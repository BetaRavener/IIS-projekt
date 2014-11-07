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
            
            <form name="add" method="POST" action="caj-update.php" id="add">
                <input type='hidden' name='caj_pk' value='<?php echo $teaId; ?>' readonly/> <br />
                Dostupné množství: <input class='edit' type='number' name='dostupneMnozstvo' value='' min='0' max='1000000' step='1'/> <br />
                Datum expirace: <input class='edit' type='date' name='datumExpiracie' value=''/> <br />
                Cena: <input class='edit' type='number' name='cena' value='' min='0' max='1000' step='0.1'/> <br />
                Sleva: <input class='edit' type='number' name='zlava' value='' min='0' max='100' step='0.1'/> <br />
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