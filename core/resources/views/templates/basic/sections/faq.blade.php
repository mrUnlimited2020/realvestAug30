@php
    $faqContent  = getContent('faq.content', true);
    $faqElements = getContent('faq.element', orderById: true);
@endphp

<section class=" pb-120 bg-pattern">
    <div class="container custom--container">
        <div class="section-heading style-left mb-4">
            <h2 class="section-heading__title">{{ __(@$faqContent->data_values->title) }}</h2>
        </div>
        <div class="accordion custom--accordion" id="faq-accordion">
            @foreach (@$faqElements as $key => $faqElement)
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button @if (!$loop->first)  collapsed @endif" type="button" data-bs-toggle="collapse"
                            data-bs-target="#faq-accordion-item-{{ $loop->index }}" aria-expanded="true">
                            {{ __(@$faqElement->data_values->question) }}
                        </button>
                    </div>
                    <div id="faq-accordion-item-{{ $loop->index }}" class="accordion-collapse  collapse   @if ($loop->first) show  @endif"
                        data-bs-parent="#faq-accordion" style="">
                        <div class="accordion-body">
                            <p class="text">
                                {{ __(@$faqElement->data_values->answer) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
