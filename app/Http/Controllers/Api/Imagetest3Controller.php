<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use \App\Functions\IndexFunction;

use App\Models\Imagetest3;

class Imagetest3Controller extends Controller
{
    public function index()
    {

        $imagetest3s= Imagetest3::get();
        return view('imagetest3.index',compact('imagetest3s'));

}

}