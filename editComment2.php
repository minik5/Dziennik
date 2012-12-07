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
elseif(isset($_POST['deletKom'])) {
    //Przed skasowaniem dialogbox Yes/No by się przydać.
    $query= mysql_query("DELETE FROM komentarze WHERE IdKom='$nrKom'");
    if ($query) {
        echo '<br><span style="color: green; font-weight: bold;">Komentarz został usunięty! </span><br>';
        // Powrót na index po 3 sekundach.
		header("Refresh: 3; url=index.php");
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Błąd połączenia z bazą danych! </span><br>'.mysql_error();
    }
	date_default_timezone_set("Europe/Warsaw");


}
}
}
}
}

?>
