<?php
session_start();
$cartIdx = $_POST['cartIdx'];
if (array_key_exists('cart', $_SESSION))
{
    unset($_SESSION['cart'][$cartIdx]);
    echo 'zmazane';
}
?>