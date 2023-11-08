@extends($theme.'layouts.user')
@section('title',__($page_title))

@push('pagetitle')
<li class="flex-grow-0">
    <div class="group inline-flex rounded-t-lg h-full items-center">
        {{trans($page_title)}}
    </div>
</li>
@endpush

@section('content')
<section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32">
    <div class="pb-4 text-right">
        <a href="{{route('user.ticket.create')}}" class="w-full rounded-lg bg-pirategold-500 px-3 py-1.5 text-center text-sm font-medium text-white focus:outline-none"> <i class="fa fa-plus-circle"></i> @lang('Create Ticket')</a>
    </div>
    <div class="pb-4">
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-left bg-gray-700 text-gray-400 border-collapse border-none">
                <thead class="text-xs bg-gray-700 text-gray-400">
                    <tr class="border-0">
                        <th class="px-2 py-2 border-0">@lang('Subject')</th>
                        <th class="px-2 py-2 border-0">@lang('Status')</th>
                        <th class="px-2 py-2 border-0">@lang('Last Reply')</th>
                        <th class="px-2 py-2 border-0">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @forelse($tickets as $key => $ticket)
                    <tr class="text-xs border-b bg-gray-800 border-gray-700">
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                            [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }}
                        </td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                            @if($ticket->status == 0)
                                <span class="font-bold text-green-500">@lang('Open')</span>
                            @elseif($ticket->status == 1)
                                <span class="font-bold text-blue-500">@lang('Answered')</span>
                            @elseif($ticket->status == 2)
                                <span class="font-bold text-yellow-500">@lang('Replied')</span>
                            @elseif($ticket->status == 3)
                                <span class="font-bold text-red-500">@lang('Closed')</span>
                            @endif
                        </td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                            {{diffForHumans($ticket->last_reply) }}
                        </td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                            <a href="{{ route('user.ticket.view', $ticket->ticket) }}" class="w-full rounded-lg bg-pirategold-500 px-2 py-1 text-center text-sm font-medium text-white focus:outline-none">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-xs text-center">
                        <td colspan="100%" class="px-2 py-8 text-white whitespace-nowrap">
                            <div class="flex justify-center items-center text-center">
                                <i class="fa-regular fa-triangle-exclamation h-5 w-5 px-3"></i>
                                <span class="text-lg">{{trans('No Data Found!')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>


@endsection
