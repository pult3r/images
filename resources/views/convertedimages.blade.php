@extends('layout')

@section('content')

    <h1 class="flex items-center mx-5">Converted image list Page</h1>
    @laravelViewsScripts
    @isset($convertedimages)
        @livewire('convertedimage-table-view')
    @endisset

@endsection
