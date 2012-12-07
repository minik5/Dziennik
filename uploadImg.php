<?php session_start();
include ("connection.php");



if (isset($_POST['idWpisu']) && (isset($_SESSION['dziennik']))){


$idwpisu = $_POST['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];
$komunikaty = '';
// ******** USUWANIE ZDJ�?CIA ********
if (isset($_POST['usun']) && isset($_POST['zdj'])){

for ($i =0; $i<sizeof($_POST['zdj']); $i++){
$result = mysql_query("DELETE FROM zalaczniki WHERE idwpisu='$idwpisu' AND url = '".$_POST['zdj'][$i]."'");
if ($result){
$komunikaty .= '<font color="blue">Pomyślnie usunięto '.$_POST['zdj'][$i].' z bazy danych </font> <br />';
$result2 = unlink($_POST['zdj'][$i]);
if ($result2){
$komunikaty .= '<font color="blue">Pomyślnie usunięto '.$_POST['zdj'][$i].' z serwera </font> <br />';
}
else{
$komunikaty .= '<font color="red">Wystąpił błąd podczas usuwania '.$_POST['zdj'][$i].' z serwera </font> <br />';
}
}
else {
$komunikaty .= '<font color="red">Wystąpił błąd podczas usuwania '.$_POST['zdj'][$i].' z bazy danych </font> <br />';
}
}
}
// ******** EDYCJA KOMENTARZA ********
if (isset($_POST['zapisz']) && isset($_POST['idzal'])){
$idzal = $_POST['idzal'];
$kom = $_POST['photoTextArea'];

$zamien = mysql_query("UPDATE zalaczniki SET komentarz ='$kom' WHERE idzal = '$idzal'");

if ($zamien){
$komunikaty .= '<font color="blue">Pomyślnie zmieniono komentarz do zdjęcia. </font> <br />';
}
else{
$komunikaty .= '<font color="red">Wystąpił błąd podczas zmiany komentarza do zdjęcia. </font> <br />'.mysql_error();
}
}
// ******** USUWANIE KOMENTARZA ********
if (isset($_POST['usunKom']) && isset($_POST['idzal'])){
$idzal = $_POST['idzal'];
$kom = $_POST['photoTextArea'];

$zamien = mysql_query("UPDATE zalaczniki SET komentarz ='' WHERE idzal = '$idzal'");

if ($zamien){
$komunikaty .= '<font color="blue">Pomyślnie usunięto komentarz do zdjęcia. </font> <br />';
}
else{
$komunikaty .= '<font color="red">Wystąpił błąd podczas usuwania komentarza do zdjęcia. </font> <br />'.mysql_error();
}
}


$query = mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '".$idwpisu."'");

?>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<?php if (isset($komunikaty)){ echo $komunikaty; }?>
<p>Lista przeslanych plikow</p>
<p>Obrazy</p>
<?php

$i = 0;
	while ($row = mysql_fetch_array($query, MYSQL_BOTH)){
	if ($i ==0){
	
	echo '<form name="photoForm" action="uploadImg.php" method="POST">
	<ul name="photoList">
	<input type="hidden" name="idWpisu" value="'.$idwpisu.'" />';
	}
		echo'<li>
			
				<a href="editPhoto.php?idzal='.$row["idzal"].'"><img src="
				'//miniaturka.php?foto='
				.$row["url"].'" height="150" width="150"></a>
				<input type="checkbox" name="zdj[]" value="'.$row["url"].'"> <br>
			
		</li>';
		
		$i++;
		}
		if ($i != 0){
	echo '</ul>
	<input type="submit" name="usun" value ="Usun">
	</form>';
	}
	else{
	echo '<b>Brak zdjęć dla tego wpisu. <br />
	Aby dodać zdjęcie, powróć na stronę dodawania.</b><br />';
	}
	echo'
	<form name="back" action="addPhoto.php" method="POST">
	<input type="hidden" name="idWpisu" value="'.$idwpisu.'" />
	<input type="submit" name="Powrot" value="Powrot">
	</form>';
	
	?>
</div>
</body>


<?php 

}
else{
   echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, którego zdjęcia mają być edytowane!</span><br>' ;
}
?>