@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <form action="{{ route('user.transfer.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form--label">@lang('Amount')</label>
                    <div class="input-group">
                        <input class="form-control form--control" name="amount" type="number" value="{{ old('amount') }}"
                            step="any" autocomplete="off" required>
                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form--label">@lang('@Username')</label>
                    <div class="input-group">
                        <input class="form-control form--control" name="username" type="text" value=""
                            autocomplete="off" required>
                    </div>
                </div>
                <button class="btn btn--base w-100 mt-3" type="submit">@lang('Transfer Now')</button>
            </form>
        </div>
    </div>
@endsection