<?php
    header("Content-Type: text/html; charset=UTF-8");
    include_once 'db.php';
    
    if(array_key_exists('send_changes', $_POST))
    {
        $state = true;
    
        for ($i = 0; $i < $_POST['count']; $i++) {
            if(array_key_exists('checkbox'.$i, $_POST))
            {
                if($_POST['stav'.$i] == 'prijata')
                    $sql = "UPDATE Objednavka SET stav='vybavena' WHERE pk=".$_POST['checkbox'.$i];
                else if($_POST['stav'.$i] == 'stornovana')
                    $sql = "UPDATE Objednavka SET stav='zrusena' WHERE pk=".$_POST['checkbox'.$i];
                else{}
                
                if ($db->query($sql) === TRUE) {
                        
                } else {
                    echo "Error updating record: " . $db->error;
                    $state = false;
                }    
            }
        }
        if($state)
             header('Location: ' . $web_home . 'objednavka-edit.php');    
    }
    else if(array_key_exists('delete', $_POST))
    {
        $state = true;
    
        for ($i = 0; $i < $_POST['count']; $i++) {
            if(array_key_exists('checkbox'.$i, $_POST))
            {
                $sql = "DELETE FROM Objednavka WHERE pk=".$_POST['checkbox'.$i];
                
                if ($db->query($sql) === TRUE) {
                        
                } else {
                    echo "Error updating record: " . $db->error;
                    $state = false;
                }
            } 
        }
        if($state)
             header('Location: ' . $web_home . 'objednavka-edit.php');
    }
    else
    {}
?>