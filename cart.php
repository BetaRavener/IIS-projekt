﻿<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Distributor caju</title>
<link rel="stylesheet" href="style.css" type="text/css" >
</head>

<body onload='onBodyLoad()'>
    <?php
        header("Content-Type: text/html; charset=UTF-8");
        include_once('mainInit.php');
    ?>

    <script>
    function removeFromCart(index)
    {
        if ( typeof removeFromCart.counter == 'undefined' ) {
            removeFromCart.counter = <?php 
                    $result = $db->query('select * from PolozkaObjednavky as po where po.objednavka_pk = (select ZiskajKosik(' . $userId . '))');
                    if ($result)
                        echo $result->num_rows;
                    else
                        echo '0'; ?>
        }
    
        var http = new XMLHttpRequest();
        http.open("POST", '<?php echo $web_home . 'removeFromCart.php'?>', true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = 'cartItemId=' + index;
        http.send(params);
        http.onload = function() {
            var elem = document.getElementById('row' + index)
            elem.parentNode.removeChild(elem);
            alert(http.responseText);
            removeFromCart.counter--;
            if (removeFromCart.counter == 0)
                location.reload();
            else
                totalPrice();
        }
    }
    
    function totalPrice()
    {
        var elem = document.getElementById('totalPrice');
        if (elem !== null)
        {
            var list = document.getElementsByTagName('td');
            var arr = Array.prototype.slice.call(list, 0);
            var total = 0;
            arr.forEach(function (tdElem) {
                if (/^price.*$/.test(tdElem.id))
                {
                    var price = parseFloat(tdElem.innerHTML);
                    total += price;
                }
            });
            elem.innerHTML = total.toString();
        }
    }
    
    function amountChanged(idx)
    {
        var amountElem = document.getElementById('amount' + idx);
        var amount = parseFloat(amountElem.value);
        var price = 0;
        if (!isNaN(amount))
        {
            var unitPrice = parseFloat(document.getElementById('unitPrice' + idx).innerHTML);
            price = unitPrice * amount / 100;
            
            if(!checkAvailable(idx))
                alert('mnozstvo');
        }
        document.getElementById('price' + idx).innerHTML = price.toString();

        totalPrice();
    }
    
    function checkAvailable(idx)
    {
        var amountElem = document.getElementById('amount' + idx);
        var availableElem = document.getElementById('available' + idx);
        
        var amount = parseFloat(amountElem.value);
        var available = parseFloat(availableElem.innerHTML);
        
        return amount <= available;
    }
    
    function onBodyLoad()
    {
        var list = document.getElementsByTagName('tr');
        var arr = Array.prototype.slice.call(list, 0);
        arr.forEach(function (tdElem) {
            if (/^row.*$/.test(tdElem.id))
            {
                if (!checkAvailable(parseInt(tdElem.id.slice(3))))
                    alert('mnozstvo');
            }
        });
        totalPrice();
    }
    
    </script>
    
    <div id="main">
        <div id="header">
            <?php include 'header.php' ?>
        </div>

        <?php include 'menu.php' ?>
        <div id="content">
            <h2>Košík</h2>
            <?php
            $selectQuery = 'select po.pk, c.nazov, po.objednaneMnozstvo as mnozstvo, v.cena * (1 - v.zlava) as cena, v.dostupneMnozstvo ';
            $selectQuery .= 'from (PolozkaObjednavky as po left join Varka as v on po.varka_pk = v.pk) left join Caj as c on v.caj_pk = c.pk ';
            $selectQuery .= 'where po.objednavka_pk = ZiskajKosik(' . $userId . ')';
            
            $result = $db->query($selectQuery);
            if ($result and $result->num_rows > 0)
            {
                echo '<table id="teaTable">';
                echo '<tr>';
                echo '<th>Název čaju</th>';
                echo '<th>Cena (100g)</th>';
                echo '<th>Dostupné množství (g)</th>';
                echo '<th>Množství (g)</th>';
                echo '<th>Cena</th>';
                echo '</tr>';
                
                while($row = $result->fetch_assoc()) {
                    echo '<tr id=row' . $row['pk'] . '>';
                    echo '<td>' . $row['nazov'] . '</td>';
                    echo '<td id=unitPrice' . $row['pk'] . '>' . $row['cena'] . '</td>';
                    echo '<td id="available' . $row['pk'] . '">' . $row['dostupneMnozstvo'] . '</td>';
                    echo '<td> <input type=number id="amount' . $row['pk'] . '" value="' . $row['mnozstvo'] . '" oninput="amountChanged(' . $row['pk'] . ')"/> </td>';
                    echo '<td id=price' . $row['pk'] . '>' . floatval($row['cena']) * floatval($row['mnozstvo']) / 100 . '</td>';
                    echo '<td onclick=\'removeFromCart(' . $row['pk'] . ')\'><img src="obrazky/remove.png" class="removeimg"></td>';
                    echo '</tr>';
                }
                
                echo '</table>';
                
                echo 'Celková cena: <b id=totalPrice>0</b>';
                echo '<form action="order.php">';
                echo '<input type=submit value="Přejít na objednávku" />';
                echo '</form>';
            }
            else
            {
                echo 'Košík je prázdny.';
            }
            
            // if (!array_key_exists('cart', $_SESSION) or empty($_SESSION['cart']))
            // {
                // echo 'Košík je prázdny.';
            // }
            // else
            // {
                // echo '<table id="teaTable">';
                // echo '<tr>';
                // echo '<th>Název čaju</th>';
                // echo '<th>Množství</th>';
                // echo '<th>Cena</th>';
                // echo '</tr>';
                // foreach ($_session['cart'] as $idx => $cartitem)
                // {
                    // $batchid = $cartitem['batchid'];
                    // $amount = $cartitem['amount'];
                    // $result = $db->query('select * from varka where varka.pk=' . $batchid);
                    // if ($result->num_rows == 1)
                    // {
                        // $batch = $result->fetch_assoc();
                        // $discount = floatval($batch['zlava']);
                        // $price = floatval($batch['cena']);
                        // $discountprice = $price * (1.0 - $discount);
                        // $result = $db->query('select * from caj where caj.pk=' . $batch['caj_pk']);
                        // $tea = $result->fetch_assoc();
                        // echo '<tr id=row' . $idx . '>';
                        // echo '<td>' . $tea['nazov'] . '</td>';
                        // echo '<td>' . $amount . '</td>';
                        // echo '<td>' . $discountprice * $amount . '</td>';
                        // echo '<td onclick=\'removeFromCart(' . $idx . ')\'><img src="obrazky/remove.png" class="removeimg"></td>';
                        // echo '</tr>';
                    // }
                    // else
                    // {
                        // //todo: remove
                    // }
                // }
                
                // echo '</table>';
                
                // echo '<form action="order.php">';
                // echo '<input type=submit value="Přejít na objednávku" />';
                // echo '</form>';
            // }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>