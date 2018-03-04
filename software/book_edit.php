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
          $book_id = $_GET['book_id'];
          $current_userId = $_SESSION['current_userId'];

          $book_date = mysqli_real_escape_string($conn, $_POST['book_date']);
          $book_time = mysqli_real_escape_string($conn, $_POST['book_time']);
          $book_note = mysqli_real_escape_string($conn, $_POST['book_note']); 
          $booknum = mysqli_real_escape_string($conn, $_POST['booknum']); 


          $updateBookSql = "UPDATE transactionbook SET BookDate = '$book_date', BookTime = '$book_time', Note = '$book_note' WHERE Id = '$book_id';";

          if (mysqli_query($conn, $updateBookSql)) {
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
        <h2>
          Update Book
        </h2>
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
                <?php 
                  $book_id = $_GET['book_id'];
                  $getBookDetailSQL = "SELECT Id, 
                            BookDate, 
                            Note,
                            BookTime
                          FROM transactionbook 
                          WHERE Id = '$book_id'";
                          
                  $getBookDetailresult = mysqli_query($conn, $getBookDetailSQL);

            $getbookcount = mysqli_num_rows($getBookDetailresult);
            if($getbookcount == 1) { 
              $data = mysqli_fetch_assoc($getBookDetailresult);

              $bookDataTime = strtotime($data["BookDate"]);
              $bookDateFormat = date('Y-m-d', $bookDataTime);

              $BookTime = strtotime($data["BookTime"]);
              $BookTimeFormat = date('H:i', $BookTime);

              $NoteData = $data["Note"];

                ?>
            <div class='form-group'>
              <label for='bookdate'> Book Date:</label>
              <input type="date" class="form-control" id="book_date" name="book_date" value="<?php echo $bookDateFormat; ?>" />
              <label for='bookdate'> Book Time:</label>
              <input type="time" class="form-control" id="book_time" name="book_time" value="<?php echo $BookTimeFormat ?>" />
            </div>
            <div class='form-group'>
              <label for='ManualBookNumber'>Pax:</label>
              <input type="number" class="form-control" id="book_note" name="book_note" value="<?php echo $NoteData; ?>" />
          
            </div>
            <br />
            <br />
            <button type="submit" class="btn btn-info">Update</button>
            <a type="button" class="btn btn-danger" href="customer_index.php">Close</a>
            <?php } ?>
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
