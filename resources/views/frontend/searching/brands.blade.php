<style>
    .md-img{
        height: auto;
    }
    .md-card{
        height: 70px;
    }
</style>
<div class="row">
@foreach($brands as $key=>$brand)

    <input type="hidden" id="b_name{{$brand->id}}" value="{{ $brand->name }}">
    <div class="col-md-3">
        <div class="mt-2 md-card card-r"
             style="border:3px solid black; display: flex; padding: 10px;margin-left: 25px;" onclick="chk({{ $brand->parent }}, {{ $brand->id }})">

            <img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-15px md-img">

            <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span>

        </div>
    </div>

    {{--<li onclick="chk({{ $brand->parent }}, {{ $brand->id }})" class="CarBrand" data-brand="D - 大众"><img class="img"--}}
                                                                                                        {{--src="{{ uploaded_asset($brand->logo) }}"><span><font--}}
                    {{--style="vertical-align: inherit;"><font--}}
                        {{--style="vertical-align: inherit;"> {{ $brand->name }}</font></font></span>--}}
    {{--</li>--}}
@endforeach
</div>
<script>
    function chk(key, value) {
        var name = $('#b_name'+value).val();
        var category = $('#select_value').val();
        var brand_id = $('#brand_id').val();
        var model_id = $('#model_id').val();
        var details_id = $('#details_id').val();
        var type_id = value;
        if(key == 1){
            $(".step"+key).addClass("active");
            $(".step"+key).addClass("acti");
        }
        else if(key == 2){

            // $(".step"+1).addClass("active");
            // $(".step"+2).addClass("active");
            $(".step"+1).addClass("acti");
            $(".step"+2).addClass("acti");
        }
        else if(key == 3){

            // $(".step"+1).addClass("active");
            // $(".step"+2).addClass("active");
            // $(".step"+3).addClass("active");

            $(".step"+1).addClass("acti");
            $(".step"+2).addClass("acti");
            $(".step"+3).addClass("acti");
        }
        else{

            // $(".step"+1).addClass("active");
            // $(".step"+2).addClass("active");
            // $(".step"+3).addClass("active");
            // $(".step"+4).addClass("active")

            $(".step"+1).addClass("acti");
            $(".step"+2).addClass("acti");
            $(".step"+3).addClass("acti");
            $(".step"+4).addClass("acti");
        }


        $.ajax({
            url : "{{ url('get-subchlid-brand') }}",
            type: 'get',
            data: {
                key : key,
                id : value,
                name : name
            },
            success: function(res)
            {
                if(res === 'empty'){
                    window.location = $(location).attr('href') + 'searching-brand-products/' + value + '/' + category + '/' + 4 + '/' + brand_id + '/' + model_id + '/' + details_id;
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