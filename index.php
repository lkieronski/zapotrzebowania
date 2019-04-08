<?php
session_start();
require('assets/conf.php');
require('assets/classes/kategoria.class.php');
require('assets/classes/produkt.class.php');
require('assets/classes/wydzial.class.php');
require('assets/classes/zapotrzebowanie.class.php');
require('assets/classes/zapotrzebowanie_nr.class.php');
require('assets/classes/zapotrzebowanie_info.class.php');
require('assets/classes/uzytkownik.class.php');

if (isset($_GET['wyloguj'])){
    session_destroy();
    unset($_COOKIE['logkey']);
    setcookie('logkey','');
    header('Location: login.php');
}


if (!isset($_SESSION['nazwa'])){
    if (isset($_COOKIE['logkey'])){
        $u = new Uzytkownik($conn_auth);
        if ($user = $u->wczytaj_uzytkownika_po_cookie($_COOKIE['logkey'])){
            $_SESSION['id'] = $user->id;
            $_SESSION['nazwa'] = $user->nazwa;
            $_SESSION['email'] = $user->email;
            $_SESSION['imie'] = $user->imie;
            $_SESSION['nazwisko'] = $user->nazwisko;
            $_SESSION['uprawnienia'] = $user->uprawnienia;
            $uprawnienia = explode(';',$user->uprawnienia);
            $_SESSION['rola'] = $uprawnienia[0];
            $_SESSION['wydzial'] = $user->wydzial;
        }
    }
    else {
        header('Location: login.php');
    }
}

//ZABEZPIECZYC MOCNIEJ
if (isset($_POST['rola'])){
    $_SESSION['rola'] = $_POST['rola'];
}

$uprawnienia = explode(';',$_SESSION['uprawnienia']);
$rola = $_SESSION['rola'];


