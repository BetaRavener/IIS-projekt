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
        require_once 'checkAdmin.php';
    ?>

    <script>
    function showTea(url) {
        document.location.href=url;
    }
    
    function changeRowColor(item, hover) {
        if (hover) {
            item.className = 'customerTableRowHover';
        }
        else {
            item.className = 'customerTableRow';
        }
    }
    
    function filter()
    {
        var filterString = document.getElementById('nameFilter').value;
        
        var list = document.getElementsByClassName('customerTableRow');
        var arr = Array.prototype.slice.call(list, 0);
        arr.forEach(function (trElem) {
            var nameElem = trElem.childNodes[0];
            var surnameElem = trElem.childNodes[1];
            var addressElem = trElem.childNodes[2];
            var name = nameElem.childNodes[0].nodeValue;
            var surname = surnameElem.childNodes[0].nodeValue;
            var address = addressElem.childNodes[0].nodeValue;
            
            var re = new RegExp(filterString, "i");
            var fullName = name + " " + surname;
            
            if (re.test(fullName) || re.test(address))
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
            <h2>Odběratelé</h2>
            
            <div id="filter">
            <?php
            
            echo 'Hledat: <input type="text" id="nameFilter" oninput="filter()">';
            
            ?>
            </div>
            
            <table id="teaTable">
                <tr>
                    <th>Jméno</th>
                    <th>Příjmení</th>
                    <th>Dodací adresa</th>
                    <th>Počet objednávek</th>
                </tr>
                <?php
                    $result = $db->query('SELECT odb.*, COUNT(obj.pk) as pocet FROM Odberatel AS odb JOIN Objednavka AS obj ON odb.pk = obj.odberatel_pk GROUP BY odb.pk');
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="customerTableRow" onmouseover=\'changeRowColor(this, true)\' onmouseout=\'changeRowColor(this, false)\' onclick=\'showTea("customer.php?id=' . $row['pk'] . '")\'>';
                        echo '<td>' . $row['meno'] . '</td>';
                        echo '<td>' . $row['priezvisko'] . '</td>';
                        echo '<td>' . $row['dodaciaAdresa'] . '</td>';
                        echo '<td>' . $row['pocet'] . '</td>';
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