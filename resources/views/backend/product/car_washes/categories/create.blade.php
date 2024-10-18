@extends('backend.layouts.app')
@section('title', translate('Category Information'))
@section('css')

    <link rel="stylesheet" href="{{ static_asset('assets/css/color-picker.css') }}" />

@endsection
@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header row gutters-5">
                    <h5 class="mb-md-0 h6">{{ translate('Category Information') }}</h5>
                    <a class="btn btn-primary" href="{{ route('car-washes-categories.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                </div>
                @include('backend.inc.error')
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('car-washes-categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }}</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Color Code') }}</label>
                            <div class="col-md-9">
                                <div class="input-group colorpicker-component">
                                    <input type="text" name="color_code" value="#00AABB" data-picker="WKCP" class="form-control"/>
                                    <span class="input-group-addon"></span>
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
    </div>

@endsection
@section('script')

    <script src="{{ static_asset('assets/js/color-picker.js') }}"></script>

@endsection
