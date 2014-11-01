<?php
    session_start();
    setcookie('logged', '', time() - 3600, "/");
    $_SESSION["wrong_nick_or_psw"] = false;
    header("Location: http://www.stud.fit.vutbr.cz/~xcizek12/iis/index.php");
?>