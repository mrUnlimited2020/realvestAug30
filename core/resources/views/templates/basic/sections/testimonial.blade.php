@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element');
    $brandElements = getContent('brands.element');
@endphp
<section class="testimonial py-120 ">
    <div class="container ">
        <div class="row gy-4 justify-content-lg-between align-items-center">
            <div class="col-md-5">
                <div class="section-heading style-left">
                    <p class="section-heading__subtitle">{{ __(@$testimonialContent->data_values->title) }}</p>
                    <h2 class="section-heading__title">{{ __(@$testimonialContent->data_values->heading) }}</h2>
                </div>
                <div class="testimonial__dots mt-auto"></div>
            </div>
            <div class="col-md-7 col-lg-6">
                <div class="testimonial__cards">
                    @foreach (@$testimonialElements as $testimonialElement)
                        <div class="testimonial-card">
                            <div class="testimonial-card__wrapper">
                                <div class="testimonial-card__content">
                                    <p class="testimonial-card__desc">
                                        {{ __(@$testimonialElement->data_values->review) }}
                                    </p>
                                </div>
                                <div class="testimonial-card__info">
                                    <img class="testimonial-card__thumb"
                                        src="{{ getImage('assets/images/frontend/testimonial/' . @$testimonialElement->data_values->image, '65x65') }}"
                                        alt="testimonial-image">
                                    <div class="testimonial-card__details">
                                        <h6 class="testimonial-card__name">
                                            {{ __(@$testimonialElement->data_values->name) }}</h6>
                                        <span class="testimonial-card__country">
                                            {{ __(@$testimonialElement->data_values->address) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="testimonial-bottom">
            <div class="testimonial__brands">
                @foreach (@$brandElements as $brandElement)
                    <img src="{{ getImage('assets/images/frontend/brands/' . @$brandElement->data_values->image, '180x35') }}"
                        alt="testimonial-image">
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        (function($) {
            "use strict";

            // Testimonial Cards Slider Js start
            $('.testimonial').each(function(index, element) {
                $(element).find('.testimonial__cards').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    speed: 1500,
                    arrows: false,
                    dots: true,
                    appendDots: $(element).find('.testimonial__dots'),
                    responsive: [{
                        breakpoint: 767 + 1,
                        settings: {
                            appendDots: $(element).find('.testimonial__cards'),
                        }
                    }, ]
                });
                $(element).find('.testimonial__brands').slick({
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1000,
                    pauseOnHover: true,
                    speed: 2000,
                    dots: false,
                    arrows: false,
                    responsive: [{
                            breakpoint: 1199 + 1,
                            settings: {
                                slidesToShow: 4,
                            }
                        },
                        {
                            breakpoint: 576 + 1,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 424 + 1,
                            settings: {
                                slidesToShow: 2,
                            }
                        }
                    ]
                });
                // Remove slick dots numbers
                var textNodes = $(element).find('.slick-dots > li button').contents().filter(function() {
                    return this.nodeType === Node.TEXT_NODE;
                });

                textNodes.remove();
            });
            // Testimonial Cards Slider Js End
        })(jQuery);
    </script>
@endpush
