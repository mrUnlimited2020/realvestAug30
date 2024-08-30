@extends($activeTemplate . 'layouts.frontend')

@section('content')
    <section class="account">
        <div class="account-inner py-120 bg-pattern3">
            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <form method="POST" action="{{ route('user.data.submit') }}" class="account-form">
                            @csrf
                            <div class="account-form__body">
                                <div class="alert alert-primary mb-4" role="alert">
                                    <strong>
                                        @lang('Complete your profile')
                                    </strong>
                                    <p>@lang('You need to complete your profile by providing below information.')</p>
                                </div>
                                <div class="row">
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('First Name')</label>
                                            <input class="form--control" type="text" name="firstname" value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Last Name')</label>
                                            <input class="form--control" type="text" name="lastname" value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('Address')</label>
                                            <input type="text" class="form--control" name="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('State')</label>
                                            <input type="text" class="form--control" name="state" value="{{ old('state') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="your-password" class="form--label">@lang('Zip Code')</label>
                                            <input class="form--control" type="text" name="zip" value="{{ old('zip') }}">
                                        </div>
                                    </div>
                                    <div class="col-xsm-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="form--label">@lang('City')</label>
                                            <input class="form--control" type="text" name="city" value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="w-100 btn btn--base">@lang('Submit')</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
