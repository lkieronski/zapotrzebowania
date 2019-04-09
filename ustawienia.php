<?php
session_start();
require('assets/conf.php');
require('assets/classes/kategoria.class.php');
require('assets/classes/produkt.class.php');
require('assets/classes/wydzial.class.php');
require('assets/classes/zapotrzebowanie.class.php');
require('assets/classes/zapotrzebowanie_nr.class.php');
require('assets/classes/zapotrzebowanie_info.class.php');
require('assets/classes/uzytkownik.class.php');

if (isset($_POST['dodaj_uzytkownika'])){
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $haslo2 = $_POST['haslo2'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $wydzial = $_POST['wydzial'];
    $uprawnienia = '';
    if (isset($_POST['user'])){
        $uprawnienia .= 'user;';
    }
    if (isset($_POST['kierownik_komorki'])){
        $uprawnienia .= 'kierownik_komorki;';
    }
    if (isset($_POST['kierownik_jednostki'])){
        $uprawnienia .= 'kierownik_jednostki;';
    }
    if (isset($_POST['realizator'])){
        $uprawnienia .= 'realizator;';
    }
    $uprawnienia = substr($uprawnienia, 0, -1);

    $nazwa = $imie.' '.$nazwisko;

    if ($haslo === $haslo2){
        $user = new Uzytkownik($conn_auth, null, $nazwa, $email, $haslo, $imie, $nazwisko, $wydzial, $uprawnienia);
        $user->zapisz_nowego_uzytkownika_do_bazy();
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="jquery.min.js"></script>
    <script src="ustawienia.js"></script>
</head>
<body>
<!-- WRAPPER -->
<div class="wrapper">
<?php
$uprawnienia = explode(';',$_SESSION['uprawnienia']);
if (in_array('user',$uprawnienia)){
    $w = new Wydzial($conn_auth);
    $wydzialy = $w->zwroc_wszystkie();
    ?>

    <div class="uprawnienia">
        <div>
            <div id="zmien_haslo" class="uprawnienia_single">
                ZMIEŃ HASŁO
            </div>
            <div id="zmien_haslo_bottom" class="uprawnienia_single_bottom">
                <form action="ustawienia.php" method="post">
                    <div class="ustawienia_inner"><label for="stare_haslo">stare hasło:</label><input type="password" name="stare_haslo" /><br /></div>
                    <div class="ustawienia_inner"><label for="haslo">nowe hasło:</label><input type="password" name="haslo" /><br /></div>
                    <div class="ustawienia_inner"><label for="haslo2">powtórz:</label><input type="password" name="haslo2" /><br /></div>
                    <div class="ustawienia_inner">
                            <input type="submit" name="zmien_haslo" value="Zmień Hasło" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (in_array('admin',$uprawnienia)){
    ?>
        <!-- UŻYTKOWNIK -->
        <div class="uprawnienia">
            <!-- DODAJ -->
            <div>
                <div id="dodaj_uzytkownika" class="uprawnienia_single">
                    DODAJ UŻYTKOWNIKA
                </div>
                <div id="dodaj_uzytkownika_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="email">e-mail:</label><input type="text" name="email" /><br /></div>
                        <div class="ustawienia_inner"><label for="haslo">hasło:</label><input type="password" name="haslo" /><br /></div>
                        <div class="ustawienia_inner"><label for="haslo2">powtórz hasło:</label><input type="password" name="haslo2" /><br /></div>
                        <div class="ustawienia_inner"><label for="imie">imię:</label><input type="text" name="imie" /><br /></div>
                        <div class="ustawienia_inner"><label for="nazwisko">nazwisko:</label><input type="text" name="nazwisko" /><br /></div>
                        <div class="ustawienia_inner"><label for="wydzial">wydział:</label>
                        <select name="wydzial">
                            <?php
                            foreach($wydzialy as $wydzial){
                                echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                            }
                            ?>
                        </select>
                        </div>
                        <div class="ustawienia_inner"><label>uprawnienia:</label>
                            <span class="chkbx"><input type="checkbox" name="user" value="1" checked /> user</span>
                            <span class="chkbx"><input type="checkbox" name="kierownik_komorki" value="1" /> kierownik_komórki</span>
                            <span class="chkbx"><input type="checkbox" name="kierownik_jednostki" value="1" /> kierownik_jednostki</span>
                            <span class="chkbx"><input type="checkbox" name="realizator" value="1" /> realizator</span>
                        </div><br />
                        <div class="ustawienia_inner">
                            <input type="submit" name="dodaj_uzytkownika" value="Dodaj Użytkownika" />
                        </div>
                    </form>
                </div>
            </div>
            <!-- KONIEC DODAJ -->
            <!-- EDYTUJ -->
            <div>
                <div id="edytuj_uzytkownika" class="uprawnienia_single">
                    EDYTUJ UŻYTKOWNIKA
                </div>
                <div id="edytuj_uzytkownika_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="wydzial">wydział:</label>
                            <select name="wydzial">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner" style="border-bottom: 1px solid #d35400"><label for="nazwa">użytkownik:</label>
                            <select name="nazwa">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner"><label for="email">e-mail:</label><input type="text" name="email" /><br /></div>
                        <div class="ustawienia_inner"><label for="haslo">hasło:</label><input type="password" name="haslo" /><br /></div>
                        <div class="ustawienia_inner"><label for="haslo2">powtórz hasło:</label><input type="password" name="haslo2" /><br /></div>
                        <div class="ustawienia_inner"><label for="imie">imię:</label><input type="text" name="imie" /><br /></div>
                        <div class="ustawienia_inner"><label for="nazwisko">nazwisko:</label><input type="text" name="nazwisko" /><br /></div>
                        <div class="ustawienia_inner"><label for="wydzial">wydział:</label>
                        <select name="wydzial">
                            <?php
                            foreach($wydzialy as $wydzial){
                                echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                            }
                            ?>
                        </select>
                        </div>
                        <div class="ustawienia_inner"><label>uprawnienia:</label>
                            <span class="chkbx"><input type="checkbox" name="user" value="1" checked /> user</span>
                            <span class="chkbx"><input type="checkbox" name="kierownik_komorki" value="1" /> kierownik_komórki</span>
                            <span class="chkbx"><input type="checkbox" name="kierownik_jednostki" value="1" /> kierownik_jednostki</span>
                            <span class="chkbx"><input type="checkbox" name="realizator" value="1" /> realizator</span>
                        </div><br />
                        <div class="ustawienia_inner">
                            <input type="submit" name="edytuj_uzytkownika" value="Edytuj Użytkownika" />
                        </div>
                    </form>
                </div>
            </div>
            <!-- KONIEC EDYTUJ -->
            <!-- USUŃ -->
            <div>
                <div  id="usun_uzytkownika" class="uprawnienia_single">
                    USUŃ UŻYTKOWNIKA
                </div>
                <div id="usun_uzytkownika_bottom" class="uprawnienia_single_bottom">
                <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="wydzial">wydział:</label>
                            <select name="wydzial">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner"><label for="nazwa">użytkownik:</label>
                            <select name="nazwa">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->nazwa.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="usun_uzytkownika" value="Usuń Użytkownika" />
                        </div>
                    </form>
                </div>
            </div>
            <!-- KONIEC USUŃ -->
        </div>
        <!-- KONIEC UŻYTKOWNIK  -->

        <!-- WYDZIAL -->
        <div class="uprawnienia">
            <div>
                <!-- DODAJ -->
                <div id="dodaj_wydzial" class="uprawnienia_single">
                    DODAJ WYDZIAŁ
                </div>
                <div id="dodaj_wydzial_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="nazwa">nazwa:</label><input type="text" name="nazwa" /><br /></div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="dodaj_wydzial" value="Dodaj Wydział" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
                <!-- EDYTUJ -->                
                <div id="edytuj_wydzial" class="uprawnienia_single">
                    EDYTUJ WYDZIAŁ
                </div>
                <div id="edytuj_wydzial_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner" style="border-bottom: 1px solid #d35400"><label for="nazwa">wydział:</label>
                            <select name="wydzial">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->id.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner"><label for="nazwa">nowa nazwa:</label><input type="text" name="nazwa" /><br /></div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="edytuj_wydzial" value="Edytuj Wydział" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
                <!-- USUŃ -->
                <div id="usun_wydzial" class="uprawnienia_single">
                    USUŃ WYDZIAŁ
                </div>
                <div id="usun_wydzial_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="nazwa">wydział:</label>
                            <select name="wydzial">
                                <?php
                                foreach($wydzialy as $wydzial){
                                    echo '<option value="'.$wydzial->id.'">'.$wydzial->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="usun_wydzial" value="Usuń Wydział" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
            </div>
        </div>
        <!-- KONIEC WYDZIAŁ  -->
    <?php
    }
    if (in_array('admin',$uprawnienia) || in_array('realizator',$uprawnienia)){
        $k = new Kategoria($conn);
        $kategorie = $k->zwroc_wszystkie();
    ?>

        <!-- KATEGORIA -->
        <div class="uprawnienia">
            <div>
                <!-- DODAJ -->
                <div id="dodaj_kategoria" class="uprawnienia_single">
                    DODAJ KATEGORIE
                </div>
                <div id="dodaj_kategoria_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="nazwa">nazwa:</label><input type="text" name="nazwa" /><br /></div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="dodaj_kategoria" value="Dodaj Kategorie" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
                <!-- EDYTUJ -->
                <div id="edytuj_kategoria" class="uprawnienia_single">
                    EDYTUJ KATEGORIE
                </div>
                <div id="edytuj_kategoria_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner" style="border-bottom: 1px solid #d35400"><label for="nazwa">kategoria:</label>
                            <select name="kategoria">
                                <?php
                                foreach($kategorie as $kategoria){
                                    echo '<option value="'.$kategoria->id.'">'.$kategoria->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner"><label for="nazwa">nowa nazwa:</label><input type="text" name="nazwa" /><br /></div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="edytuj_kategoria" value="Edytuj Kategorie" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
                <!-- USUŃ -->
                <div id="usun_kategoria" class="uprawnienia_single">
                    USUŃ KATEGORIE
                </div>
                <div id="usun_kategoria_bottom" class="uprawnienia_single_bottom">
                    <form action="ustawienia.php" method="post">
                        <div class="ustawienia_inner"><label for="nazwa">kategoria:</label>
                            <select name="wydzial">
                                <?php
                                foreach($kategorie as $kategoria){
                                    echo '<option value="'.$kategoria->id.'">'.$kategoria->nazwa.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="ustawienia_inner">
                            <input type="submit" name="usun_kategoria" value="Usuń Kategorie" />
                        </div>
                    </form>
                </div>
                <!-- KONIEC -->
            </div>
        </div>
        <!-- KONIEC KATEGORIA  -->

        <div class="uprawnienia">
        <h1>dodawanie produktu</h1>
        <h1>edycja produktu</h1>
        <h1>usuwanie produktu</h1>
        </div>
    <?php
    }
}
?>
</div>
<!-- KONIEC WRAPPER -->
</body>
</html>