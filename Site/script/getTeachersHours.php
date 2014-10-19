<?php

if(isset($_GET["codeProf"])) {
	$codeProf = $_GET["codeProf"];

	$sql = "SELECT * FROM `seances_profs` WHERE codeRessource:codeProf ";
	$req = $dbh->prepare($sql);
	$req->execute(array(':codeProf' => $codeProf));
} 


$allCSTeachers = array();

while($ligne = $req->fetch())
{
	$csTeacher = array('prenom' => $ligne['prenom'], 'nom' => $ligne['nom']);
	array_push($allCSTeachers, $csTeacher);
}

$req->closeCursor();

?>