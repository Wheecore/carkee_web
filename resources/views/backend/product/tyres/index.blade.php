@extends('backend.layouts.app')
@section('title', translate('Spare Tyre'))
@section('content')

    <div class="card-body">
        <form class="form form-horizontal mar-top" action="{{ route('tyres.spare-tyre.saveorupdate') }}" method="POST"
            id="choice_form">
            <div class="row gutters-5">
                <div class="offset-1 col-lg-10 col-md-10 col-11">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Spare Tyre') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-lg-4 col-from-label">{{ translate('Tyre  Name') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Tyre Name') }}" value="{{ $tyre ? $tyre->name : '' }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-from-label">{{ translate('Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-8">
                                    <input type="number" step="0.01" class="form-control" name="amount"
                                        placeholder="{{ translate('Price') }}" value="{{ $tyre ? $tyre->amount : '' }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 mt-5" role="toolbar" aria-label="Toolbar with button groups"
                                    style="text-align: center;">
                                    <button type="submit" name="button" value="publish"
                                        class="btn btn-success">{{ translate('Update Data') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
