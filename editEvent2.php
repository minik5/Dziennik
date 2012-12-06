<?php
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
if (isset($_SESSION['dziennik'])){
    $dziennik = $_SESSION['dziennik'];
    $wpisy= mysql_query("SELECT * FROM wpisy WHERE IdDziennika='$dziennik' ORDER BY DataWpisu DESC");
    if (mysql_num_rows($wpisy)>0) {
    $tytul = "";
    $wpis = "";
    if (isset($_GET['idWpisu'])) {
        $idWpisu = $_GET['idWpisu'];
        $query = mysql_query("SELECT * FROM wpisy WHERE IdWpis='$idWpisu' AND IdDziennika='$dziennik'");

        if (mysql_num_rows($query)==1) { 
            $result = mysql_fetch_array($query);
            $tytul = $result['Tytul'];
            $wpis = $result['Tresc'];


        if(isset($_POST['submit'])) {    

            $tytul = $_POST['title'];
            $wpis = $_POST['inscription'];

            $query=mysql_query("UPDATE wpisy SET Tytul='$tytul',Tresc='$wpis' WHERE IdWpis='$idWpisu'");

            if ($query) {
                echo '<br><span style="color: green; font-weight: bold;">Wpis został zmieniony! </span><br>';
            } else {
                echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
            }

        } else if(isset($_POST['reset'])) {
            $tytul = "";
            $wpis = "";
        } else if(isset($_POST['delete'])) {
            //Przed skasowaniem dialogbox Yes/No by się przydać.
            $query= mysql_query("DELETE FROM wpisy WHERE IdWpis='$idWpisu'");
            if ($query) {
                echo '<br><span style="color: green; font-weight: bold;">Wpis został usunięty! </span><br>';
                // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
            } else {
                echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
            }
        }
        }
    }

    } else {
        echo '<br><span style="color: red; font-weight: bold;">Nie posiadasz wpis�w w dzienniku!</span><br>' ;
    }
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie posiadasz dziennika!</span><br>' ;
}
?>