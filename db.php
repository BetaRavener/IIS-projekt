<?php
$db = new mysqli('localhost', 'xsevci50', '9amcicim', 'xsevci50');
// Check connection
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}
$db->set_charset('utf8')
?>