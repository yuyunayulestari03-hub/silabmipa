@php
  $isActive = fn($name) => request()->routeIs($name) ? 'active' : '';
@endphp

<aside class="sidebar">
  <div class="brand">
    <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height: 40px; width: auto;">
    <div class="title">
      <strong>SI LAB MIPA</strong>
      <span>Laboratorium IPA</span>
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
    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
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
      Jadwal Pratikum
    </a>

    <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
        </svg>
      </span>
      Inventaris Alat dan Bahan
    </a>
    @endif
    
    @if(auth()->user()->role === 'admin')
    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
      <span class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
          <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
        </svg>
      </span>
      Manajemen User
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
