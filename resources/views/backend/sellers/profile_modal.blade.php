<div class="modal-body">
    <div class="text-center">
        <span class="avatar avatar-xxl mb-3">
            <img src="{{ uploaded_asset($seller->user->avatar_original) }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
        </span>
        <h1 class="h5 mb-1">{{ $seller->user->name }}</h1>
        <p class="text-sm text-muted">{{ $seller->user->shop->name }}</p>

        <div class="pad-ver btn-groups">
            <a href="{{ $seller->user->shop->facebook }}" class="btn btn-icon demo-pli-facebook icon-lg add-tooltip"
                data-original-title="Facebook" data-container="body"></a>
            <a href="{{ $seller->user->shop->twitter }}" class="btn btn-icon demo-pli-twitter icon-lg add-tooltip"
                data-original-title="Twitter" data-container="body"></a>
            <a href="{{ $seller->user->shop->google }}" class="btn btn-icon demo-pli-google-plus icon-lg add-tooltip"
                data-original-title="Google+" data-container="body"></a>
        </div>
    </div>
    <hr>

    <!-- Profile Details -->
    <h6 class="mb-4">{{ translate('About') }} {{ $seller->user->name }}</h6>
    <p><i class="demo-pli-map-marker-2 icon-lg icon-fw mr-1"></i>{{ $seller->user->shop->address }}</p>
    <p><i class="demo-pli-old-telephone icon-lg icon-fw mr-1"></i>{{ $seller->user->phone }}</p>

    <h6 class="mb-4">{{ translate('Payout Info') }}</h6>
    <p>{{ translate('Bank Name') }} : {{ $seller->bank_name }}</p>
    <p>{{ translate('Bank Acc Name') }} : {{ $seller->bank_acc_name }}</p>
    <p>{{ translate('Bank Acc Number') }} : {{ $seller->bank_acc_no }}</p>

    <br>

    <div class="table-responsive">
        <table class="table table-striped mar-no">
            <tbody>
                <tr>
                    <td>{{ translate('Total Orders') }}</td>
                    <td>{{ App\Models\Order::where('seller_id', $seller->user->shop->id)->count() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </div>
</div>
