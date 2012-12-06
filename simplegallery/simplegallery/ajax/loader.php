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

if(isset($_POST['action'])) {
	$gallery_folder = "../gallery/";
	$sg_path = $_POST['sg_path'];
	$sg_main_category = $_POST['sg_main_category'];
	$sg_twidth = $_POST['sg_twidth'];
	$sg_theight = $_POST['sg_theight'];
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
		echo '<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.0.6"></script>';
		echo '<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />';
		echo '<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.0.6" media="screen" />';
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
		echo '<ul id="sg_images">';
		foreach($images as $value) {
			if($sg_path=='') {
				echo '<li><a href="inc/img.php?i='.$value.'" rel="'.$currentDir.'" title=""><img src="inc/img.php?c='.$value.'&w='.$sg_twidth.'&h='.$sg_theight.'"></a></li>';
			} else {
				echo '<li><a href="'.$sg_path.'/inc/img.php?i='.$value.'" rel="'.$currentDir.'" title=""><img src="'.$sg_path.'/inc/img.php?c='.$value.'&w='.$sg_twidth.'&h='.$sg_theight.'"></a></li>';
			}
		}
		echo '</ul>';
	}
	echo '<div style="clear:both;"></div>';
}