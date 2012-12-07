﻿<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który edytuje wpis
 * Z GET'a pobiera:
 IdWpisu - id wpisu, który będziemy edytować
  
 * Trzeba przemyśleć, czy będziemy chcieli gdzieś zapamitywać datę i autora korekty.
 * Trzeba by jeszcze dorobić jakiś Messege box do deleta. 
 * Po delejcie powrót do indexa by się przydać
 
 **/
if (isset($_GET['idWpisu']) && (isset($_SESSION['dziennik']))){
$idWpisu = $_GET['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];

$query = mysql_query("SELECT * FROM wpisy w LEFT JOIN katalog k ON w.IdKatalog=k.IdKatalog WHERE IdWpis='$idWpisu'");
$spr1 = mysql_query ("SELECT * FROM redaktorzy WHERE NazwaDziennika='$dziennik' AND NickRed = '$nick'");

if (mysql_num_rows($query)==1) {
    $result = mysql_fetch_array($query);
    if (mysql_num_rows($spr1) == 1 || $result['IdDziennika'] == $nick){
	$red = mysql_fetch_array($spr1);
	if ($red['EdycjaAutora']=='TAK' && $result['IdDziennika'] == $result['NickRed'] || $red['EdycjaRedaktora'] =='TAK' && $result['NickRed'] != $result['IdDziennika'] || $result['IdDziennika'] == $nick){
            $tytul = $result['Tytul'];
            $wpis = $result['Tresc']; 
            $IdKatalogu = $result['IdKatalog'];
?>

<link href="" type="text/css" rel="stylesheet"/>   
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('#coser').hide();
	$('.editclick').click(function(){
	if ($("#title").val() == ""){
	$('#coser').show();
	}
	else{
	$('#coser').hide();
	var form_data = {
			title: $("#title").val(),
			inscription: $("#inscription").val(),
			trip: $("#trip").val(),
			submit: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "editInscription2.php?idWpisu="+$("#idWpisu").val(),
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	}
	});
	$('.deleteclick').click(function(){
	var form_data = {
			delete: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "editInscription2.php?idWpisu="+$("#idWpisu").val(),
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	});
	$('.costrip').click(function(){
	$('.insideDiv').load('addTrip.php');
	});
	$('.clearing').click(function(){
	$("#title").attr('value','');
	$("#inscription").attr('value','');
	});
	$(".gotoPhoto").click(function(){
	$('.insideDiv').load('addPhoto.php?idWpisu='+$("#idWpisu").val());
	});
	
	
});
</script>
<?php //include("ckeditor.php"); ?>

<title>Multimedialny dziennik podróży - edycja zdarzenia.</title> 
<div id="message"></div>       
<table>        
    <th>         
    <td>            
	<input type="hidden" id="idWpisu" value="<?php echo $idWpisu;?>">
        <p><label for="title">Podróż: </label> 
          <?php
            $podroze = mysql_query("SELECT * FROM Katalog WHERE IdDziennika='$dziennik'");
            if (mysql_num_rows($podroze)>0) {
                echo "<select id='trip' name='trip'>";
                while ($podroz=mysql_fetch_assoc($podroze)) {
                    if ($IdKatalogu!=$podroz['IdKatalog']) echo '<option>'.$podroz['Katalog'].'</option>';
                    else echo '<option selected="selected">'.$podroz['Katalog'].'</option>';
                }
                echo "</select>";
            }
          ?>
            <button type="button" class="costrip">Dodaj podróż</button>
        </p>
		<div id="coser"><font color="red"><b>Podaj tytuł wycieczki</b></font></div> 
        <p><label for="title">Tytuł zdarzenia: </label></p>  
        <p> <input type="text" id="title" name="title" value="<?php echo $tytul;?>" size="30" autofocus required/>                                     
        </p>                
        <p><label for="inscription">Wpis: </label></p>                
        <p><textarea class="ckeditor" id="inscription" name="inscription" rows="20" cols="60" /><?php echo $wpis;?></textarea></p>                
        <p class="center">                    
           <input type="submit" class="clearing" name="reset" value="Wyczyść pola"/>                    
           <input type="submit" class="editclick" name="submit" value="Zapisz"/>
           <input type="submit" class="deleteclick" name="delete" value="Usuń"/>
        </p>            
    </td>           
    </th>        
    <th>                    
        <table>               
        <tr><td><label>Załącz multimedia: </label></td></tr>            
        <tr><td>
		<input type="submit" class="gotoPhoto" name="wpis" value="Przejdź do galerii zdjęć"></td></tr>                        
        </table>
    </th>
</table>

<?php
} else {
$tytul = "";
$wpis = "";
echo '<br><span style="color: red; font-weight: bold;">Nie masz uprawnień do edycji tego wpisu.</span><br>' ;
} 
} else {
$tytul = "";
$wpis = "";
echo '<br><span style="color: red; font-weight: bold;">Nie masz uprawnień do edycji tego wpisu.</span><br>' ;
}

} else {
    $tytul = "";
    $wpis = "";
    echo '<br><span style="color: red; font-weight: bold;">Brak wpisu w bazie lub nie należy on do wybranego dziennika.</span><br>' ;
}   
} else {
 echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, który ma być edytowany!</span><br>' ;
}