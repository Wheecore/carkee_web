@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4" style="color: white">{{ translate('All Brands') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            <a class="text-reset" href="{{ route('brands.all') }}">"{{ translate('All Brands') }}"</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @foreach ($categories as $category)
        <section class="mb-4">
            <div class="container">
                <div class="bg-white shadow-sm rounded px-3 pt-3 card-r">
                    <h4>
                        {{ $category->name }}
                    </h4>
                    <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                        <div class="text-center p-3">
                            <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

@endsection
