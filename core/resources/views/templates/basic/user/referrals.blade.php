@extends($activeTemplate . 'layouts.master')
@php
    $referralContent = getContent('referral.content', true);
@endphp
@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h6 class="page-title">{{ __(@$referralContent->data_values->title) }}</h6>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="alert alert-info dashboard__section-margin" role="alert">
                <p> {{ __(@$referralContent->data_values->description) }}</p>
            </div>
            <div class="input-group input-group--copy">
                <input class="form--control" type="text" value="{{ route('home') }}?reference={{ $user->username }}" readonly>
                <button class="btn btn-soft--base" type="button">
                    <i class="las la-copy"></i>
                    <span>@lang('Copy')</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            @if (count(@$user->allReferrals) > 0 && @$maxLevel > 0)
                <div class="treeview-container">
                    <ul class="treeview">
                        <li class="items-expanded"> {{ $user->fullname }}
                            @include($activeTemplate . 'partials.under_tree', [
                                'user' => $user,
                                'layer' => 0,
                                'isFirst' => true,
                            ])
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            $('.treeview').treeView();
        })(jQuery);
    </script>
@endpush
