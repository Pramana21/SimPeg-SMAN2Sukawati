@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Manajemen User</h3>

        <a href="{{ route('user.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Pegawai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach ($users as $index => $user)

            <tr>

                <td>{{ $index + 1 }}</td>

                <td>{{ $user->username }}</td>

                <td>{{ $user->role->role_name ?? '-' }}</td>

                <td>{{ $user->pegawai->nama_pegawai ?? '-' }}</td>

                <td>
                    @if($user->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Nonaktif</span>
                    @endif
                </td>

                <td>

                    <a href="{{ route('user.edit',$user->id_user) }}" 
                       class="btn btn-warning btn-sm">
                       Edit
                    </a>

                    <form action="{{ route('user.destroy',$user->id_user) }}" 
                          method="POST"
                          style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection