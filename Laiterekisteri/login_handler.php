<?php
	session_start();
	$username = "";
	$password = "";
	$password2 = "";
	$errors = array();
	 
	// Yhteys tietokantaan	
	
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');

	// Sisäänkirjautuminen
	
	if (isset($_POST['loginBtn'])) {
		$username = mysqli_real_escape_string($database, $_POST['username']);
		$password = mysqli_real_escape_string($database, $_POST['password']);

		if (empty($username)) { 
			echo "<script> alert ('Käyttäjätunnus vaaditaan!')</script>";
			array_push($errors, "Käyttäjätunnus vaaditaan!"); 
		}
	
		if (empty($password)) { 
			echo "<script> alert ('Salasana vaaditaan!')</script>";
			array_push($errors, "Salasana vaaditaan!"); 
		}

		if (count($errors) == 0) {
			$query = "SELECT * FROM asiakas WHERE NIMI='$username' AND SALASANA='$password'";
			$results = mysqli_query($database, $query);
			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				if ($username === 'admin'){
					header('location: laitehallinta.php');
				}
				else {
					header('location: asiakas.php');
				}
				
			}else {
				echo "<script> alert ('Väärä käyttäjätunnus tai salasana!')</script>";
				array_push($errors, "Väärä käyttäjätunnus tai salasana!");
			}
		}
	}

	// Rekisteröinti

if (isset($_POST['register'])) {
		$username = mysqli_real_escape_string($database, $_POST['username']);
		$password = mysqli_real_escape_string($database, $_POST['password']);
		$password2 = mysqli_real_escape_string($database, $_POST['password2']);

	// Tarkistaa että kentät eivät ole tyhjiä ja salasanat täsmäävät

	if (empty($username)) { 
		echo "<script> alert ('Käyttäjätunnus vaaditaan!')</script>";
		array_push($errors, "Käyttäjätunnus vaaditaan!"); 
	}

  	if (empty($password)) { 
		echo "<script> alert ('Salasana vaaditaan!')</script>";
		  array_push($errors, "Salasana vaaditaan!"); 
		}

  	if ($password != $password2) {
		echo "<script> alert ('Salasanat eivät täsmää!')</script>";
	array_push($errors, "Salasanat eivät täsmää!");
	}

	
	$check_user = "SELECT * FROM asiakas WHERE NIMI='$username' LIMIT 1";
	$result = mysqli_query($database, $check_user);
	$user = mysqli_fetch_assoc($result);

	if ($user) {
		if ($user['NIMI'] === $username) {
			echo "<script> alert ('Käyttäjätunnus varattu!')</script>";
			array_push($errors, "Käyttäjätunnus varattu!");
		}
	}							
	
	if (count($errors) == 0) {
		$query = "INSERT INTO `asiakas` (`NIMI`, `SALASANA`) VALUES ('$username', '$password')";
		mysqli_query($database, $query);
		header('location: asiakas.php');	
		exit();	
	}
}

?>


