<form action="/cuti/{{ $cuti->kode_cuti }}/update" method="POST" id="frmCuti">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                <input type="text" value="{{ $cuti->kode_cuti }}" id="kode_cuti" readonly class="form-control" placeholder="Kode Cuti" name="kode_cuti">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </span>
                <input type="text" id="nama_cuti" value="{{ $cuti->nama_cuti }}" class="form-control" name="nama_cuti" placeholder="Nama Cuti">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                    </svg>
                </span>
                <input type="text" id="jml_hari" value="{{ $cuti->jml_hari }}" class="form-control" name="jml_hari" placeholder="Jumlah Hari">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 14l11 -11"></path>
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5"></path>
                    </svg>
                    Update
                </button>
            </div>
        </div>
    </div>
</form>
