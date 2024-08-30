@extends($activeTemplate . 'layouts.app')
@section('main-content')
    @include($activeTemplate . 'partials.header')
    @include($activeTemplate . 'partials.breadcrumb')
    <div class="dashboard py-60 position-relative">
        <div class="container ">
            <div class="dashboard__wrapper">
                @include($activeTemplate . 'partials.sidenav')
                <div class="dashboard-body">
                    <div class="flex-between breadcrumb-dashboard">
                        <div class="show-sidebar-btn mb-4">
                            <i class="fas fa-bars"></i>
                        </div>
                        @stack('breadcrumb')
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include($activeTemplate . 'partials.footer')
@endsection

@push('script')
    <script>
        $('.showFilterBtn').on('click', function() {
            $('.responsive-filter-card').slideToggle();
        });
    </script>
@endpush
