@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')

    {{--<style>--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/custom-frontend.min.css?ver=1626882282 ; media=all */--}}
        {{--@media all{--}}
            {{--.elementor *,.elementor :after,.elementor :before{-webkit-box-sizing:border-box;box-sizing:border-box;}--}}
            {{--.elementor-widget-wrap>.elementor-element{width:100%;}--}}
            {{--.elementor-widget{position:relative;}--}}
            {{--.elementor-widget:not(:last-child){margin-bottom:20px;}--}}
            {{--.elementor-element .elementor-widget-container{-webkit-transition:background .3s,border .3s,-webkit-border-radius .3s,-webkit-box-shadow .3s;transition:background .3s,border .3s,-webkit-border-radius .3s,-webkit-box-shadow .3s;-o-transition:background .3s,border .3s,border-radius .3s,box-shadow .3s;transition:background .3s,border .3s,border-radius .3s,box-shadow .3s;transition:background .3s,border .3s,border-radius .3s,box-shadow .3s,-webkit-border-radius .3s,-webkit-box-shadow .3s;}--}}
        {{--}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/post-16219.css?ver=1626882282 ; media=all */--}}
        {{--@media all{--}}
            {{--.elementor-widget:not(:last-child){margin-bottom:20px;}--}}
        {{--}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/uploads/elementor/css/post-13767.css?ver=1626882282 ; media=all */--}}
        {{--@media all{--}}
            {{--.elementor-13767 .elementor-element.elementor-element-11a7bb4>.elementor-column-wrap>.elementor-widget-wrap>.elementor-widget:not(.elementor-widget__width-auto):not(.elementor-widget__width-initial):not(:last-child):not(.elementor-absolute){margin-bottom:0;}--}}
            {{--.elementor-13767 .elementor-element.elementor-element-ede1fbc{z-index:20;}--}}
        {{--}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/themes/vehica/style.css?ver=1.0.58 ; media=all */--}}
        {{--@media all{--}}
            {{--*{outline:0;-webkit-tap-highlight-color:transparent;}--}}
            {{--*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}--}}
            {{--*:focus,*:active{outline:0 solid transparent!important;}--}}
            {{--button{font-size:14px;line-height:1.715;}--}}
            {{--@media (min-width:1023px){--}}
                {{--button{font-size:16px;line-height:1.75;}--}}
            {{--}--}}
            {{--div{display:block;}--}}
            {{--.vs__open-indicator{display:none;}--}}
            {{--.vs__actions{padding:4px 40px 0 3px!important;}--}}
            {{--.vs__actions .vs__clear{fill:var(--primary);position:absolute;background:#fff;padding:8px 13px;z-index:2;top:3px;right:5px;}--}}
            {{--@media (max-width:1023px){--}}
                {{--.vs__actions .vs__clear{top:5px;}--}}
            {{--}--}}
            {{--.vs__actions:after{position:absolute;right:26px;top:16px;content:'\f107';font-family:"font awesome 5 free";font-weight:900;color:#000;font-size:14px;}--}}
            {{--.vs__selected-options{max-height:51px!important;}--}}
            {{--@media (max-width:767px){--}}
                {{--.v-select input{font-size:16px!important;}--}}
            {{--}--}}
            {{--.vehica-button{overflow:hidden;display:inline-block;font-size:17px;line-height:21px;font-weight:600;text-align:center;color:#fff;border:0 solid transparent;box-shadow:none;cursor:pointer;padding:16px 25px;vertical-align:top;border-radius:10px;background-color:var(--primary);transition:all .2s ease-in-out;transition-property:all;transition-duration:.2s;transition-timing-function:linear;transition-delay:0s;align-items:center;transform:translateZ(0);text-decoration:none;}--}}
            {{--@media (min-width:1023px){--}}
                {{--.vehica-button:active,.vehica-button:focus,.vehica-button:hover{color:#fff;}--}}
            {{--}--}}
            {{--.vehica-button:before{content:''!important;position:absolute;top:0;left:0;transition-property:transform;transition-duration:.2s;transition-timing-function:linear;transition-delay:0s;display:block;width:100%;height:100%;background-color:rgba(255,255,255,.1);transform:scale(0,1);transform-origin:right top;z-index:-1;}--}}
            {{--@media (min-width:1023px){--}}
                {{--.vehica-button:hover:before{transform:scale(1,1);transform-origin:left top;}--}}
            {{--}--}}
            {{--.vehica-button i{margin-right:7px;}--}}
            {{--.vehica-radio{color:#6d6d6d;}--}}
            {{--@media (min-width:1023px){--}}
                {{--.vehica-radio:not(.vehica-radio--disabled):hover{color:var(--primary)!important;}--}}
                {{--.vehica-radio:not(.vehica-radio--disabled):hover label{color:var(--primary)!important;}--}}
            {{--}--}}
            {{--.vehica-radio label{transition:all .2s ease;}--}}
            {{--.vehica-radio input{cursor:pointer;position:absolute;opacity:0;height:21px;margin-top:0;margin-left:0;width:21px;z-index:1;}--}}
            {{--.vehica-radio input+label{font-size:14px;line-height:16px;display:block;position:relative;cursor:pointer;min-height:20px;padding:1px 0 0 28px;}--}}
            {{--.vehica-radio input+label:before{position:absolute;top:0;left:0;content:'';display:inline-block;vertical-align:text-top;width:17px;height:17px;background:#fff;border:solid 1px #d5d8e0;border-radius:50%;}--}}
            {{--.vehica-radio input:disabled+label{color:#b8b8b8;cursor:auto;}--}}
            {{--.vehica-radio input:disabled+label:before{box-shadow:none;background:#ddd;}--}}
            {{--.vehica-radio input:checked+label:after{content:'';position:absolute;left:5px;top:5px;width:7px;height:7px;border-radius:50%;}--}}
            {{--.vehica-radio input:checked+label:after{background:var(--primary)!important;border-color:var(--primary)!important;}--}}
            {{--.vehica-radio input:checked+label:after{background:var(--primary)!important;border-color:var(--primary)!important;}--}}
            {{--.vehica-search-classic-v2{max-width:500px;padding:0 15px;width:100%;margin:0 auto;}--}}
            {{--.vehica-search-classic-v2 input{font-weight:700;}--}}
            {{--@media (min-width:900px){--}}
                {{--.vehica-search-classic-v2{max-width:800px;}--}}
            {{--}--}}
            {{--.vehica-search-classic-v2 .v-select:not(.vs-open) input{font-weight:700;}--}}
            {{--.vehica-search-classic-v2__inner{position:relative;}--}}
            {{--@media (min-width:900px){--}}
                {{--.vehica-search-classic-v2__search-button-wrapper{margin-left:4px;}--}}
            {{--}--}}
            {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button{width:57px;height:53px;padding-left:0;padding-right:0;}--}}
            {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button .vehica-button__text{display:none;}--}}
            {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button i{margin:0;}--}}
            {{--@media (max-width:899px){--}}
                {{--.vehica-search-classic-v2__search-button-wrapper{width:100%;}--}}
                {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button{width:100%;}--}}
                {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button i{margin-left:7px;}--}}
                {{--.vehica-search-classic-v2__search-button-wrapper .vehica-button .vehica-button__text{display:inline;}--}}
            {{--}--}}
            {{--.vehica-search-classic-v2__top{display:flex;text-align:center;justify-content:center;margin-top:-10px;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio{position:relative;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio:after{content:'';width:0;height:0;border-left:7px solid transparent;border-right:7px solid transparent;border-bottom:7px solid #fff;position:absolute;bottom:-10px;left:0;right:0;margin:0 auto;display:inline-block;transition:all .3s ease-in-out;opacity:0;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio label{font-size:17px;z-index:2;font-weight:600;line-height:21px;padding:10px;margin:0 18px 18px;transition:all .3s ease-in-out;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio label:after,.vehica-search-classic-v2__top .vehica-radio label:before{display:none;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio--active:after{opacity:1;bottom:0;}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio--active label{color:var(--primary);}--}}
            {{--.vehica-search-classic-v2__top .vehica-radio{color:#fff;}--}}
            {{--.vehica-search-classic-v2__fields--wrapper{position:relative;}--}}
            {{--.vehica-search-classic-v2__fields{z-index:2;width:100%;background:#fff;border-radius:20px;padding:16px 22px 17px;box-shadow:0 3px 6px 0 rgba(0,0,0,.16);position:relative;}--}}
            {{--@media (min-width:900px){--}}
                {{--.vehica-search-classic-v2__fields{display:flex;}--}}
            {{--}--}}
            {{--.vehica-search-classic-v2__fields .vehica-search__field{width:100%;margin-bottom:10px;}--}}
            {{--@media (min-width:900px){--}}
                {{--.vehica-search-classic-v2__fields .vehica-search__field{margin:0 4px;}--}}
            {{--}--}}
            {{--.vehica-search-classic-v2-mask-bottom{content:'';display:block;position:absolute;bottom:-9px;left:0;background:#fff;width:100%;height:50%;border-bottom-left-radius:20px;border-bottom-right-radius:20px;opacity:.59;}--}}
            {{--.v-select:not(.vs-open) input{border:0 solid transparent;padding:10px 0;min-height:51px;margin:0;font-size:14px;line-height:16px;width:100%;color:#2f3b48;}--}}
            {{--.v-select:not(.vs-open) .vs__dropdown-toggle{border:1px solid #e7edf3;box-shadow:1px 1px 0 0 rgba(196,196,196,.24);padding:0 0 0 27px;background:#fff;border-radius:10px;position:relative;}--}}
            {{--.v-select:not(.vs-open) .vs__selected-options{padding:0;}--}}
            {{--.vs__clear{display:none!important;}--}}
            {{--.vs__dropdown-toggle{z-index:9000;}--}}
        {{--}--}}
        {{--/*! CSS Used from: Embedded */--}}
        {{--input,button{font-family:'Muli', Arial,Helvetica,sans-serif!important;}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.15.3 ; media=all */--}}
        {{--@media all{--}}
            {{--.fas{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1;}--}}
            {{--.fa-search:before{content:"\f002";}--}}
        {{--}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css?ver=5.15.3 ; media=all */--}}
        {{--@media all{--}}
            {{--.fas{font-family:"Font Awesome 5 Free";font-weight:900;}--}}
        {{--}--}}
        {{--/*! CSS Used from: https://demo.vehica.com/wp-content/plugins/vehica-core/assets/css/vue-select.min.css?ver=5.8 ; media=all */--}}
        {{--@media all{--}}
            {{--.v-select{position:relative;font-family:inherit;}--}}
            {{--.v-select,.v-select *{box-sizing:border-box;}--}}
            {{--.vs__dropdown-toggle{-webkit-appearance:none;-moz-appearance:none;appearance:none;display:flex;padding:0 0 4px;background:none;border:1px solid rgba(60,60,60,.26);border-radius:4px;white-space:normal;}--}}
            {{--.vs__selected-options{display:flex;flex-basis:100%;flex-grow:1;flex-wrap:wrap;padding:0 2px;position:relative;}--}}
            {{--.vs__actions{display:flex;align-items:center;padding:4px 6px 0 3px;}--}}
            {{--.vs--unsearchable .vs__dropdown-toggle{cursor:pointer;}--}}
            {{--.vs__open-indicator{fill:rgba(60,60,60,.5);transform:scale(1);transition:transform .15s cubic-bezier(1,-.115,.975,.855);transition-timing-function:cubic-bezier(1,-.115,.975,.855);}--}}
            {{--.vs__clear{fill:rgba(60,60,60,.5);padding:0;border:0;background-color:transparent;cursor:pointer;margin-right:8px;}--}}
            {{--.vs__search::-ms-clear{display:none;}--}}
            {{--.vs__search,.vs__search:focus{-webkit-appearance:none;-moz-appearance:none;appearance:none;line-height:1.4;font-size:1em;border:1px solid transparent;border-left:none;outline:none;margin:4px 0 0;padding:0 7px;background:none;box-shadow:none;width:0;max-width:100%;flex-grow:1;z-index:1;}--}}
            {{--.vs__search::-webkit-input-placeholder{color:inherit;}--}}
            {{--.vs__search::-moz-placeholder{color:inherit;}--}}
            {{--.vs__search:-ms-input-placeholder{color:inherit;}--}}
            {{--.vs__search::-ms-input-placeholder{color:inherit;}--}}
            {{--.vs__search::placeholder{color:inherit;}--}}
            {{--.vs--unsearchable .vs__search{opacity:1;}--}}
            {{--.vs--unsearchable:not(.vs--disabled) .vs__search:hover{cursor:pointer;}--}}
            {{--.vs__spinner{align-self:center;opacity:0;font-size:5px;text-indent:-9999em;overflow:hidden;border:.9em solid hsla(0,0%,39.2%,.1);border-left-color:rgba(60,60,60,.45);transform:translateZ(0);-webkit-animation:vSelectSpinner 1.1s linear infinite;animation:vSelectSpinner 1.1s linear infinite;transition:opacity .1s;}--}}
            {{--.vs__spinner,.vs__spinner:after{border-radius:50%;width:5em;height:5em;}--}}
        {{--}--}}
        {{--/*! CSS Used keyframes */--}}
        {{--@-webkit-keyframes vSelectSpinner{0%{transform:rotate(0deg);}to{transform:rotate(1turn);}}--}}
        {{--@keyframes vSelectSpinner{0%{transform:rotate(0deg);}to{transform:rotate(1turn);}}--}}
        {{--/*! CSS Used fontfaces */--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}--}}
        {{--@font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}--}}
        {{--@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:400;font-display:block;src:url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.eot);src:url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.eot#iefix) format("embedded-opentype"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.woff2) format("woff2"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.woff) format("woff"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.ttf) format("truetype"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-regular-400.svg#fontawesome) format("svg");}--}}
        {{--@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:900;font-display:block;src:url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.eot);src:url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.eot#iefix) format("embedded-opentype"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.woff2) format("woff2"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.woff) format("woff"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.ttf) format("truetype"),url(https://demo.vehica.com/wp-content/plugins/elementor/assets/lib/font-awesome/webfonts/fa-solid-900.svg#fontawesome) format("svg");}--}}
    {{--</style>--}}



    {{--///--}}
    {{--<style>--}}
        {{--/*! CSS Used from: https://res-bak.tuhu.org/css/global.min.css?v=201903215 */--}}

        {{--.clearfix:before,.clearfix:after{content:'\20';display:block;width:0;height:0;}--}}
        {{--.clearfix:after{clear:both;}--}}
        {{--::-webkit-input-placeholder{color:#aaa;}--}}
        {{--:-moz-placeholder{color:#aaa;}--}}
        {{--::-moz-placeholder{color:#aaa;}--}}
        {{--:-ms-input-placeholder{color:#aaa;}--}}
        {{--img{border:none;}--}}
        {{--ul,ul li,p{margin:0;padding:0;list-style-type:none;}--}}
        {{--a{color:#333;text-decoration:none;}--}}
        {{--a:hover{color:#c00;text-decoration:none;}--}}
        {{--a{cursor:pointer;}--}}
        {{--.body{padding:0 20px 10px;box-shadow:0 0 0 10px rgba(3,3,3,.2);background-color:#fff;overflow:hidden;}--}}
        {{--.body .close{position:relative;float:right;width:20px;height:16px;background:url(https://res-bak.tuhu.org/Css/images/icon_modal.png) 0 -220px;margin-top:14px;cursor:pointer;z-index:111;}--}}
        {{--.carselect-pop li{list-style:none;}--}}
        {{--.carselect-pop .tab-nav{position:relative;border-bottom:1px solid #d9d9d9;margin:20px 0 15px;}--}}
        {{--.carselect-pop .tab-nav ul li{float:left;width:140px;font-size:16px;color:#999;text-align:center;padding-bottom:12px;cursor:pointer;}--}}
        {{--.carselect-pop .tab-nav ul li.active{color:#333;}--}}
        {{--.carselect-pop .tab-nav ul li.active .i-s1{background:url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_car_h.png');}--}}
        {{--.carselect-pop .tab-nav .line{position:absolute;width:140px;height:2px;background-color:#d12e42;bottom:-1px;}--}}
        {{--.carselect-pop .tab-nav .i-txt{font-size:14px;margin-right:3px;color:#cbcbcb;}--}}
        {{--.carselect-pop .tab-nav .i-s1{display:inline-block;width:27px;height:15px;background:url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_car.png');margin-right:6px;vertical-align:-3px;}--}}
        {{--.carselect-pop .tab-nav .i-s2{display:inline-block;width:16px;height:16px;background:url('https://res-bak.tuhu.org/Image/Public/carselect-pop/i_search.png');margin-right:6px;vertical-align:-3px;}--}}
        {{--.carselect-pop .pop-content{width:10000px;}--}}
        {{--.carselect-pop .tab-content{float:left;width:900px;height:400px;min-height:200px;overflow-y:auto;overflow-x:hidden;padding-bottom:20px;margin-right:20px;}--}}
        {{--.carselect-pop .carsel-progress{height:36px;border:1px solid #d5d5d5;overflow:hidden;}--}}
        {{--.carselect-pop .carsel-progress li{float:left;width:25%;height:36px;color:#ccc;line-height:36px;font-weight:bold;font-size:15px;background:url(https://res-bak.tuhu.org/Css/images/icon_modal.png) #f7f7f7;}--}}
        {{--.carselect-pop .carsel-progress .head_div2{color:#d12a3e;background:#fff;}--}}
        {{--.carselect-pop .carsel-progress .head_div3{background-position:0 0;}--}}
        {{--.carselect-pop .carsel-progress .head_div5{background-position:0 -120px;}--}}
        {{--.carselect-pop .carsel-progress .round,.carselect-pop .carsel-progress .round2{display:inline-block;width:20px;height:20px;margin:0 10px 0 50px;border-radius:10px;color:#fff;line-height:20px;text-align:center;font-weight:700;font-size:16px;}--}}
        {{--.carselect-pop .carsel-progress .round{background:none repeat scroll 0 0 #d12a3e;}--}}
        {{--.carselect-pop .carsel-progress .round2{background:none repeat scroll 0 0 #cbcbcb;}--}}
        {{--.carselect-pop .carnav-letter{margin:18px 0;}--}}
        {{--.carselect-pop .carnav-letter li{float:left;width:20px;height:25px;margin:0 0 0 10px;line-height:25px;color:#898989;text-align:center;font-weight:700;cursor:pointer;}--}}
        {{--.carselect-pop .carnav-letter .CarZiMu1NotSel{width:40px;font-size:13px;margin-left:0;}--}}
        {{--.carselect-pop .carnav-letter .CarZiMu1NotSel{color:#898989;}--}}
        {{--.carselect-pop .carnav-letter .CarZiMuSelect,.carselect-pop .carnav-letter li:hover{background-color:#d12a3e;color:#fff;}--}}
        {{--.carselect-pop .carsel-current{margin:15px 0;}--}}
        {{--.carselect-pop .carsel-current .title{float:left;width:82px;border:1px solid #fff;font-weight:bold;font-size:14px;color:#333;line-height:25px;}--}}
        {{--.carselect-pop .carsel-list{margin-left:-20px;}--}}
        {{--.carselect-pop .carsel-list li{float:left;width:163px;height:50px;border:1px solid #ddd;line-height:50px;font-size:14px;color:#666;font-weight:bold;cursor:pointer;margin:0 0 10px 20px;text-align:center;}--}}
        {{--.carselect-pop .carsel-list li:hover{border-color:#d12b3f;color:#333;}--}}
        {{--.carselect-pop .carsel-list li .img{width:30px;height:30px;margin:0 20px 0 16px;vertical-align:-10px;}--}}
        {{--.carselect-pop .carsel-list .CarBrand,.carselect-pop .carsel-list .CarBrand2{text-align:left;}--}}
        {{--.carselect-pop #div7,.carselect-pop #div8{display:none;}--}}
        {{--.carselect-pop #Carhistory{max-height:215px;background-color:#fff;padding-bottom:5px;}--}}
        {{--.carselect-pop #Carhistory .history_img{float:left;width:20px;height:14px;margin:5px 9px 0 0;background:url(https://res-bak.tuhu.org/Image/Public/chose-car-icon.png) no-repeat 0 0;}--}}
        {{--.carselect-pop #CarOver{margin:20px 0;font-size:15px;color:#666;text-align:center;}--}}
        {{--.carselect-pop .succeed{height:84px;text-align:center;font-size:17px;color:#666;line-height:84px;border-bottom:1px dotted #c1c1c1;margin-top:10px;}--}}
        {{--.carselect-pop .succeed .icon{display:inline-block;width:26px;height:26px;background:url(https://res-bak.tuhu.org/Css/images/icon_modal.png) 0 -260px;vertical-align:-6px;margin-right:5px;}--}}
        {{--.carselect-pop .cartype-search{position:relative;width:720px;margin-bottom:20px;}--}}
        {{--.carselect-pop .cartype-search .is-text{width:698px;height:33px;border:1px solid #ddd;line-height:33px;padding:0 10px;font-size:14px;color:#151b53;outline:none;}--}}
        {{--.carselect-pop .cartype-search .btn{position:absolute;width:84px;height:33px;cursor:pointer;text-align:center;background-color:#d12a3e;color:#fff;font-size:14px;right:0;top:0;}--}}
        {{--.carselect-pop .cartype-search .icon{display:inline-block;width:15px;height:15px;background-position:-69px -90px;background-color:#d12a3e;background-image:url(https://res-bak.tuhu.org/Image/Public/icon_new.png);vertical-align:-2px;margin-right:5px;}--}}
        {{--.carselect-pop .cartype-search .vin{position:relative;float:left;width:80%;}--}}
        {{--.carselect-pop .cartype-search .vin .is-text{width:554px;}--}}
        {{--.carselect-pop .cartype-search .vin .i-txt{display:inline-block;height:10px;line-height:10px;color:#fff;border:1px solid #fff;padding:1px;margin-right:3px;font-size:12px;font-style:normal;-moz-transform:scale(.85);-ms-transform:scale(.85);-o-transform:scale(.85);-webkit-transform:scale(.85);transform:scale(.85);}--}}
        {{--.carselect-pop .cartype-search .tips{float:right;width:20%;position:relative;}--}}
        {{--.carselect-pop .cartype-search .tips span{display:block;font-size:14px;color:#2c59b8;text-align:right;line-height:35px;}--}}
        {{--.carselect-pop .cartype-search .tips span i{display:inline-block;width:16px;height:16px;background:url(https://res-bak.tuhu.org/Image/Public/icon_new.png) 0 -61px no-repeat;font-size:0;vertical-align:-3px;}--}}
        {{--.carselect-pop .nodata-tips,.carselect-pop .nodata{position:relative;width:346px;height:278px;margin:60px auto 0;}--}}
        {{--.carselect-pop .nodata-tips p,.carselect-pop .nodata p{position:absolute;width:170px;height:50px;line-height:25px;font-size:18px;color:#333;right:10px;top:15px;}--}}
        {{--.carselect-pop .nodata{background:url('https://res-bak.tuhu.org/Image/Public/carselect-pop/people_sad.png') no-repeat;}--}}
        {{--.carselect-pop .nodata-tips{background:url('https://res-bak.tuhu.org/Image/Public/carselect-pop/people_small.png') no-repeat;}--}}
        {{--.CarZiMu1NotSel:hover{background-color:#d12a3e;color:#fff;}--}}
        {{--.CarZiMuSelect{width:20px;height:25px;float:left;line-height:25px;text-align:center;margin-left:10px;font-weight:700;cursor:pointer;background-color:#d12a3e;color:#fff;}--}}
        {{--/*! CSS Used from: https://staticfile.tuhu.org/imsdk.tuhu.cn/static/css/app.css?v=1.7.20210427071730 */--}}
        {{--.img{width:54px;border-radius:50%;}--}}
        {{--/*! CSS Used from: https://staticfile.tuhu.org/imsdk.tuhu.cn/static/css/app.css?v=1630580255502 */--}}
        {{--.img{width:54px;border-radius:50%;}--}}
        {{--/*! CSS Used from: Embedded */--}}
        {{--input[type=text]::-ms-clear{display:none;}--}}
    {{--</style>--}}
    {{--<style>--}}
        {{--.md-img{--}}
            {{--height: auto;--}}
        {{--}--}}
        {{--.md-card{--}}
            {{--height: 55px;--}}
        {{--}--}}
    {{--</style>--}}
    <section class="mt-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded card-r">
                <div class="row">
                    @if(!empty($brand))
                        <div class="col-md-3 col-lg-2 col-xs-12 col-sm-12">
                            <div class="mt-2 mb-2 md-card card-r"
                                 style="border:2px solid black; display: flex; padding: 10px;">
                                <img src="{{ uploaded_asset($brand->logo) }}" alt="{{translate('Brand')}}" class="h-15px md-img">

                                <span class="ml-2" style="line-break: anywhere;"> {{ $brand->name }}</span>

                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xs-12 col-sm-12">
                            <div class="mt-2 mb-4 md-card card-r"
                                 style="border:2px solid black; display: flex; padding: 10px;">
                                <img src="{{ uploaded_asset($model->logo) }}" alt="{{translate('Model')}}" class="h-15px md-img">

                                <span class="ml-4" style="line-break: anywhere;"> {{ $model->name }}</span>

                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xs-12 col-sm-12">
                            <div class="mt-2 mb-4 md-card card-r"
                                 style="border:2px solid black; display: flex; padding: 10px;">
                                <img src="{{ uploaded_asset($detail->logo) }}" alt="{{translate('Details')}}" class="h-15px md-img">

                                <span class="ml-2" style="line-break: anywhere;"> {{ $detail->name }}</span>

                            </div>
                        </div>
                    @endif
                </div>
                <div class="row  mb-3 align-items-baseline border-bottom">
                    <div class="col-md-4 col-lg-2 col-xs-12 col-sm-12">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Search Results</span>
                        </h3></div>

                    <div class="col-md-4 col-lg-2 col-xs-12 col-sm-12">
                        <a href="{{ route('model.home') }}" class="btn btn-success">Edit Car Models</a>
                    </div>
                    @if($cat_name == 'Tyre')
                    <div class="col-md-4 col-lg-2 col-xs-12 col-sm-12">
                        <div>
                            <a href="{{ url('get-tyres') }}" class="btn btn-primary">Find Tyres</a>
                        </div>
                    </div>
@endif
                    {{--<div class="col-3">--}}
                            {{--<select class="form-control aiz-selectpicker" name="size_cat_id" id="size_cat_id" onchange="size_subcats_ajax()">--}}
                                {{--<option value="">FIRST NUMBER</option>--}}
                                {{--@foreach(\App\SizeCategory::all() as $data)--}}
                                    {{--<option value="{{ $data->id}}">--}}
                                        {{--{{ $data->name }}--}}
                                    {{--</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="col-3">--}}

                            {{--<select class="form-control" name="sub_cat_id" id="sub_cat_id" onchange="size_childcats_ajax()">--}}
                                {{--<option value="">SECOND NUMBER</option>--}}
                            {{--</select>--}}

                    {{--</div>--}}
                    {{--<div class="col-3">--}}
                        {{--<div>--}}
                            {{--<select class="form-control" name="child_cat_id" id="child_cat_id" onchange="size_products_ajax()">--}}
                                {{--<option value="">THIRD NUMBER</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}




                </div>
              <div class="row">
                @if(count($prods)>0)
                                @foreach($prods as $prod)

                                        <div class="col-md-4 col-lg-2 col-xs-12 col-sm-12">
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
                                                       tabindex="0" style="font-size: 14px !important;">{{ $prod->name }}</a>
                                                </h3>
                                                <p class="card-text">
{{--                                                      {!! $prod->description !!}--}}
                                                    {!! Str::limit($prod->description, 80) !!}
                                                </p>
                                            </div>
                                        </div>
                                        </div>

                                @endforeach
                            @else
                                <h4 class="card-title">No data found!</h4>
                            @endif
                        </div>
                        </div>
        </div>

    </section>
    <script type="text/javascript">
        function size_subcats_ajax() {
            var cat_id = $('#size_cat_id').val();
            $.ajax({
                url : "{{ url('get-size-sub-cats') }}",
                type: 'get',
                data: {
                    id : cat_id
                },
                success: function(res)
                {
                    $('#sub_cat_id').html(res);
                },
                error: function()
                {
                    alert('failed...');

                }
            });
        }
        function size_childcats_ajax() {
            var cat_id = $('#sub_cat_id').val();
            $.ajax({
                url : "{{ url('get-size-child-cats') }}",
                type: 'get',
                data: {
                    id : cat_id
                },
                success: function(res)
                {
                    $('#child_cat_id').html(res);
                },
                error: function()
                {
                    alert('failed...');

                }
            });
        }
        function size_products_ajax() {
            var cat_id = $('#child_cat_id').val();
            $.ajax({
                url : "{{ url('get-size-products') }}",
                type: 'get',
                data: {
                    id : cat_id
                },
                success: function(res)
                {
                    $('#size_res').html(res);
                },
                error: function()
                {
                    alert('failed...');

                }
            });
        }
    </script>
@endsection