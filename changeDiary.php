<?php
include("connection.php");
session_start();

if (isset ($_POST['diaryname'])){
$diary = $_POST['diaryname'];


$query = mysql_query ("SELECT * FROM dzienniki WHERE IdDziennika = '$diary'");
if (mysql_num_rows($query) > 0){
		   $_SESSION['dziennik'] = $diary;
		   echo "success";
}
}


?>