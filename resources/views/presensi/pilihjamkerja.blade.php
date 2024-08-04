@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pilih Jam Kerja</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="row" style="margin-top:70px">
                <div class="col-12">
                    @foreach ($jamkerja as $d)
                        <a href="/presensi/{{ Crypt::encrypt($d->kode_jam_kerja) }}/create"
                            style="text-decoration: none; color:black">
                            <div class="card mb-1" style="border : 1px solid blue">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="finger-print-outline" style="font-size: 48px;"
                                                class="text-success"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3 style="line-height: 3px">{{ $d->nama_jam_kerja }}</h3>
                                            <span>Jam Masuk : {{ $d->jam_masuk }}</span><br>
                                            <span>Jam Pulang : {{ $d->jam_pulang }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>


            </div>
        </div>
    </div>
@endsection
