<div class="card-header mb-2">
    <h5 class="mb-0 h6">{{ translate('Edit Your Gift Base Coupon') }}</h5>
</div>
@php
    $selected_products = json_decode($coupon->product_ids);
@endphp
<div class="form-group row">
    <label class="col-lg-3 col-from-label">{{ translate('Coupon Title') }}</label>
    <div class="col-lg-9">
        <input type="text" placeholder="{{ translate('Coupon Title') }}" value="{{ $coupon->discount_title }}"
            name="discount_title" class="form-control" required>
    </div>
</div>

<div class="product-choose-list">
    <div class="product-choose">
        <div class="form-group row">
            <label class="col-lg-3 control-label" for="name">{{ translate('Product') }}</label>
            <div class="col-lg-9">
                <select name="product_ids[]" class="form-control product_id aiz-selectpicker" data-live-search="true"
                    data-selected-text-format="count" required multiple>
                    @foreach (filter_products(\App\Models\Product::query())->get() as $key => $product)
                        <option value="{{ $product->id }}"
                            {{ in_array($product->id, $selected_products) ? 'selected' : '' }}>
                            {{ $product->getTranslation('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
@php
    $coupon_det = json_decode($coupon->details);
@endphp
<div class="form-group row">
    <label class="col-lg-3 col-from-label">{{ translate('Minimum Shopping') }}</label>
    <div class="col-lg-9">
        <input type="number" lang="en" min="0" step="0.01"
            placeholder="{{ translate('Minimum Shopping') }}" value="{{ $coupon_det->min_buy }}" name="min_buy"
            class="form-control" required>
    </div>
</div>

@php
    $start_date = date('m/d/Y', $coupon->start_date);
    $end_date = date('m/d/Y', $coupon->end_date);
@endphp
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date">{{ translate('Date') }}</label>
    <div class="col-sm-9">
        <input type="text" class="form-control aiz-date-range" value="{{ $start_date . ' - ' . $end_date }}"
            name="date_range" placeholder="Select Date">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date">{{ translate('Usage Limit') }}</label>
    <div class="col-sm-9">
        <input type="number" class="form-control" name="limit" placeholder="" value="{{ $coupon->limit }}" required>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 control-label" for="start_date">{{ translate('Discount Type') }}</label>
    <div class="col-sm-9">
        <input type="radio" id="discount" name="discount_way" value="discount"
            {{ $coupon->gift_type == 'discount' ? 'checked' : '' }}>
        <label for="discount" class="ml-1">Discount</label>
        <input type="radio" id="gift" name="discount_way" class="ml-4" value="gift"
            {{ $coupon->gift_type == 'gift' ? 'checked' : '' }}>
        <label for="gift" class="ml-1">Gift</label>
    </div>
</div>
<div class="form-group row" id="discount_div" @if ($coupon->gift_type == 'gift') style="display: none;" @endif>
    <label class="col-lg-3 col-from-label">{{ translate('Discount') }}</label>
    <div class="col-lg-7">
        <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount') }}"
            value="{{ $coupon->discount }}" name="discount" class="form-control">
    </div>
    <div class="col-lg-2">
        <select class="form-control aiz-selectpicker" name="discount_type">
            <option value="amount" @if ($coupon->discount_type == 'amount') selected @endif>{{ translate('Amount') }}</option>
            <option value="percent" @if ($coupon->discount_type == 'percent') selected @endif>{{ translate('Percent') }}
            </option>
        </select>
    </div>
</div>

@php
    $gifts = json_decode($coupon->gifts, true);
    $i = 1;
@endphp
<div id="gift_div" @if ($coupon->gift_type == 'discount') style="display: none;" @endif>
    <input type="hidden" id="total_gifts" name="total_gifts" value="{{ $gifts ? count($gifts) : 1 }}">
    @if ($gifts && count($gifts) > 0)
        @foreach ($gifts as $key => $gift)
            <div class="form-group row">
                <label class="col-sm-3 control-label" for="">{{ translate('Gift Name') }}</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="gift_name_{{ $i }}"
                        id="gift_name_{{ $i }}" value="{{ $gift }}">
                </div>
                @if ($loop->last)
                    <div class="col-sm-1">
                        <i class="las la-plus la-2x custom-plus" onclick="addMoreGifts()"></i>
                    </div>
                @endif
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="">{{ translate('Gift Image') }}</label>
                <div class="col-md-9">
                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                {{ translate('Browse') }}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="attachment_id_{{ $i }}" value="{{ $key }}"
                            class="selected-files" id="attachment_id_{{ $i }}">
                    </div>
                    <div class="file-preview box sm">
                        <div class="d-flex justify-content-between align-items-center mt-2 file-preview-item"
                            data-id="{{ $key }}">
                            <div class="align-items-center align-self-stretch d-flex justify-content-center thumb">
                                <img src="{{ uploaded_asset($key) }}" class="img-fit">
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-link remove-attachment" type="button"><i
                                        class="la la-close"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $i++;
            @endphp
        @endforeach
    @else
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="">{{ translate('Gift Name') }}</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="gift_name_1" id="gift_name_1">
            </div>
            <div class="col-sm-1">
                <i class="las la-plus la-2x custom-plus" onclick="addMoreGifts()"></i>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="">{{ translate('Gift Image') }}</label>
            <div class="col-md-9">
                <div class="input-group" data-toggle="aizuploader" data-type="image">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                            {{ translate('Browse') }}</div>
                    </div>
                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                    <input type="hidden" name="attachment_id_1" class="selected-files" id="attachment_id_1">
                </div>
                <div class="file-preview box sm">
                </div>
            </div>
        </div>
    @endif

    <div id="more_gifts"></div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.aiz-date-range').daterangepicker();
        AIZ.plugins.bootstrapSelect('refresh');
    });

    $($('input[name="discount_way"]')).change(function() {
        var check_value = $('input[name="discount_way"]:checked').val();
        if (check_value == 'gift') {
            $("#gift_div").show();
            $("#discount_div").hide();
        } else {
            $("#gift_div").hide();
            $("#discount_div").show();
        }
    });

    function addMoreGifts() {
        var count = parseInt($('#total_gifts').val());
        if ($("#gift_name_" + count).val() != '' && $("#attachment_id_" + count).val() != '') {
            var new_count = count + 1;
            $('#more_gifts').append('<div class="form-group row gift_row_' + new_count + '">' +
                '<label class="col-sm-3 control-label" for="">{{ translate('Gift Name') }}</label>' +
                '<div class="col-sm-8">' +
                '<input type="text" class="form-control" name="gift_name_' + new_count + '" id="gift_name_' +
                new_count + '">' +
                '</div>' +
                '<div class="col-sm-1">' +
                '<button class="custom_btn" type="button"><i class="las la-trash custom-delete" onclick="deleteGift(' +
                new_count + ')"></i></button>' +
                '</div>' +
                '</div>' +
                '<div class="form-group row gift_row_' + new_count + '">' +
                '<label class="col-md-3 col-form-label" for="">{{ translate('Gift Image') }}</label>' +
                '<div class="col-md-9">' +
                '<div class="input-group" data-toggle="aizuploader" data-type="image">' +
                '<div class="input-group-prepend">' +
                '<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>' +
                '</div>' +
                '<div class="form-control file-amount">{{ translate('Choose File') }}</div>' +
                '<input type="hidden" name="attachment_id_' + new_count +
                '" class="selected-files" id="attachment_id_' + new_count + '">' +
                '</div>' +
                '<div class="file-preview box sm">' +
                '</div>' +
                '</div></div>');
            $('#total_gifts').val(new_count);
        }
    }

    function deleteGift(id) {
        $('.gift_row_' + id).remove();
        var total_gifts = $('#total_gifts').val();
        var new_count = total_gifts - 1;
        $('#total_gifts').val(new_count);
    }
</script>
