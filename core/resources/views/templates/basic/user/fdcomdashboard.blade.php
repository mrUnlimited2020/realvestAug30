@extends($activeTemplate . 'layouts.master')
@php
    $kycInstructionContent = getContent('kyc_instruction.content', true);
@endphp
@section('content')

    <!--Direct Sales Comm-->
    <div class="row gy-4 dashboard-widget-wrapper mb-4 justify-content-center">
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-donate"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Direct Sales Comm')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['direct_sales_comm']) }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!--Referrals Sales Comm-->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Ref Sales Comm')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['referrals_sales_comm']) }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!-- Balance Wallet -->
        <div class="col-xl-4 col-lg-6 col-sm-6 ">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('My Balance')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['sales_balance']) }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!-- Direct Sales Volume Wallet -->
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Direct Sales Volume')</span>
                    <h6 class="dashboard-widget__number">
                        {{ @$widget['food_comm_direct_sales_volume'] }}
                    </h6>
                </div>
            </div>
        </div>
        
        <!--Team Sales Volume Wallet-->
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="far fa-credit-card"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('Team Sales Volume')</span>
                    <h6 class="dashboard-widget__number">
                        {{ $general->cur_sym }}{{ showAmount(@$widget['food_comm_team_sales_volume']) }}
                    </h6>
                </div>
            </div>
        </div>
    
        <!-- Profit Sharing Token Wallet -->
        <div class="col-xl-4 col-lg-6 col-sm-4">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('PST of DSV')</span>
                    <h6 class="dashboard-widget__number">
                         {{ $widget['pst_of_dsv'] }}<span class="dashboard-widget__text">@lang('units')</span>
                    </h6>
                </div>
            </div>
        </div>
        <!-- Profit Sharing Token Wallet 2 -->
        <div class="col-xl-4 col-lg-6 col-sm-4">
            <div class="dashboard-widget flex-align">
                <div class="dashboard-widget__icon flex-center">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="dashboard-widget__content">
                    <span class="dashboard-widget__text">@lang('PST of TSV')</span>
                    <h6 class="dashboard-widget__number">
                         {{ $widget['pst_of_tsv'] }}<span class="dashboard-widget__text">@lang('units')</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>
@endsection
