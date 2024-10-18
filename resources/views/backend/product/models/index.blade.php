@extends('backend.layouts.app')
@section('title', translate('Car Models'))
@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Car Models') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form class="" id="sort_modals" action="" method="GET">
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
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Type') }}</th>
                                <th class="text-right">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $key => $model)
                                <tr>
                                    <td>{{ $key + 1 + ($models->currentPage() - 1) * $models->perPage() }}</td>
                                    <td>{{ $model->brand_name }}</td>
                                    <td>{{ $model->getTranslation('name') }}</td>
                                    <td>{{ str_replace("_"," ", $model->type) }}</td>
                                    <td class="text-right">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('models.edit', ['id' => $model->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('models.destroy', $model->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $models->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Add New Model') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('models.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Select Brand') }}</label>
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                <option value="">-- {{ translate('Select') }} --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Name') }}</label>
                            <input type="text" placeholder="{{ translate('Name') }}" name="name" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Type') }}</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">-- {{ translate('Select') }} --</option>
                                <option value="MPV" {{ old('type') == 'MPV' ? 'selected' : '' }}>
                                    {{ translate('MPV') }}
                                </option>
                                <option value="Standard_Sedan" {{ old('type') == 'Standard_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Standard Sedan') }}
                                </option>
                                <option value="Executive_Sedan" {{ old('type') == 'Executive_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Executive Sedan') }}
                                </option>
                                <option value="SUV" {{ old('type') == 'SUV' ? 'selected' : '' }}>
                                    {{ translate('SUV') }}
                                </option>
                                <option value="4X4" {{ old('type') == '4X4' ? 'selected' : '' }}>
                                    {{ translate('4X4') }}
                                </option>
                                <option value="B-segment" {{ old('type') == 'B-segment' ? 'selected' : '' }}>
                                    {{ translate('B-segment') }}
                                </option>
                                <option value="Super_Sedan" {{ old('type') == 'Super_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Super Sedan') }}
                                </option>
                                <option value="Sportscar" {{ old('type') == 'Sportscar' ? 'selected' : '' }}>
                                    {{ translate('Sportscar') }}
                                </option>
                            </select>
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
