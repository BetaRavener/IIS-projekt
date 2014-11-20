<?php
session_start();
require_once 'mainInit.php';

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