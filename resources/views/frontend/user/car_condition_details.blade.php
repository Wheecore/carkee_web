@extends('frontend.layouts.user_panel')
@section('panel_content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row w-100">
                            <div class="col-md-8 col-12">
                                 <h5>{{translate('Customer Car Condition List Details')}}</h5>
                            </div>
                            <div class="col-md-4 col-12">
                                   <form action="" method="get" id="sort_reds">
                                <select id="sort_by_red" name="sort_by_red" class="form-control" onchange="sort_reds()">
                                    <option value="">Filter By</option>
                                    <option value="">All</option>
                                    <option value="Red">Red</option>
                                    <option value="Yellow">Yellow</option>
                                    <option value="Green">Green</option>
                                    <option value="White">White</option>
                                </select>
                            </form>
                            </div>
                        </div>
                    </div>

                    @if(isset($sort_by_red))
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-6 mt-2"><strong>Customer: </strong> </div>
                                        <div class="col-6 mt-2">{{ $condition->customer }}</div>
                                        <div class="col-6 mt-2"><strong>Contact Number: </strong> </div>
                                        <div class="col-6 mt-2">{{ $condition->contact_number }}</div>
                                        <div class="col-6 mt-2"><strong>Model: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->model }}</div>
                                        <div class="col-6 mt-2"><strong>Number Plate: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->number_plate }}</div>
                                        <div class="col-6 mt-2"><strong>Mileage: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->mileage }}</div>
                                        <div class="col-6 mt-2"><strong>Vin: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->vin }}</div>
                                        <div class="col-6 mt-2"><strong>Service Adviser: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->service_advisor }}</div>
                                        <div class="col-6 mt-2"><strong>Techician: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->techician }}</div>
                                        <div class="col-6 mt-2"><strong>Car Condition Date: </strong></div>
                                        <div class="col-6 mt-2">{{ date(env('DATE_FORMAT'), strtotime($condition->car_condition_date)) }}</div>
                                        <div class="col-6 mt-2"><strong>Car Condition Time: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->car_condition_time }}</div>


                                        <div class="col-6 mt-2"><strong>Front End Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->front_end_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Rear End Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->rear_end_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Driver Side Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->driver_side_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Pass Side Body  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->pass_side_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Roof : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->roof?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wind Shield : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->windshield?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Window / Glass : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->window_glass?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wheels / Rim : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->wheels_rim?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Fuel Tank Cover  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->fuel_tank_cover?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wing Mirror  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->wing_cover?'ok':'not ok' }}</div>
                                        <hr>

                                        <h5 style="font-weight: 700">GUIDE FOR INTERIOR / EXTERIOR, UNDER HOOD, UNDER VEHICLE, BRAKE CONDITION </h5>

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

                                        <div class="col-12 mt-2">
                                        <h5>INTERIOR / EXTERIOR</h5></div>
                                        @if($condition->horn_operation == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Horn Operation  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->horn_operation }}; height:30px; width:30px">
                                                </div>

                                            </div>

                                        @endif

                                        @if($condition->headlights == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Headlights / Turn Signals / High Beams / Fog Lights  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->headlights }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        @if($condition->front_wiper_blades == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Front Wiper Blades  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->front_wiper_blades }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        @if($condition->rear_wiper_blade == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Wiper Blade  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->rear_wiper_blade }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        @if($condition->tail_lights == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Tail Lights / Brake Lights / Turn Signals / Reverse Lights : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->tail_lights }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        @if($condition->in_cabin == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>In-cabin Icrofilter / Interior Lights : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->in_cabin }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        @if($condition->system_check_lights == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>System Check Lights / Faulty Massages : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->system_check_lights }}; height:30px; width:30px">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-6 mt-2"><strong> Comment: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->interior_comment }}</div>




                                        <div class="col-12 mt-2">
                                            <h5> UNDER HOOD</h5></div>
                                        @if($condition->engine_oil == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Engine Oil : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->engine_oil }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->coolant == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Coolant : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->coolant }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->power == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Power Steering Fluid : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->power }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->brake_fluid == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Brake Fluid : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->brake_fluid }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->windscreen == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Windscreen Washer Fluid : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->windscreen }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->automatic == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Automatic Transmission Fluid  : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->automatic }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->cooling_system == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Cooling System Hoses / Parts : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->cooling_system }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->radiator_case == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Radiator Case / Core / Cap  : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->radiator_case }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->engine_air == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Engine Air Filter  : </strong></div>
                                            <div class="col-6 mt-2">    <div style="background: {{ $condition->engine_air }}; height:30px; width:30px">
                                                </div></div>
                                        @endif
                                        @if($condition->driver_belt == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Drive Belts  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->driver_belt }}; height:30px; width:30px"></div>
                                            </div>
                                        @endif
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->under_hood_comment }}</div>


                                        <div class="col-12 mt-2">
                                            <h5> UNDER VEHICLE</h5></div>

                                        @if($condition->front_shocks == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Front Shocks / Suspension / Stabalizer / Bushes  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->front_shocks }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->drivershaft == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Driveshaft / Cv Boots : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->drivershaft }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->subframe == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Subframe / Steering System / Tie Rods : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->subframe }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->fluid_leaks == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Fluid Leaks (oil / Transmission / Coolant)  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->fluid_leaks }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->brake_hose == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Brake Hose / Linings / Cables  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->brake_hose }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->real_shocks == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Shocks / Suspension / Stabalizer / Bushes  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->real_shocks }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->differential == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Differential / Axle (check Condition & Leaks)  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->differential }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->exhuast == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Exhuast / Muffler / Mountings  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->exhuast }}; height:30px; width:30px"></div></div>
                                        @endif
                                        @if($condition->wheel_bearing == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Wheel Bearings / Sensors / Harness  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->wheel_bearing }}; height:30px; width:30px"></div></div>
                                        @endif
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->under_vehicle_comment }}</div>


                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <h5> All Images</h5>
                                        </div>
                                        @php
                                            $photos = explode(',', $condition->photos);
                                        @endphp
                                        <div class="col-12 mt-2">
                                        @foreach ($photos as $key => $photo)
                                                <img style="height:165px; width: 46%;margin-bottom: 4px;"
                                                     class=""
                                                     src="{{ uploaded_asset($photo) }}"
                                                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                        @endforeach
                                        </div>
                                        
                                        @if($condition->battery_terminals == $sort_by_red)
                                            <div class="row">
                                                <div class="col-12 mt-2">
                                                    <h5> BATTERY PERFORMANCE </h5></div>
                                                <div class="col-6">
                                                    <div style="height:30px;width: 30px;background:green;border:1px solid blue"></div><b>PASS</b>
                                                </div>
                                                <div class="col-6">
                                                    <div style="height:30px;width: 30px;background:yellow;border:1px solid blue"></div><b>RECHARGE</b>
                                                </div>
                                                <div class="col-6">
                                                    <div style="height:30px;width: 30px;background:red;border:1px solid blue"></div><b>FAIL</b>
                                                </div>
                                                <div class="col-6">
                                                    <div style="height:30px;width: 30px;background:white;border:1px solid blue"></div><b>NOT INSPECTED</b>
                                                </div>
                                            </div>

                                            <div class="col-6 mt-2"><strong>Battery Terminals / Cables / Mounting : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->battery_terminals }}; height:30px; width:30px"></div></div>
                                        @endif
                                        <div class="col-6 mt-2"><strong>Battery Capacity Test : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->battery_capacity_test }}</div>

                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->battery_performance_comment}}</div>


                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <h5> TYRES </h5></div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:green;border:1px solid blue"></div><b>8-6 MM</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:yellow;border:1px solid blue"></div><b>5-3 MM</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:red;border:1px solid blue"></div><b>2MM or LESS</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:white;border:1px solid blue"></div><b>NOT INSPECTED</b>
                                            </div>
                                        </div>
                                        @if($condition->tyre_left_front == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Left Front : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->tyre_left_front }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->tyre_right_front == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Right Front : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->tyre_right_front }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->tyre_left_rear == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Left Rear : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->tyre_left_rear }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->tyre_right_rear == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Right Rear : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->tyre_right_rear }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">
                                            {{ $condition->tyre_comment }}</div>

                                        <div class="col-12 mt-2">
                                            <h5> BRAKE CONDITION  </h5></div>

                                        @if($condition->front_left_brake == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Front Left Brake Pads  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->front_left_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->right_left_brake == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Left Brake Pads  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->right_left_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->front_brake_disc == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Front Brake Disc Rotors : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->front_brake_disc }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->front_right_brake == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Front Right Brake Pads  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->front_right_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->rear_right_brake_pads == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Right Brake Pads  : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->rear_right_brake_pads }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->rear_brake_disc == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Brake Disc Rotors : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->rear_brake_disc }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->rear_right_brake_shoes == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Right Brake Shoes : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->rear_right_brake_shoes }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        @if($condition->rear_right_brake_cylinders == $sort_by_red)
                                            <div class="col-6 mt-2"><strong>Rear Right Brake Cylinders : </strong></div>
                                            <div class="col-6 mt-2">
                                                <div style="background: {{ $condition->rear_right_brake_cylinders }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        @endif
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->brake_condition_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-6 mt-2"><strong>Customer: </strong> </div>
                                        <div class="col-6 mt-2">{{ $condition->customer }}</div>
                                        <div class="col-6 mt-2"><strong>Contact Number: </strong> </div>
                                        <div class="col-6 mt-2">{{ $condition->contact_number }}</div>
                                        <div class="col-6 mt-2"><strong>Model: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->model }}</div>
                                        <div class="col-6 mt-2"><strong>Number Plate: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->number_plate }}</div>
                                        <div class="col-6 mt-2"><strong>Mileage: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->mileage }}</div>
                                        <div class="col-6 mt-2"><strong>Vin: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->vin }}</div>
                                        <div class="col-6 mt-2"><strong>Service Adviser: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->service_advisor }}</div>
                                        <div class="col-6 mt-2"><strong>Techician: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->techician }}</div>
                                        <div class="col-6 mt-2"><strong>Car Condition Date: </strong></div>
                                        <div class="col-6 mt-2">{{ date(env('DATE_FORMAT'), strtotime($condition->car_condition_date)) }}</div>
                                        <div class="col-6 mt-2"><strong>Car Condition Time: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->car_condition_time }}</div>


                                        <div class="col-6 mt-2"><strong>Front End Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->front_end_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Rear End Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->rear_end_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Driver Side Body : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->driver_side_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Pass Side Body  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->pass_side_body?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Roof : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->roof?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wind Shield : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->windshield?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Window / Glass : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->window_glass?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wheels / Rim : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->wheels_rim?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Fuel Tank Cover  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->fuel_tank_cover?'ok':'not ok' }}</div>
                                        <div class="col-6 mt-2"><strong>Wing Mirror  : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->wing_cover?'ok':'not ok' }}</div>
                                        <hr>

                                        <h5 style="font-weight: 700">GUIDE FOR INTERIOR / EXTERIOR, UNDER HOOD, UNDER VEHICLE, BRAKE CONDITION </h5>

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

                                        <div class="col-12 mt-2">
                                            <h5>INTERIOR / EXTERIOR</h5></div>
                                        <div class="col-6 mt-2"><strong>Horn Operation  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->horn_operation }}; height:30px; width:30px;border:1px solid blue">
                                            </div>

                                        </div>
                                        <div class="col-6 mt-2"><strong>Headlights / Turn Signals / High Beams / Fog Lights  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->headlights }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>Front Wiper Blades  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->front_wiper_blades }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>Rear Wiper Blade  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->rear_wiper_blade }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>Tail Lights / Brake Lights / Turn Signals / Reverse Lights : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->tail_lights }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>In-cabin Icrofilter / Interior Lights : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->in_cabin }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>System Check Lights / Faulty Massages : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->system_check_lights }}; height:30px; width:30px;border:1px solid blue">
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong> Comment: </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->interior_comment }}</div>




                                        <div class="col-12 mt-2">
                                            <h5> UNDER HOOD</h5></div>
                                        <div class="col-6 mt-2"><strong>Engine Oil : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->engine_oil }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Coolant : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->coolant }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Power Steering Fluid : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->power }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Brake Fluid : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->brake_fluid }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Windscreen Washer Fluid : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->windscreen }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Automatic Transmission Fluid  : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->automatic }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Cooling System Hoses / Parts : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->cooling_system }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Radiator Case / Core / Cap  : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->radiator_case }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Engine Air Filter  : </strong></div>
                                        <div class="col-6 mt-2">    <div style="background: {{ $condition->engine_air }}; height:30px; width:30px;border:1px solid blue">
                                            </div></div>
                                        <div class="col-6 mt-2"><strong>Drive Belts  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->driver_belt }}; height:30px; width:30px;border:1px solid blue"></div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->under_hood_comment }}</div>


                                        <div class="col-12 mt-2">
                                            <h5> UNDER VEHICLE</h5></div>

                                        <div class="col-6 mt-2"><strong>Front Shocks / Suspension / Stabalizer / Bushes  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->front_shocks }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Driveshaft / Cv Boots : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->drivershaft }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Subframe / Steering System / Tie Rods : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->subframe }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Fluid Leaks (oil / Transmission / Coolant)  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->fluid_leaks }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Brake Hose / Linings / Cables  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->brake_hose }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Shocks / Suspension / Stabalizer / Bushes  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->real_shocks }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Differential / Axle (check Condition & Leaks)  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->differential }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Exhuast / Muffler / Mountings  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->exhuast }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Wheel Bearings / Sensors / Harness  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->wheel_bearing }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->under_vehicle_comment }}</div>


                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">

                                        <div class="col-12 mt-2">
                                            <h5> All Images</h5>
                                        </div>
                                        @php
                                            $photos = explode(',', $condition->photos);
                                        @endphp
                                        <div class="col-12 mt-2">
                                        @foreach ($photos as $key => $photo)
                                                <img style="height:165px; width: 46%;margin-bottom: 4px;"
                                                     class=""
                                                     src="{{ uploaded_asset($photo) }}"
                                                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                        @endforeach
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <h5> BATTERY PERFORMANCE </h5></div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:green;border:1px solid blue"></div><b>PASS</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:yellow;border:1px solid blue"></div><b>RECHARGE</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:red;border:1px solid blue"></div><b>FAIL</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:white;border:1px solid blue"></div><b>NOT INSPECTED</b>
                                            </div>
                                        </div>

                                        <div class="col-6 mt-2"><strong>Battery Terminals / Cables / Mounting : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->battery_terminals }}; height:30px; width:30px;border:1px solid blue;border:1px solid blue"></div></div>

                                        <div class="col-6 mt-2"><strong>Battery Capacity Test : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->battery_capacity_test }}</div>

                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->battery_performance_comment}}</div>



                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <h5> TYRES </h5></div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:green;border:1px solid blue"></div><b>8-6 MM</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:yellow;border:1px solid blue"></div><b>5-3 MM</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:red;border:1px solid blue"></div><b>2MM or LESS</b>
                                            </div>
                                            <div class="col-6">
                                                <div style="height:30px;width: 30px;background:white;border:1px solid blue"></div><b>NOT INSPECTED</b>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-2"><strong>Left Front : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->tyre_left_front }}; height:30px; width:30px;border:1px solid blue"></div></div>

                                        <div class="col-6 mt-2"><strong>Right Front : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->tyre_right_front }}; height:30px; width:30px;border:1px solid blue"></div></div>

                                        <div class="col-6 mt-2"><strong>Left Rear : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->tyre_left_rear }}; height:30px; width:30px;border:1px solid blue"></div></div>

                                        <div class="col-6 mt-2"><strong>Right Rear : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->tyre_right_rear }}; height:30px; width:30px;border:1px solid blue"></div></div>

                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">
                                            {{ $condition->tyre_comment }}</div>

                                        <div class="col-12 mt-2">
                                            <h5> BRAKE CONDITION  </h5></div>

                                        <div class="col-6 mt-2"><strong>Front Left Brake Pads  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->front_left_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Left Brake Pads  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->right_left_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Front Brake Disc Rotors : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->front_brake_disc }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Front Right Brake Pads  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->front_right_brake }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Right Brake Pads  : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->rear_right_brake_pads }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Brake Disc Rotors : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->rear_brake_disc }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Right Brake Shoes : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->rear_right_brake_shoes }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Rear Right Brake Cylinders : </strong></div>
                                        <div class="col-6 mt-2">
                                            <div style="background: {{ $condition->rear_right_brake_cylinders }}; height:30px; width:30px;border:1px solid blue"></div></div>
                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                        <div class="col-6 mt-2">{{ $condition->brake_condition_comment }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
<script>
    function sort_reds(el){
        $('#sort_reds').submit();
    }
</script>

@endsection

