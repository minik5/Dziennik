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
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
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
<script>
$(document).ready(function(){
	$('.editpswER').hide();
	$('.editER').hide();
	$('.editpsw').click(function(){
	
	if ($("#oldpassword").val() == "" || $("#newpassword").val() == "" || $("#vnewpassword").val() == ""){
	$('.editpswER').show();
	}
	else{
	$('.editpswER').hide();
	var form_data = {
			oldpassword: $("#oldpassword").val(),
			newpassword: $("#newpassword").val(),
			vnewpassword: $("#vnewpassword").val(),
			pwd: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "edit2.php",
			data: form_data,
		}).done(function( response ) {
		$(".message").html(response);
		});
	}
	});
	$('.editProfile').click(function(){
	
	if ($("#acctpassword").val() == "" || $("#firstname").val() == "" || $("#surname").val() == "" || $("#email").val() == "" || $("#omnie").val() == "" || $("#datepicker").val() == ""){
	$('.editER').show();
	}
	else{
	$('.editER').hide();
	var form_data = {
			password: $("#acctpassword").val(),
			firstname: $("#firstname").val(),
			surname: $("#surname").val(),
			email: $("#email").val(),
			omnie: $("#omnie").val(),
			datepicker: $("#datepicker").val(),
			edit: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "edit2.php",
			data: form_data,
		}).done(function( response ) {
		$(".message").html(response);
		});
	}
	});
});
</script>
</head>
<body>
<div>
Witaj, <?php echo $nick;?>
	<fieldset>
	<legend>Edycja danych</legend><br>
	
	<div class="message"></div>
	<!-- ----------------------------------------------------------------- -->
	<!-- WAZNE!! -->
	<!-- w value powinno byc imie uzytkownika sciagane z bazy danych (php) -->
	<!-- ----------------------------------------------------------------- -->
	<div class="editER"><font color="red">Zapomniałeś o czymś?</font></div>
	<label for="firstname">Imie:</label>     <input type='text' value="<?php echo $imie;?>"  class='firstname' id='firstname' name='firstname' required="required"><br>
	<label for="surname">Nazwisko:</label>   <input type='text' value="<?php echo $nazwisko;?>" class='surname' id='surname' name='surname' required="required"><br>
	<label for="email">E-mail:</label>       <input type='email' value="<?php echo $email;?>" class='email' id='email' name='email' required="required" autocomplete="off"><br><br>
	<label for="omnie">O mnie:</label>       <input type='text' value="<?php echo $omnie;?>" class='omnie' id='omnie' name='omnie'><br><br>
	<label for="datepicker">Data Ur:</label> <input type='date'  class='datepicker' id='datepicker' name='datepicker' value="<?php echo $dataUr;?>" disabled="disabled"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIE' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' class='dData' id='dDate' name='dDate' value="<?php echo $dzien;?>" disabled="disabled"><br>
			<label for="mDateie">Miesiac: </label> <input type='text' class='mData' id='mDate' name='mDate' value="<?php echo $mies;?>" disabled="disabled"><br>
			<label for="yDateie">Rok:     </label> <input type='text' class='yData' id='yDate' name='yDate'value="<?php echo $rok;?>"  disabled="disabled"><br>
			<!-- -------------------------------------------------------------- -->
			</div>
	<label for="password">Potwierdz zmiany haslem:</label>	 <input type='password' value="" class='acctpassword' id='acctpassword' name='password' required="required"><br>
	<input type="submit" style="float:right" class="editProfile" name="edit" value="Zapisz zmiany">
	</fieldset>
</form>
</div>
<div id="container"> <!--(do srodka) |action="html_form_action.asp" method="get"| po nacisnieciu submit - wysyla dane do html_form_action.asp --> 
	<fieldset>
	<legend>Zmiana hasla</legend><br>
	<div class="message"></div>
	<!-- WAZNE!! -->
	<!-- w value powinno byc imie uzytkownika sciagane z bazy danych (php) -->
	<div class="editpswER"><font color="red">Zapomniałeś o czymś?</font></div>
	<label for="password">Stare Haslo:</label>	     <input type='password' value="" class='oldpassword' id='oldpassword' name='oldpassword' required="required"><br>
	<label for="password">Nowe haslo:</label>	     <input type='password' value="" class='newpassword' id='newpassword' name='newpassword' required="required"><br>
	<label for="password">Potwierdz haslo:</label>	 <input type='password' value="" class='vnewpassword' id='vnewpassword' name='vnewpassword' required="required"><br>
	
	<input type="submit" style="float:right" class="editpsw" name="pwd" value="Zapisz zmiany">
	</fieldset>
</div>
<!-- -->

<script>
	//wywolaj po otwarciu strony
	window.onload=dateFun ; 
</script>
</body>
<?php }
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="index.html">Zaloguj się</a><br>';
}
?>