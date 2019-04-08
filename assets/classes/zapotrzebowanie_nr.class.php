<?php
class Zapotrzebowanie_nr
{
    public $conn;
    public $id;
    public $numer;

    function __construct($conn, $id = null, $numer = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->numer = $numer;
    }

    public function dodaj(){ //zwraca numer 
        $numer = $this->generujNumer();
        if ($zapytanie = mysqli_query($this->conn, "INSERT INTO zapotrzebowanie_nr (numer) VALUES ('$numer')")){ 
            //$this->numer = $numer;
            //$this->id = mysqli_insert_id($this->conn);
            //echo 'Dodano nowy numer zapotrzebowania. Id:'.$this->id.' _ Numer:'.$this->numer.'';
            return $numer;
        }
    }

    public function usun($id){
        $z = new Zapotrzebowanie($this->conn);
        $zinfo = new Zapotrzebowanie_info($this->conn);
        $numer = $this->zwroc_numer($id);
        if (!($z->sprawdz_czy_istnieje_zapotrzebowanie_po_numer($numer))){
            if (!($zinfo->sprawdz_czy_istnieje_zapotrzebowanie_info_po_numer($numer))){
                if ($zapytanie = mysqli_query($this->conn, "DELETE FROM zapotrzebowanie_nr WHERE id='$id'")){
                    echo 'Usunięto numer z bazy';
                }
            } // dopisac komunikat
        } // dopisac komunikat
    }

    public function zwroc_numer($id){
        if ($zapytanie = mysqli_query($this->conn, "SELECT numer FROM zapotrzebowanie_nr WHERE id='".$id."'")){
            $zapotrzebowanie_nr = $zapytanie->fetch_array();
            $numer = $zapotrzebowanie_nr['numer'];
            return $numer;
        }
    }



    public function generujNumer(){
        $data = date('Ymd');
        $i = 1;
        while ($this->sprawdz_czy_istnieje_numer($data.$i)){
            $i++;
        }
        $numer = $data.$i;
        return $numer;
    }

    public function sprawdz_czy_istnieje_id($id){
        $zapytanie = mysqli_query($this->conn, "SELECT id FROM zapotrzebowanie_nr WHERE id='".$id."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function sprawdz_czy_istnieje_numer($numer){
        $nazwa = $this->przygotuj_string($numer);
        $zapytanie = mysqli_query($this->conn, "SELECT numer FROM zapotrzebowanie_nr WHERE numer='".$numer."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function przygotuj_string($string){
        $string = strip_tags($string);
        $string = mysqli_escape_string($this->conn, $string);
        $string = trim($string);
        return $string;
    }
}



?>