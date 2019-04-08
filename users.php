<?php

require('assets/conf.php');
require('assets/classes/uzytkownik.class.php');

//$u = new Uzytkownik($conn_auth, null, 'Łukasz Kieroński','l.kieronski@lipnowski.powiat.pl','haslo','Łukasz','Kieroński','Biuro do Spraw Informatyzacji','admin;user;kierownik_komorki;realizator;kierownik_jednostki');
//$u->zapisz_nowego_uzytkownika_do_bazy();

$u = new Uzytkownik($conn_auth);
if (isset($_COOKIE['logkey'])){
    if ($u->uwierzytelnij_uzytkownika_po_cookie($_COOKIE['logkey'])){
        
    }
}
else {
    $email = 'l.kieronski@lipnowski.powiat.pl';
    $haslo = 'haslo';
    $zapamietaj = 1;
    $u->uwierzytelnij_uzytkownika($email, $haslo, $zapamietaj);
}
?>