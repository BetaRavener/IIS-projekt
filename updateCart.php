<?php
session_save_path("tmp/");
session_start();
require_once 'mainInit.php';
require_once 'checkUser.php';

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
        echo $db->error;
    }
}

?>