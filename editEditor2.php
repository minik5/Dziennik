<?php
session_start();
include ("connection.php");

if (isset ($_SESSION['zalogowany'])){
if (isset($_GET['id'])){
$id = $_GET['id'];
$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM redaktorzy WHERE IdRed = '".$id."' AND NazwaDziennika = '".$nick."'");
$r = mysql_fetch_array($query);

if (!(isset($r['IdRed']))){
	echo 'Wybrany redaktor nie należy do Twojego dziennika. <br />';
	exit;
}
else{
$query2 = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika ='".$r['NazwaDziennika']."'");
$d = mysql_fetch_array($query2);
}
if (isset($_POST['zmiana'])){
$komunikaty = '';
$query3 = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$n = mysql_fetch_array($query3);
if (isset ($_POST['password'])){
$old = $_POST['password'];
$old = md5($old);
if ($old==$n['Haslo']){
$redaktor = 'NIE';
$autor = 'NIE';
if (isset($_POST['option1'])){
$redaktor = $_POST['option1'];
}
if (isset($_POST['option2'])){
$autor = $_POST['option2'];
}
$result = mysql_query("UPDATE redaktorzy  SET EdycjaAutora='".$autor."', EdycjaRedaktora ='".$redaktor."' WHERE IdRed = '".$id."'");
if (!$result){
    die('Invalid query: ' . mysql_error());
  }
  else {
  $komunikaty.="Uprawnienia zostały nadane <br />";
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
else{
echo "Inexplicable internal error";
}
}
else{
echo'<br>Błąd. <br />Nie wybrano redaktora do zmiany uprawnień. <br />';



}
echo $komunikaty;
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
	echo 'Lub <a href="register.php">Zarejestruj się</a>';
	exit;


}
?>