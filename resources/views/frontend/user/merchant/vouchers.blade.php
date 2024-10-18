@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aiz-titlebar text-left mt-4 mb-2">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{translate('All Vouchers')}}
                                 <a href="{{ route('scan-voucher-qrcode') }}" class="btn btn-sm btn-outline-primary" style="float: right;">
                                    <i class="las la-qrcode aiz-side-nav-icon" style="font-size: 45px;"></i>
                                    <span class="aiz-side-nav-text">{{ translate('') }}</span>
                                </a>
                                </h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header row">
                        <div class="col">
                            <h5 class="mb-md-0 h6">{{ translate('All Vouchers') }}</h5>
                        </div>
                        <div class="col-md-5">
                            <form class="" id="sort_merchants" action="{{url('/merchant/merchant/vouchers')}}" method="GET">
                                <div class="form-group mb-0">
                                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type voucher code & Enter') }}" onclick="formSubmit()">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <table class="table aiz-table mb-0">
                            <thead>
                            <tr>
                                <th width="15%">{{translate('Voucher Code')}}</th>
                                <th data-breakpoints="sm">{{translate('Used Limit')}}</th>
                                <th data-breakpoints="sm">{{translate('No Of Used')}}</th>
                                <th data-breakpoints="sm">{{translate('Amount')}}</th>
                                <th data-breakpoints="sm">{{translate('Creation Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($merchant_vouchers as $key => $voucher)
                                <tr>
                                    <td>{{$voucher->voucher_code}}</td>
                                    <td>{{$voucher->total_limit}}</td>
                                    <td>{{$voucher->used_count}}</td>
                                    <td>RM {{$voucher->amount}}</td>
                                    <td>{{ convert_datetime_to_local_timezone($voucher->created_at, user_timezone(Auth::id())) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="aiz-pagination">
                            {{ $merchant_vouchers->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function formSubmit(){
            if($("#search").val() != '') {
                $("#sort_merchants").submit();
            }
        }
    </script>

@endsection