$zinfo = new Zapotrzebowanie_info($conn);
if (isset($_POST['akceptacja_1'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'akceptacja','1');
}

if (isset($_POST['akceptacja_0'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'akceptacja','0');
}

if (isset($_POST['akceptacja_s_1'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'akceptacja_s','1');
}
if (isset($_POST['akceptacja_s_0'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'akceptacja_s','0');
}
if (isset($_POST['przyjety_do_realizacji_0'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'przyjety_do_realizacji','0');
}
if (isset($_POST['przyjety_do_realizacji_1'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'przyjety_do_realizacji','1');
}
if (isset($_POST['zrealizowane_0'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'zrealizowane','0');
}
if (isset($_POST['zrealizowane_1'])){
    $zinfo->ustaw_dane_po_id($_POST['zap_id'],'zrealizowane','1');
}






//-------------------------- dodawanie zapotrzeboawnia jesli jest post zd_submit ---------------------------------
if (isset($_POST['zd_submit'])){
    foreach($_POST as $key=>$value){
        $n = explode('_', $key);
        if ($n[0] == 'nazwa'){
            $nazwa[] = $value;
        }
        else if ($n[0] == 'ilosc'){
            $ilosc[] = $value;
        }
    }

    if (!empty($nazwa)){
        $termin_realizacji = $_POST['termin_realizacji'];
        $pozostale_informacje = $_POST['pozostale_informacje'];
        $szacowany_koszt = $_POST['szacowany_koszt'];
        
        $znr = new Zapotrzebowanie_nr($conn);
        $zapotrzebowanie_nr = $znr->dodaj();
        $wydzial = $_SESSION['wydzial'];
        $skladajacy = $_SESSION['nazwa'];
        $zinfo = new Zapotrzebowanie_info($conn, null, $zapotrzebowanie_nr, $wydzial, $skladajacy, null, $termin_realizacji, $szacowany_koszt, $pozostale_informacje);
        $zinfo->dodaj();
        for ($i = 0; $i < count($nazwa); $i++ ){
            $z[] = new Zapotrzebowanie($conn, null, $zapotrzebowanie_nr, $nazwa[$i], $ilosc[$i]);
        }
        foreach ($z as $zapotrzebowanie){
            $zapotrzebowanie->dodaj();
        }
    }

}

$k = new Kategoria($conn);
$kategorie = $k->zwroc_wszystkie();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ESZ: ZAPOTRZEBOWANIA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="jquery.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <div class="menu_wrapper">
        <div class="menu_wrapper_left">
            <div class="logo"><h2 style="float:left">ESZ: ZAPOTRZEBOWANIA</h2></div>
        </div>
        <div class="menu_wrapper_right">
            <div class="top_menu">
                <div>
                <form id="form_rola" method="post" action="index.php">
                Rola:
                <select name="rola" id="rola">
                <?php
                $key = array_search($rola, $uprawnienia);
                $u_select = $uprawnienia;
                unset($u_select[$key]);
                echo '<option value="'.$rola.'">'.$rola.'</option>';
                foreach($u_select as $u){
                    echo '<option value="'.$u.'">'.$u.'</option>'; 
                }
                ?>
                </select>
                </form>
                </div>
                <div class="tm_login">
                Zalogowany: <?php echo $_SESSION['nazwa'] ?>
                <a href="ustawienia.php"><img style="border: none; cursor:pointer" src="img/kz1.png" alt=""></a>
                <a href="index.php?wyloguj=true"><img style="border: none; cursor:pointer" src="img/lo.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">      
        
        <?php if (($rola === 'admin' || $rola === 'kierownik' || $rola === 'user')){ ?>
        <div class="dodaj_produkt">
            <div id="dodaj_produkt" style="display:none">
                DODAJ PRODUKT: 
                    <select id="pd_k">
                    <option value="pusty">Wybierz kategorie</option>
                    <?php
                    foreach($kategorie as $kategoria){
                        echo '<option value="'.$kategoria->id.'">'.$kategoria->nazwa.'</option>';
                    }
                    ?>
                    <input type="text" name="" id="pd_p" />
                    <input type="button" name="" id="pd_submit" value="dodaj" />
                <div id="dodaj_produkt_ajax"></div>
            </div>
            <div id="dodaj_produkt_b" style="cursor: pointer;">Kliknij żeby dodać nowy produkt.</div>
        </div>
        
        <div class="dodaj_zapotrzebowanie">
            <div id="dodaj_zapotrzebowanie" style="display:none">
                DODAJ ZAPOTRZEBOWANIE: 
                <select id="kategoria">
                <option value="">Wybierz kategorie</option>
                <?php
                        foreach($kategorie as $kategoria){
                            echo '<option value="'.$kategoria->nazwa.'">'.$kategoria->nazwa.'</option>';
                        }
                ?>
                </select>
                <select id="produkt" style="display:none;">
                    <option value="">Najpier wybierz kategorie</option>
                </select>
                <input type="number" id="ile" name="ilosc" value="1" style="display:none;" />
                <input type="button" value="+" id="add" style="display:none;" />
                <div class="wew_zapotrzebowanie" id="wew_zapotrzebowanie" style="display:none">
                    <form id="form_1" action="index.php" method="post">
                        <div id='form1'>
                        </div>
                        <div>
                        <label for="termin_realizacji">Termin realizacji:</label><br />
                        <select class="termin_realizacji" name="termin_realizacji">
                            <option value="7">7 dni</option>
                            <option value="14">14 dni</option>
                            <option value="30">30 dni</option>
                        </select><br />
                        <label for="szacowany_koszt">Szacowany koszt:</label><br />
                        <select class="szacowany_koszt" name="szacowany_koszt">
                            <option value="1">mniej niż 100 Euro</option>
                            <option value="2">więcej niż 100 Euro, mniej niż 1000 Euro</option>
                            <option value="3">więcej niż 1000 Euro, mniej niż 30000 Euro</option>
                        </select><br />
                        <label for="pozostale_informacje">Pozostałe informacje:</label><br />
                        <textarea class="pozostale_informacje" id="pozostale_informacje" name="pozostale_informacje"></textarea><br />
                        <input type="submit" name="zd_submit" value="dodaj zapotrzebowanie" />
                        </div>
                    </form>        
                </div>
            </div>
            <div id="dodaj_zapotrzebowanie_b" style="cursor: pointer;">Kliknij żeby dodać zapotrzebowanie.</div>
        </div>
        <?php } ?>

<?php
    if ($rola === 'admin' || $rola === 'realizator'){
    ?>
        <div class="filtruj">
            <div id="filtruj_zapytanie" style="display:none">
                DODAJ PRODUKT: 
                    <select id="pd_k">
                    <option value="pusty">Wybierz kategorie</option>
                    <?php
                    foreach($kategorie as $kategoria){
                        echo '<option value="'.$kategoria->id.'">'.$kategoria->nazwa.'</option>';
                    }
                    ?>
                    <input type="text" name="" id="pd_p" />
                    <input type="button" name="" id="pd_submit" value="dodaj" />
                <div id="dodaj_produkt_ajax"></div>
            </div>
            <div id="filtruj_zapytanie_b" style="cursor: pointer;">Kliknij żeby dodać filtr.</div>
        </div>
    <?php
    }
    ?>    



        <div>
<?php

$numery = array();
if ($rola === 'user'){
    $numery = $zinfo->zwroc_wszystkie_zapotrzebowanie_nr_uzytkownika($_SESSION['nazwa']);  //instrukcja warunkowa w zależności od poziomu
}

if ($rola === 'kierownik_komorki'){
    $numery = $zinfo->zwroc_wszystkie_zapotrzebowanie_nr_wydzialu($_SESSION['wydzial']);
}

if ($rola === 'realizator' || $rola === 'admin' || $rola === 'kierownik_jednostki'){
    $numery = $zinfo->zwroc_wszystkie_zapotrzebowanie_nr();
}

$z = new Zapotrzebowanie($conn);
if (!empty($numery)){
    foreach ($numery as $numer){
        $zapotrzebowania[] = $z->zwroc_wszystkie_po_zapotrzebowanie_nr($numer);
    }
    $ilosc = count($zapotrzebowania);
    for ($i=0 ; $i<$ilosc; $i++){
        $zi = $zinfo->zwroc_zapotrzebowanie_info_po_numer($zapotrzebowania[$i][0]->zapotrzebowanie_nr);
        echo '<div class="zapotrzebowania_wrapper"><form id="'.$zi->id.'" method="post" action="index.php#'.$zi->id.'">';
        echo '<div class="zapotrzebowania_info">';
        
        // AKCEPTACJA KIEROWNIKA
        if ($zi->zrealizowane === "0"){
            if ($zi->akceptacja === '0'){
                echo '<span style="border-color:#c0392b">Czeka na akceptację kierownika komórki</span>';
            }
            else{
                echo '<span style="border-color:#2ecc71">Zaakceptowane przez kierownika komórki</span>';
                // AKCEPTACJA STAROSTY
                if($zi->akceptacja_s === '0'){
                    echo '<span style="border-color:#c0392b">Czeka na akceptację Starosty</span>';
                }
                else{
                    echo '<span style="border-color:#2ecc71">Zaakceptowane przez Starostę</span>';
                    // PEZYJETY DO REALIZACJI
                    if($zi->przyjety_do_realizacji === '0'){
                        echo '<span style="border-color:#c0392b">Czeka na przyjęcie do realizacji</span>';
                    }
                    else{
                        echo '<span style="border-color:#2ecc71">Przyjęty do realizacji</span>';
                        echo '<span style="border-color:#c0392b">Czeka na realizację</span>';

                    }
                }
            }
        }
        else {
            echo '<span style="border-color:#2ecc71">Zrealizowane</span>';
        }
        
        
        $szacowana_kwota = 'Kwota: ';
        switch($zi->szacowany_koszt){
            case 1:
                $szacowana_kwota .= 'mniej niż 100 Euro';
            break;

            case 2:
                $szacowana_kwota .= 'więcej niż 100 Euro, mniej niż 1000 Euro';
            break;

            case 3:
                $szacowana_kwota .= 'więcej niż 1000 Euro, mniej niż 30000 Euro';
            break;

            default:
            break;
        }
        
        echo '<br /><span>NR: '.$zi->zapotrzebowanie_nr.'</span><span>Data dodania: '.$zi->data_dodania.'</span><span>Ternim realizacji: '.$zi->termin_realizacji.'</span><span>'.$szacowana_kwota.'</span><br />';
        echo '<span style="border:2px solid #95a5a6">'.$zi->wydzial.'</span><span style="border:2px solid #95a5a6">'.$zi->skladajacy.'</span></div>';
        echo '<div class="zapotrzebowania_wrapper_inner">';
        foreach($zapotrzebowania[$i] as $zapotrzebowanie){
            echo '<div class="ilosc">szt. '.$zapotrzebowanie->ilosc.'</div><div class="produkt">'.$zapotrzebowanie->produkt.'</div><div class="clear"></div>';
        }
        echo '</div>';
        echo '<div class="zapotrzebowania_wrapper_inner_dod_inf">';
            echo 'Pozostałe Informacje:<br/>'.nl2br($zi->pozostale_informacje);
        echo '</div>';

        $zapotrzebowanie_menu = '<div class="zapotrzebowania_btn">';
        $zapotrzebowanie_menu .= '<input type="hidden" name="zap_id" value="'.$zi->id.'">';
        if ($zi->zrealizowane === '0'){
            if ($zi->przyjety_do_realizacji === '0'){
                if ($zi->akceptacja_s === '0'){
                    if ($zi->akceptacja === '0'){
                        if ($rola === 'kierownik_komorki' || $rola === 'admin'){
                            $zapotrzebowanie_menu .= '<input type="submit" name="usun_zapotrzebowanie" value="Usuń" style="border-color:#c0392b">';
                            $zapotrzebowanie_menu .= '<input type="submit" name="akceptacja_1" value="Zaakceptuj" style="border-color:#1abc9c">';
                        }
                    }
                    else{
                        if ($rola === 'kierownik_komorki' || $rola === 'admin'){
                            $zapotrzebowanie_menu .= '<a href="drukuj.php?id='.$zi->id.'" target="_blank">Drukuj</a>';
                            $zapotrzebowanie_menu .= '<input type="submit" name="akceptacja_0" value="Cofnij akceptację" style="border-color:#c0392b">';
                        }
                        if($rola === 'kierownik_jednostki' || $rola === 'admin'){
                            $zapotrzebowanie_menu .= '<input type="submit" name="akceptacja_s_1" value="Zaakceptuj" style="border-color:#1abc9c">';
                        }
                    }
                }
                else{
                    if ($rola === 'kierownik_jednostki' || $rola === 'admin'){
                        $zapotrzebowanie_menu .= '<input type="submit" name="akceptacja_s_0" value="Cofnij akceptację" style="border-color:#c0392b">';
                    }
                    if ($rola === 'realizator' || $rola === 'admin'){
                        $zapotrzebowanie_menu .= '<input type="submit" name="przyjety_do_realizacji_1" value="Przyjmij do realizacji" style="border-color:#1abc9c">';
                    }
                }
            }
            else{
                if ($rola === 'realizator' || $rola === 'admin'){
                    $zapotrzebowanie_menu .= '<input type="submit" name="przyjety_do_realizacji_0" value="Cofnij przyjęcie do realizacji" style="border-color:#c0392b">';
                    $zapotrzebowanie_menu .= '<input type="submit" name="zrealizowane_1" value="Oznacz jako zrealizowane" style="border-color:#1abc9c">';
                }
            }
        }
        else{
            if ($rola === 'realizator' || $rola === 'admin'){
                $zapotrzebowanie_menu .= '<input type="submit" name="zrealizowane_0" value="Cofnij oznaczenie jako zrealizowane" style="border-color:#c0392b">';
            }
        }

        $zapotrzebowanie_menu .= '</form></div><div class="clear"></div>';
        echo $zapotrzebowanie_menu;
        echo '</div>';
        } 
    }
?>
        </div>
    </div>
</body>
</html>