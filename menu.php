<div id="menu">
  <table>
    <tr>   
        <td>O nás</td>
        <td><a href="caje.php">Čaje</a></td>
        <td>Kontakty</td>
    </tr>
<?php if ($logged) { ?>
    <tr>   
        <td>Objednávky</td>
        <td><a href='cart.php'>Košík</a></td>
        <td>Účet</td>
    </tr>
<?php } ?>
  </table>
</div>

