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
    function removeFromCart(index)
    {
        if ( typeof removeFromCart.counter == 'undefined' ) {
            removeFromCart.counter = <?php 
                if (array_key_exists('cart', $_SESSION))
                    echo count($_SESSION['cart']);
                else 
                    echo '0';?>;
        }
    
        var http = new XMLHttpRequest();
        http.open("POST", '<?php echo $web_home . 'removeFromCart.php'?>', true);
        http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        var params = 'cartIdx=' + index;
        http.send(params);
        http.onload = function() {
            document.getElementById('row' + index).style.display = 'none';
            alert(http.responseText);
            removeFromCart.counter--;
            if (removeFromCart.counter == 0)
                location.reload();
        }
    }
    </script>
    
    <div id="main">
        <div id="header">
            <?php include 'header.php' ?>
        </div>
        
        <?php include 'menu.php' ?>
        <div id="content">
            <?php 
            $transactionFailed = false;
            $result = $db->query('start transaction');
            $result = $db->query('set autocommit=0');
            $result = $db->query('call PotvrdKosik(' . $userId . ')');
            if (!$result)
            {
                if ($db->errno == 1644)
                {
                    //TODO: my error
                    if ($db->error == 'Amount')
                    {
                        // Unable to create order, required amount unavailable.
                        echo '<h2>Některé položky košíka už nejsou dostupné v požadovaném množství</h2>';
                        echo 'Upravte množství nebo odstaňte položky z košíku.';
                                                
                        echo '<form action="cart.php">';
                        echo '<input type=submit value="Přejít na košík" />';
                        echo '</form>';
                    }
                    else
                    {
                        echo $db->error;
                    }
                }
                else
                {
                    //TODO: db error
                    echo $db->error;
                }
                $transactionFailed = true;
            }
            
            if (!$transactionFailed)
            {
                $result = $db->query('commit');
                if ($result)
                {
                    echo '<h2>Objednávka byla úspěšně odeslána</h2>';
                    unset($_SESSION['cart']);
                }
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>