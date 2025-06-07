@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                    placeholder="@lang('Search by product in your stock')">
                <button class="btn--base btn" type="submit">
                    <span class="icon"><i class="la la-search"></i></span>
                </button>
            </div>
        </form>
    </div>
    <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-lg-12 ">
            @if(count($orders ?? []) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Products')</th>
                                <th class="text-center">@lang('Total Stock')</th>
                                <th class="text-center">@lang('Sold Stock')</th>
                                <th class="text-center">@lang('Others..')</th>
                                <th class="text-center">@lang('Others..')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'Stocks are being addedd!'])
            @endif
        </div>
    </div>

    <div class="modal fade custom--modal" id="detailModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('order Details')</h5>
                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <div class="modal-body text-end">
                    <div class="modal-form__header">
                        <ul class="list-group list-group-flush userData mb-2"></ul>
                        <div class="feedback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection