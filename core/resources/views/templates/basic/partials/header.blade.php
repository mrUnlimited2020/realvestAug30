@php
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<header class="header " id="header">
    <div class="container ">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand logo order-1" href="{{ route('home') }}">
                <img src="{{ siteLogo() }}" alt="logo">
            </a>
            <button class="navbar-toggler header-button order-3 order-lg-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbar-content" aria-expanded="false">
                <i class="las la-bars"></i>
            </button>
            <div class="collapse navbar-collapse order-4 order-lg-3" id="navbar-content">
                <ul class="navbar-nav nav-menu ms-auto align-items-lg-center">
                    <li>
                        <div class="navbar-actions navbar-actions--sm">
                            @include($activeTemplate . 'partials.language')
                            @guest
                                <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
                            @endguest
                            @auth
                                @if (!request()->routeIs('user.*') && !request()->routeIs('ticket*'))
                                    <a href="" class="btn btn--base">@lang('Dashboard')</a>
                                @else
                                    <div class="user-info">
                                        <button class="user-info__button flex-align">
                                            <span class="user-info__name">
                                                @lang('More')
                                            </span>
                                        </button>
                                        <ul class="user-info-dropdown">
                                            <li class="user-info-dropdown__item">
                                                <a class="user-info-dropdown__link {{ menuActive('user.profile.setting') }}"
                                                    href="{{ route('user.profile.setting') }}">
                                                    <span class="icon"><i class="far fa-user-circle"></i></span>
                                                    <span class="text">@lang('Profile Setting')</span>
                                                </a>
                                            </li>
                                            <li class="user-info-dropdown__item">
                                                <a class="user-info-dropdown__link {{ menuActive('user.change.password') }}"
                                                    href="{{ route('user.change.password') }}">
                                                    <span class="icon"><i class="fas fa-cog"></i></span>
                                                    <span class="text">@lang('Change Password')</span>
                                                </a>
                                            </li>
                                            <li class="user-info-dropdown__item">
                                                <a class="user-info-dropdown__link {{ menuActive('user.twofactor') }}"
                                                    href="{{ route('user.twofactor') }}">
                                                    <span class="icon"><i class="fas fa-shield-alt"></i></span>
                                                    <span class="text">@lang('2FA Security')</span>
                                                </a>
                                            </li>
                                            <li class="user-info-dropdown__item">
                                                <a class="user-info-dropdown__link" href="{{ route('user.logout') }}">
                                                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                                    <span class="text">@lang('Logout')</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('home') }}" href="{{ route('home') }}">@lang('Home')</a>
                    </li>
                    @foreach (@$pages as $k => $data)
                    <li class="nav-item {{ menuActive('pages', null, @$data->slug) }}">
                        <a href="{{ route('pages', [@$data->slug]) }}" class="nav-link">{{ __(@$data->name) }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('property*') }}" href="{{ route('property') }}">@lang('Investments')</a>
                    </li>
                    <!-- I added some items to the menu list -->
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('#') }}" href="#">@lang('Properties')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('blog*') }}" href="{{ route('blog') }}">@lang('Blog')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ menuActive('contact') }}"
                            href="{{ route('contact') }}">@lang('Contact')</a>
                    </li>
                </ul>
            </div>
            <div class="navbar-actions navbar-actions--md order-2 order-lg-4">
                @include($activeTemplate . 'partials.language')
                @guest
                    <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
                @endguest
                @auth
                    @if (!request()->routeIs('user.*') && !request()->routeIs('ticket*'))
                        <a href="{{ route('user.home') }}" class="btn btn--base">@lang('Dashboard')</a>
                    @else
                        <div class="user-info">
                            <button class="user-info__button flex-align">
                                <span class="user-info__name">
                                    @lang('More')
                                </span>
                            </button>
                            <ul class="user-info-dropdown">
                                <li class="user-info-dropdown__item">
                                    <a class="user-info-dropdown__link" href="{{ route('user.profile.setting') }}">
                                        <span class="icon"><i class="far fa-user-circle"></i></span>
                                        <span class="text">@lang('Profile Setting')</span>
                                    </a>
                                </li>
                                <li class="user-info-dropdown__item">
                                    <a class="user-info-dropdown__link" href="{{ route('user.change.password') }}">
                                        <span class="icon"><i class="fas fa-cog"></i></span>
                                        <span class="text">@lang('Change Password')</span>
                                    </a>
                                </li>
                                <li class="user-info-dropdown__item">
                                    <a class="user-info-dropdown__link" href="{{ route('user.twofactor') }}">
                                        <span class="icon"><i class="fas fa-shield-alt"></i></span>
                                        <span class="text">@lang('2FA Security')</span>
                                    </a>
                                </li>
                                <li class="user-info-dropdown__item">
                                    <a class="user-info-dropdown__link" href="{{ route('user.logout') }}">
                                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                        <span class="text">@lang('Logout')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                @endauth
            </div>
        </nav>
    </div>
</header>
