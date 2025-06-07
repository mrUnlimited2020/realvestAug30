@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <form id="convert-form" action="{{ route('user.convert.process') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form--label">@lang('Amount')</label>
                    <div class="input-group">
                        <input class="form-control form--control" name="amount" type="number" value="{{ old('amount') }}"
                            step="any" autocomplete="off" required>
                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                    </div>
                </div>
                <button class="btn btn--base w-100 mt-3" type="submit">@lang('Convert')</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#convert-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission
                // Simulate form submission and processing
                setTimeout(function () {
                    $('#convert-form').off('submit').submit(); // Submit the form after 5 seconds
                }, 2000); // 2 seconds delay
            });
        });
    </script>
@endpush