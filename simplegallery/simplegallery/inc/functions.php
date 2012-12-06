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

function get_crumbs($dir,$sg_main_category) {
	$gallery_folder = "../gallery/";
	$i=0;
	if($dir==$gallery_folder) {
		$crumb[$i]['name'] = $sg_main_category;
		$crumb[$i]['path'] = $gallery_folder;
	} else {
		$split = explode(str_replace('../','',$gallery_folder),$dir);
		$folders = explode("/", $split[1]);
		$foldersCount = count($folders)-1;
		
		$crumb[$i]['name'] = $sg_main_category;
		$crumb[$i]['path'] = $gallery_folder;
		$i++;
	
		foreach($folders as $value) {
			if($value!='') {
				$j = $i-1;
				$crumb[$i]['name'] = $value;
				$crumb[$i]['path'] = $crumb[$j]['path'].$value.'/';
				$i++;
			}
		}
	}
	return $crumb;
}
function get_dirs($dir){
	$listDir = array();
	$i=0;
	if(is_dir($dir)) {
		if($handler = opendir($dir)) {
			while (($sub = readdir($handler)) !== FALSE) {
				if ($sub != "." && $sub != "..") {
					if(is_dir($dir."/".$sub)){
						$listDir[$i]['name'] = $sub;
						$listDir[$i]['path'] = $dir.$sub.'/';
						$i++;
					}
				}
			}
			closedir($handler);
		}
		return $listDir;
	} else {
		die("Could not read/find the images directory.");	
	}
}
function get_images($dir){
	$listDir = array();
	if(is_dir($dir)) {
		if($handler = opendir($dir)) {
			while (($sub = readdir($handler)) !== FALSE) {
				if ($sub != "Thumb.db" && $sub != "Thumbs.db") {
					if(is_file($dir."/".$sub)) {
						$listDir[] = $dir.$sub;
					}
				}
			}
			closedir($handler);
		}
		if(count($listDir)>0) {
			return $listDir;
		} else {
			die('There are no images in the "/simplegallery/gallery/" directory.');	
		}
	} else {
		die('Could not read/find the "/simplegallery/gallery/" directory.');	
	}
}
?>