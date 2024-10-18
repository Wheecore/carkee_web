@extends('backend.layouts.app')
@section('title', translate('All Deals'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <a href="{{ route('deals.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Create New Deal') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('All Deals') }}</h5>
            <div class="pull-right clearfix">
                <form class="" id="sort_deals" action="" method="GET">
                    <div class="box-inline pad-rgt pull-left">
                        <div class="" style="min-width: 200px;">
                            <input type="text" class="form-control" id="search" name="search"
                                @isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type name & Enter') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Title') }}</th>
                            <th>{{ translate('Banner') }}</th>
                            <th>{{ translate('Start Date') }}</th>
                            <th>{{ translate('End Date') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Type') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deals as $key => $deal)
                            <tr>
                                <td>{{ $key + 1 + ($deals->currentPage() - 1) * $deals->perPage() }}</td>
                                <td>{{ $deal->getTranslation('title') }}</td>
                                <td><img src="{{ uploaded_asset($deal->banner) }}" alt="banner" class="h-50px">
                                </td>
                                <td>{{ date(env('DATE_FORMAT'), $deal->start_date) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $deal->end_date) }}</td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_deal_status(this)" value="{{ $deal->id }}"
                                            type="checkbox" <?php if ($deal->status == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td>{{ ucfirst(str_replace("_"," ",$deal->type)) }}</td>
                                <td class="text-right d-flex">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1"
                                        href="{{ route('deals.edit', ['id' => $deal->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('deals.destroy', $deal->id) }}"
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
                    {{ $deals->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function update_deal_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('deals.update_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    location.reload();
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
