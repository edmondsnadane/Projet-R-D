<?php

/**
 *
rss prof
 */
 include("../config.php");
 $code=$_GET['codeProf'];
 
// �dition du d�but du fichier XML
$xml = '<?xml version="1.0" encoding="iso-8859-1"?><rss version="2.0">';
$xml .= '<channel>';
$xml .= '<title>Derni�res mises � jour de mon emploi du temps</title>';
$xml .= '<link>http://ufrsitec.u-paris10.fr/edtpst/RSS/rss.php?codeProf='.$code.'</link>';
$xml .= '<description>Derni�res modifications de l\'EDT</description>';
//initialisation variables$date_modif_prof="";$date_modif_groupe="";$date_modif_salle="";
// Cr�ation requ�te
unset($requete);

if ($_GET['codeProf'] > 0) {
 $sql= "SELECT *, seances.deleted AS seance_deleted, seances.dureeSeance as duree, enseignements.nom AS nomens, seances.dateModif as date_modif_seance, seances.dateCreation as date_creation_seance, modifications.dateModif AS dateModifs, seances_profs.deleted AS seance_prof_deleted, seances_salles.deleted AS seance_salle_deleted, seances_groupes.deleted AS seance_groupe_deleted   FROM seances LEFT JOIN enseignements USING (codeEnseignement) right outer JOIN modifications on (seances.codeSeance=modifications.code) RIGHT JOIN seances_profs on (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN seances_salles on (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN seances_groupes on (seances_groupes.codeSeance=seances.codeSeance)  WHERE     seances_profs.codeRessource=:codeProf and modifications.typeObjet=9   ORDER BY modifications.dateModif DESC ";$req_prof=$dbh->prepare($sql);$req_prof->execute(array(':codeProf'=>$_GET['codeProf']));$profs=$req_prof->fetchAll();//preparation des requete pour les boucles suivantes	$sql= "SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (seances_profs.codeRessource=ressources_profs.codeProf) WHERE codeSeance=:codeSeance AND seances_profs.deleted='0' AND ressources_profs.deleted='0' ";	$req=$dbh->prepare($sql);		$sql=  "SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (seances_groupes.codeRessource=ressources_groupes.codeGroupe) WHERE codeSeance=:codeSeance AND seances_groupes.deleted='0' AND ressources_groupes.deleted='0'";	$req_groupe=$dbh->prepare($sql);		$sql= "SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (seances_salles.codeRessource=ressources_salles.codeSalle) WHERE codeSeance=:codeSeance AND seances_salles.deleted='0' AND ressources_salles.deleted='0'";	$req_salle=$dbh->prepare($sql);$compteur=1;$liste_code_seance=array();$liste_code_seance['0']="";foreach($profs as $tab) { if ($compteur==21) { break; }if (!in_array($tab['codeSeance'],$liste_code_seance))
{  $liste_code_seance[$compteur]=$tab['codeSeance'];  $compteur+=1;   $titre = utf8_decode($tab['nomens']);
    $titre = explode("_", $titre);	unset($req_type);	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;	$req_type=$dbh->prepare($sql);		$req_type->execute(array(':type_activite'=>$tab['codeTypeActivite']));	$res_types=$req_type->fetchAll();				      		foreach($res_types as $res_type)	{	$type= $res_type['alias'];	}			
    
    $titre = $titre[1];

    $dateseance = $tab['dateSeance'];
    $date3 = date("d-m-Y", strtotime($dateseance));
   
    // Listing des profs
	$req->execute(array(':codeSeance'=>$tab['codeSeance']));	$res1=$req->fetchAll();	
    unset($prof);$prof="";
    unset($i);$i='0';
	foreach($res1 as $tab1)	 {
        if ($i > 0) {
            $prof = $prof . " - ";
        }
        $prof = $prof . $tab1['nom'];
        $i++;$date_modif_prof=$tab1['dateModif'];
    }
    // Listing des groupes	$req_groupe->execute(array(':codeSeance'=>$tab['codeSeance']));	$res2=$req_groupe->fetchAll();
    unset($groupes);	$groupes="";    unset($i);	$i='0';	foreach($res2 as $tab2)
	{
        if ($i > 0) {
            $groupes = $groupes . " - ";
        }
        $groupes .= $tab2['nom'];
        $i++;$date_modif_groupe=$tab2['dateModif'];
    }
    // Listing des salles	$req_salle->execute(array(':codeSeance'=>$tab['codeSeance']));	$res3=$req_salle->fetchAll();
    unset($salles);	$salles="";    unset($i);	$i='0';	foreach($res3 as $tab3)	
	{
        if ($i > 0) {
            $salles = $salles . " - ";
        }
        $salles .= $tab3['nom'];
        $i++;$date_modif_salle=$tab3['dateModif'];
    }//trouver la date la plus r�cente de la modification de la seance$date_finale=$tab['date_modif_seance'];if ($date_finale<$tab['dateModifs']){$date_finale=$tab['dateModifs'];}	if ($date_finale<$date_modif_prof){$date_finale=$date_modif_prof;}if ($date_finale<$date_modif_groupe){$date_finale=$date_modif_groupe;}if ($date_finale<$date_modif_salle){$date_finale=$date_modif_salle;}    $date2 = date("D, d M Y H:i:s", strtotime($date_finale));	
// Calcul des horaires    $horaire_debut = substr((100 + substr($tab['heureSeance'], - strlen($tab['heureSeance']), strlen($tab['heureSeance']) - 2)), - 2, 2) . "h" . substr($tab['heureSeance'], - 2, 2);    $horaire_fin = (substr($tab['heureSeance'], - strlen($tab['heureSeance']), strlen($tab['heureSeance']) - 2) + substr($tab['heureSeance'], - 2, 2) / 60) + (substr($tab['duree'], - strlen($tab['duree']), strlen($tab['duree']) - 2) + substr($tab['duree'], - 2, 2) / 60);    $horaire_fin = substr(intval($horaire_fin + 100), - 2, 2) . "h" . substr(($horaire_fin - intval($horaire_fin)) * 60 + 100, - 2, 2);    // La s�ance a �t� supprim�e$j=0;    if ($tab['seance_deleted'] == 1)	{        $description = "La s�ance de " . $type . " de " . $titre ." du " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin . " a �t� supprim�e.";$j=1;    }    // Le prof a �t� supprim� de la s�ance    if ($tab['seance_prof_deleted'] == "1" && $tab['seance_deleted']==0){        $description = "La s�ance de " . $type . " de " . $titre . " du " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin ." en " . $salles. " a �t� attribu�e � " . $prof.".";$j=1;}			    // Le groupe a �t� supprim� de la s�ance    if ($tab['seance_groupe_deleted'] == "1" && $tab['seance_deleted']==0){        $description = "La s�ance de " . $type . " de " . $titre . " du " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin ." en " . $salles.  " se fera avec les " . $groupes.".";	$j=1;	}	    // La salle a �t� supprim� de la s�ance    if ($tab['seance_salle_deleted'] == 1 && $tab['seance_deleted']==0){        $description = "La s�ance de " . $type . " de " . $titre . " du " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin . " se fera en " . $salles.".";	$j=1;	}		    // Cr�ation s�ance    if ($tab['date_modif_seance'] == $tab['date_creation_seance'] && $tab['seance_deleted']==0 && $j==0){        $description = "La s�ance de " . $type . " de " . $titre . " avec les ".$groupes." vient d'�tre plac�e le " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin." en " . $salles."." ;	$j=1;	}	    // La s�ance a juste �t� modifi�e    if($j==0  && $tab['seance_deleted']==0)	{        $description = "Le " . $type . " de " . $titre . " avec les " . $groupes . " a �t� modifi�. Il aura maintenant lieu le " . $date3 . " de " . $horaire_debut . " � " . $horaire_fin . " en " . $salles . ".";}
    // On affiche pour un prof en particulier
    if ($_GET['codeProf'] > 0) {
        $title = $titre;
    }
    // Ou pour tout le d�partement
    else {
        $title = $prof;
    }
    // On g�n�re le contenu XML
    $xml .= '<item>';
    $xml .= '<title>' . $title . '</title>';
    $xml .= '<pubDate>' . $date2 . ' +0100</pubDate>';
    $xml .= '<description>' . $description . '</description>';
    $xml .= '</item>';
}}}
// �dition de la fin du fichier XML
$xml .= '</channel>';
$xml .= '</rss>';
// �criture dans le fichier
echo $xml;

@mysql_close();

?>