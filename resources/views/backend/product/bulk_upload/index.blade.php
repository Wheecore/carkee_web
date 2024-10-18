@extends('backend.layouts.app')
@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate(ucfirst($type).' Products Bulk Upload')}}</h5>
        <a class="btn btn-primary" href="{{ route('products.all') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
    </div>
    <div class="card-body">
        <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
            <strong>{{ translate('Step 1')}}:</strong>
            <p>1. {{translate('Download the skeleton file and fill it with proper data')}}.</p>
            <p>2. {{translate('You can download the example file to understand how the data must be filled')}}.</p>
            <p>3. {{translate('Once you have downloaded and filled the skeleton file, upload it in the form below and submit')}}.</p>
            <p>4. {{translate('After uploading products you need to edit them and set product\'s images and choices')}}.</p>
        </div>
        <br>
        <div>
            @if($type == 'tyre')
            <a href="{{ static_asset('download/tyre_product_bulk_demo.xlsx') }}" download><button class="btn btn-info">{{ translate('Download CSV')}}</button></a>
            @else
            <a href="{{ static_asset('download/service_product_bulk_demo.xlsx') }}" download><button class="btn btn-info">{{ translate('Download CSV')}}</button></a>
            @endif
        </div>
        <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
            <strong>{{translate('Step 2')}}:</strong>
            <p>1. {{translate('Categories and '.$type.' Brand should be in numerical id')}}.</p>
            <p>2. {{translate('You can download below pdf files to get the data')}}.</p>
            <p>5. {{translate("Featured value should be 0 or 1")}}.</p>
        </div>
        <br>
        <div class="">
            <a href="{{ route('pdf.download_category') }}"><button class="btn btn-info">{{translate('Download Category')}}</button></a>
            @if($type == 'tyre')
            <a href="{{ route('pdf.download_tyre_brands') }}"><button class="btn btn-info">{{translate('Download Tyre Brands')}}</button></a>
            @else
            <a href="{{ route('pdf.download_service_brands') }}"><button class="btn btn-info">{{translate('Download Service Brands')}}</button></a>
            @endif
            @if($type == 'service')
            <a href="{{ route('pdf.download_service_subcategories') }}"><button class="btn btn-info">{{translate('Download Sub Categories')}}</button></a>
            <a href="{{ route('pdf.download_service_subchildcategories') }}"><button class="btn btn-info">{{translate('Download Sub Child categories')}}</button></a>
            @endif
        </div>
        <br>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Upload '.ucfirst($type).' Products File')}}</h5>
    </div>
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('bulk_product_upload', $type) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-sm-9">
                    <div class="custom-file">
                        <label class="custom-file-label">
                            <input type="file" name="bulk_file" class="custom-file-input" required>
                            <span class="custom-file-name">{{ translate('Choose File')}}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-info">{{translate('Upload CSV')}}</button>
            </div>
        </form>
    </div>
</div>

@endsection