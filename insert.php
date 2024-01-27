<?php
// Adding databse connection file
require 'connection.php';


if ( isset( $_POST['title'] ) && isset( $_POST['description'] ) ) {
	$title       = $_POST['title'];
	$description = $_POST['description'];

	// Check if title is empty 
	if ( ! isset( $_POST['title'] ) ) {
		return;
	}

	// Prepare the insert statement with a placeholder for the parameter
	$sql = $conn->prepare( 'INSERT INTO notes (title,description) VALUES (?, ? )' );

	// Check if the statement could be prepared successfully
	if ( $sql ) {
		// Bind the parameter to the statement
		$sql->bind_param( 'ss', $title, $description );

		// Execute the statement
		if ( $sql->execute() ) {
			// Check the number of affected rows
			if ( $sql->affected_rows > 0 ) {
				echo htmlspecialchars( $sql->insert_id ); // Success indicator
			} else {
				echo 'No rows affected. The record may not exist.';
			}
		} else {
			echo 'Error executing statement: ' . htmlspecialchars( $sql->error );
		}
	} else {
		echo 'Error preparing statement: ' . htmlspecialchars( $conn->error );
	}
}
die();
