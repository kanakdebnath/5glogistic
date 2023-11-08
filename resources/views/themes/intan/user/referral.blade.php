@extends($theme.'layouts.user')
@section('title',trans('Referral'))

@section('content')

@push('style')
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/invites.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/intan/css/withdraw.css')}}">

@endpush


<!-- BEGIN: JEWLERY HEADER SECTION -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <center>
                    <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" style="height: 110px;" />
                </center>
            </div>
        </div>
    </div>
</div>
<!-- END: JEWLERY HEADER SECTION -->
<!-- BEGIN: PROFILE SECTION -->
<section class="jewlery-profile-section">
    <div class="container">
        <div class="row profile-detail">
            <div class="col-md-12">
                <img src="img/profile-img.png" alt="">
                <h1>{{Auth::user()->fullname}}</h1>
                <p>{{Auth::user()->email}}</p>
            </div>
        </div>
        <!-- profile detail end -->


        <form class="row g-3">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label"><i class="fa-solid fa-link"></i>&nbsp; &nbsp;@lang('Referral
                    Link') :</label>
                <input type="text" disabled class="form-control" value="{{route('register.sponsor',[Auth::user()->username])}}" id="inputEmail4" placeholder="{{route('register.sponsor',[Auth::user()->username])}}">
                <span style='cursor: pointer;' id="file-copy" onclick="copyFunctionText()" class="fa fa-fw fa-file"></span>
            </div>
        </form>
        <div class="row jewlery-about">
            <div class="col-md-12">
                <h1>Rabat / Komisi Bawahan</h1>
                <p>
                    Setiap pengguna yang berhasil mendaftar dan melakukan investasi maka anda akan mendapatkan rabat / komisi sebesar :
                </p>
                <p style="text-align:center;">level 1 : 15 % </p>
                <p style="text-align:center;">level 2 :  3 % </p>
                <p style="text-align:center;">level 3 :  1 % </p>
                <p>* Saldo bonus rabat / komisi bawahan dapat ditarik tanpa harus memiliki investasi aktif </p>
            </div>
        </div>

        @php
    $total = getMemberLevel(Auth::id());
    $level = getLevelByTotal($total);
    $nextlevel = getNextLevel($level);
    $nextlevelmembers = getLevelMembers($nextlevel);


    @endphp
    <div class="row" id="referral-page-btn">
            <div class="col-md-12">
                <a href="{{ route('user.bonus_history') }}"><button type="button">Cek Riwayat Bonus</button></a>
            </div>
        </div>

        <div class="row jewlrey-lavel-card">
            <div class="col-md-4">
                <h1 class="d-inline">Level 1</h1>
                <a href="{{ route('user.referral.member',1) }}">
                    <button type="button" class="float-end">Selengkapnya</button>
                </a>
                <table>
                    <tr>
                        <th>Total Anggota</th>
                        <td><b>{{LevelOneTotal(Auth::id())}}</b> Anggota</td>
                    </tr>
                    <tr>
                        <th>Berinvestasi</th>
                        <td><b>{{ LevelOneMember(Auth::id()) }}</b> Anggota</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <h1 class="d-inline">Level 2</h1>
                <a href="{{ route('user.referral.member',2) }}">
                    <button type="button" class="float-end">Selengkapnya</button>
                </a>
                <table>
                    <tr>
                        <th>Total Anggota</th>
                            <td><b>{{ LevelTwoTotal(Auth::id()) }}</b> Anggota</td>
                    </tr>
                    <tr>
                        <th>Berinvestasi</th>
                        <td><b>{{ LevelTwoMember(Auth::id()) }}</b> Anggota</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <h1 class="d-inline">Level 3</h1>
                <a href="{{ route('user.referral.member',3) }}">
                    <button type="button" class="float-end">Selengkapnya</button>
                </a>
                <table>
                    <tr>
                        <th>Total Anggota</th>
                        <td><b>{{ LevelThreeTotal(Auth::id()) }}</b> Anggota</td>
                    </tr>
                    <tr>
                        <th>Berinvestasi</th>
                        <td><b>{{ LevelThreeMember(Auth::id()) }}</b> Anggota</td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</section>
<!-- END: PROFILE SECTION -->


@endsection


@push('scripts')
<script>
    function copyFunctionText() {
                // Get the text field
        var copyText = document.getElementById("inputEmail4");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        let notifier = new AWN(options);
        notifier.success("Link referral disalin");
    }
</script>
@endpush