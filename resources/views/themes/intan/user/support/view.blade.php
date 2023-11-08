@extends($theme.'layouts.user')
@section('title',trans($page_title))

@push('pagetitle')
<li class="flex-grow-0">
    <div class="group inline-flex rounded-t-lg h-full items-center">
        {{trans($page_title)}}
    </div>
</li>
@endpush

@section('content')
<section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32">
    <div class="flex-1 p-4 flex flex-col bg-gray-800 rounded-lg">
        <div class="flex sm:items-center justify-between pb-3 border-b border-gray-600">
            <div class="relative flex items-center space-x-4">
                <div class="flex flex-col leading-tight">
                    <div class="text-sm mt-1 flex-col items-start">
                        <span class="text-gray-100 mr-3">
                            {{trans('Ticket#'). $ticket->ticket }}
                            <br />
                            <span>{{ $ticket->subject }}</span>
                            <br />
                            Status:
                            @if($ticket->status == 0)
                            <span class="font-bold text-green-500">@lang('Open')</span>
                            @elseif($ticket->status == 1)
                            <span class="font-bold text-blue-500">@lang('Answered')</span>
                            @elseif($ticket->status == 2)
                            <span class="font-bold text-yellow-500">@lang('Replied')</span>
                            @elseif($ticket->status == 3)
                            <span class="font-bold text-red-500">@lang('Closed')</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <button type="button" onclick="openModal('#closeTicketModal')" class="inline-flex items-center justify-center rounded-lg bg-red-500 px-3 py-1.5 text-center text-sm font-medium text-white focus:outline-none">
                    <i class="fa-regular fa-close h-4 w-4 mr-1"></i>
                    <span>Close</span>
                </button>
            </div>
        </div>

        <div class="border-b border-gray-600 py-4">
            <form action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="md:flex-col sm:flex-row space-x-4 space-y-4">
                    <div>
                        <textarea name="message" placeholder="Write your message!" rows="4" class="block w-full rounded-lg border p-2.5 text-sm focus:border-pirategold-400 focus:ring-pirategold-400 border-gray-700 bg-gray-900 text-gray-300 placeholder-gray-400 focus:outline-none" required>{{old('message')}}</textarea>
                        @error('message')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="file" name="attachments[]" id="file" multiple style="display: none;">

                    <div class="flex items-center justify-center space-x-2">

                        <button type="button" onclick="javascript:document.querySelector('input#file').click()" class="inline-flex items-center justify-center px-3 py-1.5 text-center text-sm font-medium text-white">
                            <i class="fa-regular fa-image h-6 w-6 text-gray-200"></i>
                        </button>

                        <button type="submit" name="replayTicket" value="1" class="inline-flex items-center justify-center rounded-lg bg-pirategold-500 px-3 py-1.5 text-center text-sm font-medium text-white focus:outline-none">
                            <span class="font-bold">{{trans('Reply')}}</span>
                            <span><i class="fa-regular fa-paper-plane h-4 w-4 ml-2"></i></span>
                        </button>

                    </div>
                </div>
            </form>
        </div>

        <div id="messages" class="flex flex-col space-y-5 pt-7 overflow-y-auto">
            @if(count($ticket->messages) > 0)
                @foreach($ticket->messages as $item)
                    @if($item->admin_id == null)
                    <div class="chat-message">
                        <div class="flex items-start justify-end">
                            <div class="flex flex-col text-sm max-w-xs mx-2 order-1 items-end">
                                <div>
                                    <span class="px-4 py-2 rounded-lg inline-block bg-pirategold-500 text-white">{{$item->message}}</span>
                                </div>
                                <div>
                                    @if(0 < count($item->attachments))
                                        <div class="flex flex-wrap justify-end mt-1">
                                            @foreach($item->attachments as $k=> $image)
                                                <a href="{{route('user.ticket.download',encrypt($image->id))}}" class="text-pirategold-500 ml-3"><i class="fa-regular fa-file"></i> @lang('File') {{++$k}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-white block" style="font-size: 10px;">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
                                </div>
                            </div>
                            <img src="{{getFile(config('location.user.path').optional($ticket->user)->image)}}" alt="user" class="w-6 h-6 rounded-full order-2">
                        </div>
                    </div>
                    @else
                    <div class="chat-message">
                        <div class="flex items-start">
                            <div class="flex flex-col space-y-2 text-sm max-w-xs mx-2 order-2 items-start">
                                <div>
                                    <span class="px-4 py-2 rounded-lg inline-block bg-gray-600 text-white">{{$item->message}}</span>
                                </div>
                                <div>
                                    @if(0 < count($item->attachments))
                                        <div class="flex flex-wrap justify-end mt-1">
                                            @foreach($item->attachments as $k=> $image)
                                                <a href="{{route('user.ticket.download',encrypt($image->id))}}" class="text-600-500 ml-3"><i class="fa-regular fa-file"></i> @lang('File') {{++$k}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-white block" style="font-size: 10px;">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
                                </div>
                                {{-- <div>
                                    <span class="px-4 py-2 rounded-lg inline-block bg-gray-600 text-gray-50">{{$item->message}}</span>
                                    <span class="text-white block my-1" style="font-size: 10px;">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
                                </div> --}}
                            </div>
                            <img src="{{getFile(config('location.admin.path').optional($item->admin)->image)}}" alt="My profile" class="w-6 h-6 rounded-full order-1">
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>


@push('loadModal')
<!-- Main modal -->
<div id="closeTicketModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto mt-10">
        <!-- Modal content -->
        <div class="relative rounded-lg shadow-lg bg-gray-800">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-4 rounded-t border-b border-gray-700">
                <h5 class="text-md text-white">@lang('Confirmation')</h5>
                <button type="button" class="text-gray-500 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="closeModal('#closeTicketModal')">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-2">
                <form method="post" action="{{ route('user.ticket.reply', $ticket->id) }}">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-2 block text-md font-medium text-gray-300">@lang('Are you want to close ticket?')</h5>
                    <div>
                        <button type="submit" name="replayTicket" value="2" class="rounded-lg bg-pirategold-500 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none">@lang("Confirm")</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endpush


@endsection


@push('script')
<script>
    'use strict';
    $(document).on('change', '#upload', function() {
        var fileCount = $(this)[0].files.length;
        $('.select-files-count').text(fileCount + ' file(s) selected')
    })

</script>
@endpush
