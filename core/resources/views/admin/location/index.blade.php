@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Location')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $location)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('location') . '/' . $location->image, getFileSize('location')) }}"
                                                        class="plugin_bg">
                                                </div>
                                                <span class="name">{{ __($location->name) }}</span>
                                            </div>
                                        </td>

                                        <td>@php echo @$location->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                @php
                                                    $location->image_with_path = getImage(
                                                        getFilePath('location') . '/' . $location->image,
                                                        getFileSize('location'),
                                                    );
                                                @endphp
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-resource="{{ $location }}" data-modal_title="@lang('Edit Location')">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                @if ($location->status == Status::DISABLE)
                                                    <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure to enable this location')?"
                                                        data-action="{{ route('admin.manage.location.status', $location->id) }}">
                                                        <i class="la la-eye"></i> @lang('Enable')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure to disable this location')?"
                                                        data-action="{{ route('admin.manage.location.status', $location->id) }}">
                                                        <i class="la la-eye-slash"></i> @lang('Disable')
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($data) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="cuModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.manage.location.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required">@lang('Image')</label>
                            <x-image-uploader name="image" :imagePath="getFilePath('location')" :size="getFileSize('location')" class="w-100" id="localityImage" :required="true" />
                        </div>
                        <div class="form-group">
                            <label class="required">@lang('Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search" />

    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add Location')"
        data-image_path="{{ getImage(null, getFileSize('location')) }}">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('style')
    <style>
        .table-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
@endpush
