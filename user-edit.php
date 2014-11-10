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
    
    <script type="text/javascript">
    
    function user_checkvalues() {
        var ret = true;
        
        var required= ["meno", "priezvisko", "dodaciaAdresa"]
        
        var i;
        for	( i = 0; i < required.length; i++) {
            document.getElementById(required[i]+"_star").style.color = "black";
        }
        
        for	( i = 0; i < required.length; i++) {
            if(document.forms["change"][required[i]].value == ""){
               document.getElementById(required[i]+"_star").style.color = "red"; 
               ret = false; 
            }
        }
        
        if(document.forms["change"]["heslo"].value != document.forms["change"]["heslo_o"].value){
            document.getElementById("heslo_o_star").style.color = "red";
            document.getElementById("heslo_o_star").innerHTML = "Hesla se neshodují!";
            ret = false;    
        }
        
        return ret;
    }
    </script>


    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
       
        <div id="content">
            <h2>Účet: <?php echo $username ?></h2>
            <?php
            $result = $db->query('SELECT * FROM Uzivatel WHERE Uzivatel.pk=' . $userId);
            if ($result->num_rows == 1)
            {
                $user = $result->fetch_assoc();
                $result = $db->query('SELECT * FROM Odberatel WHERE Odberatel.pk=' . $user['odberatel_pk']);
                if ($result->num_rows == 1)
                {
                    $customer = $result->fetch_assoc();
            ?>
            
            <form name="change" method="POST" action="user-update.php" onsubmit="return user_checkvalues()" id="change">
                Jméno: <input type="text" name="meno" value="<?php echo $customer['meno'] ?>"/><span id="meno_star">*</span> <br /> 
                Příjmení: <input type="text" name="priezvisko" value="<?php echo $customer['priezvisko'] ?>"/><span id="priezvisko_star">*</span> <br /> 
                Trvalá adresa: <input type="text" name="adresaBydliska" value="<?php echo $customer['adresaBydliska'] ?>"/> <br />
                Dodací adresa: <input type="text" name="dodaciaAdresa" value="<?php echo $customer['dodaciaAdresa'] ?>"/><span id="dodaciaAdresa_star">*</span> <br />
                E-mail: <input type="text" name="email" value="<?php echo $customer['email'] ?>"/> <br />
                Telefonní číslo: <input type="text" name="telefonneCislo" value="<?php echo $customer['telefonneCislo'] ?>"/> <br />
                <br />
                Odběr novinek: <input type="checkbox" name="odberNoviniek" value="" <?php if($customer['odberNoviniek'] == 1) echo 'checked'; ?>> <br />
                <br /> 
                <h3>Změna hesla:</h3>
                Heslo: <input type="password" name="heslo" value=""/> <br />
                Heslo (ověření): <input type="password" name="heslo_o" value=""/><span id="heslo_o_star"></span> <br />
                <input type='hidden' name="pk" value='<?php echo $userId ?>' readonly/>
                <input type='hidden' name="odberatel_pk" value='<?php echo $user['odberatel_pk'] ?>' readonly/>
                <div class="button_center">
                    <input type="submit" name="send_changes" value="Změnit údaje" />
                </div>
            </form>
            
            <?php
                }
            }
            ?>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>