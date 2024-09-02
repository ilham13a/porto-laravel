@extends('layouts_2.app')

@section('content')
    <div class="card">
        <div class="card-header">Experiences</div>
        <div class="card-body">
            <a href="{{ route('experience.create') }}" class="btn btn-primary btn-sm mb-2">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Actions</th>
                            <th>Sub Judul</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Descriptions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($experiences as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->judul_experience }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('experience.edit', $item->id) }}"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <form style="display: inline;" action="{{ route('experience.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to soft delete this profile?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Soft Delete</button>
                                    </form>
                                </td>
                                <td>{{ $item->sub_experience }}
                                </td>
                                <!-- Assuming you may want to display a status -->
                                <td>{{ $item->tgl_masuk }}</td>
                                <td>{{ $item->tgl_keluar }}</td>
                                <td>{{ $item->description }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
@endsection
@section('script-sweetalert')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const statusRadios = document.querySelectorAll('.status-radio');
            statusRadios.forEach(radio => {
                radio.addEventListener('click', (event) => {
                    const itemId = event.target.getAttribute('data-id');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(`/admin/experiences/update-status/${itemId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Berhasil',
                                    'Status berhasil diperbarui.',
                                    'success'
                                );
                                statusRadios.forEach(r => {
                                    if (r.getAttribute('data-id') != itemId) {
                                        r.checked = false;
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Gagal',
                                    data.error ||
                                    'Terjadi kesalahan saat memperbarui status',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Gagal',
                                'Terjadi kesalahan saat memperbarui status.',
                                'error'
                            );
                        });
                });
            });
        });
    </script>
@endsection
