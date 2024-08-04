<?php

namespace App\Http\Controllers;

use App\Models\Setjamkerja;
use App\Models\Setjamkerjadept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('konfigurasi_lokasi')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function jamkerja()
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jamkerja', compact('jam_kerja'));
    }

    public function storejamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $status_istirahat = $request->status_istirahat;
        $awal_jam_istirahat = $request->awal_jam_istirahat;
        $akhir_jam_istirahat = $request->akhir_jam_istirahat;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;
        $lintashari = $request->lintashari;

        //dd($lintashari);
        $data = [
            'kode_jam_kerja' => $kode_jam_kerja,
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'status_istirahat' => $status_istirahat,
            'awal_jam_istirahat' => $awal_jam_istirahat,
            'akhir_jam_istirahat' => $akhir_jam_istirahat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam,
            'lintashari' => $lintashari
        ];
        try {
            DB::table('jam_kerja')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }


    public function editjamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jamkerja = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->first();
        return view('konfigurasi.editjamkerja', compact('jamkerja'));
    }

    public function updatejamkerja(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;
        $total_jam = $request->total_jam;
        $lintashari = $request->lintashari;
        $status_istirahat = $request->status_istirahat;
        $awal_jam_istirahat = $request->awal_jam_istirahat;
        $akhir_jam_istirahat = $request->akhir_jam_istirahat;
        $data = [
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'status_istirahat' => $status_istirahat,
            'awal_jam_istirahat' => $awal_jam_istirahat,
            'akhir_jam_istirahat' => $akhir_jam_istirahat,
            'jam_pulang' => $jam_pulang,
            'total_jam' => $total_jam,
            'lintashari' => $lintashari
        ];
        try {
            DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->update($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function deletejamkerja($kode_jam_kerja)
    {
        $hapus = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }

    public function setjamkerja($nik)
    {
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cekjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->count();
        $bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        // dd($cekjamkerja);
        if ($cekjamkerja > 0) {
            $setjamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->get();
            return view('konfigurasi.editsetjamkerja', compact('karyawan', 'jamkerja', 'setjamkerja', 'bulan'));
        } else {
            return view('konfigurasi.setjamkerja', compact('karyawan', 'jamkerja', 'bulan'));
        }
    }


    public function storesetjamkerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }


        try {
            Setjamkerja::insert($data);
            return redirect('/karyawan')->with(['success' => 'Jam Kerja Berhasil Di Seting']);
        } catch (\Exception $e) {
            return redirect('/karyawan')->with(['warning' => 'Jam Kerja Gagal Di Seting']);
            // dd($e);
        }
    }



    public function updatesetjamkerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }

        DB::beginTransaction();
        try {
            DB::table('konfigurasi_jamkerja')->where('nik', $nik)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/karyawan')->with(['success' => 'Jam Kerja Berhasil Di Seting']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/karyawan')->with(['warning' => 'Jam Kerja Gagal Di Seting']);
            // dd($e);
        }
    }

    public function jamkerjadept()
    {

        $jamkerjadept = DB::table('konfigurasi_jk_dept')
            ->join('cabang', 'konfigurasi_jk_dept.kode_cabang', '=', 'cabang.kode_cabang')
            ->join('departemen', 'konfigurasi_jk_dept.kode_dept', '=', 'departemen.kode_dept')
            ->get();
        return view('konfigurasi.jamkerjadept', compact('jamkerjadept'));
    }


    public function createjamkerjadept()
    {
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departemen')->get();
        return view('konfigurasi.createjamkerjadept', compact('jamkerja', 'cabang', 'departemen'));
    }


    public function storejamkerjadept(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;
        $kode_jk_dept = "J" . $kode_cabang . $kode_dept;

        DB::beginTransaction();
        try {
            //Menyimpan Data ke Table Konfigurasi_jk_dept
            DB::table('konfigurasi_jk_dept')->insert([
                'kode_jk_dept' => $kode_jk_dept,
                'kode_cabang' => $kode_cabang,
                'kode_dept' => $kode_dept
            ]);

            for ($i = 0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept' => $kode_jk_dept,
                    'hari' => $hari[$i],
                    'kode_jam_kerja' => $kode_jam_kerja[$i]
                ];
            }
            Setjamkerjadept::insert($data);
            DB::commit();
            return redirect('/konfigurasi/jamkerjadept')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/konfigurasi/jamkerjadept')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }


    public function editjamkerjadept($kode_jk_dept)
    {

        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departemen')->get();
        $jamkerjadept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
        $jamkerjadept_detail = DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->get();
        return view('konfigurasi.editjamkerjadept', compact('jamkerja', 'cabang', 'departemen', 'jamkerjadept', 'jamkerjadept_detail'));
    }


    public function updatejamkerjadept($kode_jk_dept, Request $request)
    {

        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        DB::beginTransaction();
        try {

            //Hapus Data Jam kerja Sebelumnya
            DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->delete();

            for ($i = 0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept' => $kode_jk_dept,
                    'hari' => $hari[$i],
                    'kode_jam_kerja' => $kode_jam_kerja[$i]
                ];
            }
            Setjamkerjadept::insert($data);
            DB::commit();
            return redirect('/konfigurasi/jamkerjadept')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/konfigurasi/jamkerjadept')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }


    public function showjamkerjadept($kode_jk_dept)
    {
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departemen')->get();
        $jamkerjadept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
        $jamkerjadept_detail = DB::table('konfigurasi_jk_dept_detail')
            ->join('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('kode_jk_dept', $kode_jk_dept)->get();
        return view('konfigurasi.showjamkerjadept', compact('jamkerja', 'cabang', 'departemen', 'jamkerjadept', 'jamkerjadept_detail'));
    }


    public function deletejamkerjadept($kode_jk_dept)
    {
        try {
            DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function storesetjamkerjabydate(Request $request)
    {
        $nik = $request->nik;
        $tanggal = $request->tanggal;
        $kode_jam_kerja = $request->kode_jam_kerja;

        $data = [
            'nik' => $nik,
            'tanggal' => $tanggal,
            'kode_jam_kerja' => $kode_jam_kerja
        ];


        try {
            DB::table('konfigurasi_jamkerja_by_date')->insert($data);
            return 0;
        } catch (\Exception $e) {
            return 1;
            // dd($e);
        }
    }


    public function getjamkerjabydate($nik, $bulan, $tahun)
    {


        $konfigurasijamkerjabydate = DB::table('konfigurasi_jamkerja_by_date')
            ->join('jam_kerja', 'konfigurasi_jamkerja_by_date.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal)="' . $tahun . '"')
            ->get();
        return view('konfigurasi.getjamkerjabydate', compact('konfigurasijamkerjabydate', 'nik'));
    }


    public function deletejamkerjabydate(Request $request)
    {
        $nik = $request->nik;
        $tanggal = $request->tanggal;

        try {
            DB::table('konfigurasi_jamkerja_by_date')->where('nik', $nik)->where('tanggal', $tanggal)->delete();
            return 0;
        } catch (\Exception $e) {
            return 1;
        }
    }
}
