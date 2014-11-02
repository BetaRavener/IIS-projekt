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
    ?>
    
    <div id="main">
        <div id="header">
            <?php 
                if($logged)
                {
                    include 'logged.php';
                }
                else
                {
                    include 'login.php';
                }
            ?>
            <h1>Prodejna čajů Tomáš a Ivan</h1> 
        </div>
        
        <?php $logged = true ?>
        <?php include 'menu.php' ?>
        <div id="content">
            <h2>Odběratel</h2>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>