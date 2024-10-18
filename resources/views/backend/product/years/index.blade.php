@extends('backend.layouts.app')
@section('title', translate('Car Years'))
@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Car Years') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_details" action="" method="GET">
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
                                <th>{{ translate('year') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($years as $key => $year)
                                <tr>
                                    <td>{{ $key + 1 + ($years->currentPage() - 1) * $years->perPage() }}</td>
                                    <td>
                                        {{ $year->brand_name }}
                                    </td>
                                    <td>
                                        {{ $year->model_name }}
                                    </td>
                                    <td>{{ $year->getTranslation('name') }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('years.edit', ['id' => $year->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('years.destroy', $year->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $years->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New Year') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('years.store') }}" method="POST">
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
                            <select name="model_id" id="model_id" class="form-control" required>
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Years') }}</label>
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
