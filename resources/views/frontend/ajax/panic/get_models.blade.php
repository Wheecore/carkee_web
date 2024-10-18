
<div class="row">
    <div class="col-md-3">
        <div class="mt-2"
             style="border:3px solid black; display: flex; padding: 10px;margin-left: 25px;">
            <img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span> <span><i class="la la-close" onclick="back_brands()" style="cursor: pointer"></i> </span>

        </div>
    </div>
</div>

<hr>
<div class="row">
@foreach($models as $key=>$model)
    <input type="hidden" id="b_name{{$model->id}}" value="{{ $model->name }}">
    <div class="col-md-3">
        <div class="mt-2"
             style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;"
             onclick="car_details({{ $key_val }}, {{ $model->id }})">
            <img src="{{ uploaded_asset($model->logo) }}" alt="{{translate('Model')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $model->name }}</span>

        </div>
    </div>
@endforeach
</div>

<script>
    function back_brands() {
        $(".step1").removeClass("active");

        $.ajax({
            url : "{{ url('get-back-brands') }}",
            type: 'get',
            data: {

            },
            success: function(res)
            {
                window.location = $(location).attr('href') + '/';
            },
            error: function()
            {
                alert('failed...');

            }
        });

    }
    function car_details(key, value) {
        var name = $('#b_name'+value).val();
        var category = $('#select_value').val();
        $(".step"+key).addClass("active");
        $(".step" + key).addClass("acti");

        $.ajax({
            url : "{{ url('get-p-car-details') }}",
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
                        window.location = $(location).attr('href') + 'searching-brand-products/' + value + '/' + category + '/' + 2;
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