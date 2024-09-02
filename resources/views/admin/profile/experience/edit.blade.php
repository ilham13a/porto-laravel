@extends('layouts_2.app')
@section('content')
    <form action="{{ route('experience.update', $experience->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="nama_lengkap">Nama</label>
            <input type="text" name="judul_experience" id="nama_lengkap" class="form-control"
                value="{{ $experience->judul_experience }}">
        </div>
        <div class="mb-3">
            <label for="nama_lengkap">Sub Judul</label>
            <input type="text" name="sub_experience" id="nama_lengkap" class="form-control"
                value="{{ $experience->sub_experience }}">
        </div>
        <div class="mb-3">
            <label for="descriptions">Descriptions</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $experience->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="facebook">Tanggal Masuk</label>
            <input type="date" name="tgl_masuk" class="form-control">
        </div>
        <div class="mb-3">
            <label for="twitter">Tanggal Keluar</label>
            <input type="date" name="tgl_keluar" class="form-control">

        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ url('admin/profiles') }}">Back</a>
        </div>

    </form>
@endsection
