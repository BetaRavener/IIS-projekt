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
    
    function cajadd_checkvalues() {
        var ret = true;
        
        if(document.forms["add"]["nazov"].value == ""){
           document.getElementById("nazev_star").style.color = "red"; 
           ret = false; 
        }
        
        if(document.forms["add"]["dodavatel_pk"].value == ""){ 
           document.getElementById("dodavatel_star").style.color = "red"; 
           ret = false; 
        }
        
        return ret;
    }
    </script>


    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
       
        <div id="content">
            <h2>Nový čaj</h2>
            
            <form name="add" method="POST" action="caj-update.php" onsubmit="return cajadd_checkvalues()" id="add">
                Nazev: <input type="text" name="nazov" value=""/><span id="nazev_star">*</span> <br /> 
                Druh: <input type="text" name="druh" value=""/> <br /> 
                Krajina původu: <input type="text" name="krajinaPovodu" value=""/> <br />
                Kvalita: <input type="text" name="kvalita" value=""/> <br />
                Chut: <input type="text" name="chut" value=""/> <br />
                Lůhovací doba: <input type="text" name="dobaLuhovania" value=""/> <br />
                Zdravotní ůčinky: <input type="text" name="zdravotneUcinky" value=""/> <br />
                Čajová oblast:  <select name="cajovaoblast_pk" form="add">
                                    <?php
                                        echo "<option value=''></option>";
                                        $result = $db->query('SELECT pk, nazov FROM CajovaOblast');
                                        while($row = $result->fetch_assoc()){
                                            echo "<option value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                        }    
                                    ?>
                                </select> <br />
                Dodavatel: <select name="dodavatel_pk" form="add">
                                    <?php
                                        echo "<option value=''></option>";
                                        $result = $db->query('SELECT pk, nazov FROM Dodavatel');
                                        while($row = $result->fetch_assoc()){
                                            echo "<option value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                        }    
                                    ?>
                                </select> <span id="dodavatel_star">*</span> <br />
                <div class="button_center">
                    <input type="submit" name="create_caj" value="Vytvořit" />
                </div>
            </form>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>