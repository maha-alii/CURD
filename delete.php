<?php
/*include 'connection.php';
if(isset($_GET['deleteid'])){
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM notes WHERE id=$id";
    $result = mysqli_query( $conn, $sql );
    if($result){
        //echo'Deleted successfully';
        header('location:show.php');
	}
	else{
		die( 'Connection failed: ' . htmlspecialchars( $conn->connect_error ) );
	}
}*/

    include 'connection.php';
	$sql = $conn->prepare("DELETE  FROM notes WHERE id=?");  
	$sql->bind_param("i", $_GET["deleteid"]); 
	$sql->execute();
	header('location:show.php');		



?>