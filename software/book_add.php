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
        
        
        <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
          $current_userId = $_SESSION['current_userId'];

          $book_date = mysqli_real_escape_string($conn, $_POST['book_date']);
          $book_time = mysqli_real_escape_string($conn, $_POST['book_time']);
          $book_time_value = date('H:i:s ', strtotime($book_time));
          $book_note = mysqli_real_escape_string($conn, $_POST['book_note']); 
          $booknum = mysqli_real_escape_string($conn, $_POST['booknum']); 

          if(!isset($book_date) || trim($book_date) == '')
          {
             echo
               "
                 <div class='alert alert-danger'>
                    Full name is required.  
                 </div>
               ";
          } else if(!isset($book_time) || trim($book_time) == '') {
            echo
               "
                 <div class='alert alert-danger'>
                    Book Time is required.
                 </div>
               ";
          } else if(!isset($book_note) || trim($book_note) == '') {
            echo
               "
                 <div class='alert alert-danger'>
                    Number of pax is required.
                 </div>
               ";
          } else {

          $bookSql = "INSERT INTO `transactionbook`  (
            BookDate, 
            BookNumber, 
            Note, 
            IsApproved, 
            Disapproved, 
            BookedByUserId,
            BookTime)
          VALUES (
            '$book_date', 
            '$booknum',
            '$book_note',
            '0',
            '0',
            '$current_userId',
            '$book_time_value')";

          if ($conn->query($bookSql) == TRUE) {
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
        }
        ?>
        <h4>
          Add Reservation Date
        </h4>
        <div class="jumbotron">
          <form action='' method="POST">
            <?php
                function createRandomPassword() {
                  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
                  srand((double)microtime()*1000000);
                  $i = 0;
                  $pass = '' ;
                  while ($i <= 7) {

                    $num = rand() % 33;

                    $tmp = substr($chars, $num, 1);

                    $pass = $pass . $tmp;

                    $i++;

                  }
                  return $pass;
                }
                $finalcode='00-'.createRandomPassword();
                ?>
                


                <input type="hidden" name="booknum" value="<?php echo $finalcode ?>" />
            <div class='form-group'>
              <label for='bookdate'> Book Date:</label>
              <input type="date" class="form-control" id="book_date" name="book_date" value="<?php echo date('Y-m-d'); ?>"  min="<?php echo date('Y-m-d'); ?>"/>
              <label for='bookdate'> Book Time:</label>
              <input type="time" class="form-control" id="book_time" name="book_time" value="<?php echo date("H:i"); ?>" />
            </div>
            <div class='form-group'>  
              <label for='ManualBookNumber'>Pax:</label>
             <input type="number" class="form-control" id="book_note" name="book_note" value="" />
            </div>
            <br />
            <br />  
            <button type="submit" name="book" class="btn btn-primary">Book</button>
            <a type="button" class="btn btn-danger" href="customer_index.php">Close</a>
          </form>
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
