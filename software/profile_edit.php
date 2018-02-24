<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
session_start();  

  if(isset($_SESSION['current_userId']) && !empty($_SESSION['current_userId'])) {
    if($_SESSION['current_userType'] === "admin") {
      header("location: admin_index.php");
    }
  } else {
      header("location: login.php");
  }

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
  <title>Home</title>

  <!-- Styles -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="../css/landing-page.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="http://localhost/gyroislandescape/index.html?#">Gyro Island Escape</a>
      <?php 
      if(isset($_SESSION['isLoggedin'])) {  ?>
      <a>WELCOME <?php echo $_SESSION['current_user'] ?></a>
      <?php } ?>
    </div>
  </nav>
  <br />
  <br />
  <div class="container">
    <div class="row">
      <div class="col-md-2">

      </div>
      <div class="col-md-8">
        <h2>
          Edit Profile
        </h2>
        <div class="jumbotron">
          <form action="" method="post">
            <div class="form-group">
             <label for="BookDate">FullName</label>
             <?php 
             echo "<input type='text' class='form-control' id='BookDate' placeholder='Enter Book Date' name='userFullname' value='". $_SESSION['current_user'] ."'>";  ?>
           </div>
           <div class="form-group">
             <label for="ManualBookNumber">Address:</label>
             <?php 
             echo "<textarea rows='5' class='form-control' id='BookDate' placeholder='Enter Book Date' name='userAddress'>". $_SESSION['current_user_address'] ." </textarea>";  ?>
           </div>
           <div class="form-group">
             <label for="BookDate">Contact Number</label>
             <?php 
             echo "<input type='text' class='form-control' id='BookDate' placeholder='Enter Book Date' name='userContactNo' value='". $_SESSION['current_user_contactNumber'] ."'>";  ?>
           </div>
           <div class="form-group">
             <label for="BookDate">Email Address</label>
             <?php 
             echo "<input type='text' class='form-control' id='BookDate' placeholder='Enter Book Date' name='userEmail' value='". $_SESSION['current_user_emailAddress'] ."'>";  ?>
           </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a type="button" class="btn btn-danger" href="customer_index.php">Close</a>
         </form>
         <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
          $current_userId = $_SESSION['current_userId'];
          $userFullname = mysqli_real_escape_string($conn, $_POST['userFullname']);
          $userAddress = mysqli_real_escape_string($conn, $_POST['userAddress']); 
          $userContactNo = mysqli_real_escape_string($conn, $_POST['userContactNo']); 
          $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']); 

          $updateUserSql = "UPDATE masteruser 
                            SET FullName = '$userFullname', 
                                Address = '$userAddress',
                                ContactNumber = '$userContactNo',
                                EmailAddress = '$userEmail'
                            WHERE Id = '$current_userId';";

          if (mysqli_query($conn, $updateUserSql)) {

            $_SESSION['current_user'] = $userFullname;
            $_SESSION['current_user_address'] = $userAddress;
            $_SESSION['current_user_contactNumber'] = $userContactNo;
            $_SESSION['current_user_emailAddress'] = $userEmail;

            header("location: customer_index.php");
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
        </div>
        
      </div>
    </form>
      <div class="col-md-2">

      </div>
    </div>
  </div>
  <br />
  <br />
  <br />
  <br />
  <br />
</div>

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
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
