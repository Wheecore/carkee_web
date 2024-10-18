@foreach($brands as $key=>$brand)
    <input type="hidden"
           id="b_name"
           value="{{ $brand->name }}">
    {{--<div class="col-md-3">--}}
        {{--<div class="mt-2"--}}
             {{--style="border:1px solid black; display: flex; padding: 10px"--}}
             {{--onclick="get_models(1, {{ $brand->id }})">--}}
            {{--<img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-15px">--}}

            {{--<span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span>--}}

        {{--</div>--}}
    {{--</div>--}}
    <li onclick="get_models(1, {{ $brand->id }})" class="CarBrand" data-brand="D - 大众"><img class="img"
                                                  src="{{ uploaded_asset($brand->logo) }}"><span><font
                    style="vertical-align: inherit;"><font
                        style="vertical-align: inherit;"> {{ $brand->name }}</font></font></span>
    </li>
@endforeach
<script>
    function get_models(key, value) {
        var category = $('#select_value').val();
        $(".step" + key).addClass("active");

        $.ajax({
            url: "{{ url('get-models') }}",
            type: 'get',
            data: {
                key: key + 1,
                id: value,
                // name : name
            },
            success: function (res) {
                // $('#count_id').val(count);
                if (res === 'empty') {
                    if(category == 'Services'){
                        window.location = $(location).attr('href') + 'searching-brand-packages/' + value +'/'+ category;
                    }
                    else{
                        window.location = $(location).attr('href') + 'searching-brand-products/' + value +'/'+ category;
                    }
                }
                else {
                    $('#brand_res').html(res);
                }
            },
            error: function () {
                alert('failed...');

            }
        });
    }
</script>