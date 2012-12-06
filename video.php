<?php
include ("connection.php");
include ("getbrowser.php");

play("/upload/movie.webm");
function play($wideo){
$path_parts = pathinfo($wideo);
$ext = $path_parts['extension'];
$ext = strtolower($ext);
echo $ext, "\n";

/*****MP4*****/
if ($ext == "mp4"){
 if (getbrowser() == "ie" || getbrowser() == "chrome" || getbrowser() == "safari"){
?>
<video width="320" height="240" controls="controls">
<source src="<?php echo $wideo; ?>" type="video/mp4">
Your browser does not support the video tag.
</video>
<?php
}
else{
?>
<object id="MediaPlayer1" width=300 height=300 classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="FileName" value="Your Video File.3gp"><param name="ShowStatusBar" value="true"><param name="autoStart" value="False"><param name="DefaultFrame" value="mainFrame"><embed type="video/mp4" pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" src="<?php echo $wideo; ?>" align="middle" width=300 height=291 autostart=1 defaultframe="rightFrame" showstatusbar=false></embed></object>

<?php
}
}
/*****WEBM*****/
elseif ($ext == "webm"){
 if (getbrowser() == "firefox" || getbrowser() == "chrome" || getbrowser() == "opera"){
?>
<video width="320" height="240" controls="controls">
<source src="<?php echo $wideo; ?>" type="video/webm">
Your browser does not support the video tag.
</video>
<?php
}
else{
?>
<object id="MediaPlayer1" width=300 height=300 classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject"><param name="FileName" value="Your Video File.3gp"><param name="ShowStatusBar" value="true"><param name="autoStart" value="False"><param name="DefaultFrame" value="mainFrame"><embed type="video/webm" pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" src="<?php echo $wideo; ?>" align="middle" width=300 height=291 autostart=1 defaultframe="rightFrame" showstatusbar=false></embed></object>

<?php
}
}



}





?>