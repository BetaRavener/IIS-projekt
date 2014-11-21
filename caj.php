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
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <?php
            $teaId = -1;
            if (array_key_exists('id', $_GET))
                $teaId = $_GET['id'];
            $result = $db->query('SELECT c.*, d.nazov as dNazov, o.nazov as oNazov FROM (Caj as c LEFT JOIN Dodavatel AS d on c.dodavatel_pk = d.pk) LEFT JOIN CajovaOblast AS o ON c.cajovaoblast_pk = o.pk WHERE c.pk=' . $teaId);
            if ($result->num_rows == 1)
            {
                $tea = $result->fetch_assoc();
            ?>
                <h2> <?php echo $tea['nazov'] ?> </h2>
                Druh: <?php echo $tea['druh'] ?> <br />
                Krajina původu: <?php echo $tea['krajinaPovodu'] ?> <br />
                Kvalita: <?php echo empty($tea['kvalita']) ? 'Základní' : $tea['kvalita'] ?> <br />
                Chuť: <?php echo $tea['chut'] ?> <br />
                Lůhovací doba: <?php echo $tea['dobaLuhovania'] ?> <br />
                Zdravotní ůčinky: <?php echo empty($tea['zdravotneUcinky']) ? 'Žádné' : $tea['zdravotneUcinky'] ?> <br />
                Čajová oblast: 
                <?php
                if (empty($tea['cajovaoblast_pk']))
                    echo 'Neznámá';
                else
                    echo '<a href=' . $web_home . 'area.php?id=' . $tea['cajovaoblast_pk'] . '>' . $tea['oNazov'] . '</a>';
                ?> <br />
                Dodavatel: 
                <?php
                if (empty($tea['dodavatel_pk']))
                    echo 'Neznámý';
                else
                    echo '<a href=' . $web_home . 'supplier.php?id=' . $tea['dodavatel_pk'] . '>' . $tea['dNazov'] . '</a>';
                ?> <br />
                
                <h3> Dostupné várky </h3>
                
                <?php 
                $result = $db->query('SELECT * FROM Varka WHERE Varka.caj_pk='. $teaId);
                if ($result and $result->num_rows > 0)
                {
                ?>
                    <table id="teaTable">
                    <tr>
                        <th>Dostupné množství (g)</th>
                        <th>Datum expirace</th>
                        <th>Cena (100g)</th>
                        <?php if (!$isAdmin) { ?>
                        <th>Množství (g)</th>
                        <?php } ?>
                    </tr>
                    
                    <?php
                    while($row = $result->fetch_assoc()) {
                        echo '<tr class="teaTableRow">';
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
                        if (!$isAdmin) {
                            echo '<td><input type=number id="amount' . $row['pk'] . '" value="0" /></td>';
                            echo '<td onClick=\'addToCart(' . $row['pk'] . ')\'><img src="obrazky/cart.png" class="cartImg"></td>';
                        }
                        echo '</tr>';
                    }
                }
                else
                {
                    echo 'Pro tento čaj nejsou momentálně dostupné žádne várky.';
                }
                ?>
            </table>
            <?php
            }
            else
            {
                echo '<h2>' . 'Neznámý čaj' . '</h2>';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>