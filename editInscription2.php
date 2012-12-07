﻿<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który edytuje wpis
 * Z GET'a pobiera:
 IdWpisu - id wpisu, który będziemy edytować
  
 * Trzeba przemyśleć, czy będziemy chcieli gdzieś zapamitywać datę i autora korekty.
 * Trzeba by jeszcze dorobić jakiś Messege box do deleta. 
 * Po delejcie powrót do indexa by się przydać
 
 **/
if (isset($_GET['idWpisu']) && (isset($_SESSION['dziennik']))){
$idWpisu = $_GET['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];

if(isset($_POST['submit'])) {    
    
    $tytul = $_POST['title'];
    $wpis = $_POST['inscription'];
    $podroz = $_POST['trip'];
    
    $katalog = mysql_query("SELECT * FROM katalog WHERE Katalog='$podroz' AND IdDziennika='$dziennik'");
    
    if (mysql_num_rows($katalog)==1) {
        
        $idKatalog = mysql_fetch_assoc($katalog);        
        $idKatalogu=$idKatalog['IdKatalog'];

        $query=mysql_query("UPDATE wpisy SET IdKatalog='$idKatalogu',Tytul='$tytul',Tresc='$wpis' WHERE IdWpis='$idWpisu'");

        if ($query) {
            echo '<br><span style="color: green; font-weight: bold;">Wpis został zmieniony! </span><br>';
        } else {
            echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
        }
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
    }
    
}  else if(isset($_POST['delete'])) {
    //Przed skasowaniem dialogbox Yes/No by się przydać.
    $query= mysql_query("DELETE FROM wpisy WHERE IdWpis='$idWpisu'");
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis został usunięty! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
    }
}

  
} else {
 echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, który ma być edytowany!</span><br>' ;
}