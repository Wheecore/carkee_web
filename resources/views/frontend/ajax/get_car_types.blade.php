{{-- <div class="col-md-1 mt-3"> --}}
{{-- <button style="padding: revert;" class="btn-sm btn-info" onclick="back_details({{ 3 }}, {{ $model_id }})"><<</button> --}}
{{-- </div> --}}
<?php $count_v[] = 0; ?>
@if (!empty($category))
    @if ($category->getParentsNames() !== $category->name)
        @foreach ($category->getParentsNames()->reverse() as $item)
            @if ($item->parent_id == 0)
                {{--            <li class="breadcrumb-item"><a href="/{{ $item->slug }}">{{ $item->name }}</a></li> --}}
                <?php $count_v[] = $item->name; ?>
            @else
                {{-- <li class="breadcrumb-item"><a href="../{{ $item->slug }}">{{ $item->name }}</a></li> --}}

                <?php $count_v[] = $item->name; ?>
            @endif
        @endforeach
    @endif
@endif

<?php $cc = count($count_v) + 1; ?>
{{-- {{ $cc = count($count_v)+1 }} --}}
{{-- <div id="selectedBrands"> --}}
{{-- <ul class="clearfix carsel-list" id="brand_res" style="margin-left: 0px !important;"> --}}

{{-- <li class="CarBrand" data-brand="D - 大众"><img class="img" --}}
{{-- src="{{ uploaded_asset($brand->logo) }}"><span><font --}}
{{-- style="vertical-align: inherit;"><font --}}
{{-- style="vertical-align: inherit;"> {{ $brand->name }}</font></font></span> --}}
{{-- </li> --}}
{{-- <li class="CarBrand" data-brand="D - 大众"><img class="img" --}}
{{-- src="{{ uploaded_asset($model->logo) }}"><span><font --}}
{{-- style="vertical-align: inherit;"><font --}}
{{-- style="vertical-align: inherit;"> {{ $model->name }}</font></font></span> --}}
{{-- </li> --}}
{{-- <li class="CarBrand" data-brand="D - 大众"><img class="img" --}}
{{-- src="{{ uploaded_asset($detail->logo) }}"><span><font --}}
{{-- style="vertical-align: inherit;"><font --}}
{{-- style="vertical-align: inherit;"> {{ $detail->name }}</font></font></span> --}}
{{-- <span><i class="la la-close" onclick="back_details({{ 3 }}, {{ $model_id }})"></i></span> --}}
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
<input type="hidden" value="{{ $itype }}" name="itype" id="itype" style="margin-left: 30px;">
<div class="row row-left">
    <div class="col-md-4 col-lg-3 col-sm-6">
        <div class="mt-2 md-card card-r" style="border:2px solid black; display: flex; padding: 10px;">
            <img src="{{ uploaded_asset($brand->logo) }}" alt="{{ translate('Brand') }}" class="h-15px md-img">

            <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span>

        </div>
    </div>
    <div class="col-md-4 col-lg-3 col-sm-6">
        <div class="mt-2 md-card card-r" style="border:2px solid black; display: flex; padding: 10px;">
            <img src="{{ uploaded_asset($model->logo) }}" alt="{{ translate('Model') }}" class="h-15px md-img">

            <span class="ml-2" style="line-break: anywhere;"> {{ $model->name }}</span>

        </div>
    </div>
    <div class="col-md-4 col-lg-3 col-sm-6">
        <div class="mt-2 md-card card-r" style="border:2px solid black; display: flex; padding: 10px;">
            <img src="{{ uploaded_asset($detail->logo) }}" alt="{{ translate('Details') }}" class="h-15px md-img">

            <span class="ml-2" style="line-break: anywhere;"> {{ $detail->name }}</span>
            <span><i class="la la-close" onclick="back_details({{ 3 }}, {{ $model_id }})"
                    style="cursor: pointer"></i></span>

        </div>
    </div>
</div>
<hr>
<div class="row row-left">
    @foreach ($types as $key => $type)
        <input type="hidden" id="b_name{{ $type->id }}" value="{{ $type->name }}">
        <div class="col-md-4 col-lg-3 col-sm-6">
            <div class="mt-2 md-card card-r" style="border:2px solid black; display: flex; padding: 10px;"
                onclick="car_types({{ $type->parent }}, {{ $type->id }})">

                <img src="{{ uploaded_asset($type->logo) }}" alt="{{ translate('Brand') }}" class="h-15px md-img">

                <span class="ml-2" style="line-break: anywhere;"> {{ $type->name }}</span>

            </div>
        </div>
        {{-- <li onclick="car_types({{ $type->parent }}, {{ $type->id }})" class="CarBrand" data-brand="D - 大众"><img class="img" --}}
        {{-- src="{{ uploaded_asset($type->logo) }}"><span><font --}}
        {{-- style="vertical-align: inherit;"><font --}}
        {{-- style="vertical-align: inherit;"> {{ $type->name }}</font></font></span> --}}
        {{-- </li> --}}
    @endforeach
</div>
<script>
    function back_details(key, value) {
        $(".step3").removeClass("active");

        $.ajax({
            url: "{{ url('get-car-details') }}",
            type: 'post',
            data: {
                _token: CSRF,
                key: key,
                id: value
            },
            success: function(res) {

                $('#brand_res').html(res);

            },
            error: function() {
                alert('failed...');

            }
        });

    }

    function car_types(key, value) {
        var itype = $('#itype').val();
        var name = $('#b_name' + value).val();
        var category = $('#select_value').val();
        $(".step" + key).addClass("active");
        $(".step" + key).addClass("acti");

        var brand_id = $('#brand_id').val();
        var model_id = $('#model_id').val();
        var details_id = $('#details_id').val();
        var type_id = value;

        $.ajax({
            url: "{{ url('get-car-types') }}",
            type: 'post',
            data: {
                _token: CSRF,
                key: key,
                id: value,
                name: name,
                itype: itype,
                category: category,
            },
            success: function(res) {
                if (res === 'empty' || itype == 1) {
                    if (category == 'Services') {
                        window.location = $(location).attr('href') + 'searching-brand-packages/' + value +
                            '/' + category;
                    } else {
                        window.location = $(location).attr('href') + 'searching-brand-products/' + value +
                            '/' + category + '/' + 4 + '/' + brand_id + '/' + model_id + '/' + details_id;
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
