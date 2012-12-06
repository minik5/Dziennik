<?php session_start();
include ("connection.php");



if (isset($_POST['idWpisu']) && (isset($_SESSION['dziennik']))){

$idwpisu = $_POST['idWpisu'];
$dziennik = $_SESSION['dziennik'];
$nick = $_SESSION['login'];
date_default_timezone_set("Europe/Warsaw");
$data = date("Y-m-d");




?>
<head>

<title>Dodawanie multimediów</title>
<link rel="stylesheet" type="text/css" href="Data/cssAddEditor.css">
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script>
$(document).ready(function() {
$('.multimedia').children('div').hide();
$('#videoopt').hide();
$('#yt').hide();
$('.obj').change(function(){
		var target = $('input[name=obj]:checked').val();
		$('#kom').hide();
		$('.multimedia').children('div').hide();
		$('.multimedia').children('div [value="'+target+'"]').show();
		if (target == 'video'){
		$('#videoopt').show();
		}
		else{
		$('#videoopt').hide();
		}
	});
$('.objlink').change(function(){
	var  target = $('input[name=objlink]:checked').val();
	//alert(target);
	if (target == 'yt'){
	$('#dysk').hide();
	$('#yt').show();
	$('.vfile').removeAttr('required');
	$('#yt_link').attr("required","required"); 
	}
	else{
	$('#yt').hide();
	$('#dysk').show();
	$('#yt_link').removeAttr('required');
	$('.vfile').attr("required","required"); 
	}


});

});
</script>
</head>
<body>
<p>Wybierz obiekt do dodania:</p>
<p id="kom"><font color="red"><b>Wybierz jedną z opcji poniżej</b></font></p>
<input type="radio" class="obj"name="obj" id="fotoobj" value="foto"> Zdjęcia
<input type="radio" class="obj"name="obj" id="videoobj" value="video"> Filmy
<input type="radio" class="obj"name="obj" id="songobj"value="song"> Pliki dźwiękowe
<div id="videoopt">
<b>
	<input type="radio" class="objlink" name="objlink" id="dysklink" value="dysk" checked> Z dysku
	<input type="radio" class="objlink" name="objlink" id="ytlink" value="yt"> Z YouTube<br />
	</b>
	
</div>
<div class="multimedia" id ="multimedia">
<div id="foto" value="foto">
<hr width="400" align="left">
<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>
<p><b>Zaladuj zdjecia</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:
     <p><strong>Upload Files:</strong> <input type="file" accept="image/jpeg, image/gif, image/png" name="plik[]" id="filesToUpload" required="required"multiple="" onChange="makeFileList();" /></p>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="foto" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  <!-- w tym miejscu zrobi sie system miniatur przeslanych obrazkow -->
</div>
<div id="video" value="video">
<hr width="400" align="left">
<!--<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php //echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>
-->
<p><b>Zaladuj Film</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:<br />
	
	<div id="dysk">
	Obsługiwane typy plików:<br />
	WEBM, MP4, OGG (video), FLV, WMV, MPEG<br />
     <p><strong>Upload Files:</strong> <input class="vfile" type="file" accept="video/webm, video/mp4, video/ogg, video/x-flv, video/x-ms-wmv, video/mpeg" name="plik[]" id="filesToUpload" onChange="makeFileList();" required="required"/></p>
	 </div>
	 <div id="yt">
	 <p>Podaj link z serwisu YT<br /></p>
	 <input type="text" id="yt_link" name="yt_link" size="40" value="">
	 </div>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="film" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  </div>
<div id="song" value="song">
<hr width="400" align="left">
<!--<form method="post" action="uploadImg.php">
<input type="hidden" name="idWpisu" value="<?php //echo $idwpisu; ?>" />
<input type="submit" name="wyslij" value ="Obejrzyj zdjęcia">
</form>-->
<p><b>Zaladuj Plik dźwiękowy</b></p>
	<form method="post" enctype="multipart/form-data" action="addPhoto.php">
  <fieldset>
    <legend>Przeslij pliki</legend>
    <label>Dodaj pliki:<br />
	Obsługiwane typy plików:<br />
	MP3, OGG (audio), WAV<br />
     <p><strong>Upload Files:</strong> <input type="file" accept="audio/mpeg, audio/ogg, audio/wav" name="plik[]" id="filesToUpload" required="required" onChange="makeFileList();" /></p>
	 </label><br><input type="hidden" name="idWpisu" value="<?php echo $idwpisu; ?>" />
	 <input type="hidden" name="rodzaj" value="song" />
    <input type="submit" name="wyslij" value ="Wyslij zapytanie">
  </fieldset>
  </form>
  <!-- w tym miejscu zrobi sie system miniatur przeslanych obrazkow -->
  
  </div>
  </div>
<div><p>Wybrane pliki</p>
  <ul id="fileList"><li>No Files Selected</li></ul>
	
	<script type="text/javascript">
		function makeFileList() {
			var input = document.getElementById("filesToUpload");
			var ul = document.getElementById("fileList");
			while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < input.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = input.files[i].name;
				ul.appendChild(li);
			}
			if(!ul.hasChildNodes()) {
				var li = document.createElement("li");
				li.innerHTML = 'No Files Selected';
				ul.appendChild(li);
			}
		}
	</script>
  
  </div>

<script>


	$(".wpisz").click(function() {
	$(this).attr("value","");
	$(this).css("color","black");
	});	
</script>
</body>
</div>
<?php
}
else{
   echo '<br><span style="color: red; font-weight: bold;">Nie został wpis, do którego mają być przesyłane nowe zdjęcia!</span><br>' ;
}
?>