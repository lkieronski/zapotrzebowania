<?php
require_once('assets/conf.php');
require_once('assets/classes/kategoria.class.php');
require_once('assets/classes/produkt.class.php');

$k = new Kategoria($conn);
$p = new Produkt($conn);

if (isset($_POST['pd_k']) && isset($_POST['pd_p']) ){
    if ($_POST['pd_k'] === 'pusty'){
        echo 'Wybierz kategorię!';
    }
    else{
        $pd_k = $p->przygotuj_string($_POST['pd_k']);
        $pd_p = $p->przygotuj_string($_POST['pd_p']);
        $p->dodaj($pd_k, $pd_p);
    }
}
else echo 'cos nie tak';

?>