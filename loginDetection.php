<?php
    require_once 'db.php';
    $userLogedIn = isset($_COOKIE['logged']);
    $userId = -1;
    if ($userLogedIn)
    {
        $userId = $_COOKIE['logged'];
        $result = $db->query('SELECT * FROM Uzivatel WHERE Uzivatel.pk=' . $userId);
        if ($result->num_rows == 1)
        {
            $user = $result->fetch_assoc();
            $username = $user['meno'];
            $_SESSION['userId'] = $userId;
        }
    }
    $_SESSION['userLogedIn'] = $userLogedIn;
?>