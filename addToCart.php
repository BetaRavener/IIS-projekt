<?php
session_start();
require_once 'mainInit.php';

if (array_key_exists('batchId', $_POST) and array_key_exists('amount', $_POST))
{
    $batchId = $_POST['batchId'];
    $amount = $_POST['amount'];

    if ($_SESSION['userLogedIn'])
    {
        $result = $db->query('call PridajDoKosika(' . $_SESSION['userId'] . ', ' . $batchId . ', ' . $amount . ')');
        if ($result)
        {
            echo 'Přidáno do košíku';
        }
        else
        {
            //TODO: Error
            echo $db->error;
        }
    }
    else
    {
        echo 'Před nákupem se, prosím, přihlašte';
    }
}
?>