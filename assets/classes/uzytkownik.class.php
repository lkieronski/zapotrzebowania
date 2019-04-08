<?php
class Uzytkownik{
    public $conn;
    public $id;
    public $nazwa;
    public $email;
    public $haslo;
    public $imie;
    public $nazwisko;
    public $wydzial;
    public $uprawnienia;
    public $cookie_logkey;
    public $cookie_logkey_tiemout;

    function __construct($conn, $id = null, $nazwa = null, $email = null, $haslo = null, $imie = null, $nazwisko = null, $wydzial = null, $uprawnienia = null, $cookie_logkey = null, $cookie_logkey_timeout = null){
        $this->conn = $conn;
        $this->id = $id;
        $this->nazwa = $nazwa;
        $this->email = $email;
        $this->haslo = $haslo;
        $this->imie = $imie;
        $this->nazwisko = $nazwisko;
        $this->wydzial = $wydzial;
        $this->uprawnienia = $uprawnienia;
        $this->cookie_logkey = $cookie_logkey;
        $this->cookie_logkey_tiemout = $cookie_logkey_timeout;
    }

    public function zapisz_nowego_uzytkownika_do_bazy(){
        $this->haslo = $this->zakoduj_haslo($this->haslo);
        if (mysqli_query($this->conn, "INSERT INTO uzytkownicy (nazwa, email, haslo, imie, nazwisko, wydzial, uprawnienia) VALUES ('$this->nazwa','$this->email','$this->haslo','$this->imie','$this->nazwisko','$this->wydzial','$this->uprawnienia')")){
            echo 'Użytkownik dodany do bazy';
        }
    }

    public function wczytaj_uzytkownika_po_id($id){
        $u = mysqli_query($this->conn, "SELECT * FROM uzytkownicy WHERE id='$id'");
        $user = $u->fetch_array();
        return new Uzytkownik(null, $user['id'], $user['nazwa'], $user['email'], $user['haslo'], $user['imie'], $user['nazwisko'], $user['wydzial'], $user['uprawnienia']);
    }

    public function wczytaj_uzytkownika_po_email($email){
        $u = mysqli_query($this->conn, "SELECT * FROM uzytkownicy WHERE email='$email'");
        $user = $u->fetch_array();
        return new Uzytkownik(null, $user['id'], $user['nazwa'], $user['email'], $user['haslo'], $user['imie'], $user['nazwisko'], $user['wydzial'], $user['uprawnienia'], $user['cookie_logkey']);
    }
    
    public function wczytaj_uzytkownika_po_cookie($logkey){
        if ($u = mysqli_query($this->conn, "SELECT * FROM uzytkownicy WHERE cookie_logkey='$logkey'")){
            if ($user = $u->fetch_array()){
                return new Uzytkownik(null, $user['id'], $user['nazwa'], $user['email'], $user['haslo'], $user['imie'], $user['nazwisko'], $user['wydzial'], $user['uprawnienia'], $user['cookie_logkey']);
            }
            else return false;
        }   
    } 

    public function uwierzytelnij_uzytkownika_po_cookie($logkey){
        if ($user = $this->wczytaj_uzytkownika_po_cookie($logkey)){
            echo "Uwierzytelniony po cookie jako $user->nazwa";
            return true;
        }
        else return false;
    }

    public function uwierzytelnij_uzytkownika($email, $haslo, $zapamietaj){
        if($user = $this->wczytaj_uzytkownika_po_email($email)){
            if (password_verify($haslo,$user->haslo)){
                if ($zapamietaj === '1'){
                    $dni_trwalosci = 5;
                    $cookie = $this->generuj_cookie($dni_trwalosci);      
                    $cookie_logkey = $cookie['logkey'];
                    $cookie_logkey_timeout = $cookie['logkey_timeout'];
                    setcookie('logkey', $cookie_logkey, time() + (86400 * 2));
                    $this->dodaj_cookie_do_bazy($user->id,$cookie_logkey, $cookie_logkey_timeout);
                }
            return $user;
            }
            else {
                return false;
            }
        }
        else return 0;
    }

    public function dodaj_cookie_do_bazy($id, $cookie_logkey, $cookie_logkey_timeout){
        mysqli_query($this->conn, "UPDATE uzytkownicy SET cookie_logkey='$cookie_logkey', cookie_logkey_timeout='$cookie_logkey_timeout' WHERE id='$id'");
    }
    public function zakoduj_haslo($haslo){
        $haslo = $this->przygotuj_string($haslo);
        $haslo = password_hash($haslo, PASSWORD_BCRYPT);
        return $haslo;
    }

    public function generuj_cookie($dni_trwalosc){
        $t = new DateTime(date('Y-m-d H:i:s'));
        $t->add(new DateInterval('P'.$dni_trwalosc.'D'));
        $logkey_tiemout = $t->format('Y-m-d H:i:s');
        $logkey = $this->GenerateRandomKeyCode(20);
        $cookie = array();
        $cookie['logkey'] = $logkey;
        $cookie['logkey_timeout'] = $logkey_tiemout;
        return $cookie;
    }

    private function GenerateRandomKeyCode($dlugosc) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";   
        $alphaLength = strlen($alphabet) - 1;
        $pass='';
        for ($i = 0; $i < $dlugosc; $i++) {
            $n = rand(0, $alphaLength);
            $pass[$i] = $alphabet[$n];
        }
        return $pass;
    }

    public function przygotuj_string($string){
        $string = mysqli_escape_string($this->conn, $string);
        $string = trim($string);
        return $string;
    }
}
?>