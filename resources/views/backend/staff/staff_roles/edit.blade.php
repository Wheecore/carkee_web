@extends('backend.layouts.app')
@section('title', translate('Role Information'))
@section('content')

    <div class="col-lg-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Role Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('roles.index') }}"><i class="las la-arrow-left mr-1"></i>{{ translate('Back') }}</a>
            </div>
            <div class="card-body p-0">
                <form class="p-4" action="{{ route('roles.update', $role->id) }}" method="POST">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="name">{{ translate('Name') }} <i class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name" class="form-control" value="{{ $role->getTranslation('name', $lang) }}" required>
                        </div>
                    </div>
                    <br>
                    @php
                        $permissions = json_decode($role->permissions);
                        $permissions = ($permissions != null)?$permissions:[];
                    @endphp
                    <!-- Permissions -->
                    <div>
                        <!-- Dashboard -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Dashboard') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Dashboard') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(1, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="1">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tyre Size Categories -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Tyre Size Categories') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Tyre Size Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(2, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="2">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Width') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(3, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="3">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Series') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(4, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="4">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Rim Size') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(5, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="5">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Category -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Featured Category') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Featured Category') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(6, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="6">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Main Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(7, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="7">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Sub Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(8, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="8">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tyre Vehicle Category -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Tyre Vehicle Category') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Tyre Vehicle Category') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(9, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="9">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Size Alternatives -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Size Alternatives') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Size Alternatives') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(10, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="10">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Brands -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Brands') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Brands Data') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(11, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="11">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Tyre Brands') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(12, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="12">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Service Brands') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(13, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="13">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Battery Brands') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(14, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="14">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Part Brands') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(92, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="92">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Part Data -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Part Data') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Part Types') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(93, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="93">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Car Data -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Car Data') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Data') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(15, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="15">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Brand') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(16, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="16">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Models') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(17, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="17">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Years') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(18, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="18">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Variants') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(19, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="19">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Products') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Products') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(20, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="20">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add Tyre Battery & Service') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(21, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="21">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add New product') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(22, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="22">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Products') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(23, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="23">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Products Reviews') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(24, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="24">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Orders') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(25, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="25">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('New Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(26, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="26">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Done Orders list') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(27, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="27">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Reschedule Date Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(28, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="28">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Reassign Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(29, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="29">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Orders Reviews') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(30, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="30">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Packages Reviews') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(31, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="31">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Services') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Services') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(32, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="32">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Sub Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(33, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="33">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Sub Child Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(34, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="34">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Batteries Services -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Emergency Batteries Services') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Batteries') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(35, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="35">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Sub Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(36, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="36">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Sub Child Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(37, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="37">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add New Battery') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(38, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="38">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Jumpstart') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(39, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="39">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Tyres Services -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Emergency Tyres Services') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Spare Tyre') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(40, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="40">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Petrols Services -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Emergency Petrols Services') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Petrol Details') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(41, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="41">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Orders -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Emergency Orders') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Emergency Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(42, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="42">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Battery Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(43, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="43">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Tyre Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(44, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="44">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Petrol Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(45, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="45">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Coupons -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Emergency Coupons') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Emergency Coupons') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(46, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="46">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Car Wash -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Car Wash') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Wash Products') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(47, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="47">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(48, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="48">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Products') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(49, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="49">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add New product') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(50, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="50">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add New Order') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(51, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="51">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Membership') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(52, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="52">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Payments') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(53, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="53">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Usage Logs') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(54, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="54">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Orders') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(55, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="55">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Car Wash Technicians -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Car Wash Technicians') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Car Wash Technicians') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(56, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="56">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add Car Wash Technician') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(57, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="57">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customers -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Customers') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Customer List') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(58, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="58">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Customers Wallet Transactions') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(90, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="90">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Customer Car Condition List') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(59, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="59">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Workshops -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Workshops') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Workshops') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(60, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="60">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Workshops Availability Requests') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(61, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="61">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Merchants -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Merchants') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Merchants') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(62, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="62">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Merchant Categories') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(63, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="63">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Merchants') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(64, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="64">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Merchants Vouchers') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(65, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="65">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Staffs -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Staffs') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('All Staffs') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(66, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="66">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Add New Role') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(67, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="67">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Staff Permissions') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(68, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="68">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payments -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Payments') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Reschedule Payments') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(69, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="69">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Wallet Amount') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(88, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="88">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Uploaded Files -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Others') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Message To Customers') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(91, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="91">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Uploaded Files') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(70, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="70">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Referral System -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Referral System') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Referral Configurations') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(71, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="71">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Referral Users') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(72, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="72">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Referral Coupons') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(73, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="73">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Marketing -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Marketing') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Deals') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(75, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="75">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Newsletters') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(76, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="76">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Subscribers') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(77, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="77">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Coupon') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(78, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="78">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Gift Codes') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" @php if(in_array(74, $permissions)) echo "checked"; @endphp value="74">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Gift Codes History') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" @php if(in_array(89, $permissions)) echo "checked"; @endphp value="89">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Website Setup -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Website Setup') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Slider') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(79, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="79">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Video') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(80, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="80">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Header') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(81, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="81">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Footer') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(82, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="82">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Pages') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(83, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="83">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Appearance') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(84, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="84">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Setup & Configurations -->
                        <div class="card no-shadow">
                            <div class="card-body">
                                <h6>{{ translate('Setup & Configurations') }}</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('General Settings') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(85, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="85">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('SMTP Settings') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(86, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="86">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <label class="col-from-label">{{ translate('Social Media Logins') }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="permissions[]" @php if(in_array(87, $permissions)) echo "checked"; @endphp class="form-control demo-sw" value="87">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
