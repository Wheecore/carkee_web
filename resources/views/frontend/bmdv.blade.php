@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('All Brands') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        {{--<li class="breadcrumb-item opacity-50"> --}}
                            {{--<a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>--}}
                        {{--</li>--}}
                        {{--<li class="text-dark fw-600 breadcrumb-item">--}}
                            {{--<a class="text-reset" href="{{ route('brands.all') }}">"{{ translate('All Brands') }}"</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container">
            <h6 style="color: #FFFFFF">Brands</h6>
            <div class="bg-white shadow-sm rounded px-3 pt-3">
                <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                    @foreach (json_decode($product->brand_id) as $data)
                        <?php
                        $brand = \App\Models\Brand::where('id', $data)->first();
                        ?>
                    <div class="card">
                        <div class="col text-center">
                            {{ $brand->name }}
                        <img src="{{ uploaded_asset($brand->logo) }}" class="lazyload mx-auto h-70px mw-100">

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container">
            <h6 style="color: #FFFFFF">Models</h6>
            <div class="bg-white shadow-sm rounded px-3 pt-3">
                <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                    @foreach (json_decode($product->model_id) as $data)
                        <?php
                        $m = \App\CarModel::where('id', $data)->first();
                        ?>
                    <div class="card">
                        <div class="col text-center">
                            {{ $m->name }}
                        <img src="{{ uploaded_asset($m->logo) }}" class="lazyload mx-auto h-70px mw-100">

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container">
            <h6 style="color: #FFFFFF">Car Details</h6>
            <div class="bg-white shadow-sm rounded px-3 pt-3">
                <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                    @foreach (json_decode($product->details_id) as $data)
                        <?php
                        $d = \App\CarDetail::where('id', $data)->first();
                        ?>
                    <div class="card">
                        <div class="col text-center">
                            {{ $d->name }}
                        <img src="{{ uploaded_asset($d->logo) }}" class="lazyload mx-auto h-70px mw-100">

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="mb-4">
        <div class="container">
            <h6 style="color: #FFFFFF">Car Variants</h6>
            <div class="bg-white shadow-sm rounded px-3 pt-3">
                <div class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 gutters-10">
                    @foreach (json_decode($product->type_id) as $data)
                        <?php
                        $t = \App\CarType::where('id', $data)->first();
                        ?>
                    <div class="card">
                        <div class="col text-center">
                            {{ $t->name }}
                        <img src="{{ uploaded_asset($t->logo) }}" class="lazyload mx-auto h-70px mw-100">

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
