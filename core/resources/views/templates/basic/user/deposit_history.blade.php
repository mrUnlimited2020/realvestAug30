@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                    placeholder="@lang('Search by transactions')">
                <button class="btn--base btn" type="submit">
                    <span class="icon"><i class="la la-search"></i></span>
                </button>
            </div>
        </form>
    </div>
    <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-md-12">
            @if (count($deposits) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Transaction')</th>
                                <th class="text-center">@lang('Initiated')</th>
                                <th class="text-center">@lang('Amount')</th>
                                <th class="text-center">@lang('Status')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deposits as $deposit)
                                <tr>
                                    <td>
                                        <span class="fw-bold">
                                            <span class="text--base">{{ $deposit->trx }}</span>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                    </td>
                                    <td class="text-center">
                                        <span>
                                            {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span
                                                class="text-danger"
                                                title="@lang('charge')">{{ showAmount($deposit->charge) }}
                                            </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }}
                                                {{ __($general->cur_text) }}
                                            </strong>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php echo $deposit->statusBadge @endphp
                                    </td>
                                    @php
                                        $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <td>
                                        <button class="action--btn btn btn-outline--base detailBtn"
                                            data-deposit="{{ $deposit }}"
                                            @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                            @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                            <i class="las la-desktop"></i>
                                        </button>
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
                @if ($deposits->hasPages())
                    {{ $deposits->links() }}
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Deposit not found!'])
            @endif
        </div>
    </div>

    <div class="modal fade custom--modal" id="detailModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Deposit Details')</h5>
                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-form__header">
                        <ul class="list-group userData mb-2 list-group-flush"></ul>
                        <div class="feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var deposit = $(this).data('deposit');
                var curText = '{{ __($general->cur_text) }}';
                var curSymbol = '{{ $general->cur_sym }}';
                var userData = $(this).data('info');
                var html = '';
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="list--group-text">@lang('Gateway')</span>
                                <span class="list--group-desc"><strong>${deposit.gateway.name}</strong></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="list--group-text">@lang('Trx')</span>
                                <span class="text--base list--group-desc"><strong>${deposit.trx}</strong></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                                <span class="list--group-text">@lang('Amount')</span>
                                <span class="list--group-desc">${curSymbol}${Number(deposit.amount).toFixed(2)}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                                <span class="list--group-text">@lang('Charge')</span>
                                <span class="list--group-desc">${curSymbol}${Number(deposit.charge).toFixed(2)}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                                <span class="list--group-text">@lang('Total Amount')</span>
                                <span class="list--group-desc"><strong>${curSymbol}${(Number(deposit.charge) + Number(deposit.amount)).toFixed(2)}</strong></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                                <span class="list--group-text">@lang('Conversion')</span>
                                <span class="list--group-desc">1 ${curText} = ${Number(deposit.rate).toFixed(2)} ${deposit.method_currency}<br><strong>${curSymbol}${Number(deposit.amount).toFixed(2)}</strong></span>
                            </li>`;

                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="list--group-text">${element.name}</span>
                                <span class="list--group-desc">${element.value}</span>
                            </li>`;
                        }
                    });
                }
                modal.find('.userData').html(html);
                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `<ul class="list-group">
                            <li class="list-group-item">
                                <div class="my-3 text-start">
                                    <strong>@lang('Admin Feedback')</strong>
                                    <p>${$(this).data('admin_feedback')}</p>
                                </div>
                            </li>
                        </ul>`;
                } else {
                    var adminFeedback = '';
                }
                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
