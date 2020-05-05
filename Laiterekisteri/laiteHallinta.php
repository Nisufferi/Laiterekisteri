<?php 
session_start();
require_once("login_utils.inc");
check_session();
//require_once("laiteHallintaHandler.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/Redmond/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
    .tabs {
       position: relative;    
   }

   table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
   }

table {
    border-collapse: collapse;
    width: 50%;
   }

th, td {
    padding: 15px;
   }
.fieldset-auto-width {
         display: inline-block;
    }


.container input {
  width: 100%;
  display: block;
  clear: both;
   }
    </style>
    <?php echo "Tervetuloa" ." ". $_SESSION['username'];?>
    <a href='logout.php'>Kirjaudu ulos</a>
    <br>
    <br>
    <br>
    <script>
		$(function(){
            $(document).ready(function () {
                $("#loadVaraukset").load("laiteHallintaHandler.php?haevaraukset", function(){			    
                });
                $("#loadLainat").load("laiteHallintaHandler.php?haelainat", function() {
                });
                $("#loadmuut").load("laiteHallintaHandler.php?haemuut", function() {
                });
                
                
            });
            $("#etusivu").button();
            $("#hae").button();
            $("#hae").click(function(){
                var form = $("#formihae").serialize();
                console.log(form);
                $("#onloadi").load("laiteHallintaHandler.php", form, function(){
				    
			    });
            
            });
            /*$(".muokkaalaiteb").click(function(){
                var sarjan = 71;//$(".muokkaalaiteb").val();
                console.log(sarjan);
                $("#muokkaadialogi").load("laiteHallintaHandler.php", sarjan, function(){
				    $("#muokkaadialogi").dialog("open");
			    });
            });*/

            $("#poistaLaite").button();
            $("#modify_user").button();
            $("#varaaLaite").button();
            $("#tabs").tabs();
            
            $("#lisaa").button();
            $("#lisaa").click(function(){
                $("#dialogi").dialog("open");
            });
            
            $("#muokkaaLaite").button();
            
            /*$("#muokkaaLaite").click(function(){
                $("#muokkaadialogi").dialog("open");
            });*/
        
            
            
            
            
               
            
            $("#muokkaadialogi").dialog({
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Tallenna",
                            click: function() {
                                if ($.trim($("#nimi_muok").val()) === "" || $.trim($("#malli_muok").val()) === "" || $.trim($("#merkki_muok").val()) === "" || 
                                    $.trim($("#sijainti_muok").val()) === "" || $.trim($("#omistaja_muok").val()) === "" || $.trim($("#kategoria_muok").val()) === "" || 
                                    $.trim($("#kuvaus_muok").val()) === "") 
                                {
                                alert("Anna arvo kaikkiin kenttiin");
                                return false;
                                }
                                else
                                {
                                    var laite = $("#formimuokkaa").serialize();
                                    console.log(laite);
                                    muokkaaLaite(laite);
                                    $(this).dialog("close");
                                    haeLaitteet();

                                }
                            },
                        },
                        {
                            text: "Peruuta",
                            click: function() {
                                $(this).dialog("close");
                            },
                        }
                    ],
                    closeOnEscape: false,
                    draggable: false,
                    modal: true,
                    resizable: false
            });
            
            
            
            $("#dialogi").dialog({
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Lisää",
                            click: function() {
                                if ($.trim($("#nimi_lis").val()) === "" || $.trim($("#malli_lis").val()) === "" || $.trim($("#merkki_lis").val()) === "" || 
                                    $.trim($("#sijainti_lis").val()) === "" || $.trim($("#omistaja_lis").val()) === "" || $.trim($("#kategoria_lis").val()) === "" || 
                                    $.trim($("#kuvaus_lis").val()) === "") 
                                {
                                console.log("Anna arvo kaikkiin kenttiin!");
                                return false;
                                } 
                                else 
                                {
                                    var laite = $("#formilisaa").serialize();                           
                                    console.log(laite);
                                    lisaaLaite(laite);
                                    $(this).dialog("close");
                                }
                            },
                        },
                        {
                            text: "Peruuta",
                            click: function() {
                                $(this).dialog("close");
                            },
                        }
                    ],
                    closeOnEscape: false,
                    draggable: true,
                    modal: true,
                    resizable: false
            });
            $("#muokkaavarausdialogi").dialog({
                    modal: true,
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Tallenna",
                            click: function() {
                                if ($("#status").val() === ""){
                                if ($("#datepickerAlku").val() === $("#datepickerLoppu").val() || $("#datepickerAlku").val() > $("#datepickerLoppu").val()) 
                                {
                                alert("Tarkista päivämäärät!");
                                return false;
                                }
                                }
                                if (tarkistapaivat() === false){
                                alert("VARATTU JO");
                                return false;
                                }
                                else
                                {
                                    var varaus = $("#formimuokkaavaraus").serialize();
                                    console.log(varaus);
                                    muokkaaVarauskantaan(varaus);
                                    $(this).dialog("close");
                                    window.location.reload();

                                }
                            },
                        },
                        {
                            text: "Peruuta",
                            click: function() { 
                                $(this).dialog("close");
                            },
                        }
                        
                    ],
                    closeOnEscape: false,
                    draggable: false,
                    modal: true,
                    resizable: false
            });
            $("#muokkaalainadialogi").dialog({
                    modal: true,
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Tallenna",
                            click: function() {
                                if ($("#datepickerPalautus").val() != "" && $("#status").val() != "PALAUTETTU"){
                                    alert("Palautuksen yhteydessä laita status PALAUTETTU");
                                    return false;
                                }
                                if ($("#status").val() === ""){
                                if ($("#datepickerAlku").val() === $("#datepickerLoppu").val() || $("#datepickerAlku").val() > $("#datepickerLoppu").val()) 
                                {
                                alert("Tarkista päivämäärät!");
                                return false;
                                }
                                }
                                if (tarkistapaivat() === false){
                                alert("VARATTU JO");
                                return false;
                                }
                                else
                                {
                                    var varaus = $("#formimuokkaalaina").serialize();
                                    console.log(varaus);
                                    muokkaaLainakantaan(varaus);
                                    $(this).dialog("close");
                                    //window.location.hash = 'tabs-4';
                                    window.location.reload();

                                }
                            },
                        },
                        {
                            text: "Peruuta",
                            click: function() { 
                                $(this).dialog("close");
                            },
                        }
                        
                    ],
                    closeOnEscape: false,
                    draggable: false,
                    modal: true,
                    resizable: false
            });
            $("#varausdialogi").dialog({
                    modal: true,
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Varaa",
                            click: function() {
                                if ($("#datepickerAlku").val() === $("#datepickerLoppu").val() || $("#datepickerAlku").val() > $("#datepickerLoppu").val()) 
                                {
                                alert("Tarkista päivämäärät!");
                                return false;
                                }
                                else if (tarkistapaivat() === false){
                                alert("VARATTU JO");
                                return false;
                                }
                                else
                                {
                                    var varaus = $("#formivaraa").serialize();
                                    console.log(varaus);
                                    luoVaraus(varaus);
                                    $(this).dialog("close");
                                    window.location.reload();

                                }
                            },
                        },
                        {
                            text: "Peruuta",
                            click: function() { 
                                $(this).dialog("close");
                            },
                        }
                        
                    ],
                    closeOnEscape: false,
                    draggable: false,
                    modal: true,
                    resizable: false
            });
            

        });
        function tarkistapaivat(){
                    
                    var paivatlista = document.querySelectorAll('.lista li');
                    console.log(paivatlista);
                    console.log($("#datepickerAlku").val());
                    console.log($("#datepickerLoppu").val());
                    for (var i = 0; i < paivatlista.length; i++) {
                        
                    if ($("#datepickerAlku").val() === paivatlista[i].textContent || $("#datepickerLoppu").val() === paivatlista[i].textContent ||
                    $("#datepickerAlku").val() < paivatlista[i].textContent && $("#datepickerLoppu").val() > paivatlista[i].textContent){
                        return false;
                    }
                    
                }
            }
        function datePickerpalautus(sarjanumero){
                $( "#datepickerPalautus" ).datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                jQuery('#datepickerPalautus').datepicker("show");
            }
        function datePickeralku(sarjanumero){
                $( "#datepickerAlku" ).datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                jQuery('#datepickerAlku').datepicker("show");
            }
            
            
        function datePickerloppu(sarjanumero){
            $( "#datepickerLoppu" ).datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: true
        });
        jQuery('#datepickerLoppu').datepicker("show");
        }
        function muokkaaVarauskantaan(varaus){
            $.post(
                "laiteHallintaHandler.php",
                varaus
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui muokkaaVarauskantaan: " + varaus)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("muokkaaVarauskantaan: status=" + textStatus + ", " + errorThrown);
            });
        }
        function muokkaaLainakantaan(varaus){
            $.post(
                "laiteHallintaHandler.php",
                varaus
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui muokkaaLainakantaan: " + varaus)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("muokkaaLainakantaan: status=" + textStatus + ", " + errorThrown);
            });
        }
        function lisaaLaite(laite) {
            $.post(
                "laiteHallintaHandler.php",
                laite
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui lisaaLaite.")
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("lisaaAsiakas: status=" + textStatus + ", " + errorThrown);
            });
        }
        
        function poistaLaite(sarjanumero){
            $.get(
                "laiteHallintaHandler.php?poistaLaite=" + sarjanumero
            ).done(function (data, textStatus, jqXHR) {
				console.log("Asiakas poistettu sarjanumerolla: " + sarjanumero);
                haeLaitteet();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("poista_asiakas: status=" + textStatus + ", " + errorThrown);
            });
        }
        function haeLaitteet(){
            $("#onloadi").load("laiteHallintaHandler.php?haeLaitteet", function(){
				    $(".poistalaiteb").button();
                    $(".muokkaalaiteb").button();
			    });
        }
        function getTiedot(sarjanumero){
            console.log(sarjanumero);
            $("#muokkaadialogi").load("laiteHallintaHandler.php?haetiedot=&sarjanumero=" + sarjanumero, function(){
				    
			    });
                $("#muokkaadialogi").dialog("open");
                
        }
        function muokkaaLaite(laite){
            $.post(
                "laiteHallintaHandler.php",
                laite
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui muokkaaLaite.")
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("muokkaaLaite: status=" + textStatus + ", " + errorThrown);
            });
        }
        function poistaVaraus(varausid){
            $.get(
                "asiakasHandler.php?poistavaraus=&varausid=" + varausid
            ).done(function (data, textStatus, jqXHR) {
				console.log("poistaVaraus varausid:llä: " + varausid);
                window.location.reload();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("poistaVaraus: status=" + textStatus + ", " + errorThrown);
            });
        }
        function muokkaaVaraus(varausid){
            console.log(varausid);
            $("#muokkaavarausdialogi").load("laiteHallintaHandler.php?muokkaavaraus=&varausid=" + varausid, function(){
                });
                $("#muokkaavarausdialogi").dialog("open");
            }
        function muokkaaLaina(varausid){
            console.log(varausid);
            $("#muokkaalainadialogi").load("laiteHallintaHandler.php?muokkaalaina=&varausid=" + varausid, function(){
                });
                $("#muokkaalainadialogi").dialog("open");
            }
        function getVaraustiedot(sarjanumero){
        console.log(sarjanumero);
        $("#varausdialogi").load("laiteHallintaHandler.php?varaalaite=&sarjanumero=" + sarjanumero, function(){
            });
                $("#varausdialogi").dialog("open");
        }
        function luoVaraus(varaus){
            $.post(
                "laiteHallintaHandler.php",
                varaus
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui luoVaraus." + varaus)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("luoVaraus: status=" + textStatus + ", " + errorThrown);
            });
        }
        
        
        
	</script>

