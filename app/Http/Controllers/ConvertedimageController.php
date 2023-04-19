<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConvertedimageController extends Controller
{
    public function index()
    {
        $convertedImages = DB::table('convertedimages')->orderby('created_at', 'DESC')->paginate(20);
        return view("convertedimages")->with("convertedimages", $convertedImages);
    }
}
