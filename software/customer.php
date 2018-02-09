<?php 
  include 'dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gyro Island Escape</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/landing-page.min.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
      <div class="container">
        <h3>Gyro Island Escape Customer List</h3>
       
      </div>
    </nav>
<div class="container">
<br />
  <div class="row">
  
  <div class="col-sm-12" align="right">
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Add</button>
  </div>
</div>
<br />
  <table class="table table-bordered" style="width: 100%;">
    <thead>
      <tr>
        <th style="width: 10%;">Edit</th>
        <th style="width: 10%;">Delete</th>
        <th style="width: 20%;">Code No.</th>
        <th style="width: 40%;">Customer</th>
        <th style="width: 20%;">Contact No.</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $sql = "SELECT Id, CustomerNumber, Customer, ContactNumber FROM mastercustomer";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo 
            "
               <tr>
                <td><button type='button' class='btn btn-info btn-block' data-toggle='modal' data-target'#myModal'>Edit</button></td>
                <td><button type='button' class='btn btn-danger btn-block' data-toggle='modal' data-target'#myModal'>Delete</button></td>
                <td>" . $row["CustomerNumber"]. "</td>
                <td>" . $row["Customer"]. "</td>
                <td>" . $row["ContactNumber"]. "</td>
              </tr>
            ";
          }
        } 
        else {
          echo "0 results";
        }

        $conn->close();
      ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content      -->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">




         <form action="/action_page.php">
          <div class="form-group">
            <label for="text">Code Number:</label>
            <input type="text" class="form-control" id="text">
          </div>
          <div class="form-group">
            <label for="text">Customer:</label>
            <input type="text" class="form-control" id="text">
          </div>
          <div class="form-group">
            <label for="text">Contact Number:</label>
            <input type="text" class="form-control" id="text">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>



      </form>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>

</div>
</div>


  















  

    <!-- Call to Action -->
  

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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
