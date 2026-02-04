<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — Si Lab MIPA</title>
  <link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/css/auth.css') }}" />
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div style="margin-bottom: 1rem;">
                @if(isset($appLogo) && strpos($appLogo, 'backend/img/logo.svg') === false)
                    <img src="{{ asset($appLogo) }}" alt="Logo" style="height: 60px; width: auto;">
                @else
                    <!-- Default Logo placeholder or Icon -->
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 3h10l-1 3H8L7 3z"/>
                        <path d="M5 6h14v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6z"/>
                        <path d="M16 13l-4 4-4-4"/>
                        <path d="M12 17V13"/>
                    </svg>
                @endif
            </div>
            <h1>Selamat Datang</h1>
            <p>LAB MIPA</p>
        </div>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" required autofocus placeholder="nama@email.com" value="{{ old('email') }}">
                @error('email')
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>
                    <a href="#" style="font-size: 0.8rem; color: var(--muted);">Lupa Password?</a>
                </div>
                <input type="password" id="password" name="password" class="form-input" required placeholder="••••••••">
                @error('password')
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width: 1rem; height: 1rem; border-radius: 4px; border: 1px solid var(--border); accent-color: var(--primary);">
                <label for="remember" style="font-size: 0.9rem; color: var(--muted); cursor: pointer; user-select: none;">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk ke Dashboard</button>
        </form>

        <div class="auth-links">
            <p style="color: var(--muted); margin: 0;">Belum punya akun? <a href="#">Hubungi Admin</a></p>
        </div>
    </div>

</body>
</html>
