<?php 
if (!isset($mainInit))
    exit(1);
?>

<div id="menu">
    <table>
        <tr>   
            <td><a href="caje.php">Čaje</a></td>
            <td><a href="contacts.php">Kontakty</a></td>
        </tr>
    </table>
    
<?php if ($userLogedIn) { 
    echo '<table>';
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
        echo "</tr>";
        echo "<tr>";
        echo "<td><a href='customers.php'>Odběratelé</a></td>";
        echo "<td><a href='mail.php'>Zaslat novinku</a></td>";
        echo "</tr>";
    }
    echo '</table>';
} ?>
</div>

