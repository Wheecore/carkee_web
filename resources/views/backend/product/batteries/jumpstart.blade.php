@extends('backend.layouts.app')
@section('title', translate('Jumpstart'))
@section('content')

    <form class="form form-horizontal mar-top" action="{{ route('battery.saveOrUpdate') }}" method="POST" id="choice_form">
        <div class="row gutters-5">
            <div class="offset-1 col-lg-10 col-md-10 col-11">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Jumpstart') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Price') }}</label>
                            <div class="col-md-6">
                                <input type="number" min="0" value="{{ $data ? $data->amount : 0 }}" step="0.01"
                                    placeholder="{{ translate('Price') }}" name="amount" class="form-control">
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

@endsection
