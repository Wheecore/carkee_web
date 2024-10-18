{{-- <div class="col-md-1 mt-3"> --}}
{{-- <button style="padding: revert;" class="btn-sm btn-info" onclick="back_brands()"><<</button> --}}
{{-- </div> --}}
{{-- @foreach ($models as $key => $model) --}}

{{-- <input type="hidden" id="b_name{{$model->id}}" value="{{ $model->name }}"> --}}
{{-- <div class="col-md-3"> --}}
{{-- <span style="margin-top: -20px;background: white; cursor: pointer">   <i class="la la-close"></i></span> --}}
{{-- <div class="mt-2" style="border:2px solid black; display: flex; padding: 10px" onclick="car_details({{ $key_val }}, {{ $model->id }})"> --}}

{{-- <img src="{{ uploaded_asset($model->logo) }}" alt="{{translate('Brand')}}" class="h-15px"> --}}

{{-- <span class="ml-2" style="line-break: anywhere;"> {{ $model->name }}</span> --}}


{{-- </div> --}}
{{-- </div> --}}

{{-- @endforeach --}}
{{-- <div id="selectedBrands"> --}}
{{-- <ul class="clearfix carsel-list" id="brand_res" style="margin-left: 0px !important;"> --}}

{{-- <li class="CarBrand" data-brand="D - 大众"><img class="img" --}}
{{-- src="{{ uploaded_asset($brand->logo) }}"><span><font --}}
{{-- style="vertical-align: inherit;"><font --}}
{{-- style="vertical-align: inherit;"> {{ $brand->name }}</font></font></span> --}}
{{-- <span><i class="la la-close" onclick="back_brands()"></i></span> --}}
{{-- </li> --}}

{{-- </ul> --}}
{{-- </div> --}}
{{-- <style> --}}
{{-- .md-img{ --}}
{{-- height: auto; --}}
{{-- } --}}
{{-- .md-card{ --}}
{{-- height: 70px; --}}
{{-- } --}}
{{-- </style> --}}
<div class="row row-left">
    <div class="col-md-4 col-lg-3 col-sm-6" style="width: unset">
        <div class="mt-2 md-card card-r" style="border:3px solid black; display: flex; padding: 10px;">
            <img id="md-img" src="{{ uploaded_asset($brand->logo) }}" alt="{{ translate('Brand') }}"
                class="md-img h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span> <span><i class="la la-close"
                    onclick="back_brands()" style="cursor: pointer"></i> </span>

        </div>
    </div>
</div>

<hr>
<div class="row row-left">
    @foreach ($models as $key => $model)
        <input type="hidden" id="b_name{{ $model->id }}" value="{{ $model->name }}">
        {{-- <li onclick="car_details({{ $key_val }}, {{ $model->id }})" class="CarBrand" data-brand="D - 大众"><img class="img" --}}
        {{-- src="{{ uploaded_asset($model->logo) }}"><span><font --}}
        {{-- style="vertical-align: inherit;"><font --}}
        {{-- style="vertical-align: inherit;"> {{ $model->name }}</font></font></span> --}}
        {{-- </li> --}}
        <div class="col-md-4 col-lg-3 col-sm-6" style="width: unset">
            <div class="mt-2 md-card card-r" style="border:2px solid black; display: flex; padding: 10px;"
                onclick="car_details({{ $key_val }}, {{ $model->id }})">
                <img src="{{ uploaded_asset($model->logo) }}" alt="{{ translate('Model') }}" class="h-15px md-img">

                <span class="ml-2" style="line-break: anywhere;"> {{ $model->name }}</span>

            </div>
        </div>
    @endforeach
</div>

<script>
    function back_brands() {
        $(".step1").removeClass("active");

        $.ajax({
            url: "{{ url('get-back-brands') }}",
            type: 'get',
            data: {

            },
            success: function(res) {
                $('#brand_res').html(res);
            },
            error: function() {
                alert('failed...');

            }
        });

    }

    function car_details(key, value) {
        var name = $('#b_name' + value).val();
        var category = $('#select_value').val();
        $(".step" + key).addClass("active");
        $(".step" + key).addClass("acti");
        $('#model_id').val(value);
        $.ajax({
            url: "{{ url('get-car-details') }}",
            type: 'post',
            data: {
                _token: CSRF,
                key: key + 1,
                id: value,
                name: name
            },
            success: function(res) {
                if (res === 'empty') {
                    if (category == 'Services') {
                        window.location = $(location).attr('href') + 'searching-brand-packages/' + value +
                            '/' + category;
                    } else {
                        window.location = $(location).attr('href') + 'searching-brand-products/' + value +
                            '/' + category + '/' + 2;
                    }
                } else {
                    $('#brand_res').html(res);
                }
            },
            error: function() {
                alert('failed...');

            }
        });

    }
</script>
