<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Varaushistoria</title>
</head>

<style>
html, body { height: 100%; padding: 0; margin: 0; }
div { 
    width: 50%;
    height: 50%;
    float: left;
    overflow: scroll;
    overflow-x: hidden;
    
    }

h1 {
    margin: auto;
    line-height: 50px;
    vertical-align: middle;
}

button {
    line-height: 20px;
    width: 75px;
    font-size: 13pt;
    font-family: tahoma;
    margin-top: 1px;
    margin-right: 880px;
    position: absolute;
    top: 0;
    right: 0;
}

a:link {
    
    color: black;
    font-family: Arial, Helvetica, sans-serif;
    padding: 2px 5px;
    text-align: center;
    display: inline-block;
}


</style>
<body>
<div id="varaukset_tulevat">
<a href="javascript:history.back()">Takaisin</a>
<h1>Tulevat varaukset</h1>
<?php 

	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $query = "SELECT ALKUPVM, LOPPUPVM FROM varaus WHERE STATUS_NIMI='VARATTU' AND alkupvm > CURDATE()";
    $result = mysqli_query($database, $query);

        while($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $val) {
                echo $key . ": " . $val . "<br>";
            }
 
        }
?>
</div>
<div id="varaukset_menevat">
<h1>Menneet varaukset</h1>
<?php 

	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $query = "SELECT ALKUPVM, LOPPUPVM FROM varaus WHERE STATUS_NIMI='VARATTU' AND alkupvm < CURDATE()";
    $result = mysqli_query($database, $query);

        while($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $val) {
                echo $key . ": " . $val . "<br>";
            }
 
        }
?>
</div>

<div id="lainat_tulevat">
<h1>Tulevat lainat</h1>
<?php 

	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $query = "SELECT ALKUPVM, LOPPUPVM FROM varaus WHERE STATUS_NIMI='LAINATTU' AND alkupvm > CURDATE()";
    $result = mysqli_query($database, $query);

        while($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $val) {
                echo $key . ": " . $val . "<br>";
            }
 
        }
?>
</div>
<div id="lainat_menneet">
<h1>Menneet lainat</h1>
<?php 

	$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $query = "SELECT ALKUPVM, LOPPUPVM FROM varaus WHERE STATUS_NIMI='LAINATTU' AND alkupvm < CURDATE()";
    $result = mysqli_query($database, $query);

        while($row = mysqli_fetch_assoc($result)) {
            foreach($row as $key => $val) {
                echo $key . ": " . $val . "<br>";
            }
 
        }
?>
</div>

    
</body>
</html>