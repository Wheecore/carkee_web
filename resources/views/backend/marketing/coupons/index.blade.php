@extends('backend.layouts.app')
@section('title', translate('All Coupons'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <a href="{{ route('coupon.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Coupon') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Coupon Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table p-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Code') }}</th>
                            <th>{{ translate('Type') }}</th>
                            <th>{{ translate('Start Date') }}</th>
                            <th>{{ translate('End Date') }}</th>
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>
                                    @if ($coupon->type == 'cart_base')
                                        {{ translate('Cart Base') }}
                                    @elseif ($coupon->type == 'product_base')
                                        {{ translate('Product Base') }}
                                    @elseif ($coupon->type == 'gift_base')
                                        {{ translate('Gift Base') }}
                                    @elseif ($coupon->type == 'warranty_reward')
                                        {{ translate('Warranty Reward') }}
                                    @endif
                                </td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->start_date) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->end_date) }}</td>
                                <td class="text-right d-flex">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1"
                                        href="{{ route('coupon.edit', encrypt($coupon->id)) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('coupon.destroy', $coupon->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $coupons->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
