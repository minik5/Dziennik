<?php
session_start();
include ("connection.php");
?>

<?php
$komunikaty ="";
if (isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dzienniki WHERE IdDziennika='".$nick."' LIMIT 1"));
if ($spr1[0]>=1 && !isset($result)){
$komunikaty.="Posiadasz już swój dziennik w systemie.<br />";
$stop = true;
}
?>
<title>Strona głowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssFP.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.dodaj').click(function(){
	var form_data = {
			name_diary: $("#newDiary_name").val(),
			wyslij: true,
			opt: $("input:radio[name=opt]:checked").val(),
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addDiary2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	});
	
});
</script>
</head>
<body>
<div id="message"></div>
<div id="inside">
<fieldset>
<legend>Utwórz dziennik</legend>
<?php if ($komunikaty && !isset($result)){ echo '<font color="red"><b>'.$komunikaty.'</b></font>';}
	else { echo '<font color="blue">'.$komunikaty.'</font>';}?>
<p>Nazwa dziennika:</p>
<input type="text" id="newDiary_name" name="name_diary" size="40" placeholder="Tutaj wpisz nazwę dziennika" required="required">
<p>Możliwość komentowania wpisów:</p>
<input type="radio" name="opt" value="able" checked="yes">Włącz<br>
<input type="radio" name="opt" value="disable">Wyłącz
<br><br>
<input class="dodaj" type="submit" class="submit" name="wyslij" value="Wyślij" <?php if ($stop) { echo'disabled="disabled"';}?>>
</fieldset>
</div>
<script>
$(document).ready(function() {
 $("#newDiary_name").click(function() {
  $(this).attr("value","");
  $(this).css("color","black");
  }); 
});
</script>
</body>
<?php 
}
else
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany<br><a href="login.php">Zaloguj się</a><br>'
?>