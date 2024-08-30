@extends($activeTemplate . 'layouts.' . $layout)
@php
    $label = 'form--label';
    $formControl = '';
@endphp
@section('content')
    @if ($layout == 'frontend')
        <section class="account">
            <div class="account-inner py-120 bg-pattern3">
                <div class="container ">
    @endif
    <div class="row @if ($layout == 'master') dashboard-widget-wrapper @endif justify-content-center">
        <div class="col-md-12">
            @if ($layout == 'frontend')
                <div class="account-form">
            @endif
            <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                @csrf
                @if ($layout == 'frontend')
                    <div class="account-form__header">
                    @else
                        <div class="d-flex justify-content-between align-items-center mb-4">
                @endif
                <h6 class="@if ($layout == 'master') m-0 @endif">
                    @php echo $myTicket->statusBadge; @endphp [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                </h6>
                @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                    <button class="btn btn--danger close-button action--btn confirmationBtn" type="button">
                        <i class="la la-times"></i>
                    </button>
                @endif
        </div>
        @if ($layout == 'frontend')
            <div class="account-form__body">
        @endif
        <div class="form-group">
            <textarea name="message" class="form--control" rows="4">{{ old('message') }}</textarea>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn--base addFile btn--sm">
                <i class="la la-plus"></i>
                @lang('Add New')
            </button>
        </div>
        <div class="form-group">
            <label class="form--label">@lang('Attachments')</label>
            <small class="text--danger">@lang('Max 5 files can be uploaded').
                @lang('Maximum upload size is')
                {{ ini_get('upload_max_filesize') }}
            </small>
            <input type="file" name="attachments[]" class="form--control" />
            <div id="fileUploadsContainer"></div>
            <p class="my-2 ticket-attachments-message text-muted">
                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'),
                .@lang('png'),
                .@lang('pdf'), .@lang('doc'), .@lang('docx')
            </p>
        </div>
        @if (!auth()->check())
            <x-captcha :label="$label" :formControl="$formControl" />
        @endif
        <div class="form-group mb-0">
            <button type="submit" class="w-100 btn btn--base">
                <i class="fa fa-reply"></i>
                @lang('Reply')
            </button>
        </div>
        @if ($layout == 'frontend')
    </div>
    @endif
    </form>
    @if ($layout == 'frontend')
        </div>
    @endif


    @if ($layout == 'frontend')
        <div class="account-form mt-4">
            <div class="account-form__body">
    @endif
    @foreach ($messages as $message)
        @if ($message->admin_id == 0)
            <div class="support-ticket">
                <div class="flex-align gap-3 mb-2">
                    <h6 class="support-ticket-name">{{ $message->ticket->name }}</h6>
                    <p class="support-ticket-date"> @lang('Posted on')
                        {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                </div>

                <p class="support-ticket-message">{{ $message->message }}</p>

                @if ($message->attachments->count() > 0)
                    <div class="support-ticket-file mt-2">
                        @foreach ($message->attachments as $k => $image)
                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"> <span class="icon"><i
                                        class="la la-file-download"></i></span> @lang('Attachment')
                                {{ ++$k }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="support-ticket reply">
                <div class="flex-align gap-3 mb-2">
                    <h6 class="support-ticket-name">{{ $message->admin->name }} <span class="staff">@lang('Staff')</span></h6>
                    <p class="support-ticket-date"> @lang('Posted on')
                        {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                </div>

                <p class="support-ticket-message">{{ $message->message }}</p>

                @if ($message->attachments->count() > 0)
                    <div class="support-ticket-file mt-2">
                        @foreach ($message->attachments as $k => $image)
                            <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3"> <span class="icon"><i
                                        class="la la-file-download"></i></span> @lang('Attachment')
                                {{ ++$k }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    @endforeach

    @if ($layout == 'frontend')
        </div>
        </div>
    @endif
    </div>
    </div>
    @if ($layout == 'frontend')
        </div>
        </div>
        </section>
    @endif

    <div class="modal fade custom--modal" id="confirmationModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button class="close-btn" type="button" data-bs-dismiss="modal">
                        <i class="las fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('ticket.close', $myTicket->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-form__header">
                            <h6 class="modal-form__title">@lang('Are you sure to close this ticket?')</h6>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal">@lang('No')</button>
                            <button class="btn btn--base btn--sm">@lang('Yes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group input-with-text my-3">
                        <input type="file" name="attachments[]" class="form--control" required />
                        <button type="submit" class="input-group-text btn--danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });

            $('.confirmationBtn').on('click', function() {
                let modal = $('#confirmationModal');
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
