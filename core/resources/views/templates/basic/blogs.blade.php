@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="blog py-120 bg-pattern">
        <div class="container ">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="row g-3 g-md-4">
                        @foreach ($blogs as $blog)
                            <div class="col-sm-6 col-lg-4">
                                <article class="card blog--card">
                                    <a class="card-img" href="{{ route('blog.details', [slug(@$blog->data_values->title), @$blog->id]) }}">
                                        <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->image, '420x250') }}" alt="@lang('Blog Image')">
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
                                        <div class="mb-3">
                                            <p class="mb-3">
                                                {{ strLimit(strip_tags(@$blog->data_values->description), 150) }}
                                            </p>
                                            <a href="{{ route('blog.details', [slug(@$blog->data_values->title), @$blog->id]) }}">@lang('Read More')</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    @if (@$blogs->hasPages())
                        {{ paginateLinks(@$blogs) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (@$sections != null)
        @foreach (json_decode(@$sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
