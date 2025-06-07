@php
    $includedFromId = 19; // Starting ID to include
    $propertyContent  = getContent('latest_property.content', true);
    $latestProperties = App\Models\Property::active()
        ->withSum('invests', 'total_invest_amount')
        ->withCount('invests')
        ->with(['location', 'profitScheduleTime', 'installmentDuration', 'invests'])
        ->where('id', '>=', $includedFromId) // Include properties with IDs greater than or equal to 
        ->orderByDesc('id')
        ->get();    
@endphp


<section class="latest-property py-120 bg-pattern bg-pattern-bottom-right">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">{{ __(@$propertyContent->data_values->title) }}</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">{{ __(@$propertyContent->data_values->heading) }}</h2>
                <!--<a class="section-heading__link" href="{{ route('property') }}">-->
                <!--    <span>@lang('Explore')</span>-->
                <!--    <i class="las la-long-arrow-alt-right"></i>-->
                <!--</a>-->
            </div>
        </div>
        <div class="row gy-4 g-sm-3 g-md-4 justify-content-center">
            @include($activeTemplate . 'partials.property', ['properties' => @$latestProperties, 'col' => '4'])
        </div>
    </div>
</section>
