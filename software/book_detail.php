<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
session_start();  

if(isset($_SESSION['current_userId']) && !empty($_SESSION['current_userId'])) {
  if($_SESSION['current_userType'] === "customer") {
    header("location: customer_index.php");
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
          $book_note = mysqli_real_escape_string($conn, $_POST['book_note']); 
          $booknum = mysqli_real_escape_string($conn, $_POST['booknum']); 

          $updateBookSql = "UPDATE transactionbook SET BookDate = '$book_date', Note = '$book_note' WHERE Id = '$book_id';";

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
        <h4>
          Booking Details
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
            <?php 
            $book_id = $_GET['book_id'];
            $getBookDetailSQL = "SELECT 
            transactionbook.Id, 
            transactionbook.BookDate, 
            transactionbook.BookTime, 
            transactionbook.BookNumber, 
            transactionbook.Note,
            transactionbook.IsApproved,
            transactionbook.Disapproved,
            transactionbook.BookedByUserId,
            masteruser.FullName,
            masteruser.Address,
            masteruser.ContactNumber,
            masteruser.EmailAddress
            FROM  transactionbook
            INNER JOIN masteruser ON transactionbook.BookedByUserId = masteruser.Id
            WHERE transactionbook.Id = '$book_id'";

            $result = mysqli_query($conn, $getBookDetailSQL);
            $count = mysqli_num_rows($result);
            if($count == 1) { 
              $data = mysqli_fetch_assoc($result);
              $bookDataTime = strtotime($data["BookDate"]);
              $bookDateFormat = date('Y-m-d', $bookDataTime);

              $BookTime = strtotime($data["BookTime"]);
              $BookTimeFormat = date('H:i', $BookTime);

              $NoteData = $data["Note"];
              $BookNumber = $data["BookNumber"];

              $FullName = $data["FullName"];
              $Address = $data["Address"];
              $BookNumber = $data["BookNumber"];
              $ContactNumber = $data["ContactNumber"];
              $EmailAddress = $data["EmailAddress"];
              $BookedByUserId = $data["BookedByUserId"];
              ?>
              <div class='form-group'>
                <label for='bookdate'> Customer</label>
                <input type="text" class="form-control" id="" name="" value="<?php echo $FullName ?>" disabled/>
              </div>
              <div class='form-group'>
                <label for='ManualBookNumber'>Address:</label>
                <textarea rows='5' class='form-control' id="" name="" disabled><?php echo $Address; ?></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                 <div class='form-group'>
                  <label for='bookdate'> Contact No.:</label>
                  <input type="text" class="form-control" id="" name="" value="<?php echo $ContactNumber ?>" disabled/>
                </div>
              </div>
              <div class="col-md-6">
               <div class='form-group'>
                <label for='bookdate'> Email Address:</label>
                <input type="text" class="form-control" id="" name="" value="<?php echo $EmailAddress ?>" disabled/>
              </div>
            </div>
          </div>
          <br />
      <div class='form-group'>
        <label for='bookdate'> Book Code:</label>
        <input type="text" class="form-control" id="" name="" value="<?php echo $BookNumber ?>" disabled/>
      </div>
          <div class="row">
            <div class="col-md-6">
             <div class='form-group'>
              <label for='bookdate'> Book Date:</label>
              <input type="date" class="form-control" id="" name="" value="<?php echo $bookDateFormat; ?>" disabled/>
            </div>
          </div>
          <div class="col-md-6">
           <div class='form-group'>
            <label for='bookdate'> Book Time:</label>
            <input type="time" class="form-control" id="" name="" value="<?php echo $BookTimeFormat ?>" disabled/>
          </div>
        </div>
      </div>
      <div class='form-group'>
        <label for='ManualBookNumber'>Pax:</label>
        <input type="number" class="form-control" id="" name="" value="<?php echo $NoteData; ?>" disabled />
      </div>
      <br />
      <br />
      <button type="button" class="btn btn-primary" onclick="bookDetailFunction(<?php echo $BookedByUserId ?>, <?php echo $_GET['book_id'] ?>, 1, 0, 0)">Approve</button>
      <button type="button" class="btn btn-danger" onclick="bookDetailFunction(<?php echo $BookedByUserId ?>, <?php echo $_GET['book_id'] ?>, 0, 1, 0)">Pending</button>
      
      <a type="button" class="btn btn-danger pull-right" href="admin_index.php">Close</a>
      <?php }?>
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
<script type="text/javascript">
     function bookDetailFunction(bookByUserId, id, approve, disapproved, reserve) {
        if(approve == 1) {
          var r = confirm("Are you sure you want to approve?");
          if (r == true) {
              window.location="book_detail_function.php?bookByUserId="+bookByUserId+"&book_id="+id+"&approve_data="+approve+"&disapproved_data="+disapproved
          }
        }

        if(disapproved == 1) {
          var r = confirm("Are you sure you want the book to be pending?");
          if (r == true) {
              window.location="book_detail_function.php?bookByUserId="+bookByUserId+"&book_id="+id+"&approve_data="+approve+"&disapproved_data="+disapproved
          }
        }
    }
  </script>
</body>
</html>
