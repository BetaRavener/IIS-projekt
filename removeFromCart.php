<?php
session_start();
require_once 'db.php';
require_once 'loginDetection.php';

$cartItemId = $_POST['cartItemId'];
if ($_SESSION['userLogedIn'])
{
    $result = $db->query('call OdstranZKosika(' . $_SESSION['userId'] . ', ' . $cartItemId . ')');
    if ($result)
    {
        echo 'zmazane';
    }
    else
    {
        //TODO: Error
        echo $db->error;
    }
}
else
{
    if (array_key_exists('cart', $_SESSION))
    {
        unset($_SESSION['cart'][$cartItemId]);
        echo 'zmazane';
    }
}
?>