@extends('backend.layouts.app')
@section('title', translate('Edit Group Products'))
@section('content')

    <div class="card">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Edit Group Products') }}</h5>
                </div>
                <div class="mb-2 mb-md-0">
                    <button class="btn btn-primary" type="button" onclick="update_group()">{{ translate('Update Group') }}</button>
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
            
            <form id="save_products" action="{{ route('products.group.update') }}" method="POST">
            @csrf
            <input type="hidden" name="group_id" value="{{ $id }}">
            <div class="card-body">
                @if(count($errors) > 0)
                        <div class="row ml-2 mt-1">
                            <div class="col-md-11">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="p-0 m-0" style="list-style: none;">
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            </div>
                            </div>
                        </div>
                        @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Group Name</label>
                            </div>
                            <div class="col-md-9">
                            <div class="form-group">
                                <input type="text" name="group_name" value="{{ $product_group->group_name }}" class="form-control" required>
                            </div>    
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ translate('Product Name') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label id="chk" class="aiz-checkbox">
                                            <input type="checkbox" class="check-one chkone{{ $product->id }}"
                                                name="products_id[]" value="{{ $product->id }}" {{ (in_array($product->id, $added_products))?'checked':'' }}>
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

                            </tr>
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

@section('script')
    <script type="text/javascript">
        function update_group() {
           $("#save_products").submit();
        }
    </script>
@endsection
