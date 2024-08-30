@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-4 g-3">
        <div class="col-lg-6">
            <div class="card  b-radius--10 h-100">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Property details')</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Property Name')
                            <span class="fw-bold">{{ __(@$invest->property->title) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Investment Type')
                            <span class="fw-bold">
                                {{ $invest->property->getInvestmentType }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Total Share')
                            <span class="fw-bold">
                                {{ $invest->property->total_share }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Per Share Amount')
                            <span class="fw-bold">
                                {{ $general->cur_sym }}{{ showAmount($invest->property->per_share_amount) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Capital Back')
                            @php
                                echo $invest->property->capitalBackStatusBadge;
                            @endphp
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Profit Type')
                            <span class="fw-bold">
                                {{ $invest->property->getProfitType }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Profit Amount')
                            <span class="fw-bold">
                                <span class="value">
                                    {{ $invest->property->getProfit }}
                                </span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Profit Schedule')
                            <span class="fw-bold">
                                <span class="value">
                                    {{ $invest->property->getProfitSchedule }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card b-radius--10 h-100">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Invest Details')</h5>
                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Username')
                            <span class="fw-bold">
                                <a href="{{ route('admin.users.detail', $invest->user->id) }}">
                                    <span>@</span>{{ $invest->user->username }}
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Invested Amount')
                            <span
                                class="fw-bold text--primary">{{ $general->cur_sym }}{{ showAmount($invest->total_invest_amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Paid Amount')
                            <span class="fw-bold text--success">
                                {{ $general->cur_sym }}{{ showAmount($invest->paid_amount) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Due Amount')
                            <span
                                class="fw-bold @if ($invest->due_amount > 0) text--danger @else text--success @endif">{{ $general->cur_sym }}{{ showAmount($invest->due_amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Per Installment Amount')
                            <span
                                class="fw-bold text--info">{{ $general->cur_sym }}{{ showAmount($invest->per_installment_amount) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Total Profit')
                            <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($invest->total_profit) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Investment Status')
                            @php echo $invest->investStatusBadge @endphp
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                            @lang('Profit Status')
                            @php echo $invest->profitStatusBadge @endphp
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 g-3">
        @if ($invest->property->invest_type == Status::INVEST_TYPE_INSTALLMENT)
            <div class="col-xxl-6">
                <h5 class="mb-2">@lang('Installment History')</h5>
                <div class="card b-radius--10">
                    <div class="card-body p-0">
                        <div class="table-responsive--lg table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th class="ps-3">@lang('Installment Date')</th>
                                        <th>@lang('Paid Date')</th>
                                        <th>@lang('Late Fee')</th>
                                        <th>@lang('Status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(@$installments as $installment)
                                        <tr>
                                            <td class="ps-3">
                                                <span>{{ showDateTime($installment->next_time) }}</span> <br>
                                                <span
                                                    class="text--small">{{ diffForHumans($installment->next_time) }}</span>
                                            </td>
                                            <td>
                                                @if ($installment->status == Status::INSTALLMENT_SUCCESS)
                                                    <span>{{ showDateTime($installment->paid_time) }}</span> <br>
                                                    <span
                                                        class="text--small">{{ diffForHumans($installment->paid_time) }}</span>
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </td>
                                            <td>{{ $general->cur_sym }}{{ showAmount($installment->late_fee) }}</td>
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
                </div>
            </div>
        @endif
        <div class="col-xxl-{{ $invest->property->invest_type == Status::INVEST_TYPE_INSTALLMENT ? '6' : '12' }}">
            <h5 class="mb-2">@lang('Profit History')</h5>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('TRX')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(@$profits as $profit)
                                    <tr>
                                        <td>
                                            <span>{{ showDateTime($profit->updated_at) }}</span> <br>
                                            <span class="text--small">{{ diffForHumans($profit->updated_at) }}</span>
                                        </td>
                                        <td>{{ $general->cur_sym }}{{ showAmount($profit->amount) }}
                                        </td>
                                        <td>{{ $profit->transaction->trx }}</td>
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
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ url()->previous() }}" />
@endpush
