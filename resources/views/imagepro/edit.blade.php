        @extends('layouts.admin')

        @section('content')
        <div class="col-12 p-3">
            <form action="{{ route('imagepro.update.web', $imagepro->id) }}" method="POST">
                @csrf
                @method('PUT')
                    <div class="col-12 col-lg-6 p-2">
        <div class="col-12">
            Name
        </div>
        <div class="col-12 pt-3">
            <input type="text" name="Name" id="Name" class="form-control" value="{{ $imagepro->Name }}">
        </div>
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
    <div class="col-12  p-2" >
        <div class="col-12">
            Discripe
        </div>
        <div class="col-12 pt-3">
            <textarea name="discripe" id="discripe" class="editor with-file-explorer">{{ $imagepro->discripe }}</textarea>
        </div>
    </div>
<div class="col-12 col-lg-6 p-2">
    <div class="col-12">
        Numer
    </div>
    <div class="col-12 pt-3">
        <input type="number" name="numer" id="numer" class="form-control" value="{{ $imagepro->numer }}">
    </div>
</div>

                <div class="col-12 p-3">
                <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
        @endsection