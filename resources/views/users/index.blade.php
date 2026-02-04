@extends('layouts.master')

@section('title', 'Manajemen User')

@section('content')
<div class="dashboard-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Manajemen User</h1>
        <p style="color: var(--muted);">Kelola data pengguna sistem.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" style="width: 20px; height: 20px;">
            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
        </svg>
        Tambah User
    </a>
</div>

@if(session('success'))
<div style="background: #dcfce7; color: #16a34a; padding: 12px; border-radius: 8px; margin-bottom: 24px;">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 24px;">
    {{ session('error') }}
</div>
@endif

<div class="card" style="background: var(--panel); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border); background: var(--panel-2);">
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text);">Nama</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text);">Email</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text);">Role</th>
                    <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text);">Bergabung</th>
                    <th style="padding: 16px; text-align: right; font-weight: 600; color: var(--text);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid var(--border);">
                    <td style="padding: 16px; color: var(--text);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 0.875rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td style="padding: 16px; color: var(--muted);">{{ $user->email }}</td>
                    <td style="padding: 16px;">
                        <span style="
                            padding: 4px 12px; 
                            border-radius: 9999px; 
                            font-size: 0.875rem; 
                            font-weight: 500;
                            background: {{ $user->role === 'admin' ? '#e0e7ff' : ($user->role === 'dosen' ? '#dcfce7' : '#fef9c3') }};
                            color: {{ $user->role === 'admin' ? '#4338ca' : ($user->role === 'dosen' ? '#15803d' : '#a16207') }};
                        ">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 16px; color: var(--muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding: 16px; text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('users.edit', $user) }}" style="color: var(--primary); padding: 4px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                                    <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                </svg>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; cursor: pointer; color: #ef4444; padding: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                                        <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 24px; text-align: center; color: var(--muted);">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
