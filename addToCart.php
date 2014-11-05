<?php
session_start();
require_once 'db.php';
require_once 'loginDetection.php';

$batchId = $_POST['batchId'];
$amount = $_POST['amount'];

if ($_SESSION['userLogedIn'])
{
    $result = $db->query('call PridajDoKosika(' . $_SESSION['userId'] . ', ' . $batchId . ', ' . $amount . ')');
    if ($result)
    {
        echo 'pridane';
    }
    else
    {
        //TODO: Error
        echo $db->error;
    }
}
else
{
    if (!array_key_exists('cart', $_SESSION))
    {
        $_SESSION['cart'] = array();
    }
    array_push($_SESSION['cart'], array('batchId' => $batchId, 'amount' => $amount));
    echo 'pridane';
}
?>