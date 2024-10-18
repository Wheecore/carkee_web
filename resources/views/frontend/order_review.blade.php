@extends('frontend.layouts.user_panel')
@section('panel_content')
<style>
    .review-area .left-side p {
        color: grey;
        margin-bottom: 0px;
    }

    .review-area .left-side .rate {
        float: left;
        height: 46px;
    }

    .review-area .left-side .rate:not(:checked)>input {
        position: absolute;
        /*top: -9999px;*/
        display: none;
    }

    .review-area .left-side .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 40px;
        color: #ccc;
    }

    .review-area .left-side .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .review-area .left-side .rate>input:checked~label {
        color: #ffc700;
    }

    .review-area .left-side .rate:not(:checked)>label:hover,
    .review-area .left-side .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .review-area .left-side .rate>input:checked+label:hover,
    .review-area .left-side .rate>input:checked+label:hover~label,
    .review-area .left-side .rate>input:checked~label:hover,
    .review-area .left-side .rate>input:checked~label:hover~label,
    .review-area .left-side .rate>label:hover~input:checked~label {
        color: #c59b08;
    }

    .review-area .left-side button {
        cursor: pointer;
        outline: 0;
        color: #AAA;
        background: white;
        font-size: 30px;
    }

    .review-area .left-side .btn:focus {
        outline: none;
    }

    .review-area .left-side .green {
        color: #6CB284;
    }

    .review-area .left-side .red {
        color: red;
    }

    .review-area .right-side p {
        color: grey;
        margin-bottom: 0px;
    }

    .review-area .radio-toolbar input[type="checkbox"] {
        opacity: 0;
        position: fixed;
        width: 0;
    }

    .review-area .radio-toolbar label {
        display: inline-block;
        background-color: #F4F3EF;
        padding: 5px 18px;
        font-family: sans-serif, Arial;
        font-size: 16px;
        border: 2px solid #F4F3EF;
        border-radius: 25px;
    }

    .review-area .radio-toolbar label:hover {
        background-color: #ddd;
    }

    .review-area .radio-toolbar input[type="checkbox"]:checked+label {
        background-color: #A1E6B7;
        border-color: #A1E6B7;
    }

    .review-area .right-side .last-btn {
        background-color: #a1e6b7;
    }

    /* Media Query */
    @media (max-width:768px) {

        .review-area .left-side h2,
        .review-area .right-side h2 {
            font-size: 21px;
        }
    }
