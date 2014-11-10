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
        
        var required= ["meno", "priezvisko", "dodaciaAdresa", "u_meno", "heslo", "heslo_o"]
        document.getElementById("heslo_o_star").innerHTML = "*";
        
        var i;
        for	( i = 0; i < required.length; i++) {
            document.getElementById(required[i]+"_star").style.color = "black";
        }
        
        for	( i = 0; i < required.length; i++) {
            if(document.forms["add"][required[i]].value == ""){
               document.getElementById(required[i]+"_star").style.color = "red"; 
               ret = false; 
            }
        }
        
        if(document.forms["add"]["heslo"].value != document.forms["add"]["heslo_o"].value){
            document.getElementById("heslo_star").style.color = "red";
            document.getElementById("heslo_o_star").style.color = "red";
            document.getElementById("heslo_o_star").innerHTML = "* Hesla se neshodují!";
            ret = false;    
        }
        
        return ret;
    }
    </script>


    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
       
        <div id="content">
            <h2>Registrace</h2>
            
            <form name="add" method="POST" action="user-update.php" onsubmit="return user_checkvalues()" id="add">
                Jméno: <input type="text" name="meno" value=""/><span id="meno_star">*</span> <br /> 
                Příjmení: <input type="text" name="priezvisko" value=""/><span id="priezvisko_star">*</span> <br /> 
                Trvalá adresa: <input type="text" name="adresaBydliska" value=""/> <br />
                Dodací adresa: <input type="text" name="dodaciaAdresa" value=""/><span id="dodaciaAdresa_star">*</span> <br />
                E-mail: <input type="text" name="email" value=""/> <br />
                Telefonní číslo: <input type="text" name="telefonneCislo" value=""/> <br />
                <br />
                Odběr novinek: <input type="checkbox" name="odberNoviniek" value=""> <br />
                <br />
                Uživatelské jméno: <input type="text" name="u_meno" value=""/><span id="u_meno_star">*</span> <br /> 
                Heslo: <input type="password" name="heslo" value=""/><span id="heslo_star">*</span> <br />
                Heslo (ověření): <input type="password" name="heslo_o" value=""/><span id="heslo_o_star">*</span> <br />
                <div class="button_center">
                    <input type="submit" name="create_user" value="Vytvořit" />
                </div>
            </form>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>