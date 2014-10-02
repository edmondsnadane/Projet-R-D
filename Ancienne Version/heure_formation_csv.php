<?php
session_start();

include("config.php");
error_reporting(E_ALL);


	
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
	
$jour=date('d');
$mois=date('m');
$annee=date('y');



if (isset ($_GET['formation']))
{
$formation=$_GET['formation'];
}

if (isset ($_GET['annee_debut']))
{
$annee_debut=$_GET['annee_debut'];
}

if (isset ($_GET['annee_fin']))
{
$annee_fin=$_GET['annee_fin'];
}

if (isset ($_GET['mois_fin']))
{
$mois_fin=$_GET['mois_fin'];
}

if (isset ($_GET['mois_debut']))
{
$mois_debut=$_GET['mois_debut'];
}

if (isset ($_GET['jour_debut']))
{
$jour_debut=$_GET['jour_debut'];
}

if (isset ($_GET['jour_fin']))
{
$jour_fin=$_GET['jour_fin'];
}
	
   
   if (isset ($_GET['jour_fin']))
	{
	if (strlen($jour_fin)==1)
					{
						$jour_fin="0".$jour_fin;
					}
	}
		
if (isset ($_GET['jour_debut']))
{		
	if (strlen($jour_debut)==1)
					{
						$jour_debut="0".$jour_debut;
					}
					}
	
if (isset ($_GET['mois_fin']))
{	
	if (strlen($mois_fin)==1)
					{
						$mois_fin="0".$mois_fin;
					}
					}
	
if (isset ($_GET['mois_debut']))
{		
	if (strlen($mois_debut)==1)
					{
						$mois_debut="0".$mois_debut;
					}
					}
		

$fichier="";
	
	

