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
    
    $totalPemasukan = query("SELECT * FROM pemasukkan WHERE username = '$ambilNama'");
    $totalPengeluaran = query("SELECT * FROM pengeluaran WHERE username = '$ambilNama'");
    
    foreach ( $totalPemasukan as $rowMasuk ) {
        $hargaMasuk[] = $rowMasuk["jumlah"];
        $convertHarga = str_replace('.', '', $hargaMasuk);
        $totalMasuk = array_sum($convertHarga);
    }

    foreach ( $totalPengeluaran as $rowKeluar ) {
        $hargaKeluar[] = $rowKeluar["jumlah"];
        $convertHarga2 = str_replace('.', '', $hargaKeluar);
        $totalKeluar = array_sum($convertHarga2);
    }

    global $totalMasuk, $totalKeluar;
    $saldo = $totalMasuk - $totalKeluar;
    $saldoFix = number_format($saldo, 0, ',', '.'); 

    $month = date('m');
    $day = date('d');
    $year = date('Y');
    
    $today = $year . '-' . $month . '-' . $day;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/icon.png">
    <title>CatatanKu - Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
    <link rel="stylesheet" href="css/styler.css?v=1.0">
    <link rel="stylesheet" href="css/dashboard.css?v=1.0">
    <script src="js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="js/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

    <style>
    
.rentang {
    padding-bottom: 75px;
}
    </style>
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
                    <li class="aktif" style="border-left: 5px solid #306bff;">
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
                    <li>
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
                <h2 class="heade" style="color: #4b4f58;">Dashboard</h2>
                <hr style="margin-top: -2px;">
                <div class="container" id="container" style="border: none;">
                    <div class="row tampilCardview" id="row">

                        <div class="col-md-4 jarak">
                            <div class="card card-stats card-warning" style="background: #347ab8;">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="fas fa-wallet ikon"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center tulisan">
                                            <div class="numbers">
                                                <p class="card-category ket head">Sisa Saldo</p>
                                                <h4 class="card-title ket total">Rp. <?=$saldoFix;?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 jarak">
                                <div class="card card-stats card-warning" style="background: #d95350;">
                                    <div class="card-body ">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="icon-big text-center">
                                                    <i class="fa fa-file-invoice-dollar ikon"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 d-flex align-items-center tulisan">
                                                <div class="numbers">
                                                    <p class="card-category ket head">Pengeluaran</p>
                                                    <?php foreach ($totalPengeluaran as $row) : ?>
                                                    <?php
                                                        $hargaPengeluaran[] = $row["jumlah"];
                                                        $hargaConvert = str_replace('.', '', $hargaPengeluaran);
                                                        $totalPeng = array_sum($hargaConvert);
                                                        $hasilHargaPengeluaran = number_format($totalPeng, 0, ',', '.');   
                                                    ?>                                     
                                                    <?php endforeach; ?>

                                                    <?php global $hasilHargaPengeluaran;
                                                    if ( $hasilHargaPengeluaran != "" ) : ?>
                                                    <h4 class="card-title ket total">Rp. <?= $hasilHargaPengeluaran; ?></h4>
                                                    <?php else : ?>
                                                    <h4 class="card-title ket total">Rp. 0</h4>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="col-md-4 jarak">
                                <div class="card card-stats card-warning" style="background: #5db85b;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="icon-big text-center">
                                                    <i class="fa fa-hand-holding-usd ikon"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 d-flex align-items-center tulisan">
                                                <div class="numbers">
                                                    <p class="card-category ket head">Pemasukkan</p>
                                                    <?php foreach ($totalPemasukan as $row) : ?>
                                                        <?php
                                                            $hargaPemasukkan[] = $row["jumlah"];
                                                            $hargaConvert = str_replace('.', '', $hargaPemasukkan);
                                                            $totalPem = array_sum($hargaConvert);
                                                            $hasilHarga = number_format($totalPem, 0, ',', '.');    
                                                        ?>     
                                                    <?php endforeach ?>

                                                    <?php global $hasilHarga;
                                                    if ( $hasilHarga != "" ) : ?>
                                                    <h4 class="card-title ket total">Rp. <?= $hasilHarga ?> </h4>
                                                    <?php else : ?>
                                                    <h4 class="card-title ket total">Rp. 0 </h4>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

    <!-- banyak modal -->
    <!-- <script>
        $('#openBtn').click(function () {
            $('#myModal2').modal({
                show: true
            });
        })
        $('#openBtn2').click(function () {
            $('#myModal3').modal({
                show: true
            });
        })
        $('#openBtn3').click(function () {
            $('#myModal4').modal({
                show: true
            });
        })
        $('#openBtn4').click(function () {
            $('#myModal5').modal({
                show: true
            });
        })
    </script>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ["Saldo masuk", "Saldo keluar"],
                datasets: [{
                    label: 'Data rekening',
                    data: [
                        <?= $totalRekIn ?>, 
                        <?= $totalRekOut ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
    </script> -->

    <script src="js/bootstrap.js"></script>
    <script src="js/kirimNoRek.js"></script>
    <script src="ajax/js/tambahRekeningIn.js"></script>
    <script src="ajax/js/tambahRekeningOut.js"></script>
</body>

</html>