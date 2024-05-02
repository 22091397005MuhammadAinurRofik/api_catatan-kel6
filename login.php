<?php 
session_start();
require 'function/functions.php'; 
require 'function/loginRegister.php';

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT username FROM users WHERE id_user = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: dashboard");
    exit;
} elseif (isset($_COOKIE['login'])) {
    header("Location: dashboard");
    exit;
}

// login
if (isset($_POST['login'])) {
    login($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Title -->
    <title>Login | CatatanKu</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/icon.png">
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/tambah.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- SweetAlert Library -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Internal Styles -->
    <style>
        body {
            /* background: url('img/body.png'); */
            background-color: #191717;
            /* Background image for the body */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: "roboto", sans-serif;
            /* Font family for the body text */
        }

        .img {
            /* background: url('img/login.png'); */
            /* Background image for the login section */
            background-size: cover;
            background-position: center;
            height: 100%;
            top: 0;
            position: absolute;
            width: 100%;
            z-index: 2;
        }
    </style>
</head>

<body>
   <!-- Main Container -->
<div class="container">
    <div class="center">
        <!-- Login Section -->
        <div class="card">
            <div class="card-header">
                <!-- Login Tab -->
                <div class="login">
                    <h4 class="aktif">LOGIN</h4>
                </div>
                <!-- Subtitle for Login Section -->
                <!-- <div class="sub-title">Login untuk gunakan CatatanKu</div> -->
            </div>
            
            <!-- Login Form -->
            <div class="card-body">
                <form method="POST">
                    <!-- Username or Email Input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input type="text" name="user-email" class="form-control" placeholder="Username / email" autocomplete="off" required>
                    </div>
                    <!-- Password Input -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>
                        <input type="password" name="password-login" class="form-control" placeholder="Password" required>
                    </div>
                    <!-- Remember Me Checkbox -->
                    <div class="form-group">
                        <label class="mz-check">
                            <input type="checkbox" name="rememberme">
                            <i class="mz-blue"></i>
                            Remember Me
                        </label>
                    </div>
                    <!-- Login Button -->
                    <button type="submit" name="login" class="btn btn-primary" style="margin-top: -15px">Login</button>
                </form>
                <div class="input-group mt-3"><h6 >Belum punya akun?<a href="register.php">Register</a></h6></div>
            </div>
        </div>
    </div>
</div>
    <!-- Script for Slide Login -->
    <script src="js/slidelogin.js"></script>
</body>

</html>
