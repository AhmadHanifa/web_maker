<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Test267;

class Test267Controller extends Controller
{
    public function create()
    {
        return view('test267.create');
    }
public function edit($id)
    {
        $test267 = Test267::findOrFail($id);
        return view('test267.edit',compact('test267'));
    }
public function index()
    {

        $test267s= Test267::get();
        return view('test267.index',compact('test267s'));

}
public function store(Request $request)
    {
        $newItem = $request->all();
        Test267::create($newItem);
        return redirect(route('test267.index'));
    }
public function update(Request $request , $id)
    {
        $updateItem = Test267::findOrFail($id);
        $updateItem->update($request->all());
        return redirect(route('test267.index'));
    }

}