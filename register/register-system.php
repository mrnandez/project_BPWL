<?php

require 'vendor/autoload.php';
require_once 'verification.php';

session_start();

// Mendefenisikan variabel dan analisis ketika Value kosong
$firstname = $lastname = $gender = $username = $status = $password = $confirm_password = "";
$firstname_err = $lastname = $gender_err = $username_err = $status_err = $password_err = $confirm_password_err = "";
 
// Memproses data ketika form di submit
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
/*<!--===============================================================================================-->*/

    $firstname= stripslashes($_POST['firstname']);

    // Mengikutkan Nama
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Silahkan masukkan nama pertama anda.";
    } else{

        // Pemilihan Nama untuk stekmen
        $sql = "SELECT id FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            // Mem-bind variabel ke stekmen yang sudah disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "s", $param_firstname);
            
            // Men-set parameter
            $param_firstname = trim($_POST["firstname"]);
            
            // Mencoba eksekusi stekmen yang sudah disiapkan
            if(mysqli_stmt_execute($stmt)){

                /* Menyimpan Hasil */
                mysqli_stmt_store_result($stmt);
                

            } else{
                echo "Oops! Ada yang salah. Silahkan coba lagi nanti.";
            }
        }
         
        // Menutup stekmen
        mysqli_stmt_close($stmt);
    }

/*<!--===============================================================================================-->*/

$lastname= stripslashes($_POST['lastname']);

// Mengikutkan Nama
if(empty(trim($_POST["lastname"]))){
    $lastname_err = "Silahkan masukkan nama terakhir anda.";
} else{

    // Pemilihan Nama untuk stekmen
    $sql = "SELECT id FROM users WHERE name = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){

        // Mem-bind variabel ke stekmen yang sudah disiapkan sebagai parameter
        mysqli_stmt_bind_param($stmt, "s", $param_lastname);
        
        // Men-set parameter
        $param_lastname = trim($_POST["lastname"]);
        
        // Mencoba eksekusi stekmen yang sudah disiapkan
        if(mysqli_stmt_execute($stmt)){

            /* Menyimpan Hasil */
            mysqli_stmt_store_result($stmt);
            

        } else{
            echo "Oops! Ada yang salah. Silahkan coba lagi nanti.";
        }
    }
     
    // Menutup stekmen
    mysqli_stmt_close($stmt);
}

/*<!--===============================================================================================-->*/

    // Mengikuti Status ketika kosong
    if (empty(trim($_POST["status"]))) {
        $status_err = "Silahkan pilih status anda.";
    }

    //  Membuat Parameter dan case untuk Status
    if(isset($_POST['status'])){
        $status = $_POST['status'];
        switch ($status) {
            case 'Pelajar':
                echo 'Pelajar<br/>';
                break;
            case 'Mahasiswa':
                echo 'Mahasiswa<br/>';
                break;
            case 'Pekerja':
                echo "Pekerja<br/>";
                break;

        }
    }


/*<!--===============================================================================================-->*/

   // Mengikuti gender ketika kosong
   if (empty(trim($_POST["gender"]))) {
    $gender_err = "Silahkan pilih gender anda.";
}

//  Membuat Parameter dan case untuk Gender
$gender = $_POST['gender'];
if (isset($_POST['submit'])) {
    mysqli_query ("INSERT INTO users SET gender='$gender'");
}

/*<!--===============================================================================================-->*/

/*<!--===============================================================================================-->*/


    // Mengesahkan password
    if(empty(trim($_POST["password"]))){
        $password_err = "Silahkan masukkan password anda.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password harus punya lebih dari 8 karakter.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Mengesahkan konfirmasi pasword
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Silahkan konfirmasi password anda.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password tidak cocok.";
        }
    }

/*<!--===============================================================================================-->*/

    // Mengikutkan Email
    if(empty(trim($_POST["username"]))){
        $username_err = "Silahkan masukkan username anda.";
    } else{

        // Pemilihan Username untuk stekmen
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            // Mem-bind variabel ke stekmen yang sudah disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Men-set parameter
            $param_username = trim($_POST["username"]);
            
            // Mencoba eksekusi stekmen yang sudah disiapkan
            if(mysqli_stmt_execute($stmt)){

                /* Menyimpan Hasil */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Maaf, Username ini sudah diambil.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Ada yang salah. Silahkan coba lagi nanti.";
            }
        }
         
        // Menutup stekmen
        mysqli_stmt_close($stmt);
    }
      
    
/*<!--===============================================================================================-->*/

    // Check error pada input sebelum memasukkan ke database
    if(empty($firstname_err) && empty($lastname_err) && empty($gender_err) && empty($username_err) && empty($status_err) && empty($password_err) && empty($confirm_password_err)){

        // Mempersiapkan pemasukan stekmen database
        $sql = "INSERT INTO users (firstname, lastname, gender, username, status, password, token, confirmation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){

            // Mem-bind variabel ke stekmen yang sudah disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "sssssssb", $param_firstname, $param_lastname, $gender, $param_username, $param_status, $param_password, $token, $confirmation);
           
            // Men-set parameter
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_gender = $gender;
            $param_username = $username;
            $param_status = $status;
            $param_password = password_hash($password, PASSWORD_DEFAULT);   // Membuat sebuah hash password
            $token = bin2hex(openssl_random_pseudo_bytes(16));              // Membuat sebuah token user
            $confirmation = false;                                          // Membuat konfirmasi default
            $userimg = $username;                                          

            sendVerificationUsername($username, $token);

            // Mencoba eksekusi stekmen yang sudah disiapkan
            if(mysqli_stmt_execute($stmt)){

                // Meng-redirect ke Halaman Login
                header("location: success.php");
            } else{
                echo "Oops! Ada yang salah. Silahkan coba lagi nanti.";
            }

        }
         
        // Menutup stekmen
        mysqli_stmt_close($stmt);
    }
    
    // Menutup Koneksi
    mysqli_close($link);
}

?>