@foreach ($properties as $property)
    <div class="col-sm-6 col-lg-{{ $col }}">
        <article class="card property--card border-0">
            <a class="card-img-top " href="{{ route('property.details', [slug(@$property->title), @$property->id]) }}">
                <img src="{{ getImage(getFilePath('propertyThumb') . '/' . @$property->thumb_image, getFileSize('propertyThumb')) }}"
                    alt="property-image">
            </a>
            <div class="card-body px-2 py-3 p-md-3 p-xl-4">
                <div class="card-body-top">
                    <h5 class="card-title mb-2">
                        <a href="{{ route('property.details', [slug(@$property->title), @$property->id]) }}">{{ __(@$property->title) }}</a>
                    </h5>
                    <ul class="card-meta card-meta--one">
                        <li class="card-meta__item card-meta__item__location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="text">{{ __(@$property->location->name) }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-body-middle">
                    <div class="card-progress mb-4">
                        <div class="card-progress__bar">
                            <div class="card-progress__thumb" style="width: {{ @$property->invest_progress }}%;"></div>
                        </div>
                        <span class="card-progress__label fs-12">
                            {{ @$property->invests_count }} @lang('Investors') |
                            {{ $general->cur_sym }}{{ showAmount(@$property->invested_amount) }}
                            ({{ getAmount(@$property->invest_progress) }}%)
                        </span>
                    </div>
                    <ul class="card-meta card-meta--two">
                        <li class="card-meta__item">
                            <div class="text">
                                {{ @$property->getProfit }}
                            </div>
                            <span class="subtext">@lang('Profit')</span>
                        </li>
                        <li class="card-meta__item">
                            <div class="text">
                                {{ @$property->getProfitSchedule }}
                            </div>
                            <span class="subtext">@lang('Profit Schedule')</span>
                        </li>
                        <li class="card-meta__item">
                            <div class="text">
                                {{ @$property->getCapitalBackStatus }}
                            </div>
                            <span class="subtext">@lang('Capital Back')</span>
                        </li>
                    </ul>
                </div>
                <div class="card-body-bottom mb-4">
                    <a class="btn btn--sm btn--base" href="{{ route('property.details', [slug(@$property->title), @$property->id]) }}"
                        role="button">@lang('Details')</a>
                    <span class="card-price">{{ $general->cur_sym }}{{ showAmount(@$property->per_share_amount) }}</span>
                </div>
            </div>
        </article>
    </div>
@endforeach  