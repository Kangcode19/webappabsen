@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->

                    <h2 class="page-title">
                        Data Karyawan
                    </h2>
                </div>

            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @role('administrator', 'user')
                                <div class="row">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-primary" id="btnTambahkaryawan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Tambah Data
                                        </a>
                                    </div>
                                </div>
                            @endrole
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/karyawan" method="GET">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" name="nama_karyawan" id="nama_karyawan"
                                                        class="form-control" placeholder="Nama Karyawan"
                                                        value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            @role('administrator', 'user')
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <select name="kode_dept" id="kode_dept" class="form-select">
                                                            <option value="">Departemen</option>
                                                            @foreach ($departemen as $d)
                                                                <option
                                                                    {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}
                                                                    value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <select name="kode_cabang" id="kode_cabang" class="form-select">
                                                            <option value="">Semua Cabang</option>
                                                            @foreach ($cabang as $d)
                                                                <option
                                                                    {{ Request('kode_cabang') == $d->kode_cabang ? 'selected' : '' }}
                                                                    value="{{ $d->kode_cabang }}">
                                                                    {{ strtoupper($d->nama_cabang) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endrole
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>No. HP</th>
                                                <th>Foto</th>
                                                <th>Departemen</th>
                                                <th>Cabang</th>
                                                <th>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                                        <path d="M9 4v13" />
                                                        <path d="M15 7v5.5" />
                                                        <path
                                                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                        <path d="M19 18v.01" />
                                                    </svg>
                                                </th>
                                                <th>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                                        <path d="M16 3v4" />
                                                        <path d="M8 3v4" />
                                                        <path d="M4 11h10" />
                                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                        <path d="M18 16.5v1.5l.5 .5" />
                                                    </svg>
                                                </th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $d)
                                                @php
                                                    $path = Storage::url('uploads/karyawan/' . $d->foto);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                    <td>{{ $d->nik }}</td>
                                                    <td>{{ $d->nama_lengkap }}</td>
                                                    <td>{{ $d->jabatan }}</td>
                                                    <td>{{ $d->no_hp }}</td>
                                                    <td>
                                                        @if (empty($d->foto))
                                                            <img src="{{ asset('assets/img/nophoto.png') }}"
                                                                class="avatar" alt="">
                                                        @else
                                                            <img src="{{ url($path) }}" class="avatar"
                                                                alt="">
                                                        @endif

                                                    </td>
                                                    <td>{{ $d->nama_dept }}</td>
                                                    <td>{{ $d->kode_cabang }}</td>
                                                    <td class="text-center">
                                                        @if ($d->status_location == 1)
                                                            <a href="/karyawan/{{ $d->nik }}/lockandunlocklocation">
                                                                <span class=" badge bg-danger badge-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-lock"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        @else
                                                            <a href="/karyawan/{{ $d->nik }}/lockandunlocklocation">
                                                                <span class="badge bg-success badge-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-lock-open"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                                        <path
                                                                            d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                        <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($d->status_jam_kerja == 1)
                                                            <a href="/karyawan/{{ $d->nik }}/lockandunlockjamkerja">
                                                                <span class=" badge bg-danger badge-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-lock"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        @else
                                                            <a href="/karyawan/{{ $d->nik }}/lockandunlockjamkerja">
                                                                <span class="badge bg-success badge-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-lock-open"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M5 11m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                                        <path
                                                                            d="M12 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                                        <path d="M8 11v-5a4 4 0 0 1 8 0" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div>
                                                                @role('administrator', 'user')
                                                                    <a href="#" class="edit btn btn-info btn-sm"
                                                                        nik="{{ $d->nik }}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-edit"
                                                                            width="24" height="24" viewBox="0 0 24 24"
                                                                            stroke-width="2" stroke="currentColor"
                                                                            fill="none" stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path>
                                                                            <path
                                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                            </path>
                                                                            <path
                                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                            </path>
                                                                            <path d="M16 5l3 3"></path>
                                                                        </svg>
                                                                    </a>
                                                                @endrole

                                                                <a href="/konfigurasi/{{ $d->nik }}/setjamkerja"
                                                                    class="btn btn-success btn-sm ml-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-settings"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none"></path>
                                                                        <path
                                                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                                                        </path>
                                                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                                    </svg>
                                                                </a>
                                                                <a href="/karyawan/{{ Crypt::encrypt($d->nik) }}/resetpassword"
                                                                    class="btn btn-sm btn-warning">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-key-off"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M10.17 6.159l2.316 -2.316a2.877 2.877 0 0 1 4.069 0l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.33 2.33" />
                                                                        <path
                                                                            d="M14.931 14.948a2.863 2.863 0 0 1 -1.486 -.79l-.301 -.302l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.863 2.863 0 0 1 -.794 -1.504" />
                                                                        <path d="M15 9h.01" />
                                                                        <path d="M3 3l18 18" />
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            @role('administrator', 'user')
                                                                <div>
                                                                    <form action="/karyawan/{{ $d->nik }}/delete"
                                                                        method="POST" style="margin-left:5px">
                                                                        @csrf
                                                                        <a class="btn btn-danger btn-sm delete-confirm">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="icon icon-tabler icon-tabler-trash-filled"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                                stroke="currentColor" fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
                                                                                <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"></path>
                                                                                <path
                                                                                    d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z"
                                                                                    stroke-width="0" fill="currentColor">
                                                                                </path>
                                                                                <path
                                                                                    d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z"
                                                                                    stroke-width="0" fill="currentColor">
                                                                                </path>
                                                                            </svg>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @endrole
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="modal modal-blur fade" id="modal-inputkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/karyawan/store" method="POST" id="frmKaryawan" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-barcode" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                            <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                            <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M5 11h1v2h-1z"></path>
                                            <path d="M10 11l0 2"></path>
                                            <path d="M14 11h1v2h-1z"></path>
                                            <path d="M19 11l0 2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" maxlength="5" value="" id="nik"
                                        class="form-control" placeholder="Nik" name="nik">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="nama_lengkap" value="" class="form-control"
                                        name="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-device-analytics" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path d="M7 20l10 0"></path>
                                            <path d="M9 16l0 4"></path>
                                            <path d="M15 16l0 4"></path>
                                            <path d="M8 12l3 -3l2 2l3 -3"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="jabatan" value="" class="form-control"
                                        name="jabatan" placeholder="Jabatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="text" id="no_hp" value="" class="form-control"
                                        name="no_hp" placeholder="No. HP">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <select name="kode_dept" id="kode_dept" class="form-select">
                                    <option value="">Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <select name="kode_cabang" id="kode_cabang" class="form-select">
                                    <option value="">Cabang</option>
                                    @foreach ($cabang as $d)
                                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 14l11 -11"></path>
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                            </path>
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>

            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {

            $("#nik").mask("000000000");
            $("#no_hp").mask("0000000000000");
            $("#btnTambahkaryawan").click(function() {
                $("#modal-inputkaryawan").modal("show");
            });

            $(".edit").click(function() {
                var nik = $(this).attr('nik');
                $.ajax({
                    type: 'POST',
                    url: '/karyawan/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respond) {
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-editkaryawan").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda Yakin Data Ini Mau Di Hapus ?',
                    text: "Jika Ya Maka Data Akan Terhapus Permanent",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Saja!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        // Swal.fire(
                        //     'Deleted!', 'Data Berhasil Di Hapus', 'success'
                        // )
                    }
                })
            });

            $("#frmKaryawan").submit(function() {
                var nik = $("#nik").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var jabatan = $("#jabatan").val();
                var no_hp = $("#no_hp").val();
                var kode_dept = $("#frmKaryawan").find("#kode_dept").val();
                var kode_cabang = $("#frmKaryawan").find("#kode_cabang").val();
                if (nik == "") {
                    // alert('Nik Harus Diisi');
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nik Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nik").focus();
                    });

                    return false;
                } else if (nama_lengkap == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nama_lengkap").focus();
                    });

                    return false;
                } else if (jabatan == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jabatan Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#jabatan").focus();
                    });

                    return false;
                } else if (no_hp == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'No. HP Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#no_hp").focus();
                    });

                    return false;
                } else if (kode_dept == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Departemen Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#kode_dept").focus();
                    });

                    return false;
                } else if (kode_cabang == "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Cabang Harus Diisi !',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#kode_cabang").focus();
                    });

                    return false;
                }
            });
        });
    </script>
@endpush
