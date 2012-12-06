<?php 
echo '<?xml version="1.0" encoding="iso-8859-2"?>'; 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
transitional.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-type" content="text/html; charset=iso-8859-2" /> 
<title>Upload</title> 
</head> 
<body> 

<div> 
<form enctype="multipart/form-data" action="send.php" method="POST"> 
<input type="hidden" name="MAX_FILE_SIZE" value="250000" /> 
<input name="plik" type="file" /> 
<input type="submit" value="Wyślij plik" /> 
</form> 
</div> 

<?php 
$plik_tmp = $_FILES['plik']['tmp_name']; 
$plik_nazwa = $_FILES['plik']['name']; 
$plik_rozmiar = $_FILES['plik']['size']; 

if(is_uploaded_file($plik_tmp)) { 
     move_uploaded_file($plik_tmp, "upload/$plik_nazwa"); 
    echo "Plik: <strong>$plik_nazwa</strong> o rozmiarze 
    <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!"; 
}
else{ echo "i chuj, błąd <br />";
} 
?> 
</body> 
</html>