<?php
session_save_path("tmp/");
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
        require_once 'checkUser.php';
        require_once 'utility.php';
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
                echo '<th>Stornovat</th>';
                echo '</tr>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr id=row' . $row['pk'] . '>';
                    echo '<td>' . $row['datumPrijatia'] . '</td>';
                    echo '<td>' . $row['stav'] . '</td>';
                    
                    if (isOrderNotProcessed($row['stav']))
                    {
                        echo '<td>' . $row['stornoPoplatok'] . '</td>';
                        echo '<td><a href=stornoOrder.php?id=' . $row['pk'] . '><img src="obrazky/remove.png" class="removeimg"></a></td>';
                    }
                    else
                    {
                        echo '<td> --- </td>';
                    }
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