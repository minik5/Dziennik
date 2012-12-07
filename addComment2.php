<?php
include ("connection.php");
session_start();

if (isset($_GET['IdWpisu'])){
$parametr = $_GET['IdWpisu'];
$komunikaty = "";
if (isset($_SESSION['zalogowany'])){

if (isset($_POST['wyslij'])){
$nick = $_SESSION['login'];
$komentarz = $_POST['komentarz'];
$wpis = $parametr;
	date_default_timezone_set("Europe/Warsaw");

$result = mysql_query("INSERT INTO komentarze (IdWpisu, IdUser, Tresc, Widoczny, Ostrz, DataOstrz) VALUES('$wpis','$nick','$komentarz','',null,null)") or die("Nie mogłem dodac komentarza !".mysql_error());
$komunikaty .= "<font color='green'><b>Komentarz dodany</b></font>";

}
echo $komunikaty;
?>

<?php
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
}
?>
