@extends('backend.layouts.app')
@section('title', translate('All products'))
@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col text-right">
            <a href="{{ route('product_bulk_upload.index', 'service') }}" class="btn btn-circle btn-primary mt-1">
                <span>{{ translate('Import Service CSV') }}</span>
            </a>
            <a href="{{ route('product_bulk_upload.index', 'tyre') }}" class="btn btn-circle btn-primary mt-1">
                <span>{{ translate('Import Tyre CSV') }}</span>
            </a>
            <a href="{{ route('export_csv', 'service') }}" class="btn btn-circle btn-primary mt-1">
                <span>{{ translate('Export Service Excel') }}</span>
            </a>
            <a href="{{ route('export_csv', 'tyre') }}" class="btn btn-circle btn-primary mt-1">
                <span>{{ translate('Export Tyre Excel') }}</span>
            </a>
            <a href="javascript:void(0)" class="btn btn-circle btn-info mt-1" data-toggle="modal" data-target="#images_add_modal">
                <span>{{ translate('Upload Images') }}</span>
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-circle btn-info mt-1">
                <span>{{ translate('Add New Product') }}</span>
            </a>
        </div>
    </div>
</div>
<br>
<h5 class="">{{ translate('All Product') }}</h5>

<div class="card">
    <form id="sort_products" action="" method="GET">
        <div class="card-header row gutters-6">

            <div class="dropdown mb-2 mb-md-0 col">
                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    {{ translate('Bulk Action') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="bulk_delete()">
                        {{ translate('Delete selection') }}</a>
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="tyre_brand_id" onchange="sort_products()">
                    <option value="">{{ translate('Tyre Brands') }}</option>
                    @foreach ($tyre_brands as $tyre_brand)
                    <option value="{{ $tyre_brand->id }}" @if($tyre_brand->id == $tyre_brand_id) selected @endif>
                        {{ $tyre_brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="cat_id" onchange="sort_products()">
                    <option value="">{{ translate('All Categories') }}</option>
                    @foreach ($categories as $key => $category)
                    <option value="{{ $category->id }}" @if($category->id == $category_id) selected @endif>
                        {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2" id="frontrear-ddl">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="front_rear" id="front_rear" onchange="sort_products()">
                    <option value="">{{ translate('Choose Front/Rear') }}</option>
                    <option value="front" @if($front_rear == "front") selected @endif>Front</option>
                    <option value="rear" @if($front_rear == "rear") selected @endif>Rear</option>
                    <option value="front/rear" @if($front_rear == "front/rear") selected @endif>Front/Rear</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="qty_filter" onchange="sort_products()">
                    <option value="">{{ translate('Filter By Quantity') }}</option>
                    <option value="low_qty" @if($qty_filter == 'low_qty') selected @endif>{{ translate('Low Quantity') }}</option>
                </select>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control form-control-sm" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th>
                        <!--<th data-breakpoints="lg">#</th>-->
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Tags') }}</th>
                        <th data-breakpoints="lg">{{ translate('Added By') }}</th>
                        <th data-breakpoints="sm">{{ translate('Info') }}</th>
                        <th data-breakpoints="md">{{ translate('Total Stock') }}</th>
                        <th data-breakpoints="lg">{{ translate('Published') }}</th>
                        <th data-breakpoints="lg">{{ translate('Featured') }}</th>
                        <th data-breakpoints="sm" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                    @if (isset($_GET['low_qty']) && $_GET['low_qty'] == 'low_qty' ? $product->qty <= $product->low_stock_quantity : $product)
                        <tr>
                            <!--<td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>-->
                            <td>
                                <div class="form-group d-inline-block">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-one" name="id[]" value="{{ $product->id }}">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="row gutters-5 w-200px w-md-300px mw-100">
                                    <div class="col-auto">
                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="Image" class="size-50px img-fit">
                                    </div>
                                    <div class="col">
                                        <span class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->tags }}</td>
                            <td>{{ $product->user->name }}</td>
                            <td>
                                <strong>{{ translate('Num of Sale') }}:</strong> {{ $product->num_of_sale }}
                                {{ translate('times') }} </br>
                                <strong>{{ translate('Cost Price') }}:</strong>
                                {{ single_price($product->cost_price) }} </br>
                                <strong>{{ translate('Base Price') }}:</strong>
                                {{ ($product->category_id == 1)?single_price($product->quantity_1_price):single_price($product->unit_price) }}
                            </td>
                            <td>
                                @php
                                echo $product->qty;
                                @endphp
                                @if ($product->qty <= $product->low_stock_quantity)
                                    <span class="badge badge-inline badge-danger">Low</span>
                                    @endif
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->published == 1) {
                                                    echo 'checked';
                                                } ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if ($product->featured == 1) {
                                                    echo 'checked';
                                                } ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-right">
                                {{-- <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  href="{{ route('product', $product->slug) }}" target="_blank" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                                </a> --}}
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('products.admin.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="{{ route('products.duplicate', ['id' => $product->id]) }}" title="{{ translate('Duplicate') }}">
                                    <i class="las la-copy"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('products.destroy', $product->id) }}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
@include('modals.delete_modal')

<div class="modal fade" id="images_add_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{ translate('Upload Products Image') }}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <form action="{{ route('products.image-upload') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label"
                        for="signinSrEmail">{{ translate('Thumbnail Image') }}
                        <small>(300x300)</small></label>
                    <div class="col-md-8">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="thumbnail_img" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <small
                            class="text-muted">{{ translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 140px;">
                    <label class="col-lg-3 control-label" for="name">{{ translate('Choose Products') }}</label>
                    <div class="col-lg-9">
                        <select class="form-control aiz-selectpicker" name="products[]"
                            data-selected-text-format="count" data-actions-box="true" data-live-search="true" multiple required>
                            @foreach ($products_without_imgs as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection


@section('script')
<script type="text/javascript">

    $(function(){

        @if($category_id == null || $category_id != 1)
        $('#frontrear-ddl').hide();
        @endif
    });
    $(document).on("change", ".check-all", function() {
        if (this.checked) {
            // Iterate each checkbox
            $('.check-one:checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.check-one:checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    function update_published(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('products.published') }}', {_token: '{{ csrf_token() }}', id: el.value, status: status},
            function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
    }

    function update_featured(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('products.featured') }}', {_token: '{{ csrf_token() }}', id: el.value, status: status},
         function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully ') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong ') }}');
                }
            });
    }

    function sort_products() {
        $('#sort_products').submit();
    }

    function bulk_delete() {
        var data = new FormData($('#sort_products')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('bulk-product-delete') }}",
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    location.reload();
                }
            }
        });
    }

</script>
@endsection
