@php
    $aboutContent = getContent('about.content', true);
@endphp
<section class="about-us   @if(request()->routeIs('home')) pb-120 pt-60 @else  py-120  @endif  bg-pattern bg-pattern-top-left">
    <div class="container ">
        <div class="row align-items-center gy-4">
            <div class="col-md-6">
                <div class="about-us__content">
                    <div class="section-heading mb-less style-left">
                        <p class="section-heading__subtitle">{{ __(@$aboutContent->data_values->title) }}</p>
                        <h2 class="section-heading__title">{{ __(@$aboutContent->data_values->heading) }}</h2>
                    </div>
                    <h6 class="about-us__subheading">{{ __(@$aboutContent->data_values->subheading) }}</h6>
                    <div class="about-us__desc">
                        <p>{{ __(@$aboutContent->data_values->description) }}</p>
                    </div>
                    <a class="btn btn--base" href="{{ @$aboutContent->data_values->button_url }}" role="button">
                        {{ __(@$aboutContent->data_values->button_text) }}
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-lg-end">
                    <div class="about-us__wrapper">
                        <img class="about-us__thumb"
                            src="{{ getImage('assets/images/frontend/about/' . @$aboutContent->data_values->image, '545x635') }}" alt="about-image">
                        <div class="floating-card floating-card--one">
                            <div class="floating-card__content">
                                <h3 class="floating-card__title" data-s-break>
                                    {{ __(@$aboutContent->data_values->top_card_number) }}
                                </h3>
                            <p class="floating-card__text">{{ __(@$aboutContent->data_values->top_card_title) }}</p>
                            </div>
                        </div>
                        <div class="floating-card floating-card--two">
                            <div class="floating-card__content">
                                <h3 class="floating-card__title" data-s-break>
                                    {{ __(@$aboutContent->data_values->bottom_card_number) }}
                                </h3>
                                <p class="floating-card__text">{{ __(@$aboutContent->data_values->bottom_card_title) }}</p>
                            </div>
                            <img class="floating-card__thumb"
                                src="{{ getImage('assets/images/frontend/about/' . @$aboutContent->data_values->group_image, '160x60') }}"
                                alt="about-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
