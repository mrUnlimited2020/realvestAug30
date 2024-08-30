@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-4">
        <div class="col-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i>
                    @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('Serach')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control"
                                    placeholder="@lang('Property')/@lang('Username')/@lang('Investment ID')">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Installment Status')</label>
                                <select name="status" class="form-control">
                                    <option value="" selected>@lang('All')</option>
                                    <option value="{{ Status::INSTALLMENT_PENDING }}" @selected(request()->status == Status::INSTALLMENT_PENDING)>@lang('Due')
                                    </option>
                                    <option value="{{ Status::INSTALLMENT_SUCCESS }}" @selected(request()->status == Status::INSTALLMENT_SUCCESS)>@lang('Completed')
                                    </option>
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i>
                                    @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Property') | @lang('Invest Id')</th>
                                    <th>@lang('Installment Date')</th>
                                    <th>@lang('Installment Amount')</th>
                                    <th>@lang('Invest Amount')</th>
                                    <th>@lang('Paid Amount') | @lang('Due Amount')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(@$installments as $installment)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $installment->invest->user->fullname }}</span><br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $installment->invest->user->id) }}">
                                                    <span>@</span>{{ $installment->invest->user->username }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span>
                                                    {{ __(@$installment->invest->property->title) }}
                                                </span> <br>
                                                <span class="small">{{ $installment->invest->investment_id }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span>{{ showDateTime($installment->next_time) }}</span> <br>
                                                <span class="small">{{ diffForHumans($installment->next_time) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $general->cur_sym . showAmount($installment->invest->per_installment_amount) }}
                                        </td>
                                        <td>{{ $general->cur_sym . showAmount($installment->invest->total_invest_amount) }}</td>
                                        <td>
                                            <div>
                                                <span class="text--success">
                                                    {{ $general->cur_sym . showAmount($installment->invest->paid_amount) }} <br>
                                                </span>
                                                <span class="@if ($installment->invest->due_amount > 0) text-danger @else text--muted @endif">
                                                    {{ $general->cur_sym . showAmount($installment->invest->due_amount) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>@php echo $installment->installmentStatusBadge @endphp</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($installments->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($installments) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

{{-- @push('breadcrumb-plugins')
    <x-search-form placeholder="Search..." />
@endpush --}}
