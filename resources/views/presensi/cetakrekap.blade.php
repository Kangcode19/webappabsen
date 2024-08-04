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


        body.A4.landscape .sheet {
            width: 297mm !important;
            height: auto !important;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
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
                        PT.RIYAL SAPUTRA SAPUTRA<br>
                    </span>
                    <span><i></i></span>
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
                        }else{
                            $status = "";
                        }

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

                        {{ $status }}

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
