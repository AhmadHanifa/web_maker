@extends('layouts.admin')

@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0 main-box">
        <div class="col-12 px-0">
            <div class="col-12 p-0 row">
                <div class="col-12 col-lg-4 py-3 px-3">
                    <span class="fas fa-articles"></span> <th style="width:150px;">{imagetests}</th>
                </div>
                <div class="col-12 col-lg-4 p-0">
                </div>
                <div class="col-12 col-lg-4 p-2 text-lg-endq">
                    <a href="{{route('imagetest.create.web')}}">
                    <span class="btn btn-primary"><span class="fas fa-plus"></span> إضافة جديد</span>
                    </a>
                </div>
            </div>
            <div class="col-12 divider" style="min-height: 2px;"></div>
        </div>

        <div class="col-12 p-3" style="overflow:auto">
            <div class="col-12 p-0" style="min-width:1100px;">
                <table class="table table-bordered  table-hover">
                    <thead>
                        <th>#</th>

                                                <th>Name</th>
                    <th>Nummer</th>
                    <th>Discripe</th>
                    <th>Image</th>


                        <th></th>
                    </thead>
                    <tbody>
                    @foreach($imagetests as $imagetest)
                        <tr>
                            <td> </td>
                                                <td>{{ $imagetest->Name }}</td>
                    <td>{{ $imagetest->Nummer }}</td>
                    <td>{{ $imagetest->discripe }}</td>
                    <td>{{ $imagetest->image }}</td>

                            <td>
                                <a href="{{route('imagetest.edit.web', $imagetest->id)}}">
                                    <span class="btn btn-outline-success btn-sm font-small mx-1"><span class="fas fa-wrench"></span> تعديل </span>
                                </a>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 p-3">
        </div>
    </div>
</div>
@endsection