@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label> @lang('Image')</label>
                                    <x-image-uploader name="image" :imagePath="getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance'))" :size="false" class="w-100" id="maintenanceImage" :required="false" />
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>@lang('Status')</label>
                                            <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success"
                                                data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')"
                                                data-off="@lang('Disabled')" @if (@$general->maintenance_mode) checked @endif
                                                name="status">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Heading')</label>
                                    <input type="text" class="form-control" required name="heading"
                                        value="{{ @$maintenance->data_values->heading }}">
                                </div>
                                <div class="form-group">
                                    <label>@lang('Description')</label>
                                    <textarea class="form-control nicEdit" rows="10" name="description">@php echo @$maintenance->data_values->description @endphp</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
