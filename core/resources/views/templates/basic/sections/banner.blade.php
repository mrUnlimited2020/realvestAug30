@php
    $bannerContent = getContent('banner.content', true);
    $bannerElements = getContent('banner.element', limit: 3, orderById: true);
@endphp
<section class="banner bg-pattern3">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <div class="banner-content">
                    <p class="banner-content__subtitle">{{ __(@$bannerContent->data_values->title) }}</p>
                    <h1 class="banner-content__title">{{ __(@$bannerContent->data_values->heading) }}</h1>
                    <a href="{{ @$bannerContent->data_values->button_url }}" class="btn btn--base">
                        {{ __(@$bannerContent->data_values->button_text) }}
                    </a>
                    <ul class="banner-info">
                        @foreach (@$bannerElements as $bannerElement)
                            <li class="banner-info__item">
                                <h3 class="title" data-s-break>
                                    {{ @$bannerElement->data_values->count }}
                                </h3>
                                <span class="text">{{ __(@$bannerElement->data_values->title) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="d-none d-lg-block col-lg-5">
                <div class="banner-thumbs">
                    <div class="banner-thumbs-image">
                        <img class="fit-image pe-none"
                            src="{{ getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->image, '515x565') }}"
                            alt="banner-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
