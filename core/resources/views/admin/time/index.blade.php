@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $time)
                                    <tr>
                                        <td><span class="fw-bold">{{ __(@$time->name) }}</span></td>
                                        <td>{{ @$time->time }} @lang('Hours')</td>
                                        <td>@php echo @$time->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $time }}" data-modal_title="@lang('Edit Time')" data-has_status="1">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>

                                                 @if ($time->status == Status::DISABLE)
                                                     <button class="btn btn-sm btn-outline--success confirmationBtn"
                                                         data-question="@lang('Are you sure to enable this time?')"
                                                         data-action="{{ route('admin.manage.time.status', $time->id) }}">
                                                         <i class="la la-eye"></i> @lang('Enable')
                                                     </button>
                                                 @else
                                                     <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                         data-question="@lang('Are you sure to disable this time?')"
                                                         data-action="{{ route('admin.manage.time.status', $time->id) }}">
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
                @if($data->hasPages())
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
                <form action="{{ route('admin.manage.time.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="required">@lang('Time Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. @lang('Hour, Day, Week')" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="required">@lang('Time in Hours')</label>
                            <input type="text" class="form-control" name="time" value="{{ old('time') }}" required>
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
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add Time')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush
