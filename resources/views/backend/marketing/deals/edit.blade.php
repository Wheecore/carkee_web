@extends('backend.layouts.app')
@section('title', translate('Deal Information'))
@section('content')

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Deal Information') }}</h5>
                    <a class="btn btn-primary" href="{{ route('deals.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                </div>
                <div class="card-body p-0">
                    <form class="p-4" action="{{ route('deals.update', $deal->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="name">{{ translate('Title') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Title') }}" id="name" name="title"
                                    value="{{ $deal->getTranslation('title', $lang) }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-from-label" for="text_color">{{ translate('Text Color') }}</label>
                            <div class="col-lg-9">
                                <select name="text_color" id="text_color" class="form-control demo-select2" required>
                                    <option value="">Select One</option>
                                    <option value="white" @if ($deal->text_color == 'white') selected @endif>
                                        {{ translate('White') }}</option>
                                    <option value="dark" @if ($deal->text_color == 'dark') selected @endif>
                                        {{ translate('Dark') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Banner') }}
                                <small>(1920x500)</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="banner" value="{{ $deal->banner }}"
                                        class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>

                        @php
                            $start_date = date('d-m-Y H:i:s', $deal->start_date);
                            $end_date = date('d-m-Y H:i:s', $deal->end_date);
                        @endphp

                        <div class="form-group row">
                            <label class="col-sm-3 col-from-label" for="start_date">{{ translate('Date') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control aiz-date-range"
                                    value="{{ $start_date . ' to ' . $end_date }}" name="date_range" placeholder="Select Date"
                                    data-time-picker="true" data-format="DD-MM-Y HH:mm:ss" data-separator=" to "
                                    autocomplete="off" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-sm-3 control-label" for="products">{{ translate('Deal Type') }}</label>
                            <div class="col-sm-9">
                                <select name="type" id="deal_type" class="form-control" required>
                                    <option value="today" {{ ($deal->type == 'today')?'selected':'' }}>{{ translate('Today') }}</option>
                                    <option value="tyre" {{ ($deal->type == 'tyre')?'selected':'' }}>{{ translate('Tyre') }}</option>
                                    <option value="service" {{ ($deal->type == 'service')?'selected':'' }}>{{ translate('Service') }}</option>
                                    <option value="car_wash" {{ ($deal->type == 'car_wash')?'selected':'' }}>{{ translate('Car Wash') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="today_tyre_products">
                            <label class="col-sm-3 col-from-label" for="products">{{ translate('Products') }}</label>
                            <div class="col-sm-9">
                                <select name="products[]" id="products" class="form-control aiz-selectpicker"
                                    data-placeholder="{{ translate('Choose Products') }}" data-live-search="true"
                                    data-selected-text-format="count" multiple>
                                    @foreach (\App\Models\Product::orderBy('created_at', 'desc')->whereIn('category_id', [1, 5])->select('id', 'name')->get() as $product)
                                        @php
                                            $deal_product = DB::table('deal_products')->where('deal_id', $deal->id)
                                            ->where('product_id', $product->id)
                                            ->first();
                                        @endphp
                                        <option value="{{ $product->id }}" {{ ($deal_product)?'selected':''}}>{{ $product->getTranslation('name') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="car_wash_products">
                            <label class="col-sm-3 col-from-label" for="carwash_products">{{ translate('Products') }}</label>
                            <div class="col-sm-9">
                                <select name="carwash_products[]" id="carwash_products" class="form-control aiz-selectpicker"
                                    data-placeholder="{{ translate('Choose Products') }}" data-live-search="true"
                                    data-selected-text-format="count" multiple>
                                    @foreach (\App\Models\CarWashProduct::orderBy('created_at', 'desc')->whereIn('ptype',['O','M'])->select('id', 'name')->get() as $product)
                                        @php
                                            $deal_product = DB::table('deal_products')->where('deal_id', $deal->id)
                                            ->where('product_id', $product->id)
                                            ->first();
                                        @endphp
                                        <option value="{{ $product->id }}" {{ ($deal_product)?'selected':''}}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-danger" id="discount_alert">
                        {{ translate('If any product has discount or exists in another today deal, the discount will be replaced by this discount & time limit.') }}
                        </div>

                        <br>
                        <div class="form-group" id="discount_table">

                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            if($("#deal_type").val() == 'today' || $("#deal_type").val() == 'tyre'){
                get_deal_discount();
            }
            deals();

            $('#products').on('change', function() {
                get_deal_discount();
            });
            $('#deal_type').on('change', function() {
                deals();
            });

            function get_deal_discount() {
                var product_ids = $('#products').val();
                if (product_ids.length > 0) {
                    $.post('{{ route('deals.product_discount_edit') }}', {
                        _token: '{{ csrf_token() }}',
                        product_ids: product_ids,
                        deal_id: {{ $deal->id }}
                    }, function(data) {
                        $('#discount_table').html(data);
                        AIZ.plugins.fooTable();
                    });
                } else {
                    $('#discount_table').html(null);
                }
            }

            function deals(){
                var deal_value = $("#deal_type").val();
                if(deal_value == 'today' || deal_value == 'tyre'){
                    $("#today_tyre_products").show();
                    $("#car_wash_products").hide();
                    $("#discount_alert").show();
                }
                if(deal_value == 'service'){
                    $("#today_tyre_products").hide();
                    $("#car_wash_products").hide();
                    $("#discount_alert").hide();
                }
                if(deal_value == 'car_wash'){
                    $("#today_tyre_products").hide();
                    $("#car_wash_products").show();
                    $("#discount_alert").hide();
                }
            }
        });
    </script>
@endsection
