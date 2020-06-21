<?php

		//MYSQLi
		//connect to database

	$conn = mysqli_connect('localhost', 'Arshitha', 'minu202000','book_page');

	//check connection

	if(!$conn){
		echo 'Connection error:  '.mysqli_connect_error();
	}

	//retrieve the data from db
	//write query for all books

	$sql = 'SELECT title, AG, id FROM books ORDER BY created_at'; //create a variable eg:sql and store the query in that
	//we are ordering them by the time they were created

	//Make query and  get results

	$result = mysqli_query($conn, $sql);//Making the query work with the connection to db

	//fetch the resulting rows

	$books = mysqli_fetch_all($result, MYSQLI_ASSOC); // fetching the result and converting into an associative array, grabs all arrays

	//freeing the mysql memory after array convertion

	mysqli_free_result($result);

	//close connection to db

	mysqli_close($conn);

	//print_r($books);

	//EXPLODE

	//explode(',', $books[0]['AG']); to convert a string into an array in php


?>
<!DOCTYPE html>
<html>
<head>
	<title>Add a book</title>
</head>
<body>
	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">BOOKS!</h4>
	<div class="container">
		<div class="row">
			<?php foreach ($books as $book) { ?>

			<div class="col s6 md3">
				<div class="card z-depth-0">
					<img src="img/book.jpg" class="book">
					<div class="card-content center">
						<h6><?php echo htmlspecialchars($book['title']);?></h6>
						<div>
							<ul>
								<?php foreach(explode(',', $book['AG']) as $ag){ ?>
									<li><?php echo htmlspecialchars($ag);  ?></li>
							<?php  } ?>
									
							</ul>
						</div>
					</div>
					<div class="card-action right-align">
						<a class="brand-text" href="details.php?id=<?php echo $book['id']?>">More info</a>
					</div>
				</div>
			</div>


		<?php  }    ?>
			

		</div>
	</div>
	<?php include('templates/footer.php'); ?>
</body>
</body>
</html>
