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

function sg_load(sg_path, sg_main_category, sg_twidth, sg_theight) {
	if(sg_path=="") {
		var loader_path = "ajax/loader.php"; 
	} else {
		var loader_path = sg_path+"/ajax/loader.php"; 
	}
	$.post(loader_path, { 
		action: "loadData",
		sg_path: sg_path,
		sg_main_category: sg_main_category,
		sg_twidth: sg_twidth,
		sg_theight: sg_theight
	}, function(data) {
		if(data!='') {
			$("#simplegallery").empty().append(data);
			$('#sg_images li a').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',
				openEffect : 'elastic',
				openSpeed  : 300,
				closeEffect : 'elastic',
				closeSpeed  : 300,
				closeBtn  : false,
				arrows    : false,
				nextClick : true,
				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background-color' : '#eee'
						}
					}
				}
			});
			sg_reload(sg_path, sg_main_category, sg_twidth, sg_theight);
		}
	});
}
function sg_reload(sg_path, sg_main_category, sg_twidth, sg_theight) {
	$("#sg_crumbs li, #sg_dirs li").click(function() {
		if(sg_path=="") {
			var loader_path = "ajax/loader.php"; 
		} else {
			var loader_path = sg_path+"/ajax/loader.php"; 
		}
		$.post(loader_path, { 
			action: "changeDir",
			newdir:  this.id,
			sg_path: sg_path,
			sg_main_category: sg_main_category,
			sg_twidth: sg_twidth,
			sg_theight: sg_theight
		}, function(data) {
			if(data!='') {
				$("#simplegallery").empty().append(data);
			}
		});
	});
}
$(document).ready(function() {
	var thisURL = window.location.protocol + "://" + window.location.host + "/" + window.location.pathname;
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-12171642-1']);
	_gaq.push(['_setDomainName', 'allembru.com']);
	_gaq.push(['_trackPageview']);
	_gaq.push(['_trackEvent', 'Scripts', thisURL, 'Simple Gallery v2.5']);
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
});