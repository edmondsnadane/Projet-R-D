<?php
$user='root';
$pass='';
$serveur='localhost';

$base=array();
$annee_scolaire=array();
$base[0]='vt_agenda';
$annee_scolaire[0]='2013-2014';
$nbdebdd='1';

date_default_timezone_set('Europe/Paris');

$k=$nbdebdd-1;
$dernierebase=$base[$k];

try
{
	$dbh=new PDO("mysql:host=$serveur;dbname=$dernierebase;",$user,$pass);
}
catch(PDOException $e)
{
	die("erreur ! : " .$e->getMessage());
}

?>