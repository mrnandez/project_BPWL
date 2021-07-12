<?php

  require_once "../config.php";

  if (!empty($_GET['code']) && isset($_GET['code'])) {
      $code = $_GET['code'];
      $sql  = mysqli_query($link, "SELECT * FROM users WHERE token = '$code' ");
      $num  = mysqli_fetch_array($sql);

      if ($num>0) {
          $st=0;
          $result   = mysqli_query($link, "SELECT id FROM users WHERE token = '$code' and confirmation = '$st' ");
          $result4  = mysqli_fetch_array($result);

          if ($result4 > 0) {
              $st = 1;
              $result1  = mysqli_query($link, "UPDATE users SET confirmation = '$st' WHERE token = '$code' ");
  
              $msg      = "Akun anda telah aktif";
          } else {
              $msg      = "Akun anda sudah aktif, pengaktifan ulang tidak dibutuhkan lagi";
          }
      } else {
          $msg      = "Ada kesalahan dalam aktivasi kode.";
      }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FATechID - Email Confirmation</title>
  <!-- Favicon -->
  <link href="../assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link type="text/css" rel="stylesheet" href="../css/froala_blocks.css">


</head>
<body>

<section class="fdb-block">
      <div class="col-fill-left" style="background-image: url(../assets/img/theme/ty.png);">
      </div>
    
      <div class="container">
        <div class="row justify-content-end">
          <div class="col-12 col-md-5 text-center">
            <h1>Terima kasih telah mengaktifkan akun anda</h1>
            <p class="lead"><?php echo htmlentities($msg); ?></p>
    
            <p class="mt-4"><a href="../../projects">Klik disini untuk login <i class="fas fa-angle-right"></i></a></p>
          </div>
        </div>
      </div>
    </section>


  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Optional JS -->
  <script src="../assets/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="../assets/vendor/chart.js/dist/Chart.extension.js"></script>
  <!-- Argon JS -->
  <script src="../assets/js/argon.js?v=1.0.0"></script>
</body>
</html>