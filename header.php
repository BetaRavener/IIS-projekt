<div id="header">
    <?php
    if (!isset($mainInit))
        exit(1);
        
    require_once 'loginDetection.php';

    if ($userLogedIn) { ?>
    
    <script>
        function index()
        {
            document.location.href= '<?php echo $web_home . 'index.php' ?>';
        }
    </script>
    
    <table class="login">
        <form name="login" method="POST" action="logout.php">
            <?php if($username != "admin"){ ?>
            <tr>   
                <td class="label">Přihlášen jako:</td>
            </tr>
            <tr>
                <td class="name"><?php echo $nameSurname . ' (' . $username . ')' ?></td>
            </tr>
            <?php } else { ?>
            <tr>   
                <td class="name">Vítejte v administračním systému</td>
            </tr>
            <br />
            <?php } ?>
            <tr>
                <td class="button"><input type="submit" name="login" value="Odhlásit" style="font-size:1em; font-family: Impact, Charcoal, sans-serif" /></td>
            </tr>
        </form>
    </table>
    <?php } else {?>
        <table class="login">
            <form name="login" method="POST" action="login.php">
                <tr>   
                    <td class="label">Jméno</td>
                    <td class="label">:</td>
                    <td><input type="text" name="username" value="" 
                    <?php
                        if (array_key_exists('wrong_nick_or_psw', $_SESSION))
                        {
                            if ($_SESSION["wrong_nick_or_psw"])
                            { 
                                echo 'placeholder="Jméno"'; 
                            }
                        }                        
                    ?>
                    />
                    </td>
                </tr>
                <tr>
                    <td class="label">Heslo</td>
                    <td class="label">:</td>
                    <td><input type="password" name="password" value="" 
                    <?php
                        if (array_key_exists('wrong_nick_or_psw', $_SESSION))
                        {
                            if ($_SESSION["wrong_nick_or_psw"])
                            { 
                                echo 'placeholder="Heslo"'; 
                            }
                        }                        
                    ?>
                    />
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="button">
                        <input type="submit" name="login" value="Přihlásit" style="font-size:1em; font-family: Impact, Charcoal, sans-serif" />
                        <input type="button" onClick="<?php echo 'javascript:location.href = \'' . $web_home . 'registration.php\'' ?>" value="Registrace" style="font-size:1em; font-family: Impact, Charcoal, sans-serif" />
                    </td>
                </tr>
            </form>
        </table>
    <?php } ?> 
    <h1><a href="index.php">Prodejna čajů Tomáš a Ivan</a></h1> 
</div>