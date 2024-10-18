@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Video Information') }}</h5>
            </div>
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('video.update', $video->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    @csrf

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Video') }}</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control">
                            </div>
                        </div>
                    </div>
                    @if ($video->video)
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="signinSrEmail"></label>
                            <video width="320" height="240" controls>
                                <source src="{{ static_asset('/uploads/' . $video->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
