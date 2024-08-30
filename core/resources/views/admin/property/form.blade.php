@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-xxl-8 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link @if ($step == 1) active @endif"
                                href="{{ @$property ? route('admin.manage.property.edit', $property->id) . '?step=1' : route('admin.manage.property.create') }}">
                                <i class="las la-warehouse"></i>
                                @lang('Property Setting')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($step == 2) active @endif @if(!@$property) disabled @endif"
                                href="{{ @$property ? route('admin.manage.property.edit', $property->id) . '?step=2' : 'javvascript:void(0)' }}">
                                <i class="las la-seedling"></i>
                                @lang('Investment Setting')
                            </a>
                        </li>
                    </ul>
                    <form action="{{ route('admin.manage.property.store', @$property->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" value="{{ $step }}">
                        @include("admin.property.step.$step")
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.manage.property.index') }}" />
@endpush


@push('style')
    <style>
        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #212529c9;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        .nav-tabs .nav-link {
            color: #212529c9;
        }

        @media(max-width: 380px) {
            .nav-link {
                padding: 8px 7px;
                font-size: 12px;
            }
        }

        .image--uploader .mt-2 {
            text-align: center !important;
        }

        .image-uploader .upload-text span {
            font-size: 14px !important;
            color: #6c757d !important;
        }

        .image-uploader .upload-text i {
            margin-bottom: 0px !important;
        }
    </style>
@endpush
