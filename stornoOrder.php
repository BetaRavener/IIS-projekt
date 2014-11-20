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
        require_once 'utility.php';
    ?>
    
    <script>
    function storno(orderId)
    {
        var http = new XMLHttpRequest();
        http.open("POST", '<?php echo $web_home . 'stornoOrder-action.php' ?>', true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = 'orderId=' + orderId;
        http.send(params);
        http.onload = function() {
            var response = http.responseText;
            var message;
            if (response === "Success")
            {
                message = "Objednávka byla úspěšně stornována";
            }
            else
            {
                //TODO: error
                message = response;
            }
            alert(message);
            document.location.href= '<?php echo $web_home . 'orders.php' ?>';
        }
    }
    </script>
    
    <div id="main">
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
        
        <div id="content">
            <h2>Stornování objednávky</h2>
            <?php
            $orderId = $_GET['id'];
            $selectQuery = 'select *, CenaObjednavky(' . $orderId . ') as cena from Objednavka as o where o.pk = ' . $orderId . ' and o.kosik = false';
            $result = $db->query($selectQuery);
            if ($result and $result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $orderState = $row['stav'];
                $orderPrice = $row['cena'];
                $orderStorno = $row['stornoPoplatok'];
                
                if (isOrderNotProcessed($orderState))
                {
                    echo 'Stav objednávky: ' . $orderState . '<br/>';
                    echo 'Datum přijetí: ' . $row['datumPrijatia'] . '<br/>';
                    echo 'Celková cena objednávky: ' . $orderPrice . '<br/>';
                    echo 'Storno poplatek: ' . $orderStorno . '<br/>';
                    echo 'K navrácení: ' . ($orderPrice - $orderStorno) . '<br/>';
                    echo '<input type="button" value="Stornovat objednávku" onclick="storno(' . $orderId . ')"/>';
                }
                else
                {
                    echo 'Objednávka už byla spracována';
                }
            }
            else
            {
                echo 'Neexistující objednávka';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>