@extends('backend.layouts.app')
@section('title', translate('Refferal Users'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Refferal Users') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Email Address') }}</th>
                        <th>{{ translate('Reffered By') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($refferal_users as $key => $refferal_user)
                        @if ($refferal_user != null)
                            <tr>
                                <td>{{ $key + 1 + ($refferal_users->currentPage() - 1) * $refferal_users->perPage() }}</td>
                                <td>{{ $refferal_user->name }}</td>
                                <td>{{ $refferal_user->phone }}</td>
                                <td>{{ $refferal_user->email }}</td>
                                <td>
                                    @php 
                                      $refered_user = \App\User::find($refferal_user->referred_by);
                                    @endphp
                                        {{ ($refered_user)?$refered_user->name .'('.$refered_user->email.')':'' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $refferal_users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
