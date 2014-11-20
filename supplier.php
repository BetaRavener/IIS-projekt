<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor caju</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body>
    <?php
        require_once 'mainInit.php';
    ?>
    
    <div id="main">
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <?php
            $supplierId = -1;
            if (array_key_exists('id', $_GET))
                $supplierId = $_GET['id'];
            $result = $db->query('SELECT * FROM Dodavatel as d WHERE d.pk=' . $supplierId);
            if ($result->num_rows == 1)
            {
                $supplier = $result->fetch_assoc();
                echo '<h2>' . $supplier['nazov'] . '</h2>';
                if (!empty($supplier['weblink']))
                    echo '<a href=http://' . $supplier['weblink'] . '>Přejít na web dodavatele</a>';
            }
            else
            {
                echo '<h2>' . 'Neznámý dodavatel' . '</h2>';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>