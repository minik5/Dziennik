<?php 
include("connection.php");

/**
Haslo jest kodowane md5, więc jakby zaistniała potrzeba wykorzystywania porównania hasła, 
pamiętać o zakodowaniu wpisanego przez usera i porównaniu ciągu znaków z bazą

*/

if (isset($_GET['id'])){
$id = $_GET['id'];
	if ($id == 'reg') {

$nick = $_POST["nickname"];
$haslo = $_POST["password"];
$vhaslo = $_POST["password2"];
$imie = $_POST["firstname"];
$nazwisko = $_POST["surname"];
$email = $_POST["email"];



$spr6a = is_numeric($_POST["dDate"]);
$spr7a = is_numeric($_POST["mDate"]);
$spr8a = is_numeric ($_POST["yDate"]);

$dzien = (int)$_POST["dDate"];


$mies = (int)$_POST["mDate"];


$rok = (int)$_POST["yDate"];


$data= $_POST["datepicker"];
//kilka sprawdzen co do nicku i maila
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM Uzytkownicy WHERE Nick='$nick' LIMIT 1")); //czy user o takim nicku istnieje
$spr2 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM Uzytkownicy WHERE Email='$email' LIMIT 1")); // czy user o takim emailu istnieje
$komunikaty = '';
$spr4 = strlen($nick);
$spr5 = strlen($haslo);
date_default_timezone_set("Europe/Warsaw"); 

//sprawdzenie co uzytkownik zle zrobil
if ($spr4 < 4) {
$komunikaty .= "Login musi mieć przynajmniej 4 znaki<br>"; }
if ($spr5 < 4) {
$komunikaty .= "Hasło musi mieć przynajmniej 4 znaki<br>"; }
if ($spr1[0] >= 1) {
$komunikaty .= "Ten login jest zajęty!<br>"; }
if ($spr2[0] >= 1) {
$komunikaty .= "Ten e-mail jest już używany!<br>"; }
if ($haslo != $vhaslo) {
$komunikaty .= "Hasła się nie zgadzają ...<br>";}
if ($data == NULL){
if (!($spr8a)){
$komunikaty .= "Nieprawidłowy format roku <br>";
}
elseif($rok <= 1900 || $rok > date(Y)){
$komunikaty .= "Nieprawidłowy rok <br>";
}
elseif (!($spr7a)){
$komunikaty .= "Nieprawidłowy format miesiąca <br>";
}
elseif (!($spr6a)){
$komunikaty .= "Nieprawidłowy format dnia <br>";
}
elseif(!checkdate($dzien, $mies, $rok)){
 $komunikaty .= "Nieprawidłowa data <br>";
}
}
if ($data==NULL && spr6a && spr7a && spr8a){
$data = ($rok.'-'.$mies.'-'.$dzien);
}
$teraz = date("Y-m-d");




//jesli cos jest nie tak to blokuje rejestracje i wyswietla bledy
if ($komunikaty) {
echo '
<b>Rejestracja nie powiodła się, popraw następujące błędy:</b><br>
'.$komunikaty.'<br>';
} else {
//jesli wszystko jest ok dodaje uzytkownika i wyswietla informacje
$haslo = md5($haslo); //szyfrowanie hasla

mysql_query("INSERT INTO `uzytkownicy` (Nick, Haslo, Imie, Nazwisko, Email, Dostep, DataRej, KodIdent, OMnie, DataUr) VALUES('$nick','$haslo','$imie','$nazwisko','$email','0','$teraz','0','Tutaj wpisz informację o sobie','$data')") or die("Nie mogłem Cie zarejestrować !".mysql_error());

echo '<br><span style="color: green; font-weight: bold;">Zostałeś zarejestrowany '.$nick.'. Teraz możesz się zalogować</span><br>';
echo '<br><a href="login.php">Logowanie</a>';
}
}
}
?>
<link href="Data/formRCSS.css" type="text/css" rel="stylesheet"/>
<title>Multimedialny dziennik podróży - rejestracja.</title>
<script language="javascript">  
function dateFun(){
   var datefield=document.createElement("input")
   datefield.setAttribute("type", "date")
       if(datefield.type!="date"){ //sprawdza czy przegladarka obsluguje input type="date"
               alert("Do przeglądania tej strony polecamy przeglądarkę Google Chrome!");
               document.getElementById('datepicker').style.display='none';
               document.getElementById('dateIE').style.display='block';
               
               document.getElementById('dDate').required=true;
               document.getElementById('mDate').required=true;
               document.getElementById('yDate').required=true;
       }
       else{
               document.getElementById('datepicker').required=true;
       }
}
</script>  
<div id="container" >
<form method="post" action="register.php?id=reg"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
	<fieldset>
	<legend>Wpisz swoje dane</legend><br>
	<label for="nickname">Nick:</label>      <input type='text' maxlength="20" class='pData' id='nickname' name='nickname' value="<?php if (isset($nick)){echo $nick;}?>" required="required" autofocus='autofocus'><br>
	<label for="password">Hasło:</label>	 <input type='password' maxlength="20"  class='pData' id='password' name='password' required="required"><br>
	<label for="password2">Powtórz hasło:</label>	 <input type='password' maxlength="20"  class='pData' id='password2' name='password2' required="required"><br>
	<label for="firstname">Imię:</label>     <input type='text' maxlength="30"  class='pData' id='firstname' name='firstname' value="<?php if (isset($nick)){echo $imie;}?>" required="required"><br>
	<label for="surname">Nazwisko:</label>   <input type='text' maxlength="30"  class='pData' id='surname' name='surname' value="<?php if (isset($nick)){echo $nazwisko;}?>"required="required"><br>
	<label for="email">E-mail:</label>       <input type='email' maxlength="30" class='pData' id='email' name='email' value="<?php if (isset($nick)){echo $email;}?>" required="required" autocomplete="off"><br><br>
	<label for="datepicker">Data ur.:</label> <input type='date'  class='pData' id='datepicker' name='datepicker' value="<?php if (isset($nick)){echo $data;}?>"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIE' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' class='pData' id='dDate' name='dDate' value="<?php if (isset($nick)){echo $dzien;}?>"><br>
			<label for="mDateie">Miesiac: </label> <input type='text' class='pData' id='mDate' name='mDate' value="<?php if (isset($nick)){echo $mies;}?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' class='pData' id='yDate' name='yDate'value="<?php if (isset($nick)){echo $rok;}?>" ><br>
			<!-- -------------------------------------------------------------- -->
			</div>
			<br><br>
	<input type="submit" class="submit" value="Submit">
	</fieldset>
</form>
</div>
<!-- -->

<script>
	//wywolaj po otwarciu strony
	window.onload=dateFun ; 
</script>

