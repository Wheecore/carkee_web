@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
    <link rel="stylesheet" href="{{ static_asset('assets/css/test.css') }}">
    <style>
        .smenu__asd, .smenu__icon--remove, .smenu__value {
            background-color: unset !important;
            color: black;
            font-weight: 700;
            font-size:12px;
        }
        @media (min-width: 1500px){
            .container--listing {
                max-width: 1140px;
            }
        }
        .btn-default{
            display: contents !important;
        }
        .smenu__label{
            font-size:16px !important;
        }
        .four-tenths, .two-fifths{
            width: 70%;
        }
    </style>
    <main class="bg-white">
        <div class="drawer-backdrop  js-mobile-menu-toggle"></div>
        <div class="header__finder  flex__left-auto  text--uppercase  weight--semibold  hidden">
            <a href="#js-mobile-sort__trigger" class="text--white  js-mobile-sort__trigger">Sort</a>
            <a href="#js-mobile-show-search" class="text--white  js-mobile-show-search">Search</a>
        </div>


        <div id="classified-listings" class="listings  relative mt-5">
            <div class="container  container--listing  cf">

                <button type="button" class="dmenus btn btn-primary" onclick="showMenus()">Menus</button>

                <div class="grid  grid--classified">
                    <nav class="listings__fixed-left  grid__item  js-listings__fixed-left  js-listings__fixed-left--sticky-top  js-part-facets">



                        <div class="removesmenu smenu smenucss box  hard  transition--default" data-smenu-params="{&quot;make&quot;:&quot;toyota&quot;,&quot;model&quot;:&quot;86&quot;,&quot;vehicle_type&quot;:&quot;car&quot;,&quot;badge_operator&quot;:&quot;OR&quot;,&quot;boss&quot;:true,&quot;page_size&quot;:25,&quot;facets_all&quot;:true,&quot;page_number&quot;:1,&quot;total&quot;:504}" style="-webkit-box-sizing: border-box; box-sizing: border-box; background: #fff; border-radius: 4px; -webkit-box-shadow: 0 2px 4px rgba(52, 66, 81, .1), 0 0 0 1px rgba(52, 66, 81, .1); box-shadow: 0 2px 4px rgba(52, 66, 81, .1), 0 0 0 1px rgba(52, 66, 81, .1); color: #576a7f; font-size: 12px; line-height: 36px; z-index: unset; padding: 0; position: absolute; -webkit-transition: all .3s ease; -o-transition: all .3s ease; transition: all .3s ease;width: 285px;">

                            <div class="smenu__fields" style="-webkit-box-sizing: border-box; box-sizing: border-box;">
                                <div class="smenu__fields__container" style="-webkit-box-sizing: border-box; box-sizing: border-box;">
                                    <div class="smenu__field smenu__field--overview  visuallyhidden--desk-end" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                        <div class="smenu__btn" style="-webkit-box-sizing: border-box; box-sizing: border-box; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; font-size: 0; text-align: center; cursor: default;">
                                            <a class="smenu__side" href="#" style="-webkit-box-sizing: border-box; box-sizing: border-box; background-color: transparent; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; color: #02aaee; cursor: pointer; text-decoration: none; overflow: hidden; display: block; float: none; text-align: center; font-family: bmwTypeNextWeb, Arial, Helvetica, sans-serif; font-style: normal; font-weight: 700;">
                                            <span class="inline--block  valign--top  smenu__value" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-radius: 4px 0 0 4px; overflow: hidden; -o-text-overflow: ellipsis; text-overflow: ellipsis; white-space: nowrap; background-color: #02aaee; float: none; font-size: 12px; font-weight: 700; line-height: 24px; margin: 10px 3px; max-width: 1000px; padding: 0; vertical-align: top; display: inline-block; color: #02aaee; background: none;">
                                                <form action="" method="get">
                                                     <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <button class="btn btn-default" style="font-size: 18px;"> Reset Search</button>
                                                </form>

                                            </span>
                                                <span class="inline--block  valign--top  smenu__addon-icon  icon  icon--md-reset" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; font-style: normal; position: relative; text-align: center; float: none; font-size: 12px; font-weight: 500; line-height: 24px; margin: 10px 3px; max-width: 1000px; padding: 0; vertical-align: top; display: inline-block; background: none;"></span>
                                            </a>
                                        </div>
                                    </div>


                                    <div class="smenu__section  smenu__section--finder  visuallyhidden--desk-wide" style="-webkit-box-sizing: border-box; box-sizing: border-box;">
                                        <div class="container" style="-webkit-box-sizing: border-box; box-sizing: border-box; width: 100%; margin-right: auto; margin-left: auto; margin: 0 auto; max-width: 1120px; padding-left: 20px; padding-right: 20px;">
                                            <div class="smenu__keyword  input-group  smenu__input  smenu__input--text  smenu__input--has-prepend  smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                                <div class="smenu__input__prepend  icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>
                                                <div class="smenu__input__prepend  smenu__back  icon  icon--md-arrow-back  hidden  js-smenu__close-dropdown--filter" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; font-style: normal; font-weight: 400; vertical-align: middle; display: none; color: #cfd6df; font-size: 14px; height: 20px; left: 0; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2;"></div>

                                                <form action="" method="get">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <button class="btn btn-primary"> Reset Search</button>
                                                </form>
                                                <button type="button" class="btn btn-default" onclick="hideMenus()"><i class="la la-close"></i></button>
                                                {{--</div>--}}
                                                <div class="smenu__input__append smenu__form-input--keyword-clear icon icon--wrong-circle append--after visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="smenu__section" style="-webkit-box-sizing: border-box; box-sizing: border-box;">

                                        <div class="vart smenu__field js-menu-slug--variant smenu__field--show-content" data-smenu-toggle=".smenu__filter--variant" data-smenu-slug="variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                            <div class="smenu__btn  relative" style="-webkit-box-sizing: border-box; box-sizing: border-box; cursor: pointer; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; position: relative;">
                                                <div class="smenu__label  float--left  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; float: left; font-weight: 500; color: #02aaee;">Brand</div>
                                                <div class="smenu__side" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: hidden;">
                                                    <div class="" style="float:right"><i class="la la-angle-right"></i></div>
                                                    <div class="smenu__value" style="">
                                                        <form action="" method="get">
                                                            <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                            {{ isset($b_id)? \App\Models\Brand::where('id', $b_id)->first()->name: ''}}
                                                            {{ isset($brand_id)? \App\Models\Brand::where('id', $brand_id)->first()->name: ''}}
                                                            <?php
                                                            Session::put('session_brand_id', isset($b_id) ? $b_id : (isset($brand_id) ? $brand_id : ''));
                                                            Session::get('session_brand_id');
                                                            ?>
                                                            @if(isset($b_id) || isset($brand_id))
                                                                <button type="submit" class="btn btn-sm btn-default"> <span><i class="la la-close"></i></span></button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vartModels smenu__field js-menu-slug--variant smenu__field--show-content" data-smenu-toggle=".smenu__filter--variant" data-smenu-slug="variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                            <div class="smenu__btn  relative" style="-webkit-box-sizing: border-box; box-sizing: border-box; cursor: pointer; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; position: relative;">
                                                <div class="smenu__label  float--left  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; float: left; font-weight: 500; color: #02aaee;">Models</div>
                                                <div class="smenu__side" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: hidden;">
                                                    <div class="" style="float:right"><i class="la la-angle-right"></i></div>
                                                    <div class="smenu__value" style="">
                                                        <form action="" method="get">

                                                            <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">

                                                            <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                            {{ isset($m_r_id)? \App\CarModel::where('id', $m_r_id)->first()->name: ''}}
                                                            {{ isset($model_id)? \App\CarModel::where('id', $model_id)->first()->name: ''}}
                                                            <?php
                                                            Session::put('session_model_id', isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : ''));
                                                            Session::get('session_model_id');
                                                            ?>
                                                            @if(isset($m_r_id) || isset($model_id))
                                                                <button type="submit" class="btn btn-sm btn-default"> <span><i class="la la-close"></i></span></button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vartDetails smenu__field js-menu-slug--variant smenu__field--show-content" data-smenu-toggle=".smenu__filter--variant" data-smenu-slug="variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                            <div class="smenu__btn  relative" style="-webkit-box-sizing: border-box; box-sizing: border-box; cursor: pointer; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; position: relative;">
                                                <div class="smenu__label  float--left  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; float: left; font-weight: 500; color: #02aaee;">Car Years</div>
                                                <div class="smenu__side" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: hidden;">
                                                    <div class="" style="float:right"><i class="la la-angle-right"></i></div>
                                                    <div class="smenu__value" style="">
                                                        <form action="" method="get">
                                                            <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                            <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">
                                                            <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                            {{ isset($cd_id)? \App\CarDetail::where('id', $cd_id)->first()->name: ''}}
                                                            {{ isset($details_id)? \App\CarDetail::where('id', $details_id)->first()->name: ''}}
                                                            <?php
                                                            Session::put('session_details_id', isset($cd_id)? $cd_id : (isset($details_id)? $details_id : ''));
                                                            Session::get('session_details_id');
                                                            ?>
                                                            @if(isset($cd_id) || isset($details_id))
                                                                <button type="submit" class="btn btn-sm btn-default"> <span><i class="la la-close"></i></span></button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vartYears smenu__field js-menu-slug--variant smenu__field--show-content" data-smenu-toggle=".smenu__filter--variant" data-smenu-slug="variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                            <div class="smenu__btn  relative" style="-webkit-box-sizing: border-box; box-sizing: border-box; cursor: pointer; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; position: relative;">
                                                <div class="smenu__label  float--left  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; float: left; font-weight: 500; color: #02aaee;">Car CC</div>
                                                <div class="smenu__side" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: hidden;">
                                                    <div class="" style="float:right"><i class="la la-angle-right"></i></div>
                                                    <div class="smenu__value" style="">
                                                        <form action="" method="get">
                                                            <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                            <input type="hidden" name="cd_id" value="{{ isset($cd_id)? $cd_id : (isset($details_id)? $details_id : '')}}">
                                                            {{--                                                        <input type="hidden" name="ct_id" value="{{ isset($ct_id)? $ct_id : (isset($type_id)? $type_id : '')}}">--}}
                                                            <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">
                                                            <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                            {{ isset($y_id)? \App\CarYear::where('id', $y_id)->first()->name: ''}}
                                                            {{ isset($year_id)? \App\CarYear::where('id', $year_id)->first()->name: ''}}
                                                            <?php
                                                            Session::put('session_year_id', isset($y_id)? $y_id : (isset($year_id)? $year_id : ''));
                                                            Session::get('session_year_id');
                                                            ?>
                                                            @if(isset($y_id) || isset($year_id))
                                                                <button type="submit" class="btn btn-sm btn-default"> <span><i class="la la-close"></i></span></button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vartTypes smenu__field js-menu-slug--variant smenu__field--show-content" data-smenu-toggle=".smenu__filter--variant" data-smenu-slug="variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; border-bottom: 1px solid #e6e9ef; line-height: 36px; position: relative;">
                                            <div class="smenu__btn  relative" style="-webkit-box-sizing: border-box; box-sizing: border-box; cursor: pointer; outline: none; overflow: hidden; padding-left: 12px; padding-right: 4px; position: relative;">
                                                <div class="smenu__label  float--left  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; float: left; font-weight: 500; color: #02aaee;">Car Variants</div>
                                                <div class="smenu__side" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: hidden;">
                                                    <div class="" style="float:right"><i class="la la-angle-right"></i></div>
                                                    <div class="smenu__value" style="">
                                                        <form action="" method="get">
                                                            <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                            <input type="hidden" name="y_id" value="{{ isset($y_id)? $y_id : (isset($year_id)? $year_id : '')}}">
                                                            <input type="hidden" name="cd_id" value="{{ isset($cd_id)? $cd_id : (isset($details_id)? $details_id : '')}}">
                                                            <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">
                                                            <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                            {{ isset($ct_id)? \App\CarType::where('id', $ct_id)->first()->name: ''}}
                                                            {{ isset($type_id)? \App\CarType::where('id', $type_id)->first()->name: ''}}
                                                            <?php
                                                            Session::put('session_type_id', isset($ct_id)? $ct_id : (isset($type_id)? $type_id : ''));
                                                            Session::get('session_type_id');
                                                            ?>
                                                            @if(isset($ct_id) || isset($type_id))
                                                                <button type="submit" class="btn btn-sm btn-default"> <span><i class="la la-close"></i></span></button>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end:.smenu__section -->

                                </div>
                                @if($_GET['category_id'] == 'Tyre')
                                    <div class="ml-2 mt-3 md-card card-r" style="display: block;">
                                        <a href="{{ url('get-tyres') }}" class="btn btn-primary">Find Tyres</a>
                                    </div>
                                @endif
                            </div><!-- .smenu__fields -->

                            <div class="smenu__filters" style="-webkit-box-sizing: border-box; box-sizing: border-box;">


                                {{--smenu__filter--show-myself--}}
                                <div class="zin smenu_varients smenu__filter smenu__filter--variant smenu__filter--show-myselff">
                                    <div class="smenu__filter-header" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 12px; padding-right: 12px;">
                                        <div class="flexbox  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table; width: 100%; font-weight: 500;">
                                            <div class="flexbox__item" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle;">Select Car Brand</div>
                                            <div class="flexbox__item  tight" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle; white-space: nowrap; width: 1px;"><span class="la la-close" onclick="closeMenu()" style="cursor: pointer"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smenu__filter-finder  soft-half--sides  soft-quarter--ends  visuallyhidden--portable" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">

                                        <div class="input-group smenu__input smenu__input--text smenu__input--has-prepend smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                            <div class="smenu__input__prepend icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>
                                            <span class="smenu__input__input" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: block; height: 32px;">
        <input id="searchBrandFilter" class="input smenu__form-input--variant smenu__form-input--dropdown-filter js-smenu__form-input--dropdown-filter" type="text" name="" value="" data-smenu-filter=".smenu__select--variant" placeholder="Search car variant" autocomplete="off" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; font-family: inherit; letter-spacing: inherit; margin: 0; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: #fff; border: 1px solid #cfd6df; border-radius: 4px; cursor: text; display: inline-block; outline: none; padding: 7px 12px; padding-left: 36px; font-size: 12px; height: 32px; line-height: 16px; max-width: 100%; vertical-align: top; width: 100%; color: #576a7f;">
    </span>
                                            <span data-target-input=".smenu__form-input--variant" class=" js-smenu__do-input-clear smenu__input__append icon icon--wrong-circle append--after  visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></span>
                                        </div>        </div>

                                    <div class="brands_filter smenu__filter-content" style="-webkit-box-sizing: border-box; box-sizing: border-box; -webkit-overflow-scrolling: touch; overflow-y: auto; height: calc(100% - 78px);">
                                        <ul class="smenu__select smenu__select--variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; margin-top: 0; margin-bottom: 1.3846153846rem; margin-left: 3.0769230769rem; list-style: none; margin: 0; padding: 0;">
                                            @foreach(\App\Models\Brand::all() as $item)
                                                <form action="" method="get">

                                                    <input type="hidden" name="b_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <li class="smenu__select__option  " data-value="BMW" data-scroll-to=".smenu__field-group--make">
                                                        <button type="submit" class="btn btn-default">
                                                            <span class="smenu__select__option__value  brand-label  brand-label--small  text--truncate">
                                    <span class="text--muted  float--right"> </span>
                                                                {{ $item->getTranslation('name') }}
                                </span>
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                {{--Model Menus--}}
                                <div class="zin model_menus_varients smenu__filter smenu__filter--variant">
                                    <div class="smenu__filter-header" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 12px; padding-right: 12px;">
                                        <div class="flexbox  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table; width: 100%; font-weight: 500;">
                                            <div class="flexbox__item" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle;">Select Car Model</div>
                                            <div class="flexbox__item  tight" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle; white-space: nowrap; width: 1px;"><span class="la la-close" onclick="closeMenu()" style="cursor: pointer"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smenu__filter-finder  soft-half--sides  soft-quarter--ends  visuallyhidden--portable" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">

                                        <div class="input-group smenu__input smenu__input--text smenu__input--has-prepend smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                            <div class="smenu__input__prepend icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>

                                            <span class="smenu__input__input" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: block; height: 32px;">
        <input id="searchModelFilter" class="input smenu__form-input--variant smenu__form-input--dropdown-filter js-smenu__form-input--dropdown-filter" type="text" name="" value="" data-smenu-filter=".smenu__select--variant" placeholder="Search car variant" autocomplete="off" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; font-family: inherit; letter-spacing: inherit; margin: 0; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: #fff; border: 1px solid #cfd6df; border-radius: 4px; cursor: text; display: inline-block; outline: none; padding: 7px 12px; padding-left: 36px; font-size: 12px; height: 32px; line-height: 16px; max-width: 100%; vertical-align: top; width: 100%; color: #576a7f;">

                                        </span>
                                            <span data-target-input=".smenu__form-input--variant" class=" js-smenu__do-input-clear smenu__input__append icon icon--wrong-circle append--after  visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></span>
                                        </div>        </div>

                                    <div class="models_filter smenu__filter-content" style="-webkit-box-sizing: border-box; box-sizing: border-box; -webkit-overflow-scrolling: touch; overflow-y: auto; height: calc(100% - 78px);">
                                        <ul class=" smenu__select smenu__select--variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; margin-top: 0; margin-bottom: 1.3846153846rem; margin-left: 3.0769230769rem; list-style: none; margin: 0; padding: 0;">
                                            @foreach(\App\CarModel::where('brand_id',isset($b_id)? $b_id : (isset($brand_id)? $brand_id : ''))->get() as $item)
                                                <form action="" method="get">
                                                    <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                    <input type="hidden" name="m_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <li class="smenu__select__option  " data-value="BMW" data-scroll-to=".smenu__field-group--make">
                                                        <button type="submit" class="btn btn-default">
                                                            <span class="smenu__select__option__value  brand-label  brand-label--small  text--truncate">
                                    <span class="text--muted  float--right"> </span>
                                                                {{ $item->getTranslation('name') }}
                                </span>
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{--Details Menus--}}
                                <div class="zin detail_menus_varients smenu__filter smenu__filter--variant">
                                    <div class="smenu__filter-header" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 12px; padding-right: 12px;">
                                        <div class="flexbox  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table; width: 100%; font-weight: 500;">
                                            <div class="flexbox__item" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle;">Select Car Year</div>
                                            <div class="flexbox__item  tight" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle; white-space: nowrap; width: 1px;"><span class="la la-close" onclick="closeMenu()" style="cursor: pointer"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smenu__filter-finder  soft-half--sides  soft-quarter--ends  visuallyhidden--portable" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">

                                        <div class="input-group smenu__input smenu__input--text smenu__input--has-prepend smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                            <div class="smenu__input__prepend icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>
                                            <span class="smenu__input__input" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: block; height: 32px;">
        <input id="searchDetailsFilter" class="input smenu__form-input--variant smenu__form-input--dropdown-filter js-smenu__form-input--dropdown-filter" type="text" name="" value="" data-smenu-filter=".smenu__select--variant" placeholder="Search car variant" autocomplete="off" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; font-family: inherit; letter-spacing: inherit; margin: 0; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: #fff; border: 1px solid #cfd6df; border-radius: 4px; cursor: text; display: inline-block; outline: none; padding: 7px 12px; padding-left: 36px; font-size: 12px; height: 32px; line-height: 16px; max-width: 100%; vertical-align: top; width: 100%; color: #576a7f;">
    </span>
                                            <span data-target-input=".smenu__form-input--variant" class=" js-smenu__do-input-clear smenu__input__append icon icon--wrong-circle append--after  visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></span>
                                        </div>        </div>

                                    <div class="details_filter smenu__filter-content" style="-webkit-box-sizing: border-box; box-sizing: border-box; -webkit-overflow-scrolling: touch; overflow-y: auto; height: calc(100% - 78px);">
                                        <ul class="smenu__select smenu__select--variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; margin-top: 0; margin-bottom: 1.3846153846rem; margin-left: 3.0769230769rem; list-style: none; margin: 0; padding: 0;">
                                            @foreach(\App\CarDetail::where('model_id',isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : ''))->orderBy('name', 'desc')->get() as $item)
                                                <form action="" method="get">
                                                    <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                    <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">

                                                    <input type="hidden" name="cd_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <li class="smenu__select__option  " data-value="BMW" data-scroll-to=".smenu__field-group--make">
                                                        <button type="submit" class="btn btn-default">

                                                            <span class="smenu__select__option__value  brand-label  brand-label--small  text--truncate">
                                    <span class="text--muted  float--right"> </span>
                                                                {{ $item->getTranslation('name') }}
                                </span>
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{--Years Menus--}}
                                <div class="zin year_menus_varients smenu__filter smenu__filter--variant">
                                    <div class="smenu__filter-header" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 12px; padding-right: 12px;">
                                        <div class="flexbox  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table; width: 100%; font-weight: 500;">
                                            <div class="flexbox__item" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle;">Select Car Details</div>
                                            <div class="flexbox__item  tight" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle; white-space: nowrap; width: 1px;"><span class="la la-close" onclick="closeMenu()" style="cursor: pointer"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smenu__filter-finder  soft-half--sides  soft-quarter--ends  visuallyhidden--portable" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">

                                        <div class="input-group smenu__input smenu__input--text smenu__input--has-prepend smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                            <div class="smenu__input__prepend icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>
                                            <span class="smenu__input__input" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: block; height: 32px;">

        <input id="searchYearsFilter" class="input smenu__form-input--variant smenu__form-input--dropdown-filter js-smenu__form-input--dropdown-filter" type="text" name="" value="" data-smenu-filter=".smenu__select--variant" placeholder="Search car variant" autocomplete="off" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; font-family: inherit; letter-spacing: inherit; margin: 0; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: #fff; border: 1px solid #cfd6df; border-radius: 4px; cursor: text; display: inline-block; outline: none; padding: 7px 12px; padding-left: 36px; font-size: 12px; height: 32px; line-height: 16px; max-width: 100%; vertical-align: top; width: 100%; color: #576a7f;">

    </span>
                                            <span data-target-input=".smenu__form-input--variant" class=" js-smenu__do-input-clear smenu__input__append icon icon--wrong-circle append--after  visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></span>
                                        </div>        </div>

                                    <div class="years_filter smenu__filter-content" style="-webkit-box-sizing: border-box; box-sizing: border-box; -webkit-overflow-scrolling: touch; overflow-y: auto; height: calc(100% - 78px);">
                                        <ul class="smenu__select smenu__select--variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; margin-top: 0; margin-bottom: 1.3846153846rem; margin-left: 3.0769230769rem; list-style: none; margin: 0; padding: 0;">
                                            @foreach(\App\CarYear::where('details_id',isset($cd_id)? $cd_id : (isset($details_id)? $details_id : ''))->get() as $item)
                                                <form action="" method="get">
                                                    <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                    <input type="hidden" name="cd_id" value="{{ isset($cd_id)? $cd_id : (isset($details_id)? $details_id : '')}}">
                                                    <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">
                                                    <input type="hidden" name="y_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <li class="smenu__select__option  " data-value="BMW" data-scroll-to=".smenu__field-group--make">
                                                        <button type="submit" class="btn btn-default">

                                                            <span class="smenu__select__option__value  brand-label  brand-label--small  text--truncate">
                                    <span class="text--muted  float--right"> </span>
                                                                {{ $item->getTranslation('name') }}
                                </span>
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                {{--Types Menus--}}
                                <div class="zin type_menus_varients smenu__filter smenu__filter--variant">
                                    <div class="smenu__filter-header" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 12px; padding-right: 12px;">
                                        <div class="flexbox  weight--semibold" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table; width: 100%; font-weight: 500;">
                                            <div class="flexbox__item" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle;">Select Car Variants</div>
                                            <div class="flexbox__item  tight" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: table-cell; vertical-align: middle; white-space: nowrap; width: 1px;"><span class="la la-close" onclick="closeMenu()" style="cursor: pointer"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="smenu__filter-finder  soft-half--sides  soft-quarter--ends  visuallyhidden--portable" style="-webkit-box-sizing: border-box; box-sizing: border-box; padding-left: 10px; padding-right: 10px; padding-bottom: 5px; padding-top: 5px;">

                                        <div class="input-group smenu__input smenu__input--text smenu__input--has-prepend smenu__input--has-append" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%; position: relative;">
                                            <div class="smenu__input__prepend icon  icon--magnifier  append--before" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; color: #cfd6df; font-size: 14px; height: 20px; line-height: 20px; margin-top: -10px; position: absolute; text-align: center; top: 50%; width: 36px; z-index: 2; left: 0; right: auto;"></div>
                                            <span class="smenu__input__input" style="-webkit-box-sizing: border-box; box-sizing: border-box; display: block; height: 32px;">
        <input id="searchTypesFilter" class="input smenu__form-input--variant smenu__form-input--dropdown-filter js-smenu__form-input--dropdown-filter" type="text" name="" value="" data-smenu-filter=".smenu__select--variant" placeholder="Search car variant" autocomplete="off" style="-webkit-box-sizing: border-box; box-sizing: border-box; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; font-family: inherit; letter-spacing: inherit; margin: 0; -webkit-appearance: none; -moz-appearance: none; appearance: none; background: #fff; border: 1px solid #cfd6df; border-radius: 4px; cursor: text; display: inline-block; outline: none; padding: 7px 12px; padding-left: 36px; font-size: 12px; height: 32px; line-height: 16px; max-width: 100%; vertical-align: top; width: 100%; color: #576a7f;">
    </span>
                                            <span data-target-input=".smenu__form-input--variant" class=" js-smenu__do-input-clear smenu__input__append icon icon--wrong-circle append--after  visuallyhidden" style="-webkit-box-sizing: border-box; box-sizing: border-box; zoom: 1; display: inline-block; font-style: normal; font-weight: 400; vertical-align: middle; line-height: 20px; margin-top: -10px; text-align: center; top: 50%; z-index: 2; color: #73879b; font-size: 16px; left: auto; clip: rect(0 0 0 0); border: 0; height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; right: 4px;"></span>
                                        </div>        </div>

                                    <div class="types_filter smenu__filter-content" style="-webkit-box-sizing: border-box; box-sizing: border-box; -webkit-overflow-scrolling: touch; overflow-y: auto; height: calc(100% - 78px);">
                                        <ul class="smenu__select smenu__select--variant" style="-webkit-box-sizing: border-box; box-sizing: border-box; margin-top: 0; margin-bottom: 1.3846153846rem; margin-left: 3.0769230769rem; list-style: none; margin: 0; padding: 0;">
                                            @foreach(\App\CarType::where('year_id',isset($y_id)? $y_id : (isset($year_id)? $year_id : ''))->get() as $item)
                                                <form action="" method="get">
                                                    <input type="hidden" name="b_id" value="{{ isset($b_id)? $b_id : (isset($brand_id)? $brand_id : '')}}">
                                                    <input type="hidden" name="y_id" value="{{ isset($y_id)? $y_id : (isset($year_id)? $year_id : '')}}">
                                                    <input type="hidden" name="cd_id" value="{{ isset($cd_id)? $cd_id : (isset($details_id)? $details_id : '')}}">
                                                    <input type="hidden" name="m_id" value="{{ isset($m_r_id)? $m_r_id : (isset($model_id)? $model_id : '')}}">
                                                    <input type="hidden" name="ct_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $cat->name }}">
                                                    <li class="smenu__select__option  " data-value="BMW" data-scroll-to=".smenu__field-group--make">
                                                        <button type="submit" class="btn btn-default">
                                                            <span class="smenu__select__option__value  brand-label  brand-label--small  text--truncate">
                                    <span class="text--muted  float--right"> </span>
                                                                {{ $item->getTranslation('name') }}
                                </span>
                                                        </button>
                                                    </li>
                                                </form>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>



                            </div>

