@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                <div class="card-header row">
                    <div class="col-md-8 col-12">
                      <h5 class="h5">{{translate('Customer Feedback List')}}</h5>
                    </div>
                    <div class="col-md-4 col-12 ml-auto">
                   <form action="" id="sort_orders" method="GET">
                        <div class="form-group mb-0">
                            <select name="search" id="search" class="form-control" onchange="callFun()">
                                <option value="">-FILTER BY STAR-</option>
                                <option value="1" {{ isset($_GET['search']) && $_GET['search'] == '1'? 'selected' :'' }}>1</option>
                                <option value="2" {{ isset($_GET['search']) && $_GET['search'] == '2'? 'selected' :'' }}>2</option>
                                <option value="3" {{ isset($_GET['search']) && $_GET['search'] == '3'? 'selected' :'' }}>3</option>
                                <option value="4" {{ isset($_GET['search']) && $_GET['search'] == '4'? 'selected' :'' }}>4</option>
                                <option value="5" {{ isset($_GET['search']) && $_GET['search'] == '5'? 'selected' :'' }}>5</option>
                            </select>
                        </div>
                </form>
                </div>
                </div>

                    <div class="card-body mt-2">
                        <div class="table-responsive">
                        <table class="table aiz-table mb-0">
                            <thead>
                            <tr>
                                <th>{{translate('Customer Name')}}</th>
                                <th>{{translate('Order Code')}}</th>
                                <th>{{translate('Car Plate')}}</th>
                                <th>{{translate('Car Model')}}</th>
                                <th data-breakpoints="lg">{{translate('Description')}}</th>
                                <th>{{translate('Rated')}}</th>
                                <!--<th>{{translate('Delete')}}</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $key => $review)
                                    <tr>
                                        <td>{{$review->name}}</td>
                                        <td>{{$review->code}}</td>
                                        <td>{{$review->car_plate}}</td>
                                        <td>{{$review->model_name}}</td>
                                        <td>{{$review->description}}</td>
                                        <td>{{$review->score}} <i class="la la-star" style="color: #0162dd;"></i></td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                       {{ $reviews->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script>
function callFun(){
   $('#sort_orders').submit();
}
</script>
@endsection
