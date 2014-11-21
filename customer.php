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
        require_once 'checkAdmin.php';
    ?>
    
    <div id="main">
        <?php require_once 'header.php' ?>
        <?php require_once 'menu.php' ?>
        
        <div id="content">
            <?php
            $customerId = -1;
            if (array_key_exists('id', $_GET))
                $customerId = $_GET['id'];
            $result = $db->query('SELECT * FROM Odberatel AS odb WHERE odb.pk=' . $customerId);
            if ($result->num_rows == 1)
            {
                $customer = $result->fetch_assoc();
            ?>
                <h2> Odběratel <?php echo $customer['meno'] . ' ' . $customer['priezvisko'] ?> </h2>
                Dodací adresa: <?php echo $customer['dodaciaAdresa'] ?> <br/>
                Adresa bydliska: <?php echo empty($customer['adresaBydliska']) ? 'Nezadána' : $customer['adresaBydliska'] ?> <br/>
                Email: <?php echo empty($customer['email']) ? 'Nezadán' : $customer['email'] ?> <br/>
                Telefonní číslo: <?php echo empty($customer['telefonneCislo']) ? 'Nezadáno' : $customer['telefonneCislo'] ?> <br/>
                <?php
                if (!empty($customer['email']))
                { 
                    echo '<form action="mail.php" method="POST">';
                    echo '<input type="hidden" name="email" value="' . $customer['email'] . '"/>';
                    echo '<input type="submit" value="Informovat pomocí emailu"/>';
                    echo '</form>';
                }
                ?>
            <?php
            }
            else
            {
                echo '<h2>' . 'Neznámý odběratel' . '</h2>';
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>