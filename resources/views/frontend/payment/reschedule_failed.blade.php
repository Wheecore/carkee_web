@extends('frontend.layouts.custom_layout')
@section('content')
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="card card-body" style="border-radius: 15px;">
					<img src="{{ static_asset('assets/img/500.svg') }}" class="mw-100 mx-auto mb-5" height="300">
					<h1 class="fw-700">{{ translate('Payment failed') }}</h1>
					<p class="fs-16 opacity-60">{{ translate('Payment failed, please try again!') }}</p>
					</div>
					<div style="text-align: center">
						<a class="btn" href="https://carkee.my/block" style="background: #000693; color: white;border-radius: 8px;font-weight: 600;font-size: 14px;width: 214px;">GO BACK</a>
					</div>
				</div>
			</div>

@endsection
