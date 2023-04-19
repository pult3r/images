@extends('layout')

@section('content')
        <h1 class="flex items-center mx-5">Convert image Page </h1>
        <form action="{{ route('image.change') }}" method="POST" class="" enctype="multipart/form-data">
            @csrf 
            <input type="hidden" name="id" value="{{$image->id}}">
            <div class="float-left block m-3">
                <img width="300px" src="{{ URL::asset('storage/'.$image->path) }} "/>
            </div>
            <div class="float-left block  m-3">
                <div class="float-left mb-3">
                
                    <h1 class="">Change :</h1>
                    <h2 class="">Image size :</h2>
                    <div class="float-left block">
                        <div class="float-left block uppercase font-bold py-1">Width :</div>
                        <div class="float-left block"><input type="text" name="imagewidth" value="{{$image->width}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 mb-1 ml-1 focus:outline-none focus:bg-white focus:border-gray-500"></div>
                    </div>
                    <div class="float-left clear-both">
                        <div class="float-left block uppercase font-bold py-1">Height :</div>
                        <div class="float-left block"><input type="text" name="imageheight" value="{{$image->height}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 mb-1 ml-1 focus:outline-none focus:bg-white focus:border-gray-500"></div>
                    </div>
                
                </div>

                <div class="float-left clear-both mb-3">
                    <h2 class="">Image resolution :</h2>
                    <div class="float-left block">
                        <div class="float-left block uppercase font-bold py-1">X :</div>
                        <div class="float-left block"><input type="text" name="resolutionx" value="{{$image->resolutionx}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 mb-1 ml-1 focus:outline-none focus:bg-white focus:border-gray-500"></div>
                    </div>
                    <div class="float-left block clear-both">
                        <div class="float-left block uppercase font-bold py-1">Y :</div>
                        <div class="float-left block"><input type="text" name="resolutiony" value="{{$image->resolutiony}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 mb-1 ml-1 focus:outline-none focus:bg-white focus:border-gray-500"></div>
                    </div>
                </div>

                <div class="float-left clear-both  mb-3">
                    <h2 class="">Image type:</h2>
                    <div class="float-left block">
                        <div class="float-left block uppercase font-bold py-1">Type :</div>
                        <div class="float-left block">
                            <select name="imagetype" class="block w-full  bg-gray-200 text-gray-700 border border-gray-200 rounded py-1 px-4 mb-1 ml-1 focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="JPG" @if($image->extension == 'jpg') selected="selected" @endif>JPG</option>
                                <option value="PNG" @if($image->extension == 'png') selected="selected" @endif>PNG</option>
                                <option value="GIF" @if($image->extension == 'gif') selected="selected" @endif>GIF</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear-both float-left m-3">
                <button type="submit" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded">Save</button>
            </div>
        </form>
@endsection