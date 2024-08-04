<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzincutiController extends Controller
{
    public function create()
    {
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('izincuti.create', compact('mastercuti'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $kode_cuti = $request->kode_cuti;
        $status = "c";
        $keterangan = $request->keterangan;

        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y", strtotime($tgl_izin_dari));
        // dd($tahun);
        $thn = substr($tahun, 2, 2);
        $lastizin = DB::table('pengajuan_izin')
            ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
            ->orderBy('kode_izin', 'desc')
            ->first();
        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : "";
        $format = "IZ" . $bulan . $thn;
        $kode_izin = buatkode($lastkodeizin, $format, 3);



        //Hitung Jumlah Hari Yang Di Ajukan

        $jmlhari = hitunghari($tgl_izin_dari, $tgl_izin_sampai);
        //Cek Jumlah Maksimal Cuti
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();

        $jmlmaxcuti = $cuti->jml_hari;

        //Cek Jml Cuti Yang Sudah Digunakan Pada Tahun Aktif
        $cutidigunakan = DB::table('presensi')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('status', 'c')
            ->where('nik', $nik)
            ->count();

        //Sisa Cuti

        $sisacuti = $jmlmaxcuti - $cutidigunakan;




        //dd($kode_izin);
        $data = [
            'kode_izin' => $kode_izin,
            'nik' => $nik,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'kode_cuti' => $kode_cuti,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        //Cek Sudah Absen / Belum

        $cekpresensi = DB::table('presensi')
            ->whereBetween('tgl_presensi', [$tgl_izin_dari, $tgl_izin_sampai])
            ->where('nik', $nik);
        //Cek Sudah Di Ajukan / Belum
        $cekpengajuan = DB::table('pengajuan_izin')
            ->where('nik', $nik)
            ->whereRaw('"' . $tgl_izin_dari . '" BETWEEN tgl_izin_dari AND tgl_izin_sampai');



        $datapresensi = $cekpresensi->get();

        if ($jmlhari > $sisacuti) {
            return redirect('/presensi/izin')->with(['error' => 'Jumlah Hari Melebihi Batas Maksimal Jumlah Hari Cuti dalam 1 Tahun, Sisa Cuti Anda adalah ' . $sisacuti . 'Hari']);
        } else if ($cekpresensi->count() > 0) {
            $blacklistdate = "";
            foreach ($datapresensi as $d) {
                $blacklistdate .= date('d-m-Y', strtotime($d->tgl_presensi)) . ",";
            }
            return redirect('/presensi/izin')->with(['error' => 'Tidak Bisa Melakukan Pengajuan Pada Tanggal ' . $blacklistdate . 'Karena Ada tanggal yang sudah digunkan / sudah melakukan Presensi, Silahkan Ganti Periode Tanggal Pengajuan']);
        } else if ($cekpengajuan->count() > 0) {
            return redirect('/presensi/izin')->with(['error' => 'Tidak Bisa Melakukan Pengajuan Pada Tanggal Tersebut Karena Ada tanggal yang sudah digunakan Sebelumnya !']);
        } else {
            $simpan = DB::table('pengajuan_izin')->insert($data);

            if ($simpan) {
                return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan']);
            }
        }
    }

    public function edit($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('izincuti.edit', compact('mastercuti', 'dataizin'));
    }


    public function update($kode_izin, Request $request)
    {
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $kode_cuti = $request->kode_cuti;
        try {
            //code...
            $data = [
                'tgl_izin_dari' => $tgl_izin_dari,
                'tgl_izin_sampai' => $tgl_izin_sampai,
                'kode_cuti' => $kode_cuti,
                'keterangan' => $keterangan
            ];

            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update($data);
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    public function getmaxcuti(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_cuti = $request->kode_cuti;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tahun_cuti = date('Y', strtotime($tgl_izin_dari));
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();

        if ($kode_cuti == "C01") {
            $cuti_digunakan = DB::table('presensi')
                ->join('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
                ->where('presensi.status', 'c')
                ->where('kode_cuti', 'C01')
                ->whereRaw('YEAR(tgl_presensi)="' . $tahun_cuti . '"')
                ->where('presensi.nik', $nik)
                ->count();
            $max_cuti = $cuti->jml_hari - $cuti_digunakan;
        } else {
            $max_cuti = $cuti->jml_hari;
        }

        return $max_cuti;
    }
}
