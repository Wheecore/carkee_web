@extends('backend.layouts.app')
@section('title', translate('Packages Reviews'))
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row flex-grow-1">
                <div class="col">
                    <h5 class="mb-0 h6">{{ translate('Packages Reviews') }}</h5>
                </div>
                <div class="col-md-6 col-xl-4 ml-auto mr-0">
                    <form id="sort_by_rating" action="" method="GET">
                        <div style="min-width: 200px;">
                            <select class="form-control aiz-selectpicker" name="rating" id="rating"
                                onchange="filter_by_rating()">
                                <option value="">{{ translate('Filter by Rating') }}</option>
                                <option value="rating_desc">{{ translate('Rating (High > Low)') }}</option>
                                <option value="rating_asc">{{ translate('Rating (Low > High)') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Customer') }}</th>
                            <th>{{ translate('WorkShop') }}</th>
                            <th>{{ translate('Order Code') }}</th>
                            <th>{{ translate('Package Name') }}</th>
                            <th>{{ translate('Rating') }}</th>
                            <th>{{ translate('Comment') }}</th>
                            <th>{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $key => $review)
                            <tr>
                                <td>{{ $key + 1 + ($reviews->currentPage() - 1) * $reviews->perPage() }}</td>
                                <td>{{ $review->user }}</td>
                                <td>{{ $review->seller }}</td>
                                <td>{{ $review->code }}</td>
                                <td>{{ translate('Package') }}</td>
                                <td>{{ $review->rating }} <i class="las la-star aiz-side-nav-icon"></i></td>
                                <td>{{ $review->description }}</td>
                                <td>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('package-review.destroy', $review->id) }}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="aiz-pagination">
                {{ $reviews->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
@section('modal')
@include('modals.delete_modal')
@endsection
@section('script')
    <script type="text/javascript">
        function filter_by_rating(el) {
            var rating = $('#rating').val();
            if (rating != '') {
                $('#sort_by_rating').submit();
            }
        }
    </script>
@endsection
