
<div class="row">
    <div class="col-md-3">
        <div class="mt-2"
             style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;">
            <img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span>

        </div>
    </div>
    <div class="col-md-3">
        <div class="mt-2"
             style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;">
            <img src="{{ uploaded_asset($model->logo) }}" alt="{{translate('Model')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $model->name }}</span>
            <span><i class="la la-close" onclick="back_models({{ 2 }}, {{ $brand_id }})"  style="cursor: pointer"></i></span>

        </div>
    </div>
</div>
<hr>
<div class="row">
@foreach($details as $key=>$detail)

    <input type="hidden" id="b_name{{$detail->id}}" value="{{ $detail->name }}">
    <div class="col-md-3">
        <div class="mt-2" style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;" onclick="car_types({{ $key_val }}, {{ $detail->id }})">

            <img src="{{ uploaded_asset($detail->logo) }}" alt="{{translate('Brand')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $detail->name }}</span>

        </div>
    </div>

@endforeach
</div>
<script>
    function back_models(key,value) {
        $(".step2").removeClass("active");

        $.ajax({
            url: "{{ url('get-p-models') }}",
            type: 'get',
            data: {
                key: key,
                id : value
            },
            success: function(res)
            {

                $('#brand_res').html(res);

            },
            error: function()
            {
                alert('failed...');

            }
        });

    }
    function car_types(key, value) {
        var name = $('#b_name'+value).val();
        var category = $('#select_value').val();
        $(".step"+key).addClass("active");
        $(".step" + key).addClass("acti");

        $.ajax({
            url : "{{ url('get-p-car-types') }}",
            type: 'get',
            data: {
                key : key+1,
                id : value,
                name : name
            },
            success: function(res)
            {
                if(res === 'empty'){
                    if(category == 'Services'){
                        window.location = $(location).attr('href') + 'searching-brand-packages/' + value +'/'+ category;
                    }
                    else {
                        window.location = $(location).attr('href') + 'searching-brand-products/' + value + '/' + category + '/' + 3;
                    }
                }
                else{
                    $('#brand_res').html(res);
                }
            },
            error: function()
            {
                alert('failed...');

            }
        });
    }
</script>