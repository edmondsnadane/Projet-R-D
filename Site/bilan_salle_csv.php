<?php

session_start();

include("config.php");
error_reporting(E_ALL);


//recuperation du code du prof concerné
	if(isset($_SESSION['logged_prof_perso']))
	{
	$codeProf=$_SESSION['logged_prof_perso'];
	}
	else
	{
	$codeProf="";
	}
	
	if (isset($_GET['prof']))
	{
	$codeProf=$_GET['prof'];
	}

	
//récupération de variables
if (isset ($_GET['horiz']))
{
$horizon=$_GET['horiz'];
}
if(!isset($_GET['disconnect']))
{
$_GET['disconnect']="";
}
if (isset ($_GET['lar']))
{
$lar=$_GET['lar'];
}

if (isset ($_GET['hau']))
{
$hau=$_GET['hau'];
}

if (isset ($_GET['selec_prof']))
{
$selec_prof=$_GET['selec_prof'];
}

if (isset ($_GET['selec_groupe']))
{
$selec_groupe=$_GET['selec_groupe'];
}

if (isset ($_GET['selec_salle']))
{
$selec_salle=$_GET['selec_salle'];
}
if (isset ($_GET['selec_materiel']))
{
$selec_materiel=$_GET['selec_materiel'];
}
if (isset ($_GET['current_year']))
{
$current_year=$_GET['current_year'];
}

if (isset ($_GET['current_week']))
{
$current_week=$_GET['current_week'];
}

if (isset ($_GET['jour']))
{
$jour_jour_j=$_GET['jour'];
}
else 
{
$jour_jour_j=0;
}

if (isset ($_GET['annee_scolaire']))
{
$annee_scolaire_choisie=$_GET['annee_scolaire'];
}
else 
{
$annee_scolaire_choisie=$nbdebdd-1;
}	

//recupération variables pour savoir si on affiche les séances dans l'ordre chronologique ou trié par matière
if(isset($_GET['chrono']))
	{
	$chrono=$_GET['chrono'];
	}
else
	{
	$chrono='0';
	}


$salles_multi=array();
if (isset ($_GET['salles_multi']))
{
$salles_multi=$_GET['salles_multi'];
}
$groupes_multi=array(); 	
if(isset($_GET['groupes_multi']))
{
 $groupes_multi=$_GET['groupes_multi'];
}
$profs_multi=array(); 	
if(isset($_GET['profs_multi']))
{
 $profs_multi=$_GET['profs_multi'];
}	
if(isset($_GET['materiels_multi']))
{
 $materiels_multi=$_GET['materiels_multi'];
}	




