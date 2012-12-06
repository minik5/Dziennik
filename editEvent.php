<?php
session_start();
include("connection.php");

/** Potrzebuje z sesji:
 login - nick danego usera(redaktora), który edytuje wpis
 * Z GET'a pobiera:
 IdWpisu - id wpisu, który będziemy edytować
  
 * Trzeba przemyśleć, czy będziemy chcieli gdzieś zapamitywać datę i autora korekty.
 * Trzeba by jeszcze dorobić jakiś Messege box do deleta. 
 * Po delejcie powrót do indexa by się przydać
 
 **/
if (isset($_SESSION['dziennik'])){
    $dziennik = $_SESSION['dziennik'];
    $wpisy= mysql_query("SELECT * FROM wpisy WHERE IdDziennika='$dziennik' ORDER BY DataWpisu DESC");
    if (mysql_num_rows($wpisy)>0) {
    $tytul = "";
    $wpis = "";
    if (isset($_GET['idWpisu'])) {
        $idWpisu = $_GET['idWpisu'];
        $query = mysql_query("SELECT * FROM wpisy WHERE IdWpis='$idWpisu' AND IdDziennika='$dziennik'");

        if (mysql_num_rows($query)==1) { 
            $result = mysql_fetch_array($query);
            $tytul = $result['Tytul'];
            $wpis = $result['Tresc'];
        }
    }
?>

<html>
<head>
<link href="Data/EEventCSS.css" type="text/css" rel="stylesheet"/>
<title>Title of the document</title>

<script language="javascript">  

</script>  
</head>
<body>
<div id="page">
	<div id="lewy" class="kolumny">
            <ul id="Events_list">
		<?php
                while ($w = mysql_fetch_assoc($wpisy)) {
                    echo '<li><a href="editEvent.php?idWpisu='.$w['IdWpis'].'">'.$w['DataWpisu'].'</a></li>';
                }                              
                ?>
            </ul>
	</div>
	<div id="srodkowy"class="kolumny"><var>Zdarzenie1</var><!--Zmienna do edycji -->
	<button>Uprawnienia</button><button>Edycja galeri zdarzenia</button><br>
	<h4>Tytul:</h4>
	<input type="text" size="25" value="<?php echo $tytul; ?>">
	<h4>Wpis:</h4>
	<textarea rows="12" cols="50">
	<?php echo $wpis;?>
	</textarea>
	<button>Wyslij</button>
	</div>
	<div id="prawy"class="kolumny"><p>cos</p><!-- tu bedzie os czasu --></div>

</div>


</body>

</html>

<?php 
    } else {
        echo '<br><span style="color: red; font-weight: bold;">Nie posiadasz wpis�w w dzienniku!</span><br>' ;
    }
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie posiadasz dziennika!</span><br>' ;
}
?>