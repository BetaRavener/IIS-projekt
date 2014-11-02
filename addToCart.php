<?php
session_start();
$batchId = $_POST['batchId'];
$amount = $_POST['amount'];
if (!array_key_exists('cart', $_SESSION))
    $_SESSION['cart'] = array();
array_push($_SESSION['cart'], array('batchId' => $batchId, 'amount' => $amount));
echo 'pridane';
?>