<?php
// Adding databse connection file
require 'connection.php';


if ( isset( $_POST['save'] ) ) {
	$title       = $_POST['title'];
	$description = $_POST['description'];
	// Prepare the insert statement with a placeholder for the parameter
	$sql = $conn->prepare( 'INSERT INTO notes (title,description) VALUES (?, ? )' );
	// Bind the parameter to the statement
	$sql->bind_param( 'ss', $title, $description );
	// Execute the statement
	if ( $sql->execute() ) {

		header( 'location:show.php' );
	}
}
?>

<h2>Add Notes</h2>			
<form class="form" method="post">
	<div class="form-group">
		<label for="title">Title:</label>
		<input class="form-control" name="title" id="title" >
	</div>
	<div class="form-group">
		<label for="description">Description:</label>
		<input class="form-control" name="description" id="description" >
	</div>
	<button type="button" class="btn btn-primary" name="save">Save</button>
</form>
