<?php
require_once('assets/conf.php');
require_once('assets/classes/kategoria.class.php');
require_once('assets/classes/produkt.class.php');



//if(!empty($_POST["nazwaKategori"])){
    $p = new Produkt($conn);
    $produkty = $p->zwroc_wszystkie_z_kategori($_POST['nazwaKategori']);
    foreach ($produkty as $produkt){
        echo '<option value="'.$produkt->nazwa.'">'.$produkt->nazwa.'</option>';
    }
//}
?>