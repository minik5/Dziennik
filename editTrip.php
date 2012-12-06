<?php
    // Pobiera z GET'a Id wycieczki

session_start();
include("connection.php");
include("getbrowser.php");

if (isset($_SESSION['dziennik'])) {
$login = $_SESSION['login'];
// Sprawdzanie czy dziennik został zaakceptowany przez admina
if (isset($_GET['IdTrip'])) {
   
    $result= mysql_query("SELECT * FROM katalog WHERE IdKatalog=".$_GET['IdTrip']);
    
    $podroz = mysql_fetch_assoc($result);    
    
        date_default_timezone_set("Europe/Warsaw");
    $dataRoz = $podroz['DataRozpoczecia'];
    $dataZak = $podroz['DataZakonczenia'];
    $tytul = $podroz['Katalog'];
    $opis = $podroz['Opis'];
    
    $dzien = substr($dataRoz,8,2);
    $mies = substr($dataRoz,5,2);
    $rok = substr($dataRoz,0,4);
    
    $dzienZak = substr($dataZak,8,2);
    $miesZak = substr($dataZak,5,2);
    $rokZak = substr($dataZak,0,4);
?>

<link href="" type="text/css" rel="stylesheet"/>      
<title>Multimedialny dziennik podrÃ³ży - edytowanie wycieczki.</title>  

<?php include ("ckeditor.php"); ?>

<script language="javascript">  
function dateFun(){
   var datefield=document.createElement("input")
   datefield.setAttribute("type", "date")
       if(datefield.type!="date"){ //sprawdza czy przegladarka obsluguje input type="date"
               document.getElementById('datepickerRoz').style.display='none';
               document.getElementById('dateIERoz').style.display='block';
               
               document.getElementById('dDateRoz').required=true;
               document.getElementById('mDateRoz').required=true;
               document.getElementById('yDateRoz').required=true;
               
               document.getElementById('datepickerZak').style.display='none';
               document.getElementById('dateIEZak').style.display='block';
               
               document.getElementById('dDateZak').required=true;
               document.getElementById('mDateZak').required=true;
               document.getElementById('yDateZak').required=true;
       }
       else{
               document.getElementById('datepickerRoz').required=true;        
               document.getElementById('datepickerZak').required=true;
       }
}
</script>  
<div id="container" >
<form name="addTrip" method="POST" action="editTrip.php?IdTrip=<?php echo $_GET['IdTrip']; ?>">                
<p><label for="title">Tytuł wycieczki: </label></p>                
<p> <input type="text" name="title" size="30" autofocus required="required" value="<?php echo $tytul; ?>"/>  </p> 
<label for="datepickerRoz">Data rozpoczęcia:</label> 
<input type='date' class='pDataRoz' id='datepickerRoz' name='datepickerRoz' value="<?php echo $dataRoz;?>"><br>
			<!-- Dla przegladarek nieobslugujacych HTML5 typ: date -->
			<div id='dateIERoz' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' id='dDateRoz' name='dDateRoz' value="<?php echo $dzien;?>"><br>
			<label for="mDateie">Miesiąc: </label> <input type='text' id='mDateRoz' name='mDateRoz' value="<?php echo $mies;?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' id='yDateRoz' name='yDateRoz' value="<?php echo $rok;?>" ><br>
                        <br>
			<!-- -------------------------------------------------------------- -->
			</div>
<label for="datepickerZak">Data zakonczenia:</label> 
<input type='date' class='pDataZak' id='datepickerZak' name='datepickerZak' value="<?php echo $dataZak;?>"><br>
			<!-- Dla przegladarek nieobslugujacych HTML5 typ: date -->
			<div id='dateIEZak' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' id='dDateZak' name='dDateZak' value="<?php echo $dzienZak;?>"><br>
			<label for="mDateie">Miesiąc: </label> <input type='text' id='mDateZak' name='mDateZak' value="<?php echo $miesZak;?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' id='yDateZak' name='yDateZak' value="<?php echo $rokZak;?>"><br>
			<!-- -------------------------------------------------------------- -->
			</div>
<p><label for="trip">Opis: </label></p>                
<p><textarea class="ckeditor" name="trip" rows="20" cols="60" /><?php echo $opis; ?></textarea></p>                
<p class="center">                    
   <input type="reset" value="Wyczyść pola"/>                    
   <input id="addTrip" type="submit" class="submit" name="submit" value="Zapisz"/>              
</p>            
</form> 
</div>
<script>
	//wywolaj po otwarciu strony
	window.onload=dateFun ; 
</script>
    
<?php
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie została wybrana podróż do edycji!</span><br>';
}
}else {
    echo '<br><span style="color: blue; font-weight: bold;">Nie posiadasz dziennika!</span><br>';
}
?>