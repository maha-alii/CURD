<?php
// No note variable found so exit
if ( ! isset( $_GET['delete_id'] ) ) {
	die();
}

require 'connection.php';

$sql = $conn->prepare( 'DELETE FROM notes WHERE id=?' );
$sql->bind_param( 'i', $_GET['delete_id'] );

if ( $sql->execute() ) {
	echo 1;
	die();
}
