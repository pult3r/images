@extends('layout')

@section('content')

    @laravelViewsScripts
        <h1 class="flex items-center mx-5">Upload image Page </h1>
        <h2 class="flex items-center mx-5">Upload image : </h2>
            <form action="{{ route('image.store') }}" method="POST" class="p-12" enctype="multipart/form-data">
                @csrf
                <label class="block mb-4">
                    <span class="sr-only">Choose File</span>
                    <input type="file" name="image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </label>
                <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded">Submit</button>
            </form>


    @isset($images)
        <h2 class="flex items-center mx-5">Uploaded images : </h2>
        <div class="m-5 clear-both float-left block">
        @foreach($images as $image)

            <div class="m-1 float-left block">
                <a href="{{ url('/image/'.$image->id) }}"><img  style="height:200px !important" src="{{ asset('storage/'.$image->path ) }}" /></a>
            </div>
        @endforeach
        </div>
    @endisset

    <div class="m-5 clear-both float-left block">
    {{ $images->onEachSide(2)->links() }}
    </div>

 @endsection