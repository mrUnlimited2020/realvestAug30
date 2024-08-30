<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('Investment Type')</label>
            <select name="invest_type" class="form-control" required>
                <option value="" selected disabled>@lang('Select One')</option>
                <option value="{{ Status::INVEST_TYPE_ONETIME }}" @selected(old('invest_type', @$property->invest_type) == Status::INVEST_TYPE_ONETIME)>
                    @lang('One Time Investment')
                </option>
                <option value="{{ Status::INVEST_TYPE_INSTALLMENT }}" @selected(old('invest_type', @$property->invest_type) == Status::INVEST_TYPE_INSTALLMENT)>
                    @lang('Investment By Installment')
                </option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group"><label>@lang('Total Share')</label>
            <div class="input-group">
                <input type="number" class="form-control" name="total_share"
                    value="{{ old('total_share', @$property ? getAmount(@$property->total_share) : '') }}" required>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>@lang('Per Share Amount')</label>
            <div class="input-group">
                <input type="number" class="form-control" name="per_share_amount"
                    value="{{ old('per_share_amount', @$property ? getAmount(@$property->per_share_amount) : '') }}" required>
                <span class="input-group-text">{{ __($general->cur_text) }}</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label class="required">@lang('Capital Back')</label>
            <select name="is_capital_back" class="form-control">
                <option value="">@lang('Select One')</option>
                <option value="{{ Status::CAPITAL_BACK_YES }}" @selected(old('is_capital_back', @$property->is_capital_back) == Status::CAPITAL_BACK_YES)>
                    @lang('Yes')
                </option>
                <option value="{{ Status::CAPITAL_BACK_NO }}" @selected(old('is_capital_back', @$property->is_capital_back) == Status::CAPITAL_BACK_NO)>
                    @lang('No')</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>@lang('Profit Back')</label>
            <div class="input-group">
                <input type="number" step="any" class="form-control" name="profit_back"
                    value="{{ old('profit_back', @$property->profit_back) }}" required>
                <span class="input-group-text">@lang('Day')</span>
            </div>
            <span class="text--small"><i>@lang('Investors start profit after investment')</i></span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>@lang('Profit Type')</label>
            <select name="profit_type" class="form-control" required>
                <option value="{{ Status::PROFIT_TYPE_FIXED }}" @selected(old('profit_type', @$property->profit_type) == Status::PROFIT_TYPE_FIXED)>@lang('Fixed')
                </option>
                <option value="{{ Status::PROFIT_TYPE_RANGE }}" @selected(old('profit_type', @$property->profit_type) == Status::PROFIT_TYPE_RANGE)>@lang('Range')
                </option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="row invest-by-installment d-none">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required">@lang('Total Installment')</label>
                    <input type="number" class="form-control" name="total_installment"
                        value="{{ old('total_installment', @$property->total_installment) }}">
                    <small class="text--muted perInstallment d-none"><i class="las la-info-circle"></i>
                        <i class="perInstallmentAmount"></i></small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required">@lang('Down Payment')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="down_payment"
                            value="{{ old('down_payment', @$property ? getAmount(@$property->down_payment) : '') }}">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="required">@lang('Per Installment Amount')</label>
                    <div class="input-group">
                        <input type="number" readonly class="form-control" name="per_installment_amount"
                            value="{{ old('per_installment_amount', @$property->per_installment_amount) }}">
                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="required">@lang('Installment Late Fee')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="installment_late_fee"
                            value="{{ old('installment_late_fee', @$property ? getAmount(@$property->installment_late_fee) : '') }}">
                        <span class="input-group-text">@lang('%')</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="required">@lang('Time Between Two Installment')</label>
                    <select name="installment_duration" class="form-control">
                        <option value="">@lang('Select One')</option>
                        @foreach ($times as $time)
                            <option value="{{ $time->id }}" @selected(old('installment_duration', @$property->installment_duration) == $time->id)>
                                {{ __($time->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>@lang('Profit Amount Type')</label>
                    <select class="form-control" name="profit_amount_type">
                        <option @selected(old('profit_amount_type', @$property->profit_amount_type) == Status::PROFIT_AMOUNT_TYPE_PERCENT) value="{{ Status::PROFIT_AMOUNT_TYPE_PERCENT }}">
                            @lang('%')</option>
                        <option @selected(old('profit_amount_type', @$property->profit_amount_type) == Status::PROFIT_AMOUNT_TYPE_FIXED) value="{{ Status::PROFIT_AMOUNT_TYPE_FIXED }}">
                            {{ __($general->cur_text) }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 profit--type-fixed">
                <div class="form-group">
                    <label>@lang('Profit Amount')</label>
                    <div class="input-group">
                        <input type="number" class="form-control field-for-profit-fixed" name="profit_amount"
                            value="{{ old('profit_amount', @$property ? getAmount(@$property->profit_amount) : '') }}" />
                        <span class="input-group-text profit--amount-type">@lang('%')</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 profit--type-range  d-none">
                <div class="form-group">
                    <label>@lang('Minimum Profit Amount')</label>
                    <div class="input-group">
                        <input type="number" class="form-control field-for-profit-range" name="minimum_profit_amount"
                            value="{{ old('minimum_profit_amount', @$property ? getAmount(@$property->minimum_profit_amount) : '') }}" />
                        <span class="input-group-text profit--amount-type">@lang('%')</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 profit--type-range d-none">
                <div class="form-group">
                    <label>@lang('Maximum Profit Amount')</label>
                    <div class="input-group">
                        <input type="number" class="form-control field-for-profit-range" name="maximum_profit_amount"
                            value="{{ old('maximum_profit_amount', @$property ? getAmount(@$property->maximum_profit_amount) : '') }}" />
                        <span class="input-group-text profit--amount-type">@lang('%')</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 profit-distribution-wrapper">
                <div class="form-group">
                    <label>@lang('Profit Distribution')</label>
                    <select name="profit_distribution" class="form-control profit-distribution" required>
                        <option value="" selected disabled>@lang('Select One')</option>
                        <option value="{{ Status::PROFIT_DISTRIBUTION_MANUAL }}" @selected(old('profit_distribution', @$property->profit_distribution) == Status::PROFIT_DISTRIBUTION_MANUAL)>
                            @lang('Manual')
                        </option>
                        <option value="{{ Status::PROFIT_DISTRIBUTION_AUTO }}" @selected(old('profit_distribution', @$property->profit_distribution) == Status::PROFIT_DISTRIBUTION_AUTO)>
                            @lang('Auto')
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 profit-distribution-amount-wrapper d-none">
                <div class="form-group">
                    <label>@lang('Auto Profit Distribution Amount')</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="auto_profit_distribution_amount"
                            value="{{ old('auto_profit_distribution_amount', @$property ? getAmount(@$property->auto_profit_distribution_amount) : '') }}" />
                        <span class="input-group-text profit--amount-type">@lang('%')</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 return-type-wrapper">
                <div class="form-group">
                    <label>@lang('Profit Schedule')</label>
                    <select name="profit_schedule" class="form-control" required>
                        <option value="" selected disabled>@lang('Select One')</option>
                        <option value="{{ Status::PROFIT_ONETIME }}" @selected(old('profit_schedule', @$property->profit_schedule) == Status::PROFIT_ONETIME)>
                            @lang('One Time')
                        </option>
                        <option value="{{ Status::PROFIT_LIFETIME }}" @selected(old('profit_schedule', @$property->profit_schedule) == Status::PROFIT_LIFETIME)>
                            @lang('Lifetime')
                        </option>
                        <option value="{{ Status::PROFIT_REPEATED_TIME }}" @selected(old('profit_schedule', @$property->profit_schedule) == Status::PROFIT_REPEATED_TIME)>
                            @lang('Repeated Time')
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 profit-time-period-wrapper d-none">
                <div class="form-group">
                    <label>@lang('Profit Schedule Period')</label>
                    <select name="profit_schedule_period" class="form-control">
                        <option value="">@lang('Select One')</option>
                        @foreach ($times as $time)
                            <option value="{{ $time->id }}" @selected(old('profit_schedule_period', @$property->profit_schedule_period) == $time->id)>
                                {{ __($time->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12 repeatTime d-none">
                <div class="form-group">
                    <label>@lang('Repeat Time')</label>
                    <input type="number" name="profit_repeat_time"
                        value="{{ old('profit_repeat_time', @$property->profit_repeat_time ? @$property->profit_repeat_time : '') }}"
                        class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {

                let curText = '{{ __($general->cur_text) }}';

                const installmentInvest = parseInt("{{ Status::INVEST_TYPE_INSTALLMENT }}");

                $(`select[name=invest_type]`).on('change', function(e) {
                    const {
                        value
                    } = e.target;

                    if (value == installmentInvest) {
                        $(".invest-by-installment").removeClass('d-none');
                        $('select[name=installment_duration]').removeAttr('disabled');
                        $('input[name=installment_late_fee]').removeAttr('disabled');
                        $('input[name=down_payment]').removeAttr('disabled');
                        $('input[name=total_installment]').removeAttr('disabled');
                    } else {
                        $(".invest-by-installment").addClass('d-none');
                        $('select[name=installment_duration]').attr('disabled', true);
                        $('input[name=installment_late_fee]').attr('disabled', true);
                        $('input[name=down_payment]').attr('disabled', true);
                        $('input[name=total_installment]').attr('disabled', true);
                    }
                }).change();

                function perInstallmentAmount() {

                    const perShareAmount = Number($('input[name=per_share_amount]').val());
                    if (!perShareAmount) return;

                    const totalInstallment = parseInt($(`input[name=total_installment]`).val());
                    const downPaymentPercentage = parseInt($(`input[name=down_payment]`).val());

                    if (totalInstallment && downPaymentPercentage) {
                        const dowPaymentAmount = (perShareAmount / 100) * downPaymentPercentage;
                        const amountExcludeDownPayment = perShareAmount - dowPaymentAmount;
                        const perInstallment = amountExcludeDownPayment / totalInstallment;

                        $(`input[name=per_installment_amount]`).val(parseFloat(perInstallment).toFixed(3));
                    } else {
                        $(`input[name=per_installment_amount]`).val('');
                    }
                }

                $(`input[name=total_installment], input[name=down_payment]`).on(`input`, function(e) {
                    perInstallmentAmount();
                });

                @if (@$property)
                    perInstallmentAmount();
                @endif

                $(`select[name=profit_schedule]`).on('change', function(e) {
                    const value = $(this).val();

                    if (!value) return

                    if (value == 3) {
                        $('.profit-time-period-wrapper').addClass('d-none');
                        $('select[name=profit_schedule_period]').attr('disabled', true);
                        $('.return-type-wrapper').addClass('col-lg-12').removeClass('col-lg-6');
                    } else {
                        $('.profit-time-period-wrapper').removeClass('d-none');
                        $('select[name=profit_schedule_period]').removeAttr('disabled');
                        $('.return-type-wrapper').removeClass('col-lg-12').addClass('col-lg-6');
                    }

                    if (value == 2) {
                        $('.repeatTime').removeClass('d-none');
                        $('input[name=profit_repeat_time]').removeAttr('disabled');
                    } else {
                        $('.repeatTime').addClass('d-none');
                        $('input[name=profit_repeat_time]').attr('disabled', true);
                    }

                }).change();

                $(`select[name=profit_type]`).on('change', function(e) {
                    let type = parseInt($(this).val());
                    if (type == 1) {
                        $('.profit--type-fixed').removeClass('d-none');
                        $('.profit--type-range').addClass('d-none');

                        $(".field-for-profit-fixed").attr('required', true);
                        $(".field-for-profit-fixed").removeAttr('disabled');

                        $(".field-for-profit-range").removeAttr('required');
                        $(".field-for-profit-range").attr('disabled', true);

                        $('.profit-distribution-wrapper').addClass('col-lg-12').removeClass('col-lg-6');
                        $('.profit-distribution-amount-wrapper').addClass('d-none')
                        $('input[name=auto_profit_distribution_amount]').attr('disabled', true);
                    } else {
                        $('.profit--type-fixed').addClass('d-none');
                        $('.profit--type-range').removeClass('d-none');

                        $(".field-for-profit-range").attr('required', true);
                        $(".field-for-profit-range").removeAttr('disabled');

                        $(".field-for-profit-fixed").removeAttr('required');
                        $(".field-for-profit-fixed").attr('disabled', true);

                        if ($('select[name=profit_distribution]').val() == 2) {
                            $('.profit-distribution-wrapper').addClass('col-lg-6').removeClass(
                                'col-lg-12');
                            $('.profit-distribution-amount-wrapper').removeClass('d-none')
                            $('input[name=auto_profit_distribution_amount]').removeAttr('disabled');
                        }
                    }
                }).change();

                $(`select[name=profit_amount_type]`).on('change', function(e) {
                    $('.profit--amount-type').text($(this).find(`option:selected`).text())
                }).change();

                $('select[name=profit_distribution]').on('change', function(e) {
                    let value = $(this).val();
                    if (!value) return;

                    let profitType = $('select[name=profit_type]').val();
                    if (value == 2 && profitType == 2) {
                        $('.profit-distribution-wrapper').addClass('col-lg-6').removeClass('col-lg-12');
                        $('.profit-distribution-amount-wrapper').removeClass('d-none')
                        $('input[name=auto_profit_distribution_amount]').removeAttr('disabled');
                    } else {
                        $('.profit-distribution-wrapper').addClass('col-lg-12').removeClass('col-lg-6');
                        $('.profit-distribution-amount-wrapper').addClass('d-none')
                        $('input[name=auto_profit_distribution_amount]').attr('disabled', true);
                    }
                }).change();

            });
        })(jQuery);
    </script>
@endpush
