@extends('backend.layouts.app')
@section('title', translate('Model Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Model Information') }}</h5>
            <a class="btn btn-primary" href="{{ route('models.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('models.update', $model->id) }}" method="POST">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Select Brand') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <select name="brand_id" id="brand_id" class="form-control" required>
                                <option value="">--select--</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ $brand->id == $model->brand_id ? 'selected' : '' }}>{{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                value="{{ $model->getTranslation('name', $lang) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="type">{{ translate('Type') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <select id="type" name="type" class="form-control" required>
                                <option value="">-- {{ translate('Select') }} --</option>
                                <option value="MPV" {{ $model->type == 'MPV' ? 'selected' : '' }}>
                                    {{ translate('MPV') }}
                                </option>
                                <option value="Standard_Sedan" {{ $model->type == 'Standard_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Standard Sedan') }}
                                </option>
                                <option value="Executive_Sedan" {{ $model->type == 'Executive_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Executive Sedan') }}
                                </option>
                                <option value="SUV" {{ $model->type == 'SUV' ? 'selected' : '' }}>
                                    {{ translate('SUV') }}
                                </option>
                                <option value="4X4" {{ $model->type == '4X4' ? 'selected' : '' }}>
                                    {{ translate('4X4') }}
                                </option>
                                <option value="B-segment" {{ $model->type == 'B-segment' ? 'selected' : '' }}>
                                    {{ translate('B-segment') }}
                                </option>
                                <option value="Super_Sedan" {{ $model->type == 'Super_Sedan' ? 'selected' : '' }}>
                                    {{ translate('Super Sedan') }}
                                </option>
                                <option value="Sportscar" {{ $model->type == 'Sportscar' ? 'selected' : '' }}>
                                    {{ translate('Sportscar') }}
                                </option>
                            </select>
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
