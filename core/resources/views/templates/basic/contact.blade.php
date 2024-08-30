@extends($activeTemplate . 'layouts.frontend')
@php
    $label = 'form--label';
    $formControl = '';
@endphp

@section('content')
    <section class="contact-page py-120 bg-pattern">
        <div class="contact-page__section">
            <div class="container ">
                <div class="row gy-4 justify-content-center">
                    <div class="col-sm-6 col-lg-4">
                        <div class="contact-card">
                            <span class="contact-card__icon">
                                @php echo @$contactContent->data_values->mobile_icon; @endphp
                            </span>
                            <div class="contact-card__content">
                                <h6 class="contact-card__title">{{ __(@$contactContent->data_values->mobile_title) }}</h6>
                                <a href="tel:{{ @$contactContent->data_values->mobile_number }}" class="contact-card__desc">{{ @$contactContent->data_values->mobile_number }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="contact-card">
                            <span class="contact-card__icon">
                                @php echo @$contactContent->data_values->email_icon; @endphp
                            </span>
                            <div class="contact-card__content">
                                <h6 class="contact-card__title">{{ __(@$contactContent->data_values->email_title) }}</h6>
                                <a href="mailto:{{ @$contactContent->data_values->email }}" class="contact-card__desc">{{ @$contactContent->data_values->email }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="contact-card">
                            <span class="contact-card__icon">
                                @php echo @$contactContent->data_values->address_icon; @endphp
                            </span>
                            <div class="contact-card__content">
                                <h6 class="contact-card__title">{{ __(@$contactContent->data_values->address_title) }}</h6>
                                <p class="contact-card__desc">{{ @$contactContent->data_values->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-page__section">
            <div class="container ">
                <div class="row gy-4 justify-content-center">
                    <div class="d-none d-lg-block col-lg-6">
                        <img class="contact-page__thumb"
                            src="{{ getImage('assets/images/frontend/contact_us/' . @$contactContent->data_values->image, '625x475') }}"
                            alt="contact-image">
                    </div>
                    <div class="col-lg-6">
                        <form method="post" action="{{ url()->current() }}" class="verify-gcaptcha contact-form">
                            @csrf
                            <div class="contact-form__header">
                                <h4 class="contact-form__title">{{ __(@$contactContent->data_values->title) }}</h4>
                                <p class="contact-form__desc">{{ __(@$contactContent->data_values->heading) }}</p>
                            </div>
                            <div class="contact-form__body">
                                <div class="row">
                                    <div class="col-xsm-6 col-sm-6 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <input name="name" value="{{ old('name', @$user->fullname) }}"
                                                @if ($user && $user->profile_complete) readonly @endif
                                                class="form--control form--control-lg" type="text"
                                                placeholder="@lang('Full Name')" required>
                                        </div>
                                    </div>
                                    <div class="col-xsm-6 col-sm-6 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <input name="email" value="{{ old('email', @$user->email) }}"
                                                @if ($user) readonly @endif
                                                class="form--control form--control-lg" type="email"
                                                placeholder="@lang('Email')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input name="subject" value="{{ old('subject') }}"
                                                class="form--control form--control-lg" type="text"
                                                placeholder="@lang('Subject')" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <textarea name="message" class="form--control form--control-lg" placeholder="@lang('Message')" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <x-captcha :label="$label" :formControl="$formControl" />
                            </div>
                            <div class="contact-form__footer">
                                <button type="submit" class="btn btn--base">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (@$sections != null)
        @foreach (json_decode(@$sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
