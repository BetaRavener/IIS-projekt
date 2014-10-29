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

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($username == "" or $password == "")
    {
    
    }
    else
    {
        $db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xcizek12', 'gunapu9a');
        if (!$db) die('nelze se pripojit '.mysql_error());
        if (!mysql_select_db('xcizek12', $db)) die('database neni dostupna '.mysql_error());
        
        $sql1 = "SELECT * FROM Uzivatel WHERE meno = '".$username."' AND heslo = '".$password."'";
        $res = mysql_query($sql1);
        
        if($res)
        {
            $logged = true;
        }
        else
        {
            $logged = false;
        }
    }  
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

        <?php include 'menu.php' ?>
        
        <div id="content">
            <h2>Novinky</h2>
        </div>
        <div id="footer">
        
        </div>
    </div>
</body>
</html>
