@extends('backend.layouts.app')
@section('title', translate('Battery Sub Child Categories'))
@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Battery Sub Child Categories') }}</h5>
                    </div>
                    <div class="col-md-4">
                        <form id="sort_size_cats" action="" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="search"
                                    name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
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
                                <th>{{ translate('Sub Category') }}</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                    <td>{{ DB::table('battery_sub_category_translations')->select('name')->where('battery_sub_category_id', $category->parent_id)->first()->name }}</td>
                                    <td>{{ $category->getTranslation('name') }}</td>
                                    <td class="text-right d-flex">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1"
                                            href="{{ route('battery-sub-child-categories.edit', $category->id) }}?lang={{ env('DEFAULT_LANGUAGE', 'en') }}"
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('battery-sub-child-categories.show', $category->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $categories->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Category Information') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('battery-sub-child-categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="category">{{ translate('Category') }}</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">--Select--</option>
                                @foreach ($parent_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">{{ translate('Name') }}</label>
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
