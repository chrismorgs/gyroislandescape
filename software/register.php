<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Datas -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Title -->
  <title>Register</title>

  <!-- Styles -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="../css/landing-page.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="../index.html">Gyro Island Escape</a>
    </div>
  </nav>
  <br />
  <br />
  <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
      <div class="text-center">
        <h2>Sign up</h2>
      </div>
      <br />
      <form action="" method="POST">
        <div class="form-group">
          <label for="Fullname">Fullname</label>
          <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname...">
        </div>
        <div class="form-group">
          <label for="pwd">Address</label>
          <textarea type="text" class="form-control" id="address" name="address" placeholder="Address..." rows="5"></textarea>
        </div>
        <div class="form-group">
          <label for="pwd">Contact Number</label>
          <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number...">
        </div>
        <div class="form-group">
          <label for="pwd">Email Address</label>
          <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Email Address...">
        </div>
        <br />
        <div class="form-group">
          <label for="pwd">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username...">
        </div>
        <div class="form-group">
          <label for="pwd">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
        </div>
        <div class="form-group">
          <label for="pwd">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password...">
        </div>
          <input type="submit" name="" class="btn btn-success" value="Register"> 
      </form>
      <br />
      <?php 
          if($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
            $address = mysqli_real_escape_string($conn, $_POST['address']); 
            $contactNumber = mysqli_real_escape_string($conn, $_POST['contactNumber']); 
            $emailAddress = mysqli_real_escape_string($conn, $_POST['emailAddress']); 
            $username = mysqli_real_escape_string($conn, $_POST['username']); 
            $password = mysqli_real_escape_string($conn, $_POST['password']); 
            $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']); 

            $sql = "INSERT INTO masteruser (FullName, Address, ContactNumber, EmailAddress, UserName, Password, UserType, IsActive)
                    VALUES ('$fullname', '$address','$contactNumber','$emailAddress','$username','$password', 'customer', 'true');";

            if ($conn->query($sql) === TRUE) {
              $success = "Successfully Registered!";
              echo
                 "
                   <div class='alert alert-success'>
                   " . $success . "
                   </div>
                 ";
            } else {
              $error = "Something's went wrong.";
              echo
                 "
                   <div class='alert alert-danger'>
                   " . $error . "
                   </div>
                 ";
            }
          }
       ?>
      <br />
      <a href="login.php">Already a Member?</a>
    </div>
    <div class="col-sm-4"></div>
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Cebu Eastern College. Information Techonology Department.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fa fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fa fa-twitter fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>