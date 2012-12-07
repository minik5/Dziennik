<?php
session_start();
include ("connection.php");

if (isset($_SESSION['zalogowany'])){

if (isset($_POST['wyslij'])){
$nick = $_SESSION['login'];
$tresc = $_POST['zgloszenie_txt'];
$temat = $_POST['report'];
$komunikaty = '';
date_default_timezone_set("Europe/Warsaw");
$data = date('Y-m-d');

$spr1 = strlen($tresc);
$spr3 = mysql_num_rows(mysql_query("SELECT * FROM zgloszenia WHERE NickUsera='".$nick."' AND 
Temat='dodanie dziennika' AND StatusZgl<>2"));
$spr4 = mysql_num_rows(mysql_query("SELECT * FROM zgloszenia WHERE NickUsera='".$nick."' AND 
Temat='usunięcie konta' AND StatusZgl<>2"));
$spr5 = mysql_num_rows(mysql_query("SELECT * FROM zgloszenia WHERE NickUsera='".$nick."' AND 
Temat='usunięcie dziennika' AND StatusZgl<>2"));
echo ($spr3." ".$spr4." ".$spr5);
if($spr1 < 3){
$komunikaty = "Zgloszenie musi miec min. 3 znaki. Uzupelnij formularz.<br>";
echo '<br><span style="color: red; font-weight: bold;">'.$komunikaty.'</span><br>';
}
	elseif(($spr3 > 0 && $temat =="dodanie dziennika") || ($spr4 > 0 && $temat=="usunięcie konta") || ($spr5 > 0 && $temat=="usunięcie dziennika")){
	$komunikaty .= '<font color="red"><b>Zgloszenie o podanym temacie: '.$temat.' <br>już istnieje i czeka na decyzję administratora. </b></font>';
	}
if ($komunikaty) {
echo $komunikaty;
echo '<br><a href="index.php">Strona glowna</a>';
exit;
} else {
if ($temat == "błędny wpis" || $temat == "błędny komentarz"){

if ($temat == "błędny wpis"){
$url = "/adminShowReg.php?IdWpisu=".$_POST['idwpis'];
}
else{
$url = "/showComments.php?idkom=".$_POST['idkom'];
}
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM zgloszenia WHERE NickUsera='".$nick."' AND Url = '".$url."' AND 
Temat='$temat' LIMIT 1"));
if($spr2[0] > 0){
	$komunikaty .= '<font color="red"><b>Zgloszenie o podanym temacie: '.$temat.' <br>już istnieje i czeka na decyzję administratora. </b></font>';
	}
if ($komunikaty) {
echo $komunikaty;
exit;
}
else{
$result = mysql_query("INSERT INTO `zgloszenia` (NickUsera, Temat, Tresc,  DataZgl, StatusZgl, Url) VALUES('$nick','$temat','$tresc','$data','0','$url')") or die("Nie mogłem dodac zgloszenia !".mysql_error());
}
}
else{
//jesli wszystko jest ok wysylamy zgloszenie 
$result = mysql_query("INSERT INTO `zgloszenia` (NickUsera, Temat, Tresc,  DataZgl, StatusZgl) VALUES('$nick','$temat','$tresc','$data','0')") or die("Nie mogłem dodac zgloszenia !".mysql_error());
}
if (isset($result) && $result){
echo '<br><span style="color: green; font-weight: bold;">Zgloszenie zostalo wyslane. </span><br>';
exit;
}
}
}


}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="index.html">Zaloguj się</a><br>';
}
?>