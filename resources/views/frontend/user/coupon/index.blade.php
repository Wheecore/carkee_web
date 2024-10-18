@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ translate('Code') }}</h5>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table aiz-table">
                                <thead>
                                <tr>
                                    <th data-breakpoints="md">{{ translate('No')}}</th>
                                    <th data-breakpoints="md">{{ translate('Referral Name')}}</th>
                                    <th data-breakpoints="md">{{ translate('Referred Name')}}</th>
                                    <th data-breakpoints="md">{{ translate('Coupon')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($coupons as $key => $coupon)
                                    <?php
                                    $user = \App\User::where('id', Auth::id())->first();
                                    $referral = \App\User::where('id',$user->referred_by)->first();
                                    ?>
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            {{ $referral?$referral->name:'' }}
                                        </td>
                                        <td>
                                            {{ Auth::user()->name }}
                                        </td>
                                        <td>
                                            {{ $coupon->code }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
