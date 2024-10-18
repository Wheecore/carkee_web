@extends('backend.layouts.app')
@section('title', 'Customers Wallet Transactions')
@section('content')
<style>
    .main-card {
        padding: 10px !important;
        height: 232px;
    }

    .card-area .main-card {
        border-radius: 6px;
        box-shadow: 2px 2px 19px -8px #888888;
    }

    .product_img {
        width: 60px;
        height: 60px;
    }

    .brand_img {
        max-width: 100px;
        max-height: 50px;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 14px;
        width: 33.33%;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
    }
</style>
<div class="card">
    <form action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-0 h6">{{ translate('Customers Wallet Transactions') }}</h5>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}"
                        name="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y"
                        data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search"
                        name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
    </form>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="mb-4">
                    <div class="tab mb-3">
                        <button class="tablinks {{($type == 'added' || $type == null)?'active':''}}" onclick="opentab(event, 'added')">Added To Wallet</button>
                        <button class="tablinks {{($type == 'deduct_o')?'active':''}}" onclick="opentab(event, 'deduct_o')">Deduct From Wallet By Order</button>
                        <button class="tablinks {{($type == 'deduct_m')?'active':''}}" onclick="opentab(event, 'deduct_m')">Deduct From Wallet Manually</button>
                    </div>

                    <div id="added" class="tabcontent" @if($type == 'added' || $type == null) style="display: block" @endif>
                        <div class="card-area">
                        <div class="row">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ translate('User') }}</th>
                                        <th>{{ translate('Recharge By') }}</th>
                                        <th>{{ translate('Amount') }}</th>
                                        <th>{{ translate('Payment Method') }}</th>
                                        <th>{{ translate('Staff Code') }}</th>
                                        <th>{{ translate('Transaction ID') }}</th>
                                        <th>{{ translate('Remarks') }}</th>
                                        <th>{{ translate('Created') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($added_to_wallet as $data)
                                    @php $payment_data = json_decode($data->payment_details); @endphp
                                            <tr>
                                                <td>{{ $data->receiver_name.' ('.$data->receiver_email.')' }}</td>
                                                <td>{{ ($data->user_id != $data->charge_by)?$data->name.' ('.$data->email.')':'self' }}</td>
                                                <td>{{ format_price($data->amount) }}</td>
                                                <td>{{ $data->payment_method }}</td>
                                                <td>{{ $data->staff_code }}</td>
                                                <td>{{ (isset($payment_data->transid))?$payment_data->transid:'' }}</td>
                                                <td>{{ $data->remarks }}</td>
                                                <td>{{ $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '' }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="aiz-pagination">
                            {{ $added_to_wallet->appends(['type' => 'added'])->links() }}
                        </div>
                    </div>
                    </div>

                    <div id="deduct_o" class="tabcontent" @if($type == 'deduct_o') style="display: block" @endif>
                        <div class="card-area">
                        <div class="row">
                            <table class="table aiz-table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ translate('User') }}</th>
                                        <th>{{ translate('Order Code') }}</th>
                                        <th>{{ translate('Amount') }}</th>
                                        <th>{{ translate('Payment Method') }}</th>
                                        <th>{{ translate('Transaction ID') }}</th>
                                        <th>{{ translate('Created') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($deduct_from_wallet as $data)
                                            <tr>
                                                <td>{{ $data->receiver_name.' ('.$data->receiver_email.')' }}</td>
                                                <td>{{ $data->code }}</td>
                                                <td>{{ format_price($data->amount) }}</td>
                                                <td>Wallet</td>
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '' }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="aiz-pagination">
                            {{ $deduct_from_wallet->appends(['type' => 'deduct_o'])->links() }}
                        </div>
                    </div>
                    </div>

                    <div id="deduct_m" class="tabcontent" @if($type == 'deduct_m') style="display: block" @endif>
                        <div class="card-area">
                            <div class="row">
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('User') }}</th>
                                            <th>{{ translate('Deduct By') }}</th>
                                            <th>{{ translate('Amount') }}</th>
                                            <th>{{ translate('Remarks') }}</th>
                                            <th>{{ translate('Created') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deduct_from_wallet_manually as $data)
                                                <tr>
                                                    <td>{{ $data->receiver_name.' ('.$data->receiver_email.')' }}</td>
                                                    <td>{{ ($data->user_id != $data->charge_by)?$data->name.' ('.$data->email.')':'self' }}</td>
                                                    <td>{{ format_price($data->amount) }}</td>
                                                    <td>{{ $data->remarks }}</td>
                                                    <td>{{ $data->created_at ? convert_datetime_to_local_timezone($data->created_at, $timezone) : '' }}</td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="aiz-pagination">
                                {{ $deduct_from_wallet_manually->appends(['type' => 'deduct_m'])->links() }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function opentab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection
