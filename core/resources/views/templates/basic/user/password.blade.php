@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row justify-content-center dashboard-widget-wrapper">
    <div class="col-md-12">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label class="form--label">@lang('Current Password')</label>
                <input type="password" class="form--control" name="current_password" required autocomplete="current-password">
            </div>
            <div class="form-group">
                <label class="form--label">@lang('Password')</label>
                <input type="password" class="form--control @if($general->secure_password) secure-password @endif" name="password" required autocomplete="current-password">
            </div>
            <div class="form-group">
                <label class="form--label">@lang('Confirm Password')</label>
                <input type="password" class="form--control" name="password_confirmation" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn--base w-100 mt-2">@lang('Submit')</button>
        </form>
    </div>
</div>
@endsection
@if($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
