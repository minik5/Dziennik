<?php session_start();
include ("connection.php");


if (isset($_POST['wyslij'])){

$zal = mysql_num_rows(mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = '$idwpisu'"));
$allowedExts = array("jpg", "jpeg", "gif", "png");
$komunikaty = '';

if(count($_FILES['plik']['name'])) {
$i = 0;
	//if(count($_FILES['plik']['name']) >1){
  foreach ($_FILES['plik']['name'] as $file) {
$extension = end(explode(".", $_FILES["plik"]["name"][$i]));
$numer = $zal + $i +1; 
$plik_tmp = $_FILES['plik']['tmp_name'][$i]; 
$filename = stripslashes($_FILES['plik']['name'][$i]); 
//$ext =  getExtension($filename);
//$ext = strtolower($ext);
$plik_nazwa = $idwpisu.'_z_'.$numer.'.'.$extension;
$plik_rozmiar = $_FILES['plik']['size'][$i]; 
$r = $_POST['rodzaj'];
$max = false;

if (isset($_POST['yt_link'])){
$vt = $_POST['yt_link'];

if (strpos($vt, "youtube.com") !== false){
echo "Jednak to był link z YT <br />";
if (strpos($vt, "v=") !== false){
$vt_link = substr(substr($vt, strpos($vt, "v=")),2);
if (strpos($vt_link,"#") !== false){
$vt_link = substr($vt_link,0, strpos($vt_link,"#"));
}
}
elseif (strpos($vt, "embed/") !== false){
$vt_link = substr(substr($vt, strpos($vt, "embed/")),6);
if (strpos($vt_link, '" frameborder') !== false){
$vt_link = substr($vt_link, 0, strpos($vt_link, '" frameborder'));
}
elseif (strpos($vt_link, "?feature") !== false){
$vt_link = substr($vt_link, 0, strpos($vt_link, "?feature"));
}
}
$vt_link = 'http://www.youtube.com/v/'.$vt_link;
//http://www.youtube.com/watch?v=QC5DJom3PAs
//http://www.youtube.com/embed/UV3rv_gO0Qc?feature=player_detailpage
//<iframe width="854" height="510" src="http://www.youtube.com/embed/Ylk74Nys5oA" frameborder="0" allowfullscreen></iframe>
}


}

if ($r == "foto" &&(($_FILES["plik"]["type"][$i] == "image/gif")
|| ($_FILES["plik"]["type"][$i] == "image/jpeg")
|| ($_FILES["plik"]["type"][$i] == "image/png")
|| ($_FILES["plik"]["type"][$i] == "image/pjpeg"))
&& in_array($extension, $allowedExts))
  {
	if (($_FILES["plik"]["size"][$i] < 20971521)){
  $rodzaj = 'Z'; //zdjęcie
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />";
  }
  }
elseif ($r == "song" &&(($_FILES["plik"]["type"][$i] == "audio/mpeg")
|| ($_FILES["plik"]["type"][$i] == "audio/ogg")
|| ($_FILES["plik"]["type"][$i] == "audio/wav")
//|| ($_FILES["plik"]["type"][$i] == "image/pjpeg")
)
&& in_array($extension, $allowedExts))
  {
	if (($_FILES["plik"]["size"][$i] < 20971521)){
  $rodzaj = 'A'; //pliki dźwiękowe
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />";
  }
  }
elseif ($r == "film" 
&&(($_FILES["plik"]["type"][$i] == "video/webm")
|| ($_FILES["plik"]["type"][$i] == "video/mp4")
|| ($_FILES["plik"]["type"][$i] == "video/ogg")
|| ($_FILES["plik"]["type"][$i] == "video/x-flv")
|| ($_FILES["plik"]["type"][$i] == "video/x-ms-wmv")
|| ($_FILES["plik"]["type"][$i] == "video/mpeg")
|| (isset ($vt_link)))
&& in_array($extension, $allowedExts))
  {
	if ($_FILES["plik"]["size"][$i] < 20971521){
  $rodzaj = 'W'; //wideo
  }
  else{
  $max = true;
  $komunikaty.="Dla pliku ".$_FILES["plik"]["name"][$i]." przekroczono maksymalny rozmiar 20MB<br />
				<i>Zapraszamy do korzystania z portalu YouTube w celu przesłania większego pliku wideo</i><br />";
  }
  }
if (isset ($vt_link)){
$rodzaj = 'W';
$addbd = mysql_query("INSERT INTO zalaczniki (idwpisu, nickRed, dataDodania, url, rodzaj) VALUES ('$idwpisu', '$nick', '$data','$vt_link','".$rodzaj."')");
	if ($addbd){
    $komunikaty.="<br />Link: <strong>$vt_link</strong> został poprawnie dodany!<br />";
	}
	else{
	echo mysql_error();
	}

}
elseif (isset($rodzaj)){
  if ($_FILES["plik"]["error"][$i] > 0)
    {
    $komunikaty.= "Error: " . $_FILES["plik"]["error"][$i] . " dla pliku ".$_FILES["plik"]["name"][$i]."<br />";
    }
  else
    {
    /*
	echo "Upload: " . $_FILES["plik"]["name"][$i] . "<br />";
    echo "Type: " . $_FILES["plik"]["type"][$i] . "<br />";
    echo "Size: " . ($_FILES["plik"]["size"][$i] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["plik"]["tmp_name"][$i];
    */
	
if(is_uploaded_file($plik_tmp)) { 
	$url = "upload/".$plik_nazwa;
	$addbd = mysql_query("INSERT INTO zalaczniki (idwpisu, nickRed, dataDodania, url, rodzaj) VALUES ('$idwpisu', '$nick', '$data','$url','".$rodzaj."')");
	if ($addbd){
	move_uploaded_file($plik_tmp, $url); 
    $komunikaty.="<br />Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!<br />";
	}
	else{
	echo mysql_error();
	}
} 
    
  }
  }
  else{
  if ($max == false){
  $komunikaty.= "Nieprawidłowy format pliku: " .$_FILES["plik"]["name"][$i]."<br />";
  }
  }
  $i++;
  }
 //}
 
if (isset($komunikaty)){
  echo "Komunikaty dotyczące przesyłanych plików :<br />";
  echo $komunikaty;
  
  }
}
}
?>