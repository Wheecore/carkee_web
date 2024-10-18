@extends('backend.layouts.app')
@section('title', translate('All Packages'))
@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col text-right">
            <a href="{{ route('packages.create') }}" class="btn btn-circle btn-info">
                <span>{{ translate('Add New Package') }}</span>
            </a>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row gutters-5">
                    <div class="col text-center text-md-left">
                        <h5 class="mb-md-0 h6">{{ translate('Packages') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <form class="" id="sort_packages" action="" method="GET">
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
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Type') }}</th>
                                <th>{{ translate('Logo') }}</th>
                                <th class="text-center">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $key => $package)
                                <tr>
                                    <td>{{ $key + 1 + ($packages->currentPage() - 1) * $packages->perPage() }}</td>
                                    <td>{{ $package->getTranslation('name') }}</td>
                                    <td>{{ ucfirst($package->type) }}</td>
                                    <td>
                                        <img src="{{ uploaded_asset($package->logo) }}" class="h-50px">
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-sm mb-1 btn-circle"
                                        href="{{ route('package.products.recommend.edit', ['id' => $package->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        target="_blank" title="{{ translate('Edit Package Products') }}">
                                        {{ translate('Edit Recommend Products') }}
                                        </a>
                                        <a class="btn btn-soft-primary btn-sm mb-1 btn-circle"
                                        href="{{ route('package.products.addon.edit', ['id' => $package->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        target="_blank" title="{{ translate('Edit Addon Products') }}">
                                        {{ translate('Edit Addon Products') }}
                                        </a>
                                        <a class="btn btn-soft-primary btn-sm mb-1 btn-circle btn-sm"
                                            href="{{ route('package.edit', ['id' => $package->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}">
                                            {{ translate('Edit') }}
                                        </a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('package.destroy', $package->id) }}">
                                            {{ translate('Delete') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $packages->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">

        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')

    <script type="text/javascript">
        function sort_packages(el) {
            $('#sort_packages').submit();
        }
    </script>

@endsection
