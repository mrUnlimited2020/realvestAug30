@php
    $featureContent = getContent('feature.content', true);
    $featureElements = getContent('feature.element', limit: 4, orderById: true);
@endphp
<section class="why-invest py-120">
    <div class="container ">
        <div class="section-heading">
            <p class="section-heading__subtitle">{{ __(@$featureContent->data_values->title) }}</p>
            <h2 class="section-heading__title">{{ __(@$featureContent->data_values->heading) }}</h2>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach (@$featureElements as $featureElement)
                <div class="col-xsm-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="why-invest-card">
                        <span class="why-invest-card__icon">
                            @php echo @$featureElement->data_values->feature_icon; @endphp
                        </span>
                        <div class="why-invest-card__content">
                            <h6 class="why-invest-card__title">{{ __(@$featureElement->data_values->title) }}</h6>
                            <p class="why-invest-card__desc">{{ __(@$featureElement->data_values->description) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
