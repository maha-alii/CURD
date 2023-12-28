

    include 'connection.php';
	$sql = $conn->prepare("DELETE  FROM notes WHERE id=?");  
	$sql->bind_param("i", $_GET["deleteid"]); 
	$sql->execute();
	header('location:show.php');		



?>
