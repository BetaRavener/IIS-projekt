<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor čajů</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body>

    <?php
        header("Content-Type: text/html; charset=UTF-8");
        error_reporting(0);
        session_start();
    ?>
    
    <div id="main">
        <?php include 'header.php' ?>

        <?php include 'menu.php' ?>
        
        <div id="content">
            <h2>Novinky</h2>
        </div>
        <div id="footer">
        
        </div>
    </div>
</body>
</html>

    <?php
        session_unset();
        session_destroy(); 
    ?>
