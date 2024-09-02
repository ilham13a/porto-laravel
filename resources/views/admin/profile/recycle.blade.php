@extends('layouts_2.app')
@section('content')
    <div class="card">
        <div class="card-header">Profiles</div>
        <div class="card-body">
            {{-- <a href="{{ route('profiles.create') }}" class="btn btn-primary btn-sm mb-2">Add</a> --}}
            <a href="{{ url('admin/profiles') }}" class="btn btn-secondary btn-sm mb-2">Back</a>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Actions</th>
                            {{-- <th>Status</th> --}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{-- <th>Picture</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profiles as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class=" justify-content-center">
                                    <a href="{{ route('profiles.restore', $item->id) }}"
                                        class="btn btn-success btn-sm">Restore</a>
                                    {{-- <button type="submit" class="btn btn-success btn-sm">Restore</button> --}}
                                    <form style="display: inline;"
                                        action="{{ route('profiles.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to soft delete this profile?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                                {{-- <td><input type="radio" name="status" class="status-radio" data-id=""></td> --}}
                                <!-- Assuming you may want to display a status -->
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->email }}</td>
                                {{-- <td></td> --}}
                                {{-- <td></td> --}}
                                <td>{{ $item->no_telepon }}</td>
                                {{-- <td><img src="" width="100" alt=""></td> <!-- Adjusted width --> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
@endsection
