<div class="modal-body">

    <div class="text-center">
        <span class="avatar avatar-xxl mb-3">
            <img src="{{ uploaded_asset($merchant->avatar_original) }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
        </span>
        <h1 class="h5 mb-1">{{ $merchant->name }}</h1>
    </div>
    <hr>

    <!-- Profile Details -->
    <h6 class="mb-4">{{ translate('About') }} {{ $merchant->name }}</h6>
    <p><i class="demo-pli-map-marker-2 icon-lg icon-fw mr-1"></i>{{ $merchant->address }}</p>
    <p><i class="demo-pli-old-telephone icon-lg icon-fw mr-1"></i>{{ $merchant->phone }}</p>
    <br>
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </div>
</div>
