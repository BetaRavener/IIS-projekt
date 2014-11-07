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
        include_once('config.php');
    ?>

    <script>
    
    </script>
    
    <div id="main">
        <div id="header">
            <?php include 'header.php' ?>
        </div>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <h2>Vaše objednávka</h2>
            <?php
            $selectQuery = 'select po.pk, c.nazov, po.objednaneMnozstvo as mnozstvo, v.cena * (1 - v.zlava) as cena ';
            $selectQuery .= 'from (PolozkaObjednavky as po left join Varka as v on po.varka_pk = v.pk) left join Caj as c on v.caj_pk = c.pk ';
            $selectQuery .= 'where po.objednavka_pk = ZiskajKosik(' . $userId . ')';
            
            $result = $db->query($selectQuery);
            if ($result and $result->num_rows > 0)
            {
                echo '<table id="orderTable">';
                echo '<tr>';
                echo '<th>Název čaju</th>';
                echo '<th>Cena (100g)</th>';
                echo '<th>Množství (g)</th>';
                echo '</tr>';
                while($row = $result->fetch_assoc()) {
                    echo '<tr id=row' . $row['pk'] . '>';
                    echo '<td>' . $row['nazov'] . '</td>';
                    echo '<td>' . $row['cena'] . '</td>';
                    echo '<td>' . $row['mnozstvo'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                
                $result = $db->query('select odb.* from Odberatel as odb join Uzivatel as u on odb.pk = u.odberatel_pk where u.pk =' . $userId);
                if ($result and $result->num_rows == 1)
                {
                    $client = $result->fetch_assoc();
                    echo '<h3>Fakturační údaje:</h3>';
                    echo 'Jméno: ' . $client['meno'] . ' ' . $client['priezvisko'] . '<br/>';
                    echo 'Adresa bydliska: ' . $client['adresaBydliska'] . '<br/>';
                    echo 'Dodací adresa: ' . $client['dodaciaAdresa'] . '<br/>';
                    echo 'Kontaktní email: ' . $client['email'] . '<br/>';
                    echo 'Telefonní číslo: ' . $client['telefonneCislo'] . '<br/>';
                }
                
                echo '<form action="order-done.php">';
                echo '<input type=submit value="Potvrdit objednávku" />';
                echo '</form>';
            }
            else
            {
                echo 'Nemožné sestavit objednávku, košík je prázdny.';
            }
            // else
            // {
                // echo '<table id="orderTable">';
                // echo '<tr>';
                // echo '<th>Název čaju</th>';
                // echo '<th>Množství (g)</th>';
                // echo '<th>Cena</th>';
                // echo '</tr>';
                // foreach ($_SESSION['cart'] as $idx => $cartItem)
                // {
                    // $batchId = $cartItem['batchId'];
                    // $amount = $cartItem['amount'];
                    // $result = $db->query('SELECT * FROM Varka WHERE Varka.pk=' . $batchId);
                    // if ($result->num_rows == 1)
                    // {
                        // $batch = $result->fetch_assoc();
                        // $discount = floatval($batch['zlava']);
                        // $price = floatval($batch['cena']);
                        // $discountPrice = $price * (1.0 - $discount);
                        // $result = $db->query('SELECT * FROM Caj WHERE Caj.pk=' . $batch['caj_pk']);
                        // $tea = $result->fetch_assoc();
                        // echo '<tr id=row' . $idx . '>';
                        // echo '<td>' . $tea['nazov'] . '</td>';
                        // echo '<td>' . $amount . '</td>';
                        // echo '<td>' . $discountPrice * $amount . '</td>';
                        // echo '</tr>';
                    // }
                    // else
                    // {
                        // //TODO: Remove
                    // }
                // }
                // echo '</table>';
            // }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>