</head>
<body>



<div id="dialogi" title="Lisää uusi laite">
<form id="formilisaa">
      <input type="hidden" name="lisaa" />
      <input type="text" id="nimi_lis" name="nimi" placeholder="Nimi">
      <input type="text" id="malli_lis" name="malli" placeholder="Malli">
      <input type="text" id="merkki_lis" name="merkki" placeholder="Merkki">
      <input type="text" id="sijainti_lis" name="sijainti" placeholder="Sijainti">
      <label for="omistaja">Omistaja</label><br>
    <select name="omistaja" id="omistaja_lis">
    <option selected="selected"></option>
    <?php
    $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $sql = mysqli_query($database, "SELECT omistaja FROM laite");

    while ($row = $sql->fetch_assoc()) {
        echo '<option value="'.$row['omistaja'].'">' . $row['omistaja'] . '</option>';
    }
    ?>
    </select><br>
    <label for="kategoria">Kategoria</label><br>    

<select name="kategoria" id="kategoria_lis"><br>
<option selected="selected"></option>
<?php
$database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
$sql = mysqli_query($database, "SELECT kategoria FROM kategoria");

while ($row = $sql->fetch_assoc()) {
    echo '<option value="'.$row['kategoria'].'">' . $row['kategoria'] . '</option>';
}
?>
</select><br>
      <input type="text" id="kuvaus_lis" name="kuvaus" placeholder="Kuvaus">
  </form>
