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


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Coding Arena</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script>
	function insert_note( id ) {
			jQuery.ajax({
				url: "insert.php?id=" + id,
				type: "get",
				//type: "post",
				//data: {'ad': 123, 'asasasa': 'asasas'},
				success: function (response) {
					// You will get response from your PHP page (what you echo or print)
					console.log(response)
					if( response ) {
						jQuery('#note-' + id ).insert();
					}					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("error in AJAX request: " + errorThrown);
				}
			});	
		}
	</script>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<style>
	
	* {
			font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Oxygen-Sans", Ubuntu, "Cantarell", "Helvetica Neue", sans-serif;
		}
		body {
			font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Oxygen-Sans", Ubuntu, "Cantarell", "Helvetica Neue", sans-serif;
			background-color: #f2f2f2;
			margin: 0;
			padding: 0;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		.container {
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
			max-width: 1000px;
		}

		h1, h2, h3 {
			color: #333;
			
		}

		div {
			background-color: #f5f5f5;
			padding: 5px;
			color: #4f4f4f;
			border: 1px solid #ddd;
			border-radius: 3px;
			display: block;
		}
		table, th, td {
	border:1px solid black;
}
		
		/* Style input fields and buttons */
		/* Add more styles as needed */
	</style>
</head>
<body>
	<div class="container">
		<h1>My Coding Arena</h1>
		<p>The code shows here:</p>
		<div>
			<!-- Add your code below this line -->

			<h2>Notes</h2>
			<a  onclick="insert_note(' . htmlspecialchars( $id ) . ')">
					<button class="btn btn-lg btn-primary my-5  float-end">Insert</button>
				</a> 
				<a  href='show.php'>
					<button class="btn btn-lg btn-primary my-5  float-end ">List of notes</button>
				</a> 
			
			<form action="" method="post">
				<div class="form-group">
					<label for="title">Title:</label>
					<input   name="title" id="title" >
				</div>
				<div class="form-group">
					<label for="description">Description:</label>
					<input   name="description" id="description" >
				</div>
					<button type="save" class="btn btn-primary" name="save">Save</button>
				</form>    

	<div>
</body>
</html>
