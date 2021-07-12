<?php

// Mendefenisikan variabel dan analisis ketika Value kosong
$username = $password = "";
$username_err = $password_err = "";
 
// Memproses data form, ketika form di submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ret= mysqli_query($link, "SELECT * FROM users WHERE username='$username' and password='$password'");
    $num=mysqli_fetch_array($ret);

    $confirmation=$num['confirmation'];

    
    // Check jika username kosong
    if (empty(trim($_POST["username"]))) {
        $username_err = "Silahkan masukkan email anda.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check jika password kosong
    if (empty(trim($_POST["password"]))) {
        $password_err = "Silahkan masukkan password anda.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validasi Krendensial
    if (empty($username_err) && empty($password_err)) {

        // Mempersiapkan stekmen yang dipilih
        $sql = "SELECT id, firstname, lastname, gender, username, password, status, confirmation FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {

            // Mem-bind variabel ke stekmen yang sudah disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Membuat parameter
            $param_username = $username;
            
            // Mencoba eksekusi stekmen yang sudah disiapkan
            if (mysqli_stmt_execute($stmt)) {

                /* Menyimpan Hasil */
                mysqli_stmt_store_result($stmt);
 
                // Check jika username sudah terdartar, jika sudah maka verifikasi password
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    // Mem-bind hasil variabel
                    mysqli_stmt_bind_result($stmt, $id, $firstname, $lastname, $gender, $username, $hashed_password, $status, $confirmation);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            if ($confirmation == 0) {
                                $_SESSION['checking'] = "Silahkan verifikasi akun kamu terlebih dahulu pada inbox email kamu.";
                            } else {

                            // Password benar, maka akan memulai sesi baru
                                session_start();

                                // Menyimpan data dalam sesi Variabel
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["firstname"] = $firstname;
                                $_SESSION["lastname"] = $lastname;
                                $_SESSION["username"] = $username;
                                $_SESSION["status"] = $status;
                                $_SESSION["gender"] = $gender;
                                $_SESSION["confirmation"] = $confirmation;
                            
                                // Meng-redirect ke Halaman Home
                                header("location: welcome/index.php");
                            }
                        } else {

                            // Menampilkan error, jika password yang dimasukkan salah
                            $password_err = "Password yang anda masukkan salah, silahkan periksa kembali.";
                        }
                    }
                } else {

                    // Menampilkan error, jika username yang dimasukkan tidak ada
                    $username_err = "Tidak ada akun dengan email tersebut.";
                }
            } else {
                echo "Oops! Ada yang salah. Silahkan coba lagi nanti.";
            }
        }
        
        // Menutup stekmen
        mysqli_stmt_close($stmt);
    }
    
    // Menutup koneksi
    mysqli_close($link);
}
