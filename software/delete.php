<?php    
	// ==========
    // DB Context
    // ==========
  include 'dbconnection.php';
  session_start();

	$id = $_GET['user_id'];
	$deleteSQL = "DELETE FROM transactionbook WHERE id= " . $id;

	if ($conn->query($deleteSQL) === TRUE) {
		header('location:customer_index.php');
	} else {
	    echo "Error deleting record: " . $conn->error;
	}
?>