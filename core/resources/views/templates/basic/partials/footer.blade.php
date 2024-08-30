@php
    $footerContent = getContent('footer.content', true);
    $footerElements = getContent('footer.element', limit: 4, orderById: true);
    $subscribeContent = getContent('subscribe.content', true);
    $contactContent = getContent('contact_us.content', true);
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<footer class="footer bg-pattern2">
    <div class="container ">
        <div class="footer-top pt-60">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-item">
                        <a href="{{ route('home') }}" class="footer-item__logo">
                            <img src="{{ siteLogo('dark') }}" alt="logo-image">
                        </a>
                        <p class="footer-item__desc">{{ __(@$footerContent->data_values->description) }}</p>
                        <ul class="social-list">
                            @foreach (@$footerElements as $footerElement)
                                <li class="social-list__item">
                                    <a href="{{ @$footerElement->data_values->social_link }}" target="_blank" class="social-list__link">
                                        @php echo @$footerElement->data_values->social_icon @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Quick links')</h6>
                        <ul class="footer-menu style-two">
                            <li class="footer-menu__item">
                                <a href="{{ route('blog') }}" class="footer-menu__link">@lang('Home')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('blog') }}" class="footer-menu__link">@lang('Blog')</a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="{{ route('contact') }}" class="footer-menu__link">@lang('Contact Us')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">@lang('Contact us')</h6>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <span class="footer-menu__link">
                                    @php
                                        echo @$contactContent->data_values->address_icon;
                                    @endphp
                                    @lang('4th Floor Bright Dominion Palace, Eputu Royal London, Eputu Ibeju Lekki, Lagos State.')
                                </span>
                            </li>
                            
                            <li class="footer-menu__item">
                                <span class="footer-menu__link">
                                    @php
                                        echo @$contactContent->data_values->address_icon;
                                    @endphp
                                    {{ __(@$contactContent->data_values->address) }}
                                </span>
                            </li>
                            
                            <li class="footer-menu__item">
                                <span class="footer-menu__link">
                                    @php echo @$contactContent->data_values->email_icon; @endphp
                                    <a href="mailto:{{ @$contactContent->data_values->email }}">{{ @$contactContent->data_values->email }}</a>
                                </span>
                            </li>
                            <!--<li class="footer-menu__item">-->
                            <!--    <span class="footer-menu__link">-->
                            <!--        @php echo @$contactContent->data_values->mobile_icon;@endphp-->
                            <!--        <a href="tel:{{ str_replace(" ","",@$contactContent->data_values->mobile_number) }}" class="text--body">-->
                            <!--            {{ @$contactContent->data_values->mobile_number }}-->
                            <!--        </a>-->
                            <!--    </span>-->
                            <!--</li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="footer-item">
                        <h6 class="footer-item__title">{{ __(@$subscribeContent->data_values->heading) }}</h6>
                        <p class="footer-item__desc">{{ __(@$subscribeContent->data_values->subheading) }}</p>
                        <form class="subscribe-form" id="subscribeForm">
                            @csrf
                            <input class="form--control" type="email" name="email" placeholder="@lang('Email Address')">
                            <button class="btn btn--base btn--sm" type="submit">@lang('Subscribe')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="copyright">
                &copy; @php echo now()->year; @endphp
                <a href="{{ route('home') }}">{{ $general->site_name }}</a>
                . @lang('All Rights Reserved')
            </p>
            <div class="footer-links">
                @foreach ($policyPages as $policy)
                    <a class="footer-link"
                        href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
@push('script')
    <script>
        "use strict";
        (function($) {
            var form = $("#subscribeForm");
            form.on('submit', function(e) {
                e.preventDefault();
                var data = form.serialize();
                $.ajax({
                    url: `{{ route('subscribe') }}`,
                    method: 'post',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            form.find('input[name=email]').val('');
                            notify('success', response.message);
                        } else {
                            notify('error', response.error);
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
