<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Distributor čajů</title>
  <link rel="stylesheet" href="style.css" type="text/css" >
  </head>
  
  <body>
  
    <?php
         header("Content-Type: text/html; charset=UTF-8");
    ?>
    
    <div id="main">
      <div id="header">
        <table class="login">
          <tr>   
            <td class="label">User Name : </td>
            <td><input type="text" name="username" value="" /></td>
          </tr>
          <tr>
            <td class="label">Password   : </td>
            <td><input type="password" name="password" value="" /></td>
          </tr>
          <tr>
            <td colspan="2" class="button"><input type="submit" name="login" value="Přihlásit" style="font-size:1em; font-family: fantasy" /></td>
          </tr>
        </table>
        <h1>Prodejna čajů Tomáš a Ivan</h1> 
      </div>
      <div id="menu">
        <ul>
        	<li>Čaje</li>
        	<li>...</li>
        	<li>...</li>
          <li>...</li>
        </ul>
      </div>
      <div id="content">
        <h2>Novinky</h2>
      </div>
      <div id="footer">
        
      </div>
    </div>
    
  
  </body>
</html>
