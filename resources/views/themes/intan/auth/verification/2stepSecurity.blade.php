@extends($theme.'layouts.app')
@section('title','Login')

@section('content')
<!-- Login -->
<section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 content-center h-screen">
<div class="flex rounded-lg border p-4 align-middle shadow-md border-gray-700 bg-gray-800 sm:p-6 lg:p-8">
    <form class="flex-1 space-y-6 login-form wow fadeInUp" action="{{ route('login') }}" method="post">
        @csrf
        <h5 class="text-xl font-medium text-white">@lang($page_title)</h5>
        <div>
            <label for="code" class="mb-2 block text-sm font-medium text-gray-300">@lang('Code')</label>
            <input type="text" name="code" placeholder="@lang('Code')" class="block w-full rounded-lg border p-2.5 text-sm focus:border-pirategold-400 focus:ring-pirategold-400 border-gray-700 bg-gray-900 text-gray-300 placeholder-gray-400 focus:outline-none" required />
            @error('code')<span class="text-red-400 text-sm mt-1">{{ $message }}</span>@enderror
            @error('error')<span class="text-red-400 text-sm mt-1">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="w-full rounded-lg bg-pirategold-500 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none">
            @lang('Submit')
        </button>
    </form>
</div>
</section>
<!-- Login ->
@endsection
