@extends('backend.layouts.app')
@section('title', translate('Category Information'))
@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header row gutters-5">
                    <h5 class="mb-md-0 h6">{{ translate('Category Information') }}</h5>
                    <a class="btn btn-primary" href="{{ route('categories.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                </div>
                <div class="card-body p-0">
                    <form class="p-4" action="{{ route('categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" name="lang" value="{{ $lang }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Name') }} <i
                                    class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $category->getTranslation('name', $lang) }}"
                                    class="form-control" placeholder="{{ translate('Name') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Icon') }}
                                <small>({{ translate('32x32') }})</small></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="icon" class="selected-files"
                                        value="{{ $category->icon }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Title') }}</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="meta_title"
                                    value="{{ $category->meta_title }}" placeholder="{{ translate('Meta Title') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Meta Description') }}</label>
                            <div class="col-md-9">
                                <textarea name="meta_description" rows="5" class="form-control">{{ $category->meta_description }}</textarea>
                            </div>
                        </div>
                        @if (get_setting('category_wise_commission') == 1)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Commission Rate') }}</label>
                                <div class="col-md-9 input-group">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        id="commision_rate" name="commision_rate"
                                        value="{{ $category->commision_rate }}" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
