@extends($theme.'layouts.app')
@section('title','419')


@section('content')


<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
<div class="container-fluid" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pb-32 wow fadeInUp" data-wow-delay=".2s" data-wow-offset="300">
                    <div class="flex bg-gray-800 rounded-lg">
                        <div class="flex-1">
                            <div class="col-lg-12 my-5 py-5 text-center">
                                <span class="title display-1 d-block text-white text-2xl mb-8">@lang('419')</span>
                                <div class="sub_title lead mt-4 mb-4 text-white text-xl">@lang("Sorry, your session has expired")</div>
                                <a class="linear-btn btn-base text-pirategold-400" href="{{url('/')}}">@lang('Back To Home')</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->


@endsection
