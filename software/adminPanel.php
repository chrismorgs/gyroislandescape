<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
session_start();

if($_SESSION['current_userType'] === "customer") {
  header("location: index.php");
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
          <a><?php echo $_SESSION['current_user'] ?></a>
        <?php } ?>
      </div>
    </nav>
    <br />
    <br />
    <div class="container">
      <h3><?php echo $_SESSION['current_user'] ?></h3>
      <br />
      <table class="table table-bordered" style="width: 100%;">
        <thead>
          <tr>
            <th style="width: 5%;">View</th>
            <th style="width: 15%;">Book Date</th>
            <th style="width: 15%;">Book No.</th>
            <th style="width: 30%;">Customer</th>
            <th style="width: 25%;">Remarks</th>
            <th style="width: 10%;" class="text-center">Appove</th>
            <th style="width: 10%;" class="text-center">Cancel</th>
            <th style="width: 10%;" class="text-center">Reserve</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sql = "SELECT 
                      transactionbook.Id, 
                      transactionbook.BookDate, 
                      transactionbook.BookNumber, 
                      transactionbook.ManualBookNumber,
                      transactionbook.Remarks,
                      transactionbook.IsApproved,
                      transactionbook.IsCancelled,
                      transactionbook.IsReserved,
                      masteruser.FullName
                    FROM  transactionbook
                    INNER JOIN masteruser ON transactionbook.BookedByUserId = masteruser.Id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $bookDataTime = strtotime($row["BookDate"]);
                $bookDateFormat = date('Y-m-d', $bookDataTime);

                $IsApproved = "<button class='btn btn-primary btn-sm btn-block'><i class='fa fa-check fa-fw'></i> Approve</button>";
                if($row["IsApproved"] == 1) {
                  $IsApproved = "<i class='fa fa-check fa-fw' style='color: green;'></i>";
                }

                $IsCancelled = "<button class='btn btn-danger btn-sm  btn-block'><i class='fa fa-close fa-fw'></i> Cancel</button>";
                if($row["IsCancelled"] == 1) {
                  $IsCancelled = "<i class='fa fa-close fa-fw' style='color: red;'></i>";
                }

                $IsReserved = "<button class='btn btn-success btn-sm  btn-block'><i class='fa fa-user fa-fw'></i> Reserve</button>";
                if($row["IsReserved"] == 1) {
                  $IsReserved = "<i class='fa fa-user fa-fw' style='color: blue;'></i>";
                }

                echo 
                "
                   <tr>
                    <td><button class='btn btn-info btn-block btn-sm'><i class='fa fa-eye fa-fw'></i></button></td>
                    <td>" . $bookDateFormat . "</td>
                    <td>" . $row["BookNumber"]. "</td>
                    <td>" . $row["FullName"]. "</td>
                    <td>" . $row["Remarks"]. "</td>
                    <td class='text-center'>" . $IsApproved . "</td>
                    <td class='text-center'>" . $IsCancelled . "</td>
                    <td class='text-center'>" . $IsReserved . "</td>
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
