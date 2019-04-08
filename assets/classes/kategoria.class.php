<?php

class Kategoria
{
    public $conn;
    public $id;
    public $nazwa;

    function __construct($conn, $id = null, $nazwa = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->nazwa = $nazwa;
    }

    public function dodaj($nazwa){

        //sprawdzamy czy podana nazwa jest już w bazie
        $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM kategoria WHERE nazwa='".$nazwa."'");
        if ($zapytanie->num_rows > 0){
            echo 'Podana kategoria już istnieje';
        }
        //jeśli nie ma w bazie dodajemy nową kategorie
        else {
            $nazwa = $this->przygotuj_string($nazwa);
            if (mysqli_query($this->conn, "INSERT INTO kategoria (nazwa) VALUES ('$nazwa')")){
                echo 'Dodano kategorię';
            }
            
            
        } 

        
    }
    //usuwa kategorie z bazy po id
    public function usun($id){

        //sprawdzamy czy dane id jest w bazie jeśli tak to kasujemy
        if ($this->sprawdz_czy_istnieje_id($id)){
            $nazwa_kategori = $this->zwroc_nazwe($id);
            $p = new Produkt($this->conn);
            if (!($p->sprawdz_czy_istnieja_produkty_z_dana_kategoria($nazwa_kategori))){
                if ($zapytanie_usun = mysqli_query($this->conn, "DELETE FROM kategoria WHERE id='".$id."'")){
                    echo 'Usunięto kategorię z bazy';
                }
            }
            else {
                echo 'Nie można usunąć kategori ponieważ istnieją produktu powiązane';
            }   
        }
        else {
            echo 'Nie znaleziono kategori o podanym id';
        }
    }

    //modyfikuje nazwe kategori po id
    public function modyfikuj($id, $nowa_nazwa){
        //sprawdzam czy nowej kategori nie ma już w bazie
        if ($this->sprawdz_czy_istnieje_nazwa($nowa_nazwa)){
            echo 'Kategoria na którą prubujesz zmienić obecną już istnieje';
        }
        //jeśli nie ma w bazie modyfikujemy kategorie
        else {
            if ($this->sprawdz_czy_istnieje_id($id)){
                $stara_nazwa = $this->zwroc_nazwe($id);
                $nowa_nazwa = $this->przygotuj_string($nowa_nazwa);
                if (mysqli_query($this->conn, "UPDATE kategoria SET nazwa='".$nowa_nazwa."' WHERE id='".$id."'")){
                    echo 'Zmodyfokowano kategorię '.$stara_nazwa.' na '.$nowa_nazwa;
                }
            }
            else echo 'Kategoria o podanym id nie istnieje';
            
            
        } 
        
    }

    //zwraca nazwe kategori po id
    public function zwroc_nazwe($id){

        if ($zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM kategoria WHERE id='".$id."'")){    
            $kategoria = $zapytanie->fetch_array();
            return $kategoria['nazwa'];
        }

    }

    //zwaraca wszystkie kategorie i ich id
    public function zwroc_wszystkie(){
        
        $zapytanie = mysqli_query($this->conn, "SELECT id,nazwa FROM kategoria ORDER BY nazwa");
        while ($kategoria = $zapytanie->fetch_array()){
            $kategorie[] = new Kategoria(null, $kategoria['id'], $kategoria['nazwa']);
        }
        return $kategorie;
    }

    public function sprawdz_czy_istnieje_id($id){
        $zapytanie = mysqli_query($this->conn, "SELECT id FROM kategoria WHERE id='".$id."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    public function sprawdz_czy_istnieje_nazwa($nazwa){
        $nazwa = $this->przygotuj_string($nazwa);
        $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM kategoria WHERE nazwa='".$nazwa."'");
        if ($zapytanie->num_rows > 0) return true;
        else return false;
    }

    //przygotowuje string na dodanie do bazy
    public function przygotuj_string($string){
        $string = strip_tags($string);
        $string = mysqli_escape_string($this->conn, $string);
        $string = trim($string);
        //$string = preg_replace('/\s+/', '', $string);
        return $string;
    }

    public function zwroc_kategoria_info(){
        return $this->id.';'.$this->nazwa;
    }
}
?>