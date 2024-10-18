@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Roles') }}</h1>
            </div>
            @php
                $permissions = (Auth::user()->staff) ? Auth::user()->staff->role->permissions : '';
                $permissions = ($permissions != '')?json_decode($permissions):[];
            @endphp
            @if (Auth::user()->user_type == 'admin' || (in_array(67, $permissions)))
                <div class="col-md-6 text-md-right">
                    <a href="{{ route('roles.create') }}" class="btn btn-circle btn-info">
                        <span>{{ translate('Add New Role') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('All Roles') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table">
                <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th width="10%">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ $key + 1 + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                            <td>{{ $role->getTranslation('name') }}</td>
                            <td class="text-right d-flex">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1"
                                    href="{{ route('roles.edit', ['id' => $role->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('roles.destroy', $role->id) }}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $roles->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
