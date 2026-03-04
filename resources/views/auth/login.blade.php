<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — Si Lab MIPA</title>
  <link rel="stylesheet" href="{{ asset('backend/css/admin.css') }}" />
  <link rel="stylesheet" href="{{ asset('backend/css/auth.css') }}" />
</head>
<body style="background:url({{ asset('background_login.jpg') }})">

    <div class="login-card">
        <div class="login-header">
            <div style="margin-bottom: 1rem;">
                <!-- Logo -->
                <img src="{{ asset($appLogo) }}" alt="Logo" style="max-height: 100px; width: auto;">
            </div>
            <h1>Selamat Datang</h1>
            <p>{{ $appName }}</p>
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

            <button type="submit" class="btn-login">Masuk </button>
        </form>

        <div class="auth-links">
            <p style="color: var(--muted); margin: 0;">Belum punya akun? Hubungi Admin</p>
        </div>
    </div>

</body>
</html>
