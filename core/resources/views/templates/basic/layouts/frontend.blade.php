@extends($activeTemplate . 'layouts.app')

@section('main-content')
    @include($activeTemplate . 'partials.header')
    @includeWhen(!request()->routeIs('home'), $activeTemplate . 'partials.breadcrumb')
    @yield('content')
    @include($activeTemplate . 'partials.footer')
@endsection

@push('style-lib')
    <link href="{{ asset($activeTemplateTrue . 'css/slick.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let elements = document.querySelectorAll('[data-s-break]');
            Array.from(elements).forEach(element => {
                let html = element.innerText;
                if (typeof html != 'string') {
                    return false;
                }
                html = html.split('');
                let lastValue = html.pop();
                let colorText = `<span>${lastValue}</span>`;
                html.push(colorText);
                html = html.join("");
                element.innerHTML = html;
            });
        })(jQuery);
    </script>
@endpush
