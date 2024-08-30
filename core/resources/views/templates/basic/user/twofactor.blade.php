@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        @if (!$user->ts)
            <h6 class="page-title m-0">@lang('Enable 2FA Security')</h6>
            <button type="submit" class="btn btn--base btn--sm" id="qrBtn">@lang('Scan QR Code')</button>
        @else
            <h6 class="page-title m-0">@lang('Disable 2FA Security')</h6>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($user->ts)
                <form action="{{ route('user.twofactor.disable') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $secret }}">
                    <div class="form-group">
                        <label class="form--label">@lang('Google Authenticator OTP')</label>
                        <input type="text" class="form--control" name="code" required>
                    </div>
                    <button type="submit" class="btn btn--base w-100 mt-2">@lang('Submit')</button>
                </form>
            @else
                <form action="{{ route('user.twofactor.enable') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $secret }}">
                    <div class="form-group">
                        <label class="form--label">@lang('Google Authenticator OTP')</label>
                        <input type="text" class="form--control" name="code" required>
                    </div>
                    <button type="submit" class="btn btn--base w-100 mt-2">@lang('Submit')</button>
                </form>
            @endif
        </div>
    </div>

    @if (!$user->ts)
        <div id="qrModal" class="modal fade custom--modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Add Your Account')</h5>
                        <button class="close-btn" type="button" data-bs-dismiss="modal">
                            <i class="las fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-form__header">
                            <h6 class="modal-form__title plan-confirm-text">
                                <span>@lang('Use the QR code or setup key on your Google Authenticator app to add your account.')</span>
                            </h6>
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{ $qrCodeUrl }}">
                            </div>
                        </div>
                        <div class="modal-form__body">
                            <div class="form-group">
                                <label class="form--label">@lang('Setup Key')</label>
                                <div class="input-group input-group--copy">
                                    <input type="text" name="key" value="{{ $secret }}"
                                        class="form--control referralURL" readonly>
                                    <button class="btn btn-soft--base" type="button">
                                        <i class="las la-copy"></i>
                                        <span>@lang('Copy')</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-form__footer">
                            <label><i class="fa fa-info-circle"></i> @lang('Help')</label>
                            <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')
                                <a class="text--base"
                                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                                    target="_blank">@lang('Download')
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).on('click', '#qrBtn', function() {
                var modal = $('#qrModal');
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
