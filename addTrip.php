﻿<?php
session_start();
include("connection.php");
include("getbrowser.php");

if (isset($_SESSION['dziennik'])) {
$login = $_SESSION['login'];

// Sprawdzanie czy dziennik został zaakceptowany przez admina
$error = false;
if ($_SESSION['dziennik'] == $login){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
    date_default_timezone_set("Europe/Warsaw");
$dzien = date('d');
$mies = date('m');
$rok = date('Y');
$dataRoz = date("Y-m-d");
$dzienZak = NULL;
$miesZak = NULL;
$rokZak = NULL;
$dataZak = NULL;
$tytul="";
$opis="";

?>

<link href="" type="text/css" rel="stylesheet"/>      
<title>Multimedialny dziennik podróży - dodawanie wycieczki.</title>  
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('#coser').hide();
	$('.dodajTrip').click(function(){
	if ($("#title").val() == ""){
	$('#coser').show();
	}
	else{
	$('#coser').hide();
	var form_data = {
			title: $("#title").val(),
			trip: $("#trip").val(),
			dDateRoz: $("#dDateRoz").val(),
			mDateRoz: $("#mDateRoz").val(),
			yDateRoz: $("#yDateRoz").val(),
			dDateZak: $("#dDateZak").val(),
			mDateZak: $("#mDateZak").val(),
			yDateZak: $("#yDateZak").val(),
			datepickerRoz: $("#datepickerRoz").val(),
			datepickerZak: $("#datepickerZak").val(),
			submit: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addTrip2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	}
	});
	
});
</script>
<?php include ("ckeditor.php"); ?>

<script language="javascript">  
function dateFun(){
   var datefield=document.createElement("input")
   datefield.setAttribute("type", "date")
       if(datefield.type!="date"){ //sprawdza czy przegladarka obsluguje input type="date"
               document.getElementById('datepickerRoz').style.display='none';
               document.getElementById('dateIERoz').style.display='block';
               
               document.getElementById('dDateRoz').required=true;
               document.getElementById('mDateRoz').required=true;
               document.getElementById('yDateRoz').required=true;
               
               document.getElementById('datepickerZak').style.display='none';
               document.getElementById('dateIEZak').style.display='block';
               
               document.getElementById('dDateZak').required=true;
               document.getElementById('mDateZak').required=true;
               document.getElementById('yDateZak').required=true;
       }
       else{
               document.getElementById('datepickerRoz').required=true;        
               document.getElementById('datepickerZak').required=true;
       }
}
</script>  
   
  <div id="message"></div>
<div id="container" >        
<div id="coser"><font color="red"><b>Podaj tytuł wycieczki</b></font></div>        
<p><label for="title">Tytuł wycieczki: </label></p>                
<p> <input type="text" id="title" name="title" size="30" autofocus required="required" value="<?php echo $tytul; ?>"/>  </p> 
<label for="datepickerRoz">Data rozpoczęcia:</label> 
<input type='date' class='pDataRoz' id='datepickerRoz' name='datepickerRoz' value="<?php echo $dataRoz;?>"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIERoz' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' id='dDateRoz' name='dDateRoz' value="<?php echo $dzien;?>"><br>
			<label for="mDateie">Miesiąc: </label> <input type='text' id='mDateRoz' name='mDateRoz' value="<?php echo $mies;?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' id='yDateRoz' name='yDateRoz' value="<?php echo $rok;?>" ><br>
                        <br>
			<!-- -------------------------------------------------------------- -->
			</div>
<label for="datepickerZak">Data zakonczenia:</label> 
<input type='date' class='pDataZak' id='datepickerZak' name='datepickerZak' value="<?php echo $dataZak;?>"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIEZak' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' id='dDateZak' name='dDateZak' value="<?php echo $dzienZak;?>"><br>
			<label for="mDateie">Miesiąc: </label> <input type='text' id='mDateZak' name='mDateZak' value="<?php echo $miesZak;?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' id='yDateZak' name='yDateZak' value="<?php echo $rokZak;?>"><br>
			<!-- -------------------------------------------------------------- -->
			</div>
<p><label for="trip">Opis: </label></p>                
<p><textarea class="ckeditor" name="trip" rows="20" cols="60" /><?php echo $opis; ?></textarea></p>                
<p class="center">                    
   <input type="reset" value="Wyczyść pola"/>                    
   <input id="addTrip" type="submit" class="dodajTrip" name="submit" value="Zapisz"/>              
</p>            
</form> 
</div>
<script>
	//wywolaj po otwarciu strony
	window.onload=dateFun ; 
</script>
<?php
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
?>