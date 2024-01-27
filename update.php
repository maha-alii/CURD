<?php
// No note variable found, or invalid delete_id, so exit
if ( ! isset( $_POST['id'] ) || ! is_numeric( $_POST['id'] ) ) {
	die();
}
// Added databse connection file
require 'connection.php';

// Update note on user sumbit
if ( isset( $_POST['title'] ) ) {
	// Prepare the update statement with a placeholder for the parameter
	$sql         = $conn->prepare( 'UPDATE notes SET  title=?, description=? WHERE id=? ' );
	$note_id     = $_POST['id'];
	$title       = $_POST['title'];
	$description = $_POST['description'];

	// Check if title is empty
	if ( ! $title ) {
		return;
	}

	// Bind the parameter to the statement
	$sql->bind_param( 'ssi', $title, $description, $note_id );

		// Execute the statement
	if ( $sql->execute() ) {
		// Check the number of affected rows
		if ( $sql->affected_rows > 0 ) {
			echo htmlspecialchars( $note_id ); // Success indicator
		} else {
			echo 'No rows affected. The record may not exist.';
		}
	} else {
		echo 'Error executing statement: ' . htmlspecialchars( $sql->error );
	}
} else {
	echo 'Error preparing statement: ' . htmlspecialchars( $conn->error );
}

die();
