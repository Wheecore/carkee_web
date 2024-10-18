@extends('backend.layouts.app')
@section('title', translate('Profile'))
@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Profile') }}</h5>
            </div>
            <div class="card-body">
                @if(count($errors) > 0)
                    <div class="row ml-2 mt-1">
                        <div class="col-md-11">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul class="p-0 m-0" style="list-style: none;">
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('profile.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="{{ translate('Name') }}" name="name"
                                value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Email') }}</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" placeholder="{{ translate('Email') }}" name="email"
                                value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="new_password">{{ translate('New Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="{{ translate('New Password') }}"
                                name="new_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label"
                            for="confirm_password">{{ translate('Confirm Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" placeholder="{{ translate('Confirm Password') }}"
                                name="confirm_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Avatar') }}
                            <small>(90x90)</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="avatar" class="selected-files"
                                    value="{{ $user->avatar_original }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
