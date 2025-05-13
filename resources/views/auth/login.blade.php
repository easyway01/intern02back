<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
      position: relative;
    }

    @media (max-width: 768px) {
      .container {
        max-width: 700px;
        padding: 30px;
        flex-direction: column;
      }
      .image-section {
        display: none;
      }
    }

    .form-section {
      flex: 1;
      padding: 40px;
    }

    .form-section h2 {
      margin-bottom: 20px;
      font-size: 32px;
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
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
    }

    .btn {
      background-color: #4da6ff;
      color: white;
      padding: 12px 20px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      transition: background 0.3s;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #3399ff;
    }

    .form-footer {
      margin-top: 20px;
      font-size: 14px;
    }

    .form-footer a {
      color: #007bff;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }

    .remember-me {
      margin-top: 10px;
      font-size: 14px;
    }

    .remember-me input {
      margin-right: 5px;
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

    .error-text {
      color: red;
      font-size: 13px;
      margin-bottom: 10px;
    }

    .status-message {
      margin-bottom: 15px;
      font-size: 14px;
      color: green;
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
      background-color: rgba(255, 255, 255, 0.4);
    }

    .form-tabs .tab.active {
      background-color: #4da6ff;
      color: white;
      font-weight: bold;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }

    .close-btn {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #ff4d4d;
      border: none;
      font-size: 30px;
      cursor: pointer;
      color: #fff;
      border-radius: 5px;
      width: 40px;
      height: 40px;
      line-height: 40px;
      text-align: center;
      z-index: 999;
      transition: background 0.3s;
    }

    .close-btn:hover {
      background: #ff1a1a;
    }

    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <button class="close-btn" onclick="window.location.href='/'">&times;</button>

    <div class="form-section">
      <div class="form-tabs">
        <a href="{{ route('login') }}" class="tab {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
        <a href="{{ route('register') }}" class="tab {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
      </div>

      @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" id="loginForm" autocomplete="on">
        @csrf

        <!-- Email -->
        <label for="emailInput" class="visually-hidden">Email</label>
        <div class="input-group">
          <i class="fa fa-envelope"></i>
          <input type="text" name="email" id="emailInput" list="emailSuggestions" placeholder="Your Email" required>
<datalist id="emailSuggestions"></datalist>

        </div>
        @error('email')
          <div class="error-text">{{ $message }}</div>
        @enderror

        <!-- Password -->
        <label for="password" class="visually-hidden">Password</label>
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

        <!-- Remember Me -->
        <div class="remember-me">
          <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            {{ __('Remember me') }}
          </label>
        </div>

        <button type="submit" class="btn">SUBMIT</button>

        <div class="form-footer">
          <p>{{ __("Don't have an account?") }} <a href="{{ route('register') }}">{{ __('Register') }}</a></p>
          <br>
          <p><a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a></p>
        </div>
      </form>
    </div>

    <div class="image-section">
      <img src="{{ asset('images/ll1.jpg') }}" alt="Welcome Image" />
      <p>Welcome Back!</p>
    </div>
  </div>

  <script>
    const EMAIL_HISTORY_KEY = 'emailHistory';
    const EMAIL_MAX_SUGGESTIONS = 5;

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

    window.addEventListener('DOMContentLoaded', () => {
      const emailInput = document.querySelector('input[name="email"]');
      const passwordInput = document.querySelector('input[name="password"]');
      const savedEmail = localStorage.getItem('savedEmail');

      if (savedEmail) {
        emailInput.value = savedEmail;
        passwordInput.focus();
      } else {
        emailInput.focus();
      }

      const emailSuggestions = document.getElementById('emailSuggestions');
      const savedEmails = JSON.parse(localStorage.getItem(EMAIL_HISTORY_KEY)) || [];

      function updateSuggestions(inputValue) {
        emailSuggestions.innerHTML = '';
        const domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'];
        domains.forEach(domain => {
          if (!inputValue.includes('@')) {
            const option = document.createElement('option');
            option.value = `${inputValue}@${domain}`;
            emailSuggestions.appendChild(option);
          }
        });

        savedEmails.forEach(email => {
          if (email.startsWith(inputValue)) {
            const option = document.createElement('option');
            option.value = email;
            emailSuggestions.appendChild(option);
          }
        });
      }

      emailInput.addEventListener('input', () => {
  console.log("Input changed:", emailInput.value);
  updateSuggestions(emailInput.value.trim());
});


      updateSuggestions('');

      document.getElementById('loginForm').addEventListener('submit', () => {
        const email = emailInput.value.trim();
        if (email && !savedEmails.includes(email)) {
          savedEmails.unshift(email);
          if (savedEmails.length > EMAIL_MAX_SUGGESTIONS) savedEmails.pop();
          localStorage.setItem(EMAIL_HISTORY_KEY, JSON.stringify(savedEmails));
        }

        const submitBtn = document.querySelector('.btn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Logging in...';
      });
    });
  </script>
</body>
</html>
