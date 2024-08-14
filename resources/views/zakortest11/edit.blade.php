        @extends('layouts.admin')

        @section('content')
        <div class="col-12 p-3">
            <form action="{{ route('zakortest11.update', $zakortest11->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
    <label for="Name">Name</label>
    <input type="text" name="Name" id="Name" class="form-control" value="{{ $zakortest11->Name }}">
</div>
<div class="form-group">
    <label for="Nummer">Nummer</label>
    <input type="number" name="Nummer" id="Nummer" class="form-control" value="{{ $zakortest11->Nummer }}">
</div>
<div class="form-group">
    <label for="discripe">Discripe</label>
    <textarea name="discripe" id="discripe" class="form-control">{{ $zakortest11->discripe }}</textarea>
</div>
<div class="form-group">
    <label for="image">Image</label>
    <div class="col-12 p-2">
        <div class="col-12">Image</div>
        <div class="col-12 pt-3">
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="col-12 pt-3"></div>
    </div>
</div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
        @endsection