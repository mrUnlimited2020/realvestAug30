<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>

    @include('partials.seo')

    <link href="{{ asset($activeTemplateTrue . 'css/bootstrap-5.2.3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/global/css/line-awesome.min.css') }}" rel="stylesheet">

    @stack('style-lib')

    <link href="{{ asset($activeTemplateTrue . 'css/main.css') }}" rel="stylesheet">
    <link href="{{ asset($activeTemplateTrue . 'css/custom.css') }}" rel="stylesheet">

    @stack('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">
</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>

    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    @stack('fbComment')

    @yield('main-content')

    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}"
                    target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    @stack('script-lib')

    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')

    <script>
        (function($) {
            "use strict";

            $(".langSel").on("click", function() {
                var value = $(this).data('value');
                window.location.href = "{{ route('home') }}/change/" + value;
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });
            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);
            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });
            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });
            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });
        })(jQuery);
    </script>
</body>

</html>
