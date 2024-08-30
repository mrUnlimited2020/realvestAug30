@extends($activeTemplate . 'layouts.app')
@section('main-content')
    <div class="maintenance-page flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 text-center">
                    <img src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}"
                        alt="@lang('image')" class="mb-4">
                    <h4 class="text--danger mb-2">{{ __(@$maintenance->data_values->heading) }}</h4>
                    @php echo @$maintenance->data_values->description @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
