@extends($theme.'layouts.user')
@section('title',trans('Invest History'))

@push('pagetitle')
<li class="flex-grow-0">
    <div class="group inline-flex rounded-t-lg h-full items-center">
        {{trans('Invest History')}}
    </div>
</li>
@endpush

@section('content')
    <script>
        "use strict"
        function getCountDown(elementId, seconds) {
            var times = seconds;
            var x = setInterval(function () {
                var distance = times * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                times--;
            }, 1000);
        }
    </script>

    <section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32">
        <div class="pb-4">
            <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-left bg-gray-700 text-gray-400 border-collapse border-none">
                <thead class="text-xs bg-gray-700 text-gray-400">
                <tr class="border-0">
                    <th class="px-2 py-2 border-0">@lang('SL')</th>
                    <th class="px-2 py-2 border-0">@lang('Plan')</th>
                    <th class="px-2 py-2 border-0">@lang('Return Interest')</th>
                    <th class="px-2 py-2 border-0">@lang('Received Amount')</th>
                    <th class="px-2 py-2 border-0">@lang('Upcoming Payment')</th>
                </tr>
                </thead>
                <tbody class="bg-gray-800">
                    @forelse($investments as $key => $invest)
                        <tr class="text-xs border-b bg-gray-800 border-gray-700">
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                {{loopIndex($investments) + $loop->index}}
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                {{trans(optional($invest->plan)->name)}}
                                <br> {{getAmount($invest->amount).' '.trans($basic->currency)}}
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                {{getAmount($invest->profit)}} {{trans($basic->currency)}}
                                {{($invest->period == '-1') ? trans('For Lifetime') : 'per '. trans($invest->point_in_text)}}
                                <br>
                                {{($invest->capital_status == '1') ? '+ '.trans('Capital') :''}}
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                {{$invest->recurring_time}} x {{ $invest->profit }} =  {{getAmount($invest->recurring_time*$invest->profit) }} {{trans($basic->currency)}}
                            </td>
                            <td class="px-2 py-2 text-gray-300 whitespace-nowrap">
                                @if($invest->status == 1)
                                    <p id="counter{{$invest->id}}" class="mb-2"></p>
                                    <script>getCountDown("counter{{$invest->id}}", {{\Carbon\Carbon::parse($invest->afterward)->diffInSeconds()}});</script>
                                    <div class="progress">
                                        <div class="shadow w-full bg-gray-700 rounded-full overflow-hidden">
                                            <div class="bg-pirategold-500 text-xs leading-none py-1 text-center text-white" role="progressbar" style="width: {{$invest->nextPayment}}" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$invest->nextPayment}}</div>
                                        </div>
                                        {{-- <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"  style="width: {{$invest->nextPayment}}"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$invest->nextPayment}}</div> --}}
                                    </div>
                                    @else
                                        <span class="badge badge-success">@lang('Completed')</span>
                                    @endif
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
