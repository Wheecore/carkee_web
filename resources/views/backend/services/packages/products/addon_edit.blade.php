@extends('backend.layouts.app')
@section('title', translate('Addon Products'))
@section('content')
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Addon Products') }}</h5>
            </div>
            <div class="mb-2 mb-md-0">
                <a class="btn btn-primary" href="javascript::void(0)" onclick="addUpdateProducts()">
                    {{ translate('Save Products') }}</a>
            </div>
            <div class="col-md-3">
                <form action="" method="GET">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('addorupdate.package.products') }}" method="post" id="products_form">
                @csrf
                <input type="hidden" name="package_id" value="{{ $id }}">
                <input type="hidden" name="type" value="Addon">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                            </th>
                            <th>{{ translate('Product Name') }}</th>
                            <th>{{ translate('Quantity') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label id="chk" class="aiz-checkbox">
                                            <input type="checkbox" class="check-one chkone{{ $product->id }}"
                                                name="product_id[]" value="{{ $product->id }}"
                                                {{ isset($products_data[$product->id]) ? 'checked' : '' }}>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="Image"
                                                class="size-50px img-fit">
                                        </div>
                                        <div class="col">
                                            <span
                                                class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="qty-container">
                                        <button class="qty-btn-minus" type="button"><i class="las la-minus"></i></button>
                                        <input type="number" name="qty_{{ $product->id }}" placeholder="1"
                                            value="{{ isset($products_data[$product->id]) ? $products_data[$product->id] : $product->min_qty }}"
                                            min="{{ $product->min_qty }}" max="{{ $product->qty }}" class="input-qty"
                                            readonly />
                                        <button class="qty-btn-plus" type="button"><i class="las la-plus"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            <div class="aiz-pagination">
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
        </form>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function addUpdateProducts() {
            $("#products_form").submit();
        }
    </script>
@endsection
