<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
session_start();
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
    <title>Login</title>

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
        <a class="navbar-brand" href="http://localhost/gyroislandescape/index.html?#">Gyro Island Escape</a>
      </div>
    </nav>
    <br />
    <br />
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <div class="text-center">
          <h2>Login</h2>
        </div>
        <br />
        <form action="" method="POST">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Enter Username">
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Password">
          </div>
          <div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
          </div>
          <input type="submit" name="" class="btn btn-info" value="Login"> 
        </form>
        <?php 
          if($_SERVER["REQUEST_METHOD"] == "POST") {
            $myusername = mysqli_real_escape_string($conn, $_POST['username']);
            $mypassword = mysqli_real_escape_string($conn, $_POST['password']); 

            $sql = "SELECT Id, 
                      UserName, 
                      FullName, 
                      Address, 
                      ContactNumber, 
                      EmailAddress, 
                      UserType 
                    FROM masteruser 
                    WHERE Username = '$myusername' and Password = '$mypassword'";
                    
            $result = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($result);
            if($count == 1) {
              $data = mysqli_fetch_assoc($result);

              $_SESSION['isLoggedin'] = true;
              $_SESSION['current_userId'] = $data["Id"];
              $_SESSION['current_user'] = $data["FullName"];
              $_SESSION['current_user_address'] = $data["Address"];
              $_SESSION['current_user_contactNumber'] = $data["ContactNumber"];
              $_SESSION['current_user_emailAddress'] = $data["EmailAddress"];
              $_SESSION['current_userType'] = $data["UserType"];

              if($data["UserType"] === "customer") {
                header("location: index.php");
              } else if($data["UserType"] === "admin") {
                header("location: adminPanel.php");
              }
           } else {
             $error = "Your Login Name or Password is invalid";
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
       <a href="register.php">Not yet a Member? Click here to Register</a>
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

  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
