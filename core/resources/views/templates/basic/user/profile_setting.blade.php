@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row dashboard-widget-wrapper justify-content-center">
        <div class="col-md-12">
            <form class="register" action="" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row justify-content-center mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-center profile__image_content">
                            <div class="profile_image" id='profile-thumb-show'
                                style="background-image: url({{ getImage(getFilePath('userProfile') . '/' . $user->avatar, getFileSize('userProfile')) }})">
                            </div>
                            <label for="profileImage" class="profile-edit-icon"><i class="las la-pen"></i></label>
                            <input id="profileImage" type="file" class="form--control d-none" name="avatar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('First Name')</label>
                        <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}"
                            required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Last Name')</label>
                        <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('E-mail Address')</label>
                        <input class="form--control" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Mobile Number')</label>
                        <input class="form--control" value="{{ $user->mobile }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('Address')</label>
                        <input type="text" class="form--control" name="address" value="{{ @$user->address->address }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="form--label">@lang('State')</label>
                        <input type="text" class="form--control" name="state" value="{{ @$user->address->state }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label class="form--label">@lang('Zip Code')</label>
                        <input type="text" class="form--control" name="zip" value="{{ @$user->address->zip }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form--label">@lang('City')</label>
                        <input type="text" class="form--control" name="city" value="{{ @$user->address->city }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form--label">@lang('Country')</label>
                        <input class="form--control" value="{{ @$user->address->country }}" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn--base w-100 mt-2">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            function readURL(input) {
                if (!input.files && !input.files[0]) return;
                const imageUrl = URL.createObjectURL(input.files[0]);
                $('#profile-thumb-show').css('background-image', 'url(' + imageUrl + ')');
                $('#profile-thumb-show').hide();
                $('#profile-thumb-show').fadeIn(550);
            }

            $("#profileImage").change(function() {
                readURL(this);
            });
        })(jQuery);
    </script>
@endpush
