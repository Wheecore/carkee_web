@extends('admin.layouts.master')

@section('content')
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">{{ __('custom.edit_invoice') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="ic-javascriptVoid">{{ __('custom.invoice') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('custom.edit_invoice') }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <invoice-edit :invoice="{{ json_encode($invoice) }}" default_tax="{{ getDefaultTax() }}"
                                  app_name="{{ config('app.name') }}" :user="{{ auth()->user() }}"
                                  :all_status="{{ json_encode($all_status) }}"
                                  :customers="{{ json_encode($customers) }}"
                                  :product_stocks="{{ json_encode($product_stocks) }}" :categories="{{ json_encode($categories) }}"
                                  :warehouse_id="{{ $warehouse->id }}"
                                  :currency_symbol="{{ json_encode(currencySymbol()) }}">
                    </invoice-edit>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')

@endpush

@push('script')

@endpush
