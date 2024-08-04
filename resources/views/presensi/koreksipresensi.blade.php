<form action="/storekoreksipresensi" method="POST" id="formKoreksipresensi">
    @csrf
    <input type="hidden" name="nik" value="{{ $karyawan->nik }}">
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <table class="table">
        <tr>
            <td>Nik</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Tanggal Presensi</td>
            <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
        </tr>
    </table>
    <div class="row mb-2">
        <div class="col-12">
            <div class="form-group">
                <select name="status" id="status" class="form-select">
                    <option value="">Pilih Status Kehadiran</option>
                    <option
                        @if ($presensi != null) @if ($presensi->status === 'h')
                                selected @endif
                        @endif
                        value="h">Hadir</option>
                    <option value="a"
                        @if ($presensi != null) @if ($presensi->status === 'a')
                        selected @endif
                        @endif>Alfa</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-2" id="frm_jam_in">
        <div class="col-12">
            <div class="input-icon">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-24" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 0 0 5.998 8.485m12.002 -8.485a9 9 0 1 0 -18 0" />
                        <path d="M12 7v5" />
                        <path d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2" />
                        <path d="M18 15v2a1 1 0 0 0 1 1h1" />
                        <path d="M21 15v6" />
                    </svg>
                </span>
                <input type="text" id="jam_in" value="{{ $presensi != null ? $presensi->jam_in : '' }}"
                    class="form-control" placeholder="Jam Masuk" name="jam_in">
            </div>
        </div>
    </div>
    <div class="row mb-2" id="frm_jam_out">
        <div class="col-12">
            <div class="input-icon">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-24" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 0 0 5.998 8.485m12.002 -8.485a9 9 0 1 0 -18 0" />
                        <path d="M12 7v5" />
                        <path d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2" />
                        <path d="M18 15v2a1 1 0 0 0 1 1h1" />
                        <path d="M21 15v6" />
                    </svg>
                </span>
                <input type="text" id="jam_out" value="{{ $presensi != null ? $presensi->jam_out : '' }}"
                    class="form-control" placeholder="Jam Pulang" name="jam_out">
            </div>
        </div>
    </div>
    <div class="row mb-2" id="frm_kode_jam_kerja">
        <div class="col-12">
            <div class="form-group">
                <select name="kode_jam_kerja" id="kode_jam_kerja" class="form-select">
                    <option value="">Pilih Jam Kerja</option>
                    @foreach ($jamkerja as $d)
                        <option
                            @if ($presensi != null) @if ($presensi->kode_jam_kerja === $d->kode_jam_kerja)
                                selected @endif
                            @endif

                            value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {

        function loadkoreksi() {
            var status = $("#status").val();
            if (status == "a") {
                $("#frm_jam_in").hide();
                $("#frm_jam_out").hide();
                $("#kode_jam_kerja").hide();
            } else {
                $("#frm_jam_in").show();
                $("#frm_jam_out").show();
                $("#kode_jam_kerja").show();
            }
        }

        loadkoreksi();

        $("#status").change(function(e) {
            loadkoreksi();
        });
        $("#formKoreksipresensi").submit(function() {

            var kode_jam_kerja = $("#kode_jam_kerja").val();
            var status = $("#status").val();
            if (status == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Status Kehadiran Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#status").focus();
                });

                return false;
            } else if (kode_jam_kerja == "" && status == "h") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Kerja Harus Diisi !',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#kode_jam_kerja").focus();
                });

                return false;
            }
        });
    });
</script>
