@extends($activeTemplate . 'layouts.frontend')
@php
    $label = 'form--label';
    $formControl = '';
@endphp
@section('content')
    <section class="account">
        <div class="account-inner py-120 bg-pattern3">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
                        <form method="POST" action="{{ route('user.password.email') }}" class="account-form verify-gcaptcha">
                            @csrf
                            <div class="account-form__body">
                                <div class="mb-4">
                                    <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                                </div>
                                <div class="form-group">
                                    <label for="usernameOrEmail" class="form--label">@lang('Username or Email')</label>
                                    <input class="form--control" type="text" id="usernameOrEmail" name="value"
                                        value="{{ old('value') }}" required autofocus="off">
                                </div>
                                <x-captcha :label="$label" :formControl="$formControl" />
                                <div class="form-group mb-0">
                                    <button type="submit" class="w-100 btn btn--base mt-3">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
