<?php 
session_start();
include ("connection.php");



if (isset($_GET['idzal']) && (isset($_SESSION['dziennik']))){


$idzal = $_GET['idzal'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];


$query = mysql_query("SELECT * FROM zalaczniki WHERE idzal = '$idzal'");
$q1 = mysql_query("SELECT  IdWpis FROM wpisy WHERE IdDziennika ='$dziennik'");
$q2 = mysql_query("SELECT idwpisu FROM zalaczniki WHERE idzal = '$idzal'");
$row = mysql_fetch_array($query);
$spr2 = mysql_fetch_array($q2);
$result = false;
while ($spr1 = mysql_fetch_array($q1, MYSQL_BOTH)){
if ($spr1['IdWpis'] == $spr2['idwpisu']){
$result = true;
}
}
if ($result){

?>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>

</head>
<body>
<div id="inside">
<p>Obraz <?php echo $row['url']; ?></p>
	<form name="photoForm" action="uploadImg.php" method="POST">
	<input type="hidden" name="idWpisu" value="<?php echo $row['idwpisu'];?>" />
	<input type="hidden" name="zdj[]" value="<?php echo $row['url']; ?>">
	<input type="hidden" name="idzal" value="<?php echo $row['idzal']; ?>">
		<img src="<?php echo $row['url']; ?>" name="foto" width ="200" height="200" >
		<textarea name="photoTextArea" cols=35 rows=3>
			<?php echo $row['komentarz'];?>
		</textarea>
		
	    <input type="submit" name="zapisz" value ="Zapisz">
		<input type="submit" name="usunKom" value ="Usun komentarz">
		<input type="submit" name="usun" value ="Usun Zdjecie">
	</form>

		
	</ul>
</div>
</body>
<?php

}
else{
   echo '<br><span style="color: red; font-weight: bold;">Wybrany załącznik nie należy do tego wpisu!</span><br>' ;
}
}
else{
   echo '<br><span style="color: red; font-weight: bold;">Nie został załącznik, który ma być edytowany!</span><br>' ;
}

?>