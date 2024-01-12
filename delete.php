<?php
// No note variable found, or invalid delete_id, so exit
if ( ! isset( $_GET['delete_id'] ) || ! is_numeric( $_GET['delete_id'] ) ) {
	die();
}

require 'connection.php';

// Prepare the delete statement with a placeholder for the parameter
$sql = $conn->prepare( 'DELETE FROM notes WHERE id=?' );

// Check if the statement could be prepared successfully
if ( $sql ) {
	// Bind the parameter to the statement
	$sql->bind_param( 'i', $_GET['delete_id'] );

	// Execute the statement
	if ( $sql->execute() ) {
		// Check the number of affected rows
		if ( $sql->affected_rows > 0 ) {
			echo 1; // Success indicator
		} else {
			echo 'No rows affected. The record may not exist.';
		}
	} else {
		echo 'Error executing statement: ' . $sql->error;
	}
} else {
	echo 'Error preparing statement: ' . $conn->error;
}
die();