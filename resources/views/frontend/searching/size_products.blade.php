@if(count($prods)>0)
    @foreach($prods as $prod)
        <div class="slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false"
             style="width: 224px;">
            <div>
                <div class="carousel-box" style="width: 100%; display: inline-block;">
                    <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                        <div class="position-relative">
                            <a href="{{ route('product', $prod->slug) }}" class="d-block">
                                <img
                                        class="img-fit lazyload mx-auto h-140px h-md-210px"
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($prod->thumbnail_img) }}"
                                        alt="{{  $prod->getTranslation('name')  }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                >
                            </a>
                            <div class="absolute-top-right aiz-p-hov-icon">
                               
                                <a href="javascript:void(0)" onclick="showAddToCartModal({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                    <i class="las la-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="p-md-3 p-2 text-left">
                            <div class="fs-15">
                                <span class="fw-700 text-primary">${{$prod->unit_price  }}</span>
                            </div>
                            <h3 class="fw-600 text-truncate-2 lh-1-4 mb-0 h-35px">
                                <a href="http://localhost/auto-system/product/test-nynxn"
                                   class="d-block text-reset"
                                   tabindex="0">{{ $prod->name }}</a>
                            </h3>
                            <p class="card-text">
                                {!! $prod->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <h4 class="card-title">No data found!</h4>
@endif

<style>
    /*! CSS Used from: https://www.goodyear.com.my/wp-content/cache/autoptimize/css/autoptimize_6d9856574fed2a284d0f08d772d6ebf7.css ; media=all */
    @media all{
        a{background-color:transparent;}
        a:active,a:hover{outline:0;}
        h1{font-size:2em;margin:0.67em 0;}
        img{border:0;}
        input,select{color:inherit;font:inherit;margin:0;}
        select{text-transform:none;}
        input::-moz-focus-inner{border:0;padding:0;}
        input{line-height:normal;}
        input[type="checkbox"]{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding:0;}
        @media print{
            *,*:before,*:after{background:transparent!important;color:#000!important;-webkit-box-shadow:none!important;box-shadow:none!important;text-shadow:none!important;}
            a,a:visited{text-decoration:underline;}
            a[href]:after{content:" (" attr(href) ")";}
            a[href^="#"]:after{content:"";}
            img{page-break-inside:avoid;}
            img{max-width:100%!important;}
            p{orphans:3;widows:3;}
            select{background:#fff!important;}
        }
        .glyphicon{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Halflings';font-style:normal;font-weight:normal;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;}
        .glyphicon-download-alt:before{content:"\e025";}
        *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
        *:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
        input,select{font-family:inherit;font-size:inherit;line-height:inherit;}
        a{color:#337ab7;text-decoration:none;}
        a:hover,a:focus{color:#23527c;text-decoration:underline;}
        a:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
        img{vertical-align:middle;}
        h1,h4{font-family:inherit;font-weight:500;line-height:1.1;color:inherit;}
        h1{margin-top:20px;margin-bottom:10px;}
        h4{margin-top:10px;margin-bottom:10px;}
        h1{font-size:36px;}
        h4{font-size:18px;}
        p{margin:0 0 10px;}
        .text-left{text-align:left;}
        .text-center{text-align:center;}
        .text-uppercase{text-transform:uppercase;}
        ul{margin-top:0;margin-bottom:10px;}
        .row{margin-left:-15px;margin-right:-15px;}
        .col-xs-2,.col-sm-3,.col-md-3,.col-sm-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-sm-8,.col-sm-9,.col-md-9,.col-xs-12,.col-sm-12{position:relative;min-height:1px;padding-left:15px;padding-right:15px;}
        .col-xs-2,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-12{float:left;}
        .col-xs-12{width:100%;}
        .col-xs-7{width:58.33333333%;}
        .col-xs-6{width:50%;}
        .col-xs-5{width:41.66666667%;}
        .col-xs-2{width:16.66666667%;}
        @media (min-width:768px){
            .col-sm-3,.col-sm-4,.col-sm-8,.col-sm-9,.col-sm-12{float:left;}
            .col-sm-12{width:100%;}
            .col-sm-9{width:75%;}
            .col-sm-8{width:66.66666667%;}
            .col-sm-4{width:33.33333333%;}
            .col-sm-3{width:25%;}
        }
        @media (min-width:992px){
            .col-md-3,.col-md-9{float:left;}
            .col-md-9{width:75%;}
            .col-md-3{width:25%;}
        }
        label{display:inline-block;max-width:100%;margin-bottom:5px;font-weight:bold;}
        input[type="checkbox"]{margin:4px 0 0;margin-top:1px \9;line-height:normal;}
        input[type="checkbox"]:focus{outline:thin dotted;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
        .clearfix:before,.clearfix:after,.row:before,.row:after{content:" ";display:table;}
        .clearfix:after,.row:after{clear:both;}
        .visible-xs,.visible-sm{display:none!important;}
        @media (max-width:767px){
            .visible-xs{display:block!important;}
        }
        @media (min-width:768px) and (max-width:991px){
            .visible-sm{display:block!important;}
        }
        @media (max-width:767px){
            .hidden-xs{display:none!important;}
        }
        a{background-color:transparent;}
        a:active,a:hover{outline:0;}
        h1{font-size:2em;margin:.67em 0;}
        img{border:0;}
        input,select{color:inherit;font:inherit;margin:0;}
        select{text-transform:none;}
        input::-moz-focus-inner{border:0;padding:0;}
        input{line-height:normal;}
        input[type=checkbox]{box-sizing:border-box;padding:0;}
        select::-ms-expand{display:none;}
        select:disabled{background-color:#f2f2f2;}
        *{margin:0;padding:0;text-decoration:none;}
        h1,h4{margin:0;font-weight:700;text-transform:uppercase;}
        ul{list-style-position:outside;margin-left:20px;}
        a,a:hover,a:focus{text-decoration:none;}
        h1{color:#fff;font-size:65px;margin-bottom:10px;line-height:.9;}
        h4{font-size:18px;margin-bottom:10px;font-weight:400;color:#000;}
        .type-cate{border:1px solid #c6c8ca;margin-top:18px;margin-bottom:30px;background:#fff;}
        .type-cate li:hover{background:#013a82;color:#fff;}
        .type-cate li{border-bottom:1px solid #c6c8ca;}
        .type-cate li:last-child{border-bottom:0;}
        .type-box{padding:30px;background:#fff;margin-bottom:30px;}
        .type-box:last-child{margin-bottom:0;}
        .type-box h4{font-size:30px;color:#000;font-weight:700;margin-bottom:5px;text-transform:inherit;}
        .recommendation_detail h4{font-weight:700;}
        .recommendation_detail .type-box{margin-bottom:0;}
        .type-box img{margin:auto;max-width:100%;height:auto;}
        .type-box .icon-box{margin-top:10px;}
        .more-detail{color:#013a82;text-decoration:underline;}
        .type-box .icon-box img{margin-right:7px;display:block;}
        .type-right{padding-top:5px;padding-bottom:5px;}
        .type-right .btn-find a{display:block;background:#fd0;padding:10px 0 7px;font-weight:900;text-align:center;text-transform:uppercase;color:#000;border-bottom:1px solid #6c5d00;border-left:1px solid #ffff36;border-top:1px solid #ffff6c;border-right:1px solid #a18c00;}
        .type-right .btn-find a:hover{background-color:#013b81;border:1px solid #013b81;color:#fff;}
        .type-right label{cursor:pointer;font-size:16px;font-weight:400;color:#013a82;}
        .type-box input[type=checkbox]{display:none;}
        .uncheck{display:inline-block;width:23px;height:25px;margin:-1px 4px 0 0;vertical-align:middle;background:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/uncheck.png) left top no-repeat;cursor:pointer;}
        .find-type .type-detail h1{color:#000;font-size:52px;font-weight:700;line-height:1.1;}
        .find-type .type-detail a{color:#464648;}
        .type-detail h1{margin-bottom:20px;}
        select::-ms-expand{display:none;}
        select{-moz-appearance:none;-webkit-appearance:none;text-indent:.5px;text-overflow:'';background:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/icon-contact-select.png) right 12px center no-repeat #fff;border:1px solid #ccc;width:100%;border-radius:0;color:#666;border-radius:3px;height:39px;padding:10px;}
        .type-right .btn-find a,.type-bottom-destop .compare-box a{-webkit-transition:background-color .2s linear,border .2s linear;-moz-transition:background-color .2s linear,border .2s linear;-o-transition:background-color .2s linear,border .2s linear;transition:background-color .2s linear,border .2s linear;}
        .type-bottom-destop{background:#96989b;padding:20px 0;}
        .type-bottom-destop .compare-box a{display:block;background:#fd0;padding:10px 0 7px;font-weight:700;text-align:center;color:#000;border-bottom:1px solid #6c5d00;border-left:1px solid #ffff36;border-top:1px solid #ffff6c;border-right:1px solid #a18c00;text-transform:uppercase;}
        .type-bottom-destop .compare-box a:hover{background-color:#013b81;border:1px solid #013b81;color:#fff;}
        .compare-warning{display:none;color:#900;font-size:12px;}
        @media all and (max-width:1199px){
            h1{font-size:60px;}
            h4{font-size:16px;}
        }
        @media all and (max-width:1000px){
            h1{font-size:55px;}
            h4{font-size:14px;}
        }
        @media all and (max-width:900px){
            h1{font-size:40px;}
        }
        @media all and (max-width:991px){
            .type-right{border-left:0;}
            .type-left .line{background:#d0d2d4;margin:10px 0;float:left;width:100%;display:block;height:1px;}
            .type-right .btn-find{clear:both;}
            .type-cate,.type-cate li{float:left;}
            .type-cate li{width:100%;}
        }
        @media all and (min-width:768px){
            .type-box .type-left{padding-right:20px;}
            .type-right{padding-left:20px;}
        }
        @media all and (max-width:767px){
            .type-box{padding:0;}
            .type-box h4{font-size:28px;}
            .type-box p{font-size:16px;}
            .type-box .type-left{padding:30px 45px 0;}
            .type-right .check{margin-top:10px;margin-left:15px;}
            .type-right .btn-find a{border:0;font-size:36px;text-align:left;background:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/right.png) right 40px center no-repeat #fd0!important;}
            .find-type .type-box{border:0;}
            .find-type .type-detail p{font-size:28px;}
            .type-right .btn-find a{padding-left:40px;}
        }
        @media all and (max-width:500px){
            .find-type .type-detail h1{font-size:42px;}
            .find-type .type-detail p{font-size:20px;}
        }
        @media all and (max-width:400px){
            .type-box .type-left{padding:30px 35px 0;}
            .type-right .btn-find a{font-size:24px;}
            .type-right .btn-find a{background:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/right.png) right 20px center no-repeat #fd0!important;-webkit-background-size:10px!important;background-size:10px!important;}
        }
        @media all and (max-width:350px){
            .type-box h4{font-size:25px;}
            .type-right .btn-find a{padding-left:20px;}
        }
        .type-box .check{margin-top:15px;margin-bottom:15px;}
        .news-box .content-new a,.news-box .content-new a:visited{color:#013a82;text-decoration:none;}
        .type-bottom-destop .compare-box a{color:#000;}
        .type-bottom-destop .compare-box a:hover{color:#fff;}
        .find-type .type-detail h4 a{color:#013A82!important;}
        .content-new .type-box .btn-find a{color:#000;}
        .tyre_title h4{text-transform:uppercase;}
        *{box-sizing:border-box;}
        .wpb_wrapper .row .icon-box img{width:auto;}
        a,a:hover{color:#000;}
        .icon-box span{display:inline-block;}
        .icon-box img{max-width:50px;}
        .tab-content .type-box:nth-child(even){background:#eeeeef;}
        .type-cate label{width:100%;color:#000;margin-bottom:0;padding:10px;}
        .type-cate label:hover,.type-cate .type_checked label{cursor:pointer;background:#013a82;color:#fff;text-decoration:none;}
        .recommendation_detail{margin-top:50px;margin-bottom:50px;}
        .compare_item{background:#fff;min-height:40px;}
        .compare_item_content{position:relative;}
        .compare_item{position:relative;}
        .compare_item .default-text{position:absolute;text-align:center;width:100%;top:10px;}
        .type-box .type-right .check{margin-top:10px;}
        .type-cate{margin:0;list-style:none;}
        .content-new img{max-width:100%;height:auto;}
        .content-new a{color:#013a82;text-decoration:underline;}
        ul{list-style-position:outside;}
        @media all and (max-width:768px){
            .type-bottom-destop .col-xs-2{padding:0 5px;}
            .type-bottom-destop .col-xs-2:first-child{padding-left:10px;}
            .type-bottom-destop{display:inline-block;width:100%;}
        }
        .text-deco-none{text-decoration:none!important;}
        span.rof-logo img{max-width:130px;}
        .type-box .icon-box span.rof-logo{vertical-align:top;}
        .rof_box label{font-weight:400;color:#013a82;cursor:pointer;}
        .btn-find a.text-deco-none:hover{color:#fff;}
        .btn-find a.text-deco-none{color:#000;}
        @media all and (max-width:768px){
            .type-box .type-left .tyre_thumbail{margin-bottom:10px;text-align:center;}
            .type-box .type-left .tyre_thumbail img{margin:auto;}
        }
        @media all and (max-width:767px){
            .type-right .btn-find a{font-size:20px;}
            .type-right .btn-find a:hover{background-color:#fd0;border:none;color:#000;}
            .type-right .btn-find a{font-weight:700;}
            .tyre-first-row{position:relative;}
            .type-box .type-left .tyre_thumbail{padding-right:10px;padding-left:0;margin-left:-10px;}
            .type-box .type-left .tyre_title{top:50%;position:absolute;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);transform:translateY(-50%);display:inline-block;float:initial;}
            .type-box h4,.type-box p.brochure{margin-left:-30px;}
            .type-box p{font-size:14px!important;}
            .type-box .line{border-left-color:#fff;border-left-style:solid;border-left-width:15px;border-right-color:#fff;border-right-style:solid;border-right-width:15px;margin-bottom:20px;}
            .type-box .type-right .check{margin-top:20px;}
            .type-box .btn-find{margin-left:-15px;margin-right:-15px;margin-bottom:2px;}
            .type-box .btn-find a{font-size:18px;font-weight:700;line-height:1;padding:15px 20px 15px 30px;}
            .type-box:nth-child(2n) .line{border-left-color:#eeeeef;border-right-color:#eeeeef;}
            .find-type .type-detail h1{font-size:24px;line-height:1.2;}
            .type-detail h1{margin-bottom:10px;}
            .row{margin-left:0;margin-right:0;}
            .type-box{margin-bottom:5px;}
            .recommendation_detail{margin-top:0;}
            .recommendation_detail .col-sm-9{padding-left:0;padding-right:0;}
            .type-bottom-destop .ht_compare_center{margin:0 15px!important;}
        }
        .type-bottom-destop{padding:15px;}
        .type-bottom-destop .compare_item{display:table;height:50px;min-height:50px;width:100%;}
        .type-bottom-destop .compare_item .default-text{display:table-cell;height:50px;line-height:1;padding:5px;position:static;text-align:center;vertical-align:middle;width:100%;}
        .type-bottom-destop .compare_item .default-text:empty{display:none;}
        .type-bottom-destop .ht_compare_center{margin:0 -5px;}
        .type-bottom-destop .ht_compare_center>[class^=col-]{padding-left:5px;padding-right:5px;}
        .type-bottom-destop .compare-box a{padding:0;line-height:48px;}
        @media all and (max-width:767px){
            .type-bottom-destop .compare_item{display:block;}
            .type-bottom-destop .compare_item .default-text{display:none;}
        }
        #findtyre_output{padding-top:20px;}
        #findtyre_output:empty{padding:0;}
    }
    /*! CSS Used fontfaces */
    @font-face{font-family:'Glyphicons Halflings';src:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.eot);src:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.woff2) format('woff2'),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.woff) format('woff'),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg');}
    @font-face{font-family:'FSSinclairRegular';src:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairRegular.eot),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairRegular.woff) format('woff');font-weight:400;font-style:normal;}
    @font-face{font-family:'FSSinclairRegular';src:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairMedium.eot),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairMedium.woff) format('woff');font-weight:700;font-style:normal;}
    @font-face{font-family:'FSSinclairRegular';src:url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairBold.eot),url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairBold.woff) format('woff');font-weight:900;font-style:normal;}
</style>

    <h1>
        Here are our recommendations	</h1>
    <div id="findtyre_size_cate" class="row recommendation_detail text-left">
        {{--<div class="col-sm-3 hidden-xs">--}}
            {{--<h4 class="hidden-xs">Filter by category</h4><ul class="type-cate hidden-xs">--}}
                {{--<li class="type_checked">--}}
                    {{--<label for="category_166">--}}
                        {{--<span>All</span></label>--}}
                {{--</li>--}}

                {{--<li class="">--}}
                    {{--<label for="category_29">--}}
                        {{--<span>Passenger</span></label>--}}
                {{--</li>--}}





            {{--</ul><select class="visible-xs" id="category-filter-mobile"><option value="all" selected="">All</option><option value="performance">Performance</option><option value="passenger">Passenger</option><option value="suv-4x4">SUV /4x4/ Light Truck Radial</option><option value="light-truck-bias">Light Truck Bias</option><option value="medium-commercial-truck-bias">Medium Commercial Truck Bias</option><option value="farm-grader">Farm and Grader</option><option value="earth-mover">Earth Mover</option><option value="medium-radial-truck">Medium Radial Truck</option></select> <br> 		</div>--}}
        <div class="col-sm-12">
            <div role="tabpanel">
                <div class="tab-content">
                    <div class="rof_box" style="display: none;">
                        <label><input id="findtyre_rof" type="checkbox"> Show only Run On Flat</label>
                    </div>
                    <div id="findtyre_items">
                    @if(count($prods)>0)
                        @foreach($prods as $prod)

                        <div class="type-box" data-cat-filter="|category_166|category_29|" data-rof="off" data-isoe="0" data-oe-size="">
                            <div class="row">
                                <div class="col-md-9 col-sm-12 col-xs-12 type-left">
                                    <div class="row tyre-first-row">
                                        <div class="col-xs-5 col-sm-4 tyre_thumbail">
                                            <a href="{{ route('product', $prod->slug) }}" title="Goodyear Assurance TripleMax 2">
                                                <img width="300" height="300" src="{{ uploaded_asset($prod->thumbnail_img) }}"
                                                     alt="{{  $prod->getTranslation('name')  }}"
                                                     onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" class="attachment-medium size-medium wp-post-image" sizes="(max-width: 300px) 100vw, 300px">						</a>
                                        </div>
                                        <div class=" col-xs-7 col-sm-8 tyre_title">
                                            <h4><a class="text-deco-none" href="{{ route('product', $prod->slug) }}">{{ $prod->name }}</a></h4>
                                            <p class="hidden-xs">
                                                {!! $prod->description !!}
                                                <a href="{{ route('product', $prod->slug) }}" class="more-detail">
                                                    More details						</a>
                                            </p>


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 visible-xs">
                                            <p>
                                                The new Goodyear Assurance TripleMax 2 with the latest HydroTred technology can achieve better braking performance on wet road. With innovative asymmetric tread design, drivers can experience better handling and comfort performance for a safer and a more comfortable drive.&nbsp;&nbsp;
                                                <a href="https://www.goodyear.com.my/tyres/goodyear-assurance-triplemax-2?checksize=1" class="more-detail">
                                                    More details					</a>
                                            </p>
                                            <span class="rof-logo">
						<img src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/worry-free-assurance-logo-123x50-min.png" alt="">
					</span>
                                        </div>
                                        <div class="line visible-sm visible-xs"></div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12 col-xs-12 type-right">


                                    <div class="btn-find">
                                        {{--<a href="javascript:void(0)" onclick="addToWishList({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">--}}
                                            {{--<i class="la la-heart-o"></i>--}}
                                        {{--</a>--}}
                                        {{--<a href="javascript:void(0)" onclick="addToCompare({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">--}}
                                            {{--<i class="las la-sync"></i>--}}
                                        {{--</a>--}}
                                        <a class="text-deco-none" href="javascript:void(0)" onclick="showAddToCartModal({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}">
                                           Add To Cart
                                        </a>
                                    </div>


                                    {{--<p class=" ">--}}
                                        {{--<a class="text-deco-none" href="/store?tyre_id=7542">--}}
                                            {{--Find a Store				</a>--}}
                                    {{--</p>--}}


                                    {{--<p class="btn-find ">--}}
                                        {{--<a class="text-deco-none" href="https://www.goodyear.com.my/filter-tyre/request-for-quote?compare_item_return=7542&amp;type=size">--}}
                                            {{--Request for quote				</a>--}}
                                    {{--</p>--}}

                                    {{--<div class="check">--}}
                                        {{--<input type="checkbox">--}}
                                        {{--<label attr_thumb="https://www.goodyear.com.my/wp-content/uploads/ATM2-1-150x150.png" attr_title="Goodyear Assurance TripleMax 2" attr_id="7542" class="input_checkbox">--}}
                                            {{--<div class="uncheck button_compare_7542 "></div>--}}
                                            {{--Compare</label>--}}
                                        {{--<div class="compare-warning">You can compare up to 3 tyres at a time</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>


                        @endforeach
                    @else


                    <p id="noresult-ajax" class="text-center text-uppercase">
                        No results found					</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
