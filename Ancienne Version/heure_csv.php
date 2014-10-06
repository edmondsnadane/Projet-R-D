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

$materiels_multi=array(); 	
if(isset($_GET['materiels_multi']))
{
 $materiels_multi=$_GET['materiels_multi'];
}
$total_heure_forfait_module_CM='';
	$total_min_forfait_module_CM='';
		$total_heure_forfait_module_TD='';
	$total_min_forfait_module_TD='';
		$total_heure_forfait_module_TP='';
	$total_min_forfait_module_TP='';
	
	
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

//recuperation de la date du jour pour l'afficher au dessus du tableau
$jour=date('d');
$mois=date('m');
$annee=date('y');
$heure=date('H');
$minute=date('i');
	
	 
	 
//requete pour avoir le nom et le prénom du prof
$sql="SELECT * FROM ressources_profs where codeProf=:codeProf AND deleted= '0'";
$req_prof=$dbh->prepare($sql);	
$req_prof->execute(array(':codeProf'=>$codeProf));

$res_prof=$req_prof->fetchAll();
foreach ($res_prof as $prof)
	{
		$prof_nom=$prof['nom'];
		$prof_prenom=ucwords(strtolower($prof['prenom'])) ;
		
	}	
	
	 
	 
$fichier="";
$fichier.="Liste de mes heures"."\n";	 
$fichier.="(".$prof_prenom." ".$prof_nom.")"."\n";	 

$fichier.="Généré le ".$jour."/".$mois."/".$annee." à ".$heure."h".$minute."\n"."\n";


if ($chrono=="1")
{
$fichier.='Formation;Code apogée;Matière;Date;Heure de début;Heure de fin;Horaire réparti / nb profs;Forfait;CR;TD;TP;EqTD;Cumul'."\n";	
}
else
{
$fichier.='Formation;Code apogée;Matière;Date;Heure de début;Heure de fin;Horaire réparti / nb profs;Forfait;CR;TD;TP;EqTD'."\n";	
}



	



//initialisation des variables
$total_heure_eqtd="";
$total_min_eqtd="";
$total_heure_cr="";
$total_min_cr="";
$total_heure_td="";
$total_min_td="";
$total_heure_tp="";
$total_min_tp="";
$total_heure_forfait="";
$total_min_forfait="";
$bgcolor="silver";
$variable_couleur=0;
$affichage_eqtd=0;

	
//préparation des requetes

	//requete pour avoir la liste des séances des profs
	if($chrono=='1')
	{
		$sql="SELECT * FROM seances_profs left join (seances) on (seances.codeSeance=seances_profs.codeSeance )  where seances_profs.codeRessource=:codeProf AND seances_profs.deleted='0' AND seances.deleted='0' AND seances.annulee='0' order by seances.dateSeance,seances.heureSeance";
	}
	elseif ($chrono=='0')
	{
		$sql="SELECT * FROM seances left join (seances_profs) on (seances.codeSeance=seances_profs.codeSeance ) left join (enseignements) on (seances.codeEnseignement=enseignements.codeEnseignement) right join (matieres) on (matieres.codeMatiere=enseignements.codeMatiere) where seances_profs.codeRessource=:codeProf AND seances_profs.deleted='0' AND seances.deleted='0' and matieres.deleted='0' and enseignements.deleted='0'  AND seances.annulee='0'  order by matieres.nom,seances.dateSeance,seances.heureSeance";
	}
	else
	{
		$sql="SELECT *, enseignements.identifiant as codeapogee  FROM seances left join (seances_profs) on (seances.codeSeance=seances_profs.codeSeance ) left join (enseignements) on (seances.codeEnseignement=enseignements.codeEnseignement) right join (matieres) on (matieres.codeMatiere=enseignements.codeMatiere) where seances_profs.codeRessource=:codeProf AND seances_profs.deleted='0' AND seances.deleted='0' and matieres.deleted='0' and enseignements.deleted='0'  AND seances.annulee='0'  order by enseignements.identifiant,matieres.nom,seances.dateSeance,seances.heureSeance";
	}	
	$req_seances_prof=$dbh->prepare($sql);
	//requete pour avoir les groupes associés aux séances	
	$sql="SELECT * FROM seances_groupes where codeSeance=:code_seance_prof  and deleted= '0'";
	$req_seances_groupe=$dbh->prepare($sql);
	//requete pour avoir le nom des groupes associés aux séances	
	$sql="SELECT * FROM ressources_groupes where codeGroupe=:codeGroupe AND deleted= '0'";
	$req_noms_groupe=$dbh->prepare($sql);
	// requete pour avoir info sur la séance (date durée...)
	$sql="SELECT * FROM seances where codeSeance=:codeSeance AND deleted= '0'";
	$req_seances=$dbh->prepare($sql);
	// requete pour avoir info sur les enseignements
	$sql="SELECT * FROM enseignements where codeEnseignement=:codeEnseignement AND deleted= '0'";
	$req_enseignements=$dbh->prepare($sql);
	//requete pour comptere le nb de prof associé à la séance
	$sql="SELECT * FROM seances_profs where seances_profs.deleted='0' and seances_profs.codeSeance=:codeSeance  ";
	$req_nb_prof=$dbh->prepare($sql);
	//requete pour comptere le nb de seances associé à l'enseignement
	$sql="SELECT * FROM seances left join seances_profs on seances.codeSeance=seances_profs.codeSeance where seances.deleted='0' and seances_profs.deleted='0' and seances_profs.codeRessource=:codeProf and seances.codeEnseignement=:codeEnseignement  ";
	$req_nb_seances=$dbh->prepare($sql);
	//requete pour avoir la liste des enseignements forfaitaires
	$sql="SELECT * FROM enseignements left join (enseignements_profs) on (enseignements.codeEnseignement=enseignements_profs.codeEnseignement )  where enseignements_profs.codeRessource=:codeProf AND enseignements_profs.deleted='0' AND enseignements.forfaitaire='1' AND enseignements.deleted='0' order by enseignements.nom";
	$req_enseignement_forfait_pur=$dbh->prepare($sql);
	//requete pour compter le nb de profs associés à l'enseignement forfaitaire
	$sql="SELECT * FROM enseignements_profs where enseignements_profs.deleted='0' and enseignements_profs.codeEnseignement=:codeEnseignement  ";
	$req_nb_prof_enseignement_forfait_pur=$dbh->prepare($sql);
	//requete pour avoir le nom des groupes associés au forfait
	$sql="SELECT * FROM enseignements_groupes where enseignements_groupes.deleted='0' and enseignements_groupes.codeEnseignement=:codeEnseignement  ";
	$req_groupes_enseignement_forfait_pur=$dbh->prepare($sql);
	//Requete pour avoir le nom du groupe de plus haut niveau pour l'afficher dans la ligne des cumules
	$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
	$req_groupes_de_niveau_sup=$dbh->prepare($sql);
	//requete pour avoir la liste des séances des profs non comptabilisées
	$sql="SELECT * FROM seances_profs_non_comptabilisees WHERE codeSeance=:codeSeance AND deleted= '0'";
	$req_seance_non_comptabilisee=$dbh->prepare($sql);		

	
	

	
		
	
