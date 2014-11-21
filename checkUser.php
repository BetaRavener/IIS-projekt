<?php
    if (!array_key_exists('isAdmin', $_SESSION) or $_SESSION['isAdmin'])
        exit(2);
        
    if (!array_key_exists('userLogedIn', $_SESSION) or !$_SESSION['userLogedIn'])
        exit(2);
?>