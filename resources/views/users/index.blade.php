@extends('layouts.master')

@section('title', 'Manajemen User')

@section('content')
<div class="dashboard-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Manajemen User</h1>
        <p style="color: var(--muted);">Kelola data pengguna sistem.</p>
    </div>
    <button onclick="openCreateModal()" class="btn btn-primary" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5" style="width: 20px; height: 20px;">
            <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
        </svg>
        Tambah User
    </button>
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
                            background: {{ $user->role === 'admin' ? '#e0e7ff' : '#dcfce7' }};
                            color: {{ $user->role === 'admin' ? '#4338ca' : '#15803d' }};
                        ">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 16px; color: var(--muted);">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding: 16px; text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <button onclick='openEditModal(@json($user))' style="background: none; border: none; cursor: pointer; color: var(--primary); padding: 4px;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                                    <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                </svg>
                            </button>
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

<!-- Create Modal -->
<div id="createModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; justify-content: center; align-items: center;">
    <div style="background: var(--panel); width: 100%; max-width: 500px; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text); margin: 0;">Tambah User</h2>
            <button onclick="closeCreateModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer;">&times;</button>
        </div>
        
        <form id="createForm" action="{{ route('users.store') }}" method="POST">
            @csrf
            <input type="hidden" name="form_type" value="create">
            
            <div style="margin-bottom: 16px;">
                <label for="create_name" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Nama Lengkap</label>
                <input type="text" id="create_name" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'create')
                @error('name')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="create_email" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Email</label>
                <input type="email" id="create_email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'create')
                @error('email')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="create_role" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Role</label>
                <select id="create_role" name="role" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @if(old('form_type') == 'create')
                @error('role')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="create_password" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Password</label>
                <input type="password" id="create_password" name="password" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'create')
                @error('password')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 24px;">
                <label for="create_password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Konfirmasi Password</label>
                <input type="password" id="create_password_confirmation" name="password_confirmation" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeCreateModal()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid var(--border); background: var(--panel-2); color: var(--text); cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: var(--primary); color: white; cursor: pointer;">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; justify-content: center; align-items: center;">
    <div style="background: var(--panel); width: 100%; max-width: 500px; border-radius: 12px; padding: 24px; box-shadow: var(--shadow); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text); margin: 0;">Edit User</h2>
            <button onclick="closeEditModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer;">&times;</button>
        </div>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="form_type" value="edit">
            <input type="hidden" name="user_id" id="edit_user_id" value="{{ old('user_id') }}">
            
            <div style="margin-bottom: 16px;">
                <label for="edit_name" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Nama Lengkap</label>
                <input type="text" id="edit_name" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'edit')
                @error('name')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="edit_email" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Email</label>
                <input type="email" id="edit_email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'edit')
                @error('email')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="edit_role" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Role</label>
                <select id="edit_role" name="role" required
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                @if(old('form_type') == 'edit')
                @error('role')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <label for="edit_password" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Password (Opsional)</label>
                <input type="password" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
                @if(old('form_type') == 'edit')
                @error('password')
                    <div style="color: #ef4444; font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
                @endif
            </div>

            <div style="margin-bottom: 24px;">
                <label for="edit_password_confirmation" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--text);">Konfirmasi Password</label>
                <input type="password" id="edit_password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru"
                    style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); color: var(--text);">
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeEditModal()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid var(--border); background: var(--panel-2); color: var(--text); cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: var(--primary); color: white; cursor: pointer;">Update User</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function openEditModal(user) {
        document.getElementById('editForm').action = "{{ url('users') }}/" + user.id;
        document.getElementById('edit_user_id').value = user.id;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        // Reset password fields
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_password_confirmation').value = '';
        
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == document.getElementById('createModal')) {
            closeCreateModal();
        }
        if (event.target == document.getElementById('editModal')) {
            closeEditModal();
        }
    }

    // Check for validation errors and reopen modal
    @if($errors->any())
        @if(old('form_type') == 'create')
            openCreateModal();
        @elseif(old('form_type') == 'edit')
            // Re-set action for edit form based on old user_id
            document.getElementById('editForm').action = "{{ url('users') }}/" + "{{ old('user_id') }}";
            document.getElementById('editModal').style.display = 'flex';
        @endif
    @endif
</script>
@endpush