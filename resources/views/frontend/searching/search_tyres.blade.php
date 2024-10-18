@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')

    <style>
        /*! CSS Used from: https://www.goodyear.com.my/wp-content/cache/autoptimize/css/autoptimize_6d9856574fed2a284d0f08d772d6ebf7.css ; media=all */
        @media all {
            a {
                background-color: transparent;
            }

            a:active, a:hover {
                outline: 0;
            }

            img {
                border: 0;
            }

            input, select {
                color: inherit;
                font: inherit;
                margin: 0;
            }

            select {
                text-transform: none;
            }

            input::-moz-focus-inner {
                border: 0;
                padding: 0;
            }

            input {
                line-height: normal;
            }

            @media print {
                *, *:before, *:after {
                    background: transparent !important;
                    color: #000 !important;
                    -webkit-box-shadow: none !important;
                    box-shadow: none !important;
                    text-shadow: none !important;
                }

                a, a:visited {
                    text-decoration: underline;
                }

                a[href]:after {
                    content: " (" attr(href) ")";
                }

                img {
                    page-break-inside: avoid;
                }

                img {
                    max-width: 100% !important;
                }

                p {
                    orphans: 3;
                    widows: 3;
                }

                select {
                    background: #fff !important;
                }
            }
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            *:before, *:after {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            input, select {
                font-family: inherit;
                font-size: inherit;
                line-height: inherit;
            }

            a {
                color: #337ab7;
                text-decoration: none;
            }

            a:hover, a:focus {
                color: #23527c;
                text-decoration: underline;
            }

            a:focus {
                outline: thin dotted;
                outline: 5px auto -webkit-focus-ring-color;
                outline-offset: -2px;
            }

            img {
                vertical-align: middle;
            }

            p {
                margin: 0 0 10px;
            }

            .text-center {
                text-align: center;
            }

            .container {
                margin-right: auto;
                margin-left: auto;
                padding-left: 15px;
                padding-right: 15px;
            }

            @media (min-width: 768px) {
                .container {
                    width: 750px;
                }
            }
            @media (min-width: 992px) {
                .container {
                    width: 970px;
                }
            }
            @media (min-width: 1200px) {
                .container {
                    width: 1130px;
                }
            }
            .row {
                margin-left: -15px;
                margin-right: -15px;
            }

            .btn {
                display: inline-block;
                margin-bottom: 0;
                font-weight: normal;
                text-align: center;
                vertical-align: middle;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                cursor: pointer;
                background-image: none;
                border: 1px solid transparent;
                white-space: nowrap;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                border-radius: 4px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            .btn:focus, .btn:active:focus, .btn.active:focus {
                outline: thin dotted;
                outline: 5px auto -webkit-focus-ring-color;
                outline-offset: -2px;
            }

            .btn:hover, .btn:focus {
                color: #333;
                text-decoration: none;
            }

            .btn:active, .btn.active {
                outline: 0;
                background-image: none;
                -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
                box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            }

            .btn-group {
                position: relative;
                display: inline-block;
                vertical-align: middle;
            }

            .btn-group > .btn {
                position: relative;
                float: left;
            }

            .btn-group > .btn:hover, .btn-group > .btn:focus, .btn-group > .btn:active, .btn-group > .btn.active {
                z-index: 2;
            }

            .btn-group > .btn:first-child {
                margin-left: 0;
            }

            .container:before, .container:after, .row:before, .row:after {
                content: " ";
                display: table;
            }

            .container:after, .row:after {
                clear: both;
            }

            a {
                background-color: transparent;
            }

            a:active, a:hover {
                outline: 0;
            }

            img {
                border: 0;
            }

            input, select {
                color: inherit;
                font: inherit;
                margin: 0;
            }

            select {
                text-transform: none;
            }

            input::-moz-focus-inner {
                border: 0;
                padding: 0;
            }

            input {
                line-height: normal;
            }

            select::-ms-expand {
                display: none;
            }

            select:disabled {
                background-color: #f2f2f2;
            }

            * {
                margin: 0;
                padding: 0;
                text-decoration: none;
            }

            .container {
                width: 100%;
                padding: 0 50px;
            }

            .preload {
                position: fixed;
                width: 100%;
                height: 100%;
                text-align: center;
                background: #fff;
                z-index: 9999999;
                top: 0;
            }

            .preload:before {
                content: '';
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }

            .preload img {
                display: inline-block;
                vertical-align: middle;
            }

            .preload-tyre {
                display: inline-block;
                vertical-align: middle;
                width: 82px;
                height: 82px;
                margin-right: 10px;
                background-image: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/preloadtyre.png);
                background-size: 82px 82px;
                -webkit-animation-name: rotate360;
                -webkit-animation-duration: 1s;
                -webkit-animation-fill-mode: forwards;
                -webkit-animation-timing-function: linear;
                -webkit-animation-iteration-count: infinite;
                animation-name: rotate360;
                animation-duration: 1s;
                animation-fill-mode: forwards;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }

            a, a:hover, a:focus {
                text-decoration: none;
            }

            #wapper {
                max-width: 1200px;
                background: #e0e1e2;
            }

            .main-wrapper {
                margin: auto;
            }

            .ht_find_vehicle {
                margin-top: 20px;
            }

            .find-type {
                background: #e6eefc;
                padding-top: 25px;
                padding-bottom: 30px;
            }

            .find-type .type-detail p#find-tyre-title {
                color: #000;
                font-size: 52px;

                font-weight: 700;
                line-height: 1.1;
                margin-bottom: 20px;
            }

            .find-type .type-detail a.active {
                background: #013a82;
                color: #fff;
            }

            .find-type .type-detail .btn-group a {
                color: #000 !important;
            }

            .find-type .type-detail .btn-group a.active {
                color: #fff !important;
            }

            .find-type .type-detail a {
                color: #464648;
            }

            .find-type .type-detail .btn-type {
                border: 1px solid #c6c8ca;
                padding: 10px 35px;
                background: #fff;
                color: #464648;

                text-transform: uppercase;
                text-decoration: none;
                font-weight: 700;
            }

            .find-type .type-detail .btn {
                border-radius: 0;
            }

            .find-type .type-detail .btn-group {
                margin: 10px 0 25px;
            }

            select::-ms-expand {
                display: none;
            }

            select {
                -moz-appearance: none;
                -webkit-appearance: none;
                text-indent: .5px;
                text-overflow: '';
                background: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/icon-contact-select.png) right 12px center no-repeat #fff;
                border: 1px solid #ccc;
                width: 100%;
                border-radius: 0;
                color: #666;
                border-radius: 3px;
                height: 39px;
                padding: 10px;
            }

            @media all and (max-width: 767px) {
                .container {
                    padding: 0 40px;
                }

                .find-type {
                    padding-bottom: 0;
                }

                .find-type {
                    border: 0;
                }

                .find-type .type-detail p {
                    font-size: 28px;
                }
            }
            @media all and (max-width: 500px) {
                .find-type .type-detail p {
                    font-size: 20px;
                }
            }
            @media all and (max-width: 400px) {
                .container {
                    padding: 0 15px;
                }
            }
            .news-box .content-new a, .news-box .content-new a:visited {
                color: #013a82;
                text-decoration: none;
            }

            @media (max-width: 767px) {
                .findtyre_canvas .ht_find_vehicle {
                    margin: 0 1em !important;
                }
            }
            * {
                box-sizing: border-box;
            }

            .my .ht_find_vehicle .sizeoption {
                display: none;
            }

            .my .ht_find_vehicle .sizefield {
                width: 100%;
                padding: 40px;
            }

            .ht_find_vehicle .sizefield .sizefield-container {
                text-align: center;
            }

            .my .veh_size_form .sizebox_1, .my .veh_size_form .sizebox_2, .my .veh_size_form .sizebox_3 {
                width: 22%;
                display: inline-block;
                float: none;
            }

            .my .veh_size_form span.vehslash {
                float: none;
            }

            @media (max-width: 767px) {
                .veh_size_form .sizebox_1, .veh_size_form .sizebox_2, .veh_size_form .sizebox_3 {
                    width: 100% !important;
                    float: none !important;
                    margin-bottom: 10px !important;
                }
            }
            .main-wrapper {
                margin-bottom: 1px;
            }

            a, a:hover {
                color: #000;
            }

            #main-page {
                padding-bottom: 60px;
            }

            .type-detail .btn-group {
                margin: auto;
            }

            .container .container {
                width: auto;
                padding: 0;
            }

            .ht_find_vehicle span {
                color: #96989b;
            }

            #wapper {
                max-width: 100%;
            }

            .content-new img {
                max-width: 100%;
                height: auto;
            }

            .content-new .ht_find_vehicle img {
                max-width: none;
                width: 100%;
                height: auto;
            }

            .content-new a {
                color: #013a82;
                text-decoration: underline;
            }

            @media all and (max-width: 767px) {
                #wapper {
                    padding: 0;
                    margin: 20px 0;
                }

                #wapper > *:first-child {
                    margin-top: 0 !important;
                    padding-top: 0 !important;
                }

                #wapper > *:last-child {
                    margin-bottom: 0 !important;
                    padding-bottom: 0 !important;
                }

                #main-page {
                    padding: 0;
                }

                .find-type {
                    padding: 0;
                }

                .find-type .type-detail p#find-tyre-title {
                    font-size: 24px;
                    line-height: 1.2;
                }

                .find-type .type-detail .btn-group {
                    margin: 0;
                }

                .row {
                    margin-left: 0;
                    margin-right: 0;
                }

                .container {
                    padding: 0;
                }

                .type-detail .btn-group {
                    width: 50%;
                }

                .type-detail .btn-group + .btn-group {
                    margin-left: -1px;
                }

                .type-detail .btn-type {
                    width: 100%;
                }
            }
            .findtyre_canvas {
                overflow: hidden;
                position: relative;
                min-height: 30px;
            }

            .findtyre_canvas .ht_find_vehicle {
                margin-top: 0;
            }

            #findtyre_loading {
                position: absolute;
                min-height: 50px;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 100;
                overflow: hidden;
                background-color: #fff;
            }

            #findtyre_loading img {
                width: auto;
            }

            #findtyre_output {
                padding-top: 20px;
            }

            #findtyre_output:empty {
                padding: 0;
            }

            .find-type .type-detail p.subdesc {
                margin: 0 0 20px;
            }

            span.vehslash {
                font-weight: 700;
                color: #013a82;
                font-size: 30px;
                height: 39px;
                display: inline-block;
                vertical-align: top;
                padding: 0 5px;
            }

            .vehdd_size {
                background-color: #fff;
                overflow: hidden;
                position: relative;
                display: flex;
            }

            .vehdd_size .sizefield {
                overflow: hidden;
                position: relative;
                padding: 40px 10px;
                width: 65%;
                float: left;
                padding-top: 60px;
            }

            .vehdd_size .sizeoption {
                overflow: hidden;
                position: relative;
                padding: 40px 10px;
                width: 35%;
                float: left;
                background-color: #d4d4d4;
                text-align: left;
            }

            .veh_size_form .sizebox_1, .veh_size_form .sizebox_2, .veh_size_form .sizebox_3 {
                width: 30%;
                background: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/tyres/no_1.jpg) left top no-repeat;
                display: block;
                float: left;
                padding-left: 40px;
            }

            .veh_size_form .sizebox_2 {
                background: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/tyres/no_2.jpg) left top no-repeat;
            }

            .veh_size_form .sizebox_3 {
                background: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../images/tyres/no_3.jpg) left top no-repeat;
            }

            .veh_size_form span.vehslash {
                float: left;
            }

            select.vehsize {
                width: 100%;
                display: inline-block;
                vertical-align: text-bottom;
                white-space: nowrap;
                padding: 0 37px 0 15px;
            }

            select.vehsize_opt {
                width: 45%;
            }

            .findtyre_sizeimg {
                position: relative;
                overflow: hidden;
            }

            .findtyre_sizeimg img {
                width: auto;
            }

            .findtyre_sizeimg .box_left, .findtyre_sizeimg .box_right {
                width: 50%;
                float: left;
            }

            .findtyre_sizeimg .img_or {
                z-index: 99;
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -29px;
                margin-left: -29px;
            }

            .findtyre_sizeimg .img_or img {
                width: auto;
            }

            .find-type .type-detail .btn {
                min-width: 170px;
            }

            @media (max-width: 500px) {
                .find-type .type-detail p.subdesc {
                    font-size: 14px;
                    margin: 10px 0;
                }
            }
            @media all and (max-width: 767px) {
                .find-type .type-detail .btn {
                    min-width: auto;
                }

                .find-type .type-detail p.subdesc {
                    font-size: 14px;
                    margin: 10px 0;
                }

                span.vehslash {
                    display: none;
                }

                .vehdd_size {
                    display: block;
                }

                .vehdd_size .sizefield, .vehdd_size .sizeoption {
                    width: 100%;
                    padding-top: 40px;
                }

                .veh_size_form .sizebox_1, .veh_size_form .sizebox_2, .veh_size_form .sizebox_3 {
                    width: 100%;
                    float: none;
                    margin-bottom: 10px;
                }

                .findtyre_sizeimg .box_left, .findtyre_sizeimg .box_right {
                    width: 100%;
                }

                select.vehsize_opt {
                    width: 100%;
                }
            }
            .vc_column_container {
                width: 100%;
            }

            .vc_col-sm-12 {
                position: relative;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }

            @media (min-width: 768px) {
                .vc_col-sm-12 {
                    float: left;
                }

                .vc_col-sm-12 {
                    width: 100%;
                }
            }
            .vc_column_container {
                padding-left: 0;
                padding-right: 0;
            }
        }

        /*! CSS Used keyframes */
        @-webkit-keyframes rotate360 {
            from {
                -webkit-transform: rotateZ(0);
            }
            to {
                -webkit-transform: rotateZ(360deg);
            }
        }

        @keyframes rotate360 {
            from {
                -webkit-transform: rotateZ(0);
            }
            to {
                -webkit-transform: rotateZ(360deg);
            }
        }

        /*! CSS Used fontfaces */
        @font-face {
            font-family: 'FSSinclairRegular';
            src: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairRegular.eot), url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairRegular.woff) format('woff');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'FSSinclairRegular';
            src: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairMedium.eot), url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairMedium.woff) format('woff');
            font-weight: 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'FSSinclairRegular';
            src: url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairBold.eot), url(//www.goodyear.com.my/wp-content/themes/hattframework/css/../fonts/FSSinclairBold.woff) format('woff');
            font-weight: 900;
            font-style: normal;
        }
    </style>
    <style>
        /*! CSS Used from: http://localhost/911/public/assets/css/vendors.css */
        *,::after,::before{box-sizing:border-box;}
        header{display:block;}
        h6{margin-top:0;margin-bottom:.5rem;}
        ul{margin-top:0;margin-bottom:1rem;}
        ul ul{margin-bottom:0;}
        a{color:#007bff;text-decoration:none;background-color:transparent;}
        a:hover{color:#0056b3;text-decoration:underline;}
        img{vertical-align:middle;border-style:none;}
        button{border-radius:0;}
        button:focus{outline:1px dotted;outline:5px auto -webkit-focus-ring-color;}
        button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
        button,input{overflow:visible;}
        button{text-transform:none;}
        [role=button]{cursor:pointer;}
        [type=button],[type=submit],button{-webkit-appearance:button;}
        [type=button]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none;}
        h6{margin-bottom:.5rem;font-weight:500;line-height:1.2;}
        h6{font-size:1rem;}
        .list-inline{padding-left:0;list-style:none;}
        .list-inline-item{display:inline-block;}
        .list-inline-item:not(:last-child){margin-right:.5rem;}
        .container{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;}
        @media (min-width:576px){
            .container{max-width:540px;}
        }
        @media (min-width:768px){
            .container{max-width:720px;}
        }
        @media (min-width:992px){
            .container{max-width:960px;}
        }
        @media (min-width:1200px){
            .container{max-width:1140px;}
        }
        @media (min-width:576px){
            .container{max-width:540px;}
        }
        @media (min-width:768px){
            .container{max-width:720px;}
        }
        @media (min-width:992px){
            .container{max-width:960px;}
        }
        @media (min-width:1200px){
            .container{max-width:1140px;}
        }
        .col-auto,.col-xl-3{position:relative;width:100%;padding-right:15px;padding-left:15px;}
        .col-auto{-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%;}
        @media (min-width:1200px){
            .col-xl-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%;}
        }
        .form-control{display:block;width:100%;height:calc(1.5em + .75rem + 2px);padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#495057;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;border-radius:.25rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .form-control{transition:none;}
        }
        .form-control::-ms-expand{background-color:transparent;border:0;}
        .form-control:-moz-focusring{color:transparent;text-shadow:0 0 0 #495057;}
        .form-control:focus{color:#495057;background-color:#fff;border-color:#80bdff;outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
        .form-control::-webkit-input-placeholder{color:#6c757d;opacity:1;}
        .form-control::-moz-placeholder{color:#6c757d;opacity:1;}
        .form-control:-ms-input-placeholder{color:#6c757d;opacity:1;}
        .form-control::-ms-input-placeholder{color:#6c757d;opacity:1;}
        .form-control::placeholder{color:#6c757d;opacity:1;}
        .form-control:disabled{background-color:#e9ecef;opacity:1;}
        .btn{display:inline-block;font-weight:400;color:#212529;text-align:center;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-color:transparent;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .btn{transition:none;}
        }
        .btn:hover{color:#212529;text-decoration:none;}
        .btn:focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
        .btn:disabled{opacity:.65;}
        .btn-primary{color:#fff;background-color:#007bff;border-color:#007bff;}
        .btn-primary:hover{color:#fff;background-color:#0069d9;border-color:#0062cc;}
        .btn-primary:focus{color:#fff;background-color:#0069d9;border-color:#0062cc;box-shadow:0 0 0 .2rem rgba(38,143,255,.5);}
        .btn-primary:disabled{color:#fff;background-color:#007bff;border-color:#007bff;}
        .btn-sm{padding:.25rem .5rem;font-size:.875rem;line-height:1.5;border-radius:.2rem;}
        .dropdown{position:relative;}
        .dropdown-toggle{white-space:nowrap;}
        .dropdown-toggle::after{display:inline-block;margin-left:.255em;vertical-align:.255em;content:"";border-top:.3em solid;border-right:.3em solid transparent;border-bottom:0;border-left:.3em solid transparent;}
        .dropdown-toggle:empty::after{margin-left:0;}
        .dropdown-menu{position:absolute;top:100%;left:0;z-index:1000;display:none;float:left;min-width:10rem;padding:.5rem 0;margin:.125rem 0 0;font-size:1rem;color:#212529;text-align:left;list-style:none;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.15);border-radius:.25rem;}
        .dropdown-menu-left{right:auto;left:0;}
        .dropdown-menu-right{right:0;left:auto;}
        .dropdown-menu[x-placement^=bottom]{right:auto;bottom:auto;}
        .dropdown-item{display:block;width:100%;padding:.25rem 1.5rem;clear:both;font-weight:400;color:#212529;text-align:inherit;white-space:nowrap;background-color:transparent;border:0;}
        .dropdown-item:focus,.dropdown-item:hover{color:#16181b;text-decoration:none;background-color:#f8f9fa;}
        .dropdown-item:active{color:#fff;text-decoration:none;background-color:#007bff;}
        .dropdown-item:disabled{color:#6c757d;pointer-events:none;background-color:transparent;}
        .input-group{position:relative;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:stretch;align-items:stretch;width:100%;}
        .input-group>.form-control{position:relative;-ms-flex:1 1 auto;flex:1 1 auto;width:1%;min-width:0;margin-bottom:0;}
        .input-group>.form-control:focus{z-index:3;}
        .input-group>.form-control:not(:last-child){border-top-right-radius:0;border-bottom-right-radius:0;}
        .input-group-append{display:-ms-flexbox;display:flex;}
        .input-group-append .btn{position:relative;z-index:2;}
        .input-group-append .btn:focus{z-index:3;}
        .input-group-append{margin-left:-1px;}
        .input-group>.input-group-append>.btn{border-top-left-radius:0;border-bottom-left-radius:0;}
        .badge{display:inline-block;padding:.25em .4em;font-size:75%;font-weight:700;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .badge{transition:none;}
        }
        .badge:empty{display:none;}
        .btn .badge{position:relative;top:-1px;}
        .badge-pill{padding-right:.6em;padding-left:.6em;border-radius:10rem;}
        .badge-primary{color:#fff;background-color:#007bff;}
        .list-group{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;border-radius:.25rem;}
        .list-group-item{position:relative;display:block;padding:.75rem 1.25rem;background-color:#fff;border:1px solid rgba(0,0,0,.125);}
        .list-group-item:first-child{border-top-left-radius:inherit;border-top-right-radius:inherit;}
        .list-group-item:last-child{border-bottom-right-radius:inherit;border-bottom-left-radius:inherit;}
        .list-group-item:disabled{color:#6c757d;pointer-events:none;background-color:#fff;}
        .list-group-flush{border-radius:0;}
        .list-group-flush>.list-group-item{border-width:0 0 1px;}
        .list-group-flush>.list-group-item:last-child{border-bottom-width:0;}
        .bg-light{background-color:#f8f9fa!important;}
        .bg-white{background-color:#fff!important;}
        .border-top{border-top:1px solid #dee2e6!important;}
        .border-bottom{border-bottom:1px solid #dee2e6!important;}
        .border-0{border:0!important;}
        .rounded{border-radius:.25rem!important;}
        .d-none{display:none!important;}
        .d-inline-block{display:inline-block!important;}
        .d-block{display:block!important;}
        .d-flex{display:-ms-flexbox!important;display:flex!important;}
        @media (min-width:992px){
            .d-lg-none{display:none!important;}
            .d-lg-block{display:block!important;}
        }
        @media (min-width:1200px){
            .d-xl-block{display:block!important;}
        }
        .flex-grow-1{-ms-flex-positive:1!important;flex-grow:1!important;}
        .justify-content-between{-ms-flex-pack:justify!important;justify-content:space-between!important;}
        .align-items-center{-ms-flex-align:center!important;align-items:center!important;}
        .align-items-stretch{-ms-flex-align:stretch!important;align-items:stretch!important;}
        .align-self-stretch{-ms-flex-item-align:stretch!important;align-self:stretch!important;}
        @media (min-width:992px){
            .justify-content-lg-start{-ms-flex-pack:start!important;justify-content:flex-start!important;}
        }
        .overflow-auto{overflow:auto!important;}
        .position-relative{position:relative!important;}
        .position-absolute{position:absolute!important;}
        .shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important;}
        .shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175)!important;}
        .w-100{width:100%!important;}
        .h-100{height:100%!important;}
        .mw-100{max-width:100%!important;}
        .mr-0{margin-right:0!important;}
        .mb-0{margin-bottom:0!important;}
        .ml-0{margin-left:0!important;}
        .mr-1{margin-right:.25rem!important;}
        .mb-1{margin-bottom:.25rem!important;}
        .ml-1{margin-left:.25rem!important;}
        .mr-2{margin-right:.5rem!important;}
        .ml-2{margin-left:.5rem!important;}
        .mr-3{margin-right:1rem!important;}
        .ml-3{margin-left:1rem!important;}
        .p-0{padding:0!important;}
        .py-0{padding-top:0!important;}
        .py-0{padding-bottom:0!important;}
        .pl-0{padding-left:0!important;}
        .p-1{padding:.25rem!important;}
        .p-2{padding:.5rem!important;}
        .py-2{padding-top:.5rem!important;}
        .px-2{padding-right:.5rem!important;}
        .py-2{padding-bottom:.5rem!important;}
        .pl-2,.px-2{padding-left:.5rem!important;}
        .p-3{padding:1rem!important;}
        .pr-3,.px-3{padding-right:1rem!important;}
        .px-3{padding-left:1rem!important;}
        .ml-auto{margin-left:auto!important;}
        .text-left{text-align:left!important;}
        .text-center{text-align:center!important;}
        .text-reset{color:inherit!important;}
        @media print{
            *,::after,::before{text-shadow:none!important;box-shadow:none!important;}
            a:not(.btn){text-decoration:underline;}
            img{page-break-inside:avoid;}
            .container{min-width:992px!important;}
            .badge{border:1px solid #000;}
        }
        .la,.las{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1;}
        .la-2x{font-size:2em;}
        .la-flip-horizontal{-webkit-transform:scale(-1,1);transform:scale(-1,1);}
        :root .la-flip-horizontal{-webkit-filter:none;filter:none;}
        .la-bell:before{content:"\f0f3";}
        .la-search:before{content:"\f002";}
        .la-shopping-cart:before{content:"\f07a";}
        .la,.las{font-family:'Line Awesome Free';font-weight:900;}
        .la.la-close:before{content:"\f00d";}
        .la.la-long-arrow-left:before{content:"\f30a";}
        /*! CSS Used from: http://localhost/911/public/assets/css/aiz-core.css */
        .c-scrollbar-light::-webkit-scrollbar{width:4px;background:rgba(24, 28, 41, 0.08);border-radius:3px;}
        .c-scrollbar-light::-webkit-scrollbar-track{background:transparent;}
        .c-scrollbar-light::-webkit-scrollbar-thumb{background:rgba(24, 28, 41, 0.1);border-radius:3px;}
        .c-scrollbar-light{scrollbar-color:rgba(24, 28, 41, 0.08);scrollbar-width:thin;}
        .img-fit{max-height:100%;width:100%;object-fit:cover;}
        .z-1{z-index:1!important;}
        .z-1020{z-index:1020!important;}
        .minw-0{min-width:0;}
        .text-truncate-2{overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;}
        .absolute-top-right{position:absolute;top:0;right:0;}
        .absolute-top-center{position:absolute;top:0;left:50%;-webkit-transform:translateX(-50%);transform:translateX(-50%);}
        .dot-loader > div{display:inline-flex;width:8px;height:8px;border-radius:100%;margin:0 2px;background:#777;-webkit-animation:loader 1.48s ease-in-out infinite both;animation:loader 1.48s ease-in-out infinite both;}
        .dot-loader > div:nth-child(1){-webkit-animation-delay:-0.32s;animation-delay:-0.32s;}
        .dot-loader > div:nth-child(2){-webkit-animation-delay:-0.16s;animation-delay:-0.16s;}
        .top-100{top:100%!important;}
        .left-0{left:0!important;}
        .fw-600{font-weight:600!important;}
        .fs-15{font-size:0.9375rem!important;}
        .fs-15{font-size:0.9375rem!important;}
        .fs-16{font-size:1rem!important;}
        .fs-18{font-size:1.125rem!important;}
        .opacity-60{opacity:0.6!important;}
        .opacity-70{opacity:0.7!important;}
        .opacity-80{opacity:0.8!important;}
        .opacity-100{opacity:1!important;}
        .shadow-sm{box-shadow:0 1px 2px 0 rgba(0, 0, 0, 0.05)!important;}
        .shadow-lg{box-shadow:0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)!important;}
        .bg-light{background-color:var(--light)!important;}
        [class*="border"]{border-color:#e2e5ec!important;}
        .size-60px{width:60px;}
        .h-30px{height:30px;}
        .size-60px{height:60px;}
        .h-250px{height:250px;}
        .py-20px{padding-top:20px;}
        .py-20px{padding-bottom:20px;}
        @media (min-width: 768px){
            .h-md-40px{height:40px;}
        }
        @media (min-width: 992px){
            .border-lg{border:1px solid #e2e5ec!important;}
        }
        @media (min-width: 1500px){
            .container{max-width:1400px;}
        }
        a,button,input,.btn{-webkit-transition:all 0.3s ease;transition:all 0.3s ease;}
        a{color:var(--primary);}
        a:hover{text-decoration:none;color:var(--hov-primary);}
        :focus,a:focus,button:focus{box-shadow:none;outline:none;}
        .aiz-topbar-item{display:-ms-flexbox;display:flex;-ms-flex-pack:distribute;justify-content:space-around;-ms-flex-align:stretch;align-items:stretch;}
        .dropdown-toggle{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;}
        .dropdown-toggle::after{border:0;content:"\f107";font-family:"Line Awesome Free";font-weight:900;font-size:80%;margin-left:0.3rem;}
        .dropdown-toggle.no-arrow::after{content:none;}
        .dropdown-menu{border-color:#e2e5ec;margin:0;border-radius:0;min-width:14rem;font-size:inherit;padding:0;-webkit-box-shadow:0 0 50px 0 rgba(82, 63, 105, 0.15);box-shadow:0 0 50px 0 rgba(82, 63, 105, 0.15);padding:0.5rem 0;border-radius:4px;max-width:100%;}
        .dropdown-menu-animated{display:block;visibility:hidden;opacity:0;-webkit-transition:margin-top 0.3s, visibility 0.3s, opacity 0.3s;transition:margin-top 0.3s, visibility 0.3s, opacity 0.3s;margin-top:20px!important;}
        .dropdown-menu.dropdown-menu-lg{width:320px;min-width:320px;}
        .dropdown-item{display:block;width:100%;padding:0.5rem 1.5rem;clear:both;font-weight:400;color:#74788d;text-align:inherit;white-space:nowrap;background-color:transparent;border:0;}
        .dropdown-item:hover,.dropdown-item:active{color:#fff!important;background-color:var(--primary);}
        .form-control{padding:0.6rem 1rem;font-size:0.875rem;height:calc(1.3125rem + 1.2rem + 2px);border:1px solid #e2e5ec;color:#898b92;}
        .form-control:focus{border-color:var(--primary);box-shadow:none;}
        .form-control::-webkit-input-placeholder{color:#898b92;}
        .form-control:-ms-input-placeholder{color:#898b92;}
        .form-control::placeholder{color:#898b92;}
        .form-control:disabled{background-color:#f7f8fa;opacity:1;border-color:#e2e5ec;}
        .btn:focus:not(.btn-shadow){box-shadow:none!important;outline:none;}
        .btn{padding:0.6rem 1.2rem;font-size:0.875rem;color:#2a3242;font-weight:inherit;}
        .btn-icon{font-size:1rem;line-height:1.4;padding:0.6rem;width:calc(2.5125rem + 2px);height:calc(2.5125rem + 2px);}
        .btn-sm{padding:0.416rem 1rem;font-size:0.8125rem;}
        .btn-sm.btn-icon{padding:0.416rem;width:calc(2.02rem + 2px);height:calc(2.02rem + 2px);}
        .btn-primary:hover,.btn-primary:focus,.btn-primary:active,.btn-primary:disabled{background-color:var(--hov-primary);border-color:var(--hov-primary);}
        .btn-primary,.btn-soft-primary:hover{background-color:var(--primary);border-color:var(--primary);color:var(--white);}
        .btn-soft-primary{background-color:var(--soft-primary);color:var(--primary);}
        .badge{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;height:18px;width:18px;font-size:0.65rem;font-weight:500;line-height:unset;}
        .badge-circle{border-radius:50%;}
        .badge.badge-dot{display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;height:8px;width:8px;}
        .badge-inline{width:auto;}
        .badge-primary{background-color:var(--primary);}
        .list-group-item{border-color:#ebedf2;}
        @media (max-width: 991px){
            .front-header-search{position:absolute;z-index:1;width:100%;height:100%;top:0;right:0;left:0;opacity:0;transform:translateY(-100%);-webkit-transform:translateY(-100%);transition:all 0.3s;-webkit-transition:all 0.3s;}
        }
        /*! CSS Used from: Embedded */
        .list-inline-item{font-family:bmwTypeNextWeb, Arial, Helvetica, sans-serif!important;font-style:normal!important;font-weight:700!important;font-size:16px!important;color:#ffffff!important;}
        a{font-family:bmwTypeNextWeb, Arial, Helvetica, sans-serif!important;font-style:normal!important;font-weight:700!important;}
        /*! CSS Used from: Embedded */
        .list-group-item{background:lemonchiffon;}
        /*! CSS Used from: Embedded */
        *,::after,::before{box-sizing:border-box;}
        ul{margin-top:0;margin-bottom:1rem;}
        a{color:#007bff;text-decoration:none;background-color:transparent;}
        a:hover{color:#0056b3;text-decoration:underline;}
        .rounded{border-radius:.25rem!important;}
        .position-relative{position:relative!important;}
        .shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important;}
        @media print{
            *,::after,::before{text-shadow:none!important;box-shadow:none!important;}
            a:not(.btn){text-decoration:underline;}
        }
        .c-scrollbar-light::-webkit-scrollbar{width:4px;background:rgba(24, 28, 41, 0.08);border-radius:3px;}
        .c-scrollbar-light::-webkit-scrollbar-track{background:transparent;}
        .c-scrollbar-light::-webkit-scrollbar-thumb{background:rgba(24, 28, 41, 0.1);border-radius:3px;}
        .c-scrollbar-light{scrollbar-color:rgba(24, 28, 41, 0.08);scrollbar-width:thin;}
        .z-1{z-index:1!important;}
        .shadow-sm{box-shadow:0 1px 2px 0 rgba(0, 0, 0, 0.05)!important;}
        a{-webkit-transition:all 0.3s ease;transition:all 0.3s ease;}
        a{color:var(--primary);}
        a:hover{text-decoration:none;color:var(--hov-primary);}
        :focus,a:focus{box-shadow:none;outline:none;}
        a{font-family:bmwTypeNextWeb, Arial, Helvetica, sans-serif!important;font-style:normal!important;font-weight:700!important;}
        @media all{
            *{outline:0;-webkit-tap-highlight-color:transparent;}
            *,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
            *:focus,*:active{outline:0 solid transparent!important;}
            div{display:block;}
        }
        ::-webkit-input-placeholder{color:#aaa;}
        :-moz-placeholder{color:#aaa;}
        ::-moz-placeholder{color:#aaa;}
        :-ms-input-placeholder{color:#aaa;}
        ul,ul li{margin:0;padding:0;list-style-type:none;}
        a{color:#333;text-decoration:none;}
        a:hover{color:#c00;text-decoration:none;}
        a{cursor:pointer;}
        a,a:hover,a:focus{transition:color .2s ease;outline:none;}
        a{color:#464b5c;}
        a:hover{color:#5378f4;}
        a:focus{text-decoration:none;color:#464b5c;}
        /*! CSS Used from: http://localhost/911/public/assets/css/test.css */
        h6{font-size:14px;line-height:1.28;}
        img{max-width:100%;}
        img[height]{max-width:none;}
        li > ul{margin-bottom:0;}
        input{border-radius:0;cursor:default;}
        input:focus,input:hover{border:1px solid #c0c9d5;}
        input[placeholder]{color:#b8c2ce;}
        input::-webkit-input-placeholder{color:#b8c2ce;}
        input::-moz-placeholder{color:#b8c2ce;}
        input:-ms-input-placeholder{color:#b8c2ce;}
        input:-moz-placeholder{color:#b8c2ce;}
        input::-ms-clear,input::-ms-reveal{display:none;height:0;width:0;}
        .input-group{position:relative;}
        .dropdown{position:relative;}
        /*! CSS Used from: Embedded */
        @media all{
            *{outline:0;-webkit-tap-highlight-color:transparent;}
            *,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
            *:focus,*:active{outline:0 solid transparent!important;}
            button{font-size:14px;line-height:1.715;}
            @media (min-width: 1023px){
                button{font-size:16px;line-height:1.75;}
            }
            div{display:block;}
        }
        input,button{font-family:'Muli', Arial, Helvetica, sans-serif!important;}
        /*! CSS Used from: Embedded */
        ::-webkit-input-placeholder{color:#aaa;}
        :-moz-placeholder{color:#aaa;}
        ::-moz-placeholder{color:#aaa;}
        :-ms-input-placeholder{color:#aaa;}
        img{border:none;}
        ul,ul li{margin:0;padding:0;list-style-type:none;}
        a{color:#333;text-decoration:none;}
        a:hover{color:#c00;text-decoration:none;}
        a{cursor:pointer;}
        input[type=text]::-ms-clear{display:none;}
        /*! CSS Used from: Embedded */
        input:focus{-moz-box-shadow:none!important;-webkit-box-shadow:none!important;box-shadow:none!important;border:1px solid #E53935!important;outline-width:0!important;}
        /*! CSS Used from: Embedded */
        a,a:hover,a:focus{transition:color .2s ease;outline:none;}
        a{color:#464b5c;}
        a:hover{color:#5378f4;}
        a:focus{text-decoration:none;color:#464b5c;}
        img[data-src]{transition:opacity .5s;}
        img.lazyloaded{opacity:1;}
        /*! CSS Used keyframes */
        @-webkit-keyframes loader{0%,      80%,      100%{-webkit-transform:scale(0);transform:scale(0);opacity:0.2;}40%{-webkit-transform:scale(1);transform:scale(1);opacity:0.8;}}
        @keyframes loader{0%,      80%,      100%{-webkit-transform:scale(0);transform:scale(0);opacity:0.2;}40%{-webkit-transform:scale(1);transform:scale(1);opacity:0.8;}}
        /*! CSS Used fontfaces */
        @font-face{font-family:'Line Awesome Free';font-style:normal;font-weight:400;font-display:swap;src:url(http://localhost/911/public/assets/fonts/la-regular-400.eot);src:url(http://localhost/911/public/assets/fonts/la-regular-400.eot#iefix) format("embedded-opentype"),url(http://localhost/911/public/assets/fonts/la-regular-400.woff2) format("woff2"),url(http://localhost/911/public/assets/fonts/la-regular-400.woff) format("woff"),url(http://localhost/911/public/assets/fonts/la-regular-400.ttf) format("truetype"),url(http://localhost/911/public/assets/fonts/la-regular-400.svg#lineawesome) format("svg");}
        @font-face{font-family:'Line Awesome Free';font-style:normal;font-weight:900;font-display:swap;src:url(http://localhost/911/public/assets/fonts/la-solid-900.eot);src:url(http://localhost/911/public/assets/fonts/la-solid-900.eot#iefix) format("embedded-opentype"),url(http://localhost/911/public/assets/fonts/la-solid-900.woff2) format("woff2"),url(http://localhost/911/public/assets/fonts/la-solid-900.woff) format("woff"),url(http://localhost/911/public/assets/fonts/la-solid-900.ttf) format("truetype"),url(http://localhost/911/public/assets/fonts/la-solid-900.svg#lineawesome) format("svg");}
        @font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IALT8kU.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2IQLT8kU.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:italic;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Au-p_0qiz-afTf2LwLT.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:300;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:400;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:500;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:600;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:700;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:800;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afT3GLRrX.woff2) format('woff2');unicode-range:U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTzGLRrX.woff2) format('woff2');unicode-range:U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;}
        @font-face{font-family:'Muli';font-style:normal;font-weight:900;src:url(https://fonts.gstatic.com/s/muli/v22/7Auwp_0qiz-afTLGLQ.woff2) format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;}
    </style>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="vc_col-sm-12 wpb_column vc_column_container">
                                            <div class="wpb_wrapper">
                                                <div class="find-type">
                                                    <div class="type-detail text-center container-fluid"><p
                                                                id="find-tyre-title">TELL US ABOUT YOUR CAR OR TYRES</p>

                                                        <div class="btn-group" role="group"><a
                                                                    href="#"
                                                                    class="btn btn-type active">By Tyre Size </a></div>
                                                        <p class="subdesc">Check your current tyres or your vehicle’s
                                                            documentation for details about your tyres and enter them in
                                                            the fields below.</p>
                                                        <div class="findtyre_canvas">
                                                            <div id="findtyre_loading" class="preload"
                                                                 style="display: none !important">

                                                                <div class="preload-tyre"></div>
                                                                <noscript><img
                                                                            src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/logo-preload.png"
                                                                            alt=""/></noscript>
                                                                <img class="lazyload"
                                                                     src="data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20210%20140%22%3E%3C/svg%3E"
                                                                     data-src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/logo-preload.png"
                                                                     alt=""></div>
                                                            <div class="ht_find_vehicle"><input type="hidden"
                                                                                                id="ajax-nonce"
                                                                                                value="79f721c7cc">
                                                                <form id="vehform" class="veh_size_form">
                                                                    <div class="vehdd_size">
                                                                        <div style="width: 18%"></div>
                                                                        <div class="sizefield">
                                                                            <div class="sizefield-container">
                                                                                <div class="sizebox_1">
                                                                                    <select class="vehsize" name="size_cat_id" id="size_cat_id"
                                                                                            onchange="size_subcats_ajax()">
                                                                                        <option value="">FIRST NUMBER</option>
                                                                                        @foreach(\App\SizeCategory::all() as $data)
                                                                                            <option value="{{ $data->id}}">
                                                                                                {{ $data->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <span class="vehslash"> / </span>
                                                                                <div class="sizebox_2">
                                                                                    <select class="vehsize" name="sub_cat_id" id="sub_cat_id" onchange="size_childcats_ajax()">
                                                                                        <option value="">SECOND NUMBER</option>
                                                                                    </select>
                                                                                </div>
                                                                                <span class="vehslash"> / </span>
                                                                                <div class="sizebox_3">

                                                                                    <select class="vehsize" name="child_cat_id" id="child_cat_id"
                                                                                            onchange="size_products_ajax()">
                                                                                        <option value="">THIRD NUMBER</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                                <div class="findtyre_sizeimg">
                                                                    <div class="box_left">
                                                                        <noscript><img
                                                                                    src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_left-1.png"
                                                                                    alt=""/></noscript>
                                                                        <img class=" lazyloaded" id="sizeimg_left"
                                                                             src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_left-3.png"
                                                                             data-src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_left-1.png"
                                                                             alt=""></div>
                                                                    <div class="box_right">
                                                                        <noscript><img
                                                                                    src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_right-1.png"
                                                                                    alt=""/></noscript>
                                                                        <img class=" lazyloaded" id="sizeimg_right"
                                                                             src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_right-off.png"
                                                                             data-src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size_right-1.png"
                                                                             alt=""></div>
                                                                    <div class="img_or">
                                                                        <noscript><img
                                                                                    src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size-or.png"
                                                                                    alt=""/></noscript>
                                                                        <img class=" lazyloaded"
                                                                             src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size-or.png"
                                                                             data-src="https://www.goodyear.com.my/wp-content/themes/hattframework/images/tyres/size-or.png"
                                                                             alt=""></div>
                                                                </div>
                                                            </div>
                                                            <div id="size_res"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--End .row--></div>


    {{--////--}}



    <script type="text/javascript">
        function size_subcats_ajax() {
            var cat_id = $('#size_cat_id').val();
            $.ajax({
                url: "{{ url('get-size-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function (res) {
                    $('#sub_cat_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }

        function size_childcats_ajax() {
            var cat_id = $('#sub_cat_id').val();
            $.ajax({
                url: "{{ url('get-size-child-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function (res) {
                    $('#child_cat_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }

        function size_products_ajax() {
            var cat_id = $('#child_cat_id').val();
            $.ajax({
                url: "{{ url('get-size-products') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function (res) {
                    $('#size_res').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }
    </script>
@endsection