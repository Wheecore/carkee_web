@extends('frontend.informative-pages.layout')
@section('title', $page->getTranslation('title'))

@section('meta_title'){{ $page->meta_title }}@stop

@section('meta_description'){{ $page->meta_description }}@stop

@section('meta_keywords'){{ $page->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $page->meta_title }}">
    <meta itemprop="description" content="{{ $page->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($page->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $page->meta_title }}">
    <meta name="twitter:description" content="{{ $page->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($page->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($page->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $page->meta_title }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $page->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($page->meta_img) }}" />
    <meta property="og:description" content="{{ $page->meta_description }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:price:amount" content="{{ single_price($page->unit_price) }}" />
@endsection

@section('content')
<style>
    .bg-contrast.edge.bottom-right::after {
        background-image: unset;
    }
</style>
<header class="page header text-contrast bg-primary" style="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="bold display-md-4 text-contrast mb-4">{{ $page->getTranslation('title') }}</h1>
                <p class="lead text-contrast"></p>
            </div>
        </div>
    </div>
</header>
<div class="position-relative">
    <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast">
        <svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
        </svg>
    </div>
</div>

<section class="section overview">
    <div class="container">
        <div class="row align-items-center gap-y">
            <div class="col-lg-12">
                @php
                    echo $page->getTranslation('content');
                @endphp
            </div>
        </div>
    </div>
</section>

@endsection
