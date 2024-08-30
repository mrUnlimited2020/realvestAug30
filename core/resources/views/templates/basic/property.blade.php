@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="property-page py-120 bg-pattern">
        <div class="container ">
            <div class="property-page-inner">
                <aside id="property-page-sidebar" class="property-page-sidebar">
                    <button class="close-btn" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                    <form action="{{ url()->current() }}" class="filter-form">
                        <div class="filter-form__block">
                            <h6 class="title">@lang('Search Investments')</h6>
                            <div class="form-group">
                                <input class="form--control" type="text" name="search" value="{{ request()->search }}"
                                    placeholder="@lang('What are you looking for')?">
                            </div>
                            <div class="form-group">
                                <select name="location_id" class="form-select form--control on-change-submit">
                                    @if (!request()->location_id)
                                        <option value="">@lang('Select Location')</option>
                                    @else
                                        <option value="">@lang('All Location')</option>
                                    @endif

                                    @foreach (@$localities as $location)
                                        <option value="{{ @$location->id }}" @selected(@$location->id == request()->location_id)>
                                            {{ __(@$location->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="invest_type" class="form-select form--control on-change-submit">
                                    @if (!request()->invest_type)
                                        <option value="">@lang('Investment Type')</option>
                                    @else
                                        <option value="">@lang('All Investment Type')</option>
                                    @endif
                                    <option value="{{ Status::INVEST_TYPE_ONETIME }}" @selected(request()->invest_type == Status::INVEST_TYPE_ONETIME)>
                                        @lang('Onetime Investment')
                                    </option>
                                    <option value="{{ Status::INVEST_TYPE_INSTALLMENT }}" @selected(request()->invest_type == Status::INVEST_TYPE_INSTALLMENT)>
                                        @lang('Investment By Installment')
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="profit_schedule" class="form-select form--control on-change-submit ">
                                    @if (!request()->profit_schedule)
                                        <option value="">@lang('Profit Schedule')</option>
                                    @else
                                        <option value="">@lang('All Profit Schedule')</option>
                                    @endif
                                    <option value="{{ Status::PROFIT_ONETIME }}" @selected(request()->profit_schedule == Status::PROFIT_ONETIME)>
                                        @lang('One Time')
                                    </option>
                                    <option value="{{ Status::PROFIT_LIFETIME }}" @selected(request()->profit_schedule == Status::PROFIT_LIFETIME)>
                                        @lang('Lifetime')
                                    </option>
                                    <option value="{{ Status::PROFIT_REPEATED_TIME }}" @selected(request()->profit_schedule == Status::PROFIT_REPEATED_TIME)>
                                        @lang('Repeated Time')
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form--label">@lang('Capital Back')</label>
                                <div class="form-check">
                                    <input class="form-check-input on-change-submit" name="is_capital_back" type="radio"
                                        value="" id="capital-all" @checked(!request()->is_capital_back)>
                                    <label class="form-check-label" for="capital-all">
                                        @lang('All')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input on-change-submit" name="is_capital_back" type="radio"
                                        value="{{ Status::CAPITAL_BACK_YES }}" id="capital-yes"
                                        @checked(Status::CAPITAL_BACK_YES == request()->is_capital_back)>
                                    <label class="form-check-label" for="capital-yes">
                                        @lang('Yes')
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input on-change-submit" type="radio"
                                        value="{{ Status::CAPITAL_BACK_NO }}" name="is_capital_back" id="capital-no"
                                        @checked(Status::CAPITAL_BACK_NO == request()->is_capital_back)>
                                    <label class="form-check-label" for="capital-no">
                                        @lang('No')
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="filter-form__block">
                                    <label class="form--label">@lang('Investment Range')</label>
                                    <div class="range-slider">
                                        <div class="range-slider__inputs">
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                <input id="min-range" class="form--control" type="number"
                                                    name="minimum_invest" value="{{ request()->minimum_invest }}">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $general->cur_sym }}</span>
                                                <input id="max-range" class="form--control" type="number"
                                                    name="maximum_invest" value="{{ request()->maximum_invest }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn--sm btn btn-outline--base w-100">
                            <i class="las la-filter"></i> @lang('Filter Now')
                        </button>
                    </form>
                </aside>
                <div class="property-page-content">
                    <div class="text-end d-lg-none mb-4">
                        <button class="btn btn--sm btn-outline--base btn--sidebar-open" type="button" data-toggle="sidebar"
                            data-target="#property-page-sidebar">
                            <i class="las la-filter"></i>
                        </button>
                    </div>
                    <div class="row gy-4 g-sm-3 g-md-4 justify-content-center">
                        @include($activeTemplate . 'partials.property', [
                            'properties' => @$properties,
                            'col' => '6',
                        ])
                        @if (@$properties->hasPages())
                            {{ paginateLinks(@$properties) }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (@$sections != null)
        @foreach (json_decode(@$sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $(".on-change-submit").on('change', function(e) {
                $(this).closest('form').submit();
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .form-check-input:checked {
            background-color: hsla(var(--base));
            border-color: hsla(var(--base));
        }

        .form-check-input:focus {
            border-color: hsla(var(--base)/0.5);
            box-shadow: 0 0 0 0.25rem hsla(var(--base)/0.5);
        }
    </style>
@endpush
