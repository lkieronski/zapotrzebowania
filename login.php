<?php
session_start();
require('assets/conf.php');
require('assets/classes/uzytkownik.class.php');
if (isset($_POST['zaloguj'])){
    $u = new Uzytkownik($conn_auth);
    @$login = $_POST['login'];
    @$haslo = $_POST['haslo'];
    @$zapamietaj = $_POST['zapamietaj'];
    
    if ($user = $u->uwierzytelnij_uzytkownika($login, $haslo, $zapamietaj)){
        $_SESSION['id'] = $user->id;
        $_SESSION['nazwa'] = $user->nazwa;
        $_SESSION['email'] = $user->email;
        $_SESSION['imie'] = $user->imie;
        $_SESSION['nazwisko'] = $user->nazwisko;
        $_SESSION['uprawnienia'] = $user->uprawnienia;
        $uprawnienia = explode(';',$user->uprawnienia);
        $_SESSION['rola'] = $uprawnienia[0];
        $_SESSION['wydzial'] = $user->wydzial;
        header('Location: index.php');
    }
    else {
        echo "Błędne HASŁO";
    }


}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="wrapper_login_top">
        </div>
        <div class="wrapper_login_mid">
            <form method="post" action="login.php">
                <div class="wrapper_login_mid_title">Proszę się zalogować</div>
                <div style="width:40%; float:left; text-align:right; padding: 8px 0px 0px 0px"><label for="login">E-mail:</label></div>
                <div style="width:60%; float:left;"><input name="login" type="text" /></div>
                <div style="width:40%; float:left; text-align:right; padding: 8px 0px 0px 0px"><label for="haslo">Hasło:</label></div>
                <div style="width:60%; float:left;"><input name="haslo" type="password" /></div>
                <div style="width:100%; float:left; text-align:center;"><label for="zapamietaj">Zapamietaj mnie:</label><input name="zapamietaj" type="checkbox" value="1" checked /></div>
                <div style="width:100%; float:left; text-align:center;"><input type="submit" name="zaloguj" value="Zaloguj" /></div>
            </form>
        </div>
    </div>
</body>
</html>