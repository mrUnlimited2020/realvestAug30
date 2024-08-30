@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    @if (request()->routeIs('admin.invest.profit'))
                                        <th>@lang('User')</th>
                                    @endif
                                    <th>@lang('Property')</th>
                                    @if (request()->routeIs('admin.invest.profit'))
                                        <th>@lang('Invest Id')</th>
                                        <th>@lang('Invest Amount')</th>
                                        <th>@lang('TRX')</th>
                                    @endif
                                    <th>@lang('Profit Amount')</th>
                                    <th>@lang('Paid Date')</th>
                                    @if (!request()->routeIs('admin.invest.profit'))
                                        <th>@lang('Total Investor')</th>
                                        <th>@lang('Action')</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(@$profitList as $profit)
                                    <tr>
                                        @if (request()->routeIs('admin.invest.profit'))
                                            <td>
                                                <span class="fw-bold">{{ $profit->user->fullname }}</span><br>
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $profit->user->id) }}">
                                                        <span>@</span>{{ $profit->user->username }}
                                                    </a>
                                                </span>
                                            </td>
                                        @endif
                                        <td><span class="fw-bold">{{ $profit->invest->property->title }}</span></td>
                                        @if (request()->routeIs('admin.invest.profit'))
                                            <td><span class="fw-bold">{{ $profit->invest->investment_id }}</span></td>
                                            <td>
                                                <span class="fw-bold">
                                                    {{ $general->cur_sym . showAmount($profit->invest->total_invest_amount) }}
                                                </span>
                                            </td>
                                            <td>{{ $profit->transaction->trx }}</td>
                                        @endif
                                        <td>
                                            @if ($profit->amount > 0)
                                                {{ $general->cur_sym . showAmount($profit->amount) }}
                                            @else
                                                {{ $profit->property->getProfit }}
                                            @endif
                                        </td>
                                        <td>{{ showDateTime($profit->updated_at, 'Y-m-d') }}</td>

                                        @if (!request()->routeIs('admin.invest.profit'))
                                            <td>{{ $profit->total_investor }}</td>
                                            <td>
                                                <button class="btn btn-outline--primary btn--sm dischargeBtn"
                                                    data-action="{{ route('admin.invest.profit.discharge', $profit->property->id) }}"
                                                    data-profit="{{ $profit }}">
                                                    <i class="las la-money-bill-wave"></i> @lang('Discharge')
                                                </button>
                                            </td>
                                        @endif
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
                @if (@$profitList->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($profitList) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (!request()->routeIs('admin.invest.profit'))
        <div class="modal fade" id="dischargeModal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Discharge Investor Profit')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                    @lang('Property Name')
                                    <span class="fw-bold property_name"></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0">
                                    @lang('Profit Type')
                                    <span class="fw-bold profit_type"></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0 profitTypeFixed">
                                    @lang('Profit Amount')
                                    <span class="fw-bold profit_amount"></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0 profitTypeRange">
                                    @lang('Minimum Profit Amount')
                                    <span class="fw-bold minimum_profit_amount"></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0 profitTypeRange">
                                    @lang('Maximum Profit Amount')
                                    <span class="fw-bold maximum_profit_amount"></span>
                                </li>
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap ps-0 totalProfitAmount">
                                    @lang('Total Profit Amount')
                                    <span class="fw-bold total_profit_amount"></span>
                                </li>
                            </ul>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>@lang('New Profit Amount')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control"
                                                name="new_profit_amount" required>
                                            <span class="input-group-text profitAmountType"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search" />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.dischargeBtn').on('click', function() {
                let modal = $('#dischargeModal');
                let data = $(this).data();
                let property = data.profit.property;
                let profit = data.profit;
                let profitAmountType = '%';

                modal.find('form').attr('action', data.action);
                modal.find('.property_name').text(property.title);

                if (property.profit_amount_type == {{ Status::PROFIT_AMOUNT_TYPE_FIXED }}) {
                    profitAmountType = '{{ __($general->cur_text) }}';
                }
                modal.find('.profitAmountType').text(profitAmountType);

                if (property.profit_type == {{ Status::PROFIT_TYPE_FIXED }}) {
                    modal.find('.profit_type').text('Fixed');
                    $('.profitTypeFixed').removeClass('d-none');
                    $('.profitTypeRange').addClass('d-none');
                    modal.find('.profit_amount').html(Number(property.profit_amount) + ' ' + profitAmountType);
                    $('input[name=new_profit_amount]').val(Number(property.profit_amount))
                    $('.total_profit_amount').text(Number(property.profit_amount) * Number(profit.total_investor) + ' ' + profitAmountType)
                } else {
                    modal.find('.profit_type').text('Range');
                    $('.profitTypeFixed').addClass('d-none');
                    $('.profitTypeRange').removeClass('d-none');
                    modal.find('.maximum_profit_amount').html(Number(property.maximum_profit_amount) + ' ' +
                    profitAmountType);
                    modal.find('.minimum_profit_amount').html(Number(property.minimum_profit_amount) + ' ' +
                    profitAmountType);
                    $('.totalProfitAmount').addClass('d-none');
                }

                $('input[name=new_profit_amount]').on('input', function(){
                    $('.totalProfitAmount').removeClass('d-none');
                    let newProfitAmount = $('input[name=new_profit_amount]').val();
                    $('.total_profit_amount').text(Number(newProfitAmount) * Number(profit.total_investor) + ' ' + profitAmountType)
                });

                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
