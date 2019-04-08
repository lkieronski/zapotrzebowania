<?php

class Zapotrzebowanie
{
    public $conn;
    public $id;
    public $zapotrzebowanie_nr;
    public $produkt;
    public $ilosc;

    function __construct($conn, $id = null, $zapotrzebowanie_nr = null, $produkt = null, $ilosc = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->zapotrzebowanie_nr = $zapotrzebowanie_nr;
        $this->produkt = $produkt;
        $this->ilosc = $ilosc;
    }

    public function dodaj(){
        if (isset($this->zapotrzebowanie_nr) && isset($this->produkt) && isset($this->ilosc)){
            if ($zapytanie = mysqli_query($this->conn, "INSERT INTO zapotrzebowanie (zapotrzebowanie_nr, produkt, ilosc) VALUES ('$this->zapotrzebowanie_nr','$this->produkt','$this->ilosc')")){
                echo 'Zapotrzebowanie dodane do bazy';
            }
        }

    }

    public function zwroc_wszystkie_po_zapotrzebowanie_nr($zapotrzebowanie_nr){
        if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM zapotrzebowanie WHERE zapotrzebowanie_nr='$zapotrzebowanie_nr'")){
            while($zapotrzebowanie = $zapytanie->fetch_array()){
                $zapotrzebowania[] = new Zapotrzebowanie(null, $zapotrzebowanie['id'], $zapotrzebowanie['zapotrzebowanie_nr'], $zapotrzebowanie['produkt'], $zapotrzebowanie['ilosc']);
            }
            return $zapotrzebowania;
        }
    }

    public function sprawdz_czy_istnieje_zapotrzebowanie_po_numer($zapotrzebowanie_nr){
        if ($zapytani = mysqli_query($this->conn, "SELECT numer FROM zapotrzebowanie WHERE numer='$zapotrzebowanie_nr'")){
            if ($zapytanie->num_rows > 0) return true;
            else return false;
        }
    }


    public function zwroc_zapotrzebowanie_string(){
        return $this->produkt.':'.$this->ilosc.'<br>';
     }
}
?>