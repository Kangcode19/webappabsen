@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->

                <h2 class="page-title">
                    Set Jam Kerja
                </h2>
            </div>

        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <form action="/konfigurasi/jamkerjadept/store" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_cabang" id="kode_cabang" class="form-select" required>
                                    <option value="">Pilih Cabang</option>
                                    @foreach ($cabang as $d)
                                    <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_dept" id="kode_dept" class="form-select" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departemen as $d)
                                    <option value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">


                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Senin
                                    <input type="hidden" name="hari[]" value="Senin">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Selasa
                                    <input type="hidden" name="hari[]" value="Selasa">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Rabu
                                    <input type="hidden" name="hari[]" value="Rabu">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kamis
                                    <input type="hidden" name="hari[]" value="Kamis">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Jumat
                                    <input type="hidden" name="hari[]" value="Jumat">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Sabtu
                                    <input type="hidden" name="hari[]" value="Sabtu">
                                </td>
                                <td>
                                    <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                        <option value="">Pilih Jam Kerja</option>
                                        @foreach ($jamkerja as $d)
                                        <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>


                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $d)
                            <tr>
                                <td>{{ $d->kode_jam_kerja }}</td>
                                <td>{{ $d->nama_jam_kerja }}</td>
                                <td>{{ $d->awal_jam_masuk }}</td>
                                <td>{{ $d->jam_masuk }}</td>
                                <td>{{ $d->akhir_jam_masuk }}</td>
                                <td>{{ $d->jam_pulang }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
