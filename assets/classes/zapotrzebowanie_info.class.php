<?php

class Zapotrzebowanie_info
{
    public $conn;
    public $id;
    public $zapotrzebowanie_nr;
    public $wydzial;
    public $skladajacy;
    public $data_dodania;
    public $termin_realizacji;
    public $pozostale_informacje;
    public $szacowany_koszt;
    public $akceptacja;
    public $akceptacja_s;
    public $przyjety_do_realizacji;
    public $zrealizowane;

    function __construct($conn, $id = null, $zapotrzebowanie_nr = null, $wydzial = null, $skladajacy = null, $data_dodania = null, $termin_realizacji = null, $szacowany_koszt = null, $pozostale_informacje = null,  $akceptacja = 0, $akceptacja_s = 0, $przyjety_do_realizacji = 0, $zrealizowane = 0){
        $this->conn = $conn;
        $this->id = $id;
        $this->zapotrzebowanie_nr = $zapotrzebowanie_nr;
        $this->wydzial = $wydzial;
        $this->skladajacy = $skladajacy;
        $this->data_dodania = $data_dodania;
        $this->termin_realizacji = $termin_realizacji;
        $this->szacowany_koszt = $szacowany_koszt;
        $this->pozostale_informacje = $pozostale_informacje;
        $this->akceptacja = $akceptacja;
        $this->akceptacja_s = $akceptacja_s;
        $this->przyjety_do_realizacji = $przyjety_do_realizacji;
        $this->zrealizowane = $zrealizowane;
    }

    public function dodaj(){
        $this->ustawDate();
        $this->ustawTerminRealizacji();
        if (isset($this->zapotrzebowanie_nr) && isset($this->wydzial) && isset($this->skladajacy) && isset($this->data_dodania) && isset($this->termin_realizacji) && isset($this->pozostale_informacje) && isset($this->szacowany_koszt)){
            $zapytanie = mysqli_query($this->conn, "INSERT INTO zapotrzebowanie_info (zapotrzebowanie_nr, wydzial, skladajacy, data_dodania, termin_realizacji, szacowany_koszt, pozostale_informacje, akceptacja, zrealizowane) VALUES ('$this->zapotrzebowanie_nr','$this->wydzial','$this->skladajacy','$this->data_dodania','$this->termin_realizacji','$this->szacowany_koszt','$this->pozostale_informacje','$this->akceptacja','$this->zrealizowane')");
        }
    }

    public function zwroc_wszystkie_zapotrzebowanie_nr_uzytkownika($uzytkownik){
        $numery = array();
        if($zapytanie = mysqli_query($this->conn, "SELECT zapotrzebowanie_nr FROM zapotrzebowanie_info WHERE skladajacy='$uzytkownik' ORDER BY `id` DESC")){
            while ($numer = $zapytanie->fetch_array()){
                $numery[] = $numer['zapotrzebowanie_nr'];
            }
            return $numery;
        }
    }

    public function zwroc_wszystkie_zapotrzebowanie_nr_wydzialu($wydzial){
        $numery = array();
        if($zapytanie = mysqli_query($this->conn, "SELECT zapotrzebowanie_nr FROM zapotrzebowanie_info WHERE wydzial='$wydzial' ORDER BY `id` DESC")){
            while ($numer = $zapytanie->fetch_array()){
                $numery[] = $numer['zapotrzebowanie_nr'];
            }
            return $numery;
        }
    }

    public function zwroc_wszystkie_zapotrzebowanie_nr(){
        $numery = array();
        if($zapytanie = mysqli_query($this->conn, "SELECT zapotrzebowanie_nr FROM zapotrzebowanie_info ORDER BY `id` DESC")){
            while ($numer = $zapytanie->fetch_array()){
                $numery[] = $numer['zapotrzebowanie_nr'];
            }
            return $numery;
        }
    }

    public function ustawDate(){
        $date = date('Y-m-d H:i:s');
        $this->data_dodania = $date;
    }
    public function ustawTerminRealizacji(){
        $t = new DateTime($this->data_dodania);
        $t->add(new DateInterval('P'.$this->termin_realizacji.'D'));
        $this->termin_realizacji = $t->format('Y-m-d');
    }

    public function zwroc_zapotrzebowanie_info_po_numer($zapotrzebowanie_nr){
        if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM zapotrzebowanie_info WHERE zapotrzebowanie_nr='$zapotrzebowanie_nr'")){
            if ($zinfo =  $zapytanie->fetch_array()){
                return new Zapotrzebowanie_info(null, $zinfo['id'], $zinfo['zapotrzebowanie_nr'], $zinfo['wydzial'], $zinfo['skladajacy'], $zinfo['data_dodania'], $zinfo['termin_realizacji'], $zinfo['szacowany_koszt'], $zinfo['pozostale_informacje'], $zinfo['akceptacja'], $zinfo['akceptacja_s'], $zinfo['przyjety_do_realizacji'], $zinfo['zrealizowane']);
            }
        }
    }

    public function zwroc_zapotrzebowanie_info_po_id($id){
        if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM zapotrzebowanie_info WHERE id='$id'")){
            if ($zinfo =  $zapytanie->fetch_array()){
                return new Zapotrzebowanie_info(null, $zinfo['id'], $zinfo['zapotrzebowanie_nr'], $zinfo['wydzial'], $zinfo['skladajacy'], $zinfo['data_dodania'], $zinfo['termin_realizacji'], $zinfo['szacowany_koszt'], $zinfo['pozostale_informacje'], $zinfo['akceptacja'], $zinfo['akceptacja_s'], $zinfo['przyjety_do_realizacji'], $zinfo['zrealizowane']);
            }
        }
    }
/*
    public function ustaw_akceptacja_po_id($id, $akceptacja){
        if (mysqli_query($this->conn, "UPDATE zapotrzebowanie_info SET akceptacja='$akceptacja'  WHERE id='$id'")){
            return true;
        }
        else return false;
    }

    public function ustaw_zrealizowane_po_id($id, $zrealizowane){
        if (mysqli_query($this->conn, "UPDATE zapotrzebowanie_info SET zrealizowane='$zrealizowane'  WHERE id='$id'")){
            return true;
        }
        else return false;
    }
*/

    public function ustaw_dane_po_id($id, $key, $val){

        if (mysqli_query($this->conn, "UPDATE zapotrzebowanie_info SET $key='$val' WHERE id='$id'")){
            return true;
        }
        else return false;
    }
}
?>