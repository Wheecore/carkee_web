@extends('frontend.layouts.user_panel')
@section('panel_content')

    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Update Order Date') }}</h5>
                    </div>
                    <div class="card-body">
                        <!--if difference more than 24 hours so then will charge user for reschedule-->
                        @php 
                        $diff = 0;
                        if($order->created_at){
                        $to_time = strtotime(now());
                        $from_time = strtotime($order->created_at);
                        $diff = round(abs($to_time - $from_time) / 60,2);
                        $diff = $diff/60;
                        }
                        if($diff < 24){
                        if($order->user_date_update != 0){
                         $action = route('checkout.payment_charges', $order->id);
                        }
                        if($order->user_date_update == 0){
                        $action = route('front.user.update.date', $order->id);
                        }
                        }
                        else{
                        $action = route('checkout.payment_charges', $order->id);
                        }
                        @endphp
                            <form action="{{$action}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="availability_id" id="availability_id" value="{{$order->availability_id}}">
                                        <div class="form-group mb-3">
                                            <label for="name">{{translate('Date')}}</label>
                                            <input name="wdate" id="userDate" placeholder="Select Date" class="form-control datepicker selected_date" value="{{ $order->workshop_date }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="name">{{translate('Name')}}</label>
                                            <select id="userTime" class="form-control timeslot" name="wtime">
                                                @if($order->workshop_time)
                                                    <option value="{{ $order->workshop_time }}" selected>{{ $order->workshop_time }}</option>
                                                @else
                                                    <option value="" selected>Select Time</option>
                                                @endif
                                            </select>
                                        </div>
                                        <p id="datetime-error" class="mt-2 ml-3 fs-12" style="display: none; color: red;text-align: left;"></p>
                                        <p id="time-error" class="mt-2 ml-3 fs-12" style="display: none; color: red;text-align: left;"></p>
                                        <div class="form-group mb-3 text-right">
                                            <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                                        </div>
                                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{static_asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
<script>
    $(document).on("click",".ui-datepicker-next",function(){
        var shop_id = '{{$order->seller_id}}';
        // apply border color to available dates
        applyBorderToDates(shop_id);
    });

    $(document).on("click",".ui-datepicker-prev",function(){
        var shop_id = '{{$order->seller_id}}';
        // apply border color to available dates
        applyBorderToDates(shop_id);
    });

    $('.timeslot').on('change', function() {
        $("#time-error").hide();
    });


    $(document).on('click','#userDate',function(){
        $(this).datepicker({
            minDate: new Date(new Date().getTime()+(3*24*60*60*1000)),
            onSelect: function(dateText) {
                var selected_date = dateText;
                selected_date = moment(moment(selected_date)).format("YYYY-MM-DD");
                $('#userTime').html('<option value="" selected>Select Time</option>');
                $("#datetime-error").hide();
                var shop_id = '{{$order->seller_id}}';
                showTimeOfSelectedDate(shop_id,selected_date);
            }
        }).datepicker( "show" )
        var shop_id = '{{$order->seller_id}}';
        // apply border color to available dates
        applyBorderToDates(shop_id);
    });
    function applyBorderToDates(shop_id){
        $.get('{{ route('check-timings') }}',{shop_id:shop_id}, function(data){
            if(data != 'empty'){
                var selected_year = $(".current_year").html();
                $.each(data, function (key, value) {
                    slotDate = moment(value.date).format('D');
                    slotMonth = moment(value.date).format('M');
                    slotMonth = slotMonth-1;
                    slotYear = moment(value.date).format('YYYY');
                    $('.ui-datepicker-calendar td[data-month="' +slotMonth+ '"][data-year="' + slotYear + '"]').filter(function() {
                        return $(this).children().text() === slotDate;
                    }).css("border","2px solid #6ce06c");
                });
            }
        });
    }

    function showTimeOfSelectedDate(shop_id,selected_date){
        var i;
        $.ajax({
            type:'GET',
            url:'{{route('shop.get-date-time')}}',
            data: {
                'selected_date':selected_date,
                'shop_id':shop_id},
            success:function(response){
                if(response['code'] == 200){
                    $('#availability_id').val(response['availability_id']);
                    $('#userTime').html('<option value="" selected>Select Time</option>');
                    $.each(response['time_array'] , function(index, val) {
                        $('#userTime').append('<option value="'+ moment(val).format('h:mm A') +'">'+ moment(val).format('h:mm A') +'</option>');
                    });
                    $("#userTime").focus();
                }
                else{
                    $("#datetime-error").show();
                    $("#datetime-error").html(response['message']);
                }
            }
        });
    }
</script>
@endsection


