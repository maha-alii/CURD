<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Coding Arena</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
	<link href="css/note-styles.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="js/crud.js"> </script>
	<link href="css/template.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	
</head>
<body>
<div class='container'>

	<h1>NOTES</h1>
	<a onclick="show_insert_note()">
		<button class="btn btn-lg btn-primary my-5  float-right-top">Insert</button>
	</a>
	<a onclick="show_list_note()">
		<button class="btn btn-lg btn-primary my-5  float-right-top ">List of notes</button>
	</a>

	<table id="list-notes-wrap" class="table">
		<thead>
			<tr>
				<th>S.no</th>
				<th>Title</th>
				<th>Description</th>
				<th>options</th>
			</tr>
		</thead>
		<tbody id="list-notes-body">
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
						<th class="id"><?php echo htmlspecialchars( $id ); ?></th>
						<td class="note-title"><?php echo htmlspecialchars( $title ); ?></td>
						<td class="note-description"><?php echo htmlspecialchars( $description ); ?></td>
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

	<!-- HTML structre for Add Note -->
	<div id="add-note-wrap">
		<h2>Add Notes</h2>
		<form class="form" method="post" >
			<div class="form-group">
				<label for="title">Title:</label>
				<input class="form-control" name="title" id="title" required>
				<p class="text-danger"  id="title-warning" display=' hidden'>This field is required</p>
			</div>
			<div class="form-group">
				<label for="description">Description:</label>
				<input class="form-control" name="description" id="description">
			</div>
			<input class="form-control" type="hidden" name="note_id" id="note_id" value="">
			<button onclick="insert_note()" type="button" class="btn btn-primary" name="save">Save</button>
		</form>
	</div>
</div>
</body>
</html>
