<div class="property-details__block">
    <h5 class="title">@lang('Share now')</h5>
    <div class="mb-3">
        <ul class="social-list social-list--soft">
            <li class="social-list__item">
                <a class="social-list__link" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                    <i class="fab fa-facebook"></i>
                </a>
            </li>
            <li class="social-list__item">
                <a class="social-list__link"
                    href="https://twitter.com/intent/tweet?text={{ $title ?? '' }}&amp;url={{ urlencode(url()->current()) }}" target="_blank">
                    <i class="fab fa-twitter"></i>
                </a>
            </li>
            <li class="social-list__item">
                <a class="social-list__link"
                    href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ $title ?? '' }}&amp;summary={{ $description ?? '' }}"
                    target="_blank">
                    <i class="fab fa-linkedin"></i>
                </a>
            </li>
            <li class="social-list__item">
                <a class="social-list__link" href="https://www.instagram.com/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="input-group input-group--copy">
        <input class="form--control" type="text" value="{{ request()->url() }}" readonly>
        <button class="btn btn-soft--base" type="button">
            <i class="las la-copy"></i>
            <span>@lang('Copy')</span>
        </button>
    </div>
</div>
