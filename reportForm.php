<?php
session_start();
include ("connection.php");

if (isset($_SESSION['zalogowany'])){



?>
<html>
<head>

<title>Dodawanie zgloszenia</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.wyslij').click(function(){
	var form_data = {
			zgloszenie_txt: $("#zgloszenie_txt").val(),
			report: $("#report").val(),
			idwpis: $("#idwpis").val(),
			idkom: $("#idkom").val(),
			wyslij: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "reportForm2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		//$('.wyslij').hide();
		});
	
	});
	
});
</script>
</head>
<body>

<div id="message"></div>
<div id="inside">

<h4>Zgloszenie</h4>
<p>Rodzaj zgloszenia</p>

<?php if (isset ($_GET['idWpisu'])){
?>
<input type="hidden" id="idwpis" name="idwpis" value="<?php echo $_GET['idWpisu']; ?>">
<select id="report" name="report">
<option value="błędny wpis" selected="selected" >Bledny wpis</option>
<?php
}
else{
?>
<?php if (isset ($_GET['idkom'])){
?>
<input type="hidden" id="idkom" name="idkom" value="<?php echo $_GET['idkom']; ?>">
<select id="report" name="report">
<option value="błędny komentarz" selected="selected" >Bledny komentarz</option>
<?php
}
else{
?>
<select id="report" name="report">
<option value="usunięcie konta">Usuniecie konta</option>
<option value="usunięcie dziennika">Usuniecie dziennika</option>
<?php 
}
}
?>
</select>

<p>Tresc zgloszenia</p>
<textarea style="color:grey; resize:none;" name="zgloszenie_txt" id="zgloszenie_txt" rows="10"  cols="30" required="required">
</textarea><br>
<input type="submit" class="wyslij" name="wyslij" value="Wyslij">

</div>
</body>

</html>
<?php
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="index.html">Zaloguj się</a><br>';
}
?>