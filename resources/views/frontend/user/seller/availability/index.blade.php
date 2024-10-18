@extends('frontend.layouts.user_panel')
@section('panel_content')
    <link href="{{static_asset('assets/css/bootstrap-year-calendar.min.css')}}" rel="stylesheet">
    <style>
     .accordion .accordion-item.active {
       box-shadow: none; 
      }
        @media screen and (min-width: 767px) {
            .calendar .month-container {
                width: 33%;
                display: inline-block;
                margin-bottom: 13px;
            }
            .custom_margin{
                margin-right: -280px;
            }
        }
        @media screen and (max-width: 766px) {
            .calendar .month-container {
                width: 100%;
                display: inline-block;
                margin-bottom: 16px;
            }
            .calendar .calendar-header table th {
                font-size: 18px;
                padding: 5px 0px;
            }
        }
        .calendar table.month th.month-title {
            font-size: 13px !important;
            color: red;
        }
        .custom-padding{
            padding-top: 37px;
        }
        .month-title{
            cursor: pointer;
        }
        .background-color{
            background: rgba(0, 0, 0, .2) !important;
        }
        html, body{
           width: 100%;
           overflow-x: hidden;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">{{ translate('Your Availability Schedule') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <p><strong>Opps Something went wrong</strong></p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form id="schedule_form" action="{{route('workshop.availability.store')}}" method="Post">
                            @csrf
                            <input type="hidden" name="selected_year" id="current-year" value="">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Monday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="monday_start_time" name="monday_start_time" value="{{old('monday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="monday_end_time" name="monday_end_time" value="{{old('monday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Tuesday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="tuesday_start_time" name="tuesday_start_time" value="{{old('tuesday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="tuesday_end_time" name="tuesday_end_time" value="{{old('tuesday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Wednesday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="wednesday_start_time" name="wednesday_start_time" value="{{old('wednesday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="wednesday_end_time" name="wednesday_end_time" value="{{old('wednesday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Thursday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="thursday_start_time" name="thursday_start_time" value="{{old('thursday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="thursday_end_time" name="thursday_end_time" value="{{old('thursday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Friday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="friday_start_time" name="friday_start_time" value="{{old('friday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="friday_end_time" name="friday_end_time" value="{{old('friday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Saturday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="saturday_start_time" name="saturday_start_time" value="{{old('saturday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="saturday_end_time" name="saturday_end_time" value="{{old('saturday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4 custom_margin">
                                        <div class="col-md-2 font-weight-bold custom-padding">Sunday</div>
                                        <div class="col-md-3">
                                            <label>{{ translate('Start Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="sunday_start_time" name="sunday_start_time" value="{{old('sunday_start_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ translate('End Time') }}</label>
                                            <div class="input-group">
                                                <input type="time" id="sunday_end_time" name="sunday_end_time" value="{{old('sunday_end_time')}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                 <div class="accordion" id="accordionExample">
                                  <div class="accordion-item">
                                    <h2 class="h-20px" id="headingOne">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <strong style="color:#f37021">Insertion: </strong>
                                      </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <p>Select a month by clicking checkbox for which you want to save availability or click on any single date for which you want to save availablity and then set time for that day and then just click submit button.
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="accordion-item">
                                    <h2 class="h-20px" id="headingTwo">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                       <strong style="color:#f37021">Check Timings: </strong>
                                      </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <p>If you want to see whole month time so just click on month name and you will see that month timings in the upper input types for each specific day if it is set, and if you want to check the timings of single day so just single click on that date in the calender and you will see the timings in the above input types.
                                        </p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="accordion-item">
                                    <h2 class="h-20px" id="headingThree">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                       <strong style="color:#f37021">Updation: </strong>
                                      </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <p>The month which is already saved the availability will be automatically checked so you can click on month name
                                         to see the days for which availability is set so you will see the timings and then you can update any day but for updation it is necessary that that month will not be the current or next current month, and similar for date as well.
                                         </p>
                                      </div>
                                    </div>
                                  </div>
                                   <div class="accordion-item">
                                    <h2 class="h-20px" id="headingFour">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                       <strong style="color:#f37021">Note: </strong>
                                      </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <p>Green border colors on dates means that these dates are set the availability.</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>
                            </div>
                            <input type="hidden" name="single_date" id="single_date" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div data-provide="calendar"></div>
                                </div>
                            </div>
                            <center><button class="btn btn-primary" type="submit">{{translate('Submit')}}</button></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{static_asset('assets/js/bootstrap-year-calendar.min.js')}}"></script>
    <script type="text/javascript">

        $("#schedule_form").submit(function(){
            $("#current-year").val($(".current_year").html());
            var monday_st_time = $("#monday_start_time").val();
            var monday_en_time = $("#monday_end_time").val();
            var tuesday_st_time = $("#tuesday_start_time").val();
            var tuesday_en_time = $("#tuesday_end_time").val();
            var wed_st_time = $("#wednesday_start_time").val();
            var wed_en_time = $("#wednesday_end_time").val();
            var thursday_st_time = $("#thursday_start_time").val();
            var thursday_en_time = $("#thursday_end_time").val();
            var friday_st_time = $("#friday_start_time").val();
            var friday_en_time = $("#friday_end_time").val();
            var sat_st_time = $("#saturday_start_time").val();
            var sat_en_time = $("#saturday_end_time").val();
            var sun_st_time = $("#sunday_start_time").val();
            var sun_en_time = $("#sunday_end_time").val();
            // if((monday_st_time == '' || monday_en_time == '') && (tuesday_st_time == '' || tuesday_en_time == '') && (wed_st_time == '' || wed_en_time == '') &&
            //     (thursday_st_time == '' || thursday_en_time == '') && (friday_st_time == '' || friday_en_time == '') &&
            //     (sat_st_time == '' || sat_en_time == '') && (sun_st_time == '' || sun_en_time == '')){
            //     alert('Please fill one of the day start and end time.');
            //     return false;
            // }
            if((monday_st_time == '' && monday_en_time != '') || (monday_st_time != '' && monday_en_time == '')){
                alert('Please complete the monday start and end time pair.');
                return false;
            }
            else if((tuesday_st_time == '' && tuesday_en_time != '') || (tuesday_st_time != '' && tuesday_en_time == '')){
                alert('Please complete the tuesday start and end time pair.');
                return false;
            }
            else if((wed_st_time == '' && wed_en_time != '') || (wed_st_time != '' && wed_en_time == '')){
                alert('Please complete the wednesday start and end time pair.');
                return false;
            }
            else if((thursday_st_time == '' && thursday_en_time != '') || (thursday_st_time != '' && thursday_en_time == '')){
                alert('Please complete the thursday start and end time pair.');
                return false;
            }
            else if((friday_st_time == '' && friday_en_time != '') || (friday_st_time != '' && friday_en_time == '')){
                alert('Please complete the friday start and end time pair.');
                return false;
            }
            else if((sat_st_time == '' && sat_en_time != '') || (sat_st_time != '' && sat_en_time == '')){
                alert('Please complete the saturday start and end time pair.');
                return false;
            }
            else if((sun_st_time == '' && sun_en_time != '') || (sun_st_time != '' && sun_en_time == '')){
                alert('Please complete the sunday start and end time pair.');
                return false;
            }
           return true;
        });

        $(document).ready(function(){
            backgroundChange();
            fetchAllSelectedDates();
            @if(count($timings) > 0)
            @foreach($timings as $timing)
                // var month_name = '{{date("F",strtotime($timing->date))}}';
                // $("input[value='" + month_name + "']").prop('checked', true);
            @endforeach
            @endif
        });

        $(document).on("click",".year-title", function(){
            var year = $(this).html();
            getYearTiming(year);
        });

        function getYearTiming(year){
            $.get('{{ route('get.select_year-timings') }}',{year:year}, function(data){
                $("#monday_start_time").val('');
                $("#monday_end_time").val('');
                $("#tuesday_start_time").val('');
                $("#tuesday_end_time").val('');
                $("#wednesday_start_time").val('');
                $("#wednesday_end_time").val('');
                $("#thursday_start_time").val('');
                $("#thursday_end_time").val('');
                $("#friday_start_time").val('');
                $("#friday_end_time").val('');
                $("#saturday_start_time").val('');
                $("#saturday_end_time").val('');
                $("#sunday_start_time").val('');
                $("#sunday_end_time").val('');
                // $('input[type=checkbox]').attr('checked',false);
                if(data.length != 0) {
                    $.each(data, function(key,value) {
                        const monthNames = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        // const date = new Date(value.date);
                        // var month_name = monthNames[date.getMonth()];
                        // $("input[value='" + month_name + "']").prop('checked', true);
                    });
                }
            });
             backgroundChange();
             fetchAllSelectedDates();
        }

        $(document).on('click','.month-title', function(){
            var month = $(this).html();
            $(".month-title").css("color","red");
            $(this).css("color","#005CC8");
            var year = $(".current_year").html();
            $.get('{{ route('get.select_month-timing') }}',{month:month,year:year}, function(data){
                $("#monday_start_time").val('');
                $("#monday_end_time").val('');
                $("#tuesday_start_time").val('');
                $("#tuesday_end_time").val('');
                $("#wednesday_start_time").val('');
                $("#wednesday_end_time").val('');
                $("#thursday_start_time").val('');
                $("#thursday_end_time").val('');
                $("#friday_start_time").val('');
                $("#friday_end_time").val('');
                $("#saturday_start_time").val('');
                $("#saturday_end_time").val('');
                $("#sunday_start_time").val('');
                $("#sunday_end_time").val('');
                if(data.length != 0){
                  $.each(data, function(key,value){
                      var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                      var date = new Date(value.date);
                      var dayName = days[date.getDay()];
                     if(dayName == 'Monday'){
                         $("#monday_start_time").val(value.from_time);
                         $("#monday_end_time").val(value.to_time);
                     }
                      if(dayName == 'Tuesday'){
                          $("#tuesday_start_time").val(value.from_time);
                          $("#tuesday_end_time").val(value.to_time);
                      }
                      if(dayName == 'Wednesday'){
                          $("#wednesday_start_time").val(value.from_time);
                          $("#wednesday_end_time").val(value.to_time);
                      }
                      if(dayName == 'Thursday'){
                          $("#thursday_start_time").val(value.from_time);
                          $("#thursday_end_time").val(value.to_time);
                      }
                      if(dayName == 'Friday'){
                          $("#friday_start_time").val(value.from_time);
                          $("#friday_end_time").val(value.to_time);
                      }
                      if(dayName == 'Saturday'){
                          $("#saturday_start_time").val(value.from_time);
                          $("#saturday_end_time").val(value.to_time);
                      }
                      if(dayName == 'Sunday'){
                          $("#sunday_start_time").val(value.from_time);
                          $("#sunday_end_time").val(value.to_time);
                      }
                  });
                }
            });
        });

        function fetchAvailability(element, date){
                var formated_date = formatDate(date);
                if(element.children().hasClass("background-color")){
                    element.children().removeClass("background-color");
                    $("#single_date").val('');
                }
                else{
                    $(".day-content").removeClass("background-color");
                    element.children().addClass("background-color");
                    $("#single_date").val(formated_date);
                }
                $.get('{{ route('get.select_date-timings') }}',{dateyear:formated_date}, function(data){
                    $(".month-title").css("color","red");
                    $("#monday_start_time").val('');
                    $("#monday_end_time").val('');
                    $("#tuesday_start_time").val('');
                    $("#tuesday_end_time").val('');
                    $("#wednesday_start_time").val('');
                    $("#wednesday_end_time").val('');
                    $("#thursday_start_time").val('');
                    $("#thursday_end_time").val('');
                    $("#friday_start_time").val('');
                    $("#friday_end_time").val('');
                    $("#saturday_start_time").val('');
                    $("#saturday_end_time").val('');
                    $("#sunday_start_time").val('');
                    $("#sunday_end_time").val('');
                    if(!isEmpty(data)){
                        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        var date = new Date(data.date);
                        var dayName = days[date.getDay()];
                        if(dayName == 'Monday'){
                            $("#monday_start_time").val(data.from_time);
                            $("#monday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Tuesday'){
                            $("#tuesday_start_time").val(data.from_time);
                            $("#tuesday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Wednesday'){
                            $("#wednesday_start_time").val(data.from_time);
                            $("#wednesday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Thursday'){
                            $("#thursday_start_time").val(data.from_time);
                            $("#thursday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Friday'){
                            $("#friday_start_time").val(data.from_time);
                            $("#friday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Saturday'){
                            $("#saturday_start_time").val(data.from_time);
                            $("#saturday_end_time").val(data.to_time);
                        }
                        if(dayName == 'Sunday'){
                            $("#sunday_start_time").val(data.from_time);
                            $("#sunday_end_time").val(data.to_time);
                        }
                    }
                });
            }
        function isEmpty(obj) {
            for(var prop in obj) {
                if(obj.hasOwnProperty(prop))
                    return false;
            }
            return true;
        }
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

   function backgroundChange(){
      if($(window).width() >= 768){
      $(".months-container").children().each(function(i, elm) {
         if(i==1){
         $(this).css("background","antiquewhite");
          }
         if(i==4){
         $(this).css("background","antiquewhite");
          }
        if(i==7){
         $(this).css("background","antiquewhite");
          }
        if(i==10){
         $(this).css("background","antiquewhite");
          }
        });
          }
     }

       function fetchAllSelectedDates() {
            $.get('{{ route('not.set.dates') }}', function(data){
                if(data != 'empty'){
                    var selected_year = $(".current_year").html();
                    $.each(data, function (key, value) {
                        slotDate = moment(value.date).format('D');
                        slotMonth = moment(value.date).format('MMMM');
                        slotYear = moment(value.date).format('YYYY');
                        if(slotYear == selected_year) {
                            $('.day-content[date="' + slotDate + '"][month="' + slotMonth + '"]').css({border:"1px solid green", 'border-radius':"14px"});
                        }
                    });
                }
            });
        }
    </script>
@endsection
