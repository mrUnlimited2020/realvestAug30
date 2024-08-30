@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="text-center mt-2">@lang('You have requested')
                            <b class="text--success">{{ showAmount($data['amount']) }} {{ __($general->cur_text) }}</b> ,
                            @lang('Please pay')
                            <b class="text--success">{{ showAmount($data['final_amount']) . ' ' . $data['method_currency'] }}
                            </b>
                            @lang('for successful payment')
                        </p>
                        <h4 class="mb-3">@lang('Please follow the instruction below')</h4>
                        @php echo  $data->gateway->description @endphp
                    </div>
                    <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}"/>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
