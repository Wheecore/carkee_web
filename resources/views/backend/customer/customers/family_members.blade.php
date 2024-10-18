@extends('backend.layouts.app')
@section('title', translate('Family Members'))
@section('content')
<style>
    .emails_list{
        list-style-type: none;
        background: #f0f8ff;
        padding-left: 3px;
        padding-top: 7px;
        padding-bottom: 7px;
        display: none;
    }
    .emails_list li{
        margin-bottom: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .emails_list li:hover{
        background: #f4f0f0;
    }
</style>
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ $current_user->name }} {{ translate('Family Members') }}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="#" data-toggle="modal" data-target="#user_add_modal" class="btn btn-circle btn-info">
                <span>{{ translate('Add New Member') }}</span>
            </a>
        </div>
    </div>
</div>
    <div class="card">
        <form action="" id="sort_users" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-0 h6">{{ $current_user->name }} {{ translate('Family Members') }}</h5>
                </div>
                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ translate('Bulk Action') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"
                            onclick="bulk_delete()">{{ translate('Delete selection') }}</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th>{{ translate('User Image') }}</th>
                            <th>{{ translate('User Name') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $user->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ $user->thumbnail_image }}" alt="" style="width: 90px;max-height: 60px;">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td style="white-space: nowrap">
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('customers.remove_member', $user->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                <div class="aiz-pagination">
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modal')
<div class="modal fade" id="user_add_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{ translate('Add Member') }}</h5>
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="user_email" class="form-control">
                <ul class="emails_list"></ul>
                <p style="color: red; display: none" id="error" class="mt-2"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                <a type="button" id="confirmation" class="btn btn-primary">{{ translate('Add') }}</a>
            </div>
        </div>
    </div>
</div>

@include('modals.delete_modal')
@endsection
@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });
 
        $("#user_email").keyup(function(){
            $("#error").hide();
            var email = $(this).val();
            var user_id = '{{ $current_user->id }}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('customers.show_user_emails') }}",
                type: 'POST',
                data: jQuery.param({ email: email, user_id : user_id}),
                cache: false,
                success: function(response) {
                if(response != ''){
                   $(".emails_list").show();
                   $(".emails_list").html(response);
                }
                }
            });
        });

        $("#confirmation").click(function(){
            var email = $("#user_email").val();
            if(email == ''){
             alert('Please select an email first');
             return false;
            }
            var user_id = '{{ $current_user->id }}';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('customers.add_member') }}",
                type: 'POST',
                data: jQuery.param({ email: email, user_id : user_id}),
                cache: false,
                success: function(response) {
                if(response['result'] == false){
                   $("#error").show();
                   $("#error").html(response['message']);
                }
                else{
                   $("#error").hide();
                   location.reload();
                }
                }
            });
        });

        function putvalue(el)
        {
            $("#user_email").val($(el).text());
        }

        function bulk_delete() {
            var data = new FormData($('#sort_users')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('customers.bulk_remove_member') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
