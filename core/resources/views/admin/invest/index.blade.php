@extends('admin.layouts.app')
@section('panel')
    @php
        $isNotRunningInvestment = !request()->routeIs('admin.invest.running');
        $isAllInvestments = request()->routeIs('admin.invest.all');
        $isCompletedInvestments = request()->routeIs('admin.invest.completed');
    @endphp

    @if ($isAllInvestments)
        <div class="row mb-4">
            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="3" link="{{ route('admin.manage.property.invested') }}" icon="fas fa-city" title="Invested Property"
                    value="{{ $investStatistics['total_invested_property'] }}" bg="19" />
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="3" icon="fas fa-spinner" title="Running Investment" link="{{ route('admin.invest.running') }}"
                    value="{{ $general->cur_sym }}{{ showAmount($investStatistics['running_invest_amount']) }}" bg="primary" />
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="3" icon="far fa-check-circle" title="Completed Investment" link="{{ route('admin.invest.completed') }}"
                    value="{{ $general->cur_sym }}{{ showAmount($investStatistics['completed_invest_amount']) }}" bg="success" />
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="3" icon="fas fa-list" title="Total Investment"
                    value="{{ $general->cur_sym }}{{ showAmount($investStatistics['all_invest_amount']) }}" bg="17" />
            </div>
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
                                    <label>@lang('Invest Status')</label>
                                    <select name="invest_status" class="form-control">
                                        <option value="" selected>@lang('All')</option>
                                        <option value="{{ Status::RUNNING }}" @selected(request()->invest_status == Status::RUNNING)>@lang('Running')
                                        </option>
                                        <option value="{{ Status::COMPLETED }}" @selected(request()->invest_status == Status::COMPLETED)>@lang('Completed')
                                        </option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Profit Status')</label>
                                    <select class="form-control" name="profit_status">
                                        <option value="" selected>@lang('Any')</option>
                                        <option value="{{ Status::RUNNING }}" @selected(request()->profit_status == Status::RUNNING)>@lang('Running')
                                        </option>
                                        <option value="{{ Status::COMPLETED }}" @selected(request()->profit_status == Status::COMPLETED)>@lang('Completed')
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
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Property') | @lang('Invest ID')</th>
                                    <th>@lang('Invest Amount')</th>
                                    @if (!$isCompletedInvestments)
                                        <th>@lang('Paid Amount') | @lang('Due Amount')</th>
                                    @endif
                                    @if ($isNotRunningInvestment)
                                        <th>@lang('Total Profit')</th>
                                    @endif
                                    @if ($isAllInvestments)
                                        <th>@lang('Invest Status')</th>
                                    @endif
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(@$invests as $invest)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $invest->user->fullname }}</span><br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $invest->user->id) }}">
                                                    <span>@</span>{{ $invest->user->username }}
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ __($invest->property->title) }}</span> <br>
                                                <span>{{ __($invest->investment_id) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text--primary">
                                                {{ $general->cur_sym . showAmount($invest->total_invest_amount) }}
                                            </span>
                                        </td>
                                        @if (!$isCompletedInvestments)
                                            <td>
                                                <div>
                                                    <span class="text--success">{{ $general->cur_sym . showAmount($invest->paid_amount) }} </span> <br>
                                                    <span
                                                        class="@if ($invest->due_amount > 0) text--danger @else text--muted @endif">{{ $general->cur_sym . showAmount($invest->due_amount) }}</span>
                                                </div>
                                            </td>
                                        @endif
                                        @if ($isNotRunningInvestment)
                                            <td>
                                                {{ $general->cur_sym . showAmount($invest->total_profit) }}
                                            </td>
                                        @endif
                                        @if ($isAllInvestments)
                                            <td>@php echo $invest->investStatusBadge @endphp</td>
                                        @endif
                                        <td>
                                            <a href="{{ route('admin.invest.details', $invest->id) }}" class="btn btn-sm btn-outline--primary">
                                                <i class="las la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
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
                @if ($invests->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($invests) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
