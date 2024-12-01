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
                <div class="card-body">
                    <form action="{{ route('deals.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name">{{ translate('Title') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Title') }}" id="name" name="title"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 control-label" for="name">{{ translate('Text Color') }}</label>
                            <div class="col-lg-9">
                                <select name="text_color" id="text_color" class="form-control aiz-selectpicker" required>
                                    <option value="">{{ translate('Select One') }}</option>
                                    <option value="white">{{ translate('White') }}</option>
                                    <option value="dark">{{ translate('Dark') }}</option>
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
                                    <input type="hidden" name="banner" class="selected-files">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                                <span
                                    class="small text-muted">{{ translate('This image is shown as cover banner in today deal details page.') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="start_date">{{ translate('Date') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control aiz-date-range" name="date_range"
                                    placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                    data-separator=" to " autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 control-label" for="products">{{ translate('Deal Type') }}</label>
                            <div class="col-sm-9">
                                <select name="type" id="deal_type" class="form-control" required>
                                    <option value="today">{{ translate('Today') }}</option>
                                    <option value="tyre">{{ translate('Tyre') }}</option>
                                    <option value="service">{{ translate('Service') }}</option>
                                    <option value="car_wash">{{ translate('Car Wash') }}</option>
                                    <option value="membership">{{ translate('Reward') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3" id="today_tyre_products">
                            <label class="col-sm-3 control-label" for="products">{{ translate('Products') }}</label>
                            <div class="col-sm-9">
                                <select name="products[]" id="products" class="form-control aiz-selectpicker"
                                    data-placeholder="{{ translate('Choose Products') }}" data-live-search="true"
                                    data-selected-text-format="count" multiple>
                                    @foreach (\App\Models\Product::orderBy('created_at', 'desc')->whereIn('category_id', [1, 5])->select('id', 'name')->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3" id="car_wash_products" style="display: none">
                            <label class="col-sm-3 control-label" for="products">{{ translate('Products') }}</label>
                            <div class="col-sm-9">
                                <select name="carwash_products[]" id="carwash_products" class="form-control aiz-selectpicker"
                                    data-placeholder="{{ translate('Choose Products') }}" data-live-search="true"
                                    data-selected-text-format="count" multiple>
                                    @foreach (\App\Models\CarWashProduct::orderBy('created_at', 'desc')->whereIn('ptype',['O','M'])->select('id', 'name')->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}
                                        </option>
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
            $('#products').on('change', function() {
                var product_ids = $('#products').val();
                if (product_ids.length > 0) {
                    $.post('{{ route('deals.product_discount') }}', {
                        _token: '{{ csrf_token() }}',
                        product_ids: product_ids
                    }, function(data) {
                        $('#discount_table').html(data);
                        AIZ.plugins.fooTable();
                    });
                } else {
                    $('#discount_table').html(null);
                }
            });

            $('#deal_type').on('change', function() {
                if($(this).val() == 'today' || $(this).val() == 'tyre'){
                    $("#today_tyre_products").show();
                    $("#car_wash_products").hide();
                    $("#discount_alert").show();
                }
                if($(this).val() == 'service'){
                    $("#today_tyre_products").hide();
                    $("#car_wash_products").hide();
                    $("#discount_alert").hide();
                }
                if($(this).val() == 'car_wash'){
                    $("#today_tyre_products").hide();
                    $("#car_wash_products").show();
                    $("#discount_alert").hide();
                }
            });
        });

    </script>
@endsection
