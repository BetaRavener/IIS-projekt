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
            $areaId = -1;
            if (array_key_exists('id', $_GET))
                $areaId = $_GET['id'];
            $result = $db->query('SELECT * FROM CajovaOblast as co WHERE co.pk=' . $areaId);
            if ($result->num_rows == 1)
            {
                $area = $result->fetch_assoc();
                echo '<h2>' . $area['nazov'] . '</h2>';
                echo '<p>' . $area['popis'] . '</p>';
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