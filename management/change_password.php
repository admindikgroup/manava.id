<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>

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
if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: login.php");
    exit;
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
            <h1 class="login-box-msg" style="color: white; font-size: 25px; font-weight: bold;">Change Your Password</h1>
            
            <!--Forget Form-->
            <form id="loginForm" action="controller/conn_change_password.php" method="post" style="margin-top: 10px;">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES); ?>">
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
              </div>
                <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" required>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block" style="margin-top: 20px;">Change Password</button>
                </div>
              </div>
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
  </script>
</body>
</html>