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
            //TODO: Exists?
            if (array_key_exists('select', $_POST) and array_key_exists('content', $_POST))
            {
                $mode = $_POST['select'];
                $content = $_POST['content'];
            }
            else
            $recipients = "";
            if ($mode == 0)
            {
                //TODO: check error
                $result = $db->query('SELECT odb.email FROM Odberatel AS odb WHERE odb.odberNoviniek=1');
                while($row = $result->fetch_assoc()) {
                    $email = $row['email'];
                    if (!empty($email))
                    {
                        $pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
                        if (preg_match($pattern, $email))
                            $recipients .= (empty($recipients) ? '' : ', ') . $email;
                    }
                }
            }
            else
            {
                $recipients = $_POST['email'];
            }
            
            if (!empty($recipients))
            {
                $success = mail($recipients, 'Sprava od cajovne', $content);
                
                if ($success)
                {
                    echo 'Úspěšně zasláno na: ' . $recipients;
                }
                else
                {
                    echo 'Správu se nepodařilo odeslat';
                }
            }
            else
            {
                echo 'Žádný adresát';
            }
            ?>
                        
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>