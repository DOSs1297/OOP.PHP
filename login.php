<?php

require_once('classes/database.php');
session_start();
if(isset($_SESSION['username'])){
  header('location:index.php');
}
$con = new database();


$error = ""; // Initialize error variable

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $passwords = $_POST['passwords'];
    $result = $con->check($username, $passwords);
    if ($result) {
        if ($result['username'] == $_POST['username'] && $result['passwords'] == $_POST['passwords']) {
            $_SESSION['username'] = $result['username'];
             
            header('location:index.php');
        } else {
            $error = "Incorrect username or password. Please try again.";
        }
    } else {
        $error = "Error occurred while logging in. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      height: auto;
      padding: 20px
    }
  </style>
</head>
<body>
 
<div class="container-fluid login-container rounded shadow">
  <h2 class="text-center mb-4">Login</h2>
  
  <form method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="Pass_word">Password:</label>
      <input type="password" class="form-control" name="passwords" placeholder="Enter password">
    </div>
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="container">
      <div class="row gx-1">
        <div class="col"><input type="submit" class="btn btn-primary btn-block" value="Log In" name="login"></div>
        <div class="col"><a class="btn btn-danger btn-block" href="signup.php">Sign Up</a></div>
      </div>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
