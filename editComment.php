<?php
session_start();
include("connection.php");

$komunikaty = "";
if (isset($_SESSION['zalogowany'])){

	if(isset($_GET['IdKom']) && isset($_SESSION['login'])){
		$nrKom = $_GET['IdKom'];
		$nick = $_SESSION['login'];
		$query = mysql_query("SELECT * FROM komentarze WHERE IdKom='$nrKom'");
		$query2 =mysql_query("SELECT * FROM uzytkownicy WHERE Dostep='1'");

		if(mysql_num_rows($query) ==1){
			$result = mysql_fetch_array($query);
			$result2 = mysql_num_rows($query2);
			if($result['IdUser'] == $nick || $result2>0){//tylko autor komentarza lub administrator mogą edytowac
				$user = $result['IdUser'];
				$tresc = $result['Tresc'];

			if (isset($_POST['wyslij'])){
			$tresc = $_POST['komentarz'];
			$query=mysql_query("UPDATE komentarze SET Tresc='$tresc' WHERE IdKom='$nrKom'");
    
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Komentarz został zmieniony! </span><br>';
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>';
    }
    
}
?>



<div id="inside">
<form action="editComment.php?IdKom=<?php echo $nrKom;?>" method="POST">
<p>Komentarz</p>
<textarea style="color:grey; resize:none;" name="komentarz" id="komentarz" rows="7"  cols="40"  required="required">
<?php echo $tresc; ?>
</textarea><br>
<input type="submit" name="reset" value="Wyczyść pole"> 
<input type="submit" name="wyslij" value="Wyslij">
<input type="submit" name="delete" value="Usuń">
<?php //if ($komunikaty =="ok")  { echo '<br><span style="color: green; font-weight: bold;">Komentarz został dodany. </span><br>';} ?>
</form>
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
