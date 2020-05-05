<?php

/*
	Tässä tiedostossa on sekailaisia funktioita, joita voidaan tarvita php-tiedostoissa.
*/

/*
	Palauttaa parametrina tulleen datan takaisin UTF8 muodossa.
*/
function parsePost($name)
{
	if ( isset($_POST[$name]) )
		return $_POST[$name];
	else
		return null;
}
function parseGet($name)
{
	if ( isset($_GET[$name]) )
		return $_GET[$name];
	else
		return null;
}
?>