//recuperation de la date du jour pour l'afficher au dessus du tableau
$jour=date('d');
$mois=date('m');
$annee=date('y');
$heure=date('H');
$minute=date('i');
	
	 
	 

	
	 
	if (isset($_SESSION['salle']))
{

if ($_SESSION['salle']=='1')
{ 
$fichier="";
$fichier.="Bilan de l'occupation des salles ";	 
$fichier.="(Année scolaire ".$annee_scolaire[$annee_scolaire_choisie].")"."\n";	 

$fichier.="Généré le ".$jour."/".$mois."/".$annee." à ".$heure."h".$minute."\n"."\n";


	 



//choix de la BDD
$dbh=null;

	$base_a_utiliser=$base[$annee_scolaire_choisie];
		try
		{
		$dbh=new PDO("mysql:host=$serveur;dbname=$base_a_utiliser;",$user,$pass);
		}

		catch(PDOException $e)
		{
		die("erreur ! : " .$e->getMessage());
		}


$fichier.='Salle;Zone;Séance (en heure);Réservation (en heure);Total (en heure);taux d\'occupation'. "\n";
	

$total_seance=0;
$total_réservation=0;
$total_seance_par_zone=0;
$total_réservation_par_zone=0;	
$memoire_zone="";
$premiere_ligne=0;
$compteur_de_salle=0;
$compteur_de_salle_zone=0;

	//requete pour avoir la liste des salles

	$sql="SELECT ressources_salles.codeSalle AS codeSalle,ressources_salles.nom AS salle, zones_salles.nom as nom_zone FROM ressources_salles   LEFT JOIN zones_salles on (zones_salles.codeZoneSalle=ressources_salles.codeZoneSalle) WHERE ressources_salles.deleted=0 and zones_salles.deleted=0  order by zones_salles.nom, ressources_salles.nom asc";

$req_liste_salle=$dbh->query($sql);
$res_liste_salle=$req_liste_salle->fetchAll();	
$i=0;
$nb_de_salle=count($res_liste_salle);

foreach ($res_liste_salle as $res_liste_salles)		
{
$i+=1;
	//requete pour avoir la durée des séances
	$sql="SELECT SUM(ROUND(dureeSeance/100)+100*(dureeSeance/100-ROUND(dureeSeance/100))/60) as heure FROM seances_salles  LEFT JOIN seances USING (codeSeance)  WHERE  seances_salles.deleted=0 AND seances.deleted=0 and seances_salles.codeRessource=".$res_liste_salles['codeSalle'];

$req_salle=$dbh->query($sql);
$res_salle=$req_salle->fetchAll();	

	

foreach ($res_salle as $res_salles)	
	{

	$compteur_de_salle+=1;
		$compteur_de_salle_zone+=1;
	//ligne bilan de chaque zone
		if ($memoire_zone!=$res_liste_salles['nom_zone'] && $premiere_ligne!=0)
	{
	$tot=$total_seance_par_zone+$total_réservation_par_zone;
	$tota=round(($total_seance_par_zone+$total_réservation_par_zone)/(1120*($compteur_de_salle_zone-1))*100,2);
	$fichier.='CUMUL DES HEURES DE LA ZONE CI-DESSUS; ;'.str_replace('.', ',', $total_seance_par_zone).';'.str_replace('.', ',', $total_réservation_par_zone).';'.str_replace('.', ',', $tot).';'.str_replace('.', ',', $tota)."%". "\n";
	

	//remise à zéro du compteur
$total_seance_par_zone=0;
$total_réservation_par_zone=0;	
$compteur_de_salle_zone=1;
	}
$premiere_ligne=1;	
	
	
	
	
	
	
	//requete pour avoir la durée des réservations
$sql="SELECT SUM(ROUND(dureeReservation/100)+100*(dureeReservation/100-ROUND(dureeReservation/100))/60) as heure FROM reservations_salles  LEFT JOIN reservations USING (codeReservation)  WHERE  reservations_salles.deleted=0 AND reservations.deleted=0 and reservations_salles.codeRessource=".$res_liste_salles['codeSalle'];

$req_reservation=$dbh->query($sql);
$res_reservation=$req_reservation->fetchAll();	

	

foreach ($res_reservation as $res_reservations)	
	{	
$duree_reservation=	$res_reservations['heure'];

}	

unset ($req_reservation);
		$tot=round($res_salles['heure'],2)+round($duree_reservation,2);
		$tota=round(((round($res_salles['heure'],2)+round($duree_reservation,2))/1120)*100,2);
	$fichier.=$res_liste_salles['salle'].";".$res_liste_salles['nom_zone'].";".str_replace('.', ',', round($res_salles['heure'],2)).";".str_replace('.', ',', round($duree_reservation,2)).";".str_replace('.', ',', $tot).";".str_replace('.', ',', $tota)."%". "\n";
		
		

	
	$total_seance+=round($res_salles['heure'],2);
	$total_réservation+=round($duree_reservation,2);
	$total_seance_par_zone+=round($res_salles['heure'],2);
$total_réservation_par_zone+=round($duree_reservation,2);
	

		//ligne bilan de la dernière zone
		if ($compteur_de_salle==$nb_de_salle)
	{
	$tot=$total_seance_par_zone+$total_réservation_par_zone;
	$tota=round(($total_seance_par_zone+$total_réservation_par_zone)/(1120*($compteur_de_salle_zone))*100,2);
		$fichier.='CUMUL DES HEURES DE LA ZONE CI-DESSUS; ;'.str_replace('.', ',', $total_seance_par_zone).';'.str_replace('.', ',', $total_réservation_par_zone).';'.str_replace('.', ',', $tot).';'.str_replace('.', ',', $tota)."%". "\n";
	

	}
	
	
	
	}
	unset ($req_salle);
	$memoire_zone=$res_liste_salles['nom_zone'];
}	
	
//derniere ligne du tableau
$tot=$total_seance+$total_réservation;
$tota=round(($total_seance+$total_réservation)/(1120*$nb_de_salle)*100,2);
$fichier.='CUMUL TOAL DES HEURES; ;'.str_replace('.', ',', $total_seance).';'.str_replace('.', ',', $total_réservation).';'.str_replace('.', ',', $tot).';'.str_replace('.', ',', $tota)."%". "\n";
	

}
}



$jour=date('d');

$mois=date('m');

$annee=date('y');
$heuredujour=date('H');
$minutedujour=date('i');

	$nomfichier="Bilan_salle"."_".$annee_scolaire[$annee_scolaire_choisie]."_".$jour."_".$mois."_".$annee."-".$heuredujour."h".$minutedujour.".csv";


	header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=$nomfichier");
echo $fichier;






