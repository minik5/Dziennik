<?php
session_start();
include ("connection.php");
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}
?>

<?php
if ($_SESSION['zalogowany']){
if (isset($_POST['wyslij'])){
    $nick = $_POST['loginUser'];
} elseif (isset($_GET['userid'])){
 $nick = $_GET['userid'];
}
else {
    $nick = $_SESSION['login'];
}
$result = false;
if (isset($_GET['zgl']) && $_SESSION['dostep']==1){
$id = $_GET['zgl'];
//echo $id;
$page = curPageURL();
$zgloszenie = mysql_fetch_array(mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia ='$id'"));
//echo "/".$zgloszenie['Url']."&zgl=$id";
//echo ('<br />');
//echo $page;
if (isset($zgloszenie['Url']) && $zgloszenie['Url']."&zgl=$id" == $page){
$result = true;
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 1 WHERE IdZgloszenia ='$id'");
}
else{
$result = false;
}
}
$komunikaty = '';
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='".$nick."' LIMIT 1"));
echo mysql_error();
if ($spr1[0]<1){
    $komunikaty .= '<font color="red"><b>Użytkownik o podanym nicku nie istnieje</b></font>';
}
if (!($komunikaty)){
$query = mysql_query("SELECT * FROM uzytkownicy WHERE Nick = '".$nick."'");
$r = mysql_fetch_array($query);
$imie = $r['Imie'];
$nazwisko = $r['Nazwisko'];
$email = $r['Email'];
$omnie = $r['OMnie'];
$dataUr = $r['DataUr'];
$dataRej = $r['DataRej'];
$dziennik ="asd";
$query= mysql_query("SELECT * FROM dzienniki WHERE IdDziennika ='".$nick."'");
$spr = mysql_fetch_array($query,MYSQL_BOTH);
if ($spr[0] == 1){
$dziennik = $spr['Nazwa'];
}
}
?>

<link href="Data/formLCSS.css" type="text/css" rel="stylesheet"/>
<title>Multimedialny dziennik podróży - edycja danych.</title>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
	$("#deleteForm").hide();
	$('.dLinks').change(function(){
		zmien();
	}).change();
	function zmien(){
	var val = $('.dLinks option:selected').attr('dziennik');
	if (val != null){
	$('.rList').children('option').hide();
	$('.rList').children('option[filtr*="'+val+'"]').show(); 
	}
	else{
	$('.rList').children('option').show();
	}
	}
	$('.deleteBT').click(function(){
		var form_data = {
			username: $("#adminlogin").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		$.ajax({
			type: "POST",
			url: "pass.php",
			data: form_data,
		}).done(function( response ) {
		//alert(response);
                if(response == "﻿success"){
					var wartosc = [];
					$("#deleteForm2 :checked").each(function(){
					wartosc.push(this.value);
					});
					var del_data = {
					opt: wartosc,
					user: $("#nick").val(),
					is_ajax: 1
					
					};
					//$('input:checkbox').serializeArray()
					$.ajax({
					type: "POST",
					url: "delete.php",
					data: del_data,
					}).done(function (msg){
					if (msg == "﻿success"){
					$("#deleteForm2").slideUp('slow');
					$("#container").slideUp('slow');
					$("#zgloszenie").slideUp('slow');
					$("#deleteForm").slideUp('slow', function() {
						$("#message").html("<p class='success'><font color='blue'>Użytkownik poprawnie usunięty</font></p>");
					});
					$('.usunUser').attr('disabled', 'disabled');
					}
					else{
					alert(msg);
					//$("#message").html("<p class='error'><font color='red'>Wystąpił błąd</font></p>");
					}
					});
					}
				else
					$("#message").html("<p class='error'><font color='red'>Podano nieprawidłowe hasło.</font></p>");	
		});
		
		return false;
	});
	$('.usunUser').click(function(){
	$("#deleteForm").show();
	window.location = "#deleteForm";
	});
	
	$('.nagana').click(function(){
	window.location = "adminSendReport.php?user="+$("#nick").val();
	
	});
	
	});
	</script>
</head>
<body>
<div id="container">
<fieldset>
<?php echo $komunikaty; ?>
<legend>Profil użytkownika: <?php echo $nick; ?></legend><br>
<label for="firstname">Imie:</label>     <input type='text' value="<?php echo $imie;?>"  class='pData' id='firstname' name='firstname' disabled = "disabled"><br>
	<label for="surname">Nazwisko:</label>   <input type='text' value="<?php echo $nazwisko;?>" class='pData' id='surname' name='surname' disabled="disabled"><br>
	<label for="email">E-mail:</label>       <input type='email' value="<?php echo $email;?>" class='pData' id='email' name='email' disabled="disabled"><br><br>
	<label for="omnie">O mnie:</label>       <input type='text'  value="<?php echo $omnie;?>" class='pData' id='omnie' name='omnie' disabled = "disabled"><br><br>
	<label for="dataUr">Data urodzenia:</label>     <input type='text' value="<?php echo $dataUr;?>" class='pData'  id='dataur'  disabled = "disabled"><br><b>
	<label for="dataRej">Data rejestracji:</label>  <input type='text' value="<?php echo $dataRej;?>" class='pData'  disabled = "disabled"><br>
	<label for="dataRej">Prowadzony dziennik:</label> <input type="text" value="<?php echo $dziennik;?>"class='pData' id="DiaryName" name="nazwaDziennika" disabled="disabled"><br>
	
	<?php
	//**********WCZYTYWANIE LIST********************\\
	
	$query = mysql_query("SELECT * FROM redaktorzy WHERE NickRed='$nick'");
	$listaDziennikow ="";
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
		$listaDziennikow.= '<option id="'.$row['IdRed'].'" name="dziennik[]" dziennik="'.$row['NazwaDziennika'].'"value="'.$row['IdRed'].'">'.$row['NazwaDziennika'].'</option>';
		}
	$query2 = mysql_query("SELECT * FROM wpisy WHERE NickRed = '$nick'");
	$listaWpisow = "";
	while ($row = mysql_fetch_array($query2, MYSQL_BOTH)){
	$query2a = mysql_query("SELECT * FROM katalog WHERE IdKatalog = '".$row['IdKatalog']."'");
	$row2 = mysql_fetch_array($query2a, MYSQL_BOTH);
	$dziennik= $row2['IdDziennika'];
		$listaWpisow.= '<option id="'.$row['IdWpis'].'" filtr="'.$dziennik.'" name="wpis[]" value="'.$row['IdWpis'].'">['.$dziennik.'] ['.$row2['Katalog'].']['.$row['DataWpisu'].']</option>';
		}
	$query3 = mysql_query("SELECT * FROM ostrzezenia WHERE NickUser='$nick'");
	$listaOstrzezen ="";
	$i = 0;
	while ($row = mysql_fetch_array($query3, MYSQL_BOTH)){
		$i ++;
		$listaOstrzezen.= '<option id="'.$row['IDostrz'].'" name="ostrzezenie[]" value="'.$row['IDostrz'].'">['.$row['Data'].'] od ['.$row['NickUz'].']</option>';
		}
	?>
	<!-- lista powiazanych dziennikow -->
    <div id="listy">
				 <div id="box1">
				 <p> lista dziennikow</p>
					<select class="dLinks" name="dLinks" style="width:200px" size="5">
					<option><?php if ($listaDziennikow == ""){
					echo "Brak dzienników";
					}
					else{
					echo "*WSZYSTKIE DZIENNIKI*";
					}?></option>
					<?php echo $listaDziennikow; ?>
					</select>
				</div>
				<!-- lista wpisow -->
				<div id="box2">
				 <p> lista wpisow</p>
					<select class="rList" style="width:200px" size="10">
					<option><?php if ($listaWpisow == ""){
					echo "Brak wpisów";
					}
					else{
					echo "*WSZYSTKIE WPISY*";
					}?></option>
					<?php echo $listaWpisow; ?>
					</select>
				</div>
				<!-- ostrzezenia -->
				<div id="box3">
				 <p> lista ostrzezen</p>
					<select class="repList" style="width:200px" size="6">
					<option><?php if ($listaOstrzezen == ""){
					echo "Brak ostrzeżeń";
					}
					else{
					echo "*RAZEM ".$i." OSTRZEŻEŃ*";
					}?></option>
					<?php echo $listaOstrzezen; ?>
					</select>
				</div>
				</div>
			
