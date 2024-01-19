<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Coding Arena</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
	<link href="css/note-styles.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script>
		
	function update_note( id ) {
		var title = jQuery('#note-' + id).find('.note-title').text();
		var description = jQuery('#note-' + id).find('.note-description ').text();
		
		jQuery('#list-notes-wrap').hide();
		jQuery('#add-note-wrap').show();
		jQuery('#note_id').val(id);
		jQuery('#title').val(title);
		jQuery('#description').val(description);
	}
	
	function insert_note() {
		var note_id = jQuery('#note_id').val();
		var title = jQuery('#title').val();
		var description = jQuery('#description').val();
		/* When Updating a Note Via AJAX */
		if ( note_id ) {
			jQuery.ajax({
				url: "update.php",
				type: "post",
				data: {
					'id': note_id,
					'title': title,
					'description': description
				},
				success: function(response) {
					if (!isNaN(response)) {
						jQuery('#list-notes-wrap').show();
						jQuery('#add-note-wrap').hide();
						
						
						jQuery('#note-' + note_id).find('.note-title').text(title);
						jQuery('#note-' + note_id).find('.note-description').text(description);
					} else {
						// show error if not deleted
						console.log(response)
					}

				}
		  });
		} else {
			/* When Inserting a Note Via AJAX */
			jQuery.ajax({
				url: "insert.php",
				type: "post",
				data: {
					'title': title,
					'description': description
				},
				success: function(response) {
					// You will get response from your PHP page (what you echo or print)
					if (!isNaN(response)) {
						var note_id = response;
						jQuery('#list-notes-body').append(
							'<tr id=note-' + note_id + '>\
						<th>' + note_id + '</th>\
						<td class="note-title">' + title + '</td>\
						<td class="note-description">' + description + '</td>\
						<td> \
							<a onclick="update_note(' + note_id + ')">\
								<button class="btn btn-lg btn-primary">Update</button>\
							</a>\
							<a onclick="delete_note(' + note_id + ')">\
								<button class="btn btn-lg btn-danger">Delete</button>\
							</a>\
						</td>\
					</tr>'
						);
						jQuery('#list-notes-wrap').show();
						jQuery('#add-note-wrap').hide();
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
	}
	
	function show_list_note() {
		jQuery('#list-notes-wrap').show();
		jQuery('#add-note-wrap').hide();
	}
	
	function show_insert_note() {
		// Empty the note id, title and desc before insert form display
		jQuery('#title').val('');
		jQuery('#description').val('');
		jQuery('#note_id').val('');
		
		jQuery('#list-notes-wrap').hide();
		jQuery('#add-note-wrap').show();
	}

	function delete_note(id) {
		jQuery.ajax({
			url: "delete.php?delete_id=" + id,
			type: "get",
			success: function(response) {
				// You will get response from your PHP page (what you echo or print)
				if (response == 1) {
					jQuery('#note-' + id).remove();
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
		<form class="form" method="post">
			<div class="form-group">
				<label for="title">Title:</label>
				<input class="form-control" name="title" id="title" required>
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
