<?php
session_start();
include('includes/config.php');
$error = ""; // Variable to store error message

if(isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    if(!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM register WHERE email ='$email' AND password ='$password'";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        
        if($count > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $_SESSION['alogin'] = $row['user_ID'];
                echo "<script type='text/javascript'> document.location = 'notebook.php'; </script>";
            }
        } else {
            $error = "Invalid email or password."; // Set error message
        }
    } else {
        $error = "Email and password are required."; // Set error message
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>NOTCH!</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />
</head>
<body>
<div class="text-center">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xxl">
      <section class="m-t-lg">
      <header class="text-center">
      <h2 class="panel-title" style="text-align: center; font-family: 'Arial Black', Arial, sans-serif; font-size: 35px; color: white; margin: auto;">NOTCH!</h2>

</header>
        <br><br><br>
      </header>
      <form name="signin" method="post" onsubmit="return validateForm()">
        <div class="wrapper-lg">
          <div class="form-group">
            <label class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 19px; color: white;"
>Email</label>
            <input name="email" type="email" placeholder="Enter Email" class="form-control input-lg">
          </div>
          <br>
          <div class="form-group">
            <label class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 19px; color: white;"
>Password</label>
            <input name="password" type="password" id="inputPassword" placeholder="Password" class="form-control input-lg">
          </div>
          <div class="line line-dashed"></div>
          <button name="signin" type="submit" class="login-btn">Login</button>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center" style="font-family: 'Arial Black', Arial, sans-serif; font-size: 25px; color: white;"
><small>Do not have an account?</small></p>
          <a href="signup.php" class="register-btn"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 16px; color: white;">Create an account</a>
          <div style="color: red; margin-top: 15px; font-family: Arial;"><?php echo $error; ?></div> <!-- Display error message -->
        </div>
      </form>
    </section>
  </div>
</section>
<footer id="footer">
  <div class="text-center padder">
  </div>
</footer>
<script src="js/jquery.min.js"></script>
<script src="js/app.js"></script>
<script src="js/app.plugin.js"></script>
<script src="js/slimscroll/jquery.slimscroll.min.js"></script>
<script>
  function validateForm() {
    var email = document.getElementsByName('email')[0].value;
    var password = document.getElementsByName('password')[0].value;
    if (email.trim() === '' || password.trim() === '') {
      alert('Email and password are required.');
      return false;
    }
    return true;
  }
  </script>
  <style>
    /* CSS for login form */
    body {
      padding: 220px;
      background-image: url("q1.png");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      opacity: 0.9;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 50px;
      box-shadow: 0 0 60px rgba(0, 0, 0, 0.1);
      border-radius: 20px;
      background-image: url("q7.png");
      background-repeat: no-repeat;
      background-size: cover;
    }

    .wrapper-md {
      padding: 20px;
    }

    .panel-heading {
      padding: 10px 20px;
      background-color: #f5f5f5;
      border-bottom: 1px solid #ddd;
    }

    .panel-body {
      padding: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .control-label {
      font-weight: bold;
    }

    .input-lg {
      display: block;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      line-height: 1.5;
      color: #555;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .line {
      height: 1px;
      margin: 15px 0;
      overflow: hidden;
      background-color: #e5e5e5;
    }

    .line-dashed {
      border-top: 1px dashed #ddd;
    }

    .login-btn, .register-btn {
      display: inline-block;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-transform: uppercase;
      transition: background-color 0.3s;
    }

    .login-btn {
      background-color: #007bff;
    }

    .login-btn:hover {
      background-color: #0056b3;
    }

    .register-btn {
      background-color: transparent;
      border: 1px solid white;
      color: black;
      text-decoration: none;
    }

    .register-btn:hover {
      background-color: black;
    }
  </style>
</body>
</html>
