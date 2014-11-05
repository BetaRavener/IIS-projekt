<div id="menu">
  <table>
    <tr>   
        <td>O nás</td>
        <td><a href="caje.php">Čaje</a></td>
        <td>Kontakty</td>
    </tr>
<?php if (isset($_COOKIE['logged'])) { ?>
    <tr>   
        <td><a href='orders.php'>Objednávky</a></td>
        <td><a href='cart.php'>Košík</a></td>
        <td>Účet</td>
    </tr>
<?php } ?>
  </table>
</div>

