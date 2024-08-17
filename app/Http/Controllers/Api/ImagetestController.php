<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\IndexFunction;

use App\Models\Imagetest;

class ImagetestController extends Controller
{
    public function index()
    {

        $imagetests= Imagetest::get();
        return view('imagetest.index',compact('imagetests'));

}

}