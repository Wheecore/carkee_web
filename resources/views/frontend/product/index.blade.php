@extends('frontend.informative-pages.layout')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <p>{{ $product->description }}</p>

    <!-- Fallback button: If the app is installed and supports Universal Links, tapping the link should open the app.
         Otherwise, users can click this button to try opening the app using a custom scheme -->
    <a href="carkee://product?id={{ $product->id }}" class="btn btn-primary">
        Open in App
    </a>
</div>
@endsection