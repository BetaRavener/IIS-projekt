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
        header("Content-Type: text/html; charset=UTF-8");
        include_once('mainInit.php');
    ?>
    
    <div id="main">
        <div id="header">
            <?php include 'header.php' ?>
        </div>

        <?php include 'menu.php' ?>
        <div id="content">
            <h2>Objednávky</h2>
            <?php
            $selectQuery = 'select * from Objednavka as o where o.kosik = false and o.odberatel_pk = (select u.odberatel_pk from Uzivatel as u where u.pk = ' . $userId . ')';
            
            $result = $db->query($selectQuery);
            if ($result and $result->num_rows > 0)
            {
                echo '<table id="ordersTable">';
                echo '<tr>';
                echo '<th>Datum přijetí</th>';
                echo '<th>Stav</th>';
                echo '<th>Storno poplatek</th>';
                echo '</tr>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr id=row' . $row['pk'] . '>';
                    echo '<td>' . $row['datumPrijatia'] . '</td>';
                    echo '<td>' . $row['stav'] . '</td>';
                    echo '<td>' . $row['stornoPoplatok'] . '</td>';
                    echo '<td onclick=\'storno(' . $row['pk'] . ')\'><img src="obrazky/remove.png" class="removeimg"></td>';
                    echo '</tr>';
                }
                
                echo '</table>';
            }
            else
            {
                echo 'Nemáte žádne objednávky.';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>