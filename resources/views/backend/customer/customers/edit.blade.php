@extends('backend.layouts.app')
@section('title', translate('Edit Customer'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Customer') }}</h5>
                <a class="btn btn-primary" href="{{ route('customers.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>

            <div class="card-body">
                <form action="{{ route('customers.update', encrypt($user->id)) }}" method="POST">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label">{{ translate('Email Address') }}<span
                                class="text-danger text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="email" class="form-control mb-3" placeholder="{{ translate('Email Address') }}"
                                name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Primary Phone') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="{{ translate('Primary Phone') }}"
                                name="phone" value="{{ $user->phone }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Secondary Phone') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="{{ translate('Secondary Phone') }}"
                                name="phone2" value="{{ $user->phone2 }}">
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
