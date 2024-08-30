@php
    $gatewayCurrency = App\Models\GatewayCurrency::whereHas('method', function ($gate) {
        $gate->where('status', Status::ENABLE);
    })
        ->with('method')
        ->orderby('method_code')
        ->get();
@endphp
<div id="investModal" class="modal fade custom--modal invest-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 mb-2">
                <div>
                    <h6 class="modal-title">@lang('Invest to ') - <span class="text--base">{{ __($property->title) }}</span></h6>
                </div>
                <button class="close-btn" type="button" data-bs-dismiss="modal">
                    <i class="las fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.invest.store', encrypt(@$property->id)) }}" class="modal-form" id="investForm">
                    @csrf
                    <input type="hidden" name="method" id="paymentMethod" value="gateway">
                    <input name="currency" type="hidden">
                    <div class="modal-form__body">
                        <div class="mb-4">
                            <ul class="modal-form__info">
                                @if (@$property->invest_type == Status::INVEST_TYPE_INSTALLMENT)
                                    <li class="modal-form__info-item">
                                        <span class="label">@lang('Down Payment')</span>
                                        <span class="value">{{ getAmount(@$property->down_payment) }}%</span>
                                    </li>
                                    <li class="modal-form__info-item">
                                        <span class="label">@lang('Initial Invest Amount')</span>
                                        <span class="value">
                                            {{ $general->cur_sym }}{{ showAmount($initialInvestAmount) }}
                                        </span>
                                    </li>
                                @endif
                                <li class="modal-form__info-item">
                                    <span class="label">@lang('Profit')</span>
                                    <span class="value">
                                        {{ @$property->getProfit }}
                                    </span>
                                </li>
                                <li class="modal-form__info-item">
                                    <span class="label">@lang('Profit Schedule')</span>
                                    <span class="value">
                                        {{ @$property->getProfitSchedule }}
                                    </span>
                                </li>
                                <li class="modal-form__info-item">
                                    <span class="label">@lang('Profit Back')</span>
                                    <span class="value">
                                        @lang(@$property->profit_back . ' days after investment completed')
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between flex-wrap">
                                <label class="form-label">@lang('Invest Amount')</label>
                                @if (@$property->invest_type == Status::INVEST_TYPE_INSTALLMENT)
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" name="invest_full_amount" type="checkbox" value="true"
                                            id="invest_full_amount">
                                        <label class="form-check-label form-label" for="invest_full_amount">
                                            @lang('Invest Full Amount')
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <!--<div class="input-group--custom style-two">-->
                            <!--    @if (@$property->invest_type == Status::INVEST_TYPE_ONETIME)-->
                            <!--        <input class="form--control" type="number" name="invest_amount"-->
                            <!--            value="{{ getAmount(@$property->per_share_amount) }}" readonly>-->
                            <!--    @else-->
                            <!--        <input class="form--control" type="number" name="invest_amount"-->
                            <!--            value="{{ old('invest_amount', getAmount(@$initialInvestAmount)) }}" readonly>-->
                            <!--    @endif-->
                            <!--    <span class="input-group-text">{{ __($general->cur_text) }}</span>-->

                            <!--</div>-->
                            
                            <div class="input-group--custom style-two">
                                @if (@$property->invest_type == Status::INVEST_TYPE_ONETIME)
                                    <input class="form--control" type="number" name="invest_amount"
                                        value="{{ getAmount(@$property->per_share_amount) }}" 
                                        min="{{ getAmount(@$property->per_share_amount) }}">
                                @else
                                    <input class="form--control" type="number" name="invest_amount"
                                        value="{{ old('invest_amount', getAmount(@$initialInvestAmount)) }}" 
                                        min="{{ getAmount(@$property->per_share_amount) }}">
                                @endif
                                <span class="input-group-text">{{ __($general->cur_text) }}</span>

                            </div>
                            
                            <div class="mt-2 preview-details d-none">
                                <span>
                                    <span>@lang('Charge'):</span>
                                    <span class="text--base">{{ $general->cur_sym }}<span class="charge ">0</span></span>,
                                </span>
                                <span>
                                    <span>@lang('Total Amount'): </span> <span class="text--base">{{ $general->cur_sym }}<span class="payable ">
                                            0</span></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group gateway-option">
                            <label class="form-label required">@lang('Select Gateway')</label>
                            <select class="gateway-select-box" name="gateway" >
                                <option data-title="@lang('Select One')" data-charge="@lang('N/A')" value="">
                                    @lang('Select One')
                                </option>
                                @foreach ($gatewayCurrency as $data)
                                    <option data-gateway="{{ $data }}"
                                        data-title="{{ __($data->name) }} ({{ gs('cur_sym') }}{{ showAmount($data->min_amount) }} to {{ gs('cur_sym') }}{{ showAmount($data->max_amount) }})"
                                        data-charge="{{ gs('cur_sym') }} {{ showAmount($data->fixed_charge) }} + {{ getAmount($data->percent_charge) }}%"
                                        value="{{ $data->method_code }}" @selected(old('gateway') == $data->method_code)>
                                        {{ __($data->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="preview-details d-none mt-2">
                                <span class="d-none rate-element"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-form__footer flex-row   flex-wrap form-group">
                        <button type="button" class="flex-fill btn btn-outline--base active" id="payGatewayButton">
                            <span class="active-badge"> <i class="las la-check"></i> </span>
                            @lang('Pay via Gateway')
                        </button>
                        <button type="button" class="flex-fill btn btn-outline--base" id="payBalanceButton">
                            <span class="active-badge"> <i class="las la-check"></i> </span>
                            @lang('Pay via Balance')
                        </button>
                    </div>
                    <button type="submit" class="flex-fill btn btn--base w-100">
                        @lang('Invest Now')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        "use strict";
        (function($) {

            
            $('input[name=invest_full_amount]').on('change', function() {
                // Store the user's input value below
                var userEnteredAmount = $('input[name=invest_amount]').val(); 
                if (this.checked) {
                    //$('input[name=invest_amount]').val({{ $property->per_share_amount }});
                    $('input[name=invest_amount]').val(userEnteredAmount);
                    
                } else {
                    $('input[name=invest_amount]').val({{ $initialInvestAmount }});
                }
            });

            $('#payGatewayButton').on("click", function() {
                $(this).parent().find("button").removeClass('active');
                $(this).addClass('active');
                $('.gateway-option').removeClass('d-none');
                $('#paymentMethod').val('gateway');
            });

            $('#payBalanceButton').on("click", function() {
                $(this).parent().find("button").removeClass('active');
                $(this).addClass('active');
                $('.gateway-option').addClass('d-none');
                $('#paymentMethod').val('balance');
                $('.preview-details').addClass('d-none');
            });

            var gatewayOptions = $('.gateway-select-box').find('option');
            var gatewayHtml = `<div class="gateway-select">
                <div class="selected-gateway d-flex justify-content-between align-items-center">
                    <p class="gateway-title">PayPal - USD ($100 to $15,000)</p>
                    <div class="icon-area">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
                <div class="gateway-list d-none">`;

            $.each(gatewayOptions, function(key, option) {
                option = $(option);
                if (option.data('title') && option.data('charge') != 'N/A') {
                    gatewayHtml += `<div class="single-gateway" data-value="${option.val()}">
                            <p class="gateway-title">${option.data('title')}</p>
                            <p class="gateway-charge">Charge: ${option.data('charge')}</p>
                        </div>`;
                } else {
                    gatewayHtml += `<div class="single-gateway" data-value="${option.val()}">
                            <p class="gateway-title">${option.data('title')}</p>
                        </div>`;
                }
            });
            gatewayHtml += `</div></div>`;
            $('.gateway-select-box').after(gatewayHtml);
            var selectedGateway = $('.gateway-select-box :selected');
            $(document).find('.selected-gateway .gateway-title').text(selectedGateway.data('title'))

            $('.selected-gateway').on('click', function() {
                $('.gateway-list').toggleClass('d-none');
                $(this).toggleClass('focus');
                $(this).find('.icon-area').find('i').toggleClass('la-angle-up');
                $(this).find('.icon-area').find('i').toggleClass('la-angle-down');
            })

            $(document).on('click', '.single-gateway', function() {
                $('.selected-gateway').find('.gateway-title').text($(this).find('.gateway-title').text());
                $('.gateway-list').addClass('d-none');
                $('.selected-gateway').removeClass('focus');
                $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-up');
                $('.selected-gateway').find('.icon-area').find('i').toggleClass('la-angle-down');
                $('.gateway-select-box').val($(this).data('value'));
                $('.gateway-select-box').trigger('change');
            });

            function selectPostType(whereClick, whichHide) {
                if (!whichHide) return;

                $(document).on("click", function(event) {
                    var target = $(event.target);
                    if (!target.closest(whereClick).length) {
                        $(document).find('.icon-area i').addClass("la-angle-down").removeClass('la-angle-up');
                        whichHide.addClass("d-none");
                        whereClick.removeClass('focus');
                    }
                });
            }
            selectPostType(
                $('.selected-gateway'),
                $(".gateway-list")
            );

            $('select[name=gateway]').change(function() {

                if (!$('select[name=gateway]').val()) {
                    console.log("none");
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                var resource = $('select[name=gateway] option:selected').data('gateway');
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)

                if (resource.method.crypto == 1) {
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                } else {
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }
                $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                $('.max').text(parseFloat(resource.max_amount).toFixed(2));
                var amount = parseFloat($('input[name=invest_amount]').val());
                if (!amount) {
                    amount = 0;
                }
                if (amount <= 0) {
                    $('.preview-details').addClass('d-none');
                    return false;
                }
                $('.preview-details').removeClass('d-none');
                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                    toFixedDigit);
                $('.final_amo').text(final_amo);
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement =
                        `<span class="">@lang('Conversion Rate')</span> <span><span  class="">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="method_currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input', function() {
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .invest-modal .form-check-input:focus {
            border-color: hsl(var(--base));
            box-shadow: none;
        }

        .invest-modal .form-check-input:checked {
            background-color: hsl(var(--base));
            border: 1px solid hsl(var(--base));
        }

        .invest-modal .form-check-input {
            border: 1px solid hsl(var(--base));
        }

        .invest-modal .modal-form__footer button.active {
            border-color: hsl(var(--base));
            position: relative;
        }


        .invest-modal .modal-form__footer button .active-badge {
            display: none;
        }

        .invest-modal .modal-form__footer button.active .active-badge {
            right: 0px;
            top: -1px;
            position: absolute;
            color: #ffffff;
            background: hsl(var(--base));
            text-align: right;
            width: 50px;
            height: 40px;
            padding-right: 4px;
            clip-path: polygon(100% 0, 0 1%, 100% 100%);
            display: block;
        }

        .invest-modal .btn-outline--base:hover,
        .invest-modal .btn-outline--base:focus .invest-modal .btn-outline--base:focus-visible {
            background-color: hsl(var(--base) / 0.05) !important;
            border: 1px solid hsl(var(--base)) !important;
            color: hsl(var(--base)) !important;
        }

        .invest-modal .selected-gateway {
            border-color: hsl(var(--base)/0.32) !important;
        }

        .preview-details {
            font-size: 0.875rem;
        }
    </style>
@endpush
