@extends($theme.'layouts.app')
@section('title', trans('Home'))

@section('content')
@if(0 < count($plans))
    <section class="flex-col space-y-6 lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32">
        @foreach($plans as $k => $data)
        @php
        $getTime = \App\Models\ManageTime::where('time', $data->schedule)->first();
        @endphp
        <div class="flex-0 rounded-lg border border-gray-700 bg-gray-800 shadow-md">
            <a>
                <img class="w-full rounded-t-lg p-5" src="{{getFile(config('location.plan.path').$data->image) ? : 0}}" alt="" />
            </a>
            <div class="p-5">
                <div>
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-pirategold-400">{{$data->name}}</h5>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-700">
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Price')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">{{$data->price}}</div>
                                </div>
                            </li>
                                {{-- <li class="py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-white">@lang('Profit')</p>
                                        </div>
                                        <div class="inline-flex items-center text-base font-semibold text-white">{{($data->is_lifetime ==1) ? trans('Lifetime') : trans('Every').' '.trans($getTime->name)}}</div>
                                    </div>
                                </li> --}}
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Profit')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">
                                        @if ($data->profit_type == 1)
                                        <span class="highlight">{{getAmount($data->profit)}}{{'%'}} @lang('Every') {{trans($getTime->name)}}</span>
                                        @else
                                        <span class="highlight"><small><sup>{{trans($basic->currency_symbol)}}</sup></small>{{getAmount($data->profit)}} @lang('Every') {{trans($getTime->name)}}</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Capital will back')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">{{($data->is_capital_back ==1) ? trans('Yes'): trans('No')}}</div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maximum Users Can Apply')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">{{$data->max_users}}</div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maximum Per User')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">{{$data->max_per_user}} @lang('Times')</div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Maturity')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">{{$data->repeatable}} @lang('Days')</div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-white">@lang('Total')</p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-white">
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
                            <li class="py-2">
                                <div class="flex items-center space-x-2">
                                    <form action="{{route('user.payment.checkout')}}" method="post" class="w-full">
                                        @csrf
                                        <input type="hidden" name="plan_id" value="{{ $data->id }}">
                                        <input type="hidden" name="amount" value="{{ $data->fixed_amount }}">
                                        <input type="hidden" name="balance_type" value="checkout">
                                        <button type="submit" class="w-full rounded-lg bg-pirategold-500 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none">
                                            @lang('Invest Now')
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </section>
@endif
@endsection
