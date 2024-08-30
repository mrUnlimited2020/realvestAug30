@foreach ($featuredProperties as $featuredProperty)
    <div class="card border-0 property-horizontal--card">
        <a class="card-img card-img--lg" href="{{ route('property.details', [slug(@$featuredProperty->title), @$featuredProperty->id]) }}">
            <img src="{{ getImage(getFilePath('propertyThumb') . '/' . @$featuredProperty->thumb_image, getFileSize('propertyThumb')) }}"
                alt="property-image">
        </a>
        <div class="card-body py-md-4 px-md-4">
            <div class="card-body-top mb-4">
                <div class="card-wrapper flex-column">
                    <h4 class="card-title mb-1">
                        <a href="{{ route('property.details', [slug(@$featuredProperty->title), @$featuredProperty->id]) }}">
                            {{ __(@$featuredProperty->title) }}
                        </a>
                    </h4>
                    <ul class="card-meta card-meta--one">
                        <li class="card-meta__item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="text">{{ __(@$featuredProperty->location->name) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body-middle mb-4">
                <div class="card-progress mb-4">
                    <div class="card-progress__bar">
                        <div class="card-progress__thumb" style="width: {{ @$featuredProperty->invest_progress }}%;"></div>
                    </div>
                    <span class="card-progress__label fs-12">
                        {{ @$featuredProperty->invests_count }} @lang('Investors') |
                        {{ $general->cur_sym }}{{ showAmount(@$featuredProperty->invested_amount) }}
                        ({{ getAmount(@$featuredProperty->invest_progress) }}%)
                    </span>
                </div>
                <ul class="card-meta card-meta--two">
                    <li class="card-meta__item">
                        <div class="text">
                            {{ @$featuredProperty->getProfit }}
                        </div>
                        <span class="subtext">@lang('Profit')</span>
                    </li>
                    <li class="card-meta__item">
                        <div class="text">
                            <span>{{ @$featuredProperty->getProfitSchedule }}</span>
                        </div>
                        <span class="subtext">@lang('Profit Schedule')</span>
                    </li>
                    <li class="card-meta__item">
                        <div class="text">
                            {{ @$featuredProperty->getCapitalBackStatus }}
                        </div>
                        <span class="subtext">@lang('Capital Back')</span>
                    </li>
                </ul>
            </div>
            <div class="card-body-bottom">
                <a class="btn btn--sm btn--base" href="{{ route('property.details', [slug(@$featuredProperty->title), @$featuredProperty->id]) }}"
                    role="button">
                    @lang('Details')
                </a>
                <span class="card-price">
                    {{ $general->cur_sym }}{{ showAmount(@$featuredProperty->per_share_amount) }}
                </span>
            </div>
        </div>
    </div>
@endforeach
