<?php
include_once 'config.php';
$db = new mysqli($db_address, $db_login, $db_password, $db_database);
// Check connection
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}
$db->set_charset('utf8')
?>