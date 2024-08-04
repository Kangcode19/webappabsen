<ul class="action-button-list">
    <li>
        @if ($dataizin->status=="i")
        <a href="/izinabsen/{{ $dataizin->kode_izin }}/edit" class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataizin->status=="s")
        <a href="/izinsakit/{{ $dataizin->kode_izin }}/edit" class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataizin->status=="c")
        <a href="/izincuti/{{ $dataizin->kode_izin }}/edit" class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @endif

    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteConfirm">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>

<script>
    $(function() {
        $("#deletebutton").click(function(e) {
            $("#hapuspengajuan").attr('href', '/izin/' + '{{ $dataizin->kode_izin }}/delete');
        });
    });

</script>
