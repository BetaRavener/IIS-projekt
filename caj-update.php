<?php
    header("Content-Type: text/html; charset=UTF-8");
    require_once 'db.php';
    
    if(array_key_exists('send_changes', $_POST))
    {   
             
        foreach($_POST as $key => $value)
        {
            if(substr($key, 0, -1) == "checkbox" or $key == "count")
                continue;
        
            if(substr($key, 0, -1) == "datumExpiracie"){
                $value = str_replace("-", ",", $value);
                $_POST[$key] = "str_to_date('".$value."', '%Y,%m,%d')";
            }
        
            if($value == "")
                $_POST[$key] = "null";   
            else{
                if($key == "nazov" or $key == "druh" or $key == "krajinaPovodu" or $key == "kvalita" or $key == "chut" or $key == "zdravotneUcinky")
                    $_POST[$key] = "'".$value."'";          
            }       
        }
        
        $state = true;
        $sql = "UPDATE Caj SET nazov=".$_POST['nazov'].", druh=".$_POST['druh'].", krajinaPovodu=".$_POST['krajinaPovodu'].", kvalita=".$_POST['kvalita'].", chut=".$_POST['chut'].", dobaLuhovania=".$_POST['dobaLuhovania'].", zdravotneUcinky=".$_POST['zdravotneUcinky'].", cajovaoblast_pk=".$_POST['cajovaoblast_pk'].", dodavatel_pk=".$_POST['dodavatel_pk']." WHERE pk=".$_POST['teaId'];      
        if ($db->query($sql) === TRUE) {
            
        } else {
            echo "Error updating record: " . $db->error;
            $state = false;
        }
        
        for ($i = 0; $i < $_POST['count']; $i++) {
            $sql = "UPDATE Varka SET dostupneMnozstvo=".$_POST['dostupneMnozstvo'.$i].", datumExpiracie=".$_POST['datumExpiracie'.$i].", cena=".$_POST['cena'.$i].", zlava=".($_POST['zlava'.$i]/100)." WHERE pk=".$_POST['pk'.$i];
            if ($db->query($sql) === TRUE) {
                
            } else {
                echo "Error updating record: " . $db->error;
                $state = false;
            }
        }
        
        if($state)
            header('Location: ' . $web_home . 'caj-edit.php?id=' . $_POST['teaId']);
            
    }
    else if(array_key_exists('create_caj', $_POST))
    {
        foreach($_POST as $key => $value)
        {
            if($value == "")
                $_POST[$key] = "null";   
            else{
                if($key != "dobaLuhovania" and $key != "dodavatel_pk" and $key != "cajovaoblast_pk")
                    $_POST[$key] = "'".$value."'";          
            }       
        }
        
        $sql = "INSERT INTO Caj (pk, nazov, druh, krajinaPovodu, kvalita, chut, dobaluhovania, zdravotneucinky, cajovaoblast_pk, dodavatel_pk) VALUES (null, ".$_POST['nazov'].", ".$_POST['druh'].", ".$_POST['krajinaPovodu'].", ".$_POST['kvalita'].", ".$_POST['chut'].", ".$_POST['dobaLuhovania'].", ".$_POST['zdravotneUcinky'].", ".$_POST['cajovaoblast_pk'].", ".$_POST['dodavatel_pk'].")";
        if ($db->query($sql) === TRUE) {
            header('Location: ' . $web_home . 'caje-edit.php?id=' . $_POST['teaId']);
        } else {
            echo "Error inserting record: " . $db->error;
        }
        
    } 
    else if(array_key_exists('create_varka', $_POST))
    {
        $_POST['datumExpiracie'] = str_replace("-", ",", $_POST['datumExpiracie']);
        $_POST['datumExpiracie'] = "str_to_date('".$_POST['datumExpiracie']."', '%Y,%m,%d')";
    
        $sql = "INSERT INTO Varka (pk, cena, dostupneMnozstvo, datumExpiracie, zlava, miestoNaSklade, caj_pk) VALUES (null, ".$_POST['cena'].", ".$_POST['dostupneMnozstvo'].", ".$_POST['datumExpiracie'].", ".($_POST['zlava']/100).", ".$_POST['miestoNaSklade'].", ".$_POST['caj_pk'].")";
        if ($db->query($sql) === TRUE) {
            header('Location: ' . $web_home . 'caj-edit.php?id=' . $_POST['caj_pk']);
        } else {
            echo "Error inserting record: " . $db->error;
        }
    }
    else if(array_key_exists('delete_caj', $_POST))
    {
        $err_msg = "Následující čaje nemohly být obebrány z důvodu probíhajícího vyřizování objednávek.\\nČaje:";
        $err = false;
        $cond = "";
        foreach($_POST as $key => $value)
        {
            if(substr($key, 0, -1) == "checkbox")
            {   
                $selectQuery = 'SELECT DISTINCT Caj.nazov FROM (PolozkaObjednavky JOIN Varka ON PolozkaObjednavky.varka_pk = Varka.pk) RIGHT JOIN Caj ON Varka.caj_pk = Caj.pk WHERE Caj.pk = '.$value ;
                $result = $db->query($selectQuery);
                
                if($result and $result->num_rows == 1)
                {    
                    $tea = $result->fetch_assoc();
                    $err_msg .= " ".$tea['nazov'].", ";
                    $err = true;
                } 
                else 
                    $cond .= "pk=" . $value . " OR ";   
            }       
        }
        
        if($err_msg != ""){
            $err_msg = substr($err_msg, 0, -2);
        }
        
        if($cond != ""){
            $cond = substr($cond, 0, -4);
            $sql = "DELETE FROM Caj WHERE ".$cond;
            if ($db->query($sql) === TRUE) {
                if($err)
                    echo "<script>alert(\"$err_msg\"); window.location.href='caje-edit.php';</script>";
                else
                    header('Location: ' . $web_home . 'caje-edit.php');
            } else {
                echo "Error inserting record: " . $db->error;
            }
        }
        else{
            if($err)
                echo "<script>alert(\"$err_msg\"); window.location.href='caje-edit.php';</script>";    
        }  
    }
    else if(array_key_exists('delete_varka', $_POST))
    {
        $err_msg = "Některé várky tohoto čaje nemohly být obebrány z důvodu probíhajícího vyřizování objednávek.";
        $err = false;
        $cond = "";
        foreach($_POST as $key => $value)
        {
            if(substr($key, 0, -1) == "checkbox")
            {
                $selectQuery = 'SELECT DISTINCT Varka.pk FROM PolozkaObjednavky JOIN Varka ON PolozkaObjednavky.varka_pk = Varka.pk WHERE Varka.pk = '.$value ;
                $result = $db->query($selectQuery);
                
                if($result and $result->num_rows == 1)
                { 
                    $err = true;
                } 
                else 
                    $cond .= "pk=" . $value . " OR ";   
            }       
        }
        
        if($cond != ""){
            $cond = substr($cond, 0, -4);
            $sql = "DELETE FROM Varka WHERE ".$cond;
            if ($db->query($sql) === TRUE) {
                if($err)
                    echo "<script>alert(\"$err_msg\"); window.location.href='caj-edit.php?id=".$_POST['teaId']."';</script>";
                else
                    header('Location: ' . $web_home . 'caj-edit.php?id=' . $_POST['teaId']);
            } else {
                echo "Error inserting record: " . $db->error;
            }
        }
        else
            if($err)
                echo "<script>alert(\"$err_msg\"); window.location.href='caj-edit.php?id=".$_POST['teaId']."';</script>";    
    }
    else
    {
        echo 'error';
    }  
?>