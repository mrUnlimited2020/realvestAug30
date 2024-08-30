@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account">
        <div class="account-inner py-120 bg-pattern3">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
                        <form method="POST" action="{{ route('user.password.update') }}" class="account-form">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="account-form__body">
                                <div class="mb-4">
                                    <p>@lang('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.')</p>
                                </div>
                                <div class="form-group">
                                    <label class="form--label">@lang('Password')</label>
                                    <input class="form--control @if ($general->secure_password) secure-password @endif"
                                        type="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label class="form--label">@lang('Confirm Password')</label>
                                    <input class="form--control" type="password" name="password_confirmation" required>
                                </div>
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

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
