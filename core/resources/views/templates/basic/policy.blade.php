@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pb-120 pt-60 bg-pattern3 policy">
        <div class="container ">
            <div class="row justify-content-sm-center">
                <div class="col-sm-12">
                    <div class="pb-60">
                        @php echo $policy->data_values->details; @endphp
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        @media only screen and (max-width: 1199px) {
            .policy .pb-60 {
                padding-bottom:0px !important; 
            }
            .policy.pb-120 {
                padding-bottom:60px !important; 
            }
        }
    </style>
@endpush
