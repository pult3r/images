

@extends('layout')

    @section('content')
        <h1 class="flex items-center mx-5">Statistics Page</h1>
        <div class="m-5">
            <h2 class="">Uploaded images :</h2>
            <table>
                <tr>
                    <td class="font-bold p-2 align-left">Resolution</td>
                    <td class="font-bold p-2 align-left">Total size</td>
                    <td class="font-bold p-2 align-left">Quantity</td>
                </tr>
            @foreach($imageStats as $item)
        
            <tr>
                <td class=" p-2 align-left">{{$item->width}} x {{$item->height}} </td>
                <td class=" p-2 align-left">{{round($item->sizesum/1024 , 2)}} Kb</td>
                <td class=" p-2 align-left">{{$item->count}}</td>
            </tr>
            @endforeach
                <tr>
                    <td class="font-bold p-2 align-left">In total</td>
                    <td class="font-bold p-2 align-left">{{round($imageStats->sum('sizesum')/1024,2)}} kB</td>
                    <td class="font-bold p-2 align-left">{{$imageStats->sum('count')}}</td>
                </tr>
            </table>

            <h2 class="">Image types:</h2>
            <table>
                <tr>
                    <td class="font-bold p-2 align-left">Extension</td>
                    <td class="font-bold p-2 align-left">Quantity</td>
                </tr>
            @foreach($extImageStats as $item)
                <tr>
                    <td class=" p-2 align-left">{{$item->extension}} </td>
                    <td class=" p-2 align-left">{{$item->count}}</td>
                </tr>
            @endforeach
            </table>

        </div>

        <div class="m-5">
            <h2 class="">Converted images :</h2>
            <table>
                <tr>
                    <td class="font-bold p-2 align-left">Resolution</td>
                    <td class="font-bold p-2 align-left">Total size</td>
                    <td class="font-bold p-2 align-left">Quantity</td>
                </tr>
            @foreach($convertedImageStats as $item)
            <tr>
                <td class=" p-2 align-left">{{$item->width}} x {{$item->height}} </td>
                <td class=" p-2 align-left">{{round($item->sizesum/1024 , 2)}} Kb</td>
                <td class=" p-2 align-left">{{$item->count}}</td>
            </tr>
            @endforeach
                <tr>
                    <td class="font-bold p-2 align-left">In total</td>
                    <td class="font-bold p-2 align-left">{{round($convertedImageStats->sum('sizesum')/1024,2)}} kB</td>
                    <td class="font-bold p-2 align-left">{{$convertedImageStats->sum('count')}}</td>
                </tr>
            </table>

            <h2 class="">Image types:</h2>
            <table>
                <tr>
                    <td class="font-bold p-2 align-left">Extension</td>
                    <td class="font-bold p-2 align-left">Quantity</td>
                </tr>
            @foreach($extConvertedImageStats as $item)
                <tr>
                    <td class=" p-2 align-left">{{$item->extension}} </td>
                    <td class=" p-2 align-left">{{$item->count}}</td>
                </tr>
            @endforeach
            </table>
        </div>

@endsection

