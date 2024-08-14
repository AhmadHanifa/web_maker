@extends('layouts.admin')

@section('content')
    <div class="col-12 p-3">
        <form action="{{ route('zakortest.store') }}" method="POST">
            @csrf
            <div class="form-group">
    <label for="Name">Name</label>
    <input type="text" name="Name" id="Name" class="form-control" value="{{ old('Name') }}">
</div>
<div class="form-group">
    <label for="discripe">Discripe</label>
    <textarea name="discripe" id="discripe" class="form-control">{{ old('discripe') }}</textarea>
</div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection