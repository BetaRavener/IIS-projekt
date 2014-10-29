<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Distributor čajů</title>
  <link rel="stylesheet" href="style.css" type="text/css" >
  </head>
  
  <body>
  
    <?php
    /*
          header("Content-Type: text/html; charset=UTF-8");
         
          $db = mysql_connect('localhost:/var/run/mysql/mysql.sock', 'xcizek12', 'gunapu9a');
          if (!$db) die('nelze se pripojit '.mysql_error());
          if (!mysql_select_db('xcizek12', $db)) die('database neni dostupna '.mysql_error());
    */      
    ?>
    
    <div id="main">
      <div id="header">
        <table class="login">
          <tr>   
            <td colspan="2" class="label">Přihlášen jako:</td>
          </tr>
          <tr>
            <td colspan="2" class="name">"UzivatelskeJmeno"</td>
          </tr>
          <tr>
            <td colspan="2" class="button"><input type="submit" name="login" value="Odhlásit" style="font-size:1em; font-family: fantasy" /></td>
          </tr>
        </table>
        <h1>Prodejna čajů Tomáš a Ivan</h1> 
      </div>
      <div id="menu">
        <ul>
        	<a href="caje.php"><li>Čaje</li></a>
        	<a href=""><li>Objednavky</li></a>
        	<a href=""><li>Košík</li></a>
          <a href=""><li>Účet</li></a>
        </ul>
      </div>
      <div id="content">
        <h2>Čaje</h2>
      </div>
      <div id="footer">
        
      </div>
    </div>
    
  
  </body>
</html>
