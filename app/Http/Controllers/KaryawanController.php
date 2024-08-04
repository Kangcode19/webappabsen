<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }

        if ($user->hasRole('admin departemen')) {
            $query->where('karyawan.kode_dept', $kode_dept);
            $query->where('karyawan.kode_cabang', $kode_cabang);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('karyawan.index', compact('karyawan', 'departemen', 'cabang'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data =  [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {

            if ($e->getCode() == 23000) {
                $message = "Data dengan Nik " . $nik . " Sudah Ada";
            } else {
                $message = "Hubungi IT";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ' . $message]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan', 'cabang'));
    }

    public function update($nik, Request $request)
    {
        $nik = Crypt::decrypt($nik);
        $nik_baru = $request->nik_baru;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }


        $ceknik = DB::table('karyawan')
            ->where('nik', $nik_baru)
            ->where('nik', '!=', $nik)
            ->count();
        if ($ceknik > 0) {
            return Redirect::back()->with(['warning' => 'Nik Sudah Digunakan']);
        }
        try {
            $data =  [
                'nik' => $nik_baru,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Update']);
            }
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function resetpassword($nik)
    {
        $nik = Crypt::decrypt($nik);
        $password = Hash::make('12345');
        $reset = DB::table('karyawan')->where('nik', $nik)->update([
            'password' => $password
        ]);

        if ($reset) {
            return Redirect::back()->with(['success' => 'Data Password Berhasil di Reset']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Password Gagal di Reset']);
        }
    }

    public function lockandunlocklocation($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_location = $karyawan->status_location;
            if ($status_location == '1') {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_location' => '0'
                ]);
            } else {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_location' => '1'
                ]);
            }

            return Redirect::back()->with(['success' => 'Status Location Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Location Gagal Diupdate']);
        }
    }

    public function lockandunlockjamkerja($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_jam_kerja = $karyawan->status_jam_kerja;
            if ($status_jam_kerja == '1') {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jam_kerja' => '0'
                ]);
            } else {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jam_kerja' => '1'
                ]);
            }

            return Redirect::back()->with(['success' => 'Status Jam Kerja Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Jam Kerja Gagal Diupdate']);
        }
    }
}
