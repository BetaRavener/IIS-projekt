<div id="menu">
  <table>
    <tr>   
        <td>O nás</td>
        <td><a href="caje.php">Čaje</a></td>
        <td>Kontakty</td>
    </tr>
<?php if (isset($_COOKIE['logged'])) { ?>
    <tr>   
        <td>Objednávky</td>
        <td>Košík</td>
        <td>Účet</td>
    </tr>
<?php } ?>
  </table>
</div>

