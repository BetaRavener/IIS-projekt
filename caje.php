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
    
    function filter()
    {
        var type = document.getElementById('typeFilter').value;
        var name = document.getElementById('nameFilter').value;
        
        var list = document.getElementsByClassName('teaTableRow');
        var arr = Array.prototype.slice.call(list, 0);
        arr.forEach(function (trElem) {
            var nameElem = trElem.childNodes[0];
            var typeElem = trElem.childNodes[1];
            var rowName = nameElem.childNodes[0].nodeValue;
            var rowType = typeElem.childNodes[0].nodeValue;

            var re = new RegExp(name, "i");
            
            if (re.test(rowName) && (type === "" || rowType === type))
            {
                trElem.style.display = "";
            }
            else
            {
                trElem.style.display = "none";
            }
        });
    }
    </script>
    
    <div id="main">
        <?php require_once 'header.php' ?>
        <?php require_once 'menu.php' ?>
        
        <div id="content">
            <h2>Čaje</h2>
            
            <div id="filter">
            <?php
            $types = array();
            array_push($types, "");
            $result = $db->query('SELECT * FROM Caj');
            while($row = $result->fetch_assoc()) {
                $type = $row['druh'];
                if (!in_array($type, $types))
                    array_push($types, $type);
            }
            
            
            echo 'Název: <input type="text" id="nameFilter" oninput="filter()">';
            echo 'Druh: <select id="typeFilter" onchange="filter()">';
            foreach ($types as $type)
            {
                echo '<option value="' . $type . '">' . (empty($type) ? 'Všechny' : $type) . '</option>';
            }
            echo '</select>';
            
              
            ?>
            </div>
            
            <table id="teaTable">
                <tr>
                    <th>Název</th>
                    <th>Druh</th>
                    <th>Krajina původu</th>
                    <th>Kvalita</th>
                    <th>Průměrná cena (100g)</th>
                </tr>
                <?php
                    $result = $db->query('SELECT c.*, ROUND(AVG(v.cena), 2) as cena FROM Caj AS c LEFT JOIN Varka AS v ON c.pk = v.caj_pk GROUP BY c.pk');
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="teaTableRow" onmouseover=\'changeRowColor(this, true)\' onmouseout=\'changeRowColor(this, false)\' onclick=\'showTea("caj.php?id=' . $row['pk'] . '")\'>';
                        echo '<td>' . $row['nazov'] . '</td>';
                        echo '<td>' . $row['druh'] . '</td>';
                        echo '<td>' . $row['krajinaPovodu'] . '</td>';
                        echo '<td>' . $row['kvalita'] . '</td>';
                        echo '<td>' . $row['cena'] . '</td>';
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