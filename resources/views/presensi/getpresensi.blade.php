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
@foreach ($presensi as $d)
    @php
        $foto_in = Storage::url('uploads/absensi/' . $d->foto_in);
        $foto_out = Storage::url('uploads/absensi/' . $d->foto_out);
    @endphp
    @if ($d->status == 'h')
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->kode_cabang }}</td>
            <td>{{ $d->kode_dept }}</td>
            <td>
                {{ $d->nama_jam_kerja }} ({{ $d->jam_masuk }} s/d {{ $d->jam_pulang }})
            </td>
            <td>{{ $d->jam_in }}</td>
            <td>
                @if ($d->foto_in != null)
                    <img src="{{ url($foto_in) }}" class="avatar" alt="">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-cancel"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 8h.01" />
                        <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" />
                        <path d="M14 14l1 -1c.616 -.593 1.328 -.792 2.008 -.598" />
                        <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M17 21l4 -4" />
                    </svg>
                @endif
            </td>
            <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">Belum Absen</span>' !!}</td>
            <td>
                @if ($d->foto_out != null)
                    <img src="{{ url($foto_out) }}" class="avatar" alt="">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo-cancel"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 8h.01" />
                        <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" />
                        <path d="M14 14l1 -1c.616 -.593 1.328 -.792 2.008 -.598" />
                        <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        <path d="M17 21l4 -4" />
                    </svg>
                @endif

            </td>
            <td>{{ $d->status }}</td>
            <td>
                @if ($d->jam_in >= $d->jam_masuk)
                    @php
                        $jamterlambat = selisih($d->jam_masuk, $d->jam_in);
                    @endphp
                    <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
                @else
                    <span class="badge bg-success">Tepat Waktu</span>
                @endif
            </td>
            <td>
                @if ($d->lokasi_in != null)
                    <a href="#" class="btn btn-primary btn-sm tampilkanpeta" id="{{ $d->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l0 .01"></path>
                            <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5"></path>
                            <path d="M10.5 4.75l-1.5 -.75l-6 3l0 13l6 -3l6 3l6 -3l0 -2"></path>
                            <path d="M9 4l0 13"></path>
                            <path d="M15 15l0 5"></path>
                        </svg>
                    </a>
                @endif

                <a href="#" class="btn btn-success btn-sm koreksipresensi" nik="{{ $d->nik }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
                        <path d="M16 5l3 3" />
                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" />
                    </svg>
                </a>
            </td>
        </tr>
    @else
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->kode_cabang }}</td>
            <td>{{ $d->kode_dept }}</td>
            <td>
                <span class="badge bg-danger">Belum Absen</span>
            </td>
            <td>
                <span class="badge bg-danger">Belum Absen</span>
            </td>
            <td>
                <span class="badge bg-danger">Belum Absen</span>
            </td>
            <td>
                <span class="badge bg-danger">Belum Absen</span>
            </td>
            <td>
                <span class="badge bg-danger">Belum Absen</span>
            </td>
            <td>
                @if ($d->status == 'i')
                    <span class="badge bg-warning">I</span>
                @elseif($d->status == 's')
                    <span class="badge bg-info">S</span>
                @elseif($d->status == 'a')
                    <span class="badge bg-danger">A</span>
                @elseif($d->status == 'c')
                    <span class="badge" style="background-color: #a600ff">C</span>
                @endif
            </td>
            <td>{{ $d->keterangan }}</td>
            <td>
                <a href="#" class="btn btn-success btn-sm koreksipresensi" nik="{{ $d->nik }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
                        <path d="M16 5l3 3" />
                        <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" />
                    </svg>
                </a>
            </td>

        </tr>
    @endif
@endforeach

<script>
    $(function() {
        $(".tampilkanpeta").click(function(e) {
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond) {
                    $("#loadmap").html(respond);
                }
            });
            $("#modal-tampilkanpeta").modal("show");
        });

        $(".koreksipresensi").click(function(e) {
            var nik = $(this).attr("nik");
            var tanggal = "{{ $tanggal }}";


            $.ajax({
                type: 'POST',
                url: '/koreksipresensi',
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond) {
                    $("#loadkoreksipresensi").html(respond);
                }
            });
            $("#modal-koreksipresensi").modal("show");
        });
    });
</script>
