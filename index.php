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
            <h2>Novinky</h2>
            20.11.2014 Do naší ponuky sme zařadili skvělé Mate IQ, vřele Vám doporučujeme jej vyskoušet. <br/>
            18.11.2014 Vyprodal se nám čaj oblíbený čaj Gunpowder, na jeho naskladnení usilovne pracujeme.
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
