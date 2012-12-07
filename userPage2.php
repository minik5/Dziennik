<!DOCTYPE html>

<html>
<head>

<title>Strona glowna</title>
<link rel="stylesheet" type="text/css" href="css/userMain2.css">

<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	
	$("a.menu").click(function() {
		$('.insideDiv').slideUp('fast');
		$('.insideDiv').css("display","none");
		$('.insideDiv').slideDown('fast');
	});

	$('#navigation > li').hover(function () {
 	  $('a',$(this)).stop().animate({'marginLeft':'15px'},200);
  		},
  		function () {
  	 $('a',$(this)).stop().animate({'marginLeft':'0px'},200);
 	 });

	$('#menuBox ul li a').click(function(){
			$('#menuBox ul li a').addClass('current').not(this).removeClass('current');		
	});
	$('#searchUserr').click(function(){
	$('.insideDiv').slideUp('fast');
		$('.insideDiv').css("display","none");
		$('.insideDiv').slideDown('fast');
	$('.insideDiv').load('profile.php?userid='+$('#userID').val());
	});
	
	$("#dodajD").click(function(){$('.insideDiv').load('addDiary.php') ;});	
	$("#dodajW").click(function(){$('.insideDiv').load('addTrip.php') ;});	
	$("#dodajZ").click(function(){$('.insideDiv').load('addInscription.php') ;});	
//	$("#edycjaZ").click(function(){$('.insideDiv').load('addDiary.php') ;});	
	$("#redakt").click(function(){$('.insideDiv').load('addEditor.php') ;});	
	$("#edycjaD").click(function(){$('.insideDiv').load('edit.php') ;});	
	$("#zglosze").click(function(){$('.insideDiv').load('reportForm.php') ;});	
	$("#wyloguj").click(function(){$('.insideDiv').load('wyloguj.php') ;});	
	

});
</script>
<style>

</style>
</head>
<body>

  <img alt="full screen background image" src="plaza.jpg" id="full-screen-background-image" /> 
<div id="container">
			<div id="menuBox">
			<ul id="navigation">
				<li><a href="#nothing" id="dodajD" class="menu" >Dodaj dziennik</a> </li>
				<li><a href="#nothing" id="dodajW" class="menu" >Dodaj wycieczke</a> </li>
				<li><a href="#nothing" id="dodajZ" class="menu" >Dodaj zdarzenie</a> </li>
				<li><a href="#nothing" id="edycjaZ" class="menu">Edycja zdarzen</a> </li>
				<li><a href="#nothing" id="redakt" class="menu">Redaktorzy</a>  </li>
				<li><a href="#nothing" id="edycjaD" class="menu">Edycja danych</a> </li>
				<li><a href="#nothing" id="zglosze" class="menu">Zgloszenia</a>   </li> 
				<li><a href="#nothing" id="wyloguj" class="menu">Wyloguj</a>   </li> 
				<!-- Search User -->
				<div class="search_panel">
					<input type="text" id="userID" size="22" name="nickuser" style="color:grey;">
					<input type="submit" id="searchUserr" name="wyslij" value="Wyszukaj u¿ytkownika">
				</div>	
		<!-- / Search User -->
			</ul>
			
			</div>
			<div class="insideDiv">
				
			</div>
</div>

</body>

</html>