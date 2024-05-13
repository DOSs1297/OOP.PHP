<?php
require_once('classes/database.php');
$con = new database();

$error = "";

if (isset($_POST['signup'])) {
  $Username = $_POST['Username'];
  $Pass_word = $_POST['Pass_word'];
  $ConfirmPass_word = $_POST['ConfirmPass_word'];
  $Firstname = $_POST['Firstname'];
  $Lastname = $_POST['Lastname']; 
  $Birthday = $_POST['Birthday']; 
  $SEX = $_POST['SEX'];



   
    if ($con->isUsernameTaken($Username)) {
        $error = "Username is already taken. Please choose another one.";
    } else {
        if ($Pass_word === $ConfirmPass_word) { 
            $result = $con->register($Username, $Pass_word, $Firstname, $Lastname, $Birthday, $SEX);

            if ($result) {
                header('location: login.php');
                exit;
            } else {
                $error = "Error occurred while registering. Please try again.";
            }
        } else {
            $error = "Passwords do not match. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .signup-container {
            max-width: 400px;
            margin: 0 auto;
            height: auto;
            padding: 20px;
            margin-top: 100px;
          
        }
    </style>
</head>
<body>

<div class="container-fluid signup-container rounded shadow">
    <h2 class="text-center mb-4">Sign Up</h2>
    <form method="post">
        <div class="form-group">
            <label for="Firstname">First name:</label>
            <input type="text" class="form-control" name="Firstname" placeholder="Enter First name">
        </div>
        <form method="post">
        <div class="form-group">
            <label for="Lasttname">Last name:</label>
            <input type="text" class="form-control" name="Lastname" placeholder="Enter Last name">
        </div>

    <div class="mb-3">
      <label for="Birthday" class="form-label">Birthday:</label>
      <input type="date" class="form-control" name="Birthday">
    </div>
    <div class="mb-3">
      <label for="SEX" class="form-label">Sex:</label>
      <select class="form-select" name="SEX">
        <option selected disabled>Select Sex</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
  
      </select>
    </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="Username" placeholder="Enter username">
        </div>
        

        <div class="form-group">
            <label for="Pass_word">Password:</label>
            <input type="password" class="form-control" name="Pass_word" placeholder="Enter password">
        </div>
        
        <div class="form-group"> 
            <label for="ConfirmPass_word">Confirm Password:</label>
            <input type="password" class="form-control" name="ConfirmPass_word" placeholder="Confirm password">
        </div>

        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <input type="submit" class="btn btn-danger btn-block" value="Sign Up" name="signup">


       
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>