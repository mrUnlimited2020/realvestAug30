@php
    $featuredPropertyContent = getContent('featured_property.content', true);
    $featuredProperties      = App\Models\Property::active()
        ->where('is_featured', Status::YES)
        ->withSum('invests', 'total_invest_amount')
        ->withCount('invests')
        ->with(['location', 'profitScheduleTime', 'installmentDuration', 'invests'])
        ->orderByDesc('id')
        ->take(3)
        ->get();
@endphp

<section class="all-property py-120 bg-pattern">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">{{ __(@$featuredPropertyContent->data_values->title) }}</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">{{ __(@$featuredPropertyContent->data_values->heading) }}</h2>
                <a class="section-heading__link" href="{{ route('property') }}">
                    <span>@lang('Explore')</span>
                    <i class="las la-long-arrow-alt-right"></i>
                </a>
            </div>
        </div>
        <div class="all-property__cards">
            @include($activeTemplate . 'partials.featured_property', ['featuredProperties' => @$featuredProperties])
        </div>
    </div>
</section>