//requete pour avoir la liste des séances des profs
$req_seances_prof->execute(array(':codeProf'=>$codeProf));
$res_seances_prof=$req_seances_prof->fetchAll();
//memorisation du code de la matière pour afficher le sous total des heures lors du changmeent de module
$memoire_code_matiere="";
//memorisation du code apogee pour afficher le sous total des heures lors du changmeent de code apogee
$memoire_code_apogee="";
//variable pour savoir si on est en train de traiter la toute première seance ou pas.
$premiere_seance='1';
//initialisation compteur nb heure dans un EC (module)
$total_heure_cr_module='';
$total_min_cr_module='';
$total_heure_td_module='';
$total_min_td_module='';
$total_heure_tp_module='';
$total_min_tp_module='';
$total_heure_forfait_module='';
$total_min_forfait_module='';
$total_heure_eqtd_module='';
$total_min_eqtd_module='';


foreach ($res_seances_prof as $seance_prof)	
	{
	
	$seance_non_comptabilisee="0";
	//requete pour avoir la liste des séances des profs non comptabilisées
		
	$req_seance_non_comptabilisee->execute(array(':codeSeance'=>$seance_prof['codeSeance']));
	$res_seance_non_comptabilisee=$req_seance_non_comptabilisee->fetchAll();	
	foreach ($res_seance_non_comptabilisee as $res_seances_non_comptabilisees)	
		{
		$seance_non_comptabilisee="1";
		}
	if ($seance_non_comptabilisee=='0')	
		{
	
	
	//si on est  dans l'affichage par matiere et que l'on change d'EC, on affiche le sous total des heures de l'EC précédente
	if ($chrono=='0')
	{
	if ($memoire_code_matiere!=$seance_prof['codeMatiere'] && $premiere_seance=='0' )
	{
	//mis en forme de l'heure
		$total_heure_eqtd_en_min_module=$total_heure_eqtd_module*60+$total_min_eqtd_module;
	$total_heure_eqtd_module=intval($total_heure_eqtd_en_min_module/60);
	$total_min_eqtd_module=$total_heure_eqtd_en_min_module%60;
	if (strlen($total_heure_eqtd_module)==1)
		{
		$total_heure_eqtd_module="0".$total_heure_eqtd_module;
		}

	if (strlen($total_min_eqtd_module)==1)
		{
		$total_min_eqtd_module="0".$total_min_eqtd_module;
		}
	if (strlen($total_min_eqtd_module)==0)
		{
		$total_min_eqtd_module="00";
		}

	$total_heure_cr_en_min_module=$total_heure_cr_module*60+$total_min_cr_module+$total_heure_forfait_module_CM*60+$total_min_forfait_module_CM;;
	$total_heure_cr_module=intval($total_heure_cr_en_min_module/60);
	$total_min_cr_module=$total_heure_cr_en_min_module%60;
	if ($total_heure_cr_module==0 and $total_min_cr_module==0)
		{
		$total_heure_cr_module="";
		$total_min_cr_module="";
		}
	if (strlen($total_heure_cr_module)==1)
		{
		$total_heure_cr_module="0".$total_heure_cr_module;
		}
	if (strlen($total_min_cr_module)==1)
		{
		$total_min_cr_module="0".$total_min_cr_module;
		}

	$total_heure_td_en_min_module=$total_heure_td_module*60+$total_min_td_module+$total_heure_forfait_module_TD*60+$total_min_forfait_module_TD;
	$total_heure_td_module=intval($total_heure_td_en_min_module/60);
	$total_min_td_module=$total_heure_td_en_min_module%60;
	if ($total_heure_td_module==0 and $total_min_td_module==0)
		{
		$total_heure_td_module="";
		$total_min_td_module="";
		}
	if (strlen($total_heure_td_module)==1)
		{
		$total_heure_td_module="0".$total_heure_td_module;
		}
	if (strlen($total_min_td_module)==1)
		{
		$total_min_td_module="0".$total_min_td_module;
		}

	$total_heure_tp_en_min_module=$total_heure_tp_module*60+$total_min_tp_module+$total_heure_forfait_module_TP*60+$total_min_forfait_module_TP;
	$total_heure_tp_module=intval($total_heure_tp_en_min_module/60);
	$total_min_tp_module=$total_heure_tp_en_min_module%60;
	if ($total_heure_tp_module==0 and $total_min_tp_module==0)
		{
		$total_heure_tp_module="";
		$total_min_tp_module="";
		}
	if (strlen($total_heure_tp_module)==1)
		{
		$total_heure_tp_module="0".$total_heure_tp_module;
		}
	if (strlen($total_min_tp_module)==1)
		{
		$total_min_tp_module="0".$total_min_tp_module;
		}


		
	$fichier.=$nom_groupe_niv_sup.";".$memoire_code_identifiant.";"."CUMUL DES HEURES POUR L'EC CI-DESSUS".";;;;;;";
		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{
		$fichier.=$total_heure_cr_module."h".$total_min_cr_module.";";
	
		}
	else
		{
			$fichier.=";";

		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{
		$fichier.=$total_heure_td_module."h".$total_min_td_module.";";
		
		}
	else
		{
		$fichier.=";";
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{
		$fichier.=$total_heure_tp_module."h".$total_min_tp_module.";";
		}
	else
		{
		$fichier.=";";
		}

		
	$fichier.=$total_heure_eqtd_module."h".$total_min_eqtd_module."\n";	
		
	$total_heure_cr_module='';
	$total_min_cr_module='';
	$total_heure_td_module='';
	$total_min_td_module='';
	$total_heure_tp_module='';
	$total_min_tp_module='';
	$total_heure_forfait_module_CM='';
	$total_min_forfait_module_CM='';
		$total_heure_forfait_module_TD='';
	$total_min_forfait_module_TD='';
		$total_heure_forfait_module_TP='';
	$total_min_forfait_module_TP='';
	$total_heure_eqtd_module='';
	$total_min_eqtd_module='';
	}
	}
	
	
	//si on est  dans l'affichage par code apogee et que l'on change d'EC, on affiche le sous total des heures de l'EC précédente
	if ($chrono=='2')
	{
	if ($memoire_code_apogee!=$seance_prof['codeapogee'] && $premiere_seance=='0' )
	{
	//mis en forme de l'heure
		$total_heure_eqtd_en_min_module=$total_heure_eqtd_module*60+$total_min_eqtd_module;
	$total_heure_eqtd_module=intval($total_heure_eqtd_en_min_module/60);
	$total_min_eqtd_module=$total_heure_eqtd_en_min_module%60;
	if (strlen($total_heure_eqtd_module)==1)
		{
		$total_heure_eqtd_module="0".$total_heure_eqtd_module;
		}

	if (strlen($total_min_eqtd_module)==1)
		{
		$total_min_eqtd_module="0".$total_min_eqtd_module;
		}
	if (strlen($total_min_eqtd_module)==0)
		{
		$total_min_eqtd_module="00";
		}

	$total_heure_cr_en_min_module=$total_heure_cr_module*60+$total_min_cr_module+$total_heure_forfait_module_CM*60+$total_min_forfait_module_CM;
	$total_heure_cr_module=intval($total_heure_cr_en_min_module/60);
	$total_min_cr_module=$total_heure_cr_en_min_module%60;
	if ($total_heure_cr_module==0 and $total_min_cr_module==0)
		{
		$total_heure_cr_module="";
		$total_min_cr_module="";
		}
	if (strlen($total_heure_cr_module)==1)
		{
		$total_heure_cr_module="0".$total_heure_cr_module;
		}
	if (strlen($total_min_cr_module)==1)
		{
		$total_min_cr_module="0".$total_min_cr_module;
		}

	$total_heure_td_en_min_module=$total_heure_td_module*60+$total_min_td_module+$total_heure_forfait_module_TD*60+$total_min_forfait_module_TD;
	$total_heure_td_module=intval($total_heure_td_en_min_module/60);
	$total_min_td_module=$total_heure_td_en_min_module%60;
	if ($total_heure_td_module==0 and $total_min_td_module==0)
		{
		$total_heure_td_module="";
		$total_min_td_module="";
		}
	if (strlen($total_heure_td_module)==1)
		{
		$total_heure_td_module="0".$total_heure_td_module;
		}
	if (strlen($total_min_td_module)==1)
		{
		$total_min_td_module="0".$total_min_td_module;
		}

	$total_heure_tp_en_min_module=$total_heure_tp_module*60+$total_min_tp_module+$total_heure_forfait_module_TP*60+$total_min_forfait_module_TP;
	$total_heure_tp_module=intval($total_heure_tp_en_min_module/60);
	$total_min_tp_module=$total_heure_tp_en_min_module%60;
	if ($total_heure_tp_module==0 and $total_min_tp_module==0)
		{
		$total_heure_tp_module="";
		$total_min_tp_module="";
		}
	if (strlen($total_heure_tp_module)==1)
		{
		$total_heure_tp_module="0".$total_heure_tp_module;
		}
	if (strlen($total_min_tp_module)==1)
		{
		$total_min_tp_module="0".$total_min_tp_module;
		}

	
		
	$fichier.=$nom_groupe_niv_sup.";".$memoire_code_identifiant.";"."CUMUL DES HEURES POUR L'EC CI-DESSUS".";;;;;;";
		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{
		$fichier.=$total_heure_cr_module."h".$total_min_cr_module.";";
	
		}
	else
		{
			$fichier.=";";

		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{
		$fichier.=$total_heure_td_module."h".$total_min_td_module.";";
		
		}
	else
		{
		$fichier.=";";
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{
		$fichier.=$total_heure_tp_module."h".$total_min_tp_module.";";
		}
	else
		{
		$fichier.=";";
		}

		
	$fichier.=$total_heure_eqtd_module."h".$total_min_eqtd_module."\n";	
		
	$total_heure_cr_module='';
	$total_min_cr_module='';
	$total_heure_td_module='';
	$total_min_td_module='';
	$total_heure_tp_module='';
	$total_min_tp_module='';
	$total_heure_forfait_module_CM='';
	$total_min_forfait_module_CM='';
		$total_heure_forfait_module_TD='';
	$total_min_forfait_module_TD='';
		$total_heure_forfait_module_TP='';
	$total_min_forfait_module_TP='';
	
	$total_heure_eqtd_module='';
	$total_min_eqtd_module='';
	}
	}	
	
	$premiere_seance='0';
	
	
	if($chrono=='0')
	{
	$memoire_code_matiere=$seance_prof['codeMatiere'];
	}
	if($chrono=='2')
	{
	$memoire_code_apogee=$seance_prof['codeapogee'];
	}
	$code_seance_prof=$seance_prof['codeSeance'];
	//requete pour avoir les groupes associés aux séances	
	$req_seances_groupe->execute(array(':code_seance_prof'=>$code_seance_prof));
	$res_seances_groupe=$req_seances_groupe->fetchAll();
	$seance_groupe_codeSeance="";
	$nom_seance_groupe="";
	foreach ($res_seances_groupe as $seance_groupe)
		{
		$seance_groupe_codeSeance=$seance_groupe['codeSeance'];
		//requete pour avoir le nom des groupes associés aux séances	
		$code_groupe=$seance_groupe['codeRessource'];
		$req_noms_groupe->execute(array(':codeGroupe'=>$code_groupe));
		$res_noms_groupe=$req_noms_groupe->fetchAll();
		foreach ($res_noms_groupe as $groupe)
			{
			$nom_seance_groupe=$nom_seance_groupe.$groupe['nom']." ";
			}
			
		//Requete pour avoir le nom du groupe de plus haut niveau pour l'afficher dans la ligne des cumules
		$groupe_niveau_sup=$code_groupe;
		$stop=0;
		while ($stop!=1)
			{
				$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupe_niveau_sup));
				$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
				if (count($res_groupes_de_niveau_sup)>0)
					{
					foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
						{
						$groupe_niveau_sup=$groupe_de_niveau_sup['codeRessource'];
						}
					}
				else 
					{
					$stop=1;		
					}
			}
		$req_noms_groupe->execute(array(':codeGroupe'=>$groupe_niveau_sup));
		$res_noms_groupe=$req_noms_groupe->fetchAll();
		foreach ($res_noms_groupe as $groupe_niv_sup)
			{
			$nom_groupe_niv_sup=$groupe_niv_sup['nom']." ";
					
			}	
			
		}

	// requete pour avoir info sur la séance (date durée...)
	$req_seances->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
	$res_seances=$req_seances->fetchAll();
	foreach ($res_seances as $seance)
		{
		$annee=substr($seance['dateSeance'],0,4);
		$mois=substr($seance['dateSeance'],5,2);
		$jour=substr($seance['dateSeance'],8,2);
		$date_seance=$annee.$mois.$jour;
		$code_enseignement=$seance['codeEnseignement'];
		}


	// requete pour avoir info sur les enseignements
	$req_enseignements->execute(array(':codeEnseignement'=>$code_enseignement));
	$res_enseignements=$req_enseignements->fetchAll();
	foreach ($res_enseignements as $enseignement)
		{
		$forfait=$enseignement['forfaitaire'];
		}

	$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
	
	//inversion des couleurs pour avoir blanc ou gris une ligne sur 2
	if ($bgcolor=="white")
		{
		$bgcolor="silver";
		}
	else
		{
		$bgcolor="white";
		}


	//comptage du nb de profs associés à la séance
	$nb_profs=0;
	//requete pour comptere le nb de prof associé à la séance
	$req_nb_prof->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
	$res_nb_prof=$req_nb_prof->fetchAll();
	foreach ($res_nb_prof as $profs_seance)
		{
		$nb_profs=$nb_profs+1;
		}



	//duree cr td tp
	if (strlen($seance['dureeSeance'])==4)
		{
		$heureduree=substr($seance['dureeSeance'],0,2);
		$minduree=substr($seance['dureeSeance'],2,2);
		}
	if (strlen($seance['dureeSeance'])==3)
		{
		$heureduree=substr($seance['dureeSeance'],0,1);
		$minduree=substr($seance['dureeSeance'],1,2);
		}
	if (strlen($seance['dureeSeance'])==2)
		{
		$heureduree=0;
		$minduree=$seance['dureeSeance'];
		}
	if (strlen($heureduree)==1)
		{
		$heureduree="0".$heureduree;
		}	

	//heure debut seance
	if (strlen($seance['heureSeance'])==4)
		{
		$heuredebut=substr($seance['heureSeance'],0,2);
		$mindebut=substr($seance['heureSeance'],2,2);
		}
	if (strlen($seance['heureSeance'])==3)
		{
		$heuredebut=substr($seance['heureSeance'],0,1);
		$mindebut=substr($seance['heureSeance'],1,2);
		}
	if (strlen($seance['heureSeance'])==2)
		{
		$heuredebut=0;
		$mindebut=$seance['heureSeance'];
		}
	if (strlen($heuredebut)==1)
		{
		$heuredebut="0".$heuredebut;
		}	
		
	//heure fin seance
	$heurefinenmin=$heuredebut*60+$mindebut+$heureduree*60+$minduree;
	$heurefin=intval($heurefinenmin/60);
	if (strlen($heurefin)==1)
		{
		$heurefin="0".$heurefin;
		}
	$minfin=$heurefinenmin%60;
	if (strlen($minfin)==1)
		{
		$minfin="0".$minfin;
		}

	//annee mois jour de la seance
	$annee=substr($seance['dateSeance'],0,4);
	$mois=substr($seance['dateSeance'],5,2);
	$jour=substr($seance['dateSeance'],8,2);		

	//mise en forme nom de l'enseignement
	$pos_dudebut = strpos($enseignement['nom'], "_")+1;	
	$pos_defin = strripos($enseignement['nom'], "_");	
	$longueur=$pos_defin-$pos_dudebut;
	$nomenseignement=substr($enseignement['nom'],$pos_dudebut,$longueur);
$fichier.=$nom_seance_groupe.";".$enseignement['identifiant'].";".$nomenseignement.";".$jour."-".$mois."-".$annee.";".$heuredebut."h".$mindebut.";".$heurefin."h".$minfin.";";

	//memorisation de l'identifiant (code apogée) pour l'afficher dans le cumul des heures de l'EC
	$memoire_code_identifiant=$enseignement['identifiant'];



	
	if ($enseignement['volumeReparti']==1)
		{
		$fichier.="OUI / ".$nb_profs.";";
				}
	else
		{
		$fichier.="NON".";";
		}
$CodeActivite=$enseignement['codeTypeActivite'];
	if ($enseignement['forfaitaire']==0)
		{
		 if ($enseignement['volumeReparti']==1)
				{
				$dureeenmin=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs;
				}
				else
				{
				$dureeenmin=$heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2];
				}
				$heureeqtd=intval($dureeenmin/60);
														
				if (strlen($heureeqtd)==1)
					{
						$heureeqtd="0".$heureeqtd;
					}
				$mineqtd=$dureeenmin%60;
				if (strlen($mineqtd)==1)
					{
						$mineqtd="0".$mineqtd;
					}
				if (strlen($mineqtd)==0)
					{
						$mineqtd="00";
					}
					
// calcul de l'affichage de la durée effective	par prof					
				if ($enseignement['volumeReparti']==1)
				{
				$dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_profs;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_profs;
				$dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_profs;
        }
				else
				{
				$dureeenminCM=$heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0];
				$dureeenminTD=$heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1];
				$dureeenminTP=$heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2];
				}
				
        $heuredureeCM=intval($dureeenminCM/60);
				$heuredureeTD=intval($dureeenminTD/60);
				$heuredureeTP=intval($dureeenminTP/60);

// conversion des durées CM														
				if (strlen($heuredureeCM)==1)
					{
						$heuredureeCM="0".$heuredureeCM;
					}
				$mindureeCM=$dureeenminCM%60;
				if (strlen($mindureeCM)==1)
					{
						$mindureeCM="0".$mindureeCM;
					}
				if (strlen($mindureeCM)==0)
					{
						$mindureeCM="00";
					}			

// conversion des durées TD														
				if (strlen($heuredureeTD)==1)
					{
						$heuredureeTD="0".$heuredureeTD;
					}
				$mindureeTD=$dureeenminTD%60;
				if (strlen($mindureeTD)==1)
					{
						$mindureeTD="0".$mindureeTD;
					}
				if (strlen($mindureeTD)==0)
					{
						$mindureeTD="00";
					}			

// conversion des durées TP													
				if (strlen($heuredureeTP)==1)
					{
						$heuredureeTP="0".$heuredureeTP;
					}
				$mindureeTP=$dureeenminTP%60;
				if (strlen($mindureeTP)==1)
					{
						$mindureeTP="0".$mindureeTP;
					}
				if (strlen($mindureeTP)==0)
					{
						$mindureeTP="00";
					}	




			$dureeeqtd=$heureeqtd."h".$mineqtd;
			$fichier.="NON;";
			
			if($heuredureeCM!="00" or $mindureeCM!="00") 
			{
			$fichier.=$heuredureeCM."h".$mindureeCM.";";
			} 
			else
			{
			$fichier.=";";
			}
			if($heuredureeTD!="00" or $mindureeTD!="00") 
			{
			$fichier.=$heuredureeTD."h".$mindureeTD.";";
			} 
			else
			{
			$fichier.=";";
			}
						if($heuredureeTP!="00" or $mindureeTP!="00") 
			{
			$fichier.=$heuredureeTP."h".$mindureeTP.";";
			} 
			else
			{
			$fichier.=";";
			}
			if ($chrono=="1")
			{
			$fichier.=$dureeeqtd.";";
			}
			else
			{
			$fichier.=$dureeeqtd.";"."\n";
			}
			
			$total_heure_eqtd+=$heureeqtd;
			$total_min_eqtd+=$mineqtd;
			$total_heure_cr+=$heuredureeCM;
			$total_min_cr+=$mindureeCM;
			$total_heure_cr_module+=$heuredureeCM;
			$total_min_cr_module+=$mindureeCM;
						$total_heure_td+=$heuredureeTD;
			$total_min_td+=$mindureeTD;
			$total_heure_td_module+=$heuredureeTD;
			$total_min_td_module+=$mindureeTD;
						$total_heure_tp+=$heuredureeTP;
			$total_min_tp+=$mindureeTP;
			$total_heure_tp_module+=$heuredureeTP;
			$total_min_tp_module+=$mindureeTP;
			$total_heure_eqtd_module+=$heureeqtd;
			$total_min_eqtd_module+=$mineqtd;		
			
				//mise en forme cumul des heure pour affichage chronologique
$total_eqtd_cumul_minute=$total_heure_eqtd*60+$total_min_eqtd;
   $heureeqtdcumul=intval($total_eqtd_cumul_minute/60);
														
				if (strlen($heureeqtdcumul)==1)
					{
						$heureeqtdcumul="0".$heureeqtdcumul;
					}
				$mineqtdcumul=$total_eqtd_cumul_minute%60;
				if (strlen($mineqtdcumul)==1)
					{
						$mineqtdcumul="0".$mineqtdcumul;
					}
				if (strlen($mineqtdcumul)==0)
					{
						$mineqtdcumul="00";
					}
    
    		$cumul=$heureeqtdcumul."h".$mineqtdcumul;
	if ($chrono=="1")
	{
	$fichier.=$cumul.";"."\n";
	}		
		}






	//forfait avec séances
	if ($enseignement['forfaitaire']==1)
		{
		//	volume horaire total du forfait
		if (strlen($enseignement['dureeForfaitaire'])==5)
			{
			$heureduree_forfait=substr($enseignement['dureeForfaitaire'],0,3);
			$minduree_forfait=substr($enseignement['dureeForfaitaire'],3,2);
			}
		if (strlen($enseignement['dureeForfaitaire'])==4)
			{
			$heureduree_forfait=substr($enseignement['dureeForfaitaire'],0,2);
			$minduree_forfait=substr($enseignement['dureeForfaitaire'],2,2);
			}
		if (strlen($enseignement['dureeForfaitaire'])==3)
			{
			$heureduree_forfait=substr($enseignement['dureeForfaitaire'],0,1);
			$minduree_forfait=substr($enseignement['dureeForfaitaire'],1,2);
			}
		if (strlen($enseignement['dureeForfaitaire'])==2)
			{
			$heureduree_forfait=0;
			$minduree_forfait=$enseignement['dureeForfaitaire'];
			}
		if (strlen($enseignement['dureeForfaitaire'])==1)
			{
			$heureduree_forfait=0;
			$minduree_forfait="0".$enseignement['dureeForfaitaire'];
			}
		if (strlen($heureduree_forfait)==1)
			{
			$heureduree_forfait="0".$heureduree_forfait;
			}			


		//comptage du nb de sénaces associé à l'enseignement
		$nb_seances=0;
		$enseignement_codeenseignement=$enseignement['codeEnseignement'];

		//requete pour comptere le nb de seances associé à l'enseignement
		$req_nb_seances->execute(array(':codeEnseignement'=>$enseignement_codeenseignement, ':codeProf'=>$codeProf));
		$res_nb_seances=$req_nb_seances->fetchAll();
		foreach ($res_nb_seances as $nombre_seances)
			{
			$nb_seances=$nb_seances+1;
			}
// calcul de la durée CM, TD et TP en fonction du tableau d'équivalence
		if ($enseignement['volumeReparti']==1)
				{
				$dureeenminCM=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*$TauxTypeEns[$CodeActivite][0])/$nb_profs)/$nb_seances;
				$dureeenminTD=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1])/$nb_profs)/$nb_seances;
        $dureeenminTP=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_profs)/$nb_seances;
        }
			else
				{
				$dureeenminCM=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*$TauxTypeEns[$CodeActivite][0])/$nb_seances;
			  $dureeenminTD=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1])/$nb_seances;
			  $dureeenminTP=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_seances;
			
        
        
        }
			
