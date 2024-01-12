<?php
// No note variable found, or invalid delete_id, so exit
if ( ! isset( $_GET['update_id'] ) || ! is_numeric( $_GET['update_id'] ) ) {
	die();
}
// Added databse connection file
require 'connection.php';

// Update note on user sumbit
if ( isset( $_POST['save'] ) ) {
	// Prepare the update statement with a placeholder for the parameter
	$sql         = $conn->prepare( 'UPDATE notes SET  title=?, description=? WHERE id=? ' );
	$title       = $_POST['title'];
	$description = $_POST['description'];
	// Bind the parameter to the statement
	$sql->bind_param( 'ssi', $title, $description, $_GET['update_id'] );
	// Execute the statement
	$sql->execute();
	header( 'location: show.php' );
	exit();
}
?>
