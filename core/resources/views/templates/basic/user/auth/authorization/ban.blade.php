@extends($activeTemplate . 'layouts.app')
@php
    $bannedContent = getContent('banned.content', true);
@endphp
@section('main-content')
    <div class="maintenance-page flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 text-center">
                    <img src="{{ getImage('assets/images/frontend/banned/' . @$bannedContent->data_values->image, '700x400') }}"
                    alt="@lang('image')" class="mb-4">
                    <h4 class="text--danger mb-2">{{ __(@$bannedContent->data_values->heading) }}</h4>
                    <p class="mb-4">{{ __($user->ban_reason) }} </p>
                    <a href="{{ route('home') }}" class="btn--base btn btn--sm"> @lang('Go to Home') </a>
                </div>
            </div>
        </div>
    </div>
@endsection
