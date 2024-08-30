@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="flex-end mb-4 breadcrumb-dashboard">
        <form action="">
            <div class="input-group">
                <input type="text" name="search" class="form--control" value="{{ request()->search }}"
                    placeholder="@lang('Search ...')">
                <button class="btn--base btn" type="submit">
                    <span class="icon"><i class="la la-search"></i></span>
                </button>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (count($profits) > 0)
                <div class="table-responsive table--responsive--xl">
                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Property')</th>
                                <th>@lang('Investment Id')</th>
                                <th>@lang('TRX')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(@$profits as $profit)
                                <tr>
                                    <td>{{ __($profit->property->title) }}</td>
                                    <td>{{ $profit->invest->investment_id }}</td>
                                    <td>{{ @$profit->transaction->trx }}</td>
                                    <td>{{ $general->cur_sym }}{{ showAmount(@$profit->amount) }}</td>
                                    <td>
                                        <div>
                                            {{ showDateTime(@$profit->updated_at) }}<br>
                                            <span class="small">{{ diffForHumans($profit->updated_at) }}</span>
                                        </div>
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
                @if ($profits->hasPages())
                    {{ $profits->links() }}
                @endif
            @else
                @include($activeTemplate . 'partials.empty', ['message' => 'No investment found!'])
            @endif
        </div>
    </div>
@endsection
