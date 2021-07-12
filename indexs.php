<?php

// Inisialisasi Sesi
session_start();

// Check jika pengguna sudah login, makan akan diarahakan ke Halaman Home
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome/");
    exit;
}
 
// Mengikutkan file Config.php
require_once "config.php";
require_once "login-system.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>FATechID - Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="login-style/images/icons/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login-style/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login-style/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login-style/vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="login-style/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login-style/vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="login-style/css/util.css">
    <link rel="stylesheet" type="text/css" href="login-style/css/main.css">
<!--===============================================================================================-->
</head>
<body>

        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="login-style/images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <span class="login100-form-title">
                        Member Login
                    </span>

                    <div class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" data-validate = "Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="username" placeholder="Email" value="<?php echo $username; ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>

                    <div class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" data-validate = "Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>

                    <td colspan="2"><font color="#D80B24"><?php echo $_SESSION['checking']; ?><?php echo $_SESSION['checking']="";?></font></td>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <span class="txt1">
                            Lupa
                        </span>
                        <a class="txt2" href="#">
                            Password?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="register">
                            Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    
<!--===============================================================================================-->  
    <script src="login-style/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="login-style/vendor/bootstrap/js/popper.js"></script>
    <script src="login-style/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="login-style/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="login-style/vendor/tilt/tilt.jquery.min.js"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
<!--===============================================================================================-->
    <script src="login-style/js/main.js"></script>

</body>
</html>