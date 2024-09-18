<?php
session_start();
include('includes/config.php');
if(isset($_POST['signup']))
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=md5($_POST['password']);

	$query = mysqli_query($conn,"select * from register where email = '$email'")or die(mysqli_error());
	$count = mysqli_num_rows($query);

	if ($count > 0){ ?>
	 <script>
	 alert('Data Already Exist');
	</script>
	<?php
      }else{
        mysqli_query($conn,"INSERT INTO register(fullName, email, password) VALUES('$name','$email','$password')         
		") or die(mysqli_error()); ?>
		<script>alert('Records Successfully  Added');</script>;
		<script>
		window.location = "index.php"; 
		</script>
		<?php   }

}

?>


<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>NOTCH!</title>
  <!-- Include necessary meta tags and stylesheets -->
</head>
<body>
  <style>
    body {
      padding: 220px;
      margin: 0 auto;
      background-image: url("q2.png");
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    
    }
    
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-image: url("q3.png");
      background-repeat: no-repeat;
      background-size: cover;
    }
    
    .bg-dark {
      background-color: black;
    }
    
    .navbar-brand {
      color: white;
      font-family: 'Arial Black', Arial, sans-serif;
      font-weight: bold;
      font-size: 24px;
      display: block;
      margin-bottom: 20px;
    }
    
    .panel-heading {
      background-color: #f5f5f5;
      padding: 10px 20px;
      border-radius: 10px 10px 0 0;
    }
    
    .panel-body {
      padding: 20px;
    }
    
    .form-control {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 20px;
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    .form-group {
      margin-bottom: 30px;
    }
    
    .btn {
      display: inline-block;
      padding: 12px 24px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s;
    }
    
    .btn-primary {
      background-color: #007bff;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #0056b3;
    }
    
    .btn-default {
      background-color: #f5f5f5;
      color: #333;
    }
    
    .btn-default:hover {
      background-color: #e8e8e8;
    }
    
    .text-muted {
      color: #999;
      font-size: 25px;
    }
    
    
    </style>
<section id="content" class="m-t-lg wrapper-md animated fadeInDown">
  <div class="container">
    <div class="aside-xxl">
     
      <section class="panel panel-default m-t-lg bg-white">
      <br><br>
      <h2 class="panel-title" style="text-align: center;font-size: 35px;color: white;">Sign up</h2>
        </header>
        <form name="signupForm" method="POST" onsubmit="return validateForm()">
          <div class="panel-body wrapper-lg">
          	 <div class="form-group">
	            <label class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 18px; color: white;"
>Name</label>
	            <input name="name" id="name" type="text" placeholder="Full Name" class="form-control input-lg">
	          </div>
	          <div class="form-group">
    <label for="email" class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 18px; color: white;"
>Email</label>
    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email">
</div>
	          <div class="form-group">
	            <label class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 18px; color: white;"
>Password</label>
	            <input name="password" id="password" type="password" placeholder="Type a password" class="form-control input-lg">
	          </div>
	          <div class="form-group">
	            <label class="control-label"style="font-family: 'Arial Black', Arial, sans-serif; font-size: 18px; color: white;"
>Repeat Password</label>
	            <input name="password_repeat" id="password_repeat" type="password" placeholder="Repeat the password" class="form-control input-lg">
	          </div>
	          <div class="line line-dashed"></div>
	          <button name="signup" type="submit" class="btn btn-primary btn-block">Sign up</button>
	          <div class="line line-dashed"></div>
	          <p class="text-muted text-center"><small>Already have an account?</small></p>
	          <a href="index.php" class="btn btn-default btn-block">Login</a>
          </div>
        </form>
      </section>
    </div>
  </section>
</body>
<script>
function validateForm() {
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var passwordRepeat = document.getElementById("password_repeat").value;

    // Check if name is empty
    if (name.trim() === "") {
        alert("Please enter your name.");
        return false;
    }

    // Check if email is empty and valid
    if (email.trim() === "") {
        alert("Please enter your email address.");
        return false;
    } else if (!validateEmail(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Check if password is empty
    if (password.trim() === "") {
        alert("Please enter a password.");
        return false;
    }

    // Check if passwords match
    if (password !== passwordRepeat) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
</script>
</html>
