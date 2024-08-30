@php
    $citiesContent = getContent('cities.content', true);
    $localities = App\Models\Location::active()->withCount('properties')->get();
@endphp
<section class="featured-property py-120">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">{{ __(@$citiesContent->data_values->title) }}</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">{{ __(@$citiesContent->data_values->heading) }}</h2>
                <div class="featured-property__arrows"></div>
            </div>
        </div>
        <div class="featured-property__cards">
            @foreach (@$localities as $location)
                <a class="city-card" href="{{ route('property') }}?location_id={{ $location->id }}">
                    <img class="city-card__thumb"
                        src="{{ getImage(getFilePath('location') . '/' . @$location->image, getFileSize('location')) }}"
                        alt="cities-image">
                    <div class="city-card__content">
                        <h3 class="city-card__title">{{ __(@$location->name) }}</h3>
                        <span class="city-card__text">
                            {{ @$location->properties_count }}
                            {{ str()->plural(__('Property'), (int) @$location->properties_count) }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>


@push('script')
    <script>
        (function($) {
            "use strict";
            // Featured Property Cards Slider Js Start
            $('.featured-property').each(function(index, element) {
                $(element).find('.featured-property__cards').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    speed: 2000,
                    dots: false,
                    arrows: true,
                    appendArrows: $(element).find('.featured-property__arrows'),
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
                    responsive: [{
                            breakpoint: 991 + 1,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 600 + 1,
                            settings: {
                                slidesToShow: 2,
                            }
                        },
                        {
                            breakpoint: 424 + 1,
                            settings: {
                                slidesToShow: 1,
                                dots: true,
                                arrows: false
                            }
                        }
                    ]
                });
                // Remove slick dots numbers
                var textNodes = $(element).find('.slick-dots > li button').contents().filter(function() {
                    return this.nodeType === Node.TEXT_NODE;
                })
                textNodes.remove();
            });
            // Featured Property Cards Slider Js End
        })(jQuery);
    </script>
@endpush
