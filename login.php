<?php
    session_save_path("tmp/");
    session_start();
    
    if (array_key_exists('username', $_POST) and array_key_exists('password', $_POST))
    {
        require_once 'db.php';
    
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql1 = "SELECT * FROM Uzivatel WHERE meno = '".$username."' AND heslo = '".$password."'";
        $res = $db->query($sql1);

        if($res->num_rows == 1)
        {
            $row = $res->fetch_assoc();
            setcookie('logged', $row['pk'], time() + (86400 * 1), "/");
            $_SESSION["wrong_nick_or_psw"] = false;
        }
        else
        {
            setcookie('logged', '', time() - 3600, "/");
            $_SESSION["wrong_nick_or_psw"] = true;
        } 
        
        header('Location: ' . $web_home . 'index.php');
    }
?>

 