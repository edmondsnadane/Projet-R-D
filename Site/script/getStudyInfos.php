<?php

	$loginUtilisateur = "";

	if (isset($_SESSION['studyLogin']))
	{
		$loginUtilisateur = $_SESSION['studyLogin'];
	}
	else
	{
		$loginUtilisateur = $_COOKIE['studyLogin'];
	}

	$userName = "";

	// on récupere le nom et prenom reliés au login de l'étudiant
	$sql = "SELECT * FROM resources_etudiants WHERE identifiant = ".$dbh->quote($loginUtilisateur, PDO::PARAM_STR);   
	$req = $dbh->prepare($sql);
	$req->execute();
		  
	// Si oui, on continue le script...      
	while($ligne = $req->fetch())
	{
		$userName = $ligne['nom'];
	}

	$req->closeCursor();		

?>