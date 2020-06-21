<?php 

$conn = mysqli_connect('localhost', 'Arshitha', 'minu202000','book_page'); // establish connection to db

if(isset($_POST['delete'])){
	$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
	$sql= "DELETE FROM books WHERE id= $id_to_delete";

	if(mysqli_query($conn ,$sql)){
		//success if qury is successfully done
		header('Location: index.php');

	}{
		//else failure

		echo "query error: ".mysqli_error($conn);
	}

}

//check get request id parameters
 if(isset($_GET['id'])){

 	$id = mysqli_real_escape_string($conn, $_GET['id']); //escapes any sensitive sql characters it protects db

 	//make sql

 	$sql = "SELECT * FROM books WHERE id= $id";

 	//get query results

 	$result = mysqli_query($conn, $sql);

 	//fetch result in an array format

 	$book = mysqli_fetch_assoc($result);  // grabs just one array

 	mysqli_free_result($result);
 	mysqli_close($conn);


 	//print_r($book);
 }


?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="container center grey-text">
	<?php if($book): ?>

		<h4><?php echo htmlspecialchars($book['title']); ?></h4>
		<p>Created by : <?php echo htmlspecialchars($book['email']);?></p>
		<p><?php echo date($book['created_at']);?></p>
		<h5>Author and Genre</h5>
		<p><?php echo htmlspecialchars($book['AG']); ?></p>

		<!-- Delete form-->

		<form action="details.php" method="POST">
			<input type="hidden" name="id_to_delete" value="<?php echo $book['id']?>">
			<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
		</form>
		

		<?php else: ?>
			<h5>No such book exists!</h5>
		<?php endif; ?>
</div>
<?php include('templates/footer.php'); ?>
</html>
