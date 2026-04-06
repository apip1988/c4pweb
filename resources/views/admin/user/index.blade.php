@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0" style="border-radius: 20px;">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Senarai Pengguna Sistem</h5>
            <span class="badge badge-light">{{ count($users) }} Pengguna</span>
        </div>
        <div class="card-body">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama & Emel</th>
                            <th>Role Semasa</th>
                            <th>Tukar Role</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>
                                <strong>{{ $u->name }}</strong><br>
                                <small class="text-muted">{{ $u->email }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $u->role == 'ADMIN' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $u->role ?? 'USER' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.updateRole', $u->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <select name="role" class="form-control form-control-sm mr-2" style="width: 150px;">
    <option value="USER" {{ $u->role == 'USER' ? 'selected' : '' }}>USER</option>
    <option value="VIP" {{ $u->role == 'VIP' ? 'selected' : '' }}>VIP</option>
    <option value="ADMIN" {{ $u->role == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
    <option value="SUPER ADMIN" {{ $u->role == 'SUPER ADMIN' ? 'selected' : '' }}>SUPER ADMIN</option>
</select>
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td class="text-center">
                                @if($u->id != auth()->id())
                                <a href="{{ route('admin.users.destroy', $u->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Padam user ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection