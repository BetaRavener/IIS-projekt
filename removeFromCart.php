<?php
session_save_path("tmp/");
session_start();
require_once 'mainInit.php';
require_once 'checkUser.php';

if (array_key_exists('cartItemId', $_POST))
{
    $cartItemId = $_POST['cartItemId'];
    if ($_SESSION['userLogedIn'])
    {
        $result = $db->query('call OdstranZKosika(' . $_SESSION['userId'] . ', ' . $cartItemId . ')');
        if ($result)
        {
            echo 'Odstráněno z košíku';
        }
        else
        {
            //TODO: Error
            echo $db->error;
        }
    }
}
?>