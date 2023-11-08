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
    <div class="">
        <div class="relative overflow-x-auto rounded-lg">
          <table class="w-full text-left bg-gray-700 text-gray-400 border-collapse border-none">
            <thead class="text-xs bg-gray-700 text-gray-400">
              <tr class="border-0">
                <th class="px-2 py-2 border-0">@lang('SL')</th>
                <th class="px-2 py-2 border-0">@lang('Bonus From')</th>
                <th class="px-2 py-2 border-0">@lang('Amount')</th>
                <th class="px-2 py-2 border-0">@lang('Remarks')</th>
                <th class="px-2 py-2 border-0">@lang('Time')</th>
              </tr>
            </thead>
            <tbody class="bg-gray-800">
                @forelse($transactions as $key => $transaction)
                    <tr class="text-xs border-b bg-gray-800 border-gray-700">
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">{{loopIndex($transactions) + $loop->index}}</td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">@lang(optional($transaction->bonusBy)->fullname)</td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">{{getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.currency'))}}</td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">@lang($transaction->remarks)</td>
                        <td class="px-2 py-2 text-gray-300 whitespace-nowrap">{{dateTime($transaction->created_at, 'd-M-Y')}}</td>
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

    <div class="flex-col rounded-lg border p-4 align-middle shadow-md border-gray-700 bg-gray-800 sm:p-6 lg:p-8 mt-4">
        <p class="text-white font-normal text-lg mb-2">
            @lang('Refferal Bonus Information')
        </p>
        <ul>
            <li class="text-gray-200 text-sm">1. Komisi investasi 3 level dengan persentase 12%, 6%, dan 3%</li>
            <li class="text-gray-200 text-sm">2. Komisi dihasilkan ketika Downline melakukan investasi pada mesin server.</li>
            <li class="text-gray-200 text-sm">3. Komisi dapat ditarik kapan saja tanpa adanya potongan.</li>
            <li class="text-gray-200 text-sm">4. Pengguna tidak harus memiliki mesin server untuk mendapatkan komisi.</li>
        </ul>
    </div>

</section>
@endsection


@push('script')

    <script>
        "use strict";
        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>

@endpush
