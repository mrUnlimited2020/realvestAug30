@extends($activeTemplate . 'layouts.frontend')
@section('content')
<div class="account-inner pb-120 pt-60  bg-pattern3 cookie">
    <div class="container ">
        <div class="row">
            <div class="col-sm-12">
                <div class="pb-60">
                    @php echo @$cookie->data_values->description; @endphp
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection



@push('style')
    <style>
        @media only screen and (max-width: 1199px) {
            .cookie .pb-60 {
                padding-bottom:0px !important; 
            }
            .cookie.pb-120 {
                padding-bottom:60px !important; 
            }
        }
    </style>
@endpush
