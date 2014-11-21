<?php
session_save_path("tmp/");
session_start();
require_once 'mainInit.php';
require_once 'checkUser.php';

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