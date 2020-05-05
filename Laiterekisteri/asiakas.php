<?php
    session_start();
    
    $_SESSION['dates']=array();
	// Tarkistetaan, onko käyttäjä jo kirjautunut järjestelmään, jos ei -> heitetään login-sivulle
     require_once("login_utils.inc");
     require_once("db.inc");
     //require_once("db_utils.inc");
     //include("laiteHandler.php");
	 check_session();


    
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/Redmond/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <style>
   .modify_user{
       padding: 10px 20px;
       text-align: center;
       position: absolute;
       top: 5px;
       right: 10px;
   }
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

    <title>Asiakkaiden käsittely</title>
    <?php echo "Tervetuloa" ." ". $_SESSION['username'];?>
    <a href='logout.php'>Kirjaudu ulos</a>
    <br>
    <br>
    <br>

	<script>
		$(function(){
                   
            $(document).ready(function () {
                $("#loadVaraukset").load("asiakasHandler.php?haevaraukset", function(){	
                    
                });
                $("#loadLainat").load("asiakasHandler.php?haelainat", function() {
            });   
                
            });

            
            $("#hae").button();
            
	        $("#laitehallinta").button();
            $("#hae").click(function(){
                var form = $("#formihae").serialize();
                console.log(form);
                $("#onloadi").load("asiakasHandler.php", form, function(){
				    
			    });
            
            });
            $("#modify_user").button();
            $("#tabs").tabs();
            $("#muokkaadialogi").dialog({
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Tallenna",
                            click: function() {
                                if ($("#salasana_muok").val() != $("#salasana1_muok").val()) 
                                {
                                alert("Salasanat eivät täsmää!");
                                return false;
                                }
                                else
                                {
                                    var asiakas = $("#formimuokkaa").serialize();
                                    console.log(asiakas);
                                    muokkaaAsiakas(asiakas);
                                    alert("Muutokset tallennettu!")
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

            $("#muokkaavarausdialogi").dialog({
                    modal: true,
                    autoOpen: false,
                    buttons: [
                        {
                            text: "Tallenna",
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
                                    var varaus = $("#formimuokkaavaraus").serialize();
                                    console.log(varaus);
                                    muokkaaVarauskantaan(varaus);
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
        
            function muokkaaAsiakas(asiakas){
                $.post(
                    "asiakasHandler.php",
                    asiakas
                ).done(function (data, textStatus, jqXHR) {
                    console.log("Onnistui muokkaaAsiakas.")
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log("muokkaaAsiakas: status=" + textStatus + ", " + errorThrown);
                });
        }

            function getAsiakastiedot(){
            var username ='<?php echo $_SESSION['username'];?>';
            console.log(username);
            $("#muokkaadialogi").load("asiakasHandler.php?username=" + username, function(){
				console.log("asiakasHandler.php?username=" + username)
			    });
                $("#muokkaadialogi").dialog("open");

            }
            function getVaraustiedot(sarjanumero){
            console.log(sarjanumero);
            $("#varausdialogi").load("asiakasHandler.php?sarjanumero=" + sarjanumero, function(){
                
				    
			    });
                $("#varausdialogi").dialog("open");

                
                
            }
            function luoVaraus(varaus){
            $.post(
                "asiakasHandler.php",
                varaus
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui luoVaraus." + varaus)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("luoVaraus: status=" + textStatus + ", " + errorThrown);
            });
        }

        function muokkaaVarauskantaan(varaus){
            $.post(
                "asiakasHandler.php",
                varaus
            ).done(function (data, textStatus, jqXHR) {
                console.log("Onnistui muokkaaVarauskantaan: " + varaus)
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("muokkaaVarauskantaan: status=" + textStatus + ", " + errorThrown);
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
            $("#muokkaavarausdialogi").load("asiakasHandler.php?muokkaavaraus=&varausid=" + varausid, function(){
                });
                $("#muokkaavarausdialogi").dialog("open");
            }

            
	</script>
</head>

<body>
<input type="button" class="modify_user" name="modify_user" id="modify_user" onClick='getAsiakastiedot();' value="Omat tiedot">     


<div id="varausdialogi" title="Varaa laite"></div>
<div id="muokkaadialogi" title="Muokkaa tietoja"></div>


<div id="tabs">

  <ul>
    <li><a href="#tabs-1">Laitteet</a></li>
    <li><a href="#tabs-2">Varaukset</a></li>
    <li><a href="#tabs-3">Lainat</a></li>
  </ul>

  <div id="tabs-1" class="container">
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
    <button id="hae" name="haeLaitteet">Hae laitteet</button>
    <div id="onloadi"></div>
  </div>

  <div id="tabs-2">
    <div id="loadVaraukset"></div>
    <div id="muokkaavarausdialogi" title="Muokkaa varausta"></div>
  </div>

  <div id="tabs-3">
    <div id="loadLainat"></div>
  </div>

</div>
<div>
</div>


</body>
</html></div>