</div>

<!--<div id="muokkaadialogi" title="Muokkaa laitetta">
<form id="formimuokkaa">
      <input type="hidden" name="muokkaa" />
      <input type="text" id="nimi_muok" name="nimi" placeholder="Nimi">
      <input type="text" id="malli_muok" name="malli" placeholder="Malli">
      <input type="text" id="merkki_muok" name="merkki" placeholder="Merkki">
      <input type="text" id="sijainti_muok" name="sijainti" placeholder="Sijainti">
      <input type="text" id="omistaja_muok" name="omistaja" placeholder="Omistaja">
      <input type="text" id="kategoria_muok" name="kategoria" placeholder="Kategoria">
      <input type="text" id="kuvaus_muok" name="kuvaus" placeholder="Kuvaus">
  </form>
</div>-->

<div id="muokkaadialogi" title="Muokkaa laitetta"></div>

<div id="tabs">

<ul>
  <li><a href="#tabs-1">Laitteiden hallinta</a></li>
  <li><a href="#tabs-2">Varauksien hallinta</a></li>
  <li><a href="#tabs-3">Lainojen hallinta</a></li>
  <li><a href="#tabs-4">Muut</a></li>
</ul>





<div id="tabs-1" class="container">
<div id="varausdialogi" title="Varaa laite"></div>