if (isset($_SESSION['bilan_formation']))
{
if ($_SESSION['bilan_formation']!=0)
{

//pour chaque bdd

$dbh=null;
	for ($k=0;$k<=$nbdebdd-1;$k++)

	{
	$base_a_utiliser=$base[$k];
		try
		{
		$dbh=new PDO("mysql:host=$serveur;dbname=$base_a_utiliser;",$user,$pass);
		}

		catch(PDOException $e)
		{
		die("erreur ! : " .$e->getMessage());
		}
	$anneescolaire=$annee_scolaire[$k];

$sql="SELECT * FROM filieres where deleted= '0' ";
$req_filiere=$dbh->prepare($sql);	
$req_filiere->execute(array());
$res_filiere=$req_filiere->fetchAll();
foreach($res_filiere as $filiere)
{
$dateDebutBase=$filiere['dateDebut'];
$dateFinBase=$filiere['dateFin'];
$dateDebutBase=substr($dateDebutBase,0,10);
$dateFinBase=substr($dateFinBase,0,10);
}	

if (isset($annee_debut) && isset($mois_debut) && isset($jour_debut) && isset($annee_fin) && isset($mois_fin) && isset($jour_fin))
{
$date_debut=$annee_debut."-".$mois_debut."-".$jour_debut;
$date_fin=$annee_fin."-".$mois_fin."-".$jour_fin;
}



if (isset($annee_debut) && isset($mois_debut) && isset($jour_debut) && isset($annee_fin) && isset($mois_fin) && isset($jour_fin))
{
if (($date_debut>=$dateDebutBase && $date_debut<=$dateFinBase) ||($date_debut<=$dateDebutBase && $date_fin>=$dateFinBase) ||($date_debut<=$dateDebutBase && $date_fin<=$dateFinBase && $date_fin>=$dateDebutBase)   )
{	
	
//preparation des requetes
//$sql="SELECT * FROM ressources_groupes where departement=:departement and deleted= '0' ";
$sql="SELECT * FROM ressources_groupes where codeNiveau=:departement and deleted= '0' ";
$req_groupes=$dbh->prepare($sql);




//liste des groupes

$ressource_formation="(";

$req_groupes->execute(array(':departement'=>$formation));
$res_groupes=$req_groupes->fetchAll();
foreach($res_groupes as $code_grp)
{
$ressource_formation.="seances_groupes.codeRessource='".$code_grp['codeGroupe']."' or ";
}
$ressource_formation.="0)";



//preparation des requetes
//il faut faire 2 tableaux par année. Un pour les permanents et un pour les vacataires
$categorie_profs = array('PERMANENT','VACATAIRE' );

foreach($categorie_profs as $categorie_prof)
{	

//preparation des requetes
//si vacataires
if ($categorie_prof=="VACATAIRE")
	{
	
	$sql="SELECT * FROM ressources_profs  where  titulaire!='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);
	
	$titre_tableau="vacataires";
	}
//si permanents
else
	{

	
	$sql="SELECT * FROM ressources_profs  where titulaire='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);
	
	$titre_tableau="permanents";
	}

$sql="SELECT distinct (seances_profs.codeSeance) FROM seances_profs left join (seances) on (seances.codeSeance=seances_profs.codeSeance ) left join (seances_groupes) on (seances.codeSeance=seances_groupes.codeSeance )   where seances_profs.codeRessource=:codeRessource AND seances_profs.deleted='0' AND seances.deleted='0'  and ($ressource_formation)  order by seances.dateSeance,seances.heureSeance";
$req_seance_profs=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes left join (seances_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) where seances_groupes.codeSeance=:codeSeance  and seances_groupes.deleted= '0'  and ressources_groupes.deleted= '0'";
$req_seance_groupes=$dbh->prepare($sql);	
	
	
$sql="SELECT * FROM seances where codeSeance=:codeSeance AND deleted= '0'";
$req_seance=$dbh->prepare($sql);	


$sql="SELECT * FROM enseignements where codeEnseignement=:codeEnseignement AND deleted= '0'"	;
$req_enseignement=$dbh->prepare($sql);	


$sql="SELECT * FROM seances_profs where seances_profs.deleted='0' and seances_profs.codeSeance=:codeSeance "	;
$req_prof=$dbh->prepare($sql);	


$sql="SELECT * FROM seances left join seances_profs on seances.codeSeance=seances_profs.codeSeance where seances.deleted='0' and seances_profs.deleted='0' and seances_profs.codeRessource=:codeProf and seances.codeEnseignement=:codeEnseignement  ";
$req_seance_enseignement=$dbh->prepare($sql);	


$sql="SELECT * FROM enseignements left join (enseignements_profs) on (enseignements.codeEnseignement=enseignements_profs.codeEnseignement )  where enseignements_profs.codeRessource=:codeRessource AND enseignements_profs.deleted='0' AND enseignements.forfaitaire='1' AND enseignements.deleted='0' order by enseignements.nom"	;
$req_enseignement_forfait=$dbh->prepare($sql);	


$sql="SELECT * FROM ressources_groupes where codeGroupe=:codeGroupe AND deleted= '0'"	;
$req_groupe_forfait=$dbh->prepare($sql);	

$sql="SELECT * FROM enseignements_profs where enseignements_profs.deleted='0' and enseignements_profs.codeEnseignement=:codeEnseignement  "		;
$req_enseignement_prof_forfait=$dbh->prepare($sql);	
	
	

	
	
	
	
//verification qu'il y a au moins une séance à afficher	
$sql="SELECT * FROM ressources_groupes join (seances_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) join (seances) on (seances.codeSeance=seances_groupes.codeSeance ) where  ($ressource_formation) and seances.dateSeance>='$date_debut' and  seances.dateSeance<='$date_fin' and seances_groupes.deleted= '0' and  seances.deleted='0'  and ressources_groupes.deleted= '0'";
$req_seance_groupes_verif=$dbh->prepare($sql);
$req_seance_groupes_verif->execute(array());
$res_seance_groupes_verif=$req_seance_groupes_verif->fetchAll();	
$compteur_seance=count($res_seance_groupes_verif);

//verification s'il y a des enseignements forfaitaires	
	//liste des groupes
		$ressource_formation_forfait="(";
		$req_groupes->execute(array(':departement'=>$formation));
		$res_groupes=$req_groupes->fetchAll();
		foreach($res_groupes as $code_grp)
		{
		$ressource_formation_forfait.="enseignements_groupes.codeRessource='".$code_grp['codeGroupe']."' or ";
		}
		$ressource_formation_forfait.="0)";
$sql="SELECT * FROM enseignements left join (enseignements_groupes) on (enseignements.codeEnseignement=enseignements_groupes.codeEnseignement )  where ($ressource_formation_forfait) AND enseignements_groupes.deleted='0' AND enseignements.forfaitaire='1' AND enseignements.deleted='0'"	;
$req_enseignement_forfait_verif=$dbh->prepare($sql);	
$req_enseignement_forfait_verif->execute(array());
$res_enseignement_forfait_verif=$req_enseignement_forfait_verif->fetchAll();	
$compteur_enseignement_forfait=count($res_enseignement_forfait_verif);


if ($compteur_seance!=0 or $compteur_enseignement_forfait!=0)
{	
	//récuperation du nom de la formation
	$sql="SELECT * FROM niveaux where codeNiveau=:departement and deleted= '0' ";
	$req_nom_niveau=$dbh->prepare($sql);
	$req_nom_niveau->execute(array(':departement'=>$formation));
	$res_nom_niveaux=$req_nom_niveau->fetchAll();
	foreach($res_nom_niveaux as $res_nom_niveau)
		{
		$formation_nom=$res_nom_niveau['nom'];
		}

	$fichier.="Heures des profs en ".$formation_nom." (".$titre_tableau.")"."\n";

	$fichier.="Période du ".$jour_debut."/".$mois_debut."/".$annee_debut." au  ".$jour_fin."/".$mois_fin."/".$annee_fin."\n";

	$fichier.="Généré le ".date('d')."/".date('m')."/".date('y')."\n";
	
$fichier.="\n";
	$fichier.="Année scolaire ".$anneescolaire."\n";

	$fichier.='Nom;Prénom;Formation;Apogée;Matière;Date des séances;Heure de début;Heure de fin;Horaire réparti / nb profs;Forfait;CR;TD;TP;EqTD'. "\n";


}	
	
	
	$total_final_heure_cm="";
	$total_final_heure_td="";
	$total_final_heure_tp="";
	$total_final_heure_forfait="";
	$total_final_min_cm="";
	$total_final_min_td="";
	$total_final_min_tp="";
	$total_final_min_forfait="";
	$total_final_heure_eqtd="";
	$total_final_min_eqtd="";	
	

$affichage_eqtd=0;
	


$req_profs->execute(array());
$res_profs=$req_profs->fetchAll();	
foreach($res_profs as $prof)
{	




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

$codeRessource=$prof['codeProf'];


$req_seance_profs->execute(array(':codeRessource'=>$codeRessource));
$res_seance_profs=$req_seance_profs->fetchAll();	
foreach($res_seance_profs as $seance_prof)
{		
	

$codeSeance=$seance_prof['codeSeance'];
$req_seance_groupes->execute(array(':codeSeance'=>$codeSeance));
$res_seance_groupes=$req_seance_groupes->fetchAll();	
$nom_seance_groupe="";

foreach($res_seance_groupes as $seance_groupe)
	{	

	$nom_seance_groupe=$nom_seance_groupe.$seance_groupe['nom']." ";
	}
		
		
$seance_groupe_codeSeance=$seance_prof['codeSeance'];
$req_seance->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
$res_seance=$req_seance->fetchAll();
foreach($res_seance as $seance)
	{	
		$annee=substr($seance['dateSeance'],0,4);
		$mois=substr($seance['dateSeance'],5,2);
		$jour=substr($seance['dateSeance'],8,2);
		$date_seance=$annee.$mois.$jour;
}	



$codeEnseignement=$seance['codeEnseignement'];
$req_enseignement->execute(array(':codeEnseignement'=>$codeEnseignement));
$res_enseignement=$req_enseignement->fetchAll();
foreach($res_enseignement as $enseignement)
	{	
$forfait=$enseignement['forfaitaire'];
}

// MODIF LAURENT
//N'affiche la ligne que si la séance est "rémunérée" en fonction de l'option d'affichage choisie  $AfficheLignesNonPayees

// récupération du code de l'activité

$CodeActivite=$enseignement['codeTypeActivite'];

// Teste si l'on autorise ou non l'affichage des heures non rémunérées (0CM 0TD 0TP malgré des heures de présence)
if ($AfficheLignesNonPayees==1 or $TauxTypeEns[$CodeActivite][0]+$TauxTypeEns[$CodeActivite][1]+$TauxTypeEns[$CodeActivite][2]!=0)
{
		if ($date_seance<=$annee_fin.$mois_fin.$jour_fin and $date_seance>=$annee_debut.$mois_debut.$jour_debut  and $forfait!=1)
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			
			
			
		//comptage du nb de profs associés à la séance
	$nb_profs=0;

$req_prof->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
$res_prof=$req_prof->fetchAll();
foreach($res_prof as $profs_seance)
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
			//heure fin
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

					//annee mois jour
					$annee=substr($seance['dateSeance'],0,4);
					$mois=substr($seance['dateSeance'],5,2);
					$jour=substr($seance['dateSeance'],8,2);		
					
			//mise en forme matiere
				$pos_dudebut = strpos($enseignement['nom'], "_")+1;	
				$pos_defin = strripos($enseignement['nom'], "_");	
				$longueur=$pos_defin-$pos_dudebut;
				$nomenseignement=substr($enseignement['nom'],$pos_dudebut,$longueur);
	
	$fichier.=$prof['nom'].";".$prof['prenom'].";".$nom_seance_groupe.";".$enseignement['identifiant'].";".$nomenseignement.";".$jour."-".$mois."-".$annee.";".$heuredebut."h".$mindebut.";".$heurefin."h".$minfin.";";
		
	
		if ($enseignement['volumeReparti']==1)
		{
		$fichier.="OUI / ".$nb_profs.";";
	
		}
		else
		{
		$fichier.="NON".";";
		}					
		

		
		 // MODIF LAURENT : utilisation d'une grille de conversion CM TD TP de chaque enseignement.
//Ajout Laurent

      
// calcul de l'affichage de la durée Eq TD				
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
      {	$fichier.=$heuredureeCM."h".$mindureeCM.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTD!="00" or $mindureeTD!="00") 
      {	$fichier.=$heuredureeTD."h".$mindureeTD.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTP!="00" or $mindureeTP!="00") 
      {	$fichier.=$heuredureeTP."h".$mindureeTP.";";}
  else
  		{	$fichier.=";";}
  
  
	$fichier.=$dureeeqtd."\n";
	
  
    $total_heure_eqtd+=$heureeqtd;
		$total_min_eqtd+=$mineqtd;
		
		$total_heure_cr+=$heuredureeCM;
		$total_min_cr+=$mindureeCM;
		$total_final_heure_cm+=$heuredureeCM;
		$total_final_min_cm+=$mindureeCM;
		


			$total_heure_td+=$heuredureeTD;
			$total_min_td+=$mindureeTD;
		  $total_final_heure_td+=$heuredureeTD;
		  $total_final_min_td+=$mindureeTD;
	

	   $total_heure_tp+=$heuredureeTP;
			$total_min_tp+=$mindureeTP;
		$total_final_heure_tp+=$heuredureeTP;
		$total_final_min_tp+=$mindureeTP;
    	
    $total_final_heure_eqtd+=$heureeqtd;
		$total_final_min_eqtd+=$mineqtd;
	
// FIN Ajout Laurent  
    
			
		
	
		}
		
	
		
		
	//forfait avec séances
		if ($date_seance<=$annee_fin.$mois_fin.$jour_fin and $date_seance>=$annee_debut.$mois_debut.$jour_debut and $forfait==1)
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			
			
			
	//comptage du nb de profs associés à la séance
	$nb_profs=0;

	
$req_prof->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
$res_prof=$req_prof->fetchAll();
foreach($res_prof as $profs_seance)
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
				if (strlen($seance['dureeSeance'])==1)
					{
						$heureduree=0;
						$minduree="0".$seance['dureeSeance'];
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
			//heure fin
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

					//annee mois jour
					$annee=substr($seance['dateSeance'],0,4);
					$mois=substr($seance['dateSeance'],5,2);
					$jour=substr($seance['dateSeance'],8,2);		
					
			//mise en forme matiere
				$pos_dudebut = strpos($enseignement['nom'], "_")+1;	
				$pos_defin = strripos($enseignement['nom'], "_");	
				$longueur=$pos_defin-$pos_dudebut;
				$nomenseignement=substr($enseignement['nom'],$pos_dudebut,$longueur);
				
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
					
		
		$fichier.=$prof['nom'].";".$prof['prenom'].";".$nom_seance_groupe.";".$enseignement['identifiant'].";".$nomenseignement.";".$jour."-".$mois."-".$annee.";".$heuredebut."h".$mindebut.";".$heurefin."h".$minfin.";";
				

		if ($enseignement['volumeReparti']==1)
		{
		$fichier.="OUI / ".$nb_profs.";";
		}
		else
		{
		$fichier.="NON".";";
		}
		
		//comptage du nb de sénaces associé à l'enseignement
			$nb_seances=0;
			
			
	$enseignement_codeenseignement=$enseignement['codeEnseignement'];
	$req_seance_enseignement->execute(array(':codeEnseignement'=>$enseignement_codeenseignement, ':codeProf'=>$codeRessource));
$res_seance_enseignement=$req_seance_enseignement->fetchAll();
foreach($res_seance_enseignement as $nb_seances_forfait)
	{	
	$nb_seances=$nb_seances+1;
	}			
		
		

		// Modif Laurent sur le calcul du cout en utilisant le tableau d'équivalence		

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
      {	$fichier.=$heuredureeCM."h".$mindureeCM.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTD!="00" or $mindureeTD!="00") 
      {	$fichier.=$heuredureeTD."h".$mindureeTD.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTP!="00" or $mindureeTP!="00") 
      {	$fichier.=$heuredureeTP."h".$mindureeTP.";";}
  else
  		{	$fichier.=";";}
      
  $fichier.=$dureeeqtd."\n";
      
			
			
			
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
	
    
    	
		$total_final_heure_forfait+=$heureeqtd;
		$total_final_min_forfait+=$mineqtd;
		
    $total_final_heure_eqtd+=$heureeqtd;
		$total_final_min_eqtd+=$mineqtd;
	
  	$total_final_heure_cm+=$heuredureeCM;
		$total_final_min_cm+=$mindureeCM;
	
  	  $total_final_heure_td+=$heuredureeTD;
		  $total_final_min_td+=$mindureeTD;
	
  	$total_final_heure_tp+=$heuredureeTP;
		$total_final_min_tp+=$mindureeTP;

		}	
			
			// fin de la zone if concernant	l'affichage ou non des séance non rémunérées	
		}	
		
		

	}
	
	
	

	//forfait sans séance placées
	
	//liste des groupes
$ressource_formation2="(";




$req_groupes->execute(array(':departement'=>$formation));
$res_groupes=$req_groupes->fetchAll();
foreach($res_groupes as $code)
	{	
	$ressource_formation2.="enseignements_groupes.codeRessource='".$code['codeGroupe']."' or ";
	}	









$ressource_formation2.="0)";
	

	
	
$codeRessource=$prof['codeProf'];	
$req_enseignement_forfait->execute(array(':codeRessource'=>$codeRessource));
$res_enseignement_forfait=$req_enseignement_forfait->fetchAll();
foreach($res_enseignement_forfait as $enseignements_au_forfait)
	{
	
	$codeenseignement=$enseignements_au_forfait['codeEnseignement'];

	
	//on regarde si le l'enseignement forfaitaire est fait dans la formation souhaitée
	$test="";
	$nom_forfait_groupe="";

	
$sql="SELECT * FROM enseignements_groupes where enseignements_groupes.deleted='0' and enseignements_groupes.codeEnseignement=:codeEnseignement and $ressource_formation2 "	;
$req_groupe_enseignement=$dbh->prepare($sql);	
$req_groupe_enseignement->execute(array(':codeEnseignement'=>$codeenseignement));
$res_groupe_enseignement=$req_groupe_enseignement->fetchAll();
foreach($res_groupe_enseignement as $groupes_enseignement_au_forfait)
	{	
	

		
		$test=$groupes_enseignement_au_forfait['codeEnseignement'];
		$codeGroupe=$groupes_enseignement_au_forfait['codeRessource'];
		
$req_groupe_forfait->execute(array(':codeGroupe'=>$codeGroupe));
$res_groupe_forfait=$req_groupe_forfait->fetchAll();
foreach($res_groupe_forfait as $groupe)
	{	
	$nom_forfait_groupe=$nom_forfait_groupe.$groupe['nom']." ";
	}
	
	}

	
		
		
	if ($test!="")
	{
		//comptage du nb de sénaces associé à l'enseignement
			$nb_seances=0;
	$enseignement_codeenseignement=$enseignements_au_forfait['codeEnseignement'];
	
$req_seance_enseignement->execute(array(':codeEnseignement'=>$codeenseignement, ':codeProf'=>$codeRessource));
$res_seance_enseignement=$req_seance_enseignement->fetchAll();
foreach($res_seance_enseignement as $groupe)
	{	
	



	$nb_seances=$nb_seances+1;
		}	
if ($nb_seances==0)
{



// Ajout LAURENT
// récupération du code de l'activité
$CodeActivite=$enseignements_au_forfait['codeTypeActivite'];

// Teste si l'on autorise ou non l'affichage des heures non rémunérées (0CM 0TD 0TP malgré des heures de présence)
if ($AfficheLignesNonPayees==1 or $TauxTypeEns[$CodeActivite][0]+$TauxTypeEns[$CodeActivite][1]+$TauxTypeEns[$CodeActivite][2]!=0)
{

	if ($enseignements_au_forfait['volumeReparti']==1)
	{
		//comptage du nb de profs associés à l'enseignement forfaitaire
		$nb_profs_forfait=0;
		
		
	
$req_enseignement_prof_forfait	->execute(array(':codeEnseignement'=>$codeenseignement));
$res_enseignement_prof_forfait=$req_enseignement_prof_forfait	->fetchAll();
foreach($res_enseignement_prof_forfait as $enseignement_prof_forfait)
	{		




		$nb_profs_forfait=$nb_profs_forfait+1;
			}	
	}
	
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			
			
		
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
					


		
		$fichier.=$prof['nom'].";".$prof['prenom'].";".$nom_forfait_groupe.";".$enseignements_au_forfait['identifiant'].";".$nomenseignement.";;;;";
			

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
      {	$fichier.=$heuredureeCM."h".$mindureeCM.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTD!="00" or $mindureeTD!="00") 
      {	$fichier.=$heuredureeTD."h".$mindureeTD.";";}
  else
  		{	$fichier.=";";}
  
  if($heuredureeTP!="00" or $mindureeTP!="00") 
      {	$fichier.=$heuredureeTP."h".$mindureeTP.";";}
  else
  		{	$fichier.=";";}
      
  $fichier.=$dureeeqtd."\n";
      
			
			
			
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
	
    
    	
		$total_final_heure_forfait+=$heureeqtd;
		$total_final_min_forfait+=$mineqtd;
		
    $total_final_heure_eqtd+=$heureeqtd;
		$total_final_min_eqtd+=$mineqtd;
	
  	$total_final_heure_cm+=$heuredureeCM;
		$total_final_min_cm+=$mindureeCM;
	
  	  $total_final_heure_td+=$heuredureeTD;
		  $total_final_min_td+=$mindureeTD;
	
  	$total_final_heure_tp+=$heuredureeTP;
		$total_final_min_tp+=$mindureeTP;		
			
	 // Fin boucle de test sur l'affichage des lignes vides (non rémunérées))
		}
		}
		}
		}
		
	
		
		
		
		
		
		
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

		
		
$fichier.=$prof['nom'].";".$prof['prenom'].";"."CUMUL DES HEURES".";;;;;;;;";		

		
if ($total_heure_cr!="" and $total_min_cr!="")
{
$fichier.=$total_heure_cr."h".$total_min_cr.";";
}
else
	{
	$fichier.=";";
	}
	if ($total_heure_td!="" and $total_min_td!="")
{
$fichier.=$total_heure_td."h".$total_min_td.";";

}
else
	{
	$fichier.=";";
	}
	if ($total_heure_tp!="" and $total_min_tp!="")
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


}


//bilan total de toute les heures de la formation
//mise en forme de l'heure
$total_final_heure_eqtd_en_min=$total_final_heure_eqtd*60+$total_final_min_eqtd;
		$total_final_heure_eqtd=intval($total_final_heure_eqtd_en_min/60);
		$total_final_min_eqtd=$total_final_heure_eqtd_en_min%60;
		if (strlen($total_final_heure_eqtd)==1)
			{
				$total_final_heure_eqtd="0".$total_final_heure_eqtd;
			}
		
		if (strlen($total_final_min_eqtd)==1)
			{
				$total_final_min_eqtd="0".$total_final_min_eqtd;
			}
		if (strlen($total_final_min_eqtd)==0)
			{
				$total_final_min_eqtd="00";
			}
			
		$total_final_heure_cm_en_min=$total_final_heure_cm*60+$total_final_min_cm;
		$total_final_heure_cm=intval($total_final_heure_cm_en_min/60);
		$total_final_min_cm=$total_final_heure_cm_en_min%60;
		if ($total_final_heure_cm==0 and $total_final_min_cm==0)
		{
			$total_final_heure_cm="";
			$total_final_min_cm="";
		}
		
		if (strlen($total_final_heure_cm)==1)
			{
				$total_final_heure_cm="0".$total_final_heure_cm;
			}
		
		if (strlen($total_final_min_cm)==1)
			{
				$total_final_min_cm="0".$total_final_min_cm;
			}

		$total_final_heure_td_en_min=$total_final_heure_td*60+$total_final_min_td;
		$total_final_heure_td=intval($total_final_heure_td_en_min/60);
		$total_final_min_td=$total_final_heure_td_en_min%60;
		if ($total_final_heure_td==0 and $total_final_min_td==0)
		{
			$total_final_heure_td="";
			$total_final_min_td="";
		}
		
		if (strlen($total_final_heure_td)==1)
			{
				$total_final_heure_td="0".$total_final_heure_td;
			}
		
		if (strlen($total_final_min_td)==1)
			{
				$total_final_min_td="0".$total_final_min_td;
			}
			
		$total_final_heure_tp_en_min=$total_final_heure_tp*60+$total_final_min_tp;
		$total_final_heure_tp=intval($total_final_heure_tp_en_min/60);
		$total_final_min_tp=$total_final_heure_tp_en_min%60;
		if ($total_final_heure_tp==0 and $total_final_min_tp==0)
		{
			$total_final_heure_tp="";
			$total_final_min_tp="";
		}
		
		if (strlen($total_final_heure_tp)==1)
			{
				$total_final_heure_tp="0".$total_final_heure_tp;
			}
		
		if (strlen($total_final_min_tp)==1)
			{
				$total_final_min_tp="0".$total_final_min_tp;
			}
	
		$total_final_heure_forfait_en_min=$total_final_heure_forfait*60+$total_final_min_forfait;
		$total_final_heure_forfait=intval($total_final_heure_forfait_en_min/60);
		$total_final_min_forfait=$total_final_heure_forfait_en_min%60;
		if ($total_final_heure_forfait==0 and $total_final_min_forfait==0)
		{
			$total_final_heure_forfait="";
			$total_final_min_forfait="";
		}
		
		if (strlen($total_final_heure_forfait)==1)
			{
				$total_final_heure_forfait="0".$total_final_heure_forfait;
			}
		
		if (strlen($total_final_min_forfait)==1)
			{
				$total_final_min_forfait="0".$total_final_min_forfait;
			}	

$fichier.="CUMUL TOTAL DES HEURES;;;;;;;;;;";
		
		
if ($total_final_heure_cm!="" or $total_final_min_cm!="")
{
$fichier.=$total_final_heure_cm."h".$total_final_min_cm.";";
			
}
else
	{
	$fichier.=";";
		
	}
	if ($total_final_heure_td!="" or $total_final_min_td!="")
{
$fichier.=$total_final_heure_td."h".$total_final_min_td.";";
			
}
else
	{
	$fichier.=";";
		
	}
	if ($total_final_heure_tp!="" or $total_final_min_tp!="")
{
$fichier.=$total_final_heure_tp."h".$total_final_min_tp.";";
		
}
else
	{
	$fichier.=";";
		
	}

	
		
			
		$fichier.=$total_final_heure_eqtd."h".$total_final_min_eqtd."\n"."\n";
			

}


}
}
}

$jour=date('d');

$mois=date('m');

$annee=date('y');
$heuredujour=date('H');
$minutedujour=date('i');
$formation=str_replace(" ","_",$formation_nom);
	$nomfichier=$formation."_".$jour."_".$mois."_".$annee."-".$heuredujour."h".$minutedujour.".csv";


	header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=$nomfichier");

echo $fichier;



}
}
?>

