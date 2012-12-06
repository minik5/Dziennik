<?php
session_start();
include ("connection.php");
?>



<?php
if (isset($_SESSION['zalogowany'])){
$nick = $_SESSION['login'];
$error = false;
if ($_SESSION['dziennik'] == $nick){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$nick' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$nick'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
$spr1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dzienniki WHERE IdDziennika='".$nick."' LIMIT 1"));
$komunikaty = '';
$searcherror = false;

if ($spr1[0] == 1){
$query = mysql_query("SELECT IdRed, NickRed FROM redaktorzy WHERE NazwaDziennika = '".$nick."'");

?>
<title>Dodawanie redaktorów do dziennika</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.dodaj').click(function(){
	var form_data = {
			nickred: $("#wpisz").val(),
			dodaj: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addEditor2.php",
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	});
});
</script>
</head>
<body>
<div id="inside">
<fieldset>
<p>Dodawanie nowego redaktora:</p>
<div id="message"></div>
	<!--<form name="searchEditorForm" method="POST" action="addEditor.php"><br> -->
		<input type="text" id="wpisz" size="25" style="color:grey;" name="nickred" required="required" value="<?php if (isset($_POST['nickred'])) {echo $_POST['nickred'];} else {?>Podaj tu nick do szukania<?php }?>">
		<input type="submit" class="dodaj" id="dodaj" name="dodaj" value="Dodaj">
	<!--</form>-->
	</fieldset>
</div>
<br>
<div id="table">
<fieldset>
<p>Lista redaktorów przydzielonych do dziennika:</p>
	<table border="1">
	<tr>
		<th class="select">Zaznacz</th>
		<th>Lp</th>
		<th>Nick</th>
	</tr>
	<?php 
	$i = 0;
	echo ('<form method="POST" action="addEditor.php">');
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
	$i ++;
	
		echo '<tr>
		<td  class="select">
			
				<input type="radio" name="redaktor" value="'.$row['IdRed'].'" required="required"><br>
			
		</td>
		<td class="indexed">
		<!-- liczba porzadkowa Redaktora -->
			<var><center>'.$i.'</center></var>
		</td>
		<td class="nickName">
		<!-- Nick pierwszego Redaktora -->
		<p><center>'.$row['NickRed'].'</center></p>
		</td>
		
	</tr>';
	}
echo'</table>
<!-- Usuniecie Redaktora -->
		    <input type="submit" name="edit" value="Edytuj"';
			if ($i ==0){
			echo ('disabled="disabled"');
			}
			echo'>
			<input type="submit" name="del" value="Usun"';
			if ($i ==0){
			echo ('disabled="disabled"');
			}			
			echo'>';
			?>
		</form>
		</fieldset>
</div>
<script>
	$("#wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
<?php

}

else{
echo 'Nie posiadasz swojego dziennika, możesz założyć go <a href="addDiary.php">TUTAJ</a><br />.';
}
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
?>