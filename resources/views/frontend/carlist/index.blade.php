@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Car List') }}</h5>
                        <a href="{{ route('carlist.create') }}" class="btn btn-primary">Add Car list</a>
                    </div>
                    @if (count($lists) > 0)
                        <div class="card-body">
                            <table class="table aiz-table mb-0">
                                <thead>
                                <tr>
                                    {{--                        <th>{{ translate('Category')}}</th>--}}
                                    <th>{{ translate('Brand')}}</th>
                                    <th>{{ translate('Model')}}</th>
                                    <th>{{ translate('Details')}}</th>
                                    <th>{{ translate('Year')}}</th>
                                    <th>{{ translate('Varients')}}</th>
                                    <th class="text-right">{{ translate('Options')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($lists as $key => $list)
                                    <?php
                                    $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                    $model = \App\CarModel::where('id', $list->model_id)->first();
                                    $details = \App\CarDetail::where('id', $list->details_id)->first();
                                    $year = \App\CarYear::where('id', $list->year_id)->first();
                                    $type = \App\CarType::where('id', $list->type_id)->first();
                                    ?>
                                    <tr>
                                        {{--                                <td>{{ $category?$category->name:'--' }}</td>--}}
                                        <td>{{ $brand?$brand->name:'--' }}</td>
                                        <td>{{ $model?$model->name:'--' }}</td>
                                        <td>{{ $details?$details->name:'--' }}</td>
                                        <td>{{ $year?$year->name:'--' }}</td>
                                        <td>{{ $type?$type->name:'--' }}</td>

                                        <td class="text-right">
                                            <a href="{{route('carlist.orders', $list->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('view') }}">
                                                <i class="las la-eye"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('carlist.destroy', $list->id)}}" title="{{ translate('Cancel') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="aiz-pagination">
                                {{--                    {{ $lists->links() }}--}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- delete Modal -->
    <div id="delete-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{translate('Delete Confirmation')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{route('carlist.destroy', $list->id)}}">
                    @csrf
                <div class="modal-body text-center">
                    <select name="reason" id="" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>

                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" id="delete-link" class="btn btn-primary mt-2">{{translate('Delete')}}</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->


    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function () {
            location.reload();
        })
    </script>
@endsection
