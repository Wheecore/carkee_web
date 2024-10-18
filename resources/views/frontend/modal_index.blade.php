@extends('frontend.layouts.app')
@section('content')
    <style>
        .col-2 {
            max-width: fit-content !important;
        }
    </style>
    {{-- Categories , Sliders . Today's deal --}}
    <div class="home-banner-area mb-4 pt-3">
        <div class="">
            <div class="row gutters-10 position-relative">

                @php
                    $num_todays_deal = count(filter_products(\App\Product::where('published', 1)->where('todays_deal', 1))->get());
                    $featured_categories = \App\Models\Category::where('featured', 1)->get();
                    $hsilders = DB::table('sliders')->get();
                    
                @endphp

                <div class="col-lg-12">
                    <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true"
                        data-autoplay="true">
                        @foreach ($hsilders as $key => $value)
                            <div class="carousel-box">
                                <a href="">
                                    <img class="d-block mw-100 img-fit rounded shadow-sm overflow-hidden"
                                        src="{{ uploaded_asset($value->photo) }}" alt="{{ env('APP_NAME') }} promo"
                                        height="457" {{-- height="315" --}}
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div id="main_search_area_div"></div>
                </div>

            </div>


            <style>
                /*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/custom-frontend.min.css?ver=1626882282 ; media=all */
                @media all {

                    .elementor *,
                    .elementor :after,
                    .elementor :before {
                        -webkit-box-sizing: border-box;
                        box-sizing: border-box;
                    }

                    .elementor-widget-wrap>.elementor-element {
                        width: 100%;
                    }

                    .elementor-widget {
                        position: relative;
                    }

                    .elementor-widget:not(:last-child) {
                        margin-bottom: 20px;
                    }

                    .elementor-element .elementor-widget-container {
                        -webkit-transition: background .3s, border .3s, -webkit-border-radius .3s, -webkit-box-shadow .3s;
                        transition: background .3s, border .3s, -webkit-border-radius .3s, -webkit-box-shadow .3s;
                        -o-transition: background .3s, border .3s, border-radius .3s, box-shadow .3s;
                        transition: background .3s, border .3s, border-radius .3s, box-shadow .3s;
                        transition: background .3s, border .3s, border-radius .3s, box-shadow .3s, -webkit-border-radius .3s, -webkit-box-shadow .3s;
                    }
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/post-16219.css?ver=1626882282 ; media=all */
                @media all {
                    .elementor-widget:not(:last-child) {
                        margin-bottom: 20px;
                    }
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/post-13767.css?ver=1626882282 ; media=all */
                @media all {
                    .elementor-13767 .elementor-element.elementor-element-11a7bb4>.elementor-column-wrap>.elementor-widget-wrap>.elementor-widget:not(.elementor-widget__width-auto):not(.elementor-widget__width-initial):not(:last-child):not(.elementor-absolute) {
                        margin-bottom: 0;
                    }

                    .elementor-13767 .elementor-element.elementor-element-ede1fbc {
                        z-index: 20;
                    }
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/themes/vehica/style.css?ver=1.0.58 ; media=all */
                @media all {
                    * {
                        outline: 0;
                        -webkit-tap-highlight-color: transparent;
                    }

                    *,
                    :after,
                    :before {
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                    }

                    *:focus,
                    *:active {
                        outline: 0 solid transparent !important;
                    }

                    button {
                        font-size: 14px;
                        line-height: 1.715;
                    }

                    @media (min-width:1023px) {
                        button {
                            font-size: 16px;
                            line-height: 1.75;
                        }
                    }

                    div {
                        display: block;
                    }

                    .vs__open-indicator {
                        display: none;
                    }

                    .vs__actions {
                        padding: 4px 40px 0 3px !important;
                    }

                    .vs__actions .vs__clear {
                        fill: var(--primary);
                        position: absolute;
                        background: #fff;
                        padding: 8px 13px;
                        z-index: 2;
                        top: 3px;
                        right: 5px;
                    }

                    @media (max-width:1023px) {
                        .vs__actions .vs__clear {
                            top: 5px;
                        }
                    }

                    .vs__actions:after {
                        position: absolute;
                        right: 26px;
                        top: 16px;
                        content: '\f107';
                        font-family: "font awesome 5 free";
                        font-weight: 900;
                        color: #000;
                        font-size: 14px;
                    }

                    .vs__selected-options {
                        max-height: 51px !important;
                    }

                    @media (max-width:767px) {
                        .v-select input {
                            font-size: 16px !important;
                        }
                    }

                    .vehica-button {
                        overflow: hidden;
                        display: inline-block;
                        font-size: 17px;
                        line-height: 21px;
                        font-weight: 600;
                        text-align: center;
                        color: #fff;
                        border: 0 solid transparent;
                        box-shadow: none;
                        cursor: pointer;
                        padding: 16px 25px;
                        vertical-align: top;
                        border-radius: 10px;
                        background-color: var(--primary);
                        transition: all .2s ease-in-out;
                        transition-property: all;
                        transition-duration: .2s;
                        transition-timing-function: linear;
                        transition-delay: 0s;
                        align-items: center;
                        transform: translateZ(0);
                        text-decoration: none;
                    }

                    @media (min-width:1023px) {

                        .vehica-button:active,
                        .vehica-button:focus,
                        .vehica-button:hover {
                            color: #fff;
                        }
                    }

                    .vehica-button:before {
                        content: '' !important;
                        position: absolute;
                        top: 0;
                        left: 0;
                        transition-property: transform;
                        transition-duration: .2s;
                        transition-timing-function: linear;
                        transition-delay: 0s;
                        display: block;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(255, 255, 255, .1);
                        transform: scale(0, 1);
                        transform-origin: right top;
                        z-index: -1;
                    }

                    @media (min-width:1023px) {
                        .vehica-button:hover:before {
                            transform: scale(1, 1);
                            transform-origin: left top;
                        }
                    }

                    .vehica-button i {
                        margin-right: 7px;
                    }

                    .vehica-radio {
                        color: #6d6d6d;
                    }

                    @media (min-width:1023px) {
                        .vehica-radio:not(.vehica-radio--disabled):hover {
                            color: var(--primary) !important;
                        }

                        .vehica-radio:not(.vehica-radio--disabled):hover label {
                            color: var(--primary) !important;
                        }
                    }

                    .vehica-radio label {
                        transition: all .2s ease;
                    }

                    .vehica-radio input {
                        cursor: pointer;
                        position: absolute;
                        opacity: 0;
                        height: 21px;
                        margin-top: 0;
                        margin-left: 0;
                        width: 21px;
                        z-index: 1;
                    }

                    .vehica-radio input+label {
                        font-size: 14px;
                        line-height: 16px;
                        display: block;
                        position: relative;
                        cursor: pointer;
                        min-height: 20px;
                        padding: 1px 0 0 28px;
                    }

                    .vehica-radio input+label:before {
                        position: absolute;
                        top: 0;
                        left: 0;
                        content: '';
                        display: inline-block;
                        vertical-align: text-top;
                        width: 17px;
                        height: 17px;
                        background: #fff;
                        border: solid 1px #d5d8e0;
                        border-radius: 50%;
                    }

                    .vehica-radio input:disabled+label {
                        color: #b8b8b8;
                        cursor: auto;
                    }

                    .vehica-radio input:disabled+label:before {
                        box-shadow: none;
                        background: #ddd;
                    }

                    .vehica-radio input:checked+label:after {
                        content: '';
                        position: absolute;
                        left: 5px;
                        top: 5px;
                        width: 7px;
                        height: 7px;
                        border-radius: 50%;
                    }

                    .vehica-radio input:checked+label:after {
                        background: var(--primary) !important;
                        border-color: var(--primary) !important;
                    }

                    .vehica-radio input:checked+label:after {
                        background: var(--primary) !important;
                        border-color: var(--primary) !important;
                    }

                    .vehica-search-classic-v2 {
                        max-width: 500px;
                        padding: 0 15px;
                        width: 100%;
                        margin: 0 auto;
                    }

                    .vehica-search-classic-v2 input {
                        font-weight: 700;
                    }

                    @media (min-width:900px) {
                        .vehica-search-classic-v2 {
                            max-width: 800px;
                        }
                    }

                    .vehica-search-classic-v2 .v-select:not(.vs-open) input {
                        font-weight: 700;
                    }

                    .vehica-search-classic-v2__inner {
                        position: relative;
                    }

                    @media (min-width:900px) {
                        .vehica-search-classic-v2__search-button-wrapper {
                            margin-left: 4px;
                        }
                    }

                    .vehica-search-classic-v2__search-button-wrapper .vehica-button {
                        width: 57px;
                        height: 53px;
                        padding-left: 0;
                        padding-right: 0;
                    }

                    .vehica-search-classic-v2__search-button-wrapper .vehica-button .vehica-button__text {
                        display: none;
                    }

                    .vehica-search-classic-v2__search-button-wrapper .vehica-button i {
                        margin: 0;
                    }

                    @media (max-width:899px) {
                        .vehica-search-classic-v2__search-button-wrapper {
                            width: 100%;
                        }

                        .vehica-search-classic-v2__search-button-wrapper .vehica-button {
                            width: 100%;
                        }

                        .vehica-search-classic-v2__search-button-wrapper .vehica-button i {
                            margin-left: 7px;
                        }

                        .vehica-search-classic-v2__search-button-wrapper .vehica-button .vehica-button__text {
                            display: inline;
                        }
                    }

                    .vehica-search-classic-v2__top {
                        display: flex;
                        text-align: center;
                        justify-content: center;
                        margin-top: -10px;
                    }

                    .vehica-search-classic-v2__top .vehica-radio {
                        position: relative;
                    }

                    .vehica-search-classic-v2__top .vehica-radio:after {
                        content: '';
                        width: 0;
                        height: 0;
                        border-left: 7px solid transparent;
                        border-right: 7px solid transparent;
                        border-bottom: 7px solid #fff;
                        position: absolute;
                        bottom: -10px;
                        left: 0;
                        right: 0;
                        margin: 0 auto;
                        display: inline-block;
                        transition: all .3s ease-in-out;
                        opacity: 0;
                    }

                    .vehica-search-classic-v2__top .vehica-radio label {
                        font-size: 17px;
                        z-index: 2;
                        font-weight: 600;
                        line-height: 21px;
                        padding: 10px;
                        margin: 0 18px 18px;
                        transition: all .3s ease-in-out;
                    }

                    .vehica-search-classic-v2__top .vehica-radio label:after,
                    .vehica-search-classic-v2__top .vehica-radio label:before {
                        display: none;
                    }

                    .vehica-search-classic-v2__top .vehica-radio--active:after {
                        opacity: 1;
                        bottom: 0;
                    }

                    .vehica-search-classic-v2__top .vehica-radio--active label {
                        color: var(--primary);
                    }

                    .vehica-search-classic-v2__top .vehica-radio {
                        color: #fff;
                    }

                    .vehica-search-classic-v2__fields--wrapper {
                        position: relative;
                    }

                    .vehica-search-classic-v2__fields {
                        z-index: 2;
                        width: 100%;
                        background: #fff;
                        border-radius: 20px;
                        padding: 16px 22px 17px;
                        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, .16);
                        position: relative;
                    }

                    @media (min-width:900px) {
                        .vehica-search-classic-v2__fields {
                            display: flex;
                        }
                    }

                    .vehica-search-classic-v2__fields .vehica-search__field {
                        width: 100%;
                        margin-bottom: 10px;
                    }

                    @media (min-width:900px) {
                        .vehica-search-classic-v2__fields .vehica-search__field {
                            margin: 0 4px;
                        }
                    }

                    .vehica-search-classic-v2-mask-bottom {
                        content: '';
                        display: block;
                        position: absolute;
                        bottom: -9px;
                        left: 0;
                        background: #fff;
                        width: 100%;
                        height: 50%;
                        border-bottom-left-radius: 20px;
                        border-bottom-right-radius: 20px;
                        opacity: .59;
                    }

                    .v-select:not(.vs-open) input {
                        border: 0 solid transparent;
                        padding: 10px 0;
                        min-height: 51px;
                        margin: 0;
                        font-size: 14px;
                        line-height: 16px;
                        width: 100%;
                        color: #2f3b48;
                    }

                    .v-select:not(.vs-open) .vs__dropdown-toggle {
                        border: 1px solid #e7edf3;
                        box-shadow: 1px 1px 0 0 rgba(196, 196, 196, .24);
                        padding: 0 0 0 27px;
                        background: #fff;
                        border-radius: 10px;
                        position: relative;
                    }

                    .v-select:not(.vs-open) .vs__selected-options {
                        padding: 0;
                    }

                    .vs__clear {
                        display: none !important;
                    }

                    .vs__dropdown-toggle {
                        z-index: 9000;
                    }
                }

                /*! CSS Used from: Embedded */
                input,
                button {
                    font-family: 'Muli', Arial, Helvetica, sans-serif !important;
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3 ; media=all */
                @media all {
                    .fas {
                        -moz-osx-font-smoothing: grayscale;
                        -webkit-font-smoothing: antialiased;
                        display: inline-block;
                        font-style: normal;
                        font-variant: normal;
                        text-rendering: auto;
                        line-height: 1;
                    }

                    .fa-search:before {
                        content: "\f002";
                    }
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.3 ; media=all */
                @media all {
                    .fas {
                        font-family: "Font Awesome 5 Free";
                        font-weight: 900;
                    }
                }

                /*! CSS Used from: https://demo.vehica.com/wp-content/plugins/vehica-core/assets/css/vue-select.min.css?ver=5.8 ; media=all */
                @media all {
                    .v-select {
                        position: relative;
                        font-family: inherit;
                    }

                    .v-select,
                    .v-select * {
                        box-sizing: border-box;
                    }

                    .vs__dropdown-toggle {
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        display: flex;
                        padding: 0 0 4px;
                        background: none;
                        border: 1px solid rgba(60, 60, 60, .26);
                        border-radius: 4px;
                        white-space: normal;
                    }

                    .vs__selected-options {
                        display: flex;
                        flex-basis: 100%;
                        flex-grow: 1;
                        flex-wrap: wrap;
                        padding: 0 2px;
                        position: relative;
                    }

                    .vs__actions {
                        display: flex;
                        align-items: center;
                        padding: 4px 6px 0 3px;
                    }

                    .vs--unsearchable .vs__dropdown-toggle {
                        cursor: pointer;
                    }

                    .vs__open-indicator {
                        fill: rgba(60, 60, 60, .5);
                        transform: scale(1);
                        transition: transform .15s cubic-bezier(1, -.115, .975, .855);
                        transition-timing-function: cubic-bezier(1, -.115, .975, .855);
                    }

                    .vs__clear {
                        fill: rgba(60, 60, 60, .5);
                        padding: 0;
                        border: 0;
                        background-color: transparent;
                        cursor: pointer;
                        margin-right: 8px;
                    }

                    .vs__search::-ms-clear {
                        display: none;
                    }

                    .vs__search,
                    .vs__search:focus {
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        appearance: none;
                        line-height: 1.4;
                        font-size: 1em;
                        border: 1px solid transparent;
                        border-left: none;
                        outline: none;
                        margin: 4px 0 0;
                        padding: 0 7px;
                        background: none;
                        box-shadow: none;
                        width: 0;
                        max-width: 100%;
                        flex-grow: 1;
                        z-index: 1;
                    }

                    .vs__search::-webkit-input-placeholder {
                        color: inherit;
                    }

                    .vs__search::-moz-placeholder {
                        color: inherit;
                    }

                    .vs__search:-ms-input-placeholder {
                        color: inherit;
                    }

                    .vs__search::-ms-input-placeholder {
                        color: inherit;
                    }

                    .vs__search::placeholder {
                        color: inherit;
                    }

                    .vs--unsearchable .vs__search {
                        opacity: 1;
                    }

                    .vs--unsearchable:not(.vs--disabled) .vs__search:hover {
                        cursor: pointer;
                    }

                    .vs__spinner {
                        align-self: center;
                        opacity: 0;
                        font-size: 5px;
                        text-indent: -9999em;
                        overflow: hidden;
                        border: .9em solid hsla(0, 0%, 39.2%, .1);
                        border-left-color: rgba(60, 60, 60, .45);
                        transform: translateZ(0);
                        -webkit-animation: vSelectSpinner 1.1s linear infinite;
                        animation: vSelectSpinner 1.1s linear infinite;
                        transition: opacity .1s;
                    }

                    .vs__spinner,
                    .vs__spinner:after {
                        border-radius: 50%;
                        width: 5em;
                        height: 5em;
                    }
                }

                /*! CSS Used keyframes */
                @-webkit-keyframes vSelectSpinner {
                    0% {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(1turn);
                    }
                }

                @keyframes vSelectSpinner {
                    0% {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(1turn);
                    }
                }

                /*! CSS Used fontfaces */
                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: italic;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 300;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 400;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 500;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 600;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 700;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 800;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');
                    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');
                    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
                }

                @font-face {
                    font-family: 'Muli';
                    font-style: normal;
                    font-weight: 900;
                    src: url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');
                    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }

                @font-face {
                    font-family: "Font Awesome 5 Free";
                    font-style: normal;
                    font-weight: 400;
                    font-display: block;
                    src: url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.eot);
                    src: url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.eot#iefix) format("embedded-opentype"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.woff2) format("woff2"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.woff) format("woff"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.ttf) format("truetype"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.svg#fontawesome) format("svg");
                }

                @font-face {
                    font-family: "Font Awesome 5 Free";
                    font-style: normal;
                    font-weight: 900;
                    font-display: block;
                    src: url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.eot);
                    src: url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.eot#iefix) format("embedded-opentype"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.woff2) format("woff2"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.woff) format("woff"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.ttf) format("truetype"), url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.svg#fontawesome) format("svg");
                }
            </style>



            {{-- /// --}}
            <style>
                /*! CSS Used from: https://res-bak.tuhu.org/css/global.min.css?v=201903215 */

                .clearfix:before,
                .clearfix:after {
                    content: '\20';
                    display: block;
                    width: 0;
                    height: 0;
                }

                .clearfix:after {
                    clear: both;
                }

                ::-webkit-input-placeholder {
                    color: #aaa;
                }

                :-moz-placeholder {
                    color: #aaa;
                }

                ::-moz-placeholder {
                    color: #aaa;
                }

                :-ms-input-placeholder {
                    color: #aaa;
                }

                img {
                    border: none;
                }

                ul,
                ul li,
                p {
                    margin: 0;
                    padding: 0;
                    list-style-type: none;
                }

                a {
                    color: #333;
                    text-decoration: none;
                }

                a:hover {
                    color: #c00;
                    text-decoration: none;
                }

                a {
                    cursor: pointer;
                }

                .body {
                    padding: 0 20px 10px;
                    box-shadow: 0 0 0 10px rgba(3, 3, 3, .2);
                    background-color: white;
                    overflow: hidden;
                }

                .body .close {
                    position: relative;
                    float: right;
                    width: 20px;
                    height: 16px;
                    margin-top: 14px;
                    cursor: pointer;
                    z-index: 111;
                }

                .carselect-pop li {
                    list-style: none;
                }

                .carselect-pop .tab-nav {
                    position: relative;
                    border-bottom: 1px solid #d9d9d9;
                    margin: 20px 0 15px;
                }

                .carselect-pop .tab-nav ul li {
                    float: left;
                    width: 240px;
                    font-size: 16px;
                    color: #999;
                    text-align: center;
                    padding-bottom: 12px;
                    cursor: pointer;
                }

                .carselect-pop .tab-nav ul li.active {
                    color: #333;
                }

                .carselect-pop .tab-nav ul li.active .i-s1 {
                    background: url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_car_h.png');
                }

                .carselect-pop .tab-nav .line {
                    position: absolute;
                    width: 140px;
                    height: 2px;
                    background-color: #d12e42;
                    bottom: -1px;
                }

                .carselect-pop .tab-nav .i-txt {
                    font-size: 14px;
                    margin-right: 3px;
                    color: #cbcbcb;
                }

                .carselect-pop .tab-nav .i-s1 {
                    display: inline-block;
                    width: 27px;
                    height: 15px;
                    background: url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_car.png');
                    margin-right: 6px;
                    vertical-align: -3px;
                }

                .carselect-pop .tab-nav .i-s2 {
                    display: inline-block;
                    width: 16px;
                    height: 16px;
                    background: url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_search.png');
                    margin-right: 6px;
                    vertical-align: -3px;
                }

                .carselect-pop .pop-content {
                    width: 10000px;
                }

                .carselect-pop .tab-content {
                    float: left;
                    width: 900px;
                    height: 400px;
                    min-height: 200px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    padding-bottom: 20px;
                    margin-right: 20px;
                }

                .carselect-pop .carsel-progress {
                    height: 36px;
                    border: 1px solid #d5d5d5;
                    overflow: hidden;
                }

                .carselect-pop .carsel-progress li {
                    float: left;
                    width: 25%;
                    height: 36px;
                    color: #ccc;
                    line-height: 36px;
                    font-weight: bold;
                    font-size: 15px;
                    background: url(https://res-bak.tuhu.org/Css/images/icon_modal.png) #f7f7f7;
                }

                .carselect-pop .carsel-progress .head_div2 {
                    color: #d12a3e;
                    background: #fff;
                }

                .carselect-pop .carsel-progress .head_div3 {
                    background-position: 0 0;
                }

                .carselect-pop .carsel-progress .head_div5 {
                    background-position: 0 -120px;
                }

                .carselect-pop .carsel-progress .round,
                .carselect-pop .carsel-progress .round2 {
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    margin: 0 10px 0 50px;
                    border-radius: 10px;
                    color: #fff;
                    line-height: 20px;
                    text-align: center;
                    font-weight: 700;
                    font-size: 16px;
                }

                .carselect-pop .carsel-progress .round {
                    background: none repeat scroll 0 0 #d12a3e;
                }

                .carselect-pop .carsel-progress .round2 {
                    background: none repeat scroll 0 0 #cbcbcb;
                }

                .carselect-pop .carnav-letter {
                    margin: 18px 0;
                }

                .carselect-pop .carnav-letter li {
                    float: left;
                    width: 20px;
                    height: 25px;
                    margin: 0 0 0 10px;
                    line-height: 25px;
                    color: #898989;
                    text-align: center;
                    font-weight: 700;
                    cursor: pointer;
                }

                .carselect-pop .carnav-letter .CarZiMu1NotSel {
                    width: 40px;
                    font-size: 13px;
                    margin-left: 0;
                }

                .carselect-pop .carnav-letter .CarZiMu1NotSel {
                    color: #898989;
                }

                .carselect-pop .carnav-letter .CarZiMuSelect,
                .carselect-pop .carnav-letter li:hover {
                    background-color: #d12a3e;
                    color: #fff;
                }

                .carselect-pop .carsel-current {
                    margin: 15px 0;
                }

                .carselect-pop .carsel-current .title {
                    float: left;
                    width: 82px;
                    border: 1px solid #fff;
                    font-weight: bold;
                    font-size: 14px;
                    color: #333;
                    line-height: 25px;
                }

                .carselect-pop .carsel-list {
                    margin-left: -20px;
                }

                .carselect-pop .carsel-list li {
                    float: left;
                    width: 163px;
                    height: 50px;
                    border: 1px solid #ddd;
                    line-height: 50px;
                    font-size: 14px;
                    color: #666;
                    font-weight: bold;
                    cursor: pointer;
                    margin: 0 0 10px 20px;
                    text-align: center;
                }

                .carselect-pop .carsel-list li:hover {
                    border-color: #d12b3f;
                    color: #333;
                }

                .carselect-pop .carsel-list li .img {
                    width: 30px;
                    height: 30px;
                    margin: 0 20px 0 16px;
                    vertical-align: -10px;
                }

                .carselect-pop .carsel-list .CarBrand,
                .carselect-pop .carsel-list .CarBrand2 {
                    text-align: left;
                }

                .carselect-pop #div7,
                .carselect-pop #div8 {
                    display: none;
                }

                .carselect-pop #Carhistory {
                    max-height: 215px;
                    background-color: #fff;
                    padding-bottom: 5px;
                }

                .carselect-pop #Carhistory .history_img {
                    float: left;
                    width: 20px;
                    height: 14px;
                    margin: 5px 9px 0 0;
                    background: url(https://res-bak.tuhu.org/Image/Public/chose-car-icon.png) no-repeat 0 0;
                }

                .carselect-pop #CarOver {
                    margin: 20px 0;
                    font-size: 15px;
                    color: #666;
                    text-align: center;
                }

                .carselect-pop .succeed {
                    height: 84px;
                    text-align: center;
                    font-size: 17px;
                    color: #666;
                    line-height: 84px;
                    border-bottom: 1px dotted #c1c1c1;
                    margin-top: 10px;
                }

                .carselect-pop .succeed .icon {
                    display: inline-block;
                    width: 26px;
                    height: 26px;
                    background: url(https://res-bak.tuhu.org/Css/images/icon_modal.png) 0 -260px;
                    vertical-align: -6px;
                    margin-right: 5px;
                }

                .carselect-pop .cartype-search {
                    position: relative;
                    width: 720px;
                    margin-bottom: 20px;
                }

                .carselect-pop .cartype-search .is-text {
                    width: -webkit-fill-available;
                    height: 33px;
                    border: 1px solid #ddd;
                    line-height: 33px;
                    padding: 0 10px;
                    font-size: 14px;
                    color: #151b53;
                    outline: none;
                }

                .carselect-pop .cartype-search .btn {
                    position: absolute;
                    width: 84px;
                    height: 33px;
                    cursor: pointer;
                    text-align: center;
                    background-color: #d12a3e;
                    color: #fff;
                    font-size: 14px;
                    right: 0;
                    top: 0;
                }

                .carselect-pop .cartype-search .icon {
                    display: inline-block;
                    width: 15px;
                    height: 15px;
                    background-position: -69px -90px;
                    background-color: #d12a3e;
                    background-image: url(https://res-bak.tuhu.org/Image/Public/icon_new.png);
                    vertical-align: -2px;
                    margin-right: 5px;
                }

                .carselect-pop .cartype-search .vin {
                    position: relative;
                    float: left;
                    width: 80%;
                }

                .carselect-pop .cartype-search .vin .is-text {
                    width: 554px;
                }

                .carselect-pop .cartype-search .vin .i-txt {
                    display: inline-block;
                    height: 10px;
                    line-height: 10px;
                    color: #fff;
                    border: 1px solid #fff;
                    padding: 1px;
                    margin-right: 3px;
                    font-size: 12px;
                    font-style: normal;
                    -moz-transform: scale(.85);
                    -ms-transform: scale(.85);
                    -o-transform: scale(.85);
                    -webkit-transform: scale(.85);
                    transform: scale(.85);
                }

                .carselect-pop .cartype-search .tips {
                    float: right;
                    width: 20%;
                    position: relative;
                }

                .carselect-pop .cartype-search .tips span {
                    display: block;
                    font-size: 14px;
                    color: #2c59b8;
                    text-align: right;
                    line-height: 35px;
                }

                .carselect-pop .cartype-search .tips span i {
                    display: inline-block;
                    width: 16px;
                    height: 16px;
                    background: url(https://res-bak.tuhu.org/Image/Public/icon_new.png) 0 -61px no-repeat;
                    font-size: 0;
                    vertical-align: -3px;
                }

                .carselect-pop .nodata-tips,
                .carselect-pop .nodata {
                    position: relative;
                    width: 346px;
                    height: 278px;
                    margin: 60px auto 0;
                }

                .carselect-pop .nodata-tips p,
                .carselect-pop .nodata p {
                    position: absolute;
                    width: 170px;
                    height: 50px;
                    line-height: 25px;
                    font-size: 18px;
                    color: #333;
                    right: 10px;
                    top: 15px;
                }

                .carselect-pop .nodata {
                    background: url('https://res-bak.tuhu.org/Image/Public/carselect-pop/people_sad.png') no-repeat;
                }

                .carselect-pop .nodata-tips {
                    background: url('https://res-bak.tuhu.org/Image/Public/carselect-pop/people_small.png') no-repeat;
                }

                .CarZiMu1NotSel:hover {
                    background-color: #d12a3e;
                    color: #fff;
                }

                .CarZiMuSelect {
                    width: 20px;
                    height: 25px;
                    float: left;
                    line-height: 25px;
                    text-align: center;
                    margin-left: 10px;
                    font-weight: 700;
                    cursor: pointer;
                    background-color: #d12a3e;
                    color: #fff;
                }

                /*! CSS Used from: https://staticfile.tuhu.org/imsdk.tuhu.cn/static/css/app.css?v=1.7.20210427071730 */
                .img {
                    width: 54px;
                    border-radius: 50%;
                }

                /*! CSS Used from: https://staticfile.tuhu.org/imsdk.tuhu.cn/static/css/app.css?v=1630580255502 */
                .img {
                    width: 54px;
                    border-radius: 50%;
                }

                /*! CSS Used from: Embedded */
                input[type=text]::-ms-clear {
                    display: none;
                }
            </style>

            {{-- /// --}}


            <div id="main_search_area" style="margin-top: 50px"
                class="elementor-element elementor-element-ede1fbc elementor-widget elementor-widget-vehica_search_v2_general_widget"
                data-id="ede1fbc" data-element_type="widget" data-widget_type="vehica_search_v2_general_widget.default">
                <div class="elementor-widget-container">
                    <div class="vehica-search-classic-v2 vehica-search-classic-v2--fields-3">
                        <div class="vehica-search-classic-v2__inner">
                            <div>
                                <form>
                                    <div class="vehica-search-classic-v2__top">
                                        <div class="vehica-radio vehica-radio--active tyre" onclick="select_type('Tyre')">
                                            <input type="radio" id="vehica_6654"> <label for="vehica_6654"
                                                style="color: white">
                                                Tyre </label>
                                        </div>
                                        <div class="vehica-radio battery"><input type="radio" id="vehica_2072"
                                                onclick="select_type('Battery')"> <label for="vehica_2072"
                                                style="color: white;">
                                                Battery </label></div>
                                        <div class="vehica-radio services"><input type="radio" id="vehica_2073"
                                                onclick="select_type('Services')"> <label for="vehica_2073"
                                                style="color: white;">
                                                Services </label></div>
                                    </div>
                                    <div class="vehica-search-classic-v2__fields--wrapper">
                                        <div class="vehica-search-classic-v2__fields">
                                            <div
                                                class="vehica-search__field vehica-relation-field elementor-repeater-item-8a62863 vehica-results__field--relation_show">
                                                <div class="vehica-taxonomy-select">
                                                    <!---->
                                                    <div dir="auto" class="v-select vs--single vs--unsearchable">
                                                        <div id="vs1__combobox" role="combobox" aria-expanded="false"
                                                            aria-owns="vs1__listbox" aria-label="Search for option"
                                                            class="vs__dropdown-toggle">
                                                            <div class="vs__selected-options">
                                                                <input placeholder="All Brands" readonly="readonly"
                                                                    aria-autocomplete="list" aria-labelledby="vs1__combobox"
                                                                    aria-controls="vs1__listbox" type="search"
                                                                    autocomplete="off" class="vs__search"
                                                                    onclick="showBrandArea()">
                                                            </div>

                                                        </div>
                                                        <ul id="vs1__listbox" role="listbox"
                                                            style="display: none; visibility: hidden;"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="vehica-search__field vehica-relation-field elementor-repeater-item-851c2ff vehica-results__field--relation_show">
                                                <div class="vehica-taxonomy-select">
                                                    <!---->
                                                    <div dir="auto" class="v-select vs--single vs--unsearchable">
                                                        <div id="vs2__combobox" role="combobox" aria-expanded="false"
                                                            aria-owns="vs2__listbox" aria-label="Search for option"
                                                            class="vs__dropdown-toggle" style="padding: 0px 5px 0px 5px;">
                                                            <div class="vs__selected-options" style="display: BLOCK;">

                                                                <a href="{{ route('panic') }}"
                                                                    class="btn btn-lg btn-block btn-primary">Panic</a>


                                                            </div>

                                                        </div>
                                                        <ul id="vs2__listbox" role="listbox"
                                                            style="display: none; visibility: hidden;"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vehica-search-classic-v2-mask-bottom"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="select_value" name="select_value" value="Tyre">
        </div>
    </div>


    <style>
        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /*! CSS Used from: Embedded */
        .card0 {
            background-color: #F5F5F5;
            border-radius: 8px;
            z-index: 0;
        }

        .card00 {
            z-index: 0;
        }

        .card1 {
            margin-left: 140px;
            z-index: 0;
            border-right: 1px solid #F5F5F5;
        }

        .card2 {
            display: none;
        }

        .card2.show {
            display: block;
        }



        input:focus,
        select:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #E53935 !important;
            outline-width: 0 !important;
        }

        .form-brand {
            position: relative;
            margin-bottom: 1.5rem;
            width: 77%;
        }

        .form-control-placeholder {
            position: absolute;
            top: 0px;
            padding: 12px 2px 0 2px;
            transition: all 300ms;
            opacity: 0.5;
        }

        .form-control:focus+.form-control-placeholder,
        .form-control:valid+.form-control-placeholder {
            font-size: 95%;
            top: 10px;
            transform: translate3d(0, -100%, 0);
            opacity: 1;
            background-color: #fff;
        }

        .next-button {
            width: 18%;
            height: 50px;
            background-color: #BDBDBD;
            color: #fff;
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
        }

        .next-button:hover {
            background-color: #E53935;
            color: #fff;
        }

        .get-bonus {
            margin-left: 154px;
        }

        .pic {
            width: 230px;
            height: 110px;
        }

        #progressbar {
            position: absolute;
            left: 35px;
            overflow: hidden;
            color: #E53935;
        }

        #progressbar li {
            list-style-type: none;
            font-size: 8px;
            font-weight: 400;
            margin-bottom: 36px;
        }

        #progressbar li:nth-child(3) {
            margin-bottom: 88px;
        }

        #progressbar .step0:before {
            content: "";
            color: #fff;
        }

        #progressbar .step1:before {
            content: "";
            color: #fff;
        }

        #progressbar .step2:before {
            content: "";
            color: #fff;
        }

        #progressbar .step3:before {
            content: "";
            color: #fff;
        }

        #progressbar .step4:before {
            content: "";
            color: #fff;
        }

        #progressbar li:before {
            width: 30px;
            height: 30px;
            line-height: 30px;
            display: block;
            font-size: 20px;
            background: #fff;
            border: 2px solid #E53935;
            border-radius: 50%;
            margin: auto;
        }

        #progressbar li:last-child:before {
            width: 40px;
            height: 40px;
        }

        #progressbar li:after {
            content: '';
            width: 3px;
            height: 66px;
            background: #BDBDBD;
            position: absolute;
            left: 58px;
            top: 15px;
            z-index: -1;
        }

        #progressbar li:last-child:after {
            top: 147px;
            height: 132px;
        }

        #progressbar li:nth-child(3):after {
            top: 81px;
        }

        #progressbar li:nth-child(2):after {
            top: 0px;
        }

        #progressbar li:first-child:after {
            position: absolute;
            top: -81px;
        }

        #progressbar li.active:after {
            background: #E53935;
        }

        #progressbar li.active:before {
            background: #E53935;
            font-family: FontAwesome;
            content: "\f00c";
        }

        .tick {
            width: 100px;
            height: 100px;
        }

        .prev {
            display: block;
            position: absolute;
            left: 40px;
            top: 20px;
            cursor: pointer;
        }

        .prev:hover {
            color: #D50000 !important;
        }

        @media screen and (max-width: 912px) {
            .card00 {
                padding-top: 30px;
            }

            .card1 {
                border: none;
                margin-left: 50px;
            }

            .card2 {
                border-bottom: 1px solid #F5F5F5;
                margin-bottom: 25px;
            }

            .social {
                height: 30px;
                width: 30px;
                font-size: 15px;
                padding-top: 8px;
                margin-top: 7px;
            }

            .get-bonus {
                margin-top: 40px !important;
                margin-left: 75px;
            }

            #progressbar {
                left: -25px;
            }
        }

        /*! CSS Used fontfaces */
        @font-face {
            font-family: 'FontAwesome';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.eot?v=4.7.0');
            src: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.eot#iefix&v=4.7.0') format('embedded-opentype'), url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff2?v=4.7.0') format('woff2'), url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.woff?v=4.7.0') format('woff'), url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.ttf?v=4.7.0') format('truetype'), url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <div class="container-fluid px-1 px-md-4 py-5 mx-auto" id="brand_search_area" style="display: none">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-11 col-lg-10 col-xl-9">
                <div class="">
                    <div class="row">
                        <div class="col-12">
                            <div class="body carselect-pop bg-white card-r" id="carSelect"
                                style="z-index: 9999999; top: -40px; left: 379px;">
                                <div class="close" onclick="closeSearch()"></div>
                                <div class="tab-nav">
                                    <ul class="clearfix">
                                        <li class="active"><i class="i-s1"></i>
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">Choose a car model</font>
                                            </font>
                                        </li>

                                        <li>
                                            <div class="cartype-search"><input id="search_brand" type="text"
                                                    class="is-text ModelsText" placeholder="Such as: A3"><a
                                                    class="search-button btn Modelsbtn"><i style="vertical-align: 0px;"
                                                        class="icon"></i>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">search</font>
                                                    </font>
                                                </a></div>
                                        </li>
                                    </ul>
                                    <span class="line"></span>
                                </div>
                                <div class="pop-content">
                                    <div class="tab-content">
                                        <ul class="carsel-progress clearfix">
                                            <li class="head_div2 step0" id="cx1" style="width:20%;"><span
                                                    class="round" id="cxspan1" style="margin-left:34px;">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">1</font>
                                                    </font>
                                                </span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Choose Brand</font>
                                                </font>
                                            </li>
                                            <li class="head_div3 step1" id="cx2" style="width:20%;"><span
                                                    class="round2" id="cxspan2" style="margin-left:34px;">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">2</font>
                                                    </font>
                                                </span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Choose
                                                        Model</font>
                                                </font>
                                            </li>
                                            <li class="head_div5 step2" id="cx3" style="width:20%;"><span
                                                    class="round2" id="cxspan3" style="margin-left:34px;">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">3</font>
                                                    </font>
                                                </span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Choose
                                                        Details</font>
                                                </font>
                                            </li>
                                            <li class="head_div5 step3" id="cx4" style="width:20%;"><span
                                                    class="round2" id="cxspan4" style="margin-left:34px;">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">4</font>
                                                    </font>
                                                </span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Choose
                                                        Variants </font>
                                                </font>
                                            </li>
                                            <li class="head_div5 step4" id="cx4" style="width:20%;"><span
                                                    class="round2" id="cxspan4" style="margin-left:34px;">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">5</font>
                                                    </font>
                                                </span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Result </font>
                                                </font>
                                            </li>
                                        </ul>
                                        <br>
                                        <div id="div2">
                                            <div id="CarBrands">
                                                <ul class="clearfix carsel-list" id="brand_res">
                                                    <div class="row">
                                                        @foreach ($brands as $key => $brand)
                                                            <input type="hidden" id="b_name"
                                                                value="{{ $brand->name }}">
                                                            <div class="col-md-3" style="width: unset">
                                                                <div class="mt-2 md-card card-r"
                                                                    style="border:2px solid black; display: flex; padding: 10px;margin-left: 23px;"
                                                                    onclick="get_models(1, {{ $brand->id }})">
                                                                    <img src="{{ uploaded_asset($brand->logo) }}"
                                                                        alt="{{ translate('Brand') }}"
                                                                        class="h-15px md-img">

                                                                    <span class="ml-2" style="line-break: anywhere;">
                                                                        {{ $brand->name }}</span>

                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="Carhistory" style="display:none">
                                            <div style=" padding-top: 3px; padding-bottom: 9px"><span
                                                    style="font-size: 16px; color:#333; font-weight: bold"><span
                                                        class="history_img"></span>
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">Browsed models:</font>
                                                    </font>
                                                </span>
                                            </div>
                                            <div style="max-height: 75px; overflow-y: auto;" class="div"
                                                id="Carhistory2"></div>
                                        </div>

                                        <div id="div7">
                                            <div id="div40" class="clearfix carsel-current">
                                                <div id="div4" class="title">
                                                    <font style="vertical-align: inherit;">
                                                        <font style="vertical-align: inherit;">Selected models:</font>
                                                    </font>
                                                </div>
                                            </div>
                                            <div id="div5">
                                                <ul class="carsel-list clearfix"></ul>
                                            </div>
                                        </div>
                                        <div id="div8">
                                            <div class="succeed"><span class="icon"></span>
                                                <font style="vertical-align: inherit;">
                                                    <font style="vertical-align: inherit;">Model selection is
                                                        successful!</font>
                                                </font>
                                            </div>
                                            <div id="CarOver"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    {{-- Banner section 1 --}}
    @if (get_setting('home_banner1_images') != null)
        <div class="mb-4">
            {{-- <div class="container"> --}}
            <div class="row gutters-10">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col-xl col-md-6">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                    alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- </div> --}}
        </div>
    @endif

    {{-- Flash Deal --}}
    @php
        $flash_deals = \App\Models\Deal::where('type','today')->where('status', 1)->get();
    @endphp
    <input type="hidden" id="brand_id" name="brand_id" value="">
    <input type="hidden" id="model_id" name="model_id" value="">
    <input type="hidden" id="details_id" name="details_id" value="">



    <style>
        /*! CSS Used from: https://big-skins.com/frontend/foxic-html-demo/css/vendor/bootstrap.min.css */


        .justify-content-center {
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .pb-15 {
            padding-bottom: 15px !important;
        }

        /*! CSS Used from: https://big-skins.com/frontend/foxic-html-demo/css/style-electronics.css */
        .fade-up {
            transition: all 1000ms 100ms;
            opacity: 0;
        }

        .fade-up.lazyloaded {
            opacity: 1;
        }

        /*.row{min-width:100%;}*/
        .page-content img {
            max-width: 100%;
        }

        .holder {
            margin-top: 80px;
        }

        @media (max-width: 767px) {
            .carselect-pop .tab-content {
                width: 374px;
            }

            .holder {
                margin-top: 65px;
            }
        }

        @media (max-width: 731px) {
            .carselect-pop .tab-content {
                width: 388px;
            }
        }

        @media (max-width: 421px) {
            .carselect-pop .tab-content {
                width: 290px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (max-width: 578px) {
            .carselect-pop .tab-content {
                width: 338px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 320px) and (max-width: 568px) {
            .carselect-pop .tab-content {
                width: 290px;
            }

            .carselect-pop .cartype-search {
                width: 290px
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 411px) and (max-width: 823px) {
            .carselect-pop .tab-content {
                width: 381px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 375px) and (max-width: 667px) {
            .carselect-pop .tab-content {
                width: 343px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 280px) and (max-width: 653px) {
            .carselect-pop .tab-content {
                width: 255px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 360px) and (max-width: 640px) {
            .carselect-pop .tab-content {
                width: 327px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 540px) and (max-width: 720px) {
            .carselect-pop .tab-content {
                width: 510px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .carselect-pop .tab-content {
                width: 628px;
            }

            .holder {
                margin-top: 50px;
            }
        }

        .holder-mt-small {
            margin-top: 50px;
        }

        @media (max-width: 767px) {
            .holder-mt-small {
                margin-top: 35px;
            }
        }

        @media (max-width: 575px) {
            .holder-mt-small {
                margin-top: 30px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .col-md-quarter {
                max-width: 25%;
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
            }
        }

        .holder:not(.fullwidth) .container:not(.coming-soon-block) {
            max-width: 1400px !important;
        }

        .image-container {
            position: relative;
            overflow: hidden;
            height: 0;
        }

        .image-container>img {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
        }

        .heading-font {
            font-family: 'Montserrat', sans-serif !important;
        }

        a,
        a:hover,
        a:focus {
            transition: color .2s ease;
            outline: none;
        }

        a {
            color: #464b5c;
        }

        a:hover {
            color: #5378f4;
        }

        a:focus {
            text-decoration: none;
            color: #464b5c;
        }

        h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 17px;
            font-weight: 600;
            line-height: 1.5em;
            margin: 0 0 20px;
            padding: 0;
            color: #464b5c;
        }

        img[data-src] {
            transition: opacity .5s;
        }

        img.lazyloaded {
            opacity: 1;
        }

        .image-hover-scale {
            position: relative;
            z-index: 1;
            display: block;
            overflow: hidden;
            -webkit-backface-visibility: hidden;
        }

        .image-hover-scale>* {
            -webkit-backface-visibility: hidden;
        }

        .image-hover-scale>img {
            max-width: 100%;
            transition: transform .75s ease 0s, opacity .3s !important;
            vertical-align: middle;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            image-rendering: optimizeQuality;
        }

        .image-hover-scale:hover>img {
            transition: transform .5s ease .05s, opacity .3s !important;
            transform: scale3d(1.075, 1.075, 1);
        }

        img[data-sizes='auto'] {
            display: block;
            width: 100%;
        }

        .bnr-wrap {
            display: block;
        }

        .bnr-wrap,
        .bnr-wrap:hover {
            text-decoration: none;
        }

        .collection-grid-2 {
            margin-top: -30px;
            margin-right: -15px;
            margin-left: -15px;
            text-align: center;
        }

        .collection-grid-2:not(.slick-slider) {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .collection-grid-2>.collection-grid-2-item {
            padding: 0 15px;
        }

        @media (max-width: 575px) {
            .collection-grid-2 {
                margin-top: -20px;
                margin-right: -10px;
                margin-left: -10px;
            }

            .collection-grid-2>.collection-grid-2-item {
                margin-top: 20px;
                padding: 0 10px;
            }
        }

        .collection-grid-2-item {
            margin-top: 30px;
        }

        .collection-grid-2-item .collection-grid-2-item-inside {
            display: block;
            text-decoration: none;
            background-color: #f7f7f8;
        }

        .collection-grid-2-item img {
            display: block;
            max-width: 100%;
            max-height: 100%;
            margin: auto;
        }

        .collection-grid-2-img.image-container.image-hover-scale img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .collection-grid-2-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 19px;
            font-weight: 600;
            line-height: 24px;
            margin-bottom: 10px;
            transition: .2s;
            color: #464b5c;
        }

        .collection-grid-2-title:last-child {
            margin-bottom: 0;
            padding-bottom: 15px;
        }

        .collection-grid-2-title:hover {
            color: #5378f4;
        }

        .collection-grid-2-title:not(:first-child) {
            margin-top: 15px;
        }

        @media (max-width: 991px) {
            .collection-grid-2-title {
                font-size: 17px;
                line-height: 22px;
            }
        }

        /*! CSS Used from: Embedded */
        #holderCollectionGrid .collection-grid-2-title {
            font-size: 16px;
            font-weight: 600;
            color: #464b5c;
        }

        #holderCollectionGrid .collection-grid-2-title:hover {
            color: #464b5c;
        }

        /*! CSS Used fontfaces */
        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUQjIg1_i6t8kCHKm459WxRxC7mw9c.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUQjIg1_i6t8kCHKm459WxRzS7mw9c.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUQjIg1_i6t8kCHKm459WxRxi7mw9c.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUQjIg1_i6t8kCHKm459WxRxy7mw9c.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUQjIg1_i6t8kCHKm459WxRyS7m.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZOg3z8fZwnCo.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZOg3z-PZwnCo.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZOg3z8_ZwnCo.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZOg3z8vZwnCo.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZOg3z_PZw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZFgrz8fZwnCo.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZFgrz-PZwnCo.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZFgrz8_ZwnCo.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZFgrz8vZwnCo.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZFgrz_PZw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZcgvz8fZwnCo.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZcgvz-PZwnCo.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZcgvz8_ZwnCo.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZcgvz8vZwnCo.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZcgvz_PZw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZbgjz8fZwnCo.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZbgjz-PZwnCo.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZbgjz8_ZwnCo.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZbgjz8vZwnCo.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZbgjz_PZw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZSgnz8fZwnCo.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZSgnz-PZwnCo.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZSgnz8_ZwnCo.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZSgnz8vZwnCo.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: italic;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUPjIg1_i6t8kCHKm459WxZSgnz_PZw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_cJD3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_cJD3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_cJD3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_cJD3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_cJD3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUSjIg1_i6t8kCHKm459WRhyzbi.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUSjIg1_i6t8kCHKm459W1hyzbi.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUSjIg1_i6t8kCHKm459WZhyzbi.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUSjIg1_i6t8kCHKm459Wdhyzbi.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_ZpC3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_ZpC3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_ZpC3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_ZpC3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_ZpC3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_bZF3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_bZF3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_bZF3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_bZF3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_bZF3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_dJE3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_dJE3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_dJE3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_dJE3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_dJE3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_c5H3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_c5H3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_c5H3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_c5H3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_c5H3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_epG3gTD_u50.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_epG3g3D_u50.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_epG3gbD_u50.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_epG3gfD_u50.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/montserrat/v18/JTURjIg1_i6t8kCHKm45_epG3gnD_g.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
    </style>
    <section class="mb-4">

        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">
                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Today Deals</span>
                </h3>
            </div>
        </div>
    </section>



    <section class="mb-4">
        <div class="container">
            <div class="text-center my-4 text-black">
            </div>
            <div class="row gutters-5 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
                @foreach ($flash_deals as $flash_deal)
                    @foreach ($flash_deal->deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                            <div class="col mb-2">
                                <div
                                    class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                    <div class="position-relative">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                alt="{{ $product->getTranslation('name') }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </a>
                                        <div class="absolute-top-right aiz-p-hov-icon">
                                            <a href="javascript:void(0)"
                                                onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                                                data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                <i class="las la-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-md-3 p-2 text-left">
                                        <div class="rating rating-sm mt-1">
                                        </div>
                                        <div class="aiz-count-down ml-auto pb-15 ml-lg-3 align-items-center"
                                            data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach

            </div>
        </div>
    </section>


    {{-- Featured Section --}}
    <div id="section_featured">

    </div>

    {{-- Best Selling  --}}
    <div id="section_best_selling">

    </div>


    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}"
                                    class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_2_imags[$key]) }}"
                                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Category wise Products --}}
    <div id="section_home_categories">

    </div>

    {{-- Classified Product --}}
    @if (get_setting('classified_product') == 1)
        @php
            $classified_products = \App\Models\CustomerProduct::where('status', '1')
                ->where('published', '1')
                ->take(10)
                ->get();
        @endphp
        @if (count($classified_products) > 0)
            <section class="mb-4">
                <div class="container">
                    <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                        <div class="d-flex mb-3 align-items-baseline border-bottom">
                            <h3 class="h5 fw-700 mb-0">
                                <span
                                    class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Classified Ads') }}</span>
                            </h3>
                            <a href="{{ route('customer.products') }}"
                                class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View More') }}</a>
                        </div>
                        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5"
                            data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true'>
                            @foreach ($classified_products as $key => $classified_product)
                                <div class="carousel-box">
                                    <div
                                        class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                        <div class="position-relative">
                                            <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                class="d-block">
                                                <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($classified_product->thumbnail_img) }}"
                                                    alt="{{ $classified_product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                            <div class="absolute-top-left pt-2 pl-2">
                                                @if ($classified_product->conditon == 'new')
                                                    <span
                                                        class="badge badge-inline badge-success">{{ translate('new') }}</span>
                                                @elseif($classified_product->conditon == 'used')
                                                    <span
                                                        class="badge badge-inline badge-danger">{{ translate('Used') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-md-3 p-2 text-left">
                                            <div class="fs-15 mb-1">
                                                <span
                                                    class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                            </div>
                                            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                    class="d-block text-reset">{{ $classified_product->getTranslation('name') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner3_images') != null)
        <div class="mb-4">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3 mb-lg-0">
                                <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}"
                                    class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_3_imags[$key]) }}"
                                        alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <section class="mb-4" style="background: #FFFFFF">
        <style>
            h2 {
                text-align: center;
                padding: 20px;
            }

            /* Slider */

            .slick-slide {
                margin: 0px 20px;
            }

            .slick-slide img {
                width: 100%;
            }

            .slick-slider {
                position: relative;
                display: block;
                box-sizing: border-box;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                -webkit-touch-callout: none;
                -khtml-user-select: none;
                -ms-touch-action: pan-y;
                touch-action: pan-y;
                -webkit-tap-highlight-color: transparent;
            }

            .slick-list {
                position: relative;
                display: block;
                overflow: hidden;
                margin: 0;
                padding: 0;
            }

            .slick-list:focus {
                outline: none;
            }

            .slick-list.dragging {
                cursor: pointer;
                cursor: hand;
            }

            .slick-slider .slick-track,
            .slick-slider .slick-list {
                -webkit-transform: translate3d(0, 0, 0);
                -moz-transform: translate3d(0, 0, 0);
                -ms-transform: translate3d(0, 0, 0);
                -o-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
            }

            .slick-track {
                position: relative;
                top: 0;
                left: 0;
                display: block;
            }

            .slick-track:before,
            .slick-track:after {
                display: table;
                content: '';
            }

            .slick-track:after {
                clear: both;
            }

            .slick-loading .slick-track {
                visibility: hidden;
            }

            .slick-slide {
                display: none;
                float: left;
                height: 100%;
                min-height: 1px;
            }

            [dir='rtl'] .slick-slide {
                float: right;
            }

            .slick-slide img {
                display: block;
            }

            .slick-slide.slick-loading img {
                display: none;
            }

            .slick-slide.dragging img {
                pointer-events: none;
            }

            .slick-initialized .slick-slide {
                display: block;
            }

            .slick-loading .slick-slide {
                visibility: hidden;
            }

            .slick-vertical .slick-slide {
                display: block;
                height: auto;
                border: 1px solid transparent;
            }

            .slick-arrow.slick-hidden {
                display: none;
            }
        </style>
        <style>
            $primary-color: #1B95E0;

            .wrapper {
                margin-top: 50px;
                display: flex;
                left: 50%;
                transform: translateX(-50%);
                position: absolute;
            }

            .profile-card {
                box-shadow: 0px 0px 18px #ccc;
                /*width:300px;*/
                text-align: center;
                margin-right: 20px;
                margin-bottom: 20px;

                &:hover,
                &.active {
                    .profile-card-header {

                        &:after {
                            background-color: $primary-color;
                            transition: all 0.6s ease;

                        }

                        img {
                            border: 5px solid $primary-color;
                        }
                    }

                    .profile-card-footer {
                        background-color: $primary-color;
                        transition: all 0.6s ease;
                    }
                }

                &-header {
                    height: 150px;
                    position: relative;
                    z-index: 1;
                    overflow: hidden;

                    &:after {
                        position: absolute;
                        content: '';
                        border-bottom-left-radius: 50%;
                        border-bottom-right-radius: 50%;
                        width: 300px;
                        height: 200px;
                        z-index: -1;
                        left: 0;
                        top: 0;
                        margin-top: -80px;

                    }

                    img {
                        width: 100px;
                        height: 100px;
                        border-radius: 50%;
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        margin: auto;
                        border: 5px solid #fff;
                        padding: 2px;
                        background-color: #fff;
                        transition: all 0.5s ease;
                    }
                }



                &-footer {
                    height: 50px;
                    line-height: 50px;

                    ul {
                        margin-left: 0;

                        li {
                            display: inline-block;
                            text-align: left;

                            a {
                                color: #fff;
                                margin-left: 15px;
                            }
                        }
                    }
                }
            }

            @media screen and (max-width:650px) {
                .wrapper {
                    flex-direction: column;

                }
            }
        </style>


        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">
                <h3 class="h5 fw-700" style="margin-bottom: -0.01rem!important;">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Orders Feedback</span>
                </h3>
            </div>
            <section class="">
                <div class="row">
                    @foreach (DB::table('rating_orders')->get() as $order)
                        <?php
                        $user = \App\User::where('id', $order->user_id)->first();
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-12">
                            <div class="profile-card"
                                style="border-radius: 0px 40px 0px 40px !important; background: #8080800d">
                                <div class="profile-card-header image-hover-scale">
                                    @if ($user->avatar_original != null)
                                        <img src="{{ uploaded_asset($user->avatar_original) }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                            style="border-radius: 0px 40px 0px 0px !important;">
                                    @else
                                        <img src="{{ static_asset('assets/img/avatar-place.png') }}"
                                            class="image rounded-circle"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                            style="border-radius: 0px 40px 0px 0px !important;">
                                    @endif
                                </div>

                                <div class="profile-card-body">
                                    <br>
                                    <h3>{{ $user->name }}</h3>
                                </div>
                                <div class="profile-card-footer">
                                    <ul class="ratingW">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($order)
                                                @if ($order->score > $i)
                                                    <span class="la la-star-o" data-rating="1"
                                                        style="color: yellow;font-size: 20px"></span>
                                                @else
                                                    <span class="la la-star-o" data-rating="1"
                                                        style="font-size: 20px"></span>
                                                @endif
                                            @else
                                                <span class="la la-star-o" data-rating="1"
                                                    style="font-size: 20px"></span>
                                            @endif
                                        @endfor
                                    </ul>
                                    @if ($order)
                                        <p style="padding: 2px;font-size: 15px; font-family: cursive">
                                            {!! $order->description !!}</p>
                                    @endif
                                    <br>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>



@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.customer-logos').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.post('{{ route('home.section.featured') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });

            @if (get_setting('vendor_system_activation') == 1)
                $.post('{{ route('home.section.best_sellers') }}', {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    $('#section_best_sellers').html(data);
                    AIZ.plugins.slickCarousel();
                });
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {

            var current_fs, next_fs, previous_fs;
            // No BACK button on first screen
            if ($(".show").hasClass("first-screen")) {
                $(".prev").css({
                    'display': 'none'
                });
            }

            // Next button
            $(".next-button").click(function() {

                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();

                $(".prev").css({
                    'display': 'block'
                });

                $(current_fs).removeClass("show");
                $(next_fs).addClass("show");

                $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

                current_fs.animate({}, {
                    step: function() {

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });

                        next_fs.css({
                            'display': 'block'
                        });
                    }
                });
            });

            // Previous button
            $(".prev").click(function() {

                current_fs = $(".show");
                previous_fs = $(".show").prev();

                $(current_fs).removeClass("show");
                $(previous_fs).addClass("show");

                $(".prev").css({
                    'display': 'block'
                });

                if ($(".show").hasClass("first-screen")) {
                    $(".prev").css({
                        'display': 'none'
                    });
                }

                $("#progressbar li").eq($(".card2").index(current_fs)).removeClass("active");

                current_fs.animate({}, {
                    step: function() {

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });

                        previous_fs.css({
                            'display': 'block'
                        });
                    }
                });
            });

        });
    </script>

    <script>
        function get_models(key, value) {
            var category = $('#select_value').val();
            $(".step" + key).addClass("active");
            $(".step" + key).addClass("acti");
            $('#brand_id').val(value);
            $.ajax({
                url: "{{ url('get-models') }}",
                type: 'get',
                data: {
                    key: key + 1,
                    id: value,
                    // name : name
                },
                success: function(res) {
                    // $('#count_id').val(count);
                    if (res === 'empty') {
                        if (category == 'Services') {
                            window.location = $(location).attr('href') + 'searching-brand-packages/' + value +
                                '/' + category;
                        } else {
                            window.location = $(location).attr('href') + 'searching-brand-products/' + value +
                                '/' + category + '/' + 1;
                        }
                    } else {
                        $('#brand_res').html(res);
                    }
                },
                error: function() {
                    alert('failed...');

                }
            });
        }
    </script>
    <script>
        function showBrandArea() {
            $('input').blur();
            $('#main_search_area').hide();
            $('#brand_search_area').show();
        }
    </script>
    <script>
        $(document).on('click', '.search-button', function() {
            var brand = $('#search_brand').val();
            $.ajax({
                url: "{{ url('get-brand-by-search') }}",
                type: 'get',
                data: {
                    value: brand,
                },
                success: function(res) {
                    $('#brand_res').html(res);

                },
                error: function() {
                    alert('failed...');

                }
            });
        });
    </script>
    <script>
        function select_type($val) {
            if ($val == 'Tyre') {
                $('.tyre').addClass('vehica-radio--active');
                $('.battery').removeClass('vehica-radio--active');
                $('.services').removeClass('vehica-radio--active');
                $('#select_value').val($val);
            } else if ($val == 'Battery') {
                $('.tyre').removeClass('vehica-radio--active');
                $('.battery').addClass('vehica-radio--active');
                $('.services').removeClass('vehica-radio--active');
                $('#select_value').val($val);
            } else {
                $('.tyre').removeClass('vehica-radio--active');
                $('.battery').removeClass('vehica-radio--active');
                $('.services').addClass('vehica-radio--active');
                $('#select_value').val($val);
            }

        }

        function closeSearch() {
            $('#brand_search_area').hide();
            $('#main_search_area').show();
        }
    </script>
    <script>
        $(document).ready(function() {
            var scrollDiv = document.getElementById("main_search_area_div").offsetTop;
            window.scrollTo({
                top: scrollDiv,
                behavior: 'smooth'
            });
        });
    </script>
@endsection
