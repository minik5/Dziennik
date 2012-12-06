<?php
session_start();
include("connection.php");
include("getbrowser.php");

if (isset($_SESSION['dziennik'])) {
$login = $_SESSION['login'];

// Sprawdzanie czy dziennik został zaakceptowany przez admina
$error = false;
if ($_SESSION['dziennik'] == $login){
$zgl = mysql_query("SELECT * FROM zgloszenia WHERE NickUsera ='$login' AND Temat='dodanie dziennika' AND Url='/adminAddDiary.php?id=$login'");
while ($row = mysql_fetch_array($zgl)){
if ($row['StatusZgl'] <> 2){
$error = true;
}
}
}
if (!$error){
    date_default_timezone_set("Europe/Warsaw");
$dzien = date('d');
$mies = date('m');
$rok = date('Y');
$dataRoz = date("Y-m-d");
$dzienZak = NULL;
$miesZak = NULL;
$rokZak = NULL;
$dataZak = NULL;
$tytul="";
$opis="";

if (isset($_POST['submit'])) {
    
    $daty=true;
    $idDziennika = $_SESSION['dziennik'];
    $tytul = $_POST['title'];
    if (isset($_POST['trip'])) $opis = $_POST['trip'];
    else $opis = "";
    
   if (getbrowser()=='ie' || getbrowser()=='firefox') {
        // wczytanie dat dla przegl¹darek bez typu DATE
        
        if (!is_numeric($_POST['dDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Dzień to liczba z przedziału 1..31!</span><br>';
            $daty=false;
        } else $dzien = (int)$_POST['dDateRoz'];        
        if (!is_numeric($_POST['mDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Miesiąc to liczba z przedziału 1..12!</span><br>';
            $daty=false;
        } else $mies = (int)$_POST['mDateRoz'];
        if (!is_numeric($_POST['yDateRoz'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Rok to cztero-cyfrowa liczba!</span><br>';
            $daty=false;
        } else $rok = (int)$_POST['yDateRoz'];
        if (!is_numeric($_POST['dDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Dzień to liczba z przedziału 1..31!</span><br>';
            $daty=false;
        } else $dzienZak = (int)$_POST['dDateZak'];
        if (!is_numeric($_POST['mDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Miesiąc to liczba z przedziału 1..12!</span><br>';
            $daty=false;
        } else $miesZak = (int)$_POST['mDateZak'];
        if (!is_numeric($_POST['yDateZak'])) {
            echo '<br><span style="color: blue; font-weight: bold;">Rok to cztero-cyfrowa liczba!</span><br>';
            $daty=false;
        } else $rokZak = (int)$_POST['yDateZak'];
        if ($daty) {
            if (!checkdate($mies, $dzien, $rok) || !checkdate($miesZak, $dzienZak, $rokZak)) {
                echo '<br><span style="color: blue; font-weight: bold;">Nieprawidłowa data!</span><br>';
                $daty=false;
            } else {
                $dataRoz = $rok.'-'.$mies.'-'.$dzien;
                $dataZak = $rokZak.'-'.$miesZak.'-'.$dzienZak;
            }
        }
    }
    else {
        $dataRoz = $_POST['datepickerRoz'];
        $dataZak = $_POST['datepickerZak'];
    }
    
    if ( $dataRoz > $dataZak ) {
        $daty=false;
        echo '<br><span style="color: green; font-weight: bold;">Data zakończenia musi być późniejsza od daty rozpoczęcia!</span><br>'; 
    }
    
    if ($daty) {
        $spr = mysql_query("SELECT * FROM katalog WHERE Katalog='$tytul'");
        if (mysql_num_rows($spr)==0) {
            $query = "INSERT INTO katalog (IdDziennika,Katalog,Opis,DataRozpoczecia,DataZakonczenia) VALUES('$idDziennika','$tytul','$opis','$dataRoz','$dataZak')";
            $result=mysql_query($query);
            if ($result) {
                echo '<br><span style="color: green; font-weight: bold;">Wpis został dodany!</span><br>';
            }
            else echo '<br><span style="color: green; font-weight: bold;">Nie można połączyć się z bazą danych!</span><br>';
        } else echo '<br><span style="color: green; font-weight: bold;">Wycieczka o podanym tytule istenieje już w bazie danych!</span><br>';
    }
}
?>

<link href="" type="text/css" rel="stylesheet"/>      
<title>Multimedialny dziennik podróży - dodawanie wycieczki.</title>  

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
<form name="addTrip" method="POST" action="addTrip.php">                
<p><label for="title">Tytuł wycieczki: </label></p>                
<p> <input type="text" name="title" size="30" autofocus required="required" value="<?php echo $tytul; ?>"/>  </p> 
<label for="datepickerRoz">Data rozpoczęcia:</label> 
<input type='date' class='pDataRoz' id='datepickerRoz' name='datepickerRoz' value="<?php echo $dataRoz;?>"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
			<div id='dateIERoz' style='DISPLAY: none'><br>
			<label for="dDateie">Dzien:  </label> <input type='text' id='dDateRoz' name='dDateRoz' value="<?php echo $dzien;?>"><br>
			<label for="mDateie">Miesiąc: </label> <input type='text' id='mDateRoz' name='mDateRoz' value="<?php echo $mies;?>"><br>
			<label for="yDateie">Rok:     </label> <input type='text' id='yDateRoz' name='yDateRoz' value="<?php echo $rok;?>" ><br>
                        <br>
			<!-- -------------------------------------------------------------- -->
			</div>
<label for="datepickerZak">Data zakonczenia:</label> 
<input type='date' class='pDataZak' id='datepickerZak' name='datepickerZak' value="<?php echo $dataZak;?>"><br>
			<!-- Dla przeglądarek nieobsługujących HTML5 typ: date -->
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
}
else { echo'<br><span style="color: red; font-weight: bold;">Twój dziennik nie został jeszcze zaakceptowany przed admina.</span><br>' ;
}
} else {
    echo '<br><span style="color: red; font-weight: bold;">Nie został wybrany dziennik, do którego wpis ma być dodany lub nie posiadasz dziennika!</span><br>' ;
}
?>