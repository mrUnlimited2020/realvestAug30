@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="blog blog-details py-120 bg-pattern">
        <div class="container ">
            <div class="row justify-content-sm-center">
                <div class="col-sm-11 col-md-10 col-lg-7 col-xl-8">
                    <div class="text-end d-lg-none mb-4">
                        <button class="btn btn--sm btn-outline--base btn--sidebar-open" type="button" data-toggle="sidebar"
                            data-target="#blog-sidebar">
                            <i class="las la-long-arrow-alt-left"></i>
                            <span>@lang('Latest Blog')</span>
                        </button>
                    </div>
                    <div class="blog-details__inner mb-3">
                        <img class="blog-details__thumb"
                            src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->image, '840x410') }}"
                            alt="blog-image">
                        <div class="blog-details__content">
                            <div class="blog-details__date">
                                <h4 class="day">{{ @$blog->created_at->format('d') }}</h4>
                                <span class="month">{{ @$blog->created_at->format('M') }}</span>
                            </div>
                            <h1 class="blog-details__title mt-4">{{ __(@$blog->data_values->title) }}</h1>
                            <div class="blog-details__desc">
                                @php echo __(@$blog->data_values->description) @endphp
                            </div>
                        </div>
                        <div class="comment-form-area">
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>
                        </div>
                    </div>
                    @include($activeTemplate . 'partials.share_now', [
                        'title' => @$blog->data_values->title,
                        'description' => strLimit(@$blog->data_values->description, 200),
                    ])
                </div>
                <div class="col-sm-12 col-lg-5 col-xl-4">
                    <aside id="blog-sidebar" class="blog-sidebar">
                        <div class="blog-sidebar__top">
                            <button class="close-btn" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="blog-sidebar__block">
                            <h5 class="blog-sidebar__title">@lang('Latest Posts')</h5>
                            <div class="blog-sidebar__popular-blogs">
                                @foreach (@$latestBlogs as $latestBlog)
                                    <div class="popular-blog">
                                        <div class="popular-blog__thumb">
                                            <a
                                                href="{{ route('blog.details', [slug(@$latestBlog->data_values->title), @$latestBlog->id]) }}">
                                                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$latestBlog->data_values->image, '420x250') }}"
                                                    alt="blog-image">
                                            </a>
                                        </div>
                                        <div class="popular-blog__content">
                                            <h6 class="popular-blog__title">
                                                <a
                                                    href="{{ route('blog.details', [slug(@$latestBlog->data_values->title), @$latestBlog->id]) }}">
                                                    {{ @$latestBlog->data_values->title }}
                                                </a>
                                            </h6>
                                            <div class="popular-blog__date">
                                                <i class="far fa-calendar"></i>
                                                <span>
                                                    {{ @$latestBlog->created_at->format('D') }},
                                                    {{ @$latestBlog->created_at->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush

@push('style')
    <style>
        .blog-details__inner h6{
            margin-bottom: 0.5rem !important;
            font-size: 1.125rem !important;
        }
    </style>
@endpush