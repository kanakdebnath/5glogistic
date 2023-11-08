@extends('admin.layouts.app')
@section('title')
    @lang('Create a Category')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="media mb-4 justify-content-end">
                <a href="{{route('admin.categoryList')}}" class="btn btn-sm  btn-primary mr-2">
                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                </a>
            </div>

            <form method="post" action="{{route('admin.categoryStore')}}" enctype="multipart/form-data" class="form-row justify-content-center">
                @csrf
                <div class="col-md-8">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" name="name" value="{{old('name')}}" placeholder="@lang('Category Name')" class="form-control" >
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>@lang('Capital Back')</label>
                        <input data-toggle="toggle" id="capital_back" data-onstyle="success"
                               data-offstyle="info" data-on="@lang('Yes')" data-off="@lang('No')" data-width="100%"
                               type="checkbox" checked name="capital_back">
                        @error('capital_back')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-6">
                        <label>@lang('Status')</label>
                        <input data-toggle="toggle" id="status" data-onstyle="success"
                               data-offstyle="info" data-on="Active" data-off="Deactive" data-width="100%"
                               type="checkbox" checked  name="status">
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>


                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                            class="fas fa-save pr-2"></i> @lang('Save Changes')</span></button>

                </div>
            </form>
        </div>
    </div>
@endsection


@push('js')
    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif
@endpush
