<?php 
include 'dbconnection.php';
session_start();

$bookByUserId = $_GET['bookByUserId'];
$book_id = $_GET['book_id'];
$approve_data = $_GET['approve_data'];
$disapproved_data = $_GET['disapproved_data'];

echo $approve_data;

$updateBookSql = "UPDATE transactionbook SET IsApproved = '$approve_data', Disapproved = '$disapproved_data' WHERE Id = '$book_id';";

$content = "No Content";
if($approve_data == 1) {
	$content = "Your book has been approved";
} else if($disapproved_data == 1) {
	$content = "Your book is pending";
} else if($reserve_data == 0) {
	$content = "Your book has been reserved";
} else {
	$content = "No Content";
}
  
if ($conn->query($updateBookSql) === TRUE) {
	$currentDate = date('Y-m-d');
      $notification = "INSERT INTO masterusernotification  (
      UserId, 
      Content, 
      NotificationDate,
      BookId)
      VALUES (
      '$bookByUserId', 
      '$content',
      '$currentDate',
      '$book_id');";

      if ($conn->query($notification) === TRUE) {
		header('location:admin_index.php');
      } else {
        $error = "Something's went wrong.";
        echo
        "
        <div class='alert alert-danger'>
        " . $error . "
        </div>
        ";
      }
} else {
    echo "Error deleting record: " . $conn->error;
}

?>