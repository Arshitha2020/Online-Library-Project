<?php

//	if(isset($_GET['submit'])){//checks wethere the data is sent via clicking submit
//		echo $_GET['email'];
//		echo $_GET['title'];  // if data is passed we will cho all the data seperately with _GET since its a Get method $_Get is a global array which we use when we send data via get method
//		echo $_GET['AG'];
//	}    
//Get and post methods of form


//cross site scripting attack: XSS attack use htmlspecialchars to avoid anyone submitting scripting


$conn = mysqli_connect('localhost', 'Arshitha', 'minu202000','book_page');
$title = $email = $AG=''; // setting the variables empty coz we dont want anything to be displayed on screen when we open the forn
$errors = array('email'=>'','title'=>'','AG'=>''); //to store  the errors and display it in the form aswell
//initially empty
if(isset($_POST['submit'])){


	//check if anycoloumn in the form is empty
	//check email
	if (empty($_POST['email'])) {
		$errors['email']=' An email has to be entered <br />';

	}else{
		$email = $_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ // PHP provided validate func
			$errors['email']="must be a valid email ";
		}
	}


	if (empty($_POST['title'])) {
		$errors['title']=' A title has to be entered <br />';

	}else{
		$title = $_POST['title'];
		if(!preg_match('/^[a-zA-Z\s]+$/', $title))
		{
			$errors['title']="title must be letters and spaces only <br />";
		}
	}


	if (empty($_POST['AG'])) {
		$errors['AG']=' Author and Genre has to be entered <br />';

	}else{
		$AG = $_POST['AG'];
		if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $AG)){
			$errors['AG']="enter valid Author, Genre information";
		}
	}

	
	if(array_filter($errors)){ // this filter is to check the entire form validation to check successfull submission, if no errord this func returs false
		echo "There are errors in the form!";// if true is returned.
	}
		else {

			if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$AG = mysqli_real_escape_string($conn, $_POST['AG']);

			// create sql
			$sql = "INSERT INTO books(title,email,AG) VALUES('$title','$email','$AG')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				//echo "success";
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check
		
	



}
// End of form post validation

?>
<!DOCTYPE html>
<html>
<head>
	<title>Arshis page</title>
</head>
<body>
	<?php include('templates/header.php'); ?>

		<section class="container grey-text">
			<h4 class="center">Add a Book</h4>
			<form class="white" action="add.php" method="POST">

				<label>Your Email:</label>
				<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
				<div class="red-text"><?php echo $errors['email']; ?></div> <!--embedded php code inside html for dynamic content and to display the errors inside the form as well-->

				<label>Book Title:</label>
				<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
				<div class="red-text"><?php echo $errors['title']; ?></div>

				<label>Author and Genre (comma-seperated):</label>
				<input type="text" name="AG" value="<?php echo htmlspecialchars($AG) ?>">
				<div class="red-text"><?php echo $errors['AG']; ?></div>

				<div class="center">
					<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
				</div>
			</form>
		</section>



	<?php include('templates/footer.php'); ?>
</body>
</body>
</html>
