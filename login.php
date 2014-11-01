<?php
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xcizek12', 'gunapu9a');
    if (!$db) die('nelze se pripojit '.mysql_error());
    if (!mysql_select_db('xcizek12', $db)) die('database neni dostupna '.mysql_error());
    
    $sql1 = "SELECT * FROM Uzivatel WHERE meno = '".$username."' AND heslo = '".$password."'";
    $res = mysql_query($sql1);
    
    $row = mysql_fetch_row($res);
    
    if($row[0])
    {
        setcookie('logged', $username, time() + (86400 * 1), "/");
        $_SESSION["wrong_nick_or_psw"] = false;
    }
    else
    {
        setcookie('logged', '', time() - 3600, "/");
        $_SESSION["wrong_nick_or_psw"] = true;
    } 
    
    header("Location: http://www.stud.fit.vutbr.cz/~xcizek12/iis/index.php");
?>

 