</fieldset>
	</div>
	<?php if (isset($_SESSION['dostep']) && $_SESSION['dostep'] ==1 ){
		  if(isset($zgloszenie)){
	?>
	<div id="zgloszenie">
	<br> Zgłoszenie dotyczące :<font color="green"></b> <?php echo $zgloszenie['Temat']?></font><br>
	<?php }
	?>
	Wybierz działanie<br>
	<input type="submit" class="nagana" id="nagana" name="nagana" value ="Dodaj naganę">
	<input type="submit" class="usunUser" id="usunUser" name="usunUser" value ="Usuń użytkownika">
	<?php
	
	if (isset($_GET['zgl']) && $result == true){
	?>
	</div>
	<form action="adminReportPage.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="submit" class="zamknij" id="zamknij" name="zamknij" value ="Zamknij zgłoszenie">
	</form>
	<div id="message"></div>
	<div id="delete">
	<fieldset id="deleteForm">
    <legend>Usuwanie usera: <?php echo $nick; ?></legend>
	<form id="deleteForm2" action="adminReportPage.php" method="POST">
	<input type="hidden" name="nick" id="nick" value="<?php echo $nick;?>">
	<input type="hidden" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="hidden" id="adminlogin" name="adminlogin" value="<?php echo $_SESSION['login']; ?>">
	<b>Zaznacz opcje do usunięcia:</b><br>
	<input type="checkbox" id="opt" value="dziennik" checked="true" disabled="disabled"> Dziennik autora wraz z wpisami<br>
	<input type="checkbox" id="opt" value="wpisy"> Wszystkie wpisy w systemie jako Redaktor<br>
	<b>Podaj swoje hasło</b><br>	<input type="password" id="password" name="password" value="" required="required"><br>
	<input type="submit" class="deleteBT" id="deleteBT" name="deleteBT" value="Potwierdź usunęcie">
	</fieldset>
	</form>
	</div>
	<?php
	}
    }
	elseif (isset($_GET['zgl']) && $result == false){
	echo "<br /> Brak zgodności wybranego zgłoszenia z widocznym profilem lub nie posiadasz uprawnień administratora.";
	}
	
	?>
</body>
<?php 
} else {
    echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>';
}
?>
