<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Coding Arena</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
		function insert_note() {
			jQuery.ajax({
				url: "insert.php" ,
				type: "get",
				//type: "post",
				//data: {'ad': 123, 'asasasa': 'asasas'},
				success: function (response) {
					// You will get response from your PHP page (what you echo or print)
					if( response ) {
						jQuery('.container').append( response );
						jQuery('.list-notes').hide();
					}					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("error in AJAX request: " + errorThrown);
				}
			});	
		}
		
		function delete_note( id ) {
			jQuery.ajax({
				url: "delete.php?delete_id=" + id,
				type: "get",
				//type: "post",
				//data: {'ad': 123, 'asasasa': 'asasas'},
				success: function (response) {					
					// You will get response from your PHP page (what you echo or print)
					if( response == 1) {
						jQuery('#note-' + id ).remove();
					} else {
						// show error if not deleted
						console.log(response)
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
			border-radius: 2px;
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
			border-radius: 5px;
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
<div class='container'>
	
	<h1>NOTES</h1>
	<a onclick="insert_note()">
		<button class="btn btn-lg btn-primary my-5  float-right-top">Insert</button>
	</a> 
	<a href='show.php'>
		<button class="btn btn-lg btn-primary my-5  float-right-top ">List of notes</button>
	</a> 
				
	<table class="table list-notes">
		<thead>
			<tr>
				<th>S.no</th>
				<th>Title</th>
				<th>Description</th>
				<th>options</th>
			</tr>
		</thead>
		<tbody>
			<?php
			require 'connection.php';
			$sql    = 'SELECT * FROM notes';
			$result = $conn->query( $sql );
			if ( $result->num_rows > 0 ) {
				while ( $row = $result->fetch_assoc() ) {
					$id          = $row['id'];
					$title       = $row['title'];
					$description = $row['description'];
					?>
					<tr id=note-<?php echo htmlspecialchars( $id ); ?>>
						<th><?php echo htmlspecialchars( $id ); ?></th>
						<td><?php echo htmlspecialchars( $title ); ?></td>
						<td><?php echo htmlspecialchars( $description ); ?></td>
						<td>
							<a onclick="update_note(<?php echo htmlspecialchars( $id ); ?>)">
								<button class="btn btn-lg btn-primary">Update</button>
							</a>
							<a onclick="delete_note(<?php echo htmlspecialchars( $id ); ?>)">
								<button class="btn btn-lg btn-danger">Delete</button>
							</a>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
</div>	
</body>
</html>
