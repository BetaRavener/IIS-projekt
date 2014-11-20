<?php
session_start();
require_once 'db.php';
require_once 'loginDetection.php';

if (array_key_exists('orderId', $_POST))
{
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
}
?>