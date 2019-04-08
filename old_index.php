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

$uprawnienia = explode(';',$_SESSION['uprawnienia']);
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
    <div class="user_info"><p>Zalogowany: <?php echo $_SESSION['username'] ?></p></div>
    <div class="header"><h1>SYSTEM ZAPOTRZEBOWAŃ</h1></div>
<?php




$zinfo = new Zapotrzebowanie_info($conn);
$numery = $zinfo->zwroc_wszystkie_zapotrzebowanie_nr_uzytkownika($_SESSION['username']);
$z = new Zapotrzebowanie($conn);
foreach ($numery as $numer){
    $zapotrzebowania[] = $z->zwroc_wszystkie_po_zapotrzebowanie_nr($numer);
}
$ilosc = count($zapotrzebowania);
for ($i=0 ; $i<$ilosc; $i++){
    echo '<div class="zam">';
    echo '<h5>Zapotrzebowanie: '.$zapotrzebowania[$i][0]->zapotrzebowanie_nr.'</h5><hr>';
    foreach($zapotrzebowania[$i] as $zapotrzebowanie){
        echo '<div class="ilosc">szt. '.$zapotrzebowanie->ilosc.'</div><div class="produkt">'.$zapotrzebowanie->produkt.'</div><div class="clear"></div>';
    }

    $zapotrzebowanie_menu = '<div class="btnd">';
    if (in_array('drukowanie', $uprawnienia)){
        $zapotrzebowanie_menu .= '<a href="#"><span class="btns">Drukuj</span></a>';
    }
    if (in_array('potwierdzanie_realizacji', $uprawnienia)){
        $zapotrzebowanie_menu .= '<a href="#"><span class="btns">Oznacz jako zrealizowane</span></a>';
    }

    if (in_array('usuwanie', $uprawnienia)){
        $zapotrzebowanie_menu .= '<a href="#"><span class="btns">Usuń</span></a>';
    }
    $zapotrzebowanie_menu .= '</div><div class="clear"></div>';
    echo $zapotrzebowanie_menu;
    echo '</div>';
} 













// $p = new Produkt($conn);
// $produkty = $p->dodaj(10, 'Wichajster');


// $k = new Kategoria($conn);
// $kategorie = $k->dodaj('Elektronika');
// $kategorie = $k->dodaj('AGD');
// $kategorie = $k->dodaj('Pozostałe');


// foreach($kategorie as $kategoria){
//     echo $kategoria->zwroc_kategoria_info().'<br />';
// }


//$w = new Wydzial($conn);
//$w->modyfikuj_nazwa(2,'Biuro Prawne');
//$w->modyfikuj_kierownik(2, 'Tytys Spryszyński');
//$w->dodaj('Wydział Geodezji, Kartografii, Katastru i Gospodarki Nieruchomościami', 'Henryka Segień');
//$w->dodaj('Wydział Architektury i Budownictwa', 'Dariusz Kapuściński');
//$w->dodaj('Wydział Środowiska, Rolnictwa i Leśnictwa', 'Eliza Jałowiecka-Rudewicz');


// $wydzialy = $w->zwroc_wszystkie();
// foreach ($wydzialy as $wydzial){
//     echo $wydzial->zwroc_wydzial_info().'<br />';
// }


// $znr = new Zapotrzebowanie_nr($conn);
// $zapotrzebowanie_nr = $znr->dodaj();

// $w = new Wydzial($conn);
// $wydzial = $w->zwroc_nazwe(1);
// $skladajacy = 'Łukasz Kieroński';

// $zinfo = new Zapotrzebowanie_info($conn, null, $zapotrzebowanie_nr, $wydzial, $skladajacy);
// $zinfo->dodaj();


// $p = new Produkt($conn);

// $produkt1 = $p->zwroc_nazwe(4);
// $ilosc1 = 5;

// $produkt2 = $p->zwroc_nazwe(5);
// $ilosc2 = 1;

// $produkt3 = $p->zwroc_nazwe(6);
// $ilosc3 = 1;

// $z[] = new Zapotrzebowanie($conn, null, $zapotrzebowanie_nr, $produkt1, $ilosc1);
// $z[] = new Zapotrzebowanie($conn, null, $zapotrzebowanie_nr, $produkt2, $ilosc2);
// $z[] = new Zapotrzebowanie($conn, null, $zapotrzebowanie_nr, $produkt3, $ilosc3);

// foreach ($z as $zapotrzebowanie){
//     $zapotrzebowanie->dodaj();
// }



// $data_dodania = date('Y-m-d H:i:s'); 
// $conn->query("INSERT INTO zapotrzebowanie_info (data_dodania) VALUES ('$data_dodania')");









?>



</body>
</html>