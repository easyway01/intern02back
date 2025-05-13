<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      display: flex;
      max-width: 900px;
      width: 100%;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
      border-radius: 10px;
      overflow: hidden;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      border-radius: 15px;
      padding: 50px;
    }

    @media (max-width: 768px) {
        .container {
            max-width: 700px;
            padding: 30px;
        }
    }

    .form-section {
      flex: 1;
      padding: 40px;
    }

    .form-section h2 {
      margin-bottom: 20px;
      font-size: 32px;
      text-align: center;
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      border-bottom: 1px solid #ccc;
    }

    .input-group i {
      margin-right: 10px;
      color: #999;
    }

    .input-group input {
      flex: 1;
      padding: 10px;
      border: none;
      outline: none;
      font-size: 16px;
    }

    .btn {
      background-color: #4da6ff;
      color: white;
      padding: 12px 20px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      transition: background 0.3s;
      width: 100%;
    }

    .btn:hover {
      background-color: #3399ff;
    }

    .image-section {
      flex: 1;
      background: #f9f9f9;
      text-align: center;
      padding: 30px;
    }

    .image-section img {
      max-width: 100%;
      height: auto;
    }

    .image-section p {
      margin-top: 15px;
      font-size: 14px;
    }

    .image-section a {
      color: #000;
      text-decoration: none;
    }

    .error-text {
      color: red;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .login-link {
      font-size: 14px;
      color: #007bff;
      text-decoration: none;
    }

    .login-link:hover {
      text-decoration: underline;
    }

    .toggle-password {
  cursor: pointer;
  margin-left: 10px;
  color: #999;
}

.form-tabs {
  display: flex;
  justify-content: center;
  margin-bottom: 30px;
}

.form-tabs .tab {
  padding: 10px 25px;
  text-decoration: none;
  font-size: 18px;
  border-radius: 5px;
  margin: 0 10px;
  transition: all 0.3s ease;
  color: #333;
  background-color: rgba(255, 255, 255, 0.4); /* 默认半透明 */
}

.form-tabs .tab.active {
  background-color: #4da6ff; /* 当前页亮色 */
  color: white;
  font-weight: bold;
  box-shadow: 0 0 8px rgba(0,0,0,0.1);
}

.home-button {
  position: fixed;
  top: 10px;
  left: 10px;
  background-color: or;
  color: white;
  padding: 2px 2px;
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  transition: background-color 0.3s ease;
  z-index: 1000;
}

.home-button:hover {
  background-color: #3399ff;
}

.close-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background: #ff4d4d; /* 红色背景 */
  border: none;
  font-size: 30px;
  cursor: pointer;
  color: #fff; /* 文字白色 */
  border-radius: 5px; /* ✅ 变成小圆角正方形，想完全直角就设成 0 */
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  z-index: 999;
  transition: background 0.3s;
}

.close-btn:hover {
  background: #ff1a1a; /* hover 时更深的红色 */
}
  </style>
</head>
<body>
  <div class="container">
  <button class="close-btn" onclick="window.location.href='/'">&times;</button>

    <!-- Left: Register Form -->
    <div class="form-section">
    <div class="form-tabs">
  <a href="{{ route('login') }}" class="tab {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
  <a href="{{ route('register') }}" class="tab {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
</div>

      <!-- Laravel Register Form -->
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-group">
          <i class="fa fa-user"></i>
          <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}">
        </div>
        @error('name')
          <div class="error-text">{{ $message }}</div>
        @enderror

        <!-- Email -->
        <div class="input-group">
          <i class="fa fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
        </div>
        @error('email')
          <div class="error-text">{{ $message }}</div>
        @enderror

<!-- Password -->
<div class="input-group">
  <i class="fa fa-lock"></i>
  <input type="password" name="password" id="password" placeholder="Password" required>
  <span class="toggle-password" onclick="togglePassword('password', this)">
    <i class="fa fa-eye"></i>
  </span>
</div>
@error('password')
  <div class="error-text">{{ $message }}</div>
@enderror


        <!-- Confirm Password -->
        <div class="input-group">
          <i class="fa fa-lock"></i>
          <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn">REGISTER</button>
        <!-- Already have an account? -->
        <div class="mt-4 text-sm text-gray-600">
            <br>
          {{ __("Already have an account?") }}
          <a href="{{ route('login') }}" class="login-link">{{ __('Login') }}</a>
        </div>
      </form>
    </div>

    <!-- Right: Illustration -->
    <div class="image-section">
      <img src="{{ asset('images/ll1.jpg') }}" alt="Desk Illustration" />
      <p>Create a new acccount</p>
    </div>
  </div>
</body>
<script>
  function togglePassword(inputId, toggleIcon) {
    const input = document.getElementById(inputId);
    const icon = toggleIcon.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>

</html>
