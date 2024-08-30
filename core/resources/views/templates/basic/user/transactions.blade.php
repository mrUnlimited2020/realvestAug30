@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 responsive-filter-card">
        <form action="">
            <div class="d-flex flex-wrap gap-4">
                <div class="flex-grow-1">
                    <label class="form--label">@lang('Transaction Number')</label>
                    <input type="text" name="search" value="{{ request()->search }}" class="form--control">
                </div>
                <div class="flex-grow-1">
                    <label class="form--label">@lang('Type')</label>
                    <select name="trx_type" class="form--control">
                        <option value="">@lang('All')</option>
                        <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                        <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                    </select>
                </div>
                <div class="flex-grow-1">
                    <label class="form--label">@lang('Remark')</label>
                    <select class="form--control" name="remark">
                        <option value="">@lang('Any')</option>
                        @foreach ($remarks as $remark)
                            <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                {{ __(keyToTitle($remark->remark)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-grow-1 align-self-end">
                    <button class="btn btn--base btn--md w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (count($transactions) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Trx')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td>
                                        <strong>{{ $trx->trx }}</strong>
                                    </td>
                                    <td class="budget">
                                        <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ __($general->cur_text) }}
                                        </span>
                                    </td>
                                    <td class="budget">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </td>
                                    <td>
                                        <button class="action--btn btn btn-outline--base detailBtn" data-transaction="{{ $trx }}"
                                            data-transacted="{{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}">
                                            <i class="las la-desktop"></i>
                                        </button>
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
                @if ($transactions->hasPages())
                    {{ $transactions->links() }}
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Transactions not found!'])
            @endif
        </div>
    </div>
    <div class="modal fade custom--modal" id="detailModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Transaction Details')</h5>
                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-form__header">
                        <ul class="list-group list-group-flush userData mb-2"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb')
    <div class="show-filter mb-4 text-end">
        <button type="button" class="btn btn--base showFilterBtn btn-sm">
            <i class="las la-filter"></i>
        </button>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var transaction = $(this).data('transaction');
                var transacted = $(this).data('transacted');
                var curText = '{{ __($general->cur_text) }}';
                var curSymbol = '{{ $general->cur_sym }}';
                var classVariable = 'text--danger';
                if (transaction.trx_type == '+') {
                    classVariable = 'text--success'
                }
                console.log(transaction);
                var html = '';
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Trx')</span>
                            <span class="list--group-desc text--base"><strong>${transaction.trx}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Transacted')</span>
                            <span class="list--group-desc text-end">${transacted}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                            <span class="list--group-text">@lang('Amount')</span>
                            <span class="list--group-desc ${classVariable}"><strong>${transaction.trx_type} ${Number(transaction.amount).toFixed(2)}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                            <span class="list--group-text">@lang('Post Balance')</span>
                            <span class="list--group-desc">${curSymbol}${Number(transaction.post_balance).toFixed(2)}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center text-end">
                            <span class="list--group-text">@lang('Details')</span>
                            <span class="list--group-desc">${transaction.details}</span>
                        </li>`;

                modal.find('.userData').html(html);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
