<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <!-- Styles -->
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

    body {
      background: linear-gradient(135deg, #0060a0, #03396c);
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #ffffff;
    }

    .login-container {
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      color: #333333;
    }

    .login-container h2 {
      margin-bottom: 25px;
      color: #1e3a8a;
      text-align: center;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #555555;
      font-weight: 500;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #cccccc;
      border-radius: 6px;
      font-size: 15px;
      background-color: #f9f9f9;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus {
      border-color: #2563eb;
      outline: none;
    }

    .login-btn {
      width: 100%;
      padding: 12px;
      background-color: #2563eb;
      color: #ffffff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .login-btn:hover {
      background-color: #1e3a8a;
    }

    .redirect-container {
      text-align: center;
      margin-top: 15px;
    }

    .redirect-container a {
      color: #2563eb;
      text-decoration: none;
      font-weight: 500;
    }

    .redirect-container a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" action="javascript:void(0);">
      <div class="form-group">
        <label for="email">User Email</label>
        <input
          type="text"
          id="email"
          name="email"
          placeholder="Enter your email"
          required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          required />
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
    <div class="redirect-container">
      <p>Don't have an account? <a href="register.html">Register here</a></p>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" crossorigin="anonymous"></script>
  <script src="main.js"></script>
</body>

</html>