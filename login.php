<?php
session_start();
include ("connection.php");

/** W sesji przesyłane są:
zalogowany = true - może mieć dalsze zastosowanie, u mnie nie ma. Sesja po wylogowaniu zostaje zniszczona.
login - login/nick danego usera
dostep - dostęp do naszego serwisu, domyślnie na razie jest to 0, ale zostanie zmienione na 1 (user), 2(admin), 3(superadmin)

**/

if(isset($_SESSION['zalogowany'])) {

echo "From Session <br />";
$login = $_SESSION['login'];
$dziennik = $_SESSION['dziennik'];
echo $login." Zostałeś poprawnie zalogowany.<br /> Twój poziom dostępu to ".$_SESSION['dostep']." </br> Masz dziennik: ".$dziennik;
		   echo('<br /><a href="userPage2.html">Kliknij tutaj, aby przejść dalej</a>');
}else{
if(isset($_POST['wyslij'])) {
$login = $_POST['login'];
$haslo = $_POST['password'];
$haslo = md5($haslo);
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$login."' && Haslo = '".$haslo."' ");
  if(mysql_num_rows($query) > 0) {

	       $r = mysql_fetch_array($query);
           $_SESSION['zalogowany'] = true;
           $_SESSION['login'] = $login;
		   $_SESSION['dostep']= $r['Dostep'];
		   $spr1 = mysql_query("SELECT * FROM dzienniki WHERE IdDziennika ='".$login."'");
		   if (mysql_num_rows($spr1) > 0){
		   $_SESSION['dziennik'] = $login;
		   }
		   else {
		   $_SESSION['dziennik'] ='0';
		   }
		   echo header("Location: userPage2.html");
		   echo $_SESSION['dziennik']."<br />";
           echo $login." <br />Zostałeś poprawnie zalogowany.<br /> Twój poziom dostępu to ".$_SESSION['dostep']." </br>";
		   echo('<a href="userPage2.html">Kliknij tutaj, aby przejść dalej</a>');

       } else { 
	print '<p>Zle dane</p>';
	
 }
 } 
 if(!isset($_SESSION['zalogowany'])) {
 
?>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
		$('#div1').delay(50).fadeIn("slow");
		$('#div2').delay(150).fadeIn("slow");
		$('#div3').delay(250).fadeIn("slow");
		$('#div4').delay(350).fadeIn("slow");
	}, 300); // <-- time in milliseconds
	
});
</script>

<title>Multimedialny dziennik podróży - logowanie.</title>
<div id="altBody">

<div id="container">
<form name="input" method="post" action="login.php"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
    <fieldset style="width:210px;">
    <label for="loginname">Login: </label>    <input type='text'  class='lData' id='loginname' name='login' required="required"><br>
    <label for="password">Hasło: </label>     <input type='password'  class='lData' id='password' name='password' required="required"><br>
    <a href="stonaPrzypomienia.html" style="float:right">Przypomnienie hasła</a><br>
    <a id="regFromLog" href="index.html" style="float:right">Rejestracja</a><br>
    <input type="submit" class="submit" name="wyslij" value="Zaloguj">
    </fieldset>
</form>
</div>
<div id="div1" style="width:50px;height:50px;background-color:green;margin-left:10px;margin-top:10px;float:left; display:none;">
</div>
<div id="div2" style="width:50px;height:50px;background-color:red;margin-left:10px;margin-top:10px;float:left; display:none;">
</div>
<div id="div3" style="width:50px;height:50px;background-color:blue;margin-left:10px;margin-top:10px;float:left; display:none;">
</div>
<div id="div4" style="width:50px;height:50px;background-color:yellow;margin-left:10px;margin-top:10px;float:left; display:none;">
</div>
</div>

<?php
}
}
?>
