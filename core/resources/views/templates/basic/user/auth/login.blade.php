@extends($activeTemplate . 'layouts.app')
@php
    $credentials  = $general->socialite_credentials;
    $loginContent = getContent('login.content', true);
    $label        = 'form--label';
    $formControl  = '';
@endphp
@section('main-content')
    <section class="account">
        <div class="account-inner py-60 bg-pattern3">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
                        <form method="POST" action="{{ route('user.login') }}" class="account-form verify-gcaptcha">
                            @csrf
                            <div class="account-form__header text-center">
                                <a class="mb-5" href="{{route('home')}}"> <img src="{{ siteLogo() }}"></a>
                                <h5 class="account-form__title mb-3">{{ __($loginContent->data_values->heading) }}</h5>
                                @if (
                                    $credentials->google->status == Status::ENABLE ||
                                        $credentials->facebook->status == Status::ENABLE ||
                                        $credentials->linkedin->status == Status::ENABLE)
                                    <div class="account-form__social-btns">
                                        @if ($credentials->facebook->status == Status::ENABLE)
                                            <a href="{{ route('user.social.login', 'facebook') }}"
                                                class="account-form__social-btn">
                                                <img class="icon"
                                                    src="{{ asset($activeTemplateTrue . 'images/icons/facebook.png') }}"
                                                    alt="facebook">
                                            </a>
                                        @endif
                                        @if ($credentials->google->status == Status::ENABLE)
                                            <a href="{{ route('user.social.login', 'google') }}"
                                                class="account-form__social-btn">
                                                <img class="icon"
                                                    src="{{ asset($activeTemplateTrue . 'images/icons/google.png') }}"
                                                    alt="google">
                                            </a>
                                        @endif
                                        @if ($credentials->linkedin->status == Status::ENABLE)
                                            <a href="{{ route('user.social.login', 'linkedin') }}"
                                                class="account-form__social-btn">
                                                <img class="icon"
                                                    src="{{ asset($activeTemplateTrue . 'images/icons/linkedin.png') }}"
                                                    alt="linkedin">
                                            </a>
                                        @endif
                                    </div>

                                    <div class="other-option">
                                        <span class="other-option__text">@lang('OR')</span>
                                    </div>
                                @endif
                            </div>
                            <div class="account-form__body">
                                <div class="form-group">
                                    <label for="usernameOrEmail" class="form--label required">@lang('Username or Email')</label>
                                    <input class="form--control" type="text" name="username"
                                        value="{{ old('username') }}" id="usernameOrEmail" required>
                                </div>
                                <div class="form-group">
                                    <label for="your-password" class="form--label required">@lang('Password')</label>
                                    <div class="position-relative">
                                        <input class="form--control" type="password" name="password" id="your-password">
                                        <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash"
                                            id="#your-password"></span>
                                    </div>
                                </div>
                                <x-captcha :label="$label" :formControl="$formControl" />
                                <div class="flex-between">
                                    <div class="form--check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">@lang('Remember me')</label>
                                    </div>
                                    <a href="{{ route('user.password.request') }}"
                                        class="account-form__forgot-pass">@lang('Forgot Password')?</a>
                                </div>
                            </div>
                            <div class="account-form__footer">
                                <button type="submit" id="recaptcha" class="w-100 btn btn--base">@lang('Login')</button>
                                <p class="account-form__subtitle mt-3">
                                    @lang('Don\'t have an account')?
                                    <a href="{{ route('user.register') }}">@lang('Register')</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
