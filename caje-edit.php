<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor caju</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body>

    <script>
    function showTea(url) {
        document.location.href=url;
    }
    function changeRowColor(item, hover) {
        if (hover) {
            item.className = 'teaTableRowHover';
        }
        else {
            item.className = 'teaTableRow';
        }
    }    
    </script>

    <?php
        require_once('mainInit.php');   
    ?>
    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <h2>Editace čajů</h2>
            <form name="delete" method="POST" action="caj-update.php" id="delete">
            <table id="teaTable">
                <tr>
                    <th></th>
                    <th>Název</th>
                    <th>Druh</th>
                    <th>Krajina původu</th>
                    <th>Kvalita</th>
                </tr>
                <?php
                    $i = 0;
                    $result = $db->query('SELECT * FROM Caj');
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="teaTableRow">';
                        echo '<td><input type="checkbox" name=\'checkbox'. $i .'\' value='. $row['pk'] .'></td>';
                        echo '<td>' . $row['nazov'] . '</td>';
                        echo '<td>' . $row['druh'] . '</td>';
                        echo '<td>' . $row['krajinaPovodu'] . '</td>';
                        echo '<td>' . $row['kvalita'] . '</td>';
                        echo '<td onclick=\'showTea("caj-edit.php?id=' . $row['pk'] . '")\'><img src="obrazky/pencil.png" class="pencilImg"></td>';
                        echo '</tr>';
                        $i++;
                    }
                ?>
            </table>
            <div class="button_center">
                <a href="caj-add.php"><button type="button">Přidat nový čaj</button></a>
                <input type="submit" name="delete_caj" value="Odstranit označené čaje" />
            </div>
            </form>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>