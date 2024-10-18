@extends('backend.layouts.app')
@section('title', translate('Category Information'))
@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header row gutters-5">
                    <h5 class="mb-md-0 h6">{{ translate('Category Information') }}</h5>
                    <a class="btn btn-primary" href="{{ route('service-sub-categories.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                </div>
                <div class="card-body p-0">
                    <form class="p-4" action="{{ route('service-sub-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $category->getTranslation('name', $lang) }}" class="form-control" id="name" placeholder="{{ translate('Name') }}" required>
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
