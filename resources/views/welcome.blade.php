<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Inventory System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-card {
      max-width: 400px;
      width: 100%;
      padding: 2rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background: white;
      border-radius: 10px;
    }
    .error-message {
      color: #dc3545;
      font-size: 0.875rem;
      margin-top: 5px;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h3 class="text-center mb-4">Login</h3>
  
  <form action="{{ route('login') }}" method="POST">
    @csrf

    <!-- Email -->
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
      @error('email')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
      @error('password')
        <div class="error-message">{{ $message }}</div>
      @enderror
    </div>

    <!-- Remember me -->
    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="remember" name="remember">
      <label class="form-check-label" for="remember">Remember me</label>
    </div>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary w-100">Login</button>
  </form>
</div>

</body>
</html>
