<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;

        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logotok.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="title">
                        LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT.CAHAYA RIYAL SAPUTRA<br>
                    </span>
                    <span><i>Dsn. Kertoharjo, RT.02/RW.02, Kertorejo, Kintelan, Kec. Puri, Kabupaten Mojokerto, Jawa Timur 61363</i></span>
                </td>
            </tr>
        </table>
        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="120px" height="150">
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Jml Jam</th>
            </tr>

            @foreach ($presensi as $d)
                @if ($d->status == 'h')
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                        $terlambat = hitungjamterlambat($d->jam_masuk, $d->jam_in);
                        $terlambat_desimal = hitungjamterlambatdesimal($d->jam_masuk, $d->jam_in);
                        $j_terlambat = explode(':', $terlambat);
                        $jam_terlambat = intVal($j_terlambat[0]);
                        if ($jam_terlambat < 1) {
                            $jam_mulai = $d->jam_masuk;
                        } else {
                            $jam_mulai = $d->jam_in > $d->jam_masuk ? $d->jam_in : $d->jam_masuk;
                        }
                        $jam_berakhir = $d->jam_out > $d->jam_pulang ? $d->jam_pulang : $d->jam_out;
                        $total_jam = hitungjamkerja(
                            $d->tgl_presensi,
                            date('H:i', strtotime($jam_mulai)),
                            date('H:i', strtotime($jam_berakhir)),
                            $d->total_jam,
                            $d->lintashari,
                            date('H:i', strtotime($d->awal_jam_istirahat)),
                            date('H:i', strtotime($d->akhir_jam_istirahat)),
                        );
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->jam_out != null)
                                <img src="{{ url($path_out) }}" alt="" class="foto">
                            @else
                                <img src="{{ asset('assets/img/camera.jpg') }}" alt="" class="foto">
                            @endif
                        </td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>
                            @if ($d->jam_in > $d->jam_masuk)
                                Terlambat {{ $terlambat_desimal }} Jam
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                        <td>
                            {{ $total_jam }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td colspan="2" style="text-align: right">Mojokerto, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>Achmad Zakarya</u><br>
                    <i><b>Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align:bottom">
                    <u>Dwi Harja</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
