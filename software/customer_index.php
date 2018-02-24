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
    <title>GIE Booking</title>

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
        <div class="col-md-6">
          <h4><?php echo $_SESSION['current_user'] ?></h4>
          <span><i class="fa fa-globe fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_address'] ?></span><br />
          <span><i class="fa fa-phone fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_contactNumber'] ?></span><br />
          <span><i class="fa fa-envelope fa-fw"></i> &nbsp; <?php echo $_SESSION['current_user_emailAddress'] ?></span>
        </div>
        <div class="col-md-6" align="right">
          <a type="button" class="btn btn-info btn-sm" href="profile_edit.php">
            <i class="fa fa-edit fa-fw"></i> Edit Profile
          </a>
          <a type="button" class="btn btn-primary btn-sm" href="book_add.php">
            <i class="fa fa-book fa-fw"></i> Book
        </a>
          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#notification">
            <i class="fa fa-globe fa-fw"></i> View Notifications 
          </button>
          <a type="button" class="btn btn-danger btn-sm" href="logout.php" >
            <i class="fa fa-power-off fa-fw"></i>Log out 
          </a>
        </div>
      </div>
      <br />
      <table class="table table-bordered" style="width: 100%;">
        <thead>
          <tr>
            <th style="width: 7%;">Edit</th>
            <th style="width: 7%;">Delete</th>
            <th style="width: 10%;">Book Date</th>
            <th style="width: 10%;">Book Time</th>
            <th style="width: 13%;">Book Code</th>
            <th style="width: 10%;">Pax</th>
            <th style="width: 9%;" class="text-center">Approve</th>
            <th style="width: 9%;" class="text-center">Disapproved</th>
            
          </tr>
        </thead>
        <tbody>
          <?php 
          $sql = "SELECT *
          FROM  transactionbook
          WHERE BookedByUserId = " . $_SESSION['current_userId'] . " 
          ORDER BY Id DESC";

          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $bookDataTime = strtotime($row["BookDate"]);
              $bookDateFormat = date('Y-m-d', $bookDataTime);

              $bookTime = strtotime($row["BookTime"]);
              $bookTimeFormat = date('g:i: A', $bookTime);

              $IsApproved = "No";
              if($row["IsApproved"] == 1) {
                $IsApproved = "Yes";
              }

              $Disapproved = "No";
              if($row["Disapproved"] == 1) {
                $Disapproved = "Yes";
              }

              

              echo 
              "
              <tr>
              <td>
                <a href='book_edit.php?book_id=". $row["Id"] ."' class='btn btn-primary btn-block btn-sm'>Edit</a>
              </td>
              <td>
                <button onclick= 'remove(  ".$row["Id"].")' class='btn btn-danger btn-block btn-sm' > Delete</button>
              </td>
              <td>" . $bookDateFormat . "</td>
              <td>" . $bookTimeFormat . "</td>
              <td>" . $row["BookNumber"]. "</td>
              <td>" . $row["Note"]. "</td>
              <td class='text-center'>" . $IsApproved . "</td>
              <td class='text-center'>" . $Disapproved . "</td>
              
              </tr>
              ";
            }
          } 
          ?>
        </tbody>
      </table>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />

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
          <table class="table table-bordered" style="width: 100%;">
            <thead>
              <tr>
                <th style="width: 30%;">Book Code</th>
                <th style="width: 70%;">Content</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $notificationSQL = "SELECT masterusernotification.Id, 
              masterusernotification.Content, 
              masterusernotification.NotificationDate,
              masterusernotification.BookId,
              transactionbook.BookNumber
              FROM  masterusernotification
              INNER JOIN transactionbook ON masterusernotification.BookId = transactionbook.Id
              WHERE masterusernotification.UserId = " . $_SESSION['current_userId'];

              $notificationResult = $conn->query($notificationSQL);
              if ($notificationResult->num_rows > 0) {
                while($notificationRow = $notificationResult->fetch_assoc()) {
                  echo 
                  "
                  <tr>
                  <td>" . $notificationRow["BookNumber"] . "</td>
                  <td>" . $notificationRow["Content"] . "</td>
                  </tr>
                  ";
                }
              } 
              ?>
            </tbody>
          </table>
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
  <script type="text/javascript">
     function remove(number) {
        var txt="";
        var r = confirm("Are you sure you want to delete?");
        if (r == true) {
            window.location="delete.php?user_id="+number
        }
    }
  </script>
  </body>
  </html>
