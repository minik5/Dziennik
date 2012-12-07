<?php
session_start();
include("connection.php");
include("getbrowser.php");

if (isset($_SESSION['dziennik'])) {
$login = $_SESSION['login'];

// Sprawdzanie czy dziennik został zaakceptowany przez admina
$error = false;
if ($_SESSION['dziennik'] == $login){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
    date_default_timezone_set("Europe/Warsaw");
$dzien = date('d');
$mies = date('m');
$rok = date('Y');
$dataRoz = date("Y-m-d");
$dzienZak = NULL;
$miesZak = NULL;
$rokZak = NULL;
$dataZak = NULL;
$tytul="";
$opis="";

if (isset($_POST['submit'])) {
    
    $daty=true;
    $idDziennika = $_SESSION['dziennik'];
    $tytul = $_POST['title'];
    if (isset($_POST['trip']) && $_POST['trip'] != "undefined") $opis = $_POST['trip'];
    else $opis = "";
    
   if (getbrowser()=='ie' || getbrowser()=='firefox') {
        // wczytanie dat dla przegl¹darek bez typu DATE
        
        if (!is_numeric($_POST['dDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Dzień to liczba z przedziału 1..31!</span><br>';
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
                echo '<br><span style="color: blue; font-weight: bold;">Nieprawidłowa data!</span><br>';
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
        echo '<br><span style="color: green; font-weight: bold;">Data zakończenia musi być późniejsza od daty rozpoczęcia!</span><br>'; 
    }
    
    if ($daty) {
        $spr = mysql_query("SELECT * FROM katalog WHERE Katalog='$tytul'");
        if (mysql_num_rows($spr)==0) {
            $query = "INSERT INTO katalog (IdDziennika,Katalog,Opis,DataRozpoczecia,DataZakonczenia) VALUES('$idDziennika','$tytul','$opis','$dataRoz','$dataZak')";
            $result=mysql_query($query);
            if ($result) {
                echo '<br><span style="color: green; font-weight: bold;">Wycieczka została dodana!</span><br>';
            }
            else echo '<br><span style="color: green; font-weight: bold;">Nie można połączyć się z bazą danych!</span><br>';
        } else echo '<br><span style="color: green; font-weight: bold;">Wycieczka o podanym tytule istenieje już w bazie danych!</span><br>';
    }
}

}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
?>