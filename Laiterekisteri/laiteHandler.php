<?php

function hae_laitteet() {

    $nimi = "";
    $malli = "";
    $merkki = "";
    $sijainti = "";
    $omistaja = "";
    $kategoria = "";
    $sarjanumero = "";
    $kuvaus = "";
    
    $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $query = "SELECT * FROM laite WHERE";
    
    if (isset($_POST['haeLaitteet'])){
        if ($_POST['nimi'] == !null){
            $nimi = $_POST['nimi'];
            $query = $query . " nimi LIKE '%$nimi%'";
        }
        if ($_POST['malli'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $malli = $_POST['malli'];
            $query = $query . " malli LIKE '%$malli%'";
        }
        if ($_POST['merkki'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $merkki = $_POST['merkki'];
            $query = $query . " merkki LIKE '%$merkki%'";
        }
        if ($_POST['sijainti'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $sijainti = $_POST['sijainti'];
            $query = $query . " sijainti LIKE '%$sijainti%'";
        }
        if ($_POST['omistaja'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $omistaja = $_POST['omistaja'];
            $query = $query . " omistaja LIKE '%$omistaja%'";
        }
        if ($_POST['kategoria'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $kategoria = $_POST['kategoria'];
            $query = $query . " kategoria LIKE '%$kategoria%'";
        }
        if ($_POST['sarjanumero'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $sarjanumero = $_POST['sarjanumero'];
            $query = $query . " sarjanumero LIKE '%$sarjanumero%'";
        }
        if ($_POST['kuvaus'] == !null){
            if ($query != "SELECT * FROM laite WHERE"){
                $query = $query . " AND";
            }
            $kuvaus = $_POST['kuvaus'];
            $query = $query . " kuvaus LIKE '%$kuvaus%'";
        }
        $result = mysqli_query($database, $query);
    
    
    
        echo "<table border='1'>
    <tr>
    <th>Sarjanumero</th>
    <th>Nimi</th>
    <th>Malli</th>
    <th>Merkki</th>
    <th>Sijainti</th>
    <th>Kuvaus</th>
    <th>Kategoria</th>
    <th>Omistaja</th>
    </tr>";
    
    while($row = mysqli_fetch_array($result))
    {
    echo "<tr>";
    echo "<td>" . $row['SARJANUMERO'] . "</td>";
    echo "<td>" . $row['NIMI'] . "</td>";
    echo "<td>" . $row['MALLI'] . "</td>";
    echo "<td>" . $row['MERKKI'] . "</td>";
    echo "<td>" . $row['SIJAINTI'] . "</td>";
    echo "<td>" . $row['KUVAUS'] . "</td>";
    echo "<td>" . $row['KATEGORIA'] . "</td>";
    echo "<td>" . $row['OMISTAJA'] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
    
    mysqli_close($database);
    }

    



}       
?>