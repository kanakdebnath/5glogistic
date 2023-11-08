@extends($theme.'layouts.5glogistic')

@push('head')
<link rel="stylesheet" href="{{asset('assets/frontend/styles/mine.css')}}" />
@endpush

@section('content')
<header>
    @include('themes.5glogistic.inc.bottom-nav')
</header>
  <!-- top banner -->
  <section class="top-banner px-2 pt-5">
    <div
      class="d-flex align-items-center"
      style="height: 80px; margin-bottom: 30px"
    >
      <img class="h-100" src="{{asset('assets/frontend/images/icons/mine_logo.png')}}" alt="" />
      <div>
        <p class="m-0 fs-3 fw-bold text-dark">3000597212</p>
        <p
          class="m-0 fw-bold d-flex align-items-center justify-content-center gap-2"
        >
          Invite code: 193662
          <img style="width: 13px" src="{{asset('assets/frontend/images/icons/copy.png')}}" alt="" />
        </p>
      </div>
    </div>

    <div class="row gap-2 mx-2">
      <div class="col p-0 bg-white pt-2 pe-4 rounded-3">
        <p
          style="font-size: 12px; background: #b7bebe80"
          class="m-0 ps-2 rounded-end"
        >
          Current latest assets
        </p>
        <p class="m-0 px-2 fw-medium mt-1">my assets(Rs.)</p>
        <p class="m-0 px-2 fs-3 fw-bold">40.08</p>
      </div>
      <div class="col p-0 bg-white pt-2 pe-4 rounded-3">
        <p
          style="font-size: 12px; background: #ffd01a30; color: #ff721a"
          class="m-0 ps-2 rounded-end"
        >
          Current latest assets
        </p>
        <p class="m-0 px-2 fw-medium mt-1">my assets(Rs.)</p>
        <p class="m-0 px-2 fs-3 fw-bold">40.08</p>
      </div>
    </div>
  </section>

  <!-- common tools -->
  <section class="bg-white mx-3 mt-5 rounded-3 pt-2 pb-3 px-3">
    <p>Common tools</p>
    <div class="row">
      <div class="col-3 d-flex flex-column align-items-center justify-content-center">
        <img style="width: 35px;" src="{{asset('assets/frontend/images/icons/recharge1.png')}}" alt="" />
        <p class="m-0 fs-small fw-bold mt-1">Recharge</p>
      </div>
      <div class="col-3 d-flex flex-column align-items-center justify-content-center">
        <img style="width: 35px;" src="{{asset('assets/frontend/images/icons/withdraws.png')}}" alt="" />
        <p class="m-0 fs-small fw-bold mt-1">Withdraw</p>
      </div>
      <div class="col-3 d-flex flex-column align-items-center justify-content-center">
        <img style="width: 35px;" src="{{asset('assets/frontend/images/icons/bank-account.png')}}" alt="" />
        <p class="m-0 fs-small fw-bold mt-1">Account</p>
      </div>
      <div class="col-3 d-flex flex-column align-items-center justify-content-center">
        <img style="width: 35px;" src="{{asset('assets/frontend/images/icons/recharge1.png')}}" alt="" />
        <p class="m-0 fs-small fw-bold mt-1">Password</p>
      </div>
    </div>
  </section>

  <!-- links -->

  <section>
      <ul class="list-group gap-3 bg-white mx-3 mt-3 rounded-3 py-3 px-3">
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/consult.png')}}" alt="">
                      Consult</p> 
                      <p class="m-0"><i class="fa-solid fa-chevron-right"></i></p>
                  </div>
              </a>
          </li>
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/platfrom story.png')}}" alt="">
                          Platform story</p> 
                      <p class="m-0"><i class="fa-solid fa-chevron-right"></i></p>
                  </div>
              </a>
          </li>
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/newbie-help.png')}}" alt="">
                      Newbie Help</p> 
                      <p class="m-0"><i class="fa-solid fa-chevron-right"></i></p>
                  </div>
              </a>
          </li>
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/app-version.png')}}" alt="">
                      App Version</p> 
                      <p class="m-0 fs-small text-secondary">V 1.0 1.0</p>
                  </div>
              </a>
          </li>
      </ul>
  </section>

  <section>
      <ul class="list-group gap-3 bg-white mx-3 mt-3 rounded-3 py-3 px-3">
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/download.png')}}" alt="">
                      Download App</p> 
                      <p class="m-0"><i class="fa-solid fa-chevron-right"></i></p>
                  </div>
              </a>
          </li>
          <li class="list-group-item border-0">
              <a href="#" class="text-dark">
                  <div class="d-flex justify-content-between">
                      <p class="m-0 d-flex align-items-center gap-2 fw-bold"><img class="w-22" src="{{asset('assets/frontend/images/icons/signOut.png')}}" alt="">
                          Sign Out</p> 
                      <p class="m-0"><i class="fa-solid fa-chevron-right"></i></p>
                  </div>
              </a>
          </li> 
      </ul>
  </section>

@endsection


