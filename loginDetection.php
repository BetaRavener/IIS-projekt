<?php
    $userLogedIn = isset($_COOKIE['logged']);
    $userId = -1;
    if ($userLogedIn)
    {
        require_once 'db.php';
    
        $userId = $_COOKIE['logged'];
        $result = $db->query('SELECT u.meno as username, o.meno, o.priezvisko FROM Uzivatel AS u JOIN Odberatel AS o on u.odberatel_pk = o.pk WHERE u.pk=' . $userId);
        if ($result and $result->num_rows == 1)
        {
            $user = $result->fetch_assoc();
            $nameSurname = $user['meno'] . ' ' . $user['priezvisko'];
            $username = $user['username'];
            $_SESSION['userId'] = $userId;
        }
        else
            $userLogedIn = false;
    }
    $_SESSION['userLogedIn'] = $userLogedIn;
?>