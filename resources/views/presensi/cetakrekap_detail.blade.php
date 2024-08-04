<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>
    <style>
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
            font-size: 10px
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

<body class="A4 landscape">

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
                        REKAP PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT.RIYAL SAPUTRA GROUP<br>
                    </span>
                    <span><i>Dsn. Kertoharjo, RT.02/RW.02, Kertorejo, Kintelan, Kec. Puri, Kabupaten Mojokerto, Jawa Timur 61363</i></span>
                </td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">Nik</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                <th rowspan="2">H</th>
                <th rowspan="2">I</th>
                <th rowspan="2">S</th>
                <th rowspan="2">C</th>
                <th rowspan="2">A</th>
            </tr>
            <tr>
                @foreach ($rangetanggal as $d)
                    @if ($d != null)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endif
                @endforeach

            </tr>
            @foreach ($rekap as $r)
                <tr>
                    <td>{{ $r->nik }}</td>
                    <td>{{ $r->nama_lengkap }}</td>

                    <?php
                    $jml_hadir = 0;
                    $jml_izin = 0;
                    $jml_sakit = 0;
                    $jml_cuti = 0;
                    $jml_alpa = 0;
                    $color = "";
                    for($i=1; $i<=$jmlhari; $i++){
                        $tgl = "tgl_".$i;
                        $tgl_presensi = $rangetanggal[$i-1];
                        $search_items = [
                            'nik' => $r->nik,
                            'tanggal_libur' => $tgl_presensi
                        ];
                        $ceklibur = cekkaryawanlibur($datalibur, $search_items);

                        $datapresensi = explode("|",$r->$tgl);
                        if($r->$tgl != NULL){
                            $status = $datapresensi[2];
                            $jam_in = $datapresensi[0] != "NA" ? date("H:i",strtotime($datapresensi[0])) : 'Belum Absen';
                            $jam_out = $datapresensi[1] != "NA" ? date("H:i",strtotime($datapresensi[1])) : 'Belum Absen';
                            $jam_masuk = $datapresensi[4] != "NA" ? date("H:i",strtotime($datapresensi[4])) : '';
                            $jam_pulang = $datapresensi[5] != "NA" ? date("H:i",strtotime($datapresensi[5])) : '';
                            $nama_jam_kerja = $datapresensi[3] != "NA" ? $datapresensi[3] : '';
                            $total_jam = $datapresensi[8] != "NA" ? $datapresensi[8] : 0;
                            $lintashari = $datapresensi[9];
                            $jam_awal_istirahat = $datapresensi[10];
                            $jam_akhir_istirahat = $datapresensi[11];
                            $jam_berakhir = $jam_out > $jam_pulang ? $jam_pulang  : $jam_out;

                            $terlambat = hitungjamterlambat($jam_masuk,$jam_in);
                            $terlambat_desimal = hitungjamterlambatdesimal($jam_masuk,$jam_in);
                            $j_terlambat = explode(":",$terlambat);
                            $jam_terlambat = intVal($j_terlambat[0]);

                            if($jam_terlambat < 1){
                                $jam_mulai = $jam_masuk;
                            }else{
                                $jam_mulai = $jam_in > $jam_masuk ? $jam_in : $jam_masuk;
                            }

                            if($jam_in != "NA" && $jam_out != "NA"){
                                $total_jam_kerja = hitungjamkerja($tgl_presensi,$jam_mulai,$jam_berakhir,$total_jam,$lintashari,$jam_awal_istirahat, $jam_akhir_istirahat,$terlambat);
                            }else{
                                $total_jam_kerja = 0;
                            }

                            $denda = hitungdenda($terlambat);
                        }else{
                            $status = "";
                            $jam_in = "";
                            $jam_out = "";
                            $jam_masuk = "";
                            $jam_pulang = "";
                            $nama_jam_kerja = "";
                            $total_jam_kerja = 0;
                            $terlambat = 0;
                        }
                        //Denda
                        //Jika Terlambat < 5 Menit Maka Denda 0
                        // Jika Terlambat 5 - 9 Menit Denda 5000
                        // Jika Terlambat 10 - 14 Menit Denda 1000
                        //Jika Terlambat nya 15 - 59 Menit Dedna 15000
                        //Jika Terlambatnya Lebih dari sama dengan 1 Jam Maka di Potong Upah Perjam
                        $cekhari = gethari(date('D',strtotime($tgl_presensi)));
                        if($status == "h"){
                            $jml_hadir += 1;
                            $color = "white";
                        }

                        if($status == "i"){
                            $jml_izin += 1;
                            $color = "#ffbb00";
                        }

                        if($status == "s"){
                            $jml_sakit += 1;
                            $color = "#34a1eb";
                        }

                        if($status == "c"){
                            $jml_cuti += 1;
                            $color = "#a600ff";
                        }


                        if(empty($status) && empty($ceklibur) && $cekhari != 'Minggu'){
                            $jml_alpa += 1;
                            $color = "red";
                        }

                        if(!empty($ceklibur)){
                            $color = "green";
                        }


                        if($cekhari == "Minggu"){
                            $color = "orange";
                        }



                ?>
                    <td style="background-color: {{ $color }}">
                        @if ($status == 'h')
                            <span style="font-weight: bold">
                                {{ $nama_jam_kerja }}
                            </span>
                            <br>
                            <span style="color:green">
                                {{ $jam_masuk }} - {{ $jam_pulang }}
                            </span>
                            <br>
                            <span style="color: orange">
                                {{ $jam_in }} - {{ $jam_out }}
                            </span>
                            <br>
                            <span style="color:blue ">
                                Total Jam : {{ $total_jam_kerja }}
                            </span>
                            <br>
                            @if ($terlambat_desimal > 0)
                                <span style="color:red ">
                                    Terlambat : {{ $terlambat }} ({{ $terlambat_desimal }})
                                    <br>
                                    Denda : {{ $denda }}
                                </span>
                            @endif
                        @endif


                    </td>
                    <?php
                    }
                ?>
                    <td>{{ !empty($jml_hadir) ? $jml_hadir : '' }}</td>
                    <td>{{ !empty($jml_izin) ? $jml_izin : '' }}</td>
                    <td>{{ !empty($jml_sakit) ? $jml_sakit : '' }}</td>
                    <td>{{ !empty($jml_cuti) ? $jml_cuti : '' }}</td>
                    <td>{{ !empty($jml_alpa) ? $jml_alpa : '' }}</td>
                </tr>
            @endforeach
        </table>
        <h4>Keterangan Libur :</h4>
        <ol>
            @foreach ($harilibur as $d)
                <li>{{ date('d-m-Y', strtotime($d->tanggal_libur)) }} - {{ $d->keterangan }}</li>
            @endforeach
        </ol>
        <table width="100%" style="margin-top:100px">
            <tr>
                <td></td>
                <td style="text-align: center">Mojokerto, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>Achmad Zakarya</u><br>
                    <i><b>HRD Manager</b></i>
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
