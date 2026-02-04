@extends('layouts.master')
@section('title', 'Pengaturan Akun')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Pengaturan Akun</h1>
    <p style="color: var(--muted);">Kelola informasi profil dan keamanan akun Anda.</p>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Profile Information -->
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 20px; color: var(--text);">Informasi Profil</h3>
        
        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg);">
            @error('name')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Alamat Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg);">
            @error('email')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border); margin-bottom: 32px;">

        <!-- Change Password -->
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 20px; color: var(--text);">Ganti Password</h3>
        <p style="color: var(--muted); margin-bottom: 20px; font-size: 0.9rem;">Kosongkan jika tidak ingin mengubah password.</p>

        <div style="margin-bottom: 20px;">
            <label for="current_password" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Password Saat Ini</label>
            <input type="password" id="current_password" name="current_password"
                class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg);">
            @error('current_password')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
            <div>
                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Password Baru</label>
                <input type="password" id="password" name="password"
                    class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg);">
                @error('password')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg);">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="background: var(--primary); color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
