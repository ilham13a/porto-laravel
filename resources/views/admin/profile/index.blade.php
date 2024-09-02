@extends('layouts_2.app')

@section('content')
    <div class="card">
        <div class="card-header">Profiles</div>
        <div class="card-body">
            <a href="{{ route('experience.create') }}" class="btn btn-primary btn-sm mb-2">Add</a>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Picture</th>
                            <th>Phone</th>
                            {{-- <th>Status</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profiles as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_telepon }}</td>
                                <td><img src="{{ asset('storage/image/' . $item->picture) }}" width="100"
                                        alt="Profile Picture"></td> <!-- Adjusted width -->
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('profiles.edit', $item->id) }}"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <form style="display: inline;" action="{{ route('profiles.softdelete', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to soft delete this profile?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Soft Delete</button>
                                    </form>
                                </td>
                                {{-- <td><input type="radio" name="status" class="status-radio" data-id="{{ $item->id }}"
                                        {{ $item->status == 1 ? 'checked' : '' }}>
                                </td> --}}
                                <!-- Assuming you may want to display a status -->
                            </tr>
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

                    fetch(`/admin/profiles/update-status/${itemId}`, {
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
