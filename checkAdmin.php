<?php
    if (!array_key_exists('isAdmin', $_SESSION) or !$_SESSION['isAdmin'])
        exit(2);
?>