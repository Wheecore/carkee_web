@extends('frontend.layouts.user_panel')
@section('panel_content')

    <style>
        .radio-toolbar input[type="radio"]:checked + label{
            border: 5px solid blue;
        }
    </style>
    <?php
    $data = DB::table('car_lists')->where('user_id', $order->user_id)->first();
    if($data){
        $model = DB::table('car_models')->where('id', $data->model_id)->first();
    }
    $user = DB::table('users')->where('id', $order->user_id)->first();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
                    </div>
                    <div class="card-body">

                        <div class="row gutters-5">
                            <div class="col mt-2">
                                @if($order->delivery_status != 'Confirmed' && $order->delivery_status != 'Rejected')
                                    <a href="{{ route('confirm.order',$order->id) }}" class="btn btn-primary">Notify user to Workshop</a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#reject">
                                        Reject
                                    </button>
                                @endif
                            </div>

                            <div class="col-md-4 ml-auto">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('User Name')}}</td>
                                        <td class="text-right text-info text-bold">	{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('User Email')}}</td>
                                        <td class="text-right text-info text-bold">	{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('Order #')}}</td>
                                        <td class="text-right text-info text-bold">	{{ $order->code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('Order Status')}}</td>
                                        @php
                                            $status = $order->delivery_status;
                                        @endphp
                                        <td class="text-right">
                                            @if($status == 'delivered')
                                                <span class="badge badge-inline badge-success" style="padding: 5px;">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                            @else
                                                <span class="badge badge-inline badge-info" style="padding: 5px;">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('Order Date')}}	</td>
                                        <td class="text-right">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-main text-bold">{{translate('Payment method')}}</td>
                                        <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if(Auth::user()->user_type == 'seller' && $order->delivery_status == 'Confirmed')

                            <form action="{{ route('save_car_condition',$order->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="customer">Customer</label>
                                            <input type="text" name="customer" id="customer" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact_number">Contact Number</label>
                                            <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $user->phone }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="model">Model</label>
                                            <input type="text" name="model" id="model" class="form-control" value="{{ $order->model_name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="number_plate">Number Plate</label>
                                            <input type="text" name="number_plate" id="number_plate" class="form-control" value="{{ $order->car_plate }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="mileage">Mileage</label>
                                            <input type="text" name="mileage" id="mileage" class="form-control" value="{{ isset($data)?$data->mileage:'' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="vin">Vin</label>
                                            <input type="text" name="vin" id="vin" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="service_advisor">Service Advisor</label>
                                            <input type="text" name="service_advisor" id="service_advisor" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="techician">Techician</label>
                                            <input type="text" name="techician" id="techician" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" name="car_condition_date" id="car_condition_date" class="form-control" value="{{date('Y-m-d')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="time">Time</label>
                                            <input type="time" name="car_condition_time" id="car_condition_time" class="form-control">
                                        </div>

                                        {{--<div class="form-group">--}}

                                        {{--<label for="conditon">Your Car Condition is Good?</label>--}}
                                        {{--<select name="condition" id="condition" class="form-control">--}}
                                        {{--<option value="Yes" {{ isset($cc)?$cc->car_condition == 'Yes' ? 'selected' : '' : '' }}>Yes</option>--}}
                                        {{--<option value="No" {{ isset($cc)?$cc->car_condition == 'No' ? 'selected' : '' : '' }}>No</option>--}}
                                        {{--</select>--}}
                                        {{--</div>--}}

                                    </div>

                                    <div class="col-md-6 col-sm-12">

                                        <div class="form-group">
                                            <label for="images">Add Multiple Images</label>
                                            {{--<input type="file" name="images" id="images" class="form-control">--}}

                                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                <input type="hidden" name="photos" class="selected-files">
                                            </div>
                                            <div class="file-preview box sm" style="padding: unset">
                                            </div>
                                            {{--<small class="text-muted">{{translate('These images are visible in product details page gallery. Use 600x600 sizes images.')}}</small>--}}

                                        </div>


                                        <div class="form-group">
                                            <input type="checkbox" name="front_end_body" id="front_end_body" value="ON">
                                            <label for="front_end_body" class="ml-1">Front End Body</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="rear_end_body" id="rear_end_body" class="" value="ON">
                                            <label for="rear_end_body" class="ml-1">Rear End Body</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="driver_side_body" id="driver_side_body" value="ON">
                                            <label for="driver_side_body">Driver side Body</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="pass_side_body" id="pass_side_body" value="ON">
                                            <label for="pass_side_body" class="ml-1">Pass side Body</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="roof" id="roof" value="ON">
                                            <label for="roof" class="ml-1">Roof</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="windshield" id="windshield" value="ON">
                                            <label for="windshield" class="ml-1">WindShield</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="window_glass" id="window_glass" value="ON">
                                            <label for="window_glass" class="ml-1">Windows/Glass</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="wheels_rim" id="wheels_rim" value="ON">
                                            <label for="wheels_rim" class="ml-1">Wheels/Rim</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="fuel_tank_cover" id="fuel_tank_cover" value="ON">
                                            <label for="fuel_tank_cover" class="ml-1">Fuel Tank Cover</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="wing_cover" id="wing_cover" value="ON">
                                            <label for="wing_cover" class="ml-1">Wing Cover</label>
                                        </div>

                                    </div>
                                </div>

                                <hr>
                                <h3 style="font-weight: 700">GUIDE FOR INTERIOR / EXTERIOR, UNDER HOOD, UNDER VEHICLE, BRAKE CONDITION </h3>

                                <div class="row">
                                    <div class="col-3">
                                        <div style="height:30px;width: 30px;background:green;border:1px solid blue"></div><b>CHECKED AND OK AT THIS TIME</b>
                                    </div>
                                    <div class="col-3">
                                        <div style="height:30px;width: 30px;background:yellow;border:1px solid blue"></div><b>MAY NEED FUTURE ATTENTION</b>
                                    </div>
                                    <div class="col-3">
                                        <div style="height:30px;width: 30px;background:red;border:1px solid blue"></div><b>REQUIRES IMMEDIATE ATTENTION</b>
                                    </div>
                                    <div class="col-3">
                                        <div style="height:30px;width: 30px;background:white;border:1px solid blue"></div><b>NOT INSPECTED</b>
                                    </div>
                                </div>
                                <style>
                                    .radio-toolbar {
                                        margin: 10px;
                                    }

                                    .radio-toolbar input[type="radio"] {
                                        opacity: 0;
                                        position: fixed;
                                        width: 0;
                                    }

                                    .radio-toolbar label {
                                        display: inline-block;
                                        background-color: #ddd;
                                        padding: 10px 20px;
                                        font-family: sans-serif, Arial;
                                        font-size: 16px;
                                        border: 2px solid #444;
                                        border-radius: 4px;
                                    }

                                    .radio-toolbar label:hover {
                                        background-color: #dfd;
                                    }

                                    .radio-toolbar input[type="radio"]:focus + label {
                                        border: 4px dashed #444;
                                    }

                                    .radio-toolbar input[type="radio"]:checked + label {
                                        background-color: #bfb;
                                        border-color: blue;
                                    }

                                </style>
                                <hr>
                                <h3 style="font-weight: 700">GUIDE FOR INTERIOR / EXTERIOR</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="wing_cover"><b>HORN OPERATION</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen" name="horn_operation" value="Green">
                                            <label for="radioGreen" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow" name="horn_operation" value="Yellow">
                                            <label for="radioYellow" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed" name="horn_operation" value="Red">
                                            <label for="radioRed" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite" name="horn_operation" value="White" checked>
                                            <label for="radioWhite" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>HEADLIGHTS / TURN SIGNALS / HIGH BEAMS / FOG LIGHTS </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen1" name="headlights" value="Green">
                                            <label for="radioGreen1" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow1" name="headlights" value="Yellow">
                                            <label for="radioYellow1" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed1" name="headlights" value="Red">
                                            <label for="radioRed1" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite1" name="headlights" value="White" checked>
                                            <label for="radioWhite1" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FRONT WIPER BLADES  </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen2" name="front_wiper_blades" value="Green">
                                            <label for="radioGreen2" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow2" name="front_wiper_blades" value="Yellow">
                                            <label for="radioYellow2" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed2" name="front_wiper_blades" value="Red">
                                            <label for="radioRed2" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite2" name="front_wiper_blades" value="White" checked>
                                            <label for="radioWhite2" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR WIPER BLADE   </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen3" name="rear_wiper_blade" value="Green">
                                            <label for="radioGreen3" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow3" name="rear_wiper_blade" value="Yellow">
                                            <label for="radioYellow3" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed3" name="rear_wiper_blade" value="Red">
                                            <label for="radioRed3" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite3" name="rear_wiper_blade" value="White" checked>
                                            <label for="radioWhite3" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>TAIL LIGHTS / BRAKE LIGHTS / TURN SIGNALS / REVERSE LIGHTS   </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen4" name="tail_lights" value="Green">
                                            <label for="radioGreen4" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow4" name="tail_lights" value="Yellow">
                                            <label for="radioYellow4" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed4" name="tail_lights" value="Red">
                                            <label for="radioRed4" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite4" name="tail_lights" value="White" checked>
                                            <label for="radioWhite4" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>IN-CABIN ICROFILTER / INTERIOR LIGHTS   </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen5" name="in_cabin" value="Green">
                                            <label for="radioGreen5" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow5" name="in_cabin" value="Yellow">
                                            <label for="radioYellow5" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed5" name="in_cabin" value="Red">
                                            <label for="radioRed5" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite5" name="in_cabin" value="White" checked>
                                            <label for="radioWhite5" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>SYSTEM CHECK LIGHTS / FAULTY MASSAGES  </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen6" name="system_check_lights" value="Green">
                                            <label for="radioGreen6" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow6" name="system_check_lights" value="Yellow">
                                            <label for="radioYellow6" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed6" name="system_check_lights" value="Red">
                                            <label for="radioRed6" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite6" name="system_check_lights" value="White" checked>
                                            <label for="radioWhite6" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="interior_comment" name="interior_comment" rows="3"></textarea>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <h3 style="font-weight: 700">UNDER HOOD</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="wing_cover"><b>ENGINE OIL </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7" name="engine_oil" value="Green">
                                            <label for="radioGreen7" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7" name="engine_oil" value="Yellow">
                                            <label for="radioYellow7" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7" name="engine_oil" value="Red">
                                            <label for="radioRed7" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7" name="engine_oil" value="White" checked>
                                            <label for="radioWhite7" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>COOLANT  </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen8" name="coolant" value="Green">
                                            <label for="radioGreen8" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow8" name="coolant" value="Yellow">
                                            <label for="radioYellow8" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed8" name="coolant" value="Red">
                                            <label for="radioRed8" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite8" name="coolant" value="White" checked>
                                            <label for="radioWhite8" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>POWER STEERING FLUID   </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen9" name="power" value="Green">
                                            <label for="radioGreen9" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow9" name="power" value="Yellow">
                                            <label for="radioYellow9" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed9" name="power" value="Red">
                                            <label for="radioRed9" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite9" name="power" value="White" checked>
                                            <label for="radioWhite9" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>BRAKE FLUID</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen10" name="brake_fluid" value="Green">
                                            <label for="radioGreen10" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow10" name="brake_fluid" value="Yellow">
                                            <label for="radioYellow10" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed10" name="brake_fluid" value="Red">
                                            <label for="radioRed10" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite10" name="brake_fluid" value="White" checked>
                                            <label for="radioWhite10" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>WINDSCREEN WASHER FLUID</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen11" name="windscreen" value="Green">
                                            <label for="radioGreen11" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow11" name="windscreen" value="Yellow">
                                            <label for="radioYellow11" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed11" name="windscreen" value="Red">
                                            <label for="radioRed11" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite11" name="windscreen" value="White" checked>
                                            <label for="radioWhite11" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>AUTOMATIC TRANSMISSION FLUID</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen12" name="automatic" value="Green">
                                            <label for="radioGreen12" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow12" name="automatic" value="Yellow">
                                            <label for="radioYellow12" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed12" name="automatic" value="Red">
                                            <label for="radioRed12" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite12" name="automatic" value="White" checked>
                                            <label for="radioWhite12" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>COOLING SYSTEM HOSES / PARTS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen13" name="cooling_system" value="Green">
                                            <label for="radioGreen13" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow13" name="cooling_system" value="Yellow">
                                            <label for="radioYellow13" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed13" name="cooling_system" value="Red">
                                            <label for="radioRed13" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite13" name="cooling_system" value="White" checked>
                                            <label for="radioWhite13" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>RADIATOR CASE / CORE / CAP</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen131" name="radiator_case" value="Green">
                                            <label for="radioGreen131" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow131" name="radiator_case" value="Yellow">
                                            <label for="radioYellow131" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed131" name="radiator_case" value="Red">
                                            <label for="radioRed131" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite131" name="radiator_case" value="White" checked>
                                            <label for="radioWhite131" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>ENGINE AIR FILTER</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen1311" name="engine_air" value="Green">
                                            <label for="radioGreen1311" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow1311" name="engine_air" value="Yellow">
                                            <label for="radioYellow1311" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed1311" name="engine_air" value="Red">
                                            <label for="radioRed1311" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite1311" name="engine_air" value="White" checked>
                                            <label for="radioWhite1311" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>DRIVE BELTS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen13111" name="driver_belt" value="Green">
                                            <label for="radioGreen13111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow13111" name="driver_belt" value="Yellow">
                                            <label for="radioYellow13111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed13111" name="driver_belt" value="Red">
                                            <label for="radioRed13111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite13111" name="driver_belt" value="White" checked>
                                            <label for="radioWhite13111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="under_hood" name="under_hood_comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 style="font-weight: 700">UNDER VEHICLE</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FRONT SHOCKS / SUSPENSION / STABALIZER / BUSHES</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen71" name="front_shocks" value="Green">
                                            <label for="radioGreen71" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow71" name="front_shocks" value="Yellow">
                                            <label for="radioYellow71" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed71" name="front_shocks" value="Red">
                                            <label for="radioRed71" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite71" name="front_shocks" value="White" checked>
                                            <label for="radioWhite71" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>DRIVESHAFT / CV BOOTS </b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen711" name="drivershaft" value="Green">
                                            <label for="radioGreen711" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow711" name="drivershaft" value="Yellow">
                                            <label for="radioYellow711" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed711" name="drivershaft" value="Red">
                                            <label for="radioRed711" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite711" name="drivershaft" value="White" checked>
                                            <label for="radioWhite711" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>SUBFRAME / STEERING SYSTEM / TIE RODS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7111" name="subframe" value="Green">
                                            <label for="radioGreen7111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7111" name="subframe" value="Yellow">
                                            <label for="radioYellow7111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7111" name="subframe" value="Red">
                                            <label for="radioRed7111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7111" name="subframe" value="White" checked>
                                            <label for="radioWhite7111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FLUID LEAKS (OIL / TRANSMISSION / COOLANT)</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen71111" name="fluid_leaks" value="Green">
                                            <label for="radioGreen71111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow71111" name="fluid_leaks" value="Yellow">
                                            <label for="radioYellow71111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed71111" name="fluid_leaks" value="Red">
                                            <label for="radioRed71111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite71111" name="fluid_leaks" value="White" checked>
                                            <label for="radioWhite71111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>BRAKE HOSE / LININGS / CABLES</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen711111" name="brake_hose" value="Green">
                                            <label for="radioGreen711111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow711111" name="brake_hose" value="Yellow">
                                            <label for="radioYellow711111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed711111" name="brake_hose" value="Red">
                                            <label for="radioRed711111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite711111" name="brake_hose" value="White" checked>
                                            <label for="radioWhite711111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR SHOCKS / SUSPENSION / STABALIZER / BUSHES</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7111111" name="real_shocks" value="Green">
                                            <label for="radioGreen7111111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7111111" name="real_shocks" value="Yellow">
                                            <label for="radioYellow7111111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7111111" name="real_shocks" value="Red">
                                            <label for="radioRed7111111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7111111" name="real_shocks" value="White" checked>
                                            <label for="radioWhite7111111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>DIFFERENTIAL / AXLE (CHECK CONDITION & LEAKS)</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen71111111" name="differential" value="Green">
                                            <label for="radioGreen71111111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow71111111" name="differential" value="Yellow">
                                            <label for="radioYellow71111111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed71111111" name="differential" value="Red">
                                            <label for="radioRed71111111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite71111111" name="differential" value="White" checked>
                                            <label for="radioWhite71111111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>EXHUAST / MUFFLER / MOUNTINGS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen711111111" name="exhuast" value="Green">
                                            <label for="radioGreen711111111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow711111111" name="exhuast" value="Yellow">
                                            <label for="radioYellow711111111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed711111111" name="exhuast" value="Red">
                                            <label for="radioRed711111111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite711111111" name="exhuast" value="White" checked>
                                            <label for="radioWhite711111111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>WHEEL BEARINGS / SENSORS / HARNESS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7111111111" name="wheel_bearing" value="Green">
                                            <label for="radioGreen7111111111" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7111111111" name="wheel_bearing" value="Yellow">
                                            <label for="radioYellow7111111111" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7111111111" name="wheel_bearing" value="Red">
                                            <label for="radioRed7111111111" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7111111111" name="wheel_bearing" value="White" checked>
                                            <label for="radioWhite7111111111" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="under_vehicle_comment" name="under_vehicle_comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <h3 style="font-weight: 700">BRAKE CONDITION</h3>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FRONT LEFT BRAKE PADS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen72" name="front_left_brake" value="Green">
                                            <label for="radioGreen72" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow72" name="front_left_brake" value="Yellow">
                                            <label for="radioYellow72" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed72" name="front_left_brake" value="Red">
                                            <label for="radioRed72" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite72" name="front_left_brake" value="White" checked>
                                            <label for="radioWhite72" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR LEFT BRAKE PADS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen722" name="right_left_brake" value="Green">
                                            <label for="radioGreen722" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow722" name="right_left_brake" value="Yellow">
                                            <label for="radioYellow722" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed722" name="right_left_brake" value="Red">
                                            <label for="radioRed722" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite722" name="right_left_brake" value="White" checked>
                                            <label for="radioWhite722" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FRONT BRAKE DISC ROTORS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7222" name="front_brake_disc" value="Green">
                                            <label for="radioGreen7222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7222" name="front_brake_disc" value="Yellow">
                                            <label for="radioYellow7222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7222" name="front_brake_disc" value="Red">
                                            <label for="radioRed7222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7222" name="front_brake_disc" value="White" checked>
                                            <label for="radioWhite7222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>FRONT RIGHT BRAKE PADS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen72222" name="front_right_brake" value="Green">
                                            <label for="radioGreen72222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow72222" name="front_right_brake" value="Yellow">
                                            <label for="radioYellow72222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed72222" name="front_right_brake" value="Red">
                                            <label for="radioRed72222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite72222" name="front_right_brake" value="White" checked>
                                            <label for="radioWhite72222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR RIGHT BRAKE PADS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen722222" name="rear_right_brake_pads" value="Green">
                                            <label for="radioGreen722222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow722222" name="rear_right_brake_pads" value="Yellow">
                                            <label for="radioYellow722222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed722222" name="rear_right_brake_pads" value="Red">
                                            <label for="radioRed722222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite722222" name="rear_right_brake_pads" value="White" checked>
                                            <label for="radioWhite722222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR BRAKE DISC ROTORS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7222222" name="rear_brake_disc" value="Green">
                                            <label for="radioGreen7222222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow7222222" name="rear_brake_disc" value="Yellow">
                                            <label for="radioYellow7222222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed7222222" name="rear_brake_disc" value="Red">
                                            <label for="radioRed7222222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite7222222" name="rear_brake_disc" value="White" checked>
                                            <label for="radioWhite7222222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR RIGHT BRAKE SHOES</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen72222222" name="rear_right_brake_shoes" value="Green">
                                            <label for="radioGreen72222222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow72222222" name="rear_right_brake_shoes" value="Yellow">
                                            <label for="radioYellow72222222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed72222222" name="rear_right_brake_shoes" value="Red">
                                            <label for="radioRed72222222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite72222222" name="rear_right_brake_shoes" value="White" checked>
                                            <label for="radioWhite72222222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="wing_cover"><b>REAR RIGHT BRAKE CYLINDERS</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen722222222" name="rear_right_brake_cylinders" value="Green">
                                            <label for="radioGreen722222222" style="background: green;color:white">Green</label>

                                            <input type="radio" id="radioYellow722222222" name="rear_right_brake_cylinders" value="Yellow">
                                            <label for="radioYellow722222222" style="background:yellow">Yellow</label>

                                            <input type="radio" id="radioRed722222222" name="rear_right_brake_cylinders" value="Red">
                                            <label for="radioRed722222222" style="background:red;color:white">Red</label>

                                            <input type="radio" id="radioWhite722222222" name="rear_right_brake_cylinders" value="White" checked>
                                            <label for="radioWhite722222222" style="background:white">White</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="brake_condition_comment" name="brake_condition_comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 style="font-weight: 700">BATTERY PERFORMANCE</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="wing_cover"><b>BATTERY TERMINALS / CABLES / MOUNTING</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen71111111111" name="battery_terminals" value="Green">
                                            <label for="radioGreen71111111111" style="background: green;color:white">PASS</label>

                                            <input type="radio" id="radioYellow71111111111" name="battery_terminals" value="Yellow">
                                            <label for="radioYellow71111111111" style="background:yellow">RECHARGE</label>

                                            <input type="radio" id="radioRed71111111111" name="battery_terminals" value="Red">
                                            <label for="radioRed71111111111" style="background:red;color:white">FAIL</label>

                                            <input type="radio" id="radioWhite71111111111" name="battery_terminals" value="White" checked>
                                            <label for="radioWhite71111111111" style="background:white">NOT INSPECTED </label>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="exampleFormControlTextarea4">BATTERY CAPACITY TEST:  <span style="color:green">*</span></label>
                                        <input type="text" name="battery_capacity_test" class="form-control">
                                    </div>
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="battery_performance_comment" name="battery_performance_comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h3 style="font-weight: 700">TYRES (TREAD DEPTH)</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="wing_cover"><b>LEFT FRONT</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen711111111111" name="tyre_left_front" value="Green">
                                            <label for="radioGreen711111111111" style="background: green;color:white">8-6 MM</label>

                                            <input type="radio" id="radioYellow711111111111" name="tyre_left_front" value="Yellow">
                                            <label for="radioYellow711111111111" style="background:yellow">5-3 MM</label>

                                            <input type="radio" id="radioRed711111111111" name="tyre_left_front" value="Red">
                                            <label for="radioRed711111111111" style="background:red;color:white">2MM or LESS</label>

                                            <input type="radio" id="radioWhite711111111111" name="tyre_left_front" value="White" checked>
                                            <label for="radioWhite711111111111" style="background:white">NOT INSPECTED </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="wing_cover"><b>RIGHT FRONT</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen7111111111111" name="tyre_right_front" value="Green">
                                            <label for="radioGreen7111111111111" style="background: green;color:white">8-6 MM</label>

                                            <input type="radio" id="radioYellow7111111111111" name="tyre_right_front" value="Yellow">
                                            <label for="radioYellow7111111111111" style="background:yellow">5-3 MM</label>

                                            <input type="radio" id="radioRed7111111111111" name="tyre_right_front" value="Red">
                                            <label for="radioRed7111111111111" style="background:red;color:white">2MM or LESS</label>

                                            <input type="radio" id="radioWhite7111111111111" name="tyre_right_front" value="White" checked>
                                            <label for="radioWhite7111111111111" style="background:white">NOT INSPECTED </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="wing_cover"><b>LEFT REAR</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen71111111111111" name="tyre_left_rear" value="Green">
                                            <label for="radioGreen71111111111111" style="background: green;color:white">8-6 MM</label>

                                            <input type="radio" id="radioYellow71111111111111" name="tyre_left_rear" value="Yellow">
                                            <label for="radioYellow71111111111111" style="background:yellow">5-3 MM</label>

                                            <input type="radio" id="radioRed71111111111111" name="tyre_left_rear" value="Red">
                                            <label for="radioRed71111111111111" style="background:red;color:white">2MM or LESS</label>

                                            <input type="radio" id="radioWhite71111111111111" name="tyre_left_rear" value="White" checked>
                                            <label for="radioWhite71111111111111" style="background:white">NOT INSPECTED </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="wing_cover"><b>RIGHT REAR</b></label>
                                        <div class="radio-toolbar">
                                            <input type="radio" id="radioGreen711111111111111" name="tyre_right_rear" value="Green">
                                            <label for="radioGreen711111111111111" style="background: green;color:white">8-6 MM</label>

                                            <input type="radio" id="radioYellow711111111111111" name="tyre_right_rear" value="Yellow">
                                            <label for="radioYellow711111111111111" style="background:yellow">5-3 MM</label>

                                            <input type="radio" id="radioRed711111111111111" name="tyre_right_rear" value="Red">
                                            <label for="radioRed711111111111111" style="background:red;color:white">2MM or LESS</label>

                                            <input type="radio" id="radioWhite711111111111111" name="tyre_right_rear" value="White" checked>
                                            <label for="radioWhite711111111111111" style="background:white">NOT INSPECTED </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group purple-border">
                                            <label for="exampleFormControlTextarea4">Comment <span style="color:green">*</span></label>
                                            <textarea class="form-control" id="tyre_comment" name="tyre_comment" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Start Installation</button>
                                </div>
                            </form>
                        @endif
                        <hr class="new-section-sm bord-no">
                        @if ($tyre_products)
                        <div class="row">
                            <h6>Tyre Products</h6>
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-bordered aiz-table invoice-summary">
                                    <thead>
                                    <tr class="bg-trans-dark">
                                        <th class="min-col">#</th>
                                        <th width="10%">{{translate('Photo')}}</th>
                                        <th class="text-uppercase">{{translate('Description')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($tyre_products as $key => $orderDetail)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                @if ($orderDetail->thumbnail_img)
                                                    <a href="javascript:void(0);" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}"></a>
                                                @else
                                                    <strong>{{ translate('N/A') }}</strong>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($orderDetail->name != null)
                                                    <strong><a href="javascript:void(0);" target="_blank" class="text-muted">{{ $orderDetail->name }}</a></strong>
                                                @else
                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $orderDetail->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if ($package_products)
                        <div class="row mt-5">
                            <h6>Package Products</h6>
                            <div class="col-lg-12 table-responsive">
                                <table class="table table-bordered aiz-table invoice-summary">
                                    <thead>
                                    <tr class="bg-trans-dark">
                                        <th class="min-col">#</th>
                                        <th width="10%">{{translate('Photo')}}</th>
                                        <th class="text-uppercase">{{translate('Description')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Package')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($package_products as $key => $orderDetail)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                @if ($orderDetail->thumbnail_img)
                                                    <a href="javascript:void(0);" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}"></a>
                                                @else
                                                    <strong>{{ translate('N/A') }}</strong>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($orderDetail->name != null)
                                                    <strong><a href="javascript:void(0);" target="_blank" class="text-muted">{{ $orderDetail->name }}</a></strong>
                                                @else
                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $orderDetail->quantity }}</td>
                                            <td class="text-center">{{ translate('Package') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" action="{{ route('reject.order', $order->id) }}" method="post">
                    <div class="modal-body">

                        @csrf
                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function(){
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token          :'{{ @csrf_token() }}',
                order_id        :order_id,
                delivery_boy    :delivery_boy
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });

        $('#update_delivery_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token:'{{ @csrf_token() }}',
                order_id:order_id,
                status:status
            }, function(data){
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });

        $('#update_payment_status').on('change', function(){
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });
    </script>

    <script>
        function PrintElem(elem)
        {
            var mywindow = window.open('', 'PRINT', 'height=600,width=600');

            mywindow.document.write('<html><head><title>' + document.title  + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title  + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }
    </script>

    <script>
        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);

            $('#car_condition_date').attr('min', maxDate);
        });
    </script>

@endsection
