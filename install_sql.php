<?php
include ("connection.php");

echo "******Trwa instalacja bazy danych ******<br />";

// --------------------POCZĄTEK INSTALACJI BAZY--------------------
$sql = "SHOW TABLES FROM $mysql_db";
$result = mysql_query($sql);

if (!$result) {
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
$wynik = false;

// ********************DODAWANIE TABELI ZAŁĄCZNIKI********************
while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "zalaczniki"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`zalaczniki`");
if ($query){
  echo "Usunięto starą tabelę załączniki<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
    //exit;
  }
}

$query =mysql_query("CREATE  TABLE `$mysql_db`.`zalaczniki` (
  `idzal` BIGINT NOT NULL AUTO_INCREMENT ,
  `idwpisu` BIGINT NOT NULL ,
  `nickRed` VARCHAR(20) NOT NULL ,
  `komentarz` VARCHAR(255) NULL ,
  `dataDodania` DATE NOT NULL ,
  `url` VARCHAR(100) NOT NULL ,
  `rodzaj` VARCHAR(1) NOT NULL CHECK(Rodzaj IN ('Z','F','D')),
  PRIMARY KEY (`idzal`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę załączniki <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI ZAŁĄCZNIKI********************


// ********************DODAWANIE TABELI UZYTKOWNICY********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "uzytkownicy"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`uzytkownicy`");
if ($query){
  echo "Usunięto starą tabelę uzytkownicy<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
    //exit;
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`uzytkownicy` (
  `Nick` varchar(20) NOT NULL,
  `Haslo` varchar(32) NOT NULL,
  `Imie` varchar(20) NOT NULL,
  `Nazwisko` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Dostep` tinyint(4) NOT NULL,
  `DataRej` date NOT NULL,
  `KodIdent` varchar(16) NOT NULL,
  `OMnie` longtext NOT NULL,
  `DataUr` date NOT NULL,
  PRIMARY KEY (`Nick`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę użytkownicy <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI UZYTKOWNICY********************


// ********************DODAWANIE TABELI DZIENNIKI********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "dzienniki"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`dzienniki`");
if ($query){
  echo "Usunięto starą tabelę dzienniki<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
    //exit;
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`dzienniki` (
  `IdDziennika` varchar(20) NOT NULL,
  `Komentarze` char(3) DEFAULT NULL,
  `Nazwa` varchar(50) NOT NULL,
  PRIMARY KEY (`IdDziennika`)
)");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę dzienniki <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI DZIENNIKI********************

// ********************DODAWANIE TABELI KOMENTARZE********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "komentarze"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`komentarze`");
if ($query){
  echo "Usunięto starą tabelę komentarze<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`komentarze` (
  `IdKom` bigint(20) NOT NULL AUTO_INCREMENT,
  `IdWpisu` bigint(20) DEFAULT NULL,
  `IdUser` varchar(20) DEFAULT NULL,
  `Tresc` longtext NOT NULL,
  `Widoczny` char(3) DEFAULT NULL,
  `Ostrz` tinyint(4) DEFAULT NULL,
  `DataOstrz` date DEFAULT NULL,
  PRIMARY KEY (`IdKom`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę komentarze <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI KOMENTARZE********************


// ********************DODAWANIE TABELI OSTRZEZENIA********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "ostrzezenia"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`ostrzezenia`");
if ($query){
  echo "Usunięto starą tabelę ostrzeżenia<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`ostrzezenia` (
  `IDostrz` int(11) NOT NULL AUTO_INCREMENT,
  `URL` varchar(40) DEFAULT NULL,
  `NickUser` varchar(20) NOT NULL,
  `Data` date NOT NULL,
  `Powod` varchar(255) NOT NULL,
  `NickUz` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`IDostrz`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę ostrzeżenia <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI OSTRZEŻENIA********************

// ********************DODAWANIE TABELI REDAKTORZY********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "redaktorzy"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`redaktorzy`");
if ($query){
  echo "Usunięto starą tabelę redaktorzy<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`redaktorzy` (
  `IdRed` bigint(20) NOT NULL AUTO_INCREMENT,
  `NickRed` varchar(20) NOT NULL,
  `NazwaDziennika` varchar(20) NOT NULL,
  `EdycjaAutora` char(3) DEFAULT NULL,
  `EdycjaRedaktora` char(3) DEFAULT NULL,
  PRIMARY KEY (`IdRed`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę redaktorzy <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI REDAKTORZY********************

// ********************DODAWANIE TABELI WPISY********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "wpisy"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`wpisy`");
if ($query){
  echo "Usunięto starą tabelę wpisy<br />";
  }
  else{
    //echo 'MySQL Error: ' . mysql_error();
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`wpisy` (
  `IdWpis` bigint(20) NOT NULL AUTO_INCREMENT,
  `IdDziennika` varchar(20) NOT NULL,
  `Tytul` varchar(30) NOT NULL,
  `Tresc` varchar(300) NOT NULL,
  `NickRed` varchar(20) DEFAULT NULL,
  `DataWpisu` date NOT NULL,
  `LokX` float(10,10) DEFAULT NULL,
  `LokY` float(10,10) DEFAULT NULL,
  PRIMARY KEY (`IdWpis`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę wpisy <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI WPISY********************

// ********************DODAWANIE TABELI ZGŁOSZENIA********************

while ($row = mysql_fetch_row($result)) {
    if ($row[0] == "zgloszenia"){
	$wynik = true;
	}
}
if ($wynik == true){
$query=mysql_query("DROP TABLE `$mysql_db`.`zgloszenia`");
if ($query){
  echo "Usunięto starą tabelę zgłoszenia<br />";
  }
  else{
   // echo 'MySQL Error: ' . mysql_error();
  }
}

$query =mysql_query("CREATE TABLE `$mysql_db`.`zgloszenia` (
  `IdZgloszenia` bigint(20) NOT NULL AUTO_INCREMENT,
  `NickUsera` varchar(20) DEFAULT NULL,
  `Temat` varchar(30) NOT NULL,
  `Tresc` varchar(500) NOT NULL,
  `Url` varchar(40) DEFAULT NULL,
  `DataZgl` date NOT NULL,
  `StatusZgl` tinyint(4) NOT NULL,
  PRIMARY KEY (`IdZgloszenia`))");
  if ($query){
  echo "Twoja baza danych została uaktualniona o tabelę zgłoszenia <br />";
  }
  else{
    echo 'MySQL Error: ' . mysql_error();
    exit;
  }

// ********************KONIEC DODAWANIA TABELI ZGŁOSZENIA********************
// --------------------KONIEC INSTALACJI BAZY--------------------
echo "******ZAKOŃCZONO INSTALACJĘ BAZY****** <br />";
// --------------------WARTOŚCI TESTOWE--------------------
// ********************DODAWANIE KONT********************
echo "******Trwa dodawanie kont****** <br />";
$haslo = 'admin123';
$haslo = md5($haslo);

date_default_timezone_set("Europe/Warsaw"); 
$teraz = date("Y-m-d");
$admin = mysql_query("INSERT INTO `uzytkownicy` (Nick, Haslo, Imie, Nazwisko, Email, Dostep, DataRej, KodIdent, OMnie, DataUr) VALUES('admin','$haslo','administrator','administrator','admin@admin.admin','1','$teraz','0','Główny administrator systemu','1988-02-02')");
if ($admin){
 echo "Dodano konto administratora <br />";
 }
 else{
 echo mysql_error();
 }


?>