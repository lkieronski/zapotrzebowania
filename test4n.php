<?php

session_start();
require_once('assets/conf.php');
require_once('assets/classes/kategoria.class.php');
require_once('assets/classes/produkt.class.php');
require_once('assets/classes/wydzial.class.php');
require_once('assets/classes/zapotrzebowanie.class.php');
require_once('assets/classes/zapotrzebowanie_nr.class.php');
require_once('assets/classes/zapotrzebowanie_info.class.php');
require_once('users.php');

$_SESSION['username'] = 'Łukasz Kieroński';
$_SESSION['rola'] = 'admin;kierownik'; // admin, kierownik, uzytkownik, realizator
$_SESSION['wydzial'] = 'Biuro do Spraw Informatyzacji';
$_SESSION['uprawnienia'] = 'dodawanie;usuwanie;zatwierdzanie;modyfikacja;drukowanie;potwierdzanie_realizacji';
$_SESSION['wydzial'] ='Biuro do Spraw Informatyzacji';

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
    <?php

        foreach($_POST as $key=>$value){

            $n = explode('_', $key);
            if ($n[0] == 'nazwa'){
                $nazwa[] = $value;
            }
            else if ($n[0] == 'ilosc'){
                $ilosc[] = $value;
            }
        }
        for ($i = 0; $i < count($nazwa); $i++ ){
            echo $nazwa[$i].' - > '.$ilosc[$i].'<br>';
        }

        $znr = new Zapotrzebowanie_nr($conn);
        $zapotrzebowanie_nr = $znr->dodaj();
        $wydzial = $_SESSION['wydzial'];
        $skladajacy = $_SESSION['username'];
        $zinfo = new Zapotrzebowanie_info($conn, null, $zapotrzebowanie_nr, $wydzial, $skladajacy);
        $zinfo->dodaj();
        for ($i = 0; $i < count($nazwa); $i++ ){
            $z[] = new Zapotrzebowanie($conn, null, $zapotrzebowanie_nr, $nazwa[$i], $ilosc[$i]);
        }
        foreach ($z as $zapotrzebowanie){
            $zapotrzebowanie->dodaj();
        }
    ?>
</body>
</html>