<?php 
/******************************************************
* connection.php 
* konfiguracja połączenia z bazą danych 
******************************************************/
    // serwer 
    $mysql_server = "localhost"; 
    // admin 
    $mysql_admin = "dziennik_user"; 
    // hasło 
    $mysql_pass = "Passw0rd"; 
    // nazwa baza 
    $mysql_db = "dziennik_db"; 
    // nawiązujemy połączenie z serwerem MySQL 
    @mysql_connect($mysql_server, $mysql_admin, $mysql_pass) 
    or die('Brak połączenia z serwerem MySQL. '.mysql_error()); 
	//echo ('Połączenie nawiązane');
    // łączymy się z bazą danych 
    @mysql_select_db($mysql_db) 
    or die('Błąd wyboru bazy danych. '.mysql_error()); 
	//echo ('<br />Baza wybrana');

?>