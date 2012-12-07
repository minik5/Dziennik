<?php 
session_start();
 date_default_timezone_set("Europe/Warsaw");
include("connection.php");

if (isset($_GET['dziennik'])) {
    $_SESSION['dziennik']=$_GET['dziennik'];
}

if (isset($_GET['IdWpisu']))
{
    $IdWpisu=$_GET['IdWpisu'];
    $query="SELECT * FROM wpisy WHERE IdWpis=$IdWpisu";
    $dziennik = $_SESSION['dziennik'];
	
    $result= mysql_query($query);	
	date_default_timezone_set("Europe/Warsaw");
    if (mysql_num_rows($result)==1){
        $wpis=  mysql_fetch_assoc($result);   
		//do komentarzy, R.P.
		$spr = mysql_fetch_assoc(mysql_query("SELECT * FROM katalog WHERE IdKatalog ='".$wpis['IdKatalog']."'"));
		$spr2 = mysql_query("SELECT Komentarze FROM Dzienniki WHERE IdDziennika='".$spr['IdDziennika']."'");
		$rowK = mysql_fetch_array($spr2,MYSQL_ASSOC);		
		//koniec, R.P.
        $tytul=$wpis['Tytul'];
        $tresc=$wpis['Tresc'];
		$query = mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '".$IdWpisu."'");
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Wybrano błędny wpis! </span><br>';
    }
} else if (isset($_GET['wycieczka'])) {
    $query="SELECT Katalog,Opis FROM katalog WHERE IdKatalog=".$_GET['wycieczka'];
    $result=  mysql_query($query);
    $wycieczka=mysql_fetch_assoc($result);
    $tytul=$wycieczka['Katalog'];
    $tresc=$wycieczka['Opis'];
} else {
    $tytul="";
    $tresc="Wybierz wycieczke z osi czasu!";
}
if (isset($_SESSION['dziennik'])) {
?>

<html>
<head>

<title>Strona glowna</title>

<link rel="stylesheet" type="text/css" href="Data/cssShowReg.css" media="all">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="simplegallery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="simplegallery/js/simplegallery.js"></script>
<script>
$(document).ready(function(){
<?php
if (isset($_GET['wycieczka'])){
?>
$('#timeline').load('timelineFun.php?wycieczka='+<?php echo $_GET['wycieczka']; ?>);
<?php
}
else{
?>
$('#timeline').load('timelineFun.php');
<?php
}
?>
$('#edycja').click(function(){
$('.insideDiv').load("editInscription.php?idWpisu="+$('#wpisik').val());
});
$('#editontrip').click(function(){
$('.insideDiv').load("editTrip.php?IdTrip="+$('#iddektrip').val());
});
$('#dzialanie').click(function(){
$('.insideDiv').load("reportForm.php?idWpisu="+$('#wpisik').val());
});

});

</script>


</head>

<body>
<div id="inside">
    <div id="inscription">
	<!-- Tytul wpisu -->
	<div id="title" name="titleName"><h3><?php echo $tytul;?></h3></div>
	<!-- tekst wpisu -->
	<div id="entry" name="entryText"> 
            <?php echo $tresc;?>
        </div>
	<!-- Multimedia -->
        <div id="simplegallery">
        <script>sg_load("", "Galeria multimediów", "100", "80",<?php echo $IdWpisu; ?>);</script>
        </div>
    </div>    
    <div id="timeline">

    </div>
    <div id="buttonsBox">
            <!--Wyswietla sie, gdy przeglada uzytkownik(zalogowany). No i gdy widnieje wpis! -->
            <?php 
            if (isset($_SESSION['zalogowany'])) {
            if (isset($_GET['IdWpisu'])) { // trzeba sprawdzac czy uzytkownik ma prawa do przyciskow
			if (!isset($_SESSION['login'])){
			$allow = false;
			}
			else{
			$wpis = $_GET['IdWpisu'];
			$nick = $_SESSION['login'];
			$dziennik = $_SESSION['dziennik'];
			$query = mysql_query("SELECT * FROM wpisy WHERE IdWpis ='$wpis'");
			$result = mysql_fetch_array($query);
			$spr1 = mysql_query ("SELECT * FROM redaktorzy WHERE NazwaDziennika='$dziennik' AND NickRed = '$nick'");
			if (mysql_num_rows($spr1) == 1 || $dziennik == $nick){
			$red = mysql_fetch_array($spr1);
				if ($red['EdycjaAutora']=='TAK' && $result['IdDziennika'] == $result['NickRed'] || $red['EdycjaRedaktora'] =='TAK' && $result['NickRed'] != $result['IdDziennika'] || $dziennik == $nick){
			$allow = true;
			}
			}
			else{
			$allow = false;
			}
			}
			if ($allow){
            echo '
                    <div>
                            <input type="submit" id="edycja" class="button" name="Edycja" value ="Edycja">
                    </div>';
			if (isset($_GET['wycieczka'])) {
            echo '
                    <div>
                            <input type="hidden" id="iddektrip" value="'.$_GET['wycieczka'].'" name="IdTrip" />
                            <input type="submit" class="button" id="editontrip" name="Edycja" value ="Edycja">
                ';
            }     
			}
			echo'
                    <div>
                    <input type="hidden" id="wpisik" value="'.$IdWpisu.'" name="idWpisu" />
                            <input type="submit" class="button" id="dzialanie" name="zglos" value ="Zgłoś ten wpis">
                    </div>
                '; 
            }       
            }
            ?>
    </div> 
</div>
<div id="komentarze">
<?php
if (isset($_GET['IdWpisu']) && $rowK["Komentarze"] == "TAK") {
    if (isset($_SESSION['zalogowany'])) {
        include("addComment.php");
        comment($IdWpisu);
        } 
    include("showComments.php");
    show($IdWpisu);
}
?>
</div>
</body>
</html>
<?php
}
?>