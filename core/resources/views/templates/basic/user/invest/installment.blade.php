@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <h6 class="page-title">@lang('Property: ') {{ __(@$invest->property->title) }}</h6>
        <p class="mt-2 page-title-note">@lang('Per installment amount'): {{ showAmount(@$invest->per_installment_amount) }}
            {{ __($general->cur_text) }}
        </p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (count($invest->installments) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Installment Date')</th>
                                <th>@lang('Paid Date')</th>
                                <th>@lang('Late Fee')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invest->installments as $key => $installment)
                                @php
                                    $disabled = '';
                                    if (
                                        $installment->status == Status::INSTALLMENT_SUCCESS ||
                                        @$invest->installments[$key - 1]->status == Status::INSTALLMENT_PENDING
                                    ) {
                                        $disabled = 'disabled';
                                        if ($key == 0 && $invest->installments[$key]->status == Status::INSTALLMENT_PENDING) {
                                            $disabled = '';
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <div>
                                            {{ showDateTime($installment->next_time, 'Y-m-d') }}<br>
                                            <span class="small">{{ diffForHumans($installment->next_time) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if ($installment->paid_time)
                                                {{ showDateTime($installment->paid_time, 'Y-m-d') }}<br>
                                                <span class="small">{{ diffForHumans($installment->paid_time) }}</span>
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $general->cur_sym }}{{ showAmount($installment->late_fee) }}</td>
                                    <td>
                                        @if ($installment->status == Status::INSTALLMENT_SUCCESS)
                                            <span class="badge badge--success">@lang('Completed')</span>
                                        @else
                                            <span class="badge badge--warning">@lang('Due')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="action--btn btn btn-outline--primary {{ $disabled }}" id="installmentBtn"
                                            data-action="{{ route('user.invest.installment.pay', [encrypt($invest->id), encrypt($installment->id)]) }}"
                                            data-installment="{{ $installment }}" title="Pay Installment">
                                            <i class="las la-coins"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'No investment found!'])
            @endif
        </div>
    </div>
    
    @include($activeTemplate . 'partials.installment_modal')
    
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            
            $(document).on('click', '#installmentBtn', function() {
                let action = $(this).data().action;
                let installment = $(this).data().installment;
                var modal = $('#installmentModal');
                modal.find('input[name="installment_amount"]').val((
                        {{ getAmount(@$invest->per_installment_amount) }} + parseInt(installment.late_fee))
                    .toFixed(2));
                if (installment.late_fee > 0) {
                    modal.find('.lateFeeWarning').addClass('d-block');
                    modal.find('.lateFeeWarning').removeClass('d-none');
                }
                modal.find('form').attr('action', action);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
