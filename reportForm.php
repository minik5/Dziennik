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

</head>
<body>


<div id="inside">

<h4>Zgloszenie</h4>
<p>Rodzaj zgloszenia</p>
<form action="reportForm.php" method="POST">

<?php if (isset ($_GET['idWpisu']) && isset ($_POST['zglos'])){
?>
<input type="hidden" id="idwpis" name="idwpis" value="<?php echo $_GET['idWpisu']; ?>">
<select name="report">
<option value="błędny wpis" selected="selected" >Bledny wpis</option>
<?php
}
else{
?>
<?php if (isset ($_GET['idkom'])){
?>
<input type="hidden" id="idwpis" name="idkom" value="<?php echo $_GET['idkom']; ?>">
<select name="report">
<option value="błędny komentarz" selected="selected" >Bledny komentarz</option>
<?php
}
else{
?>
<select name="report">
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
<input type="submit" name="wyslij" value="Wyslij">
</form>
</div>
</body>

</html>
<?php
}
else{
echo '<br>Nie byłeś zalogowany albo zostałeś wylogowany.<br><a href="login.php">Zaloguj się</a><br>';
}
?>