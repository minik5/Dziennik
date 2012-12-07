<?php
///////////////////////////////////////////////////////////////////////////////
/// Name: Simple Gallery													///
/// Version: 2.5															///
/// Author: Allembru														///
/// Website: <http://www.allembru.com/>										///
/// Credits: jQuery <http://jquery.com/>, Fancybox <http://fancybox.net/>	///
///////////////////////////////////////////////////////////////////////////////
/// Simple Gallery v2.5 Photo Gallery Generator								///
/// Copyright (C) 2012  Allembru											///
///																			///
/// This program is free software: you can redistribute it and/or modify	///
/// it under the terms of the GNU General Public License as published by	///
/// the Free Software Foundation, either version 3 of the License.			///
///																			///
/// This program is distributed in the hope that it will be useful,			///
/// but WITHOUT ANY WARRANTY; without even the implied warranty of			///
/// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			///
/// GNU General Public License for more details.							///
///																			///
/// You should have received a copy of the GNU General Public License		///
/// along with this program.  If not, see <http://www.gnu.org/licenses/>	///
///////////////////////////////////////////////////////////////////////////////

require_once("../inc/functions.php");
include("../../connection.php");

if(isset($_POST['action'])) {
	$gallery_folder = "../../upload/";
	$sg_path = $_POST['sg_path'];
	$sg_main_category = $_POST['sg_main_category'];
	$sg_twidth = $_POST['sg_twidth'];
	$sg_theight = $_POST['sg_theight'];
	$idWpisu = $_POST['idWpisu'];
	if($_POST['action']=="loadData") {
		$crumbs = get_crumbs($gallery_folder, $sg_main_category);
		$dirs = get_dirs($gallery_folder);
		$images = get_images($gallery_folder);
	} else 
	if($_POST['action']=="changeDir") {
		$newdir = $_POST['newdir'];
		$crumbs = get_crumbs($newdir, $sg_main_category);
		$dirs = get_dirs($newdir);
		$images = get_images($newdir);
	}
	if($sg_path=='') {
		echo '<script type="text/javascript" src="simplegallery/js/fancybox/jquery.fancybox.js?v=2.0.6"></script>';
		echo '<link rel="stylesheet" type="text/css" href="simplegallery/css/style.css" media="screen" />';
		echo '<link rel="stylesheet" type="text/css" href="simplegallery/js/fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />';
	} else {
		echo '<script type="text/javascript" src="'.$sg_path.'/js/fancybox/jquery.fancybox.js?v=2.0.6"></script>';
		echo '<link rel="stylesheet" type="text/css" href="'.$sg_path.'/css/style.css" media="screen" />';
		echo '<link rel="stylesheet" type="text/css" href="'.$sg_path.'/js/fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />';
	}
	if($_POST['action']=="changeDir") {
		echo '<script>sg_reload("'.$sg_path.'", "'.$sg_main_category.'", "'.$sg_twidth.'", "'.$sg_theight.'");</script>';
	}
	if($crumbs) {
		$i=1;
		echo '<ul id="sg_crumbs">';
		foreach($crumbs as $value) {
			if($i==count($crumbs)) {
				echo '<li class="current" id="'.$value['path'].'">'.$value['name'].'</li>';
				$currentDir = $value['name'];
			} else {
				echo '<li id="'.$value['path'].'">'.$value['name'].'</li>';
			}
			$i++;
		}
		echo '</ul>';
	}
	if($dirs) {
		$i=1;
		echo '<ul id="sg_dirs">';
		foreach($dirs as $value) {
			if($i==count($dirs)) {
				echo '<li class="last" id="'.$value['path'].'">'.$value['name'].'</li>';
			} else {
				echo '<li id="'.$value['path'].'">'.$value['name'].'</li>';
			}
			$i++;
		}
		echo '</ul>';
	}
	if($images) {
		//**** edit by R.P.
		date_default_timezone_set("Europe/Warsaw");
		$query = mysql_query("SELECT * FROM zalaczniki WHERE idwpisu = $idWpisu ");
		$j = 0;
		$adresW = array();
		$komentarz = array();
		while ($row = mysql_fetch_array($query, MYSQL_NUM)) {// obcinanie nazw z folderu Upload
		//printf("ID: %s  Name: %s", $row[5], $row[1]);  
	    		$adres = explode("/",$row[5]);
				$adresW[$j] = $adres[1];
				$komentarz[$j] = $row[3];
				$rodzaj[$j] = $row[6];
				$j= $j+1;
        }
		//$row = mysql_fetch_array($query, MYSQL_BOTH);
		//echo $row['url'];
		//********
		echo '<ul id="sg_images">';
		 foreach($images as $value) {
			//**********
			
			$konc = explode("/",$value);
			//echo ' '.$konc[3].'';
			//echo $value;
			
		for($i = 0; $i < count($adresW); $i++)
		{
			if(strcmp($adresW[$i],$konc[3])==0){ //*****************
			if($sg_path=='') {
			//echo '   Przefiltrowany plik: '.$konc[3];
			//echo $currentDir;
				echo '<li><a href="simplegallery/inc/img.php?i='; if($rodzaj[$i]=='W'){echo '../../upload/play.jpg';}else if($rodzaj[$i]=='A'){
					echo '../../upload/music.jpg';}else{echo $value;}echo'" rel="'.$currentDir.'" title="'.$komentarz[$i].'">
					<img src="simplegallery/inc/img.php?c='; if($rodzaj[$i]=='W'){echo '../../upload/play.jpg';}else if($rodzaj[$i]=='A'){
					echo '../../upload/music.jpg';}else{echo $value;}echo'&w='.$sg_twidth.'&h='.$sg_theight.'"></a></li>';
			} else {
				echo '<li><a href="'.$sg_path.'simplegallery/inc/img.php?i='.$value.'" rel="'.$currentDir.'" title="'.$komentarz[$i].'"><img src="'.$sg_path.'simplegallery/inc/img.php?c='.$value.'&w='.$sg_twidth.'&h='.$sg_theight.'"></a></li>';
			}
			}
		}
		}
		echo '</ul>';
	}
	echo '<div style="clear:both;"></div>';
}