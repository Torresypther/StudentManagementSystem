<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html,
    body {
      height: 100%;
      font-family: 'Inter', sans-serif;
      background-color: #1a1d4c;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .left-panel {
      flex: 1;
      position: relative;
      background: linear-gradient(to bottom right, #1a1d4c, #1e293b);
      color: #f8fafc;
      padding: 60px 40px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-top-left-radius: 20px;
      border-bottom-left-radius: 20px;
      overflow: hidden;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("data:image/svg+xml,%3Csvg width='100%' height='100%' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,100 Q50,130 100,100 T200,100' fill='none' stroke='white' stroke-opacity='0.06' stroke-width='6'/%3E%3Cpath d='M0,130 Q50,160 100,130 T200,130' fill='none' stroke='white' stroke-opacity='0.05' stroke-width='4'/%3E%3Cpath d='M0,160 Q50,190 100,160 T200,160' fill='none' stroke='white' stroke-opacity='0.04' stroke-width='2'/%3E%3C/svg%3E");
      background-repeat: repeat;
      background-size: cover;
      z-index: 0;
    }

    .left-panel>* {
      position: relative;
      z-index: 1;
    }


    .left-panel .quote-header {
      font-size: 13px;
      letter-spacing: 2px;
      text-transform: uppercase;
      opacity: 0.8;
      color: #94a3b8;
    }

    .left-panel .quote-main {
      font-size: 42px;
      font-weight: 700;
      line-height: 1.2;
      color: #f1f5f9;
    }

    .left-panel .quote-sub {
      margin-top: 10px;
      font-size: 15px;
      color: #cbd5e1;
      max-width: 320px;
    }

    .right-panel {
      flex: 1;
      background-color: #eef4ff;
      padding: 60px 40px;
      border-top-right-radius: 20px;
      border-bottom-right-radius: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 40px;
      color: #1a1d4c;
    }

    .right-panel h2 {
      font-size: 30px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #1a1d4c;
    }

    .right-panel p {
      margin-bottom: 30px;
      color: #475569;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 6px;
      display: block;
      color: #334155;
    }

    .form-group input {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      background-color: #fff;
      font-size: 15px;
      color: #1e293b;
    }

    .form-group input:focus {
      outline: 2px solid #2b319a;
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      font-size: 14px;
      color: #475569;
    }

    .form-options input {
      margin-right: 6px;
    }

    .form-options a {
      color: #363ccc;
      text-decoration: none;
    }

    .form-options a:hover {
      text-decoration: underline;
    }
    .btn-primary {
      width: 100%;
      padding: 12px;
      background-color: #1a1e4c;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-bottom: 15px;
      transition: background 0.3s;
    }

    .btn-primary:hover {
      background-color:rgb(28, 33, 90);
    }

    .signup-link {
      text-align: center;
      font-size: 14px;
      margin-top: 15px;
      color: #475569;
    }

    .signup-link a {
      color: #363ccc;
      text-decoration: none;
      font-weight: 500;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }

    @media screen and (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left-panel,
      .right-panel {
        border-radius: 0;
      }
    }
  </style>

</head>

<body>
  <div class="container">
    <!-- Left Side -->
    <div class="left-panel">
      <div>
        <div class="quote-header">A WISE QUOTE</div>
      </div>
      <div>
        <div class="quote-main">Conquer<br>Your Tasks<br>One by One</div>
        <div class="quote-sub">Success is built by completing small tasks consistently — focus, act, and the results will follow.</div>
      </div>

    </div>

    <!-- Right Side -->
    <div class="right-panel">
      <div class="logo">Task Tracker</div>
      <h2>Welcome Back</h2>
      <p>Enter your email and password to access your account</p>
      <form id="loginForm" action="javascript:void(0);">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="Enter your email" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Enter your password" required />
        </div>
        <div class="form-options">
          <label><input type="checkbox" /> Remember me</label>
          <a href="">Forgot Password</a>
        </div>
        <button type="submit" class="btn-primary">Sign In</button>
        <div class="signup-link">
          Don’t have an account? <a href="register.html">Sign Up</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" crossorigin="anonymous"></script>
  
  <script src="main.js"></script>

</body>

</html>