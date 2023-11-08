@extends($theme.'layouts.app')
@section('title','404')


@section('content')


<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
<div class="container-fluid" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <div class="col-lg-12 my-5 py-5 text-center">
                    <span class="title display-1 d-block text-white text-2xl mb-8">{{trans('Opps!')}}</span>
                    <div class="sub_title lead mt-4 mb-4 text-white text-xl">{{trans('The page you are looking for was not found.')}}</div>
                    <a style="color: #bd9277;" href="{{url('/')}}">@lang('Back To Home')</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->


@endsection
