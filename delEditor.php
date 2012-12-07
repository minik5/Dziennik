<?php
session_start();
include ("connection.php");



if (isset($_SESSION['zalogowany']) && isset($_GET['id'])){


$nick = $_SESSION['login'];
$id = $_GET['id'];
$query = mysql_query("SELECT * FROM redaktorzy WHERE IdRed = '$id' AND NazwaDziennika ='$nick'");

$result = mysql_fetch_array($query);

if ($result[0] <1){
echo 'Wybrany redaktor nie należy do Twojego dziennika';
exit;
}
else{


$query2 = mysql_query("SELECT * FROM uzytkownicy WHERE Nick='".$result['NickRed']."'");
$row = mysql_fetch_array($query2);
?>
<html>
<head>

<title>Usuwanie redaktora</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$("#pass").hide();
	$('.usun').click(function(){
	if ($('#Psswd').val() == ""){
	$("#pass").show();
	}
	else{
	$("#pass").hide();
	var delw = [];
	$('input:checkbox[name="delwpis[]"]:checked').each(function() {
            delw.push(this.value);
     });
	var form_data = {
			password: $('#Psswd').val(),
			delRed: true,
			delwpis: delw,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "delEditor2.php?id="+$("#idEditor").val(),
			data: form_data, 
		}).done(function( response ) {
		$("#message").html(response);
		});
	}
		});
		
		
});


</script>
</head>
<body>
<div id="message"></div>
<div id="inside">
<p><b><?php echo $row['Nick'] ?></b></p>
	    <input type="hidden" id="idEditor" value="<?php echo $id;?>">
		<input type="text" id="NickR" class="" size="25" style="color:grey;" disabled value="<?php echo $row['Nick'] ?>"><br>
		<input type="text" id="ImieR" class="" size="25" style="color:grey;" disabled value="<?php echo $row['Imie'] ?>"><br>
		<input type="text" id="NazwR" class="" size="25" style="color:grey;" disabled value="<?php echo $row['Nazwisko'] ?>"><br>
		<?php
		$query8=mysql_query("SELECT * FROM katalog WHERE IdDziennika = '".$nick."'");
		$i =0;
		while ($spr = mysql_fetch_array($query8,MYSQL_BOTH)){
		$wpis = mysql_query("SELECT * FROM wpisy WHERE  IdKatalog = '".$spr['IdKatalog']."' AND NickRed = '".$result['NickRed']."'");
        while ($wpis && $row = mysql_fetch_array($wpis, MYSQL_BOTH)){
		if ($i == 0){
		echo'<b>Wpisy redaktora w Twoim dzienniku:</b><br /><table border="1">
		<tr>
		<th>Zaznacz do Usuniecia</th>
		<th>Wpisy</th>
		</tr>';
		$i++;
		}
		echo'<tr>
				<td  class="select">
					<input type="checkbox" name="delwpis[]" required="required" value="'.$row["IdWpis"].'">
				</td>
				<td class="">
					<!-- Wpisy Redaktora -->
					<a href ="showReg.php?IdWpisu='.$row["IdWpis"].'">Wpis o tytule: '.$row["Tytul"].' z dnia '.$row["DataWpisu"].'</a>
				</td>
			</tr>';
			
		}
		}
		if ($i > 0){
		echo '</table>
		<input type="checkbox" name="selectAll">Zaznacz wszystkie';
		/**
		
			
		</table>
		<input type="checkbox" name="selectAll">Zaznacz wszystkie
		*/
		}
		else {echo 'Ten redaktor nie posiada żadnych wpisów w Twoim dzienniku';
		}
		?>
		<br /><br />
		<p>Podaj haslo w ramach potwierdzenia usunięcia redaktora</p>
		<div id="pass"><font color="red"><b>Podaj hasło!</b></font></div>
		<input type="password" id="Psswd" class="wpisz" size="25" style="color:grey;" name="password" value="" required="required"><br>
		<input class="usun" type="submit" name="usunRed" value="Zatwierdz zmiany">
</div>
<script>
	$(".wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
<?php
}
}
else{
echo '<br>Nie wybrano redaktora<br>';
}

?>