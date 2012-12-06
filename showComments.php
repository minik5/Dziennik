<?php

function show($variable){
$komentarze = mysql_query("SELECT * FROM komentarze WHERE IdWpisu=".$variable."");

echo '<head><link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css"></head>';

echo 'Komentarze</br>';
echo '<hr size="1" align="left" width="340px" color="#DDDDDD">';
while ($row = mysql_fetch_array($komentarze, MYSQL_BOTH)){
$var = strlen($row['Tresc'])/40;
//echo ''.$var;
echo'<textarea style="color:black; border:0; resize:none;"  name="komentarz" id="komentarz" rows="'.ceil($var).'"  cols="40" readonly="readonly">';
echo ''.$row['IdUser'].': '.$row['Tresc'];
echo '</textarea></br>';
echo '<a style="color:blue;text-align:right;font-family:Times New Roman,serif;font-size:11" href="reportForm.php?idkom="'.$row["IdKom"].'">Zgłoś</a>  ';
$user = $_SESSION['login'];
if($user==$row['IdUser']){
echo '<a href="editComment.php?IdKom='.$row['IdKom'].'">Edytuj</a><br />';}
echo '<hr size="1" align="left" width="340px" color="#DDDDDD">';

}
}
if (isset($_GET['idkom']) && isset($_GET['zgl'])) {
session_start();

if (isset($_SESSION['dostep']) && $_SESSION['dostep']==1) {

include ("connection.php");
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}
if (isset($_GET['idkom']) && isset($_GET['zgl'])) {
$idkom = $_GET['idkom'];
$id = $_GET['zgl'];
$page = curPageURL();
$zgloszenie = mysql_fetch_array(mysql_query("SELECT * FROM zgloszenia WHERE IdZgloszenia ='$id'"));
if (isset($zgloszenie['Url']) && $zgloszenie['Url']."&zgl=$id" == $page){
$update = mysql_query("UPDATE zgloszenia SET StatusZgl = 1 WHERE IdZgloszenia ='$id'");
$row= mysql_fetch_array(mysql_query("SELECT * FROM komentarze WHERE idkom = '$idkom'"));
$var = strlen($row['Tresc'])/40;
//echo ''.$var;
echo'<div="container"<textarea style="color:black; border:0; resize:none;"  name="komentarz" id="komentarz" rows="'.ceil($var).'"  cols="40" readonly="readonly">';
echo ''.$row['IdUser'].': '.$row['Tresc'];
echo '</textarea></br></div>';
$nick=$row['IdUser'];
?>
<html>
<head>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
	$("#deleteForm").hide();
	$('.deleteBT').click(function(){
	alert ($("#id").val());
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
					var del_data = {
					idkom: $("#idkom").val(),
					zgl: $("#id").val(),
					is_kom: 1
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
						$("#message").html("<p class='success'><font color='blue'>Komentarz poprawnie usunięty</font></p>");
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

<input type="hidden" name="nick" id="nick" value="<?php echo $nick;?>">

	Wybierz działanie<br>
	<input type="submit" class="nagana" id="nagana" name="nagana" value ="Dodaj naganę">
	<input type="submit" class="usunUser" id="usunUser" name="usunUser" value ="Usuń komentarz">
	<form action="adminReportPage.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="submit" class="zamknij" id="zamknij" name="zamknij" value ="Zamknij zgłoszenie">
	</form>
	<div id="message"></div>
	<div id="delete">
	<fieldset id="deleteForm">
	<form id="deleteForm2" action="" method="POST">
	<input type="hidden" name="idkom" id="idkom" value="<?php echo $idkom;?>">
	<input type="hidden" id="id" name="id" value="<?php echo $zgloszenie['IdZgloszenia']; ?>">
	<input type="hidden" id="adminlogin" name="adminlogin" value="<?php echo $_SESSION['login']; ?>">
	<b>Podaj swoje hasło</b><br>	<input type="password" id="password" name="password" value="" required="required"><br>
	<input type="submit" class="deleteBT" id="deleteBT" name="deleteBT" value="Potwierdź usunęcie">
</body></html>
<?php
}
else{ '<br><span style="color: red; font-weight: bold;">Nieprawidłowe zgłoszenie.</span><br>';
}
}
}
}
?>