@extends($theme.'layouts.user')
@section('title',__($page_title))

@push('pagetitle')
<li class="flex-grow-0">
    <div class="group inline-flex rounded-t-lg h-full items-center">
        {{trans($page_title)}}
    </div>
</li>
@endpush

@section('content')
<section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pt-6 pb-32 content-center">
    <div class="flex rounded-lg border p-4 align-middle shadow-md border-gray-700 bg-gray-800 sm:p-6 lg:p-8">
        <form class="flex-1 space-y- login-form wow fadeInUp" action="{{route('user.ticket.store')}}" enctype="multipart/form-data" autocomplete="off" method="post">
            @csrf
            <div class="mb-5">
                <label for="subject" class="mb-2 block text-sm font-medium text-gray-300">@lang('Subject')</label>
                <input type="text" name="subject" placeholder="@lang('Enter Subject')" class="block w-full rounded-lg border p-2.5 text-sm focus:border-pirategold-400 focus:ring-pirategold-400 border-gray-700 bg-gray-900 text-gray-300 placeholder-gray-400 focus:outline-none" required />
                @error('subject')
                    <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="message" class="mb-2 block text-sm font-medium text-gray-300">@lang('Message')</label>
                <textarea name="message" id="textarea1" rows="4" placeholder="@lang('Enter Message')" class="block w-full rounded-lg border p-2.5 text-sm focus:border-pirategold-400 focus:ring-pirategold-400 border-gray-700 bg-gray-900 text-gray-300 placeholder-gray-400 focus:outline-none" required></textarea>
                @error('message')
                    <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-5">
                <label for="subject" class="mb-2 block text-sm font-medium text-gray-300">@lang('Attachments')</label>
                <input type="file" name="attachments[]" multiple placeholder="@lang('Upload File')" class="block w-full rounded-lg border p-2.5 text-sm focus:border-pirategold-400 focus:ring-pirategold-400 border-gray-700 bg-gray-900 text-gray-300 placeholder-gray-400 focus:outline-none" />
                @error('attachments')
                    <span class="text-red-400 text-sm mt-1">{{trans($message)}}</span>
                @enderror
            </div>
            <button type="submit" class="w-full rounded-lg bg-pirategold-500 px-5 py-2.5 text-center text-sm font-medium text-white focus:outline-none">
                @lang('Submit')
            </button>
        </form>
    </div>
</section>
@endsection
