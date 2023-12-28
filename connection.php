			
<?php
 //code for read data from Database
/**
 * Connects with MySQL.
 */
$servername = 'localhost';
$username   = 'root';
$password   = '';
$db         = 'app';


// Create connection
$conn = new mysqli( $servername, $username, $password, $db );

// Check connection
if ( $conn->connect_error ) {
	die( 'Connection failed: ' . htmlspecialchars( $conn->connect_error ) );
}
?>