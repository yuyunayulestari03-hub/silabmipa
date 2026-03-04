@extends('layouts.master')
@section('title', 'Pengaturan Website')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Pengaturan Website</h1>
    <p style="color: var(--muted);">Kelola identitas dan pengaturan umum website.</p>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Nama Website</label>
            <input type="text" name="app_name" class="form-control" 
                style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); color: var(--text);"
                value="{{ $settings['app_name'] ?? 'SILAB MIPA' }}" placeholder="Masukkan nama website">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Logo Website</label>
            
            @if(isset($settings['app_logo']))
            <div style="margin-bottom: 12px; padding: 10px; border: 1px solid var(--border); border-radius: 6px; display: inline-block; background: var(--bg);">
                <img src="{{ asset($settings['app_logo']) }}" alt="Current Logo" style="max-height: 80px; width: auto;">
            </div>
            @endif

            <input type="file" name="app_logo" accept="image/*" class="form-control" 
    disabled
    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); cursor: not-allowed; opacity: 0.6;">

<p style="color: var(--muted); font-size: 0.8rem; margin-top: 6px;">
    Upload logo dinonaktifkan
</p>

        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="background: var(--primary); color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
