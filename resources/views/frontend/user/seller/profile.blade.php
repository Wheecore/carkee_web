@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aiz-titlebar mt-4 mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Manage Profile') }}</h1>
                        </div>
                    </div>
                </div>
                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Basic Info-->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Basic Info')}}</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Name') }}</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="{{ translate('Your Name') }}" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Phone') }}</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="{{ translate('Your Phone')}}" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Photo') }}</label>
                                <div class="col-md-10">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photo" value="{{ Auth::user()->avatar_original }}" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Your Password') }}</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="{{ translate('New Password') }}" name="new_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">{{ translate('Confirm Password') }}</label>
                                <div class="col-md-10">
                                    <input type="password" class="form-control" placeholder="{{ translate('Confirm Password') }}" name="confirm_password">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Payment System -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Payment Setting')}}</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ translate('Bank Name') }}</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Bank Name')}}" value="{{ Auth::user()->seller->bank_name }}" name="bank_name">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ translate('Bank Account Name') }}</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Bank Account Name')}}" value="{{ Auth::user()->seller->bank_acc_name }}" name="bank_acc_name">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-form-label">{{ translate('Bank Account Number') }}</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Bank Account Number')}}" value="{{ Auth::user()->seller->bank_acc_no }}" name="bank_acc_no">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Update Profile')}}</button>
                    </div>
                </form>
                <br>
                <!-- Change Email -->
                <form action="{{ route('user.change.email') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Change your email')}}</h5>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Your Email') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                                    </div>
                                    <div class="form-group mb-0 text-right">
                                        <button type="submit" class="btn btn-primary">{{translate('Update Email')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
