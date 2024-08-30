<div class="row justify-content-center">
    <div class="col-xxl-4 col-xl-6">
        <div class="form-group">
            <x-image-uploader name="thumb_image" :imagePath="getImage(getFilePath('propertyThumb') . '/' . @$property->thumb_image, getFileSize('propertyThumb'))" :size="getFileSize('propertyThumb')" class="w-100" id="thumbImage" :required="false" />
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>@lang('Title')</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', @$property->title) }}" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group position-relative">
            <label>@lang('Location')</label>
            <select name="location_id" class="select2" required>
                <option value="">@lang('Select One')</option>
                @foreach ($localities as $location)
                    <option value="{{ $location->id }}" @selected($location->id == old('location_id', @$property->location_id))>
                        {{ __($location->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>@lang('Location Map URL')</label>
            <input type="text" class="form-control" name="map_url" value="{{ old('map_url', @$property->map_url) }}" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form--label">
                @lang('Gallery Images') <small class="text--danger">
                    (@lang('You can add multiple images'))
                </small>
            </label>
            <div class="row">
                <div class="input-images pb-3">
                </div>
                <small class="text-muted"> @lang('Supported Files:')
                    <b>@lang('.png, .jpg, .jpeg')</b>
                    @lang('Image will be resized into') <b>{{ getFileSize('propertyGallery') }}</b>@lang('px')</b>
                </small>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>@lang('Details')</label>
            <textarea rows="10" class="form-control nicEdit" name="details">{{ old('details', @$property->details) }}</textarea>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>@lang('Keyword')</label>
            <select name="keywords[]"  multiple>
                <option value=""  disabled>@lang('Enter Keyword')</option>
                @foreach ((@$property->keywords ?? []) as $keyword)
                    <option value="{{$keyword}}" selected>
                        {{ __($keyword)}}
                    </option>
                @endforeach
            </select>
            <span class="text--small"><i>@lang("Optimize your property details page SEO by providing multiple keywords")</i></span>
        </div>
    </div>
</div>

@push('script-lib')
    <script src="{{ asset('assets/global/js/image-uploader.min.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/image-uploader.min.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {

                $('.select2').select2({
                    dropdownParent: $('.position-relative')
                });
                $('select[name="keywords[]"]').select2({
                    dropdownParent: $('.position-relative'),
                    tags: true,
                    tokenSeparators: [',']
                });

                @if (isset($images))
                    let preloaded = @json($images);
                @else
                    let preloaded = [];
                @endif

                $('.input-images').imageUploader({
                    preloaded: preloaded,
                    imagesInputName: 'gallery_image',
                    preloadedInputName: 'old',
                });
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .image-uploader {
            border: 2px dashed #c8c8c8;
        }
    </style>
@endpush
