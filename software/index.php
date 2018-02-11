<?php
  // ==========
  // DB Context
  // ==========
include 'dbconnection.php';
session_start();

if($_SESSION['current_userType'] === "admin") {
  header("location: adminPanel.php");
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
          <a><?php echo $_SESSION['current_user'] ?></a>
        <?php } ?>
      </div>
    </nav>
    <br />
    <br />
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h3><?php echo $_SESSION['current_user'] ?></h3>
          <span><i class="fa fa-globe fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_address'] ?></span><br />
          <span><i class="fa fa-phone fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_contactNumber'] ?></span><br />
          <span><i class="fa fa-envelope fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_emailAddress'] ?></span>
        </div>
        <div class="col-md-4" align="right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#book">
            <i class="fa fa-book fa-fw"></i> Book
          </button>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#notification">
            <i class="fa fa-globe fa-fw"></i> View Notifications 
          </button>
        </div>
      </div>
      <br />
      <table class="table table-bordered" style="width: 100%;">
        <thead>
          <tr>
            <th style="width: 15%;">Book Date</th>
            <th style="width: 15%;">Book No.</th>
            <th style="width: 35%;">Remarks</th>
            <th style="width: 10%;" class="text-center">A</th>
            <th style="width: 10%;" class="text-center">C</th>
            <th style="width: 10%;" class="text-center">R</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $sql = "SELECT Id, 
                      BookDate, 
                      BookNumber, 
                      ManualBookNumber,
                      Remarks,
                      IsApproved,
                      IsCancelled,
                      IsReserved
                    FROM  transactionbook
                    WHERE BookedByUserId = " . $_SESSION['current_userId'];

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                $bookDataTime = strtotime($row["BookDate"]);
                $bookDateFormat = date('Y-m-d', $bookDataTime);

                $IsApproved = "No";
                if($row["IsApproved"] == 1) {
                  $IsApproved = "Yes";
                }

                $IsCancelled = "No";
                if($row["IsCancelled"] == 1) {
                  $IsCancelled = "Yes";
                }

                $IsReserved = "No";
                if($row["IsReserved"] == 1) {
                  $IsReserved = "Yes";
                }

                echo 
                "
                   <tr>
                    <td>" . $bookDateFormat . "</td>
                    <td>" . $row["BookNumber"]. "</td>
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

   <!-- The Modal -->
  <div class="modal fade" id="book">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-book fa-fw"></i> Book</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

   <!-- The Modal -->
  <div class="modal fade" id="notification">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-globe fa-fw"></i> Notifications</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
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
