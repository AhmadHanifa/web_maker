<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use \App\Functions\IndexFunction;

use App\Models\Imagetest2;

class Imagetest2Controller extends Controller
{
    public function index()
    {

        $imagetest2s= Imagetest2::get();
        return view('imagetest2.index',compact('imagetest2s'));

}

}