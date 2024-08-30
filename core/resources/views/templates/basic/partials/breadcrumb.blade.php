@php
    $breadcrumbContent = getContent('breadcrumb.content', true);
@endphp
<section class="breadcrumb bg-img"
    data-background-image="{{ getImage('assets/images/frontend/breadcrumb/' . @$breadcrumbContent->data_values->background_image, '1920x185') }}">
    <div class="container ">
        <div class="breadcrumb__wrapper">
            <h3 class="breadcrumb__title">{{ __($pageTitle) }}</h3>
        </div>
    </div>
</section>