// Calcul pour la portion CM du forfait
      $heuredureeCM=intval($dureeenminCM/60);
													
			if (strlen($heuredureeCM)==1)
				{
					$heuredureeCM="0".$heuredureeCM;
				}
			$mindureeCM=$dureeenminCM%60;
			if (strlen($mindureeCM)==1)
				{
					$mindureeCM="0".$mindureeCM;
				}
			if (strlen($mindureeCM)==0)
				{
					$mindureeCM="00";
				}	
// Calcul pour la portion TD du forfait
      $heuredureeTD=intval($dureeenminTD/60);
													
			if (strlen($heuredureeTD)==1)
				{
					$heuredureeTD="0".$heuredureeTD;
				}
			$mindureeTD=$dureeenminTD%60;
			if (strlen($mindureeTD)==1)
				{
					$mindureeTD="0".$mindureeTD;
				}
			if (strlen($mindureeTD)==0)
				{
					$mindureeTD="00";
				}	
        
 // Calcul pour la portion TP du forfait
      $heuredureeTP=intval($dureeenminTP/60);
													
			if (strlen($heuredureeTP)==1)
				{
					$heuredureeTP="0".$heuredureeTP;
				}
			$mindureeTP=$dureeenminTP%60;
			if (strlen($mindureeTP)==1)
				{
					$mindureeTP="0".$mindureeTP;
				}
			if (strlen($mindureeTP)==0)
				{
					$mindureeTP="00";
				}			
   // calcul de l'affichage de la durée Eq TD en fonction du tableau d'équivalence				
        if ($enseignement['volumeReparti']==1)
				{
				$dureeenmin=(($heureduree_forfait*90*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs)/$nb_seances;
				}
				else
				{
				$dureeenmin=($heureduree_forfait*90*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_seances;
				}
				
        $heureeqtd=intval($dureeenmin/60);
														
				if (strlen($heureeqtd)==1)
					{
						$heureeqtd="0".$heureeqtd;
					}
				$mineqtd=$dureeenmin%60;
				if (strlen($mineqtd)==1)
					{
						$mineqtd="0".$mineqtd;
					}
				if (strlen($mineqtd)==0)
					{
						$mineqtd="00";
					}
    
    		
			$dureeeqtd=$heureeqtd."h".$mineqtd;	
	
	$fichier.="OUI;";
			
			if($heuredureeCM!="00" or $mindureeCM!="00") 
			{
			$fichier.=$heuredureeCM."h".$mindureeCM.";";
			} 
			else
			{
			$fichier.=";";
			}
			if($heuredureeTD!="00" or $mindureeTD!="00") 
			{
			$fichier.=$heuredureeTD."h".$mindureeTD.";";
			} 
			else
			{
			$fichier.=";";
			}
						if($heuredureeTP!="00" or $mindureeTP!="00") 
			{
			$fichier.=$heuredureeTP."h".$mindureeTP.";";
			} 
			else
			{
			$fichier.=";";
			}
			if ($chrono=="1")
			{
			$fichier.=$dureeeqtd.";";	
		}
		else
		{
		$fichier.=$dureeeqtd.";"."\n";	
		}

	$total_heure_eqtd+=$heureeqtd;
		$total_min_eqtd+=$mineqtd;
		$total_heure_forfait+=$heureeqtd;
		$total_min_forfait+=$mineqtd;
	    	$total_heure_cr+=$heuredureeCM;
		$total_min_cr+=$mindureeCM;
	 
   		$total_heure_td+=$heuredureeTD;
			$total_min_td+=$mindureeTD;
	

	   $total_heure_tp+=$heuredureeTP;
			$total_min_tp+=$mindureeTP;	
		$total_heure_forfait_module_CM+=$heuredureeCM;
		$total_min_forfait_module_CM+=$mindureeCM;
		$total_heure_forfait_module_TD+=$heuredureeTD;
		$total_min_forfait_module_TD+=$mindureeTD;
		$total_heure_forfait_module_TP+=$heuredureeTP;
		$total_min_forfait_module_TP+=$mindureeTP;
		
		$total_heure_eqtd_module+=$heureeqtd;
		$total_min_eqtd_module+=$mineqtd;
			//mise en forme cumul des heure pour affichage chronologique
$total_eqtd_cumul_minute=$total_heure_eqtd*60+$total_min_eqtd;
   $heureeqtdcumul=intval($total_eqtd_cumul_minute/60);
														
				if (strlen($heureeqtdcumul)==1)
					{
						$heureeqtdcumul="0".$heureeqtdcumul;
					}
				$mineqtdcumul=$total_eqtd_cumul_minute%60;
				if (strlen($mineqtdcumul)==1)
					{
						$mineqtdcumul="0".$mineqtdcumul;
					}
				if (strlen($mineqtdcumul)==0)
					{
						$mineqtdcumul="00";
					}
    
    		$cumul=$heureeqtdcumul."h".$mineqtdcumul;		
		
	if ($chrono=="1")
	{
	$fichier.=$cumul.";"."\n";	
	}	
		
		
		}
	
	}

}
	
	
	
	
//affichage du sous total des heures pour le dernier EC

	//mis en forme de l'heure
		if(count($res_seances_prof)>0)
{
	if ($chrono!='1')
	{
		$total_heure_eqtd_en_min_module=$total_heure_eqtd_module*60+$total_min_eqtd_module;
	$total_heure_eqtd_module=intval($total_heure_eqtd_en_min_module/60);
	$total_min_eqtd_module=$total_heure_eqtd_en_min_module%60;
	if (strlen($total_heure_eqtd_module)==1)
		{
		$total_heure_eqtd_module="0".$total_heure_eqtd_module;
		}

	if (strlen($total_min_eqtd_module)==1)
		{
		$total_min_eqtd_module="0".$total_min_eqtd_module;
		}
	if (strlen($total_min_eqtd_module)==0)
		{
		$total_min_eqtd_module="00";
		}

	$total_heure_cr_en_min_module=$total_heure_cr_module*60+$total_min_cr_module+$total_heure_forfait_module_CM*60+$total_min_forfait_module_CM;
	$total_heure_cr_module=intval($total_heure_cr_en_min_module/60);
	$total_min_cr_module=$total_heure_cr_en_min_module%60;
	if ($total_heure_cr_module==0 and $total_min_cr_module==0)
		{
		$total_heure_cr_module="";
		$total_min_cr_module="";
		}
	if (strlen($total_heure_cr_module)==1)
		{
		$total_heure_cr_module="0".$total_heure_cr_module;
		}
	if (strlen($total_min_cr_module)==1)
		{
		$total_min_cr_module="0".$total_min_cr_module;
		}

	$total_heure_td_en_min_module=$total_heure_td_module*60+$total_min_td_module+$total_heure_forfait_module_TD*60+$total_min_forfait_module_TD;
	$total_heure_td_module=intval($total_heure_td_en_min_module/60);
	$total_min_td_module=$total_heure_td_en_min_module%60;
	if ($total_heure_td_module==0 and $total_min_td_module==0)
		{
		$total_heure_td_module="";
		$total_min_td_module="";
		}
	if (strlen($total_heure_td_module)==1)
		{
		$total_heure_td_module="0".$total_heure_td_module;
		}
	if (strlen($total_min_td_module)==1)
		{
		$total_min_td_module="0".$total_min_td_module;
		}

	$total_heure_tp_en_min_module=$total_heure_tp_module*60+$total_min_tp_module+$total_heure_forfait_module_TP*60+$total_min_forfait_module_TP;
	$total_heure_tp_module=intval($total_heure_tp_en_min_module/60);
	$total_min_tp_module=$total_heure_tp_en_min_module%60;
	if ($total_heure_tp_module==0 and $total_min_tp_module==0)
		{
		$total_heure_tp_module="";
		$total_min_tp_module="";
		}
	if (strlen($total_heure_tp_module)==1)
		{
		$total_heure_tp_module="0".$total_heure_tp_module;
		}
	if (strlen($total_min_tp_module)==1)
		{
		$total_min_tp_module="0".$total_min_tp_module;
		}

	
	$fichier.=$nom_groupe_niv_sup.";".$memoire_code_identifiant.";"."CUMUL DES HEURES POUR L'EC CI-DESSUS".";;;;;;";	
		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{
		$fichier.=$total_heure_cr_module."h".$total_min_cr_module.";";
	
		}
	else
		{
			$fichier.=";";

		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{
		$fichier.=$total_heure_td_module."h".$total_min_td_module.";";
		
		}
	else
		{
		$fichier.=";";
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{
		$fichier.=$total_heure_tp_module."h".$total_min_tp_module.";";
		}
	else
		{
		$fichier.=";";
		}
	
		
	$fichier.=$total_heure_eqtd_module."h".$total_min_eqtd_module."\n";	
}	
}	
	

//forfait sans séance placées

//requete pour avoir la liste des enseignements forfaitaires
$req_enseignement_forfait_pur->execute(array(':codeProf'=>$codeProf));
$res_enseignement_forfait_pur=$req_enseignement_forfait_pur->fetchAll();
foreach ($res_enseignement_forfait_pur as $enseignements_au_forfait)
	{
	$codeenseignement=$enseignements_au_forfait['codeEnseignement'];
	$nom_forfait_groupe="";

	//requete pour avoir la liste des groupes associés au forfait
	$req_groupes_enseignement_forfait_pur->execute(array(':codeEnseignement'=>$codeenseignement));
	$res_groupes_enseignement_forfait_pur=$req_groupes_enseignement_forfait_pur->fetchAll();
	foreach ($res_groupes_enseignement_forfait_pur as $groupes_enseignement_au_forfait)
		{
		$code_groupe_forfait=$groupes_enseignement_au_forfait['codeRessource'];
		//requete pour avoir le nom des groupes
		$req_noms_groupe->execute(array(':codeGroupe'=>$code_groupe_forfait));
		$res_noms_groupe=$req_noms_groupe->fetchAll();
		foreach ($res_noms_groupe as $groupe)
			{
			$nom_forfait_groupe=$nom_forfait_groupe.$groupe['nom']." ";
			}
		}	

	//comptage du nb de sénaces associé à l'enseignement
	$nb_seances=0;
	//requete pour compter le nb de séances associées au forfait
	$req_nb_seances->execute(array(':codeEnseignement'=>$codeenseignement, ':codeProf'=>$codeProf));
	$res_nb_seances=$req_nb_seances->fetchAll();
	foreach ($res_nb_seances as $nombre_seances)
		{
		$nb_seances=$nb_seances+1;
		}

	if ($nb_seances==0)
		{
$CodeActivite=$enseignements_au_forfait['codeTypeActivite'];
		if ($enseignements_au_forfait['volumeReparti']==1)
			{
			//comptage du nb de profs associés à l'enseignement forfaitaire
			$nb_profs_forfait=0;
			//requete pour compter le nb de profs associés à l'enseignement forfaitaire
			$req_nb_prof_enseignement_forfait_pur->execute(array(':codeEnseignement'=>$codeenseignement));
			$res_nb_prof_enseignement_forfait_pur=$req_nb_prof_enseignement_forfait_pur->fetchAll();
			foreach ($res_nb_prof_enseignement_forfait_pur as $nb_prof_au_forfait)
				{
				$nb_profs_forfait=$nb_profs_forfait+1;
				}	
			}

		$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures

		//changement de couleur pour afficher en gris ou blanc une ligne sur 2
		if ($bgcolor=="white")
			{
			$bgcolor="silver";
			}
		else
			{
			$bgcolor="white";
			}

		//duree forfait
		if (strlen($enseignements_au_forfait['dureeForfaitaire'])==5)
			{
			$heureduree=substr($enseignements_au_forfait['dureeForfaitaire'],0,3);
			$minduree=substr($enseignements_au_forfait['dureeForfaitaire'],3,2);
			}
		if (strlen($enseignements_au_forfait['dureeForfaitaire'])==4)
			{
			$heureduree=substr($enseignements_au_forfait['dureeForfaitaire'],0,2);
			$minduree=substr($enseignements_au_forfait['dureeForfaitaire'],2,2);
			}
		if (strlen($enseignements_au_forfait['dureeForfaitaire'])==3)
			{
			$heureduree=substr($enseignements_au_forfait['dureeForfaitaire'],0,1);
			$minduree=substr($enseignements_au_forfait['dureeForfaitaire'],1,2);
			}
		if (strlen($enseignements_au_forfait['dureeForfaitaire'])==2)
			{
			$heureduree=0;
			$minduree=$enseignements_au_forfait['dureeForfaitaire'];
			}
		if (strlen($enseignements_au_forfait['dureeForfaitaire'])==1)
			{
			$heureduree=0;
			$minduree="0".$enseignements_au_forfait['dureeForfaitaire'];
			}
		if (strlen($heureduree)==1)
			{
			$heureduree="0".$heureduree;
			}	

			
			
// Calcul de la durée CM, TD et TP correspondant au forfait à partir du tableau d'équivalence			
			
if ($enseignements_au_forfait['volumeReparti']==1)
		{	  $dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_profs_forfait;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_profs_forfait;
        $dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_profs_forfait;
     }
else   
    {	  $dureeenminCM=$heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0];
				$dureeenminTD=$heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1];
        $dureeenminTP=$heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2];
     }


// Calcul pour la portion CM du forfait
      $heuredureeCM=intval($dureeenminCM/60);
													
			if (strlen($heuredureeCM)==1)
				{
					$heuredureeCM="0".$heuredureeCM;
				}
			$mindureeCM=$dureeenminCM%60;
			if (strlen($mindureeCM)==1)
				{
					$mindureeCM="0".$mindureeCM;
				}
			if (strlen($mindureeCM)==0)
				{
					$mindureeCM="00";
				}	
// Calcul pour la portion TD du forfait
      $heuredureeTD=intval($dureeenminTD/60);
													
			if (strlen($heuredureeTD)==1)
				{
					$heuredureeTD="0".$heuredureeTD;
				}
			$mindureeTD=$dureeenminTD%60;
			if (strlen($mindureeTD)==1)
				{
					$mindureeTD="0".$mindureeTD;
				}
			if (strlen($mindureeTD)==0)
				{
					$mindureeTD="00";
				}	
        
 // Calcul pour la portion TP du forfait
      $heuredureeTP=intval($dureeenminTP/60);
													
			if (strlen($heuredureeTP)==1)
				{
					$heuredureeTP="0".$heuredureeTP;
				}
			$mindureeTP=$dureeenminTP%60;
			if (strlen($mindureeTP)==1)
				{
					$mindureeTP="0".$mindureeTP;
				}
			if (strlen($mindureeTP)==0)
				{
					$mindureeTP="00";}



			
// calcul de la durée eq TD correspondant au forfait (sans séance placées) à partir du tableau d'équivalence

if ($enseignements_au_forfait['volumeReparti']==1)
				{
				$dureeenmin=(($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs_forfait);
				}
				else
				{
				$dureeenmin=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]);
				}
				
        $heureeqtd=intval($dureeenmin/60);
														
				if (strlen($heureeqtd)==1)
					{
						$heureeqtd="0".$heureeqtd;
					}
				$mineqtd=$dureeenmin%60;
				if (strlen($mineqtd)==1)
					{
						$mineqtd="0".$mineqtd;
					}
				if (strlen($mineqtd)==0)
					{
						$mineqtd="00";
					}
    
    		
			$dureeeqtd=$heureeqtd."h".$mineqtd;


		//mise en forme matiere
		$pos_dudebut = strpos($enseignements_au_forfait['nom'], "_")+1;	
		$pos_defin = strripos($enseignements_au_forfait['nom'], "_");	
		$longueur=$pos_defin-$pos_dudebut;
		$nomenseignement=substr($enseignements_au_forfait['nom'],$pos_dudebut,$longueur);

