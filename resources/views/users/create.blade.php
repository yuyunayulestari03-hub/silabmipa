@extends('layouts.master')

@section('title', 'Tambah User')

@section('content')
<div class="dashboard-header" style="margin-bottom: 24px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Tambah User</h1>
    <p style="color: var(--muted);">Tambahkan pengguna baru ke dalam sistem.</p>
</div>

<div class="card" style="background: var(--panel); border-radius: 12px; box-shadow: var(--shadow); padding: 24px; max-width: 600px;">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 16px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
            @error('name')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
            @error('email')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="role" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Role</label>
            <select id="role" name="role" required
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                <option value="">Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            </select>
            @error('role')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Password</label>
            <input type="password" id="password" name="password" required
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
            @error('password')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('users.index') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; color: var(--text); background: var(--panel-2);">Batal</a>
            <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: var(--primary); color: white; cursor: pointer;">Simpan User</button>
        </div>
    </form>
</div>
@endsection
