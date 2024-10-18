<!doctype html>
@if (DB::table('languages')->where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    <title>@yield('title') | {{ get_setting('website_name') . ' | ' . get_setting('site_motto') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    @if (DB::table('languages')->where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
        <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap-rtl.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">
    <style>
        body {
            font-size: 12px;
        }
        .side-nav-title{
            letter-spacing: .05em;
            pointer-events: none;
            cursor: default;
            white-space: nowrap;
            text-transform: uppercase;
            color: #8391A2;
            font-weight: 700;
            font-size: calc(0.9375rem * .74);
            padding: 15px calc(10px * 2);
        }
        .custom-plus{
            background: #141423;
            color: white;
            border-radius: 15px;
            cursor: pointer;
        }
        .custom_btn{
            background: #C82333;
            color: white;
            border-radius: 15px;
            width: 27px;
            height: 27px;
            border: none;
        }
        .custom-delete{
            font-size: 15px;
        }
        .qty-container .input-qty{
            text-align: center;
            padding: 5.5px;
            border: 1px solid #d4d4d4;
            max-width: 50px;
        }
        .qty-container .qty-btn-minus,
        .qty-container .qty-btn-plus{
            border: 1px solid #d4d4d4;
            padding: 8px;
            font-size: 10px;
            height: 30px;
            width: 34px;
            transition: 0.3s;
        }
        .qty-container .qty-btn-plus{
            margin-left: -4px;
        }
        .qty-container .qty-btn-minus{
            margin-right: -4px;
        }
    </style>
    <script>
        var AIZ = AIZ || {};
        AIZ.local = {
            nothing_selected: '{{ translate('Nothing selected') }}',
            nothing_found: '{{ translate('Nothing found') }}',
            choose_file: '{{ translate('Choose file') }}',
            file_selected: '{{ translate('File selected') }}',
            files_selected: '{{ translate('Files selected') }}',
            add_more_files: '{{ translate('Add more files') }}',
            adding_more_files: '{{ translate('Adding more files') }}',
            drop_files_here_paste_or: '{{ translate('Drop files here, paste or') }}',
            browse: '{{ translate('Browse') }}',
            upload_complete: '{{ translate('Upload complete') }}',
            upload_paused: '{{ translate('Upload paused') }}',
            resume_upload: '{{ translate('Resume upload') }}',
            pause_upload: '{{ translate('Pause upload') }}',
            retry_upload: '{{ translate('Retry upload') }}',
            cancel_upload: '{{ translate('Cancel upload') }}',
            uploading: '{{ translate('Uploading') }}',
            processing: '{{ translate('Processing') }}',
            complete: '{{ translate('Complete') }}',
            file: '{{ translate('File') }}',
            files: '{{ translate('Files') }}',
        }
        var SITE_URL = '{{ url('/') }}';
        var CSRF = '{{ csrf_token() }}';
    </script>
    @yield('css')
</head>

<body class="">
    <div class="aiz-main-wrapper">
        @include('backend.inc.admin_sidenav')
        <div class="aiz-content-wrapper">
            @include('backend.inc.admin_nav')
            <div class="aiz-main-content">
                <div class="px-15px px-lg-25px">
                    @yield('content')
                </div>
                <div class="bg-white text-center py-3 px-15px px-lg-25px mt-auto">
                    <p class="mb-0">&copy; Carkee </p>
                </div>
            </div>
        </div>
    </div>
    @yield('modal')
    <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>
    @yield('script')
    <script src="{{ static_asset('assets/js/app.js') }}"></script>
    <script type="text/javascript">
        @foreach (session('flash_notification', collect())->toArray() as $message)
            AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
        @endforeach
        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-menu a').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change') }}', {
                        _token: '{{ csrf_token() }}',
                        locale: locale
                    }, function(data) {
                        location.reload();
                    });

                });
            });
        }

        function menuSearch() {
            var filter, item;
            filter = $("#menu-search").val().toUpperCase();
            items = $("#main-menu").find("a");
            items = items.filter(function(i, item) {
                if ($(item).find(".aiz-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item)
                    .attr('href') !== '#') {
                    return item;
                }
            });

            if (filter !== '') {
                $("#main-menu").addClass('d-none');
                $("#search-menu").html('')
                if (items.length > 0) {
                    for (i = 0; i < items.length; i++) {
                        const text = $(items[i]).find(".aiz-side-nav-text")[0].innerText;
                        const link = $(items[i]).attr('href');
                        $("#search-menu").append(
                            `<li class="aiz-side-nav-item"><a href="${link}" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>${text}</span></a></li`
                            );
                    }
                } else {
                    $("#search-menu").html(
                        `<li class="aiz-side-nav-item"><span	class="text-center text-muted d-block">{{ translate('Nothing Found') }}</span></li>`
                        );
                }
            } else {
                $("#main-menu").removeClass('d-none');
                $("#search-menu").html('')
            }
        }

    $(document).on("click",".qty-btn-plus", function() {
    var input = $(this)
    .parent(".qty-container")
    .find(".input-qty");
    var currentVal = parseInt(input.val());
    if (currentVal < input.attr('max')) {
        input.val(currentVal + 1).change();
    }
    });

    $(document).on("click",".qty-btn-minus", function() {
     var input = $(this)
    .parent(".qty-container")
    .find(".input-qty");
    var currentVal = parseInt(input.val());
    if (currentVal > input.attr('min')) {
        input.val(currentVal - 1).change();
    }
    });
    </script>
</body>

</html>
