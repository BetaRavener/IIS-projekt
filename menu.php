<?php 
if (!isset($mainInit))
    exit(1);
?>

<div id="menu">
  <table>
    <tr>   
        <td>O nás</td>
        <td><a href="caje.php">Čaje</a></td>
        <td>Kontakty</td>
    </tr>

<?php if ($userLogedIn) { 

    if ($username != "admin") {
        echo "<tr>";   
        echo "<td><a href='orders.php'>Objednávky</a></td>";
        echo "<td><a href='cart.php'>Košík</a></td>";
        echo "<td><a href='user-edit.php'>Účet</a></td>";
        echo "</tr>";
    }
    else { 
        echo "<tr>";   
        echo "<td><a href='caje-edit.php'>Editovat čaje</a></td>";
        echo "<td><a href='objednavka-edit.php'>Editovat objednávky</a></td>";
        echo "<td>Editovat účty</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><a href='customers.php'>Odběratelé</a></td>";
        echo "<td><a href='mail.php'>Zaslat novinku</a></td>";
        echo "<td></td>";
        echo "</tr>";
    }
} ?>

  </table>
</div>

