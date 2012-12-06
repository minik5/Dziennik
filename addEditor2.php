<?php
session_start();
include ("connection.php");
?>
<?php
if (isset($_POST['edit'])){
if (isset($_POST['redaktor'])){
header('Location: editEditor.php?id='.$_POST['redaktor']);
}
}
if (isset($_POST['del'])){
if (isset($_POST['redaktor'])){
header('Location: delEditor.php?id='.$_POST['redaktor']);
}
}


?>



<?php
if (isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$error = false;
if ($_SESSION['dziennik'] == $nick){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$nick' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$nick'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dzienniki WHERE IdDziennika='".$nick."' LIMIT 1"));
$komunikaty = '';
$searcherror = false;

if ($spr1[0] == 1){

if (isset($_POST['dodaj'])){
$nickred = $_POST['nickred'];
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='".$nickred."' LIMIT 1"));
$spr3 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM redaktorzy WHERE NickRed='".$nickred."' AND NazwaDziennika = '".$nick."' LIMIT 1"));

if ($spr2[0] <1){
 $komunikaty .= '<font color="red"><b>Użytkownik o podanym nicku: '.$nickred.' <br>nie istnieje, sprawdź pisownię i spróbuj jeszcze raz.</b></font><br />';
 $searcherror = true;
 }
if  ($spr3[0] >=1){
$komunikaty .= '<font color="red"><b>Użytkownik o podanym nicku: '.$nickred.' <br>istnieje już jako redaktor w Twoim dzienniku. </b></font>';
$searcherror = true;
}
if ($nick == $nickred){

$komunikaty .= '<font color="red"><b>Nie możesz dodać samego siebie.</b></font>';
$searcherror = true;
}
 else{
 if (!($searcherror)){
 $result = mysql_query("INSERT INTO redaktorzy (`NickRed`, `NazwaDziennika`, `EdycjaAutora`, `EdycjaRedaktora`) VALUES ('".$nickred."', '".$nick."', 'NIE', 'NIE')");
 if ($result){
 $komunikaty .= '<font color="blue"><b>Użytkownik: '.$nickred.' <br> został dodany poprawnie. </b></font><br />';
 }
 else {
 echo ' '.mysql_error();
 }
 }
}
}
echo $komunikaty;
}

else{
echo 'Nie posiadasz swojego dziennika, możesz założyć go <a href="addDiary.php">TUTAJ</a><br />.';
}
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
?>