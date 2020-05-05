<?php
    session_start();
    require_once("db_utils.inc");
    require_once("login_utils.inc");
    check_session();
    
    
    if(isset($_GET['haetiedot'])){
        $sarjanumero = parseGet('sarjanumero');
        $data = getLaitetiedot($sarjanumero);

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
            echo "<form id='formimuokkaa'>";
            echo "<input type='hidden' name='muokkaa' />";
            echo "<input type='hidden' name='sarjanumero' value='$a' />";
            echo "<input type='text' id='nimi_muok' name='nimi' value='$b' >";
            echo "<input type='text' id='malli_muok' name='malli' value='$c' >";
            echo "<input type='text' id='merkki_muok' name='merkki' value='$d' >";
            echo "<input type='text' id='sijainti_muok' name='sijainti' value='$e' >";
            echo "<input type='text' id='kuvaus_muok' name='kuvaus' value='$f' >";
            $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
            $sql = mysqli_query($database, "SELECT KATEGORIA FROM KATEGORIA");

            echo "</select><br>";
            echo "<label for='kategoria'>Kategoria:</label><br>";
            echo "<select name='kategoria' id='kategoria_muok'><br>";
            echo "<option selected='selected'></option>";
            while ($row = $sql->fetch_assoc()) {
                echo '<option value="'.$row['KATEGORIA'].'">' . $row['KATEGORIA'] . '</option>';
            }
            echo "</select><br>";
            $sql = mysqli_query($database, "SELECT OMISTAJA FROM LAITE");

            echo "</select><br>";
            echo "<label for='omistaja'>Omistaja:</label><br>";
            echo "<select name='omistaja' id='omistaja_muok'><br>";
            echo "<option selected='selected'></option>";
            while ($row = $sql->fetch_assoc()) {
                echo '<option value="'.$row['OMISTAJA'].'">' . $row['OMISTAJA'] . '</option>';
            }
            echo "</select><br>";
            echo "</form>";
        }
    }

    
    
    
    if(isset($_GET['poistaLaite'])){
        $sarjanumero = parseGet('poistaLaite');
        $result = deleteLaite($sarjanumero);
    }
    if(isset($_POST['lisaa'])){
        
		$a['nimi'] = $_POST['nimi'];
        $a['malli'] = $_POST['malli'];
        $a['merkki'] = $_POST['merkki'];
        $a['sijainti'] = $_POST['sijainti'];
        $a['omistaja'] = $_POST['omistaja'];
        $a['kategoria'] = $_POST['kategoria'];
        $a['kuvaus'] = $_POST['kuvaus'];
        
        createLaite($a);
    }
    if(isset($_POST['muokkaa'])){
        $a['sarjanumero'] = $_POST['sarjanumero'];
        $a['nimi'] = $_POST['nimi'];
        $a['malli'] = $_POST['malli'];
        $a['merkki'] = $_POST['merkki'];
        $a['sijainti'] = $_POST['sijainti'];
        $a['kuvaus'] = $_POST['kuvaus'];
        $a['kategoria'] = $_POST['kategoria'];
        $a['omistaja'] = $_POST['omistaja'];

        muokkaaLaite($a);
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
            echo "<td><button class='muokkaalaiteb' onClick='getTiedot($a);'>Muokkaa</button></td>";
            echo "<td><button class='poistalaiteb' onClick='poistaLaite($a);'>Poista</button></td>";
            echo "<td><a href='varaushistoria.php'>Varaushistoria</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    if(isset($_GET['varaalaite'])){
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
            $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
            $sql = mysqli_query($database, "SELECT STATUS_NIMI FROM STATUS");

            echo "</select><br>";
            echo "<label for='status'>Status:</label><br>";
            echo "<select name='status' id='status'><br>";
            echo "<option selected='selected'></option>";
            while ($row = $sql->fetch_assoc()) {
                echo '<option value="'.$row['STATUS_NIMI'].'">' . $row['STATUS_NIMI'] . '</option>';
            }
            echo "</select><br>";
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
        $a['status'] = $_POST['status'];
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
                echo "<td><button class='muokkaaVaraus' onClick='muokkaaVaraus($varausid);'>Muokkaa varausta</button></td>";
                echo "<td><button class='poistaVaraus' onClick='poistaVaraus($varausid);'>Poista varaus</button></td>";
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
                echo "<td><button class='muokkaaLaina' onClick='muokkaaLaina($varausid);'>Muokkaa lainaa</button></td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    if(isset($_GET['poistavaraus'])){
        $varausid = $_GET['varausid'];
        deleteVaraus($varausid);
    }
    if(isset($_GET['muokkaavaraus'])){
        $varausid = parseGet('varausid');
        $data3 = getVaraustiedot($varausid);
        $x;
        $alk;
        $lop;
        foreach($data3 as $row)
        {
            $x = $row['SARJANUMERO'];
            $alk = $row['ALKUPVM'];
            $lop = $row['LOPPUPVM'];
        }
        $data = getLaitetiedot($x);
        $data2 = haePaivatmuok($x, $varausid);
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
            echo "<input type='text' id='datepickerAlku' name='alkupvm' value='$alk' onfocus='datePickeralku($x);' placeholder='Alkupäivämäärä'>";
            echo "<input type='text' id='datepickerLoppu' name='loppupvm' value='$lop' onfocus='datePickerloppu($x);' placeholder='Loppupäivämäärä'>";
            $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
            $sql = mysqli_query($database, "SELECT STATUS_NIMI FROM STATUS");

            echo "</select><br>";
            echo "<label for='status'>Status:</label><br>";
            echo "<select name='status' id='status'><br>";
            echo "<option selected='selected'></option>";
            while ($row = $sql->fetch_assoc()) {
                echo '<option value="'.$row['STATUS_NIMI'].'">' . $row['STATUS_NIMI'] . '</option>';
            }
            echo "</select><br>";
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
    if (isset($_GET['haemuut'])){
				
        $varaustiedot = getMuut();
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
                echo "<td><button class='muokkaaVaraus' onClick='muokkaaVaraus($varausid);'>Muokkaa varausta</button></td>";
                echo "<td><button class='poistaVaraus' onClick='poistaVaraus($varausid);'>Poista varaus</button></td>";
                echo "</tr>";

            }
        }
        echo "</table>";
    }

    if(isset($_POST['muokkaavarauskantaan'])){
        $varausid = $_POST['varausid'];
        $alkupvm = $_POST['alkupvm'];
        $loppupvm = $_POST['loppupvm'];
        $status = $_POST['status'];
        
        muokkaaVarauskantaan($varausid, $alkupvm, $loppupvm, $status);
    }

    if(isset($_GET['muokkaalaina'])){
        $varausid = parseGet('varausid');
        $data3 = getVaraustiedot($varausid);
        $x;
        $alk;
        $lop;
        foreach($data3 as $row)
        {
            $x = $row['SARJANUMERO'];
            $alk = $row['ALKUPVM'];
            $lop = $row['LOPPUPVM'];
        }
        $data = getLaitetiedot($x);
        $data2 = haePaivatmuok($x, $varausid);
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
            echo "<form id='formimuokkaalaina'>";
            echo "<input type='hidden' name='muokkaalainakantaan' />";
            echo "<input type='hidden' name='sarjanumero' value='$x' hidden />";
            echo "<input type='hidden' name='varausid' value='$varausid' hidden />";
            echo "<input type='hidden' name='asiakasid' value='$asiakasid' hidden />";
            echo "<input type='text' id='nimi_varaa' name='nimi' value='$b' disabled >";
            echo "<input type='text' id='malli_varaa' name='malli' value='$c' disabled >";
            echo "<input type='text' id='datepickerAlku' name='alkupvm' value='$alk' onfocus='datePickeralku($x);' placeholder='Alkupäivämäärä'>";
            echo "<input type='text' id='datepickerLoppu' name='loppupvm' value='$lop' onfocus='datePickerloppu($x);' placeholder='Loppupäivämäärä'>";
            echo "<label for='palautuspvm'>Palautuspäivämäärä</label><br>";
            echo "<input type='text' id='datepickerPalautus' name='palautuspvm' value='' onfocus='datePickerpalautus($x);' placeholder='Ei pakollinen'>";
            $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
            $sql = mysqli_query($database, "SELECT STATUS_NIMI FROM STATUS");

            echo "</select><br>";
            echo "<label for='status'>Status:</label><br>";
            echo "<select name='status' id='status'><br>";
            echo "<option selected='selected'></option>";
            while ($row = $sql->fetch_assoc()) {
                echo '<option value="'.$row['STATUS_NIMI'].'">' . $row['STATUS_NIMI'] . '</option>';
            }
            echo "</select><br>";
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
    if(isset($_POST['muokkaalainakantaan'])){
        $varausid = $_POST['varausid'];
        $alkupvm = $_POST['alkupvm'];
        $loppupvm = $_POST['loppupvm'];
        $palautuspvm = $_POST['palautuspvm'];
        $status = $_POST['status'];
        
        muokkaaLainakantaan($varausid, $alkupvm, $loppupvm, $palautuspvm, $status);
    }
    
?>