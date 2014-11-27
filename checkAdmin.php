<?php
    if (!array_key_exists('isAdmin', $_SESSION) or !$_SESSION['isAdmin'])
        header('Location: ' . $web_home . 'index.php');
?>