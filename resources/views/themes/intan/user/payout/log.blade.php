@extends($theme.'layouts.user')
@section('title',trans($title))

@push('pagetitle')
<li class="flex-grow-0">
    <div class="group inline-flex rounded-t-lg h-full items-center">
        {{trans($title)}}
    </div>
</li>
@endpush

@section('content')
    <section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32">
        <div class="pb-4">
            <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-left bg-gray-700 text-gray-400 border-collapse border-none">
                <thead class="text-xs bg-gray-700 text-gray-400">
                <tr class="border-0">
                    <th class="px-2 py-2 border-0">@lang('Transaction ID')</th>
                    <th class="px-2 py-2 border-0">@lang('Gateway')</th>
                    <th class="px-2 py-2 border-0">@lang('Account')</th>
                    <th class="px-2 py-2 border-0">@lang('Amount')</th>
                    <th class="px-2 py-2 border-0">@lang('Charge')</th>
                    <th class="px-2 py-2 border-0">@lang('Status')</th>
                    <th class="px-2 py-2 border-0">@lang('Time')</th>
                    {{-- <th class="px-2 py-2 border-0">@lang('Detail')</th> --}}
                </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @forelse($payoutLog as $item)
                        <tr class="text-xs border-b bg-gray-800 border-gray-700">
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">{{$item->trx_id}}</td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">@lang(optional($item->method)->name)</td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">@lang(optional($item->account)->bank_name)</td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                <strong>{{getAmount($item->amount)}} @lang($basic->currency)</strong>
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                <strong>{{getAmount($item->charge)}} @lang($basic->currency)</strong>
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                @if($item->status == 1)
                                    <span class="text-white bg-yellow-500 bordered rounded p-1">@lang('Pending')</span>
                                @elseif($item->status == 2)
                                    <span class="text-white bg-green-500 bordered rounded p-1">@lang('Complete')</span>
                                @elseif($item->status == 3)
                                    <span class="text-white bg-red-500 bordered rounded p-1">@lang('Cancel')</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">{{ dateTime($item->created_at, 'd M Y h:i A') }}</td>
                            {{-- <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                <button type="button" class="infoButton rounded-lg bg-pirategold-500 px-3 py-1.5 text-center text-sm font-medium text-white focus:outline-none"
                                        data-information="{{json_encode($item->information)}}"
                                        data-feedback="{{$item->feedback}}"
                                        data-trx_id="{{ $item->trx_id }}">
                                    <i class="fa-regular fa-info-circle"></i>
                                </button>
                            </td> --}}
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
