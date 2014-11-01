<div id="header">
    <?php if (isset($_COOKIE['logged'])) { ?>
    <table class="login">
        <form name="f1" method="POST" action="logout.php" id="f1">
            <tr>   
                <td class="label">Přihlášen jako:</td>
            </tr>
            <tr>
                <td class="name"><?php echo $_COOKIE['logged'] ?></td>
            </tr>
            <tr>
                <td class="button"><input type="submit" name="login" value="Odhlásit" style="font-size:1em; font-family: fantasy" /></td>
        </form>
    </table>
    <?php } else {?>
        <table class="login">
            <form name="f1" method="POST" action="login.php" id="f1">
                <tr>   
                    <td class="label">Jméno</td>
                    <td class="label">:</td>
                    <td><input type="text" name="username" value="" <?php if ($_SESSION["wrong_nick_or_psw"]) { ?> placeholder="Jméno" <?php } ?> /></td>
                </tr>
                <tr>
                    <td class="label">Heslo</td>
                    <td class="label">:</td>
                    <td><input type="password" name="password" value="" <?php if ($_SESSION["wrong_nick_or_psw"]) { ?> placeholder="Heslo" <?php } ?> /></td>
                </tr>
                <tr>
                    <td colspan="3" class="button"><input type="submit" name="login" value="Přihlásit" style="font-size:1em; font-family: fantasy" /></td>
                </tr>
            </form>
        </table>
    <?php } ?> 
    <h1>Prodejna čajů Tomáš a Ivan</h1> 
</div>