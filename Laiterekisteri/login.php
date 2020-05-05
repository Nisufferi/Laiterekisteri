<?php 
include("login_handler.php");
?>


<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/Redmond/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
  .dialog { display: none;}

  #kirjaudu {
  margin: auto;
  width: 50%;
  border: 3px solid black;
  padding: 10px;

  }

  #registerBtn {
  background-color: #CBE0E6;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 25%;
}

input{
  background-color: #CBE0E6;
  color: black;
  padding: 14px 0px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

#loginBtn {
	border: 3px solid gray;

}



  </style>
  
    <title>Sisäänkirjautuminen</title>

	<script>
	$(function() {
		$("#registerBtn").click(function() {
		$("#regdialog").dialog({
			width: 600,
			height: 500,
			resizable: true,
			draggable: true
		});

	});

	});
	

</script>

</head>
<body>	
	
	<div id="kirjaudu">
	<form action="" method="post">
	<p align="center">Kirjaudu sisään järjestelmään</p>
		<fieldset>
		<label for="username">Käyttäjätunnus</label>
		<input type="text" name="username" id="username" value=""/> 
		<label for="password">Salasana</label>
		<input type="password" name="password" id="password" value=""/> 
		<input type="submit" id="loginBtn" name="loginBtn" value="Kirjaudu"/><br>
		
		</fieldset>	
	</form>
	<div style="text-align:center;">
	<input id="registerBtn" type="button" value="Rekisteröidy"/>
	</div>
	</div>

	

	<div id ="regdialog" class="dialog" title="Rekisteröidy">
	<p class="validateTips">Kaikki tiedot ovat pakollisia.</p>
	<form action="login.php" method="post">
		<fieldset>
		<label for="username">Käyttäjänimi</label>
		<input type="text" name="username" id="username" value="" placeholder="Syötä käyttäjänimi" required>
		<label for="password">Salasana</label>
		<input type="password" name="password" id="password" value="" placeholder="Syötä salasana" required>
		<input type="password" name="password2" id="password2" value="" placeholder="Syötä salasana uudestaan" required>
		<input type="submit" name="register" id="register" value="Rekisteröidy">
		</fieldset>
	</form>
	</div>

	
</body>
</html>