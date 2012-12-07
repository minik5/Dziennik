<?php
session_start();
include("connection.php");

$komunikaty = "";
if (isset($_SESSION['zalogowany'])){

	if(isset($_GET['IdKom']) && isset($_SESSION['login'])){
		$nrKom = $_GET['IdKom'];
		$nick = $_SESSION['login'];
		$query = mysql_query("SELECT * FROM komentarze WHERE IdKom='$nrKom'");
		$query2 =mysql_query("SELECT * FROM uzytkownicy WHERE Dostep='1' AND IdUser='$nick'");

		if(mysql_num_rows($query) ==1){
			$result = mysql_fetch_array($query);
			if($result['IdUser'] == $nick || $query2){//tylko autor komentarza lub administrator mogą edytowac
				$user = $result['IdUser'];
				$tresc = $result['Tresc'];
?>


<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.editcomment').click(function(){
	var form_data = {
			komentarz: $("#komentarz").val(),
			wyslij: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "editComment2.php?IdKom="+$("#idkom").val(),
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	});
	$('.delcomment').click(function(){
	alert("aaa");
	var form_data = {
			komentarz: $("#komentarz").val(),
			deletKom: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "editComment2.php?IdKom="+$("#idkom").val(),
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		$('.clearing').hide();
		$('.editcomment').hide();
		$('.delcomment').hide();
		});
	
	});
    $('.clearing').click(function(){
	$("#komentarz").attr('value','');
	});
	
});
</script>
<div id="message"></div>
<div id="inside">
<p>Komentarz</p>
<input type="hidden" id="idkom" value="<?php echo $nrKom;?>">
<textarea style="color:grey; resize:none;" name="komentarz" id="komentarz" rows="7"  cols="40"  required="required">
<?php echo $tresc; ?>
</textarea><br>
<input type="submit" class="clearing"name="reset" value="Wyczyść pole"> 
<input type="submit" class="editcomment" name="wyslij" value="Wyslij">
<input type="submit" class="delcomment" name="delete" value="Usuń">
</div>
</body>

</html>
<?php
		}else{
		echo '<br><span style="color: red; font-weight: bold;">Nie masz prawa edytować tego komentarza!</span><br>' ;
		}
	}else{
	echo '<br><span style="color: red; font-weight: bold;">Brak komentarza w bazie!</span><br>' ;
	}
 }else{
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany żaden komentarz. </span><br>' ;
 }
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}

?>
