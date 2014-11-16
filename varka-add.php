<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor caju</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body>

    <?php
        require_once 'mainInit.php';
    ?>
    
    <script type="text/javascript">
    
    function varkaadd_checkvalues() {
        var ret = true;
        
        if(document.forms["add"]["datumExpiracie"].value == ""){
           document.getElementById("datum_star").style.color = "red"; 
           ret = false; 
        }
        
        if(document.forms["add"]["cena"].value == ""){ 
           document.getElementById("cena_star").style.color = "red"; 
           ret = false; 
        }
        
        if(document.forms["add"]["zlava"].value == ""){ 
           document.getElementById("sleva_star").style.color = "red"; 
           ret = false; 
        }
        
        return ret;
    }
    </script>
    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
       
        <?php 
            $teaId = -1;
            if (array_key_exists('id', $_GET))
                $teaId = $_GET['id'];
        ?>
        <div id="content">
            <h2>Nová várka</h2>
            
            <form name="add" method="POST" action="caj-update.php" onsubmit="return varkaadd_checkvalues()" id="add">
                <input type='hidden' name='caj_pk' value='<?php echo $teaId; ?>' readonly/> <br />
                Dostupné množství: <input class='edit' type='number' name='dostupneMnozstvo' value='' min='0' max='1000000' step='1'/> <br />
                Datum expirace: <input class='edit' type='date' name='datumExpiracie' value=''/><span id="datum_star">*</span> <br />
                Cena: <input class='edit' type='number' name='cena' value='' min='0' max='1000' step='0.1'/><span id="cena_star">*</span> <br />
                Sleva: <input class='edit' type='number' name='zlava' value='' min='0' max='100' step='0.1'/><span id="sleva_star">*</span> <br />
                Místo na skladě: <input class='edit' type='number' name='miestoNaSklade' value='' min='0' max='1000' step='1'/> <br />
                <div class="button_center">
                    <input type="submit" name="create_varka" value="Vytvořit" />
                </div>
            </form>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>