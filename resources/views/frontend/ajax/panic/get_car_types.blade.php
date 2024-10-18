
<input type="hidden" value="{{ $itype }}" name="itype" id="itype" style="margin-left: 30px;">
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

        </div>
    </div>
    <div class="col-md-3">
        <div class="mt-2"
             style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;">
            <img src="{{ uploaded_asset($detail->logo) }}" alt="{{translate('Details')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $detail->name }}</span>
            <span><i class="la la-close" onclick="back_details({{ 3 }}, {{ $model_id }})"></i></span>

        </div>
    </div>
</div>
<hr>
<div class="row">
@foreach($types as $key=>$type)

    <input type="hidden" id="b_name{{$type->id}}" value="{{ $type->name }}">
    <div class="col-md-3">
        <div class="mt-2" style="border:2px solid black; display: flex; padding: 10px;margin-left: 25px;">

            <img src="{{ uploaded_asset($type->logo) }}" alt="{{translate('Brand')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $type->name }}</span>

        </div>
    </div>
@endforeach
</div>
<script>
    function back_details(key, value) {
        $(".step3").removeClass("active");

        $.ajax({
            url : "{{ url('get-p-car-details') }}",
            type: 'get',
            data: {
                key : key,
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
</script>