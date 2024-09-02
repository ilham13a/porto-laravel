@extends('layouts_2.app')
@section('content')
    <form action="{{ route('experience.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_lengkap">Nama</label>
            <input type="text" name="judul_experience" id="nama_lengkap" class="form-control">
        </div>
        <div class="mb-3">
            <label for="nama_lengkap">Nama</label>
            <input type="text" name="sub_experience" id="nama_lengkap" class="form-control">
        </div>
        <div class="mb-3">
            <label for="no_telepon">No Telp</label>
            <input type="number" name="no_telepon" id="no_telepon" class="form-control">
        </div>
        <div class="mb-3">
            <label for="descriptions">Descriptions</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
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
            <button type="submit" class="btn btn-primary">ADD</button>
            <a href="{{ url('admin/profiles') }}">Back</a>
        </div>

    </form>
@endsection
