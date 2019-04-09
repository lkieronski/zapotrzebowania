<?php

$host = "localhost";
$username = "root";
$password = "";
$z_dbname= "zapo";
$a_dbname="auth";

$conn = new mysqli($host, $username, $password, $z_dbname);

if ($conn->connect_errno) {
    //można sprawdzić czy nie ma po prostu bazy łącząc się bez podawanie $dbname i tworząc całą bazę z tabelami od nowa;  
    die('Nie udało się połączyć z bazą danych');  
}
$conn_auth = new mysqli($host, $username, $password, $a_dbname);
if ($conn_auth->connect_errno) {
    //można sprawdzić czy nie ma po prostu bazy łącząc się bez podawanie $dbname i tworząc całą bazę z tabelami od nowa;  
    die('Nie udało się połączyć z bazą danych');  
}