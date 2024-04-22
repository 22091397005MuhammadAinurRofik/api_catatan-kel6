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
  
// register
if (isset($_POST['sign-up'])) {
    if (register($_POST) > 0) {
        echo "
            <script>
                swal('Berhasil','Akun anda berhasil didaftarkan!','success');
            </script>
        ";
    } else {
        echo mysqli_error($koneksi);
    }
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
    <title>Register | Dompet-Qu</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/icon.png">
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
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
            background: url('img/login.png');
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
        <div class="row justify-content-md-center mt-12">
            <!-- Sign-up Section -->
            <div class="col-sm-6 p-0">
                <div class="card">
                    <div class="card-header">
                        <!-- Sign-up and Login Tabs -->
                        <div class="signup">
                            <h4 class="aktif">SIGN UP</h4>
                        </div>
                        <div>
                            <h4> / </h4>
                        </div>
                        <!-- Subtitle for Sign-up Section -->
                        <div class="sub-title">Registrasi untuk gunakan CatatanKu</div>
                    </div>
                    <!-- User Icon -->
                    <div class="icon-user">
                        <h4 class="fa fa-user"> </h4>
                    </div>
                    <!-- Sign-up Form -->
                    <div class="card-body">
                        <form method="POST">
                            <!-- Email Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input type="text" name="email-registrasi" class="form-control"
                                    placeholder="Email" autocomplete="off" required>
                            </div>
                            <!-- Username Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" name="username-registrasi" class="form-control"
                                    placeholder="Username" autocomplete="off" required>
                            </div>
                            <!-- Password Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" name="password-registrasi" class="form-control"
                                    placeholder="Password" autocomplete="off" required>
                            </div>
                            <!-- Confirm Password Input -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" name="password-confirm" class="form-control"
                                    placeholder="Confirm password" autocomplete="off" required>
                            </div>
                            <!-- Sign-up Button -->
                            <div>
                                <button type="submit" name="sign-up" class="btn btn-primary">Sign up</button>
                                <a href="login.php" class="btn btn-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Background Image for Sign-up Section -->
                <!-- <div class="img"></div> -->
            </div>
        </div>
    </div>
    <!-- Script for Slide Login -->
    <script src="js/slidelogin.js"></script>
</body>

</html>
