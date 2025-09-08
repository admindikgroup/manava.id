<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management DIK Group</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="icon" href="dist/img/icon.png">

  <style>
    .body-login {
      background-color: #0008;
      align-items: center;
      display: flex;
      flex-direction: column;
      height: 100vh;
      justify-content: center;
    }

    @media (min-width: 721px) {
      .login-page {
        background: url('img/login.png') no-repeat center center fixed;
        background-size: cover;
      }
    }

    @media (max-width: 720px) {
      .login-page {
        background: url('img/login-m.png') no-repeat center center fixed;
        background-size: cover;
      }
    }

    .or-color {
      color: white;
      margin-bottom: 10px;
    }

    .alert {
      background-color: #dc3545;
      color: white;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
      text-align: center;
    }

    .alert-success {
      background-color: #28a745;
    }
  </style>
</head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// if (!strpos($current_url, 'dikgroup.id/management/login.php') && !strpos($current_url, 'localhost/dggroup2/management/login.php')) {
//     header('Location: https://dikgroup.id/management/login.php');
//     exit;
// }
if(isset($_COOKIE['cookie_status'])) {
  $_SESSION['status'] = $_COOKIE['cookie_status'];
  $_SESSION['priv'] = $_COOKIE['priv'];
} 

if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("location:index.php");
    exit;
}
if (!file_exists('controller/conn.php')) {
    die("File conn.php tidak ditemukan");
}
include 'controller/conn.php';
if(isset($_SESSION['status'])){
if($_SESSION['status'] =="xx"){
?>



<?php }} ?>

<body class="hold-transition login-page dark-mode">
  <div class="row" style="width: 100%;">
    <div class="col-12 col-md-8"> </div>
    <div class="col-12 col-md-4 body-login">
      <div class="login-box">
        <div class="card card-primary" style="background-color: transparent;">
          <div class="card-body">
            <h1 style="color: white;" id="form-title">Hello,<br>Welcome back</h1>

            <div id="messageBox">
              <?php if (isset($_SESSION['status']) && $_SESSION['status'] == "xx"): ?>
                <div class="alert">Username / Password tidak sesuai!</div>
              <?php endif; ?>
            </div>

            <!-- LOGIN FORM -->
            <form id="loginForm" action="controller/conn_login.php" method="post" style="margin-top: 20px;">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Email / Username" name="username" required>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
              </div>
            </form>

            <!-- REGISTER FORM -->
            <form id="registerForm" style="display: none; margin-top: 20px;">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nama" name="nama" required>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
              </div>
              <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
              </div>
            </form>

            <!-- OTP FORM -->
            <form id="otpForm" style="display: none; margin-top: 20px;">
              <input type="hidden" id="otpEmail" name="email">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="otp" placeholder="Masukkan kode OTP" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-success btn-block">Verifikasi Email</button>
                </div>
              </div>
              <p id="resend-wrapper">
                <a href="#" id="resend-link" onclick="resendOTP(event)">Resend OTP</a>
                <span id="cooldown-text" style="display:none; color: gray;"></span>
              </p>
            </form>
            <!-- Forgot Password Link -->
            <p class="forgot-password text-center mb-1" style="margin-top: 10px;">
              <a href="forgot_password.php" style="color: white;">Forgot Password?</a>
            <!-- SOCIAL AUTH LINKS -->
            <div class="social-auth-link text-center mb-3" style="margin-top: 20px;">
              <p class="or-color">- OR -</p>
              <a href="controller/conn_googleoauth.php" class="btn btn-block btn-danger">
                <i class="fab fa-google mr-2"></i> Sign in using Google
              </a>
              <p class="mb-0" id="toggle-text">
                <span style="color: white">Don't have an account?</span>
                <a href="#" onclick="toggleForm()" class="btn-signup" id="toggle-link">Sign Up</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    function toggleForm() {
      const loginForm = document.getElementById('loginForm');
      const registerForm = document.getElementById('registerForm');
      const otpForm = document.getElementById('otpForm');
      const formTitle = document.getElementById('form-title');
      const toggleText = document.getElementById('toggle-text');
      const toggleLink = document.getElementById('toggle-link');

      if (registerForm.style.display === "none") {
        registerForm.style.display = "block";
        loginForm.style.display = "none";
        otpForm.style.display = "none";
        formTitle.innerHTML = "Create Account";
        toggleText.querySelector('span').innerText = "Already have an account?";
        toggleLink.innerText = "Login";
      } else {
        registerForm.style.display = "none";
        loginForm.style.display = "block";
        otpForm.style.display = "none";
        formTitle.innerHTML = "Hello,<br>Welcome back";
        toggleText.querySelector('span').innerText = "Don't have an account?";
        toggleLink.innerText = "Sign Up";
      }
    }

    $('#registerForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: 'controller/conn_register.php',
        type: 'POST',
        data: $(this).serialize(),
         dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          $('#messageBox').html('<div class="alert alert-success">' + res.message + '</div>');
          $('#registerForm').hide();
          $('#otpForm').show();
          $('#otpEmail').val($('input[name="email"]').val());
        } else {
         $('#messageBox').html('<div class="alert">' + res.message + '</div>');
        }
      },
      });
    });

 $('#otpForm').on('submit', function (e) {
  e.preventDefault();
  $.ajax({
    url: 'controller/verify_otp.php',
    type: 'POST',
    data: $(this).serialize(),
    dataType: 'json',
    success: function (res) {
      if (res.status === 'success') {
        $('#messageBox').html(`<div class="alert alert-success">${res.message}</div>`);
        $('#otpForm').hide();
        $('#loginForm').show();
      } else {
        $('#messageBox').html(`<div class="alert">${res.message}</div>`);
      }
    },
    error: function (xhr) {
      let res = xhr.responseJSON;
      if (res && res.message) {
        $('#messageBox').html(`<div class="alert">${res.message}</div>`);
      } else {
        $('#messageBox').html('<div class="alert">Terjadi kesalahan saat verifikasi OTP.</div>');
      }
    }
  });
});
let cooldown = 60; // cooldown 60 detik
  let timer;

  function resendOTP(event) {
    event.preventDefault();

    // Disable link
    document.getElementById("resend-link").style.display = "none";
    document.getElementById("cooldown-text").style.display = "inline";

    let remaining = cooldown;
    document.getElementById("cooldown-text").innerText = `Coba lagi dalam ${remaining}s`;

    timer = setInterval(() => {
      remaining--;
      if (remaining > 0) {
        document.getElementById("cooldown-text").innerText = `Coba lagi dalam ${remaining}s`;
      } else {
        clearInterval(timer);
        document.getElementById("resend-link").style.display = "inline";
        document.getElementById("cooldown-text").style.display = "none";
      }
    }, 1000);

    fetch("controller/conn_resend_otp.php", { method: "POST" })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      alert(data.message);
    } else {
      alert("Error: " + data.message);
    }
  })
  .catch(err => console.error(err));
  }
  </script>
</body>
</html>