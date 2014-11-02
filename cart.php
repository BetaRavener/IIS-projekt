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
    <script>
    function removeFromCart(index)
    {
        document.getElementById('row' + index).style.display = 'none';
        var http = new XMLHttpRequest();
        http.open("POST", 'http://www.stud.fit.vutbr.cz/~xsevci50/IIS/removeFromCart.php', true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = 'cartIdx=' + index;
        http.send(params);
        http.onload = function() {
            alert(http.responseText);
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
            <h2>Košík</h2>
            <?php
            if (!array_key_exists('cart', $_SESSION) or empty($_SESSION['cart']))
            {
                echo 'Košík je prázdny.';
            }
            else
            {
                echo '<table id="teaTable">';
                echo '<tr>';
                echo '<th>Názov čaju</th>';
                echo '<th>Množstvo</th>';
                echo '<th>Cena</th>';
                echo '</tr>';
                foreach ($_SESSION['cart'] as $idx => $cartItem)
                {
                    $batchId = $cartItem['batchId'];
                    $amount = $cartItem['amount'];
                    $result = $db->query('SELECT * FROM Varka WHERE Varka.pk=' . $batchId);
                    if ($result->num_rows == 1)
                    {
                        $batch = $result->fetch_assoc();
                        $discount = floatval($batch['zlava']);
                        $price = floatval($batch['cena']);
                        $discountPrice = $price * (1.0 - $discount);
                        $result = $db->query('SELECT * FROM Caj WHERE Caj.pk=' . $batch['caj_pk']);
                        $tea = $result->fetch_assoc();
                        echo '<tr id=row' . $idx . '>';
                        echo '<td>' . $tea['nazov'] . '</td>';
                        echo '<td>' . $amount . '</td>';
                        echo '<td>' . $discountPrice * $amount . '</td>';
                        echo '<td onClick=\'removeFromCart(' . $idx . ')\'><img src="obrazky/remove.png" class="removeImg"></td>';
                        echo '</tr>';
                    }
                    else
                    {
                        //TODO: Remove
                    }
                }
                echo '</table>';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>