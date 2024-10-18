@extends('frontend.layouts.app')
@section('content')

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
            top: -9999px;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="font-weight-bold">Leave a review</h3>
                    </div>
                    <div class="card-body review-area mt-4">
                        <form action="{{ route('submit.review') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="">
                            <input type="hidden" name="website_use" id="website_use" value="">
                            <input type="hidden" name="product_money" id="product_money" value="">
                            <input type="hidden" name="website_use" id="website_use" value="">
                            <div class="row">
                                <div class="col-md-6 left-side" style="padding-left: 40px;">
                                    <h5 class="font-weight-bold" style="font-weight: 600;">Which 3 features are the most valuable to you? (Can pick (<i class="fa fa-check"></i>) more
than 1 answer)</h5>
                                        <input type="checkbox" id="dashboard" name="features" value="Vehicles Profile Dashboard">
                                        <label for="dashboard">Vehicles Profile Dashboard</label><br>
                                        <input type="checkbox" id="reminder" name="features" value="Reminder Services">
                                        <label for="reminder">Reminder Services</label><br>
                                        <input type="checkbox" id="emergency" name="features" value="Emergency Rescue Services">
                                        <label for="emergency">Emergency Rescue Services</label><br>
                                        <input type="checkbox" id="selection" name="features" value="Customized Products Selection">
                                        <label for="selection">Customized Products Selection</label><br>
                                        <input type="checkbox" id="vouchers" name="features" value="Vouchers">
                                        <label for="vouchers">Vouchers</label>
                                    <br>
                                    <hr>
                                    <h5 class="font-weight-bold" style="font-weight: 600;margin-top: 16px;">How easy it is to navigate our website/app?</h5>
                                    <div class="rate">
                                                    <input type="radio" id="star5" name="website_use" value="5" onclick="Score('5')" />
                                                    <label for="star5" title="text" class="removeStar">5 star</label>
                                                    <input type="radio" id="star4" name="website_use" value="4" onclick="Score('4')" />
                                                    <label for="star4" title="text" class="removeStar">4 star</label>
                                                    <input type="radio" id="star3" name="website_use" value="3" onclick="Score('3')" />
                                                    <label for="star3" title="text" class="removeStar">3 star</label>
                                                    <input type="radio" id="star2" name="website_use" value="2" onclick="Score('2')" />
                                                    <label for="star2" title="text" class="removeStar">2 star</label>
                                                    <input type="radio" id="star1" name="website_use" value="1" onclick="Score('1')" />
                                                    <label for="star1" title="text" class="removeStar">1 star</label>
                                              
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h5 class="font-weight-bold" style="font-weight: 600;margin-top: 16px;">How would you rate the value for money of the product?</h5>
                                    <div class="rate">
                                                    <input type="radio" id="star5" name="product_money" value="5" onclick="Score('5')" />
                                                    <label for="star5" title="text" class="removeStar">5 star</label>
                                                    <input type="radio" id="star4" name="product_money" value="4" onclick="Score('4')" />
                                                    <label for="star4" title="text" class="removeStar">4 star</label>
                                                    <input type="radio" id="star3" name="product_money" value="3" onclick="Score('3')" />
                                                    <label for="star3" title="text" class="removeStar">3 star</label>
                                                    <input type="radio" id="star2" name="product_money" value="2" onclick="Score('2')" />
                                                    <label for="star2" title="text" class="removeStar">2 star</label>
                                                    <input type="radio" id="star1" name="product_money" value="1" onclick="Score('1')" />
                                                    <label for="star1" title="text" class="removeStar">1 star</label>
                                              
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                        <h5 class="font-weight-bold" style="font-weight: 600;margin-top: 16px;">How easy it is to navigate our website/app?</h5>
                                    <div class="rate">
                                                    <input type="radio" id="star5" name="website_use" value="5" onclick="Score('5')" />
                                                    <label for="star5" title="text" class="removeStar">5 star</label>
                                                    <input type="radio" id="star4" name="website_use" value="4" onclick="Score('4')" />
                                                    <label for="star4" title="text" class="removeStar">4 star</label>
                                                    <input type="radio" id="star3" name="website_use" value="3" onclick="Score('3')" />
                                                    <label for="star3" title="text" class="removeStar">3 star</label>
                                                    <input type="radio" id="star2" name="website_use" value="2" onclick="Score('2')" />
                                                    <label for="star2" title="text" class="removeStar">2 star</label>
                                                    <input type="radio" id="star1" name="website_use" value="1" onclick="Score('1')" />
                                                    <label for="star1" title="text" class="removeStar">1 star</label>
                                              
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <h3 class="font-weight-bold" style="font-weight: 600;margin-top: 16px;">Would you recommend Carkee?</h3>
                                    <p>Your opinion won't be posted publicly.</p>
                                    <button class="btn" id="green"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></button>
                                    <button class="btn" id="red"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></button>
                                    <hr>
                                    <h3 class="font-weight-bold" style="font-weight: 600;">Praise</h3>
                                    <p>What traits best describe Carkee?</p>
                                    <div class="radio-toolbar mt-3">
                                        <input type="checkbox" id="radioApple1" name="radioFruit" value="apple">
                                        <label for="radioApple1">Aventurous</label>

                                        <input type="checkbox" id="radioBanana2" name="radioFruit" value="banana" checked>
                                        <label for="radioBanana2">Clean</label>

                                        <input type="checkbox" id="radioOrange3" name="radioFruit" value="orange">
                                        <label for="radioOrange3">Good Listner</label>

                                        <input type="checkbox" id="radioOrange4" name="radioFruit" value="orange">
                                        <label for="radioOrange4">Honest</label>

                                        <input type="checkbox" id="radioOrange5" name="radioFruit" value="orange">
                                        <label for="radioOrange5">Humorous</label>

                                        <input type="checkbox" id="radioOrange6" name="radioFruit" value="orange">
                                        <label for="radioOrange6">Inspiring</label>

                                        <input type="checkbox" id="radioOrange7" name="radioFruit" value="orange">
                                        <label for="radioOrange7">Kind</label>

                                        <input type="checkbox" id="radioOrange8" name="radioFruit" value="orange" checked>
                                        <label for="radioOrange8">Knowledgable</label>

                                        <input type="checkbox" id="radioOrange9" name="radioFruit" value="orange" checked>
                                        <label for="radioOrange9">Non-judgemental</label>

                                        <input type="checkbox" id="radioOrange10" name="radioFruit" value="orange">
                                        <label for="radioOrange10">Spontaneous</label>

                                        <input type="checkbox" id="radioOrange11" name="radioFruit" value="orange">
                                        <label for="radioOrange11">Talkative</label>

                                        <input type="checkbox" id="radioOrange12" name="radioFruit" value="orange" checked>
                                        <label for="radioOrange12">Thoughtful</label>

                                        <input type="checkbox" id="radioOrange13" name="radioFruit" value="orange" checked>
                                        <label for="radioOrange13">Trustworthy</label>

                                    </div>
                                </div>
                                <div class="col-md-6 right-side" style="padding-right: 34px;">
                                    <h3>Care to share more?</h3>
                                    <p>How was your overall experience? What's that one thing you won't forget Carkee for?</p>
                                    <br>
                                    <textarea class="form-control aiz-text-editor" name="description" style="display: none;" cols="30" rows="8">
                            </textarea>
                                    <button type="submit" class="btn btn-block last-btn font-weight-bold">Publish Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function Score($value){
            $(".removeStar").css({ 'color' : ''});
            $('#website_use').val($value);
        }
          function Score($value){
            $(".removeStar").css({ 'color' : ''});
            $('#website_use').val($value);
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
        });

        btn2.addEventListener('click', function() {
            if (btn1.classList.contains('green')) {
                btn1.classList.remove('green');
            }
            this.classList.toggle('red');

        });
    </script>
@endsection