</style>
    <!-- Fontawesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="font-weight-bold">Leave a review</h3>
                    </div>
                    <div class="card-body review-area mt-4">
                        <form action="{{ route('submit.review') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order_id }}">
                            <input type="hidden" name="score" id="score"
                                value="{{ $chk_order ? $chk_order->score : 0 }}">
                            <input type="hidden" name="workshop_enviornment" id="workshop_enviornment"
                                value="{{ $chk_order ? $chk_order->workshop_enviornment : 0 }}">
                            <input type="hidden" name="job_done_on_time" id="job_done_on_time"
                                value="{{ $chk_order ? $chk_order->job_done_on_time : 'Yes' }}">
                            <input type="hidden" name="website_use" id="website_use"
                                value="{{ $chk_order ? $chk_order->website_use : 0 }}">
                            <input type="hidden" name="money_of_product" id="money_of_product"
                                value="{{ $chk_order ? $chk_order->money_of_product : 0 }}">
                            <input type="hidden" name="buy_again" id="buy_again"
                                value="{{ $chk_order ? $chk_order->buy_again : 0 }}">
                            <div class="row">
                                <div class="col-md-6 left-side" style="padding-left: 40px;">
                                    <h4 class="font-weight-bold" style="font-weight: 600;">How would you rate our services
                                        on a scale of 1-5? (5=terrible,
                                        1=stellar) in terms of:</h4>
                                    <h5>Workshop service crew performance:</h5>
                                    <div class="rate">
                                        @for ($i = 5; $i > 0; $i--)
                                            @if ($chk_order)
                                                @if ($chk_order->score >= $i)
                                                    <input type="radio" id="star{{ $i + 1 }}" name="rate"
                                                        value="{{ $i }}"
                                                        onclick="Score('score',{{ $i }})" />
                                                    <label for="star{{ $i + 1 }}" title="text"
                                                        style="color: #ffc700;"
                                                        class="removeStar_score_{{ $i }}">5 stars</label>
                                                @else
                                                    <input type="radio" id="star{{ $i + 1 }}" name="rate"
                                                        value="{{ $i }}"
                                                        onclick="Score('score',{{ $i }})" />
                                                    <label for="star{{ $i + 1 }}" title="text">5 stars</label>
                                                @endif
                                            @else
                                                <input type="radio" id="star{{ $i + 1 }}" name="rate"
                                                    value="{{ $i }}"
                                                    onclick="Score('score',{{ $i }})" />
                                                <label for="star{{ $i + 1 }}" title="text">5 stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                    <br>
                                    <br>
                                    <h5 class="mt-4">Workshop environment:</h5>
                                    <div class="rate">
                                        @for ($j = 5; $j > 0; $j--)
                                            @if ($chk_order)
                                                @if ($chk_order->workshop_enviornment >= $j)
                                                    <input type="radio" id="workshop_enviornment{{ $j + 1 }}"
                                                        name="rate2" value="{{ $j }}"
                                                        onclick="Score('workshop_enviornment',{{ $j }})" />
                                                    <label for="workshop_enviornment{{ $j + 1 }}" title="text"
                                                        style="color: #ffc700;"
                                                        class="removeStar_workshop_enviornment_{{ $j }}">5
                                                        stars</label>
                                                @else
                                                    <input type="radio" id="workshop_enviornment{{ $j + 1 }}"
                                                        name="rate2" value="{{ $j }}"
                                                        onclick="Score('workshop_enviornment',{{ $j }})" />
                                                    <label for="workshop_enviornment{{ $j + 1 }}" title="text">5
                                                        stars</label>
                                                @endif
                                            @else
                                                <input type="radio" id="workshop_enviornment{{ $j + 1 }}"
                                                    name="rate2" value="{{ $j }}"
                                                    onclick="Score('workshop_enviornment',{{ $j }})" />
                                                <label for="workshop_enviornment{{ $j + 1 }}" title="text">5
                                                    stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h4 class="font-weight-bold" style="margin-top: 16px;">How easy it is to navigate our
                                        website/app?</h4>
                                    <div class="rate">
                                        @for ($k = 5; $k > 0; $k--)
                                            @if ($chk_order)
                                                @if ($chk_order->website_use >= $k)
                                                    <input type="radio" id="website_use{{ $k + 1 }}"
                                                        name="rate3" value="{{ $k }}"
                                                        onclick="Score('website_use',{{ $k }})" />
                                                    <label for="website_use{{ $k + 1 }}" title="text"
                                                        style="color: #ffc700;"
                                                        class="removeStar_website_use_{{ $k }}">5 stars</label>
                                                @else
                                                    <input type="radio" id="website_use{{ $k + 1 }}"
                                                        name="rate3" value="{{ $k }}"
                                                        onclick="Score('website_use',{{ $k }})" />
                                                    <label for="website_use{{ $k + 1 }}" title="text">5
                                                        stars</label>
                                                @endif
                                            @else
                                                <input type="radio" id="website_use{{ $k + 1 }}" name="rate3"
                                                    value="{{ $k }}"
                                                    onclick="Score('website_use',{{ $k }})" />
                                                <label for="website_use{{ $k + 1 }}" title="text">5
                                                    stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h4 class="font-weight-bold" style="margin-top: 16px;">How would you rate the value
                                        for money of the product?</h4>
                                    <div class="rate">
                                        @for ($l = 5; $l > 0; $l--)
                                            @if ($chk_order)
                                                @if ($chk_order->money_of_product >= $l)
                                                    <input type="radio" id="money_of_product{{ $l + 1 }}"
                                                        name="rate4" value="{{ $l }}"
                                                        onclick="Score('money_of_product',{{ $l }})" />
                                                    <label for="money_of_product{{ $l + 1 }}" title="text"
                                                        style="color: #ffc700;"
                                                        class="removeStar_money_of_product_{{ $l }}">5
                                                        stars</label>
                                                @else
                                                    <input type="radio" id="money_of_product{{ $l + 1 }}"
                                                        name="rate4" value="{{ $l }}"
                                                        onclick="Score('money_of_product',{{ $l }})" />
                                                    <label for="money_of_product{{ $l + 1 }}" title="text">5
                                                        stars</label>
                                                @endif
                                            @else
                                                <input type="radio" id="money_of_product{{ $l + 1 }}"
                                                    name="rate4" value="{{ $l }}"
                                                    onclick="Score('money_of_product',{{ $l }})" />
                                                <label for="money_of_product{{ $l + 1 }}" title="text">5
                                                    stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h4 class="font-weight-bold" style="margin-top: 16px;">How likely are you to buy again
                                        from us?</h4>
                                    <div class="rate">
                                        @for ($m = 5; $m > 0; $m--)
                                            @if ($chk_order)
                                                @if ($chk_order->buy_again >= $m)
                                                    <input type="radio" id="buy_again{{ $m + 1 }}"
                                                        name="rate5" value="{{ $m }}"
                                                        onclick="Score('buy_again',{{ $m }})" />
                                                    <label for="buy_again{{ $m + 1 }}" title="text"
                                                        style="color: #ffc700;"
                                                        class="removeStar_buy_again_{{ $m }}">5 stars</label>
                                                @else
                                                    <input type="radio" id="buy_again{{ $m + 1 }}"
                                                        name="rate5" value="{{ $m }}"
                                                        onclick="Score('buy_again',{{ $m }})" />
                                                    <label for="buy_again{{ $m + 1 }}" title="text">5
                                                        stars</label>
                                                @endif
                                            @else
                                                <input type="radio" id="buy_again{{ $m + 1 }}" name="rate5"
                                                    value="{{ $m }}"
                                                    onclick="Score('buy_again',{{ $m }})" />
                                                <label for="buy_again{{ $m + 1 }}" title="text">5 stars</label>
                                            @endif
                                        @endfor
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h4 class="font-weight-bold" style="font-weight: 600;margin-top: 16px;">Is the job
                                        been carried out as per your reservation time slot?</h4>
                                    <button type="button"
                                        class="btn {{ $chk_order && $chk_order->job_done_on_time == 'Yes' ? 'green' : '' }}"
                                        id="green"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></button>
                                    <button type="button"
                                        class="btn {{ $chk_order && $chk_order->job_done_on_time == 'No' ? 'red' : '' }}"
                                        id="red"><i class="fa fa-thumbs-down fa-lg"
                                            aria-hidden="true"></i></button>
                                    <hr>
                                    <h4 class="font-weight-bold" style="font-weight: 600;">Which 3 features are the most
                                        valuable to you? (Can pick (<i class="fa fa-check"></i>) more
                                        than 1 answer) </h4>
                                    <div class="radio-toolbar mt-3">
                                        @php
                                            $features_arr = [];
                                            if ($chk_order && $chk_order->features != 'null' && $chk_order->features) {
                                                $features_arr = json_decode($chk_order->features);
                                            }
                                        @endphp
                                        <input type="checkbox" id="Vehicles" name="features[]"
                                            value="Vehicles Profile Dashboard"
                                            {{ in_array('Vehicles Profile Dashboard', $features_arr) ? 'checked' : '' }}>
                                        <label for="Vehicles">Vehicles Profile Dashboard</label>
                                        <input type="checkbox" id="Reminder" name="features[]"
                                            value="Reminder Services"
                                            {{ in_array('Reminder Services', $features_arr) ? 'checked' : '' }}>
                                        <label for="Reminder">Reminder Services</label>
                                        <input type="checkbox" id="Emergency" name="features[]"
                                            value="Emergency Rescue Services"
                                            {{ in_array('Emergency Rescue Services', $features_arr) ? 'checked' : '' }}>
                                        <label for="Emergency">Emergency Rescue Services</label>
                                        <input type="checkbox" id="Customized" name="features[]"
                                            value="Customized Products Selection"
                                            {{ in_array('Customized Products Selection', $features_arr) ? 'checked' : '' }}>
                                        <label for="Customized">Customized Products Selection</label>
                                        <input type="checkbox" id="Vouchers" name="features[]" value="Vouchers"
                                            {{ in_array('Vouchers', $features_arr) ? 'checked' : '' }}>
                                        <label for="Vouchers">Vouchers</label>
                                    </div>
                                    <hr>
                                    <h4 class="font-weight-bold">What was your biggest fear or concern about purchasing
                                        from us?
                                        (Can pick (<i class="fa fa-check"></i>) more than 1 answer)</h4>
                                    <div class="radio-toolbar mt-3">
                                        @php
                                            $purchasing_concern_arr = [];
                                            if ($chk_order && $chk_order->purchasing_concern != 'null' && $chk_order->purchasing_concern) {
                                                $purchasing_concern_arr = json_decode($chk_order->purchasing_concern);
                                            }
                                        @endphp
                                        <input type="checkbox" id="Payment" name="purchasing_concern[]"
                                            value="Payment security"
                                            {{ in_array('Payment security', $purchasing_concern_arr) ? 'checked' : '' }}>
                                        <label for="Payment">Payment security</label>
                                        <input type="checkbox" id="Counterfeit" name="purchasing_concern[]"
                                            value="Counterfeit / non-genuine products"
                                            {{ in_array('Counterfeit / non-genuine products', $purchasing_concern_arr) ? 'checked' : '' }}>
                                        <label for="Counterfeit">Counterfeit / non-genuine products</label>
                                        <input type="checkbox" id="Unfit" name="purchasing_concern[]"
                                            value="Unfit products"
                                            {{ in_array('Unfit products', $purchasing_concern_arr) ? 'checked' : '' }}>
                                        <label for="Unfit">Unfit products</label>
                                        <input type="checkbox" id="Availability" name="purchasing_concern[]"
                                            value="Availability of nearby partnering workshops"
                                            {{ in_array('Availability of nearby partnering workshops', $purchasing_concern_arr) ? 'checked' : '' }}>
                                        <label for="Availability">Availability of nearby partnering workshops</label>
                                        <input type="checkbox" id="Quality" name="purchasing_concern[]"
                                            value="Quality of service"
                                            {{ in_array('Quality of service', $purchasing_concern_arr) ? 'checked' : '' }}>
                                        <label for="Quality">Quality of service</label>
                                    </div>
                                </div>
                                <div class="col-md-6 right-side" style="padding-right: 34px;">
                                    <h4 class="font-weight-bold">What can we do to improve the experience?</h4>
                                    <br>
                                    <textarea class="form-control aiz-text-editor" name="description" style="display: none;" cols="30"
                                        rows="8">
                                {{ $chk_order ? $chk_order->description : '' }}
                            </textarea>
                                    <br>
                                    <h4 class="font-weight-bold">What other products would you like to see us offer?
                                        (Please
                                        specify)</h4>
                                    <br>
                                    <textarea class="form-control aiz-text-editor" name="specification_of_products" style="display: none;"
                                        cols="30" rows="8">
                                {{ $chk_order ? $chk_order->specification_of_products : '' }}
                            </textarea>
                                    <button type="submit" class="btn btn-block last-btn font-weight-bold">Publish
                                        Review</button>
                                </div>
                            </div>
                        </form>
                        <?php
                        $order_details = \App\Models\OrderDetail::where('order_id', $order_id)->get();
                        ?>
                        <section class="mt-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($order_details as $order_detail)
                                            <?php
                                            $detailedProduct = \App\Product::where('id', $order_detail->product_id)->first();
                                            ?>
                                            @if (Auth::check())
                                                @php
                                                    $commentable = false;
                                                @endphp
                                                @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                                    @if ($orderDetail->order != null &&
                                                        $orderDetail->order->user_id == Auth::user()->id &&
                                                        \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                                        @php
                                                            $commentable = true;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($commentable)
                                                    <div class="pt-4">
                                                        <div class="border-bottom mb-4">
                                                            <h3 class="fs-17 fw-600">
                                                                Product Name: <span
                                                                    class="opacity-50">{{ $detailedProduct->name }}</span>
                                                            </h3>
                                                        </div>
                                                        <div class="border-bottom mb-4">
                                                            <h3 class="fs-17 fw-600">
                                                                {{ translate('Write a review') }}
                                                            </h3>
                                                        </div>
                                                        <form class="form-default" role="form"
                                                            action="{{ route('reviews.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $detailedProduct->id }}">
                                                            <div class="row" style="display: none">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="text-uppercase c-gray-light">{{ translate('Your name') }}</label>
                                                                        <input type="text" name="name"
                                                                            value="{{ Auth::user()->name }}"
                                                                            class="form-control" disabled required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for=""
                                                                            class="text-uppercase c-gray-light">{{ translate('Email') }}</label>
                                                                        <input type="text" name="email"
                                                                            value="{{ Auth::user()->email }}"
                                                                            class="form-control" required disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <style>
                                                                    .rating i {
                                                                        width: 1em;
                                                                        white-space: nowrap;
                                                                        cursor: pointer;
                                                                        font-size: 37px;
                                                                        color: #ccc;
                                                                    }

                                                                    .la-star:before {
                                                                        content: '★ ';
                                                                    }

                                                                    .rating i.active {
                                                                        color: #ffc700;
                                                                    }
                                                                </style>
                                                                <label>{{ translate('Rating') }}</label>
                                                                <div class="rating rating-input">
                                                                    <label>
                                                                        <input type="radio" name="rating"
                                                                            value="1" required>
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating"
                                                                            value="2">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating"
                                                                            value="3">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating"
                                                                            value="4">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="rating"
                                                                            value="5">
                                                                        <i class="las la-star"></i>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{ translate('Comment') }}</label>
                                                                <textarea class="form-control" rows="4" name="comment" placeholder="{{ translate('Your review') }}" required></textarea>
                                                            </div>

                                                            <div class="text-right">
                                                                <button type="submit" class="btn btn-primary mt-3">
                                                                    {{ translate('Submit review') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function Score(id, $value) {
            $('.removeStar_' + id + '_' + $value).css({
                'color': ''
            });
            $('#' + id).val($value);
        }
    </script>
    <!-- Like And Dislike -->
    <script>
        var btn1 = document.querySelector('#green');
        var btn2 = document.querySelector('#red');

        btn1.addEventListener('click', function() {
            if (btn2.classList.contains('red')) {
                btn2.classList.remove('red');
            }
            this.classList.toggle('green');
            $("#job_done_on_time").val('Yes');
        });

        btn2.addEventListener('click', function() {
            if (btn1.classList.contains('green')) {
                btn1.classList.remove('green');
            }
            this.classList.toggle('red');
            $("#job_done_on_time").val('No');

        });
    </script>
@endsection
