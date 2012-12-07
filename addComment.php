<?php
include ("connection.php");
session_start();

if (isset($_GET['IdWpisu'])){
$parametr = $_GET['IdWpisu'];
$komunikaty = "";
if (isset($_SESSION['zalogowany'])){

?>

<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function(){
	$('.addCom').click(function(){
	var form_data = {
			komentarz: $("#komentarz").val(),
			wyslij: true,
			addred: 1
		};
	$.ajax({
			type: "POST",
			url: "addComment2.php?IdWpisu="+$("#idwpisu").val(),
			data: form_data,
		}).done(function( response ) {
		$("#message").html(response);
		});
	
	});
	
});
</script>
<div id="message"></div>
<div id="inside">
<input type="hidden" id="idwpisu" value="<?php echo $parametr;?>">
<p>Dodaj komentarz</p>
<textarea style="color:grey; resize:none;" name="komentarz" id="komentarz" rows="7"  cols="40" placeholder="Miejsce na Twoj komentarz" required="required">
</textarea><br>
<input type="submit" class="addCom" name="wyslij" value="Wyslij">
<?php if ($komunikaty =="ok")  { echo '<br><span style="color: green; font-weight: bold;">Komentarz został dodany. </span><br>';} ?>
</form>
</div>
</body>

</html>
<?php
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
}
?>
