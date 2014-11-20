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
    
    <script type="text/javascript">
    
    function stop(event){
        if (event.stopPropagation) {
            event.stopPropagation();   // W3C model
        } else {
            event.cancelBubble = true; // IE model
        }
    }
    
    function changeRowColor(item, hover) {
        if (hover) {
            item.className = 'teaTableRowHover';
        }
        else {
            item.className = 'teaTableRow';
        }
    }
    
    function showItems(s, f){          
        var e = document.getElementsByClassName('hideable');
        
        var i = s;
        
        if(e[i].style.display == 'none' || e[i].style.display == "")            
            for(i=s; i<=s+f; i++) {
                e[i].style.display = 'table-row';
            }
        else
            for(i=s; i<=s+f; i++) {
                e[i].style.display = 'none';
            }
    }
    
    </script>
    
    <div id="main">
        
        <?php include 'header.php' ?>
        <?php include 'menu.php' ?>
    
        <div id="content">
            <h2>Objednávky ke zpracování</h2>
            
            <form name="change" method="POST" action="objednavka-update.php" id="change">
                
                <table id="teaTable">
                <?php
                    $i = 0;
                    $j = 0;
                    
                    echo "<tr>";
                    echo "<th></th>";
                    echo "<th>ID</th>";
                    echo "<th>Datum přijetí</th>";
                    echo "<th>Příjemce</th>";
                    echo "<th>Adresa dodání</th>";
                    echo "<th>Stav</th>";
                    echo "</tr>";
                    
                    $result = $db->query('SELECT Objednavka.pk, stav, datumPrijatia, meno, priezvisko, dodaciaAdresa FROM Objednavka INNER JOIN Odberatel ON Objednavka.odberatel_pk=Odberatel.pk WHERE Objednavka.stav=\'prijata\' OR Objednavka.stav=\'stornovana\'');
                    while($row = $result->fetch_assoc()) {
                        
                        $result1 = $db->query('SELECT PolozkaObjednavky.pk, objednaneMnozstvo, miestoNaSklade, nazov FROM (PolozkaObjednavky INNER JOIN Varka ON PolozkaObjednavky.varka_pk=Varka.pk) INNER JOIN Caj ON Varka.caj_pk=Caj.pk WHERE PolozkaObjednavky.objednavka_pk='.$row['pk']);
                        
                        echo "<tr class='teaTableRow' onmouseover='changeRowColor(this, true)' onmouseout='changeRowColor(this, false)' onclick='showItems(".$i.", ".$result1->num_rows.")'>";  
                        echo "<td><input type='checkbox' name='checkbox". $j ."' value=". $row['pk'] ." onmouseover='stop(event)' onmouseout='stop(event)' onclick='stop(event)'></td>";
                        echo "<td>".$row['pk']."</td>";
                        echo "<td>".$row['datumPrijatia']."</td>";
                        echo "<td>".$row['meno']." ".$row['priezvisko']."</td>";
                        echo "<td>".$row['dodaciaAdresa']."</td>";
                        echo "<td class='no_edit'><input type='text' name='stav".$j."' value='".$row['stav']."' readonly/></td>";
                        echo '</tr>';
                        
                        echo "<tr class='hideable'>";
                        echo "<th></th>";
                        echo "<th>ID</th>";
                        echo "<th>Název čaje</th>";
                        echo "<th>Objednané množství</th>";
                        echo "<th>Místo na skladě</th>";
                        echo "</tr>";
                        
                        while($row1 = $result1->fetch_assoc()) {
                            
                            echo "<tr class='teaTableRow hideable'>";
                            echo "<td class='blue'></td>";  
                            echo "<td>".$row1['pk']."</td>";
                            echo "<td>".$row1['nazov']."</td>";
                            echo "<td>".$row1['objednaneMnozstvo']."</td>";
                            echo "<td>".$row1['miestoNaSklade']."</td>";
                            echo '</tr>';
                        
                        }
                        
                        $i += $result1->num_rows + 1;
                        $j++;
                    }
                    
                    echo "<input type='hidden' name='count' value=".$j."/>";
                    
                ?>
                </table>
                <div class="button_center">
                    <input type="submit" name="send_changes" value="Změnit stav" />
                </div>
            </form>
            
            <form name="delete" method="POST" action="objednavka-update.php" id="delete">
                <h2>Zpracované objednávky</h2>
                <table id="teaTable">
                <?php
                    $j = 0;
    
                    echo "<tr>";
                    echo "<th></th>";
                    echo "<th>ID</th>";
                    echo "<th>Datum přijetí</th>";
                    echo "<th>Příjemce</th>";
                    echo "<th>Adresa dodání</th>";
                    echo "<th>Stav</th>";
                    echo "</tr>";
                    
                    $result = $db->query('SELECT Objednavka.pk, stav, datumPrijatia, meno, priezvisko, dodaciaAdresa FROM Objednavka INNER JOIN Odberatel ON Objednavka.odberatel_pk=Odberatel.pk WHERE Objednavka.stav!=\'prijata\' AND Objednavka.stav!=\'stornovana\''); //AND Objednavka.kosik=0
                    while($row = $result->fetch_assoc()) {
                        
                        $result1 = $db->query('SELECT PolozkaObjednavky.pk, objednaneMnozstvo, miestoNaSklade, nazov FROM (PolozkaObjednavky INNER JOIN Varka ON PolozkaObjednavky.varka_pk=Varka.pk) INNER JOIN Caj ON Varka.caj_pk=Caj.pk WHERE PolozkaObjednavky.objednavka_pk='.$row['pk']);
                        
                        echo "<tr class='teaTableRow' onmouseover='changeRowColor(this, true)' onmouseout='changeRowColor(this, false)' onclick='showItems(".$i.", ".$result1->num_rows.")'>";  
                        echo "<td><input type='checkbox' name='checkbox". $j ."' value=". $row['pk'] ." onmouseover='stop(event)' onmouseout='stop(event)' onclick='stop(event)'></td>";
                        echo "<td>".$row['pk']."</td>";
                        echo "<td>".$row['datumPrijatia']."</td>";
                        echo "<td>".$row['meno']." ".$row['priezvisko']."</td>";
                        echo "<td>".$row['dodaciaAdresa']."</td>";
                        echo "<td>".$row['stav']."</td>";   
                        echo '</tr>';
                        
                        echo "<tr class='hideable'>";
                        echo "<th></th>";
                        echo "<th>ID</th>";
                        echo "<th>Název čaje</th>";
                        echo "<th>Objednané množství</th>";
                        echo "<th>Místo na skladě</th>";
                        echo "</tr>";
                        
                        while($row1 = $result1->fetch_assoc()) {
                            
                            echo "<tr class='teaTableRow hideable'>";
                            echo "<td class='blue'></td>";  
                            echo "<td>".$row1['pk']."</td>";
                            echo "<td>".$row1['nazov']."</td>";
                            echo "<td>".$row1['objednaneMnozstvo']."</td>";
                            echo "<td>".$row1['miestoNaSklade']."</td>";
                            echo '</tr>';
                        
                        }
                        
                        $i += $result1->num_rows + 1;
                        $j++;
                    }
                    
                    echo "<input type='hidden' name='count' value=".$j."/>";          
                ?>
                </table>
                <div class="button_center">
                    <input type="submit" name="delete" value="Odstranit" />    
                </div>
            </form> 
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>