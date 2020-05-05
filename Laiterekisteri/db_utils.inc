<?php
/*
	Tässä tiedostossa on funktioita, jotka käsittelevät Asiakas-taulua.
	Muiden taulujen funktiot kannattaa tehdä omiin tiedostoihinsa.
*/

require_once("db.inc");
require_once("utils.inc");

function createLaite($laite)
{
	
	
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	
	$nim = $laite['nimi'];
	$mal = $laite['malli'];
	$mer = $laite['merkki'];
	$sij = $laite['sijainti'];
	$omis = $laite['omistaja'];
	$kateg = $laite['kategoria'];
	$kuv = $laite['kuvaus'];

	$query = "INSERT INTO laite (NIMI, MALLI, MERKKI, SIJAINTI, OMISTAJA, KATEGORIA, KUVAUS) 
								VALUES ('$nim', '$mal', '$mer', '$sij', '$omis', '$kateg', '$kuv')";
	mysqli_query($database, $query);
}
function muokkaaLaite($laite){

	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');

	$sarj = $laite['sarjanumero'];
    $nim = $laite['nimi'];
	$mal = $laite['malli'];
	$mer = $laite['merkki'];
	$sij = $laite['sijainti'];
	$omis = $laite['omistaja'];
	$kateg = $laite['kategoria'];
	$kuv = $laite['kuvaus'];

	$query = "UPDATE laite SET NIMI='$nim', MALLI='$mal', MERKKI='$mer', SIJAINTI='$sij', OMISTAJA='$omis', KATEGORIA='$kateg', KUVAUS='$kuv' WHERE SARJANUMERO='$sarj'";
	
	mysqli_query($database, $query);
}
function haeLaitteet($a, $b, $c, $d, $e, $f, $g, $h){
	$tulos = array();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	
    	$query = "SELECT * FROM laite WHERE 1=1 ";
		if (!empty($a)) $query .= " AND nimi LIKE '%$a%'";
		if (!empty($b)) $query .= " AND malli LIKE '%$b%'";
		if (!empty($c)) $query .= " AND merkki LIKE '%$c%'";
		if (!empty($d)) $query .= " AND sijainti LIKE '%$d%'";
		if (!empty($e)) $query .= " AND kuvaus LIKE '%$e%'";
		if (!empty($f)) $query .= " AND kategoria LIKE '%$f%'";
		if (!empty($g)) $query .= " AND omistaja LIKE '%$g%'";
		if (!empty($h)) $query .= " AND sarjanumero LIKE '%$h%'";
		
			$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$nimi = $rivi['NIMI'];
			$malli = $rivi['MALLI'];
			$merkki = $rivi['MERKKI'];
			$sijainti = $rivi['SIJAINTI'];
			$omistaja = $rivi['OMISTAJA'];
			$kategoria = $rivi['KATEGORIA'];
			$kuvaus = $rivi['KUVAUS'];
			$sarjanumero = $rivi['SARJANUMERO'];
			$tulos[] = $rivi;
			}
		
		
	return $tulos;


}
function deleteLaite($sarjanumero){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');

	/*$query = "DELETE FROM laite WHERE SARJANUMERO ='$sarjanumero'";
	mysqli_query($database, $query);*/

	$query1 = "SELECT * FROM varaus WHERE SARJANUMERO='$sarjanumero'";
			$results = mysqli_query($database, $query1);
			if (mysqli_num_rows($results) > 0) {
				$query = "UPDATE laite SET STATUS_NIMI='POISTETTU' WHERE SARJANUMERO='$sarjanumero'";
				mysqli_query($database, $query);
				echo "<script> alert('Laitteelle liittyy varaus/lainaus. Laitettu poistettu tilaan.')</script>";
			}else {
				$query = "DELETE FROM laite WHERE SARJANUMERO ='$sarjanumero'";
				mysqli_query($database, $query);
				echo "<script> alert('Laite poistettu tietokannasta')</script>";
			}
}

