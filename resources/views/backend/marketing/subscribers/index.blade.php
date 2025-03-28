@extends('backend.layouts.app')
@section('title', translate('All Subscribers'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('All Subscribers') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $key => $subscriber)
                            <tr>
                                <td>{{ $key + 1 + ($subscribers->currentPage() - 1) * $subscribers->perPage() }}</td>
                                <td>
                                    <div class="text-truncate">{{ $subscriber->email }}</div>
                                </td>
                                <td>{{ convert_datetime_to_local_timezone($subscriber->created_at, user_timezone(Auth::id())) }}</td>
                                <td class="text-right">
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('subscriber.destroy', $subscriber->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix">
                <div class="pull-right">
                    {{ $subscribers->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
