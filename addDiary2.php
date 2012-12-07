<?php
session_start();
include("connection.php");
$komunikaty = '';
$stop = false;

/** Początek dodawania nowego dziennika **/
if (isset($_POST['wyslij']) && isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dzienniki WHERE IdDziennika='".$nick."' LIMIT 1"));
$nazwa = $_POST['name_diary'];
$options = $_POST['opt'];
$spr2 = strlen($nazwa);

if ($spr1[0]>=1){
$komunikaty.="Posiadasz już swój dziennik w systemie.<br />";
$stop = true;
}
else{
if ($spr2 < 4){
$komunikaty.="Nazwa dziennika powinna zawierać co najmniej 4 znaki.<br />";
}
if (!($komunikaty)){
if ($options == 'able'){
$opt = ''.'TAK';
}
else{
$opt = ''.'NIE';
}
$result = mysql_query("INSERT INTO `dzienniki` (IdDziennika, Komentarze, Nazwa) VALUES ('".$nick."','".$opt."','".$nazwa."')");

if ($result){
date_default_timezone_set("Europe/Warsaw");
$data = date('Y-m-d');
$zgl = mysql_query("INSERT INTO `zgloszenia` (NickUsera, Temat, Tresc, Url, DataZgl, StatusZgl) VALUES('$nick','dodanie dziennika','Proszę o dodanie dziennika do systemu','/adminAddDiary.php?id=$nick','$data','0')");
 $komunikaty.="<font color='blue'>Dziennik o nazwie ".$nazwa." został dodany.</font><br /> <b>Wymaga jeszcze akceptacji przez admina</b>";
 $_SESSION['dziennik']=$nick;
 $stop=true;
}
else { 
$komunikaty.=mysql_error();
}
}
}

echo $komunikaty;
/** Koniec dodawania nowego dziennika **/
}



?>