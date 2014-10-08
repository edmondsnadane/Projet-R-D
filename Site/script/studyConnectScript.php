<?php

session_start();

include('../config/config.php');

if (isset($_POST['studyLogin']) && !empty($_POST['studyLogin']))
{
	$find = FALSE;

	// si tout les champs sont remplis alors on regarde si le nom de compte rentré existe bien dans la base de données.
	$sql = "SELECT * FROM utilisateurs WHERE login = ".$dbh->quote($_POST['teachLogin'], PDO::PARAM_STR);   
	$req = $dbh->prepare($sql);
	$req->execute();
		  
	// Si oui, on continue le script...      
	while($find == FALSE && $ligne = $req->fetch())
	{
		$find = TRUE;
			
		// MAJ du compteur de visite
			
		// stockage dans des variables de sessions des infos utilisateurs
			
		// si Resté connecté cocher, stockage dans des cookies
	}

	$req->closeCursor();
				
	// Sinon on lui affiche un message d'erreur.
	if($find == FALSE)
	{
		header('Location: ../index.php?errorID=2');
		exit();
	}
	
	header('Location: ../index.php');
	exit();
}
else
{
	header('Location: ../index.php?errorID=1');
	exit();
}

?>