<?php
session_start();
require_once 'db.php';
require_once 'loginDetection.php';

$orderId = $_POST['orderId'];

if ($_SESSION['userLogedIn'])
{
    $result = $db->query('call StornujObjednavku(' . $userId . ', ' . $orderId . ')');
    if ($result)
    {
        echo 'Success';
    }
    else
    {
        //TODO: Error
        echo $db->error;
    }
}
else
{
    //TODO: Error
    echo 'Login';
}
?>