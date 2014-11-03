<?php
    session_start();
    setcookie('logged', '', time() - 3600, "/");
    $_SESSION["wrong_nick_or_psw"] = false;
    header('Location: ' . $web_home . 'index.php');
?>