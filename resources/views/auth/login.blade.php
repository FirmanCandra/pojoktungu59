<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin — Pojok Informasi</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root{--blue:#145bd7;--ink:#13213d;--line:#e4eaf3}
    *{box-sizing:border-box}
    body{margin:0;font-family:'DM Sans',sans-serif;color:var(--ink);background:linear-gradient(#f9fbff,#e7f0ff);min-height:100vh;display:grid;place-items:center;padding:20px}
    .login-box{background:#fff;width:100%;max-width:400px;border:1px solid var(--line);border-radius:10px;text-align:center;padding:42px 32px;box-shadow:0 10px 30px rgba(20,91,215,.08)}
    .wp{width:58px;height:58px;background:#1972d0;color:#fff;border:4px solid #b8d9ff;border-radius:50%;margin:0 auto 12px;display:grid;place-items:center;font-family:serif;font-size:32px;font-weight:700}
    .login-box h2{margin:0 0 4px;font-size:20px}
    .login-box p{font-size:12px;color:#748096;margin:0 0 24px}
    .login-box label{text-align:left;display:block;font-size:11px;font-weight:600;margin:14px 0 4px;color:#46536b}
    .login-box input[type="email"],.login-box input[type="password"]{display:block;width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:4px;font:inherit;font-size:12px}
    .login-box input:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(20,91,215,.1)}
    .remember{display:flex;justify-content:space-between;align-items:center;font-size:10px;margin:12px 0 20px}
    .remember label{display:flex;align-items:center;gap:6px;margin:0;font-weight:400}
    .remember input{margin:0}
    .primary{background:var(--blue);color:#fff;border-radius:4px;padding:10px;font-size:12px;border:none;cursor:pointer;width:100%;font-weight:600;transition:background .2s}
    .primary:hover{background:#0f4bb8}
    .back{display:block;margin-top:20px;font-size:11px;color:var(--blue);text-decoration:none}
    .error-msg{color:#dc2626;font-size:11px;text-align:left;margin-top:4px}
  </style>
</head>
<body>
  <div class="login-box">
    <img src="{{ asset('images/logo.jpg') }}" alt="Logo KKN 59" style="width:72px;height:72px;border-radius:50%;object-fit:cover;margin:0 auto 12px;display:block;border:3px solid #b8d9ff;box-shadow:0 4px 12px rgba(20,91,215,0.15)">
    <h2>Login Admin</h2>
    <p>Masuk untuk mengelola website Pojok Informasi</p>

    @if(session('status'))
      <div style="background:#e8f5e9;color:#2e7d32;padding:8px;border-radius:4px;font-size:11px;margin-bottom:12px">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div>
        <label for="email">Alamat Email Admin</label>
        <input type="email" id="email" name="email" value="{{ old('email', 'admin@pojok.id') }}" required autofocus autocomplete="username" placeholder="admin@pojok.id" />
        @error('email') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
      </div>

      <div class="remember">
        <label><input type="checkbox" name="remember" /> Ingat saya</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" style="color:var(--blue);text-decoration:none">Lupa password?</a>
        @endif
      </div>

      <button type="submit" class="primary">Login ke Admin Panel</button>
    </form>

    <a class="back" href="{{ route('home') }}">← Kembali ke Beranda Website</a>
  </div>
</body>
</html>
