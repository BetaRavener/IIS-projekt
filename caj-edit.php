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
    
    <script type="text/javascript">
    
    function showVarka(url) {
        document.location.href=url;
    }
    
    function cajedit_checkvalues() {
        var ret = true;
        document.getElementById("nazev_star").style.color = "black";
        document.getElementById("dodavatel_star").style.color = "black"; 
        
        if(document.forms["change"]["nazov"].value == ""){
           document.getElementById("nazev_star").style.color = "red"; 
           ret = false; 
        }
        
        if(document.forms["change"]["dodavatel_pk"].value == ""){ 
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
            <?php
            
            $teaId = -1;
            if (array_key_exists('id', $_GET))
                $teaId = $_GET['id'];
            $result = $db->query('SELECT * FROM Caj WHERE Caj.pk=' . $teaId);
            if ($result->num_rows == 1)
            {
                $tea = $result->fetch_assoc();
            ?>
            <form name="change" method="POST" action="caj-update.php" onsubmit="return cajedit_checkvalues()" id="change">
                <input type="hidden" name="teaId" value="<?php echo $teaId ?>" readonly/> <br />
                Nazev: <input type="text" name="nazov" value="<?php echo $tea['nazov'] ?>"/><span id="nazev_star">*</span> <br /> 
                Druh: <input type="text" name="druh" value="<?php echo $tea['druh'] ?>"/> <br /> 
                Krajina původu: <input type="text" name="krajinaPovodu" value="<?php echo $tea['krajinaPovodu'] ?>"/> <br />
                Kvalita: <input type="text" name="kvalita" value="<?php echo $tea['kvalita'] ?>"/> <br />
                Chut: <input type="text" name="chut" value="<?php echo $tea['chut'] ?>"/> <br />
                Lůhovací doba: <input type="text" name="dobaLuhovania" value="<?php echo $tea['dobaLuhovania'] ?>"/> <br />
                Zdravotní ůčinky: <input type="text" name="zdravotneUcinky" value="<?php echo $tea['zdravotneUcinky'] ?>"/> <br />
                Čajová oblast:  <select name="cajovaoblast_pk" form="change">
                                    <?php
                                        echo "<option value=''></option>";
                                        $result = $db->query('SELECT pk, nazov FROM CajovaOblast');
                                        while($row = $result->fetch_assoc()){
                                            if($row[pk] == $tea['cajovaoblast_pk'])
                                                echo "<option selected='selected' value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                            else
                                                echo "<option value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                        }    
                                    ?>
                                </select> <br />
                Dodavatel: <select name="dodavatel_pk" form="change">
                                    <?php
                                        echo "<option value=''></option>";
                                        $result = $db->query('SELECT pk, nazov FROM Dodavatel');
                                        while($row = $result->fetch_assoc()){
                                            if($row[pk] == $tea['dodavatel_pk'])
                                                echo "<option selected='selected' value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                            else
                                                echo "<option value='". $row[pk] ."'>". $row[nazov] . " (" . $row[pk] . ")</option>";
                                        }    
                                    ?>
                                </select> <span id="dodavatel_star">*</span> <br />
                
                <h3> Dostupné várky </h3>
                <table id="teaTable">
                <tr>
                    <th></th>
                    <th>Dostupné množství (g)</th>
                    <th>Datum expirace</th>
                    <th>Základní cena (100g)</th>
                    <th>Sleva (%)</th>
                    <th>Místo na skladě</th>
                    <th>Cena (100g)</th>
                </tr>
                <?php
                    
                    $i = 0;
                    $result = $db->query('SELECT * FROM Varka WHERE Varka.caj_pk='. $teaId);
                    while($row = $result->fetch_assoc()) {
                        echo "<tr class='teaTableRow'>";
                        echo "<td><input type='checkbox' name='checkbox".$i."' value='".$row['pk']."'/></td>";
                        echo "<input type='hidden' name='pk".$i."' value='".$row['pk']."' readonly/>";
                        echo "<td><input class='edit' type='number' name='dostupneMnozstvo".$i."' value='".$row['dostupneMnozstvo']."' min='0' max='1000000' step='1'/></td>";
                        echo "<td><input class='edit' type='date' name='datumExpiracie".$i."' value='".$row['datumExpiracie']."'/></td>";
                        echo "<td><input class='edit' type='number' name='cena".$i."' value='".$row['cena']."' min='0' max='1000' step='0.1'/></td>";
                        echo "<td><input class='edit' type='number' name='zlava".$i."' value='".($row['zlava']*100)."' min='0' max='100' step='0.1'/></td>";
                        echo "<td><input class='edit' type='number' name='miestoNaSklade".$i."' value='".$row['miestoNaSklade']."' min='0' max='1000' step='1'/></td>";
    
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
                        echo '</tr>';
                        $i += 1;
                    }
                    echo "<input type='hidden' name='count' value=".$i." readonly/>";
                ?>
                </table>
                <div class="button_center">
                    <input type="submit" name="send_changes" value="Uložit změny" />
                    <button type="button" onclick="showVarka('varka-add.php?id=<?php echo $teaId; ?>')">Přidat novou várku</button>
                    <input type="submit" name="delete_varka" value="Odstranit označené várky" />
                </div>
            </form>
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