<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor čajů</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body>

    <?php
        require_once 'mainInit.php';
    ?>
    
    <div id="main">
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <h3>Jak nás kontaktovat</h3>
            Mobil: +420 666 666 666 <br/>
            Email: posta@titea.cz
            <br/>
            <h3>Kde nás najdete</h3>
            Vídeňská 32 <br/>
            639 00, Brno <br/>
            Česká republika<br/>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2607.9477384881234!2d16.594739199999992!3d49.1825783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471295ae16b84243%3A0x389d6ba6fbd318e0!2zVsOtZGXFiHNrw6EgMzIsIDYzOSAwMCBCcm5vLXN0xZllZA!5e0!3m2!1ssk!2scz!4v1416502779546" width="400" height="300" frameborder="0" style="border:0"></iframe>
        </div>
    </div>
</body>
</html>

<?php
    if (array_key_exists('wrong_nick_or_psw', $_SESSION))
    {
        $_SESSION['wrong_nick_or_psw'] = false;
    }
?>
