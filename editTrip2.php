<?php
    // Pobiera z GET'a Id wycieczki

session_start();
include("connection.php");
include("getbrowser.php");

if (isset($_SESSION['dziennik'])) {
$login = $_SESSION['login'];
// Sprawdzanie czy dziennik został zaakceptowany przez admina
if (isset($_GET['IdTrip'])) {
   
    $result= mysql_query("SELECT * FROM katalog WHERE IdKatalog=".$_GET['IdTrip']);
    
    $podroz = mysql_fetch_assoc($result);    
    
        date_default_timezone_set("Europe/Warsaw");
    $dataRoz = $podroz['DataRozpoczecia'];
    $dataZak = $podroz['DataZakonczenia'];
    $tytul = $podroz['Katalog'];
    $opis = $podroz['Opis'];
    
    $dzien = substr($dataRoz,8,2);
    $mies = substr($dataRoz,5,2);
    $rok = substr($dataRoz,0,4);
    
    $dzienZak = substr($dataZak,8,2);
    $miesZak = substr($dataZak,5,2);
    $rokZak = substr($dataZak,0,4);

if (isset($_POST['submit'])) {
    
    $daty=true;
    $idDziennika = $_SESSION['dziennik'];
    $tytul = $_POST['title'];
    if (isset($_POST['trip'])) $opis = $_POST['trip'];
    else $opis = "";
    
   if (getbrowser()=='ie' || getbrowser()=='firefox') {
        // wczytanie dat dla przegladarek bez typu DATE
        
        if (!is_numeric($_POST['dDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Dzien to liczba z przedziału 1..31!</span><br>';
            $daty=false;
        } else $dzien = (int)$_POST['dDateRoz'];        
        if (!is_numeric($_POST['mDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Miesiąc to liczba z przedziału 1..12!</span><br>';
            $daty=false;
        } else $mies = (int)$_POST['mDateRoz'];
        if (!is_numeric($_POST['yDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Rok to cztero-cyfrowa liczba!</span><br>';
            $daty=false;
        } else $rok = (int)$_POST['yDateRoz'];
        if (!is_numeric($_POST['dDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Dzień to liczba z przedziału 1..31!</span><br>';
            $daty=false;
        } else $dzienZak = (int)$_POST['dDateZak'];
        if (!is_numeric($_POST['mDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Miesiąc to liczba z przedziału 1..12!</span><br>';
            $daty=false;
        } else $miesZak = (int)$_POST['mDateZak'];
        if (!is_numeric($_POST['yDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Rok to cztero-cyfrowa liczba!</span><br>';
            $daty=false;
        } else $rokZak = (int)$_POST['yDateZak'];
        if ($daty) {
            if (!checkdate($mies, $dzien, $rok) || !checkdate($miesZak, $dzienZak, $rokZak)) {
                echo '<br><span style="color: blue; font-weight: bold;">Nieprawiłowa data!</span><br>';
                $daty=false;
            } else {
                $dataRoz = $rok.'-'.$mies.'-'.$dzien;
                $dataZak = $rokZak.'-'.$miesZak.'-'.$dzienZak;
            }
        }
    }
    else {
        $dataRoz = $_POST['datepickerRoz'];
        $dataZak = $_POST['datepickerZak'];
    }
    
    if ( $dataRoz > $dataZak ) {
        $daty=false;
        echo '<br><span style="color: green; font-weight: bold;">Data zakończenia musi był być późniejsza od daty rozpoczęcia!</span><br>'; 
    }
    
    if ($daty) {        
        $query = "UPDATE katalog SET IdDziennika='$idDziennika',Katalog='$tytul',Opis='$opis',DataRozpoczecia='$dataRoz',DataZakonczenia='$dataZak' WHERE IdKatalog=".$_GET['IdTrip'];
        $result=mysql_query($query);
        if ($result) {
           echo '<br><span style="color: green; font-weight: bold;">Wyciczka została zmieniona!</span><br>';
        } else echo '<br><span style="color: green; font-weight: bold;">Nie można połączyć się z bazą danych!</span><br>';
    }
}

} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie została wybrana podróż do edycji!</span><br>';
}
}else {
    echo '<br><span style="color: blue; font-weight: bold;">Nie posiadasz dziennika!</span><br>';
}
?>