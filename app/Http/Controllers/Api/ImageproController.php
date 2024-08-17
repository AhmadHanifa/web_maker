<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\IndexFunction;

use App\Models\Imagepro;

class ImageproController extends Controller
{
    public function index()
    {

        $imagepros= Imagepro::get();
        return view('imagepro.index',compact('imagepros'));

}

}