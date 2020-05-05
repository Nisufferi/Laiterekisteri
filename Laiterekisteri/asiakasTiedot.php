<?php
session_start();

require_once("login_utils.inc");
include("asiakasHandler.php");

check_session();

?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
</head>
<body>

<div>
<form action="asiakasTiedot.php" method="post">
    <fieldset>

    
    <label for="password">Salasana</label>
    <input type="password" name="password" id="password" value="<?php echo $password; ?>">
    <label for="password2">Vahvista salasana</label>
    <input type="password" name="password2" id="password2" value="<?php echo $password2; ?>">
    <label for="osoite">Osoite</label>
    <input type="text" name="osoite" id="osoite" value="<?php echo $osoite; ?>">

    <label for="postinro">Postinumero</label>    
    <input type="number" name="postinro" id="postinro" value="<?php echo $postinro; ?>">

    <label for="postitmp">Postitoimipaikka</label>    
    <input type="text" name="postitmp" id="postitmp" value="<?php echo $postitmp; ?>">

    <input type="submit" name="modify" id="modify" value="Muokkaa">
    </fieldset>
</form>


</div>
</body>