<?php

$sql="SELECT * FROM login_prof WHERE login=".$dbh->quote($loginUtilisateur, PDO::PARAM_STR);
$req = $dbh->prepare($sql);
$req->execute();
$droits = array();
		  
//on récupère l'ensemble des droits associés à un enseignant
while($ligne = $req->fetch())
{
	$droits = array('reservation' => $ligne['reservation'], 'module' => $ligne['module'], 'bilan_heure' => $ligne['bilan_heure'], 'configuration' => $ligne['configuration'], 'rss' => $ligne['rss'], 'bilan_heure_global' => $ligne['bilan_heure_global'], 'bilan_formation' => $ligne['bilan_formation'], 'pdf' => $ligne['pdf'], 'giseh' => $ligne['giseh'], 'dialogue' => $ligne['dialogue'], 'salle' => $ligne['salle'], 'mes_droits' => $ligne['mes_droits'], 'admin' => $ligne['admin'], 'seance_clicable' => $ligne['seance_clicable']);		
}

$req->closeCursor();

?>