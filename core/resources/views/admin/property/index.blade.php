@extends('admin.layouts.app')
@section('panel')
    @php
        $isInvestedRoute = request()->routeIs('admin.manage.property.invested');
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title') | @lang('Gola Amount')</th>
                                    <th>@lang('Total Share') | @lang('Per Share Amount')</th>
                                    <th>@lang('Invested Amount') | @lang('Progress')</th>
                                    @if ($isInvestedRoute)
                                        <th>@lang('Investment Status')</th>
                                    @endif
                                    <th>@lang('Is Featured')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                    <tr>
                                        <td>
                                            <div>
                                                {{ __(@$property->title) }} <br>
                                                {{ $general->cur_sym }}{{ showAmount($property->goal_amount) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ @$property->total_share }} <br>
                                                {{ $general->cur_sym }}{{ showAmount($property->per_share_amount) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span>
                                                    {{ $general->cur_sym }}{{ showAmount($property->invested_amount) }} |
                                                    {{ getAmount($property->invest_progress) }}%
                                                </span>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ getAmount($property->invest_progress) }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if ($isInvestedRoute)
                                            <td>@php echo @$property->investmentStatus; @endphp</td>
                                        @endif
                                        <td>@php echo @$property->isFeaturedStatus; @endphp</td>
                                        <td>@php echo @$property->statusBadge; @endphp</td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.manage.property.edit', $property->id) }}"
                                                    class="btn btn-sm btn-outline--primary">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </a>
                                                <button class="btn btn-sm btn-outline--info" data-bs-toggle="dropdown" type="button"
                                                    aria-expanded="false"><i class="las la-ellipsis-v"></i>@lang('More')</button>
                                                <div class="dropdown-menu">
                                                    @if ($property->is_featured == Status::NO)
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to feature the property?')"
                                                            data-action="{{ route('admin.manage.property.featured.status', $property->id) }}">
                                                            <i class="las la-certificate"></i> @lang('Featured')
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to un-feature the property?')"
                                                            data-action="{{ route('admin.manage.property.featured.status', $property->id) }}">
                                                            <i class="las la-certificate"></i> @lang('Un-featured')
                                                        </button>
                                                    @endif
                                                    @if ($property->status == Status::DISABLE)
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to enable this property?')"
                                                            data-action="{{ route('admin.manage.property.status', $property->id) }}">
                                                            <i class="la la-eye"></i> @lang('Enable')
                                                        </button>
                                                    @else
                                                        <button class="dropdown-item threshold confirmationBtn" data-question="@lang('Are you sure to disable this property?')"
                                                            data-action="{{ route('admin.manage.property.status', $property->id) }}">
                                                            <i class="la la-eye-slash"></i> @lang('Disable')
                                                        </button>
                                                    @endif
                                                </div>
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
                @if ($properties->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($properties) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search" />
    @if (request()->routeIs('admin.manage.property.index'))
        <a href="{{ route('admin.manage.property.create') }}" class="btn btn-sm btn-outline--primary">
            <i class="las la-plus"></i>@lang('Add New')
        </a>
    @endif
@endpush

@push('style')
    <style>
        .progress {
            height: 12px;
        }
    </style>
@endpush