function getMuokkaa($sarjanumero){
	$tulos = array();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM laite WHERE SARJANUMERO ='$sarjanumero'";
	$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$nimi = $rivi['NIMI'];
			$malli = $rivi['MALLI'];
			$merkki = $rivi['MERKKI'];
			$sijainti = $rivi['SIJAINTI'];
			$omistaja = $rivi['OMISTAJA'];
			$kategoria = $rivi['KATEGORIA'];
			$kuvaus = $rivi['KUVAUS'];
			$sarjanumero = $rivi['SARJANUMERO'];
			$tulos[] = $rivi;
			}
			return $tulos;
}
function getTiedot($username){
	$tulos = array();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM asiakas WHERE NIMI ='$username'";
	$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$nimi = $rivi['NIMI'];
			$osoite = $rivi['OSOITE'];
			$postinro = $rivi['POSTINRO'];
			$postitmp = $rivi['POSTITMP'];
			$tulos[] = $rivi;
			}
			return $tulos;

}
function muokkaaTietoja($asiakas){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');

	$nimi = $asiakas['nimi'];
    $osoite = $asiakas['osoite'];
	$postinro = $asiakas['postinro'];
	$postitmp = $asiakas['postitmp'];
	$salasana = $asiakas['salasana'];

	$query = "UPDATE asiakas SET OSOITE='$osoite', POSTINRO='$postinro', POSTITMP='$postitmp', SALASANA='$salasana' WHERE NIMI='$nimi'";
	
	mysqli_query($database, $query);

}
function getLaitetiedot($sarjanumero){
	$tulos = array();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM laite WHERE SARJANUMERO ='$sarjanumero'";
	$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$nimi = $rivi['NIMI'];
			$malli = $rivi['MALLI'];
			$merkki = $rivi['MERKKI'];
			$sijainti = $rivi['SIJAINTI'];
			$kuvaus = $rivi['KUVAUS'];
			$kategoria = $rivi['KATEGORIA'];
			$omistaja = $rivi['OMISTAJA'];
			$status = $rivi['STATUS_NIMI'];
			$tulos[] = $rivi;
			}
			return $tulos;
}

function getAsiakasid(){
	$nimi = $_SESSION['username'];
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT ASIAKAS_ID FROM asiakas WHERE NIMI ='$nimi'";
	$result = mysqli_query($database, $query);
	$a = mysqli_fetch_assoc($result);
	$asiakasid = $a['ASIAKAS_ID'];
	return $asiakasid;
}

function lisaaVaraus($varaus){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');

	$sarjanumero = $varaus['sarjanumero'];
    $asiakasid = $varaus['asiakasid'];
	$alkupvm = $varaus['alkupvm'];
	$loppupvm = $varaus['loppupvm'];
	$status = $varaus['status'];

	$query = "INSERT INTO varaus (SARJANUMERO, ALKUPVM, LOPPUPVM, STATUS_NIMI, ASIAKAS_ID) VALUES ($sarjanumero, '$alkupvm', '$loppupvm', 'VARATTU', $asiakasid)";
	if ($status != ""){
		$query = "INSERT INTO varaus (SARJANUMERO, ALKUPVM, LOPPUPVM, STATUS_NIMI, ASIAKAS_ID) VALUES ($sarjanumero, '$alkupvm', '$loppupvm', 'HUOLTO', $asiakasid)";
	}
	/*$query = "INSERT INTO varaus (SARJANUMERO, ALKUPVM, LOPPUPVM, STATUS_NIMI, ASIAKAS_ID) VALUES (6, '2018-12-05', '2018-12-06', 'VARATTU', 1)";*/
	mysqli_query($database, $query);
}



function getVaraukset() {
	$tulos = array();
	$asiakasid = getAsiakasid();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM varaus WHERE ASIAKAS_ID ='$asiakasid' AND STATUS_NIMI='VARATTU'";
	if ($_SESSION['username'] === 'admin'){
		$query = "SELECT * FROM varaus WHERE STATUS_NIMI='VARATTU'";
	}
	$result = mysqli_query($database, $query);
		while ($rivi = mysqli_fetch_array($result))
			{
			$varausid = $rivi['VARAUS_ID'];
			$sarjanumero = $rivi['SARJANUMERO'];
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$status = $rivi['STATUS_NIMI'];
			$tulos[] = $rivi;
			}
			return $tulos;
	

}
 
function deleteVaraus($varausid){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');


		$query = "SELECT * FROM varaus WHERE VARAUS_ID ='$varausid'";
		$result = mysqli_query($database, $query);
		$tila2 = mysqli_fetch_assoc($result);
		$tila = $tila2['STATUS_NIMI'];
			if ($tila === 'LAINATTU') {
				echo "<script> alert('Varausta ei voi poistaa, koska siitä on lainaus.')</script>";
			}else {
				$query = "DELETE FROM varaus WHERE VARAUS_ID ='$varausid'";
				mysqli_query($database, $query);
				echo "<script> alert('Varaus poistettu tietokannasta')</script>";
			}
}

function haePaivat($sarjanumero){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$tulos = array();
	$query1 = "SELECT * FROM varaus WHERE SARJANUMERO='$sarjanumero' AND NOT STATUS_NIMI='PALAUTETTU'";
	$result1 = mysqli_query($database, $query1);
		while ($rivi = mysqli_fetch_array($result1))
			{
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$query = "select * from 
			(select adddate(CURDATE(),t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
 			(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 			(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 			(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 			(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 			(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
			where selected_date between '$alkupvm' and '$loppupvm'";

			$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$pvm = $rivi['selected_date'];
			$tulos[] = $rivi;
			}
			
			}
			return $tulos;
}
function haePaivatmuok($sarjanumero, $varausid){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$tulos = array();
	$query1 = "SELECT * FROM varaus WHERE SARJANUMERO='$sarjanumero' AND NOT VARAUS_ID='$varausid'";
	$result1 = mysqli_query($database, $query1);
		while ($rivi = mysqli_fetch_array($result1))
			{
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$query = "select * from 
			(select adddate(CURDATE(),t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
 			(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
 			(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
 			(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
 			(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
 			(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
			where selected_date between '$alkupvm' and '$loppupvm'";

			$result = mysqli_query($database, $query);
			while ($rivi = mysqli_fetch_array($result))
			{
			$pvm = $rivi['selected_date'];
			$tulos[] = $rivi;
			}
			
			}
			return $tulos;
}

function getLainat() {
	$tulos = array();
	$asiakasid = getAsiakasid();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM varaus WHERE ASIAKAS_ID ='$asiakasid' AND STATUS_NIMI='LAINATTU'";
	if ($_SESSION['username'] === 'admin'){
		$query = "SELECT * FROM varaus WHERE STATUS_NIMI='LAINATTU'";
	}
	$result = mysqli_query($database, $query);
		while ($rivi = mysqli_fetch_array($result))
			{
			$varausid = $rivi['VARAUS_ID'];
			$sarjanumero = $rivi['SARJANUMERO'];
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$status = $rivi['STATUS_NIMI'];
			$tulos[] = $rivi;
			}
			return $tulos;
	

}
function getMuut() {
	$tulos = array();
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = $query = "SELECT * FROM varaus WHERE STATUS_NIMI='HUOLTO' OR STATUS_NIMI='POISTETTU'";
	$result = mysqli_query($database, $query);
		while ($rivi = mysqli_fetch_array($result))
			{
			$varausid = $rivi['VARAUS_ID'];
			$sarjanumero = $rivi['SARJANUMERO'];
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$status = $rivi['STATUS_NIMI'];
			$tulos[] = $rivi;
			}
			return $tulos;
	

}

function getVaraustiedot($varausid){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "SELECT * FROM varaus WHERE VARAUS_ID ='$varausid'";
	$result = mysqli_query($database, $query);
		while ($rivi = mysqli_fetch_array($result))
			{
			$sarjanumero = $rivi['SARJANUMERO'];
			$alkupvm = $rivi['ALKUPVM'];
			$loppupvm = $rivi['LOPPUPVM'];
			$tulos[] = $rivi;
			}
			return $tulos;
}

function muokkaaVarauskantaan($varausid, $alkupvm, $loppupvm, $status){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "UPDATE varaus SET ALKUPVM='$alkupvm', LOPPUPVM='$loppupvm', STATUS_NIMI='$status' WHERE VARAUS_ID='$varausid'";
	if ($status === ""){
		$query = "UPDATE varaus SET ALKUPVM='$alkupvm', LOPPUPVM='$loppupvm' WHERE VARAUS_ID='$varausid'";
	}
	if ($alkupvm === "" && $loppupvm === ""){
		$query = "UPDATE varaus SET STATUS_NIMI='$status' WHERE VARAUS_ID='$varausid'";
	}
	mysqli_query($database, $query);
}

function muokkaaLainakantaan($varausid, $alkupvm, $loppupvm, $palautuspvm, $status){
	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
	$query = "UPDATE varaus SET ALKUPVM='$alkupvm', LOPPUPVM='$loppupvm', STATUS_NIMI='$status' WHERE VARAUS_ID='$varausid'";
	if ($status === ""){
		$query = "UPDATE varaus SET ALKUPVM='$alkupvm', LOPPUPVM='$loppupvm' WHERE VARAUS_ID='$varausid'";
	}
	if ($alkupvm === "" && $loppupvm === ""){
		$query = "UPDATE varaus SET STATUS_NIMI='$status' WHERE VARAUS_ID='$varausid'";
	}
	if ($palautuspvm != ""){
		$query = "UPDATE varaus SET STATUS_NIMI='$status', LOPPUPVM='$palautuspvm' WHERE VARAUS_ID='$varausid'";
	}
	mysqli_query($database, $query);
}



?>