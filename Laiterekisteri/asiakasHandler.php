<?php
	session_start();
	require_once("db_utils.inc");
	require_once("login_utils.inc");
	check_session();


			if (isset($_POST['muokkaa'])) {
				$a['nimi'] = $_POST['nimi'];
        		$a['osoite'] = $_POST['osoite'];
        		$a['postinro'] = $_POST['postinro'];
        		$a['postitmp'] = $_POST['postitmp'];
        		$a['salasana'] = $_POST['salasana'];
        		$a['salasana2'] = $_POST['salasana2'];

        		muokkaaTietoja($a);
				
			}
			if (isset($_GET['username'])) {
				$username = parseGet('username');
        		$data = getTiedot($username);

        		foreach($data as $row)
        		{

            	$a = $row['NIMI'];
            	$b = $row['OSOITE'];
            	$c = $row['POSTINRO'];
            	$d = $row['POSTITMP'];
            	echo "<form id='formimuokkaa'>";
				echo "<input type='hidden' name='muokkaa' />";
				echo "<input type='text' id='nimi_muok' name='nimi' value='$a' placeholder='Nimi' readonly>";
				echo "<input type='text' id='osoite_muok' name='osoite' value='$b' placeholder='Osoite'>";
				echo "<input type='text' id='postinro_muok' name='postinro' value='$c' placeholder='Postinumero'>";
				echo "<input type='text' id='postitmp_muok' name='postitmp' value='$d' placeholder='Postitoimipaikka'>";
				echo "<input type='password' id='salasana_muok' name='salasana' value='' placeholder='Salasana'>";
				echo "<input type='password' id='salasana1_muok' name='salasana2' value='' placeholder='Salasana uudelleen'>";
      			echo "</form>";
  
        		}
			}
			if (isset($_GET['haeLaitteet'])){
    
				$nimi = parseGet('nimi');
				$malli = parseGet('malli');
				$merkki = parseGet('merkki');
				$sijainti = parseGet('sijainti');
				$kuvaus = parseGet('kuvaus');
				$kategoria = parseGet('kategoria');
				$omistaja = parseGet('omistaja');
				$sarjanumero = parseGet('sarjanumero');
				
				
				$data = haeLaitteet($nimi, $malli, $merkki, $sijainti, $kuvaus, $kategoria, $omistaja, $sarjanumero);
				echo "<table border='1'>";
				echo "<tr>
				<th>Sarjanumero</th>
				<th>Nimi</th>
				<th>Malli</th>
				<th>Merkki</th>
				<th>Sijainti</th>
				<th>Kuvaus</th>
				<th>Kategoria</th>
				<th>Omistaja</th>
				</tr>";
				foreach($data as $row)
				{
		
					$a = $row['SARJANUMERO'];
					$b = $row['NIMI'];
					$c = $row['MALLI'];
					$d = $row['MERKKI'];
					$e = $row['SIJAINTI'];
					$f = $row['KUVAUS'];
					$g = $row['KATEGORIA'];
					$h = $row['OMISTAJA'];
					echo "<tr>";
					echo "<td>". $row['SARJANUMERO']. "</td>";
					echo "<td>". $row['NIMI']. "</td>";
					echo "<td>". $row['MALLI']. "</td>";
					echo "<td>". $row['MERKKI']. "</td>";
					echo "<td>". $row['SIJAINTI']. "</td>";
					echo "<td>". $row['KUVAUS']. "</td>";
					echo "<td>". $row['KATEGORIA']. "</td>";
					echo "<td>". $row['OMISTAJA']. "</td>";
					echo "<td><button id= 'varaaLaite' class='varaaLaite' onClick='getVaraustiedot($a);'>Varaa</button></td>";
					echo "<td><a href='varaushistoria.php'>Varaushistoria</a></td>";
					
					echo "</tr>";
				}
				echo "</table>";
			}
			if(isset($_GET['sarjanumero'])){
				$sarjanumero = parseGet('sarjanumero');
				$data = getLaitetiedot($sarjanumero);
				$data2 = haePaivat($sarjanumero);
				$asiakasid = getAsiakasid();
		
				foreach($data as $row)
				{
					
					$b = $row['NIMI'];
					$c = $row['MALLI'];
					$d = $row['MERKKI'];
					$e = $row['SIJAINTI'];
					$f = $row['KUVAUS'];
					$g = $row['KATEGORIA'];
					$h = $row['OMISTAJA'];
					$i = $row['STATUS_NIMI'];
					echo "<form id='formivaraa'>";
					echo "<input type='hidden' name='varaus' />";
					echo "<input type='hidden' name='sarjanumero' value='$sarjanumero' hidden />";
					echo "<input type='hidden' name='asiakasid' value='$asiakasid' hidden />";
					echo "<input type='text' id='nimi_varaa' name='nimi' value='$b' disabled >";
					echo "<input type='text' id='malli_varaa' name='malli' value='$c' disabled >";
					echo "<input type='text' id='datepickerAlku' name='alkupvm' onfocus='datePickeralku($sarjanumero);' placeholder='Alkupäivämäärä'>";
					echo "<input type='text' id='datepickerLoppu' name='loppupvm' onfocus='datePickerloppu($sarjanumero);' placeholder='Loppupäivämäärä'>";
					echo "<label>Varatut päivät:</label><br>";
					echo "<ul class='lista'>";
					foreach($data2 as $row)
				{
					
					$pvm = $row['selected_date'];
					echo "<li>$pvm</li>";

					

					
				}
					echo "</ul>";
				

					

					echo "</form>";
				}
			}
			if(isset($_POST['varaus'])){
				$a['sarjanumero'] = $_POST['sarjanumero'];
				$a['asiakasid'] = $_POST['asiakasid'];
				$a['alkupvm'] = $_POST['alkupvm'];
				$a['loppupvm'] = $_POST['loppupvm'];
				lisaaVaraus($a);
			}

			if (isset($_GET['haevaraukset'])){
				
				$varaustiedot = getVaraukset();
				echo "<table border='1'>";
				echo "<tr>
				<th>Status</th>
				<th>Varaus ID</th>
				<th>Alkupvm</th>
				<th>Loppupvm</th>
				<th>Sarjanumero</th>
				<th>Nimi</th>
				<th>Malli</th>
				<th>Merkki</th>
				</tr>";
				foreach($varaustiedot as $row)
				{
		
					$varausid = $row['VARAUS_ID'];
					$sarjanumero = $row['SARJANUMERO'];
					$alkupvm = $row['ALKUPVM'];
					$loppupvm = $row['LOPPUPVM'];
					$status = $row['STATUS_NIMI'];
					echo "<tr>";
					echo "<td>". $row['STATUS_NIMI']. "</td>";
					echo "<td>". $row['VARAUS_ID']. "</td>";
					echo "<td>". $row['ALKUPVM']. "</td>";
					echo "<td>". $row['LOPPUPVM']. "</td>";
					echo "<td>". $row['SARJANUMERO']. "</td>";
					$laitetiedot = getLaitetiedot($sarjanumero);
					foreach($laitetiedot as $row){
						$nimi = $row['NIMI'];
						$malli = $row['MALLI'];
						$merkki = $row['MERKKI'];
						echo "<td>". $row['NIMI']. "</td>";
						echo "<td>". $row['MALLI']. "</td>";
						echo "<td>". $row['MERKKI']. "</td>";
						echo "<td><button class='poistaVaraus' onClick='poistaVaraus($varausid);'>Poista varaus</button></td>";
						echo "<td><button class='muokkaaVaraus' onClick='muokkaaVaraus($varausid);'>Muokkaa varausta</button></td>";
						echo "</tr>";

					}
				}
				echo "</table>";
			}

			if (isset($_GET['haelainat'])){
				
				$lainaustiedot = getLainat();
				echo "<table border='1'>";
				echo "<tr>
				<th>Status</th>
				<th>Varaus ID</th>
				<th>Alkupvm</th>
				<th>Loppupvm</th>
				<th>Sarjanumero</th>
				<th>Nimi</th>
				<th>Malli</th>
				<th>Merkki</th>
				</tr>";
				foreach($lainaustiedot as $row)
				{
		
					$varausid = $row['VARAUS_ID'];
					$sarjanumero = $row['SARJANUMERO'];
					$alkupvm = $row['ALKUPVM'];
					$loppupvm = $row['LOPPUPVM'];
					$status = $row['STATUS_NIMI'];
					echo "<tr>";
					echo "<td>". $row['STATUS_NIMI']. "</td>";
					echo "<td>". $row['VARAUS_ID']. "</td>";
					echo "<td>". $row['ALKUPVM']. "</td>";
					echo "<td>". $row['LOPPUPVM']. "</td>";
					echo "<td>". $row['SARJANUMERO']. "</td>";
					$laitetiedot = getLaitetiedot($sarjanumero);
					foreach($laitetiedot as $row){
						$nimi = $row['NIMI'];
						$malli = $row['MALLI'];
						$merkki = $row['MERKKI'];
						echo "<td>". $row['NIMI']. "</td>";
						echo "<td>". $row['MALLI']. "</td>";
						echo "<td>". $row['MERKKI']. "</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
			}

			if(isset($_GET['poistavaraus'])){
				$varausid = $_GET['varausid'];
				deleteVaraus($varausid);
			}

			/*if (isset($_GET['sessionpaivat'])) {
				
				haePaivat();
				
			}*/

			if(isset($_GET['muokkaavaraus'])){
				$varausid = parseGet('varausid');
				$data3 = getVaraustiedot($varausid);
				$x;
				foreach($data3 as $row)
				{
					$x = $row['SARJANUMERO'];
				}
				$data = getLaitetiedot($x);
				$data2 = haePaivat($x, $varausid);
				$asiakasid = getAsiakasid();
		
				foreach($data as $row)
				{
					
					$b = $row['NIMI'];
					$c = $row['MALLI'];
					$d = $row['MERKKI'];
					$e = $row['SIJAINTI'];
					$f = $row['KUVAUS'];
					$g = $row['KATEGORIA'];
					$h = $row['OMISTAJA'];
					$i = $row['STATUS_NIMI'];
					echo "<form id='formimuokkaavaraus'>";
					echo "<input type='hidden' name='muokkaavarauskantaan' />";
					echo "<input type='hidden' name='sarjanumero' value='$x' hidden />";
					echo "<input type='hidden' name='varausid' value='$varausid' hidden />";
					echo "<input type='hidden' name='asiakasid' value='$asiakasid' hidden />";
					echo "<input type='text' id='nimi_varaa' name='nimi' value='$b' disabled >";
					echo "<input type='text' id='malli_varaa' name='malli' value='$c' disabled >";
					echo "<input type='text' id='datepickerAlku' name='alkupvm' onfocus='datePickeralku($x);' placeholder='Alkupäivämäärä'>";
					echo "<input type='text' id='datepickerLoppu' name='loppupvm' onfocus='datePickerloppu($x);' placeholder='Loppupäivämäärä'>";
					echo "<label>Varatut päivät:</label><br>";
					echo "<ul class='lista'>";
					foreach($data2 as $row)
				{
					
					$pvm = $row['selected_date'];
					echo "<li>$pvm</li>";
					
				}
					echo "</ul>";
	
					echo "</form>";
				}
			}

			if(isset($_POST['muokkaavarauskantaan'])){
				$varausid = $_POST['varausid'];
        		$alkupvm = $_POST['alkupvm'];
				$loppupvm = $_POST['loppupvm'];
				$status = "";
				
				muokkaaVarauskantaan($varausid, $alkupvm, $loppupvm, $status);
			}

?>