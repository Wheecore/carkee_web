@extends('backend.layouts.app')
@section('title', translate('Message To Customers'))
@section('content')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Message To Customers') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('message-to-customers.send') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Select Customers') }}</label>
                            <div class="col-sm-10">
                                <select class="form-control aiz-selectpicker" name="user_emails[]" multiple
                                    data-selected-text-format="count" data-actions-box="true" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label"
                                for="name">{{ translate('Message') }}</label>
                            <div class="col-sm-10">
                                <textarea rows="8" class="form-control aiz-text-editor"
                                    data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]], ["insert", ["link", "picture"]],["view", ["undo","redo"]]]'
                                    name="content" required></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
