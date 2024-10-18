@extends('backend.layouts.app')
@section('title', translate('All Groups'))
@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Group Name') }}</th>
                        <th width="10%" class="text-center">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product_groups as $key => $data)
                        <tr>
                            <td>{{ 1 + $key }}</td>
                            <td>{{ $data->group_name }}</td>
                            <td class="text-center" style="white-space: nowrap;">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{ route('group.products.edit', ['id' => $data->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                href="{{ route('products.group.details', ['id' => $data->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                title="{{ translate('view') }}">
                                <i class="las la-eye"></i>
                                </a>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('products.group.delete', $data->id) }}"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $product_groups->links() }}
            </div>
        </div>
    </div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection

