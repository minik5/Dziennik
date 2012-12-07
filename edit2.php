<?php
session_start();
include ("connection.php");
$komunikaty = '';
/** Pytanie: Czy dopuszczamy możliwość zmiany hasła na to samo?

*/

/** -------------początek zmiany hasła ------------- **/
if (isset($_POST['pwd']) && isset($_SESSION['zalogowany'])){ 

$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$r = mysql_fetch_array($query);
if (isset ($_POST['oldpassword'])){
$old = $_POST['oldpassword'];
$old = md5($old);
if ($old==$r['Haslo']){
if (isset ($_POST['newpassword'])){
$haslo = $_POST['newpassword'];
$spr1 = strlen($haslo);
}
if (isset ($_POST['vnewpassword'])){
$vhaslo = $_POST['vnewpassword'];
}
if ($haslo == NULL){
$komunikaty .= "Nie podano nowego hasła <br/>";
}
elseif ($vhaslo == NULL){
$komunikaty .= "Nie potwierdzono nowego hasła <br/>";
}
elseif ($spr1 <4 ){
$komunikaty .= "Nowe hasło powinno zawierać co najmniej 4 znaki<br/>";
}
 if ($haslo != $vhaslo){
 $komunikaty.= "Podane nowe hasła nie są identyczne.<br/>";
 }
  else{
  if (!$komunikaty){
  $haslo = md5($haslo);
  $result = mysql_query("UPDATE uzytkownicy  SET Haslo='".$haslo."' WHERE Nick ='".$nick."'");
  if (!$result){
    die('Invalid query: ' . mysql_error());
  }
  else {
  $komunikaty.="Hasło zostało zmienione poprawnie <br />";
  }
  }
  }
}
else{
$komunikaty.= "Podane aktualne hasło, jest nieprawidłowe. <br />";
}
}
else{
$komunikaty.= "Nie podano aktualnego hasła.<br />";
}
}
/** -------------koniec zmiany hasła ------------- **/

if (isset($_POST['edit']) && isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$haslo = $_POST["password"];
$imie = $_POST["firstname"];
$nazwisko = $_POST["surname"];
$email = $_POST["email"];
$omnie = $_POST['omnie'];
if (isset($_POST['datepicker']) && $_POST['datepicker'] != "undefined"){
$data = $_POST['datepicker'];
}
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$r = mysql_fetch_array($query);

$haslo = md5($haslo);

if ($haslo != $r['Haslo']){
$komunikaty.="Podane hasło jest niepoprawne.<br />";
}
else{
$result1 = mysql_query("UPDATE uzytkownicy  SET Imie='".$imie."', Nazwisko='".$nazwisko."', Email='".$email."',OMnie='".$omnie."' WHERE Nick ='".$nick."'");
  if (!$result1){
    die('Invalid query: ' . mysql_error());
  }
  else {
  $komunikaty.="Dane zostały zmienione poprawnie. <br />";
  }

}



}
echo $komunikaty;
?>