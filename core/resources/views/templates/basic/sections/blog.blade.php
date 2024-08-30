@php
    $blogContent = getContent('blog.content', true);
    $blogElements = getContent('blog.element', limit: 3, orderById: true);
@endphp
<section class="latest-blogs py-120 bg-pattern">
    <div class="container ">
        <div class="section-heading style-left">
            <p class="section-heading__subtitle">{{ __(@$blogContent->data_values->title) }}</p>
            <div class="section-heading__wrapper">
                <h2 class="section-heading__title">{{ __(@$blogContent->data_values->heading) }}</h2>
                <a class="section-heading__link" href="{{ route('blog') }}">
                    <span>@lang('Explore')</span>
                    <i class="las la-long-arrow-alt-right"></i>
                </a>
            </div>
        </div>
        <div class="row  gy-3 justify-content-center">
            @foreach ($blogElements as $blog)
                <div class="col-sm-6 col-lg-4">
                    <article class="card blog--card">
                        <a class="card-img" href="{{ route('blog.details', [slug(@$blog->data_values->title), @$blog->id]) }}">
                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '420x250') }}"
                                alt="@lang('Blog Image')">
                        </a>
                        <div class="card-body">
                            <div class="card-date text-center">
                                <h4 class="day">{{ showDateTime(@$blog->created_at, 'd') }}</h4>
                                <span class="month">{{ showDateTime(@$blog->created_at, 'M') }} </span>
                            </div>
                            <h4 class="card-title mt-3 mb-3">
                                <a href="{{ route('blog.details', [slug(@$blog->data_values->title), @$blog->id]) }}">
                                    {{ __(@$blog->data_values->title) }}
                                </a>
                            </h4>
                            <p class="mb-3">
                                {{ strLimit(strip_tags(@$blog->data_values->description), 150) }}
                            </p>
                            <a href="{{ route('blog.details', [slug(@$blog->data_values->title), @$blog->id]) }}">@lang('Read More')</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
