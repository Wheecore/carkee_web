@extends('backend.layouts.app')
@section('title', translate('Part Type Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Part Type Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('part-types.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('part-types.update', $part_type->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                value="{{ $part_type->getTranslation('name', $lang) }}" class="form-control" required>
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
