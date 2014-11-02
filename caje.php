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
        header("Content-Type: text/html; charset=UTF-8");     
    ?>
    
    <div id="main">
        <div id="header">
            <?php
                $logged = true;
                $username = 'ja';
                include 'db.php';
                if($logged)
                {
                    include 'logged.php';
                }
                else
                {
                    include 'login.php';
                }
            ?>
            <h1>Prodejna čajů Tomáš a Ivan</h1> 
        </div>
        
        <?php include 'menu.php' ?>
        <div id="content">
            <h2>Čaje</h2>
            <table id="teaTable">
                <tr>
                    <th>Název</th>
                    <th>Druh</th>
                    <th>Krajina původu</th>
                    <th>Kvalita</th>
                </tr>
                <?php
                    $result = $db->query('SELECT * FROM Caj');
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="teaTableRow" onmouseover=\'changeRowColor(this, true)\' onmouseout=\'changeRowColor(this, false)\' onclick=\'showTea("caj.php?id=' . $row['pk'] . '")\'>';
                        echo '<td>' . $row['nazov'] . '</td>';
                        echo '<td>' . $row['druh'] . '</td>';
                        echo '<td>' . $row['krajinaPovodu'] . '</td>';
                        echo '<td>' . $row['kvalita'] . '</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>