<?php

	error_reporting(E_ALL);

	session_start();

	include('../config/config.php');

	$sql="UPDATE login_prof SET 
			admin=".$_POST['admin']." ,
			reservation=".$_POST['reservation'].",
			mes_droits=".$_POST['mes_droits'].",
			module=".$_POST['modules'].",
			bilan_heure=".$_POST['bilan_heure'].",
			configuration=".$_POST['configuration'].",
			rss=".$_POST['rss'].",
			bilan_heure_global=".$_POST['bilan_heure_global'].",
			bilan_formation=".$_POST['bilan_formation'].",
			pdf=".$_POST['pdf'].",
			giseh=".$_POST['giseh'].",
			dialogue=".$_POST['dialogue'].",
			salle=".$_POST['salle']." 
			WHERE codeProf=".$_POST['code'];
			
	$req=$dbh->prepare($sql);
	$req->execute();
	
	echo "Les droits ont été modifiés";

?>