$fichier.=$nom_forfait_groupe.";".$enseignements_au_forfait['identifiant'].";".$nomenseignement.";;;;";
		
		if ($enseignements_au_forfait['volumeReparti']==1)
			{
			$fichier.="OUI / ".$nb_profs_forfait.";";
						}
		else
			{
			$fichier.="NON".";";
			
			}
			
		
	
	
	$fichier.="OUI;";
			
			if($heuredureeCM!="00" or $mindureeCM!="00") 
			{
			$fichier.=$heuredureeCM."h".$mindureeCM.";";
			} 
			else
			{
			$fichier.=";";
			}
			if($heuredureeTD!="00" or $mindureeTD!="00") 
			{
			$fichier.=$heuredureeTD."h".$mindureeTD.";";
			} 
			else
			{
			$fichier.=";";
			}
						if($heuredureeTP!="00" or $mindureeTP!="00") 
			{
			$fichier.=$heuredureeTP."h".$mindureeTP.";";
			} 
			else
			{
			$fichier.=";";
			}
				
	if ($chrono=="1")
			{
			$fichier.=$dureeeqtd.";";	
		}
		else
		{
		$fichier.=$dureeeqtd.";"."\n";	
		}
	
			$total_heure_eqtd+=$heureeqtd;
		$total_min_eqtd+=$mineqtd;
		$total_heure_forfait+=$heureeqtd;
		$total_min_forfait+=$mineqtd;
$total_heure_cr+=$heuredureeCM;
		$total_min_cr+=$mindureeCM;
	 
   		$total_heure_td+=$heuredureeTD;
			$total_min_td+=$mindureeTD;
	

	   $total_heure_tp+=$heuredureeTP;
			$total_min_tp+=$mindureeTP;

			//mise en forme cumul des heure pour affichage chronologique
$total_eqtd_cumul_minute=$total_heure_eqtd*60+$total_min_eqtd;
   $heureeqtdcumul=intval($total_eqtd_cumul_minute/60);
														
				if (strlen($heureeqtdcumul)==1)
					{
						$heureeqtdcumul="0".$heureeqtdcumul;
					}
				$mineqtdcumul=$total_eqtd_cumul_minute%60;
				if (strlen($mineqtdcumul)==1)
					{
						$mineqtdcumul="0".$mineqtdcumul;
					}
				if (strlen($mineqtdcumul)==0)
					{
						$mineqtdcumul="00";
					}
    
    		$cumul=$heureeqtdcumul."h".$mineqtdcumul;		
		if ($chrono=="1")
	{
	$fichier.=$cumul.";"."\n";	
	}

		
		}

	}

	
	
	

	
	
	
	
	
	
	
	
	
	
//affichage de la dernière ligne qui fait le bilan des heures	
if( $affichage_eqtd==1)
	{
	$total_heure_eqtd_en_min=$total_heure_eqtd*60+$total_min_eqtd;
	$total_heure_eqtd=intval($total_heure_eqtd_en_min/60);
	$total_min_eqtd=$total_heure_eqtd_en_min%60;
	if (strlen($total_heure_eqtd)==1)
		{
		$total_heure_eqtd="0".$total_heure_eqtd;
		}
	if (strlen($total_min_eqtd)==1)
		{
		$total_min_eqtd="0".$total_min_eqtd;
		}
	if (strlen($total_min_eqtd)==0)
		{
		$total_min_eqtd="00";
		}

	$total_heure_cr_en_min=$total_heure_cr*60+$total_min_cr;
	$total_heure_cr=intval($total_heure_cr_en_min/60);
	$total_min_cr=$total_heure_cr_en_min%60;
	if ($total_heure_cr==0 and $total_min_cr==0)
		{
		$total_heure_cr="";
		$total_min_cr="";
		}
	if (strlen($total_heure_cr)==1)
		{
		$total_heure_cr="0".$total_heure_cr;
		}
	if (strlen($total_min_cr)==1)
		{
		$total_min_cr="0".$total_min_cr;
		}
	$total_heure_td_en_min=$total_heure_td*60+$total_min_td;
	$total_heure_td=intval($total_heure_td_en_min/60);
	$total_min_td=$total_heure_td_en_min%60;
	if ($total_heure_td==0 and $total_min_td==0)
		{
		$total_heure_td="";
		$total_min_td="";
		}
	if (strlen($total_heure_td)==1)
		{
		$total_heure_td="0".$total_heure_td;
		}
	if (strlen($total_min_td)==1)
		{
		$total_min_td="0".$total_min_td;
		}
	$total_heure_tp_en_min=$total_heure_tp*60+$total_min_tp;
	$total_heure_tp=intval($total_heure_tp_en_min/60);
	$total_min_tp=$total_heure_tp_en_min%60;
	if ($total_heure_tp==0 and $total_min_tp==0)
		{
		$total_heure_tp="";
		$total_min_tp="";
		}
	if (strlen($total_heure_tp)==1)
		{
		$total_heure_tp="0".$total_heure_tp;
		}

	if (strlen($total_min_tp)==1)
		{
		$total_min_tp="0".$total_min_tp;
		}
	$total_heure_forfait_en_min=$total_heure_forfait*60+$total_min_forfait;
	$total_heure_forfait=intval($total_heure_forfait_en_min/60);
	$total_min_forfait=$total_heure_forfait_en_min%60;
	if ($total_heure_forfait==0 and $total_min_forfait==0)
		{
		$total_heure_forfait="";
		$total_min_forfait="";
		}
	if (strlen($total_heure_forfait)==1)
		{
		$total_heure_forfait="0".$total_heure_forfait;
		}
	if (strlen($total_min_forfait)==1)
		{
		$total_min_forfait="0".$total_min_forfait;
		}	
		
	$fichier.="CUMUL DES HEURES DE L'ANNEE".";;;;;;;;";	
	
	if ($total_heure_cr!="" || $total_min_cr!="")
		{
		$fichier.=$total_heure_cr."h".$total_min_cr.";";
		}
	else
		{
		$fichier.=";";
				}
	if ($total_heure_td!="" || $total_min_td!="")
		{
		$fichier.=$total_heure_td."h".$total_min_td.";";
		}
	else
		{
		$fichier.=";";
		}
	if ($total_heure_tp!="" || $total_min_tp!="")
		{
		$fichier.=$total_heure_tp."h".$total_min_tp.";";
		}
	else
		{
		$fichier.=";";
		}
	
		$fichier.=$total_heure_eqtd."h".$total_min_eqtd."\n";
	$affichage_eqtd=0;
	}


$jour=date('d');

$mois=date('m');

$annee=date('y');
$heuredujour=date('H');
$minutedujour=date('i');

	$nomfichier=$prof_nom."_".$prof_prenom."_".$jour."_".$mois."_".$annee."-".$heuredujour."h".$minutedujour.".csv";


	header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=$nomfichier");
echo $fichier;