<button id="lisaa">Lisää laite</button>
<form id="formihae">
  <fieldset class="fieldset-auto-width">
  <input type="hidden" name="haeLaitteet" />
  <label for="nimi">Nimi</label>
  <input type="text" name="nimi" id="nimi" value="">
  <label for="malli">Malli</label>
  <input type="text"  name="malli" id="malli" value="">
  <label for="merkki">Merkki</label>
  <input type="text" name="merkki" id="merkki" value="">
  <label for="sijainti">Sijainti</label>    
  <input type="text"  name="sijainti" id="sijainti" value="">

    <label for="omistaja">Omistaja</label><br>
    <select name="omistaja" id="omistaja">
    <option selected="selected"></option>
    <?php
    $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $sql = mysqli_query($database, "SELECT omistaja FROM laite");

    while ($row = $sql->fetch_assoc()) {
        echo '<option value="'.$row['omistaja'].'">' . $row['omistaja'] . '</option>';
    }
    ?>
    </select><br>

    

    <label for="kategoria">Kategoria</label><br>    

    <select name="kategoria" id="kategoria"><br>
    <option selected="selected"></option>
    <?php
    $database = mysqli_connect('localhost', 'root', '', 'laiterekisteri');
    $sql = mysqli_query($database, "SELECT kategoria FROM kategoria");

    while ($row = $sql->fetch_assoc()) {
        echo '<option value="'.$row['kategoria'].'">' . $row['kategoria'] . '</option>';
    }
    ?>
    </select><br>

  <label for="sarjanumero">Sarjanumero</label>    
  <input type="text" name="sarjanumero" id="sarjanumero" value="">
  <label for="kuvaus">Kuvaus</label>    
  <input type="text" name="kuvaus" id="kuvaus" value="">
  
  </fieldset>
  
</form>  
<button id="hae">Hae laitteet</button>
<div id="onloadi"></div>

</div>



<div id="tabs-2">
  <div id="loadVaraukset"></div>
  <div id="muokkaavarausdialogi" title="Muokkaa varausta"></div>
</div>

<div id="tabs-3">
    <div id="loadLainat"></div>
    <div id="muokkaalainadialogi" title="Muokkaa lainaa"></div>
</div>

<div id="tabs-4">
    <div id="loadmuut"></div>
    <div id="muutdialogi" title="Muokkaa varausta"></div>
</div>

</div>



    
</body>
</html>