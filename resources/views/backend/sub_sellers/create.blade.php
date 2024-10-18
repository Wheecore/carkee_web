@extends('backend.layouts.app')
@section('title', translate('Add New Sub Account'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Account Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('sub_sellers.index', $id) }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('sub_sellers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="seller_id" value="{{ $id }}">
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="email" placeholder="{{ translate('Email Address') }}" id="email"
                                name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{ translate('Password') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{ translate('Password') }}" id="password"
                                name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="signinSrEmail">{{ translate('Profile Image') }}
                            <small>(300x300)</small></label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="profile_img" class="selected-files">
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
