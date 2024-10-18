@extends('backend.layouts.app')
@section('title', translate('Size Alternative'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header row gutters-5">
                <h5 class="mb-md-0 h6">{{ translate('Size Alternative') }}</h5>
                <a class="btn btn-primary" href="{{ route('size_alternative.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('size_alternative.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Model') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <select name="model_id" id="model_id" class="form-control" required>
                                <option value="">--Select--</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}"
                                        {{ $data->model_id == $model->id ? 'selected' : '' }}>
                                        {{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                value="{{ $data->name }}" class="form-control" required>
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