</div>

                    </nav>
                    <div class="listings__fixed-right  grid__item  palm-one-whole  float--right" style="padding-bottom: 50px;">
                        <div class="grid">
                            <section id="classified-listings-result" class="listings__section  grid__item  seven-tenths  portable-one-whole  palm-one-whole" style="width:100%">


                                @if(count($prods)>0)
                                    @foreach($prods as $prod)
                                        <article class="listing  listing--card  box  push--top  js--listing  js--multi-lead listing--review" id="listing_8113640" data-listing-id="8113640" data-title="2017 Toyota 86 GT FACELIFT 13000KM True Mileage" data-display-title="2017 Toyota 86 2.0 GT Coupe" data-url="#" data-price="ʯʰ˝ˌˋ˅ˑˍˍˍ" data-price-raw="ˌˋ˅ˍˍˍ" data-installment="RM 2,178/month" data-phone="ˍˌˋːˏˉˉˉˏˌˏ" data-phone-whatsapp="ˍˌˋːˏˉˉˉˏˌˏ" data-default-whatsapp-text="Hi%2C%20I%20saw%20your%20car%20on%20Carlist.my%20and%20I%20would%20like%20to%20know%20more%20about%202017%20Toyota%2086%20GT%20FACELIFT%2013000KM%20True%20Mileage%20%28RM%20168%2C000%29.%20Thanks.%20https%3A%2F%2Fwww.carlist.my%2Frecon-cars%2F2017-toyota-86-gt-facelift-13000km-true-mileage%2F8113640" data-default-line-text="I am interested in your car on Carlist.my - 2017 Toyota 86 GT FACELIFT 13000KM True Mileage (RM 168,000). #." data-phones="ʆ˟ˍˌˋːˏˉˉˉˏˌˏ˟ˇʆ˟ʉʄʍʘ˟ˇ˟ʊʕʜʉʎʢʜʍʍ˟ˑ˟ʓʈʐʟʘʏ˟ˇ˟ˍˌˋːˏˉˉˉˏˌˏ˟ʀʀ" data-line-id="" data-line-numbers="ʆ˟˟ˇʆ˟ʉʄʍʘ˟ˇ˟ʜʚʘʓʉ˟ˑ˟ʓʜʐʘ˟ˇ˟ʾʕʒʒʓʚ˝ʪʜʔ˝ʭʔʓ˟ˑ˟ʓʈʐʟʘʏ˟ˇ˟˟ˑ˟ʑʔʓʘʢʓʈʐʟʘʏ˟ˇ˟˟ʀʀ" data-compare-image="https://img1.icarcdn.com/0463118/thumb-l_recon-car-carlist-toyota-86-gt-coupe-malaysia_000000463118_81226e7f_45e0_4e1a_85ae_9c5612120116.jpg?smia=xTM" data-image-src="https://img1.icarcdn.com/0463118/main-m_recon-car-carlist-toyota-86-gt-coupe-malaysia_000000463118_81226e7f_45e0_4e1a_85ae_9c5612120116.jpg?smia=xTM" data-make="Toyota" data-model="86" data-year="2017" data-mileage="12500" data-transmission="Automatic" data-ad-type="Recon" data-variant="GT" data-listing-status="Published" data-location="ʮʘʑʜʓʚʒʏ" data-area="ʭʘʉʜʑʔʓʚ˝ʷʜʄʜ" data-city="" data-seller-username="ʉʘʏʜʎʎʜʏʔˏ" data-seller-name="ʾʕʒʒʓʚ˝ʪʜʔ˝ʭʔʓ" data-video="" data-isbmw="" data-isvolvo="" data-seller-id="19990604-0b35-4924-b8f2-30b9f80c21bf" data-profile-type="ʮʜʑʘʎ˝ʼʚʘʓʉ" data-profile-id="0c0eff67-aa42-4aa0-99f0-c8c5965e9bc5" data-hot-deal="false" data-listing-trusted="true" data-view-store="true" data-chat-id="0" data-country-code="my" data-vehicle-type="car" data-newctr-callus="Call Now" data-newctr-exchat-detection="whatsApp_Url" data-newctr-chat-now="WhatsApp Now">
                                            <div class="grid  grid--full  cf">
                                                <header class="listing__header">
                                                    <div class="grid__item  hard  three-tenths   palm-one-half">
                                                        <a href="{{ route('product', $prod->slug) }}" class="d-block">
                                                            <img
                                                                    class="lazyload mx-auto h-140px"
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($prod->thumbnail_img) }}"
                                                                    alt="{{  $prod->getTranslation('name')  }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            >
                                                        </a>

                                                        <div class="listing__tools  action-items  push-half--top  visuallyhidden--palm">
                                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAddToCartModal({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                                Add to Cart
                                                            </a>
                                                        </div>
                                                    </div>

                                                </header>
                                                <div class="listing__content  grid__item  soft-half--sides  four-tenths  palm-one-whole relative">

                                                    <span class="nano  absolute  top--right  soft-quarter  visuallyhidden--lap-and-up">
                        </span>
                                                    <div class="listing__tools  action-items  push-half--bottom  visuallyhidden--lap-and-up">

                                                        <a class="btn btn-primary" href="javascript:void(0)" onclick="showAddToCartModal({{ $prod->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                            Add to Cart
                                                        </a>
                                                    </div>

                                                    <h2 class="listing__title  epsilon  flush">
                                                        <a class="ellipsize  js-ellipsize-text" href="{{ route('product', $prod->slug) }}" data-ellipsize-length="67" data-ga-show-type="cad-lis" data-ga-show-id="8113640">
                                                            {{ $prod->name }}</a>
                                                    </h2>

                                                    <div class="listing__excerpt  milli  text--muted  push-quarter--ends" x-ms-format-detection="none" style="font-size: 16px;">
                                                        {!! Str::limit($prod->description, 200) !!}</div>
                                                    <div class="grid  push-half--top">
                                                        <div class="grid__item  one-whole  push-half--bottom  flex">
                                                            <div class="two-thirds">

                                                                <div class="listing__price  delta  weight--bold" x-ms-format-detection="none"> RM {{$prod->unit_price  }}</div>
                                                            </div>
                                                        </div>

                                                    </div>



                                                    <div>
                                                    </div>
                                                    <div class="visuallyhidden--palm">
                                                    </div>

                                                </div>
                                            </div>
                                        </article>


                                    @endforeach
                                @else
                                    <h4 class="card-title" style="padding: 34px 0px 300px 35px"><i class="las la-frown la-3x opacity-60 mb-3"></i></h4>
                                @endif
                                <br>

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </main>


    <br>
@endsection

@section('script')
    <script>


        $(".vart").click(function(){
            $('.smenu_varients').toggleClass("smenu__filter--show-myself");

            $('.model_menus_varients').removeClass("smenu__filter--show-myself");
            $('.detail_menus_varients').removeClass("smenu__filter--show-myself");
            $('.year_menus_varients').removeClass("smenu__filter--show-myself");
            $('.type_menus_varients').removeClass("smenu__filter--show-myself");
        });
        $(".vartModels").click(function(){
            $('.model_menus_varients').toggleClass("smenu__filter--show-myself");
            $('.smenu_varients').removeClass("smenu__filter--show-myself");
            $('.detail_menus_varients').removeClass("smenu__filter--show-myself");
            $('.year_menus_varients').removeClass("smenu__filter--show-myself");
            $('.type_menus_varients').removeClass("smenu__filter--show-myself");
        });
        $(".vartDetails").click(function(){
            $('.detail_menus_varients').toggleClass("smenu__filter--show-myself");

            $('.smenu_varients').removeClass("smenu__filter--show-myself");
            $('.model_menus_varients').removeClass("smenu__filter--show-myself");
            $('.year_menus_varients').removeClass("smenu__filter--show-myself");
            $('.type_menus_varients').removeClass("smenu__filter--show-myself");
        });
        $(".vartYears").click(function(){
            $('.year_menus_varients').toggleClass("smenu__filter--show-myself");
            $('.detail_menus_varients').removeClass("smenu__filter--show-myself");
            $('.smenu_varients').removeClass("smenu__filter--show-myself");
            $('.model_menus_varients').removeClass("smenu__filter--show-myself");
            $('.type_menus_varients').removeClass("smenu__filter--show-myself");
        });
        $(".vartTypes").click(function(){
            $('.type_menus_varients').toggleClass("smenu__filter--show-myself");
            $('.year_menus_varients').removeClass("smenu__filter--show-myself");
            $('.detail_menus_varients').removeClass("smenu__filter--show-myself");
            $('.smenu_varients').removeClass("smenu__filter--show-myself");
            $('.model_menus_varients').removeClass("smenu__filter--show-myself");
        });

        function closeMenu() {
            $('.type_menus_varients').removeClass("smenu__filter--show-myself");
            $('.year_menus_varients').removeClass("smenu__filter--show-myself");
            $('.detail_menus_varients').removeClass("smenu__filter--show-myself");
            $('.smenu_varients').removeClass("smenu__filter--show-myself");
            $('.model_menus_varients').removeClass("smenu__filter--show-myself");
        }
    </script>
    <script>
        jQuery("#searchBrandFilter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            jQuery(".brands_filter *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        jQuery("#searchModelFilter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            jQuery(".models_filter *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                $('.md-img').show();
                $('.smenu__select__option__icon').show();
            });
        });
        jQuery("#searchDetailsFilter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            jQuery(".details_filter *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                $('.md-img').show();
                $('.smenu__select__option__icon').show();
            });
        });
        jQuery("#searchYearsFilter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            jQuery(".years_filter *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                $('.md-img').show();
                $('.smenu__select__option__icon').show();
            });
        });
        jQuery("#searchTypesFilter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            jQuery(".types_filter *").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                $('.md-img').show();
                $('.smenu__select__option__icon').show();
            });
        });

    </script>

    <script>
        function showMenus(){
            $("body").addClass('theme  theme--my  theme--listing body__header--sticky-top no--overflow fixed show--mobile-facet');
        }
    </script>
    <script>
        function hideMenus(){
            $("body").removeClass('theme  theme--my  theme--listing body__header--sticky-top no--overflow fixed show--mobile-facet');
        }
    </script>


@endsection
