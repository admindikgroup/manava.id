<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'controller/conn.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Otp Code</title>

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
<body class="hold-transition login-page dark-mode">
  <div class="row" style="width: 100%;">
    <div class="col-12 col-md-8"> </div>
    <div class="col-12 col-md-4 body-login">
      <div class="login-box">
        <div class="card card-primary" style="background-color: transparent;">
          <div class="card-body">
            <p class="login-box-msg or-color">Masukkan kode OTP yang telah dikirim ke email Anda.</p>
            
            <!-- tempat pesan -->
            <div id="messageBox"></div>

            <form id="otpForm" style="margin-top: 20px;">
              <input type="hidden" id="otpEmail" name="email">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="otp" placeholder="Masukkan kode OTP" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-success btn-block">Verifikasi Email</button>
                </div>
              </div>
              <p id="resend-wrapper" class="text-center" style="margin-top: 10px;">
                <a href="#"  id="resend-link" onclick="resendOTP(event)">Resend OTP</a>
                <span id="cooldown-text" style="display:none; color: gray;"></span>
              </p>
            </form>
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
  // isi hidden email dari URL query
  $(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get('email');
    if (email) {
      $('#otpEmail').val(decodeURIComponent(email));
    }
  });

  // === Submit OTP ===
  $('#otpForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: 'controller/verify_otp.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          $('#messageBox').html(`<div class="alert-success alert">${res.message}</div>`);
          setTimeout(() => {
            window.location.href = "login.php";
          }, 1500);
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

  // === Resend OTP ===
  let cooldown = 60;
  let timer;

  function resendOTP(event) {
    event.preventDefault();

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

    // kirim ulang otp dengan email
    fetch("controller/conn_resend_otp.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "email=" + encodeURIComponent($('#otpEmail').val())
    })
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
