@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">E-Presensi</div>
    <div class="right"></div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection

@section('content')
<style>
    #qr-video {
        width: 100%;
    }

    #map {
        height: 200px;
    }
</style>
<div class="row" style="margin-top: 60px">
    <div class="col-12">
        <video id="qr-video"></video>
        <h4 id="cam-qr-result" class="text-center">None</h4>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <select id="cam-list" class="form-control">
                <option value="environment" selected>Environment Facing (default)</option>
                <option value="user">User Facing</option>
            </select>
        </div>
        {{-- <div class="form-group">
            <span id="cam-has-flash" style="visibility: hidden"></span>
            <button id="flash-toggle" class="btn btn-primary">📸 Flash: <span id="flash-state">off</span></button>
        </div> --}}
        <div class="form-group">
            <input type="hidden" id="latitude">
            <input type="hidden" id="longitude">
            <input type="hidden" id="lokasi">
            <input type="hidden" id="status">
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<audio id="notifikasi_in">
    <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
</audio>
<audio id="notifikasi_out">
    <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
</audio>
<audio id="radius_sound">
    <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
</audio>
@endsection
@push('myscript')

<script src="{{ asset('assets/js/lib/qr-scanner.umd.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/qr-scanner.legacy.min.js') }}"></script>
<script type="module">
    var notifikasi_in = document.getElementById('notifikasi_in');
    var notifikasi_out = document.getElementById('notifikasi_out');
    var radius_sound = document.getElementById('radius_sound');
    //import QrScanner from "../qr-scanner.min.js";
    var x = document.getElementById("demo");

    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
        var lokasi_kantor = "{{ $lok_kantor->lokasi_cabang }}";
        var lok = lokasi_kantor.split(",");
        var lat_kantor = lok[0];
        var long_kantor = lok[1];
        var radius = "{{ $lok_kantor->radius_cabang }}";
        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20
            , subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([lat_kantor, long_kantor], {
            color: 'red'
            , fillColor: '#f03'
            , fillOpacity: 0.5
            , radius: radius
        }).addTo(map);
    }

    function errorCallback() {

    }

    const video = document.getElementById('qr-video');
    const videoContainer = document.getElementById('video-container');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camList = document.getElementById('cam-list');
    const camHasFlash = document.getElementById('cam-has-flash');
    const flashToggle = document.getElementById('flash-toggle');
    const flashState = document.getElementById('flash-state');
    const camQrResult = document.getElementById('cam-qr-result');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
    const fileSelector = document.getElementById('file-selector');
    const fileQrResult = document.getElementById('file-qr-result');
    const statusResult = document.getElementById('status');



    function storeqr(qrcode){
        var lokasi = $("#lokasi").val();
        $.ajax({
            type: 'POST'
            , url: '/presensi/storeqr'
            , data: {
                _token: "{{ csrf_token() }}"
                , image: null
                , lokasi: lokasi
                ,qrcode:qrcode
            }
            , cache: false
            , success: function(respond) {
                var status = respond.split("|");
                console.log(status);
                if (status[0] == "success") {
                    if (status[2] == "in") {
                        notifikasi_in.play();
                    } else {
                        notifikasi_out.play();
                    }
                    Swal.fire({
                        title: 'Berhasil !'
                        , text: status[1]
                        , icon: 'success'
                    })
                    scanner.stop();
                    setTimeout("location.href='/dashboard'", 3000);
                } else {
                    if (status[2] == "radius") {
                        radius_sound.play();
                    }
                    Swal.fire({
                        title: 'Error !'
                        , text: status[1]
                        , icon: 'error'
                    })
                    startscanner();

                }
            }
        });
    }
    function setResult(label, result) {
        //console.log(label);
        console.log(result.data);
        label.textContent = result.data;
        // camQrResultTimestamp.textContent = new Date().toString();
        if(result.data != "No QR code found."){
            $("#status").val(1);
            if(statusResult!=1){
                storeqr(result.data);
            }
            scanner.stop();
        }
        label.style.color = 'red';
        // clearTimeout(label.highlightTimeout);
        // label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    }

    const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });

    const updateFlashAvailability = () => {
        scanner.hasFlash().then(hasFlash => {
            camHasFlash.textContent = hasFlash;
            flashToggle.style.display = hasFlash ? 'inline-block' : 'none';

        });
    };


    function startscanner(){
        scanner.start().then(() => {
        updateFlashAvailability();
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label;
            camList.add(option);
        }));
    });
    }


    // QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

    // for debugging
    window.scanner = startscanner();

    camList.addEventListener('change', event => {
        scanner.setCamera(event.target.value).then(updateFlashAvailability);
    });

    flashToggle.addEventListener('click', () => {
        scanner.toggleFlash().then(() => flashState.textContent = scanner.isFlashOn() ? 'on' : 'off');
    });
</script>
@endpush