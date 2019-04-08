<?php 
class Produkt
{

    public $conn;
    public $id;
    public $kategoria;
    public $nazwa;

    function __construct($conn, $id = null, $kategoria = null, $nazwa = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->kategoria = $kategoria;
        $this->nazwa = $nazwa;
    }

    public function dodaj($kategoria, $nazwa){
        
        $nazwa = $this->przygotuj_string($nazwa);
        $k = new Kategoria($this->conn);
        if ($k->sprawdz_czy_istnieje_id($kategoria)){
            $kategoria = $k->zwroc_nazwe($kategoria); //zmienia id na nazwe
            if (!($this->sprawdz_czy_istnieje_nazwa($nazwa))){
                if ($zapytanie = mysqli_query($this->conn, "INSERT INTO produkt (kategoria, nazwa) VALUES ('$kategoria','$nazwa')")){
                    echo 'Dodano produkt do '.$nazwa.' w kategori '.$kategoria.' do bazy';
                }
                else {
                    echo 'Wystąpił błąd, nie dodano nowego produktu';
                }
            }
            else {
                echo 'Podany produkt już istnieje w bazie';
            }
        }
        else {
            echo 'Podana kategoria nie istnieje';
        }
        
    }


    public function usun($id){
        if ($this->sprawdz_czy_istnieje_id($id)){
            if ($zpytanie = mysqli_query($this->conn, "DELETE FROM produkt WHERE id='$id'")){
                echo 'Usunięto produkt z bazy';
            }
            else {
                echo 'Nie udało się usunąć produktu z bazy';
            }
        }
        else {
            echo 'Podane id prodoktu nie istnieje w bazie';
        }
    }

    public function modyfikuj_nazwe($id, $nowa_nazwa){
        if ($this->sprawdz_czy_istnieje_id($id)){
            $nowa_nazwa = $this->przygotuj_string($nowa_nazwa);
            if ($zapytanie = mysqli_query($this->conn, "UPDATE produkt SET nazwa='$nowa_nazwa' WHERE id='$id'")){
                echo 'Zmieniono nazwę produktu';
            }
            else {
                echo 'Nie udało się zmienić nazwy produktu';
            }
        }
        else {
            echo 'Nie istnieje produkt o podanym id';
        }
        
    }

    public function modyfikuj_kategorie($id, $nowa_kategoria){
        if ($this->sprawdz_czy_istnieje_id($id)){
            $kategoria = new Kategoria($this->conn);
            if ($kategoria->sprawdz_czy_istnieje_id($nowa_kategoria)){
                $nowa_kategoria = $kategoria->zwroc_nazwe($nowa_kategoria); //zmienia id na nazwe
                if ($zapytanie = mysqli_query($this->conn, "UPDATE produkt SET kategoria='$nowa_kategoria' WHERE id='$id'")){
                    echo 'Zmieniono kategorie produktu';
                }
            }
            else {
                echo 'Kategoria o podanym id nie istnieje';
            }
        }
    }

    public function zwroc_nazwe($id){
        if ($zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM produkt WHERE id='$id'")){
            $produkt = $zapytanie->fetch_array();
            return $produkt['nazwa'];
        }
    }

    public function zwroc_kategorie($id){
        if ($zapytanie = mysqli_query($this->conn, "SELECT kategoria FROM produkt WHERE id='$id'")){
            $produkt = $zapytanie->fetch_array();
            return $produkt['kategoria'];
        }
    }

    public function zwroc_wszystkie(){
        if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM produkt")){
            while ($produkt = $zapytanie->fetch_array()){
                $produkty[] = new Produkt(null, $produkt['id'], $produkt['kategoria'], $produkt['nazwa']);
            }
            return $produkty;
        }
    }

    public function zwroc_wszystkie_z_kategori($kategoria){
        if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM produkt WHERE kategoria='$kategoria'")){
            while ($produkt = $zapytanie->fetch_array()){
                $produkty[] = new Produkt(null, $produkt['id'], $produkt['kategoria'], $produkt['nazwa']);
            }
            return $produkty;
        }
    }

    public function sprawdz_czy_istnieja_produkty_z_dana_kategoria($kategoria){
        $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM produkt WHERE kategoria='".$kategoria."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function sprawdz_czy_istnieje_id($id){
        $zapytanie = mysqli_query($this->conn, "SELECT id FROM produkt WHERE id='".$id."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function sprawdz_czy_istnieje_nazwa($nazwa){
        $nazwa = $this->przygotuj_string($nazwa);
        $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM produkt WHERE nazwa='".$nazwa."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function przygotuj_string($string){
        $string = strip_tags($string);
        $string = mysqli_escape_string($this->conn, $string);
        $string = trim($string);
        return $string;
    }

    public function zwroc_produkt_info(){
       return $this->id.';'.$this->kategoria.';'.$this->nazwa;
    }
}
?>