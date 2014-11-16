<?php
session_start();
require_once 'db.php';
require_once 'loginDetection.php';

$batchId = $_POST['batchId'];
$amount = $_POST['amount'];

if ($_SESSION['userLogedIn'])
{
    $query = 'UPDATE PolozkaObjednavky as po SET po.objednaneMnozstvo = CASE po.pk ';
    $idList = '';
    $comma = false;
    foreach ($_POST as $id => $amount)
    {
        $query .= 'WHEN ' . strval($id) . ' THEN ' . strval($amount) . ' ';
        $idList .= ($comma ? ',' : '') . strval($id);
        $comma = true;
    }
    $query .= 'END WHERE po.pk IN (' . $idList . ') and po.objednavka_pk = ZiskajKosik(' . $userId . ')';
    
    $result = $db->query($query);
    if (!$result)
    {
        //TODO: Error
        echo 'error';
    }
}
else
{
    //TODO: error
    echo 'error';
}
?>