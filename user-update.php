<?php
    header("Content-Type: text/html; charset=UTF-8");
    include_once 'db.php';
    
    if(array_key_exists('create_user', $_POST))
    {
        foreach($_POST as $key => $value)
        {
            if($value == "")
                $_POST[$key] = "null";   
            else{
                if($key != "telefonneCislo" and $key != "odberNoviniek")
                    $_POST[$key] = "'".$value."'";          
            }       
        }
        
        if (array_key_exists('odberNovinek', $_POST))
             $odberNovinek = 1;
        else
             $odberNovinek = 0;
         
    
        $sql = "INSERT INTO Odberatel VALUES (null, ".$_POST['meno'].", ".$_POST['priezvisko'].", ".$_POST['adresaBydliska'].", ".$_POST['dodaciaAdresa'].", ".$_POST['email'].", ".$_POST['telefonneCislo'].", ".$odberNovinek.")";
        if ($db->query($sql) === TRUE) {
    
        } 
        else {
            echo "Error inserting record: " . $db->error;
        }
        
        $sql = "INSERT INTO Uzivatel VALUES (null, ".$_POST['u_meno'].", ".$_POST['heslo'].", null, ".mysqli_insert_id($db).")";
        if ($db->query($sql) === TRUE) {
            echo "<script>alert('účet vytvořen'); window.location.href='index.php';</script>";       
        } 
        else {
            echo "Error inserting record: " . $db->error;
        }
    }
    else if(array_key_exists('send_changes', $_POST))
    {
        foreach($_POST as $key => $value)
        {
            if($value == "")
                $_POST[$key] = "null";   
            else{
                if($key != "telefonneCislo" and $key != "odberNoviniek" and $key != "odberatel_pk" and $key != "pk")
                    $_POST[$key] = "'".$value."'";          
            }       
        }
        
        if (array_key_exists('odberNovinek', $_POST))
             $odberNovinek = 1;
        else
             $odberNovinek = 0;
        
        $sql = "UPDATE Odberatel SET meno=".$_POST['meno'].", priezvisko=".$_POST['priezvisko'].", adresaBydliska=".$_POST['adresaBydliska'].", dodaciaAdresa=".$_POST['dodaciaAdresa'].", email=".$_POST['email'].", telefonneCislo=".$_POST['telefonneCislo'].", odberNoviniek=".$odberNovinek." WHERE pk=".$_POST['odberatel_pk'];
        if ($db->query($sql) === TRUE) {
            if($_POST['heslo'] != "null"){
                $sql = "UPDATE Uzivatel SET heslo=".$_POST['heslo']." WHERE pk=".$_POST['pk'];
                if ($db->query($sql) === TRUE) {
                    echo "<script>alert('změny provedeny'); window.location.href='user-edit.php';</script>";
                }
                else {
                    echo "Error inserting record: " . $db->error;
                }    
            }
            else
                header('Location: ' . $web_home . 'user-edit.php');
        } 
        else {
            echo "Error inserting record: " . $db->error;
        }
        
        
    }
    else if(array_key_exists('delete_account', $_POST))
    {
        $sql = "DELETE FROM Uzivatel WHERE pk=".$_POST['pk'];
        if ($db->query($sql) === TRUE){
            header('Location: ' . $web_home . 'logout.php');
        } else {
            echo "Error inserting record: " . $db->error;
        }
    }
    else
    {}


/*
    objednavky:
    tabulka 1: objednavka.stav = "prijata"
    tabulka 2: objednavka.stav != "priajata" and objednavka.kosik = false
*/

?>

