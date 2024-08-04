<form action="/konfigurasi/harilibur/store" method="POST" id="frmcreateHarilibur">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-barcode" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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
                <input type="text" id="kode_libur" class="form-control" placeholder="Auto" name="kode_libur"
                    disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                        <path d="M16 3v4" />
                        <path d="M8 3v4" />
                        <path d="M4 11h16" />
                        <path d="M11 15h1" />
                        <path d="M12 15v3" />
                    </svg>
                </span>
                <input type="text" id="tanggal_libur" class="form-control" placeholder="Tanggal Libur"
                    name="tanggal_libur" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <select name="kode_cabang" id="kode_cabang" class="form-select">
                    <option value="">Pilih Cabang</option>
                    @foreach ($cabang as $d)
                        <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M9 17h6" />
                        <path d="M9 13h6" />
                    </svg>
                </span>
                <input type="text" id="keterangan" autocomplete="off" class="form-control" placeholder="Keterangan"
                    name="keterangan">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 14l11 -11"></path>
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                        </path>
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
        $("#tanggal_libur").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });

        $("#frmcreateHarilibur").submit(function(e) {
            var tanggal_libur = $("#tanggal_libur").val();
            var kode_cabang = $("#kode_cabang").val();
            var keterangan = $("#keterangan").val();

            if (tanggal_libur == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Tanggal Libur Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#tanggal_libur").focus();
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
            } else if (keterangan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Keterangan Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#keterangan").focus();
                });

                return false;
            }
        });
    });
</script>
