@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <form action="" method="GET" id="transaction_history">
                        <div class="card-header mr-0 row">
                        <div class="col-md-7 col-12">
                            <h5 class="mb-0 h6">{{ translate('QR Codes Download History') }}</h5>
                        </div>
                        <div class="col-md-4 col-8">
                            <div class="form-group mb-0">
                                <input style="height: calc(1.3125rem + 1.2rem + 2px);" type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & hit Enter') }}">
                            </div>
                        </div>
                        <div class="col-md-1 col-4">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                            </div>
                        </div>
                    </div>
                    </form>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table aiz-table">
                                <thead>
                                <tr>
                                    <th>{{ translate('Voucher Code')}}</th>
                                    <th>{{ translate('Download Date')}}</th>
                                    <th>{{ translate('Options')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($download_histories as $key => $history)
                                        <tr>
                                            <td>
                                                {{ $history->voucher_code }}
                                            </td>
                                            <td>
                                                {{ ($history->created_at) ? convert_datetime_to_local_timezone($history->created_at, user_timezone(Auth::id())) :'' }}
                                            </td>
                                            <td>
                                                <a href="javascript:voide(0)" data-toggle="modal" data-target="#viewAgainModel" onclick="viewQrcodeAgain({{$history->id}})" class="btn btn-primary" title="{{ translate('View Again') }}"><i class="fas fa-fw fa-download"></i> View Again
                                                </a>
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="ml-4">
                                {{ $download_histories->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
 
 <!--view again model   -->
 <div class="modal fade" id="viewAgainModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body d-flex justify-content-center" id="modal_body">
         
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>
    function viewQrcodeAgain(id)
    {
    $.post('{{ route('view-qrcode-again') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
        $("#modal_body").html(data);
    });
    }
</script>
@endsection

