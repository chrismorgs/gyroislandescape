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
    <title>Admin Panel</title>

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
        <a href="software/login.php"></a>

        <?php 
          if(isset($_SESSION['isLoggedin'])) {  ?>
          <br/><a><?php echo $_SESSION['current_user'] ?></a>
        <?php } ?>
      </div> 
      <a type="button" class="btn btn-danger" href="logout.php" >
            <i class="fa fa-power-off fa-fw"></i>Log out 
          </a>
    </nav>
    <br />
    <br />
    <div class="container">
      <h3><?php echo $_SESSION['current_user'] ?></h3>
      <br />
      <table class="table table-bordered" style="width: 100%;">
        <thead>
          <tr>
            <th style="width: 8%;">View</th>
            <th style="width: 17%;">Date</th>
            <th style="width: 25%;">Time</th>
            <th style="width: 15%;">Book Code.</th>
            <th style="width: 25%;">Customer</th>
            <th style="width: 25%;">Pax</th>
            <th style="width: 10%;" class="text-center">Appove</th>
            <th style="width: 10%;" class="text-center">Pending</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sql = "SELECT 
                      transactionbook.Id, 
                      transactionbook.BookDate, 
                      transactionbook.BookTime, 
                      transactionbook.BookNumber, 
                      transactionbook.Note,
                      transactionbook.IsApproved,
                      transactionbook.Disapproved,
                      
                      transactionbook.BookedByUserId,
                      masteruser.FullName
                    FROM  transactionbook
                    INNER JOIN masteruser ON transactionbook.BookedByUserId = masteruser.Id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $bookDataTime = strtotime($row["BookDate"]);
                $bookDateFormat = date('Y-m-d', $bookDataTime);

                $bookTime = strtotime($row["BookTime"]);
                $bookTimeFormat = date('g:i: A', $bookTime);

                $IsApproved = " ";
                if($row["IsApproved"] == 1) {
                  $IsApproved = "<i class='fa fa-check fa-fw' style='color: green;'></i>";
                }

                $Disapproved = " ";
                if($row["Disapproved"] == 1) {
                  $Disapproved = "<i class='fa fa-check fa-fw' style='color: green;'></i>";
                }
               
                echo 
                "
                   <tr>
                    <td><a class='btn btn-info btn-block btn-sm' href='book_detail.php?book_id=" . $row["Id"] . "'><i class='fa fa-eye fa-fw'></i></a></td>
                    <td>" . $bookDateFormat . "</td>
                    <td>" . $bookTimeFormat . "</td>
                    <td>" . $row["BookNumber"]. "</td>
                    <td>" . $row["FullName"]. "</td>
                    <td>" . $row["Note"]. "</td>
                    <td class='text-center'>" . $IsApproved . "</td>
                    <td class='text-center'>" . $Disapproved . "</td>
                    
                  </tr>
                ";
              }
            } 
            $conn->close();
          ?>
        </tbody>
      </table>
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
