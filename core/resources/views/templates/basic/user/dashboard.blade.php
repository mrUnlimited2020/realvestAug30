@extends($activeTemplate . 'layouts.master')
@php
    $kycInstructionContent = getContent('kyc_instruction.content', true);
@endphp
@section('content')
    @if ($user->kv == 0)
        <div class="mb-4">
            <div class="alert alert--custom mb-0 alert--danger" role="alert">
                <h6 class="alert-heading">@lang('KYC Verification required')</h6>
                <p class="alert-text">
                    {{ __(@$kycInstructionContent->data_values->kyc_required_description) }}
                </p>
                <a class="alert-link custom-alert-link custom-alert-danger-link" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
            </div>
        </div>
    @elseif($user->kv == 2)
        <div class="mb-4">
            <div class="alert alert--custom mb-0 alert--info" role="alert">
                <h6 class="alert-heading">@lang('KYC Verification pending')</h6>
                <p class="alert-text">
                    {{ __(@$kycInstructionContent->data_values->kyc_pending_description) }}
                </p>
                <a class="alert-link custom-alert-link custom-alert-info-link" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
            </div>
        </div>
    @endif
    <div class="row gy-4 dashboard-widget-wrapper mb-4 justify-content-center">
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-donate"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Remaining Balance')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['balance']) }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Deposit')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['total_deposit']) }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Withdraw')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['total_withdraw']) }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!-- New Custom Wallet Begins -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Investment Minus Reg.')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['total_after_fees']) }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!-- New Custom Wallet, PSQ Voucher -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('PSQ Voucher')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['psq_invest']) }}
                    </h6>
                </div>
            </div>
        </div>

        <!-- New Custom Wallet, Virtual Landlord -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Virtual Landlord')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['v_landlord_invest']) }}
                    </h6>
                </div>
            </div>
        </div>

        <!-- New Custom Wallet, Thrift -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Thrift')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['thrift_invest']) }}
                    </h6>
                </div>
            </div>
        </div>

        <!-- New Custom Wallet, Referral Commission -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Referral Commission')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['referral_balance']) }}
                    </h6>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Profit')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['total_profit']) }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-city"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Invested Assets')</span>
                    <h6 class="dashboard-widget__number">
                        {{ @$widget['total_property'] }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-bezier-curve"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('My Referrals')</span>
                    <h6 class="dashboard-widget__number">
                        {{ @$widget['referral'] }}
                    </h6>
                </div>
            </div>
        </div>
        <!-- Team Sales Volume Wallet -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-bezier-curve"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Team Sales Volume')</span>
                    <h6 class="dashboard-widget__number">
                        {{ @$widget['team_sales_volume'] }}
                    </h6>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fa fa-ticket-alt"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Total Ticket')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $widget['total_ticket'] }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    @if ($nextInstallment)
        <div class="mb-4">
            <div class="flex-end mb-3 breadcrumb-dashboard">
                <h6 class="page-title">@lang('Next Installment')</h6>
            </div>
            <div class="row dashboard-widget-wrapper">
                <div class="col-md-12">
                    <div class="table-responsive table--responsive--xl">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Property')</th>
                                    <th>@lang('Installment Amount')</th>
                                    <th>@lang('Installment Date')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>
                                    {{ @$nextInstallment->invest->property->title }}
                                </td>
                                <td>
                                    {{ $general->cur_sym }}{{ showAmount(@$nextInstallment->invest->per_installment_amount) }}
                                </td>
                                <td>{{ showDateTime(@$nextInstallment->next_time, 'Y-m-d') }}</td>
                                <td>
                                    @if (@$nextInstallment->status == Status::ENABLE)
                                        @lang('Completed')
                                    @else
                                        @lang('Due')
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-outline--primary action--btn" id="installmentBtn"
                                        data-action="{{ route('user.invest.installment.pay', [encrypt(@$nextInstallment->invest->id), encrypt(@$nextInstallment->id)]) }}"
                                        title="Pay Installment">
                                        <i class="las la-coins"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (@$nextProfitSchedule)
        <div class="flex-end mb-3 breadcrumb-dashboard">
            <h6 class="page-title">@lang('Next Profit Schedule')</h6>
        </div>
        <div class="row dashboard-widget-wrapper">
            <div class="col-md-12">
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Property')</th>
                                <th>@lang('Total Profit')</th>
                                <th>@lang('Next Profit Date')</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                {{ @$nextProfitSchedule->property->title }}
                            </td>
                            <td>
                                {{ $general->cur_sym }}{{ showAmount(@$nextProfitSchedule->total_profit) }}
                            </td>
                            <td>
                                <div>
                                    {{ showDateTime(@$nextProfitSchedule->next_profit_date, 'Y-m-d') }}<br>
                                    <span class="small">{{ diffForHumans($nextProfitSchedule->next_profit_date) }}</span>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if (@$nextInstallment)
        @include($activeTemplate . 'partials.installment_modal')
    @endif
@endsection
