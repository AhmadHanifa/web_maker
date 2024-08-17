<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\IndexFunction;

use App\Models\Imagetest1;

class Imagetest1Controller extends Controller
{
    public function index()
    {

        $imagetest1s= Imagetest1::get();
        return view('imagetest1.index',compact('imagetest1s'));

}

}