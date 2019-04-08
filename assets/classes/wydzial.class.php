<?php
class Wydzial
{
    public $conn;
    public $id;
    public $nazwa;
    //public $kierownik;

    //function __construct($conn = null, $id = null, $nazwa = null, $kierownik = null){
    function __construct($conn = null, $id = null, $nazwa = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->nazwa = $nazwa;
        //$this->kierownik = $kierownik;
    }

        public function dodaj($nazwa, $kierownik){
            $nazwa = $this->przygotuj_string($nazwa);
            $kierownik = $this->przygotuj_string($kierownik);
            if (!($this->sprawdz_czy_istnieje_nazwa($nazwa))){
                if ($zapytanie = mysqli_query($this->conn, "INSERT INTO wydzial (nazwa) VALUES ('$nazwa')")){
                    echo 'Wydział dodany do bazy';
                }
            }
            else {
                echo 'Wydział już istnieje w bazie';
            }
        }

        public function usun($id){
            if ($this->sprawdz_czy_istnieje_id($id)){
                if ($zapytanie = mysqli_query($this->conn, "DELETE FROM wydzial WHERE id='$id'")){
                    echo 'Usunięto wydział';
                }
            }
            else {
                echo 'Nie znaleziono wydziału o podanym id';
            }
        }

        public function modyfikuj_nazwa($id, $nowa_nazwa){
            $nowa_nazwa = $this->przygotuj_string($nowa_nazwa);
            if (!($this->sprawdz_czy_istnieje_nazwa($nowa_nazwa))){
                if ($this->sprawdz_czy_istnieje_id($id)){
                    if ($zapytanie = mysqli_query($this->conn, "UPDATE wydzial SET nazwa='$nowa_nazwa' WHERE id='$id'")){
                        echo 'Zmieniono nazwę wydziału';
                    }
                }
                else{
                    echo 'Nie istnieje wydział o podanym id';
                }
            }
            else {
                echo 'Nowa nazwa już istnieje w bazie';
            }
        }

        // public function modyfikuj_kierownik($id, $nowy_kierownik){
        //     if ($this->sprawdz_czy_istnieje_id($id)){
        //         $nowy_kierownik = $this->przygotuj_string($nowy_kierownik);
        //         if ($zapytanie = mysqli_query($this->conn, "UPDATE wydzial SET kierownik='$nowy_kierownik' WHERE id='$id'")){
        //             echo 'Zmieniono kierownika wydziału';
        //         }
        //     }
        //     else {
        //         echo 'Wydział o podanym id nie istnieje';
        //     }
        // }

        public function zwroc_nazwe($id){
 
            if ($zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM wydzial WHERE id='$id'")){
                $wydzial = $zapytanie->fetch_array();
                return $wydzial['nazwa'];
            }
            else{
                echo 'Nie udało połączyć się z bazą danych';
            }
        }

        // public function zwroc_kierownika($id){

        //     if ($zapytanie = mysqli_query($this->conn, "SELECT kierownik FROM wydzial WHERE id='$id'")){
        //         $wydzial = $zapytanie->fetch_array();
        //         return $wydzial['kierownik'];
        //     }
        //     else{
        //         echo 'Nie udało połączyć się z bazą danych';
        //     }

        // }

        public function zwroc_wszystkie(){
            if ($zapytanie = mysqli_query($this->conn, "SELECT * FROM wydzial")){
                while ($wydzial = $zapytanie->fetch_array()){
                    //$wydzialy[] = new Wydzial(null, $wydzial['id'], $wydzial['nazwa'], $wydzial['kierownik']);
                    $wydzialy[] = new Wydzial(null, $wydzial['id'], $wydzial['nazwa']);
                }
                return $wydzialy;
            }
            else{
                echo 'Nie udało połączyć się z bazą danych';
            }
        }


        public function sprawdz_czy_istnieje_id($id){
            $zapytanie = mysqli_query($this->conn, "SELECT id FROM wydzial WHERE id='".$id."'");
            if ($zapytanie->num_rows > 0) return true;
            else return false;
        }
    
        public function sprawdz_czy_istnieje_nazwa($nazwa){
            $nazwa = $this->przygotuj_string($nazwa);
            $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM wydzial WHERE nazwa='".$nazwa."'");
            if ($zapytanie->num_rows > 0) return true;
            else return false;
        }

        // public function sprawdz_czy_istnieje_kierownik($kierownik){
        //     $kierownik = $this->przygotuj_string($kierownik);
        //     $zapytanie = mysqli_query($this->conn, "SELECT nazwa FROM wydzial WHERE kierownik='".$kierownik."'");
        //     if ($zapytanie->num_rows > 0) return true;
        //     else return false;
        // }
    
        public function przygotuj_string($string){
            $string = strip_tags($string);
            $string = mysqli_escape_string($this->conn, $string);
            $string = trim($string);
            return $string;
        }

        // public function zwroc_wydzial_info(){
        //     return $this->id.';'.$this->nazwa.';'.$this->kierownik;
        //  }
}

?>