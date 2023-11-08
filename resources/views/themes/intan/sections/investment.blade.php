@if(0 < count($plans))
    <section class="flex-col space-y-6 lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pb-32">
        @foreach($plans as $k => $data)
        @php
        $getTime = \App\Models\ManageTime::where('time', $data->schedule)->first();
        @endphp
        <div class="flex-0 rounded-lg border border-gray-700 bg-gray-800 shadow-md">
            <a class="grid justify-items-center py-2">
                <img class="w-2/3" src="{{getFile(config('location.plan.path').$data->image) ? : 0}}" alt="" />
            </a>
            <div class="pb-5 pl-5 pr-5">
                <a>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-pirategold-400">{{$data->name}}</h5>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-700">
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Price')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">{{$data->price}}</div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Profit')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">
                                        @if ($data->profit_type == 1)
                                            <span class="highlight">{{getAmount($data->profit)}}{{'%'}}  @lang('Every') {{trans($getTime->name)}}</span>
                                        @else
                                            <span class="highlight"><small><sup>{{trans($basic->currency_symbol)}}</sup></small>{{getAmount($data->profit)}}  @lang('Every') {{trans($getTime->name)}}</span>
                                        @endif

                                    </div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Capital will back')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maximum Users Can Apply')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">{{$data->max_users}} @lang('Times')</div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maximum Per User')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">{{$data->max_per_user}} @lang('Times')</div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maturity')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">{{$data->repeatable}} @lang('Days')</div>
                                </div>
                            </li>
                            <li class="py-1">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Total')</p>
                                    </div>
                                    <div class="inline-flex items-center text-sm font-semibold text-white">
                                        <span>
                                            @if($data->is_lifetime == 0)
                                                @lang('Total') {{trans($data->profit*$data->repeatable)}}
                                                {{($data->profit_type == 1) ? '%': trans($basic->currency)}}
                                                @if($data->is_capital_back == 1)
                                                    + <span class="badge badge-success text-white">@lang('Capital')</span>
                                                @endif
                                            @else
                                                @lang('Lifetime Earning')
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </section>
@endif


@push('script')
    @if(count($errors) > 0 )
        <script>
            @foreach($errors -> all() as $key => $error)
                Notiflix.Notify.Failure("@lang($error)");
            @endforeach
        </script>
    @endif
@endpush
