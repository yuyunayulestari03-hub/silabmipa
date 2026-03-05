@php
  $isActive = fn($name) => request()->routeIs($name) ? 'active' : '';
@endphp

<aside class="sidebar">
  <div class="brand">
    <img src="{{ asset('logouin.png') }}" alt="Logo" style="max-height: 40px; width: auto;">
    <div class="title">
      <strong>{{ $appName }}</strong>
      <span>Fakultas Tarbiyah dan Keguruan</span>
    </div>

    {{-- tombol close (mobile) --}}
    <button class="icon-btn" style="margin-left:auto; display:none;" data-close-sidebar title="Tutup sidebar">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
      </svg>
    </button>
  </div>

  <nav class="nav">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" 
   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.632 8.632a.75.75 0 0 1-1.06 1.061l-.375-.375v8.003a2.25 2.25 0 0 1-2.25 2.25H13.5a.75.75 0 0 1-.75-.75V16.5a.75.75 0 0 0-.75-.75h-2.25a.75.75 0 0 0-.75.75v6.162a.75.75 0 0 1-.75.75H4.5a2.25 2.25 0 0 1-2.25-2.25v-8.003l-.375.375a.75.75 0 0 1-1.06-1.061L11.47 3.841Z" />
        </svg>
      </span>
      Dashboard
    </a>

    @if(in_array(auth()->user()->role, ['admin', 'user']))
    <!-- MANAJEMEN -->
    <div class="section">MANAJEMEN</div>

    <a href="{{ route('jadwal.index') }}" class="{{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V9.375a3 3 0 0 0-3-3H19.5V5.25C19.5 2.904 17.596 1 15.25 1h-6.5C6.404 1 4.5 2.904 4.5 5.25v13.5c0 1.657 1.343 3 3 3h9.75c1.657 0 3-1.343 3-3V9.375a3.375 3.375 0 0 0-3.375-3.375h-7.128V6Z" clip-rule="evenodd" />
        </svg>
      </span>
      Jadwal Praktikum
    </a>

    <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        </svg>
      </span>
      Inventaris Alat dan Bahan
    </a>

    <a href="{{ route('peminjaman-inventaris.index') }}" class="{{ request()->routeIs('peminjaman-inventaris.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
          <path fill-rule="evenodd" d="M3.087 9l.54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
        </svg>
      </span>
      Peminjaman Inventaris
    </a>
    @endif
    
    @if(auth()->user()->role === 'admin')
    <div class="section">ADMINISTRATOR</div>
    
    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
        </svg>
      </span>
      Manajemen User

    <a href="{{ route('rekap-praktikum.index') }}"
   class="{{ request()->routeIs('rekap-praktikum.*') ? 'active' : '' }}">
    <span class="icon">
        <i class="fa-solid fa-file-pdf"></i>
    </span>
    Laporan Kegiatan
</a>



    <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 5.389c-.42.18-.813.39-1.18.636l-1.874-.986a1.875 1.875 0 0 0-2.463.926l-.859 1.874a1.875 1.875 0 0 0 .61 2.512l1.649 1.101c-.02.245-.035.495-.035.749s.015.504.035.749l-1.649 1.101a1.875 1.875 0 0 0-.61 2.512l.858 1.874c.44.96 1.581 1.374 2.463.926l1.874-.986c.367.246.76.456 1.18.636l.178 1.572c.15.904.933 1.567 1.85 1.567h1.875c.916 0 1.699-.663 1.85-1.567l.178-1.572c.42-.18.813-.39 1.18-.636l1.874.986a1.875 1.875 0 0 0 2.463-.926l.859-1.874a1.875 1.875 0 0 0-.61-2.512l-1.649-1.101c.02-.245.035-.495.035-.749s-.015-.504-.035-.749l1.649-1.101a1.875 1.875 0 0 0 .61-2.512l-.858-1.874a1.875 1.875 0 0 0-2.463-.926l-1.874.986a7.17 7.17 0 0 0-1.18-.636l-.178-1.572a1.875 1.875 0 0 0-1.85-1.567h-1.875ZM12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9Z" clip-rule="evenodd" />
        </svg>
      </span>
      Pengaturan Website
    </a>
    @endif

    {{-- Logout --}}
    <div class="logout-wrapper">
        <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
              <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </span>
        Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
  </nav>
</aside>
