@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}" placeholder="@lang('Search by order no.')">
                <button class="btn--base btn" type="submit">
                    <span class="icon"><i class="la la-search"></i></span>
                </button>
            </div>
        </form>
    </div>

    <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-lg-12">
            @if(count($orders ?? []) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Product')</th>
                                <th class="text-center">@lang('Amount')</th>
                                <th class="text-center">@lang('Buyer')</th>
                                <th class="text-center">@lang('Order No.')</th>
                                <th>@lang('Full Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <!-- Product column -->
                                    <td><strong>{{ strLimit($order->property_title, 25) }}</strong></td>
                                    <!-- Amount column -->
                                    <td><strong>{{ $general->cur_sym . showAmount($order->total_invest_amount) }}</strong></td>
                                    <!-- Buyer column -->
                                    <td><strong>{{ $order->buyer_name }}</strong></td>
                                    <!-- OrderNo column -->
                                    <td>
                                        <span class="fw-bold">
                                            <span class="text--base">{{ $order->investment_id }}</span>
                                        </span>
                                    </td>
                                    <!-- Action column -->
                                    <td>
                                        <button class="action--btn btn btn-outline--base detailBtn" 
                                        data-order="{{ $order }}" 
                                        data-transacted="{{ showDateTime($order->created_at) }} <br>
                                                        {{ diffForHumans($order->created_at) }}"
                                        title="Order Details">
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
                @if ($orders->hasPages())
                    {{ $orders->links() }}
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Orders not found!'])
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade custom--modal" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">@lang('Full Details')</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData mb-2"></ul>
                    <div class="feedback"></div>
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
            let order = $(this).data('order');
            let transacted = $(this).data('transacted');
            let curSymbol = '{{ $general->cur_sym }}';
            let html = '';
            html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list--group-text">@lang('Product')</span>
                        <span class="list--group-desc"><strong>${order.property_title}</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list--group-text">@lang('Amount')</span>
                        <span class="list--group-desc"><strong>${curSymbol}${Number(order.total_invest_amount).toFixed(2)}</strong></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list--group-text">@lang('Buyer')</span>
                        <span class="list--group-desc">${String(order.buyer_name)}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="list--group-text">@lang('Order No.')</span>
                        <span class="list--group-desc">${order.investment_id}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list--group-text">@lang('Transacted')</span>
                            <span class="list--group-desc text-end">${transacted}</span>
                        </li>`;

            modal.find('.userData').html(html);
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
