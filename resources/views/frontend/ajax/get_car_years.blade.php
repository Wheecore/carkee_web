
@foreach($years as $key=>$year)

    <input type="hidden" id="b_name{{$year->id}}" value="{{ $year->name }}">
    <div class="col-md-3">
        <div class="mt-2" style="border:1px solid black; display: flex; padding: 10px" onclick="car_types({{ $key_val }}, {{ $year->id }})">

            <img src="{{ uploaded_asset($year->logo) }}" alt="{{translate('Brand')}}" class="h-15px">

            <span class="ml-2" style="line-break: anywhere;"> {{ $year->name }}</span>

        </div>
    </div>

@endforeach

<script>
    function car_types(key, value) {
// var i=0;
        var name = $('#b_name'+value).val();
        // alert(name)
        // var count_value = $('#count_id').val();

        $(".step"+key).addClass("active");

        $.ajax({
            url : "{{ url('get-car-types') }}",
            type: 'post',
            data: {
                _token: CSRF,
                key : key+1,
                id : value,
                name : name
            },
            success: function(res)
            {
                if(res === 'empty'){
                    window.location = $(location).attr('href')+'searching-brand-products/'+value;
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