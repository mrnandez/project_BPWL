<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../learning-upload");
    exit;
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$current_password = $new_password = $confirm_password = ""; 
$current_password_err = $new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate current password
   // if(empty(trim($_POST["current_password"]))){
   //     $current_password_err = "Please enter the new password.";     
   // } elseif(strlen(trim($_POST["current_password"])) < 8){
   //     $current_password_err = "Password must have atleast 8 characters.";
   // } else{
   //     $new_password = trim($_POST["current_password"]);
   // }

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Password must have atleast 8 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Setting - Reset Password</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="login-style/images/icons/favicon.ico"/>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <!-- Icons -->
  <link href="respass-style/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="respass-style/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- Argon CSS -->
  <link type="text/css" href="respass-style/css/argon.css" rel="stylesheet">
</head>
<body>&nbsp;
  <h2>&nbsp;&nbsp;Reset Password</h2>
  <br>
<div class="col-xl-8 order-xl-1">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">



        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="col-md-6" <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>>
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" class="form-control form-control-alternative" id="exampleFormControlInput1" placeholder="New Password" value="<?php echo $new_password; ?>">
        <i><span class="help-block"><?php echo $new_password_err; ?></span></i>
      </div>
    </div>

<br>

        <div class="col-md-6" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
      <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" class="form-control form-control-alternative" id="exampleFormControlInput1" placeholder="Confirm New Password" value="<?php echo $new_password; ?>">
        <i><span class="help-block"><?php echo $confirm_password_err; ?></span></i>
      </div>
    </div>
    <br/>

            <div class="form-group">
               &nbsp;&nbsp;&nbsp; <input type="submit" class="btn btn-info" name="btnChangePassword" value="Submit">
                <a class="btn btn-secondary" href="welcome.php">Cancel</a>
            </div>

        </form>

</div>
</div>
</div>

  <!-- Core -->
  <script src="respass-style/vendor/jquery/jquery.min.js"></script>
  <script src="respass-style/vendor/popper/popper.min.js"></script>
  <script src="respass-style/vendor/bootstrap/bootstrap.min.js"></script>

  <!-- Optional plugins -->
  <script src="respass-style/vendor/PLUGIN_FOLDER/PLUGIN_SCRIPT.js"></script>

  <!-- Theme JS -->
  <script src="respass-style/js/argon.js"></script>
  </body>
</html>