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

    <script>
    function addToCart(batchId)
    {
        amount = document.getElementById("amount" + batchId).value;
        var http = new XMLHttpRequest();
        http.open("POST", '<?php echo $web_home . 'addToCart.php' ?>', true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = 'batchId=' + batchId + '&amount=' + amount;
        http.send(params);
        http.onload = function() {
            alert(http.responseText);
        }
    }
    </script>
    
    <div id="main">
        <div id="header">
            <?php include 'header.php' ?>
            <?php include 'menu.php' ?>
        </div>
        
        <?php include 'menu.php' ?>
        <div id="content">
            <?php
            $teaId = -1;
            if (array_key_exists('id', $_GET))
                $teaId = $_GET['id'];
            $result = $db->query('SELECT * FROM Caj WHERE Caj.pk=' . $teaId);
            if ($result->num_rows == 1)
            {
                $tea = $result->fetch_assoc();
            ?>
                <h2> <?php echo $tea['nazov'] ?> </h2>
                Druh: <?php echo $tea['druh'] ?> <br />
                Krajina původu: <?php echo $tea['krajinaPovodu'] ?> <br />
                Kvalita: <?php echo $tea['kvalita'] ?> <br />
                Chut: <?php echo $tea['chut'] ?> <br />
                Lůhovací doba: <?php echo $tea['dobaLuhovania'] ?> <br />
                Zdravotní ůčinky: <?php echo $tea['zdravotneUcinky'] ?> <br />
                Čajová oblast: <?php echo $tea['cajovaoblast_pk'] ?> <br />
                Dodavatel: <?php echo $tea['dodavatel_pk'] ?> <br />
                
                <h3> Dostupné várky </h3>
                <table id="teaTable">
                <tr>
                    <th>Id</th>
                    <th>Dostupné množství (g)</th>
                    <th>Datum expirace</th>
                    <th>Cena (100g)</th>
                    <th>Množství (g)</th>
                </tr>
                <?php
                    $result = $db->query('SELECT * FROM Varka WHERE Varka.caj_pk='. $teaId);
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="teaTableRow">';
                        echo '<td>' . $row['pk'] . '</td>';
                        echo '<td>' . $row['dostupneMnozstvo'] . '</td>';
                        echo '<td>' . $row['datumExpiracie'] . '</td>';
                        $discount = floatval($row['zlava']);
                        $price = floatval($row['cena']);
                        if ($discount > 0.0)
                        {
                            $discountPrice = $price * (1.0 - $discount);
                            echo '<td>' . $discountPrice . '</td>';
                        }
                        else
                        {
                            echo '<td>' . $price . '</td>';
                        }
                        echo '<td><input type=number id="amount' . $row['pk'] . '"/></td>';
                        echo '<td onClick=\'addToCart(' . $row['pk'] . ')\'><img src="obrazky/cart.png" class="cartImg"></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
            <?php
            }
            else
            {
                echo '<h2>' . 'Neznámej čaj' . '</h2>';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>