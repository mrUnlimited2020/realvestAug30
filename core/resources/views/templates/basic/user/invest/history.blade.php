@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                    placeholder="@lang('Property name')">
                <button class="btn--base btn" type="submit">
                    <span class="icon"><i class="la la-search"></i></span>
                </button>
            </div>
        </form>
    </div>
    <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-md-12">
            @if (count($invests) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Property')</th>
                                <th>@lang('Invested Amount')</th>
                                <th>@lang('Due Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invests as $invest)
                                <tr>
                                    <td>
                                        <a
                                            href="{{ route('property.details', [slug(@$invest->property->title), @$invest->property->id]) }}">
                                            <strong>{{ strLimit($invest->property->title, 25) }}</strong>
                                        </a>
                                    </td>
                                    <td><strong>{{ $general->cur_sym . showAmount($invest->total_invest_amount) }}</strong>
                                    </td>
                                    <td><strong>{{ $general->cur_sym . showAmount($invest->due_amount) }}</strong></td>
                                    <td>@php echo $invest->investStatusBadge @endphp</td>
                                    <td>
                                        <div class="button--group">
                                            @php
                                                if ($invest->profit_status == Status::COMPLETED) {
                                                    $invest->badge_text =
                                                        '<span class="badge badge--success">' .
                                                        trans('Completed') .
                                                        '</span>';
                                                } elseif ($invest->profit_status == Status::RUNNING) {
                                                    $invest->badge_text = showDateTime(
                                                        $invest->next_profit_date,
                                                        'Y-m-d',
                                                    );
                                                } else {
                                                    $invest->badge_text =
                                                        '<span class="badge badge--warning">' .
                                                        trans('Investment Running') .
                                                        '</span>';
                                                }
                                            @endphp
                                            @if (count($invest->installments) > 0)
                                                <a href="{{ route('user.invest.installment.details', encrypt($invest->id)) }}"
                                                    class="btn btn-outline--info action--btn" title="Installment Details">
                                                    <i class="las la-file-invoice-dollar"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-outline--base action--btn detailBtn"
                                                data-invest="{{ $invest }}" title="Invest Details">
                                                <i class="las la-desktop"></i>
                                            </button>
                                        </div>
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
                @if ($invests->hasPages())
                    {{ $invests->links() }}
                @endif
            @else
                <div class="text-center">
                    @include($activeTemplate . 'partials.empty', ['message' => 'No investment found!'])
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade custom--modal" id="detailModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Investment Details')</h5>
                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-form__header">
                        <ul class="list-group userData mb-2 list-group-flush"></ul>
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
                let modal = $('#detailModal');
                let invest = $(this).data('invest');
                let curSymbol = '{{ $general->cur_sym }}';
                let html = '';
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Property')</span>
                            <span class="list--group-desc"><strong>${invest.property.title}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Total Invest Amount')</span>
                            <span class="list--group-desc"><strong>${curSymbol}${Number(invest.total_invest_amount).toFixed(2)}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Paid Amount')</span>
                            <span class="list--group-desc">${curSymbol}${Number(invest.paid_amount).toFixed(2)}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Due Amount')</span>
                            <span class="list--group-desc">${curSymbol}${Number(invest.due_amount).toFixed(2)}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Per Installment Amount')</span>
                            <span class="list--group-desc">${curSymbol}${Number(invest.per_installment_amount).toFixed(2)}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Next Installment Date')</span>
                            <span class="list--group-desc">${invest.invest_status == 1 ?  formatTime(new Date(invest.installments[0].next_time)) : '<span class="badge badge--success">@lang('Completed')</span>'}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Total Profit')</span>
                            <span class="list--group-desc"><strong>${curSymbol}${Number(invest.total_profit).toFixed(2)}</strong></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Next Profit Date')</span>
                            <span class="list--group-desc">${invest.badge_text}</span>
                        </li>`;

                modal.find('.userData').html(html);
                modal.modal('show');
            });

            function formatTime(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }
        })(jQuery);
    </script>
@endpush
