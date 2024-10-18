@if (home_price($detailedProduct) != home_discounted_price($detailedProduct))

    <div class="row no-gutters mt-3">
        <div class="col-sm-2">
            <div class="opacity-50 my-2">{{ translate('Price') }}:</div>
        </div>
        <div class="col-sm-10">
            <div class="fs-20 opacity-60">
                <del>
                    {{ home_price($detailedProduct) }}
                </del>
            </div>
        </div>
    </div>

    <div class="row no-gutters my-2">
        <div class="col-sm-2">
            <div class="opacity-50">{{ translate('Discount Price') }}:</div>
        </div>
        <div class="col-sm-10">
            <div class="">
                <strong class="h2 fw-600 text-primary">
                    {{ home_discounted_price($detailedProduct) }}
                </strong>
            </div>
        </div>
    </div>
@else
    <div class="row no-gutters mt-3">
        <div class="col-sm-2">
            <div class="opacity-50 my-2">{{ translate('Price') }}:</div>
        </div>
        <div class="col-sm-10">
            <div class="">
                <strong class="h2 fw-600 text-primary">
                    {{ home_discounted_price($detailedProduct) }}
                </strong>
            </div>
        </div>
    </div>
@endif
