<?php 
    session_start();
    require "function/functions.php";
    
    // session dan cookie multilevel user
    if(isset($_COOKIE['login'])) {
        if ($_COOKIE['level'] == 'user') {
            $_SESSION['login'] = true;
            $ambilNama = $_COOKIE['login'];
        } 
        
        elseif ($_COOKIE['level'] == 'admin') {
            $_SESSION['login'] = true;
            header('Location: administrator');
        }
    } 

    elseif ($_SESSION['level'] == 'user') {
        $ambilNama = $_SESSION['user'];
    } 
    
    else {
        if ($_SESSION['level'] == 'admin') {
            header('Location: administrator');
            exit;
        }
    }

    if(empty($_SESSION['login'])) {
        header('Location: login');
        exit;
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/icon.png">
    <title>CatatanKu - Laporan</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/styler.css?v=1.0">
    <link rel="stylesheet" href="css/dashboard.css?v=1.0">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/chart.js"></script>
</head>

<body>
<div class="header">
        <div class="left">
            <img src="img/icon.png" width="50px" height="50px" class="float-left logo">
            <h3 class="text-secondary font-weight-bold float-left logo">CatatanKu</h3>
        </div>
        <div class="right">
            <h5 class="admin">Selamat Datang - <?= substr($ambilNama, 0, 7) ?></h5>
            <a href="logout">
                <div class="logout">
                    <i class="fas fa-sign-out-alt float-right log"></i>
                    <!-- <p class="float-right logout">Logout</p> -->
                </div>
            </a>
        </div>
    </div>

    <div class="sidebar">
        <nav>
            <ul>
                <!-- fungsi slide -->
                <script>
                    $(document).ready(function () {
                        $("#flip").click(function () {
                            $("#panel").slideToggle("medium");
                            $("#panel2").slideToggle("medium");
                        });
                        $("#flip2").click(function () {
                            $("#panel3").slideToggle("medium");
                            $("#panel4").slideToggle("medium");
                        });
                    });
                </script>
                <!-- dashboard -->
                <a href="dashboard" style="text-decoration: none;">
                    <li>
                        <div>
                            <span class="fas fa-home"></span>
                            <span>Dashboard</span>
                        </div>
                    </li>
                </a>

                <!-- data -->
                <a href="pemasukkan" style="text-decoration: none;">
                    <li>
                        <div>
                            <span><i class="fas fa-money-bill-wave"></i></span>
                            <span>Data Pemasukkan</span>
                        </div>
                    </li>
                </a>

                <a href="pengeluaran" style="text-decoration: none;">
                    <li>
                        <div>
                            <span><i class="fas fa-hand-holding-usd"></i></span>
                            <span>Data Pengeluaran</span>
                        </div>
                    </li>
                </a>
                <!-- data -->

                <!-- laporan -->
                <a href="laporan" style="text-decoration: none;">
                    <li class="aktif" style="border-left: 5px solid #306bff;">
                        <div>
                            <span><i class="fas fa-clipboard-list"></i></span>
                            <span>Laporan</span>
                        </div>
                    </li>
                </a>

                <!-- change icon -->
                <script>
                    $(".klik").click(function () {
                        $(this).find('i').toggleClass('fa-caret-up fa-caret-right');
                        if ($(".klik").not(this).find("i").hasClass("fa-caret-right")) {
                            $(".klik").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
                        }
                    });
                    $(".klik2").click(function () {
                        $(this).find('i').toggleClass('fa-caret-up fa-caret-right');
                        if ($(".klik2").not(this).find("i").hasClass("fa-caret-right")) {
                            $(".klik2").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
                        }
                    });
                </script>
                <!-- change icon -->
            </ul>
        </nav>
    </div>

    <div class="main-content khusus">
        <div class="konten khusus2">
            <div class="konten_dalem khusus3">
                <h2 class="heade" style="color: #4b4f58;">Laporan</h2>
                <input type="hidden" id="username" value="<?= $ambilNama ?>">
                <hr style="margin-top: -2px;">
                
                <div class="table-responsive">
                    <table class="laporan">
                            <tr>
                                <td>Jenis laporan</td>
                                <td colspan="3">
                                    <select id="jenis-laporan" class="form-control">
                                        <option value="pemasukkan">Pemasukkan</option>
                                        <option value="pengeluaran">Pengeluaran</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Pilih tanggal</td>
                                <td><input type="date" id="awal" class="form-control control"></td>
                                <td>sampai</td>
                                <td><input type="date" id="akhir" class="form-control control"></td>
                                <td><button class="btn btn-primary lapor">Tampilkan</button></td>
                            </tr>
                    </table>
                </div>

                <div class="tampil"></div>
                
            </div>
        </div>
    </div>

    <script src="ajax/js/laporan.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>