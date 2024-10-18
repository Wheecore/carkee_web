@extends('backend.layouts.app')
@section('title', translate('Car Variants'))
@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Car Variants') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_years" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search" name="search"
                                    @isset($sort_search) value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type name & Enter') }}">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Brand') }}</th>
                                <th>{{ translate('Model') }}</th>
                                <th>{{ translate('Year') }}</th>
                                <th>{{ translate('Variant') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variants as $key => $variant)
                                    <tr>
                                        <td>{{ $key + 1 + ($variants->currentPage() - 1) * $variants->perPage() }}</td>
                                        <td>
                                            {{ $variant->brand_name }}
                                        </td>
                                        <td>
                                            {{ $variant->model_name }}
                                        </td>
                                        <td>
                                            {{ $variant->year_name }}
                                        </td>
                                        <td>{{ $variant->getTranslation('name') }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('variants.edit', ['id' => $variant->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                data-href="{{ route('variants.destroy', $variant->id) }}"
                                                title="{{ translate('Delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $variants->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New Car Variant') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('variants.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Select Brand') }}</label>
                            <select name="brand_id" id="brand_id" class="form-control" onchange="models()" required>
                                <option value="">--select--</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Select Model') }}</label>
                            <select name="model_id" id="model_id" class="form-control" onchange="years()" required>
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Select Car Year') }}</label>
                            <select name="year_id" id="year_id" class="form-control">
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Car Variant') }}</label>
                            <input type="text" placeholder="{{ translate('Name') }}" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
