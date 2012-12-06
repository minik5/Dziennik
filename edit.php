<?php
session_start();
include ("connection.php");
?>

<?php
if (isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$r = mysql_fetch_array($query);
$imie = $r['Imie'];
$nazwisko = $r['Nazwisko'];
$email = $r['Email'];
$omnie = $r['OMnie'];
$dataUr = $r['DataUr'];
$dzien = substr($r['DataUr'],-2,2);
$mies = substr($r['DataUr'],5,2);
$rok = substr($r['DataUr'],0,4);


?>
<link href="Data/formECSS.css" type="text/css" rel="stylesheet"/>
<title>Multimedialny dziennik podróży - edycja danych.</title>

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
</head>
<body>
<div>
Witaj, <?php echo $nick;?>
<form name="input" method="post" action="edit.php"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
	<fieldset>
	<legend>Edycja danych</legend><br>
	
	<?php if (isset($komunikaty1) && (!isset($result1) || $result1 == FALSE)){ echo '<font color="red">'.$komunikaty1.'</font><br />';}
		  elseif (isset($komunikaty1)){ echo '<font color="blue">'.$komunikaty1.'</font><br />';}
	?>
	<!-- ----------------------------------------------------------------- -->
	<!-- WAZNE!! -->
	<!-- w value powinno byc imie uzytkownika sciagane z bazy danych (php) -->
	<!-- ----------------------------------------------------------------- -->
	
	<label for="firstname">Imie:</label>     <input type='text' value="<?php echo $imie;?>"  class='pData' id='firstname' name='firstname' required="required"><br>
	<label for="surname">Nazwisko:</label>   <input type='text' value="<?php echo $nazwisko;?>" class='pData' id='surname' name='surname' required="required"><br>
	<label for="email">E-mail:</label>       <input type='email' value="<?php echo $email;?>" class='pData' id='email' name='email' required="required" autocomplete="off"><br><br>
	<label for="omnie">O mnie:</label>       <input type='text' value="<?php echo $omnie;?>" class='pData' id='omnie' name='omnie'><br><br>
	<label for="datepicker">Data Ur:</label> <input type='date'  class='pData' id='datepicker' name='datepicker' value="<?php echo $dataUr;?>" disabled="disabled"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIE' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' class='pData' id='dDate' name='dDate' value="<?php echo $dzien;?>" disabled="disabled"><br>
			<label for="mDateie">Miesiac: </label> <input type='text' class='pData' id='mDate' name='mDate' value="<?php echo $mies;?>" disabled="disabled"><br>
			<label for="yDateie">Rok:     </label> <input type='text' class='pData' id='yDate' name='yDate'value="<?php echo $rok;?>"  disabled="disabled"><br>
			<!-- -------------------------------------------------------------- -->
			</div>
	<label for="password">Potwierdz zmiany haslem:</label>	 <input type='password' value="" class='pData' id='password' name='password' required="required"><br>
	<input type="submit" style="float:right" class="submit" name="edit" value="Zapisz zmiany">
	</fieldset>
</form>
</div>
<div id="container">
<form name="input" method="post" action="edit.php"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
	<fieldset>
	<legend>Zmiana hasla</legend><br>
	<?php if (isset($komunikaty) && (!isset($result) || $result == FALSE)){ echo '<font color="red">'.$komunikaty.'</font><br />';}
		  elseif (isset($komunikaty)){ echo '<font color="blue">'.$komunikaty.'</font><br />';}
	?>
	<!-- WAZNE!! -->
	<!-- w value powinno byc imie uzytkownika sciagane z bazy danych (php) -->
	
	<label for="password">Stare Haslo:</label>	     <input type='password' value="" class='pData' id='password' name='oldpassword' required="required"><br>
	<label for="password">Nowe haslo:</label>	     <input type='password'  class='pData' id='password' name='newpassword' required="required"><br>
	<label for="password">Potwierdz haslo:</label>	 <input type='password'  class='pData' id='password' name='vnewpassword' required="required"><br>
	
	<input type="submit" style="float:right" class="submit" name="pwd" value="Zapisz zmiany">
	</fieldset>
</form>
</div>
<!-- -->

<script>
	//wywolaj po otwarciu strony
	window.onload=dateFun ; 
</script>
</body>
<?php }
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
}
?>