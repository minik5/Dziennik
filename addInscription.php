﻿<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który dodaje wpis
 dziennik - idDziennika, do którego wpis jest dodawany
Czyli przed wywołaniem skryptu trzeba dodał do sesji 'dziennik'!
  
 * Po przeanalizowaniu bazy uznałem, że gdy wpis dodaje autor pole NickRed zostaje puste.
 (Ewentualnie można przerobić zeby zawsze dodawac nick osoby dodającej wpis.)
 
 **/
if (isset ($_SESSION['zalogowany'])){
if (isset($_SESSION['dziennik']) && strlen($_SESSION['dziennik'])>1) {
    $login = $_SESSION['login'];
    $dziennik = $_SESSION['dziennik'];

$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");

$error = false;
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
if (!$error){

?>
<html>
<head>
<title>Multimedialny dziennik podróży - dodawanie zdarzenia.</title>        
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$(".cos1").hide();
	$(".cos2").hide();
	$('.dodajWpis').click(function(){
	if ($("#title").val() ==""){
	$('.cos1').show();
	}
	else{
	$('.cos1').hide();
	}
	if ($("#inscription").val() == ""){
	$('.cos2').show();
	}
	else{
	$('.cos2').hide();
	}
	if ($("#title").val() !="" && $("#inscription").val() != ""){
	var form_data = {
			title: $("#title").val(),
			inscription: $("#inscription").val(),
			trip: $("#trip").val(),
			submit: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addInscription2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	}
	});
	$('.costrip').click(function(){
	$('.insideDiv').load('addTrip.php');
	});
	$('.clearing').click(function(){
	$("#title").attr('value','');
	$("#inscription").attr('value','');
	});
	
});
</script>
</head>
<body>
<?php //include ("ckeditor.php"); ?>
<div id="message"></div>
<table>        
    <th>         
    <td>            
        <p><label for="title">Podróż: </label> 
          <?php
            $podroze = mysql_query("SELECT * FROM Katalog WHERE IdDziennika='$dziennik'");
            if (mysql_num_rows($podroze)>0) {
                echo "<select id='trip' name='trip'>";
                while ($podroz=mysql_fetch_assoc($podroze)) echo '<option>'.$podroz['Katalog'].'</option>';
                echo "</select>";
            }
          ?>
            <button type="button" class="costrip">Dodaj podróż</button>
        </p>
        <p><label for="title">Tytuł zdarzenia: </label>   
			<div class="cos1"><font color="red">Podaj tytuł</font></div>
            <input type="text" id="title" name="title" size="30" autofocus required="required"/>                                  
        </p>                
        <p><label for="inscription">Wpis: </label></p>     
			<div class="cos2"><font color="red">Wpisz treść</font></div>	
        <p><textarea class="ckeditor" id="inscription"name="inscription" rows="20" cols="60"/></textarea></p>                
        <p class="center">                    
           <input type="submit" class="clearing" name="reset" value="Wyczyść pola"/>                  
           <input type="submit" class="dodajWpis" name="submit" value="Zapisz"/>                
        </p>                    
    </td>           
    </th>        
</table>
</body>
</html>
<?php
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
}else {
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="index.html">Zaloguj się</a><br>';

}
?>