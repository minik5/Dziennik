<?php
session_start();
$komunikaty ="";
include ("connection.php");
if(isset($_POST['delRed'])) {
echo "ciał";
$nick = $_SESSION['login'];
$id = $_GET['id'];
$query3 = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$n = mysql_fetch_array($query3);
if (isset ($_POST['password'])){
$old = $_POST['password'];
$old = md5($old);
if ($old==$n['Haslo']){
	if (isset($_POST['delwpis']) && $_POST['delwpis'] != "undefined"){
	for ($i = 0; $i<sizeof($_POST['delwpis']); $i ++){
	$idWpisu = $_POST['delwpis'][$i];
    //Przed skasowaniem dialogbox Yes/No by się przydać.
    $query= mysql_query("DELETE FROM wpisy WHERE IdWpis='$idWpisu'");
	$query2=mysql_query("DELETE FROM zalaczniki WHERE idwpisu ='$idWpisu'");
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Wpis numer '.$idWpisu.' został usunięty! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
    }
	if ($query2){
	echo '<br><span style="color: green; font-weight: bold;">Załączniki wpisu zostały usunięte! </span><br>';
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
    }
	}
	}
	
	$del = mysql_query("DELETE FROM redaktorzy WHERE IdRed ='$id'");
	if ($del){
	echo '<br><span style="color: green; font-weight: bold;">Redaktor usunięty! </span><br>';
	exit;
        // Dobrze by było żeby nie zostawiać na stronie. Najlepiej info i powrót na index.
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
		exit;
    }	
}
else{
$komunikaty.= "Podane aktualne hasło, jest nieprawidłowe. <br />";
}
}
else{
echo "Nie podano hasła!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
}
}

echo $komunikaty;

?>