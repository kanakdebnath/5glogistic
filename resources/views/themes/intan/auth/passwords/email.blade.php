@extends($theme.'layouts.app')
@section('title',trans('Lupa Password'))

@section('content')

<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-inputs">
                <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
                <form action="{{ route('password.email') }}" id="form" method="post">
                    @csrf
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('Email Address')</label>
                    <i class="fa-solid fa-envelope pro-icon"></i>
                    <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="@lang('Masukkan Email Anda')" required>
                    @error('email')
                    <small class="text-danger">@lang($message)</small>
                    @enderror
                </div>
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary" id="send_link" @if(session()->has('success')) disabled @endif >@lang('Setel Ulang Kata Sandi')</button>
                    <small id="timer_div"></small>
                </center>
                 <center>
                    <img src="{{asset('assets/frontend/intan/img/ojk.png')}}" style="height: 30px;" />
                </center>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- ========================= SIGNIN SECTION END HERE ====================== -->

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#form').on('submit', function(){
            $("#send_link").attr('disabled',true);
            $("#send_link").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>');
        });
    });
</script>

@if(session()->has('success'))
    <script>
          var timeLeft = 60;
          var elem = document.getElementById("send_link");
          var timerId = setInterval(countdown, 1000);
        function countdown() {
            if (timeLeft == 0) {
              clearTimeout(timerId);
              $("#send_link").html("@lang('Setel Ulang Kata Sandi')");
              $("#send_link").attr('disabled',false);
            } else {
              elem.innerHTML = timeLeft;
              timeLeft--;
            }
        }
    </script>
@endif
@endpush
