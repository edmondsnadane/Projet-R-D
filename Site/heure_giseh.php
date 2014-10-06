<?php
session_start();

include("config.php");
error_reporting(E_ALL);

//lignes budgetaires
$ligne_sitec_FI="A90083SITC";
$ligne_sitec_titulaire_FA_FC="F9091HEUR";

$ligne_iut_FI="A90083IUT";
$ligne_iut_titulaire_FA_FC="F9609HEUR";

	
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
	
	
if (isset ($_GET['vacataire']))
	{		
	$vacataire=$_GET['vacataire'];
	}
else
{
$vacataire="oui";
}	
	
	if (isset ($_GET['export_forfait']))
	{		
	$export_forfait=$_GET['export_forfait'];
	}
else
{
$export_forfait="oui";
}	
	
	
//date permettant de ne selectionner que les seances qui nous interessent. J'ai mis un isset($_GET['mois_debut']) pour être sûr que la date a bien été définie dans l'url
if (isset ($_GET['mois_debut']))
	{	
	$date_debut_pour_requete=$annee_debut."-".$mois_debut."-".$jour_debut;
	$date_fin_pour_requete=$annee_fin."-".$mois_fin."-".$jour_fin;	
	}
?>


<?php
if ((stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || stristr($_SERVER['HTTP_USER_AGENT'], "Mini")  || stristr($_SERVER['HTTP_USER_AGENT'], "Sony")  || stristr($_SERVER['HTTP_USER_AGENT'], "Nokia")  || stristr($_SERVER['HTTP_USER_AGENT'], "BlackBerry")  || stristr($_SERVER['HTTP_USER_AGENT'], "HTC")  || stristr($_SERVER['HTTP_USER_AGENT'], "Android")   || stristr($_SERVER['HTTP_USER_AGENT'], "MOT")  || stristr($_SERVER['HTTP_USER_AGENT'], "SGH")    ) ) 
	{ 
	echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';
	}
else
	{
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> ';
	}
?>




<html>

<head>
<link rel="stylesheet" media="all" type="text/css" href="menu/hover_drop_2.css">

<script src="menu/iefix.js" type="text/javascript"></script>
<link rel="icon" type="image/x-icon" href="favicon.png" >

<title><?php echo $nom_fenetre; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<?php
if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) 
	{ 
	echo '<meta name="viewport" content="initial-scale=1.0">';
	} 
?>


<link rel="stylesheet" href="css/heure_giseh.css" type="text/css" >

</head>

<body  style="margin: 0px;">
<?php
if (isset($_SESSION['giseh']))
{
if ($_SESSION['giseh']!=0)
{
//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_admin=1;
$afficher_mes_modules=1;
$afficher_mes_droits=1;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=1;
$afficher_giseh=0;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=1;
$nom_de_la_fenetre="Giseh";
include('menu_outil.php');

	?>
			
<div style="text-align:center;width:100%;">


<form name="form2" id="form2" action="index.php" method="get" >


	
<input type="hidden" name="lar" id="screen_w" value="<?php echo $lar; ?>">
<input type="hidden" name="hau" id="screen_hi" value="<?php echo $hau; ?>">
<input type="hidden" name="selec_prof" id="selec_pr" value="<?php echo $selec_prof; ?>">
<input type="hidden" name="selec_groupe" id="selec_grou" value="<?php echo $selec_groupe; ?>">
<input type="hidden" name="selec_salle" id="selec_sa" value="<?php echo $selec_salle; ?>">
<input type="hidden" name="selec_materiel" id="selec_ma" value="<?php echo $selec_materiel; ?>">
<input type="hidden" name="current_week" id="current_w" value="<?php echo $current_week; ?>">
<input type="hidden" name="current_year" id="current_y" value="<?php echo $current_year; ?>">
<input type="hidden" name="horiz" id="ho" value="<?php echo $horizon; ?>">
				<?php
for ($i=0; $i<count($groupes_multi); $i++)
	{ 
	echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';
	}
for ($i=0; $i<count($salles_multi); $i++)
	{ 
	echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';
	}
for ($i=0; $i<count($profs_multi); $i++)
	{ 
	echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';
	}
		 for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';
		}		
	?>
<input type="hidden" name="jour" id="jours" value="<?php echo $jour_jour_j; ?>">

</form><br><br>



<form  enctype="multipart/form-data" action="heure_formation.php" method="get">

<input type="hidden" name="lar" id="screen_w2" value="<?php echo $lar; ?>">
<input type="hidden" name="hau" id="screen_hi2" value="<?php echo $hau; ?>">
<input type="hidden" name="selec_prof" id="selec_pr2" value="<?php echo $selec_prof; ?>">
<input type="hidden" name="selec_groupe" id="selec_grou2" value="<?php echo $selec_groupe; ?>">
<input type="hidden" name="selec_salle" id="selec_sa2" value="<?php echo $selec_salle; ?>">
<input type="hidden" name="selec_materiel" id="selec_ma2" value="<?php echo $selec_materiel; ?>">
<input type="hidden" name="current_week" id="current_w2" value="<?php echo $current_week; ?>">
<input type="hidden" name="current_year" id="current_y2" value="<?php echo $current_year; ?>">
<input type="hidden" name="horiz" id="ho2" value="<?php echo $horizon; ?>">
<?php
for ($i=0; $i<count($groupes_multi); $i++)
	{ 
	echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';
	}
for ($i=0; $i<count($salles_multi); $i++)
	{ 
	echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';
	}
for ($i=0; $i<count($profs_multi); $i++)
	{ 
	echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';
	}
		 for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';
		}	
	
	?>


<p>Formation : <select name="formation" >
<?php

$sql="SELECT * FROM filieres where deleted= '0' ";
$req_filiere=$dbh->prepare($sql);	
$req_filiere->execute(array());
$res_filiere=$req_filiere->fetchAll();
foreach($res_filiere as $filiere)
	{
	$anneeFinBase=$filiere['dateFin'];
	$anneeFinBase=substr($anneeFinBase,0,4);
	}	

$sql="SELECT distinct (departement)  FROM ressources_groupes WHERE deleted='0' order by departement";
$sql="SELECT * FROM niveaux WHERE deleted='0' and typeElement='1' order by nom ";
$req_formation=$dbh->prepare($sql);
$req_formation->execute(array());
$res_formation=$req_formation->fetchAll();
foreach($res_formation as $formations)
	{
	if (isset($formation))
		{
		if ($formations['codeNiveau']==$formation)
			{
			echo '<option value="'.$formations['codeNiveau'].'"  selected="selected">'.$formations['nom'].'</option>';
			}
		else
			{
			echo '<option value="'.$formations['codeNiveau'].'">'.$formations['nom'].'</option>';
			}
		}
	else
		{
		echo '<option value="'.$formations['codeNiveau'].'">'.$formations['nom'].'</option>';
		}
	}


?>
</select>		
</p>				

<p>Jour de début : <select name="jour_debut" >

<?php 

$i=1;

while ($i<=31)
	{
	if (isset($jour_debut))
		{
		if ($i==$jour_debut)
			{
			?>
			<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
			<?php
			}
		else
			{
			?>	
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php
			}
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>
</select>				

				

Mois de début : <select name="mois_debut" >

<?php 
$i=1;
while ($i<=12)
	{
	if (isset($mois_debut))
		{
		if ($i==$mois_debut)
			{
			?>
			<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
			<?php
			}
		else
			{
			?>	
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php
			}
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>
</select>	





Année de début <select name="annee_debut" >

<?php 
$i=$anneeFinBase-$nbdebdd;
while ($i<=$anneeFinBase)
	{
	if (isset($annee_debut))
		{
		if ($i==$annee_debut)
			{
			?>
			<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
			<?php
			}
		else
			{
			?>	
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php
			}
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>

</select></p>



<p>Jour de fin : <select name="jour_fin" >
<?php 
$i=1;
while ($i<=31)
	{
	if (isset($jour_fin))
		{
		if ($i==$jour_fin)
			{
			?>
			<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
			<?php
			}
		else
			{
			?>	
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php
			}
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>

</select>				



Mois de fin : <select name="mois_fin" >
<?php 
$i=1;
while ($i<=12)
	{
	if (isset($mois_fin))
	{
	if ($i==$mois_fin)
		{
		?>
		<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
		<?php
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>

</select>	





Année de fin <select name="annee_fin" >

<?php 

$i=$anneeFinBase-$nbdebdd;



while ($i<=$anneeFinBase)
	{
	if (isset($annee_debut))
		{
		if ($i==$annee_fin)
			{
			?>
			<option value="<?php echo $i ?>" selected="selected"><?php echo $i ?></option>
			<?php
			}
		else
			{
			?>	
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php
			}
		}
	else
		{
		?>	
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	$i=$i+1;
	}
?>
</select></p>

Pour les vacataires, déclarer les TP en TD :<br>
Oui : <input name="vacataire" <?php if ($vacataire=="oui") echo 'checked="checked"'; ?> type="radio" id="vac_oui" value="oui" ><br>
Non : <input name="vacataire" <?php if ($vacataire=="non") echo 'checked="checked"'; ?> type="radio" id="vac_non" value="non" ><br>
<br>

Exporter les forfaits sans séance placée :<br>
Oui : <input name="export_forfait" <?php if ($export_forfait=="oui") echo 'checked="checked"'; ?> type="radio" id="forf_oui" value="oui" ><br>
Non : <input name="export_forfait" <?php if ($export_forfait=="non") echo 'checked="checked"'; ?> type="radio" id="forf_non" value="non" ><br>
<br>
<input type="hidden" name="jour" id="jours2" value="<?php echo $jour_jour_j; ?>">
<input type=button value="Envoyer" onclick="form.action='heure_giseh.php';form.submit()"> 
<input type=button value="Export vers Excel" onclick="form.action='heure_giseh_csv.php';form.submit()"> 
</form>



<?php
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

//il faut faire 2 tableaux par année. Un pour les permanents et un pour les vacataires
$categorie_profs = array('PERMANENT','VACATAIRE' );

foreach($categorie_profs as $categorie_prof)
{	

//preparation des requetes
//si vacataires
if ($categorie_prof=="VACATAIRE")
	{
	$sql="SELECT distinct (codeProf) FROM ressources_profs left join (seances_profs) on (seances_profs.codeRessource=ressources_profs.codeProf) left join (seances) on (seances.codeSeance=seances_profs.codeSeance ) left join (seances_groupes) on (seances.codeSeance=seances_groupes.codeSeance ) where seances.dateSeance<=:dateFin AND seances.dateSeance>=:dateDebut   and seances_profs.deleted='0' and ressources_profs.deleted= '0' AND seances.deleted='0' and seances_groupes.deleted='0' and ($ressource_formation) and  ressources_profs.titulaire!='1'   order by nom asc";
	$req_compteur_profs=$dbh->prepare($sql);
	
	$sql="SELECT * FROM ressources_profs  where  titulaire!='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);
	
	$titre_tableau="vacataires";
	}
//si permanents
else
	{
	$sql="SELECT distinct (codeProf) FROM ressources_profs left join (seances_profs) on (seances_profs.codeRessource=ressources_profs.codeProf) left join (seances) on (seances.codeSeance=seances_profs.codeSeance ) left join (seances_groupes) on (seances.codeSeance=seances_groupes.codeSeance ) where seances.dateSeance<=:dateFin AND seances.dateSeance>=:dateDebut   and seances_profs.deleted='0' and ressources_profs.deleted= '0' AND seances.deleted='0' and seances_groupes.deleted='0' and ($ressource_formation) and  ressources_profs.titulaire='1'   order by nom asc";
	$req_compteur_profs=$dbh->prepare($sql);
	
	$sql="SELECT * FROM ressources_profs  where titulaire='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);
	
	$titre_tableau="permanents";
	}


$sql="SELECT *, niveaux.identifiant as niveau, composantes.identifiant as identifiant_composante, ressources_groupes.identifiant as identifiant_groupe, ressources_groupes.nom as nom_groupe, ressources_groupes.typePublic as groupe_type_public, ressources_groupes.codeGroupe as codeGroupe FROM seances_profs left join (seances) on (seances.codeSeance=seances_profs.codeSeance ) left join (seances_groupes) on (seances.codeSeance=seances_groupes.codeSeance ) left join (ressources_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe)  left join (composantes) on (ressources_groupes.codeComposante=composantes.codeComposante) left join (enseignements) on (seances.codeEnseignement=enseignements.codeEnseignement) left join (niveaux) on (niveaux.codeNiveau=ressources_groupes.codeNiveau) where niveaux.deleted='0' and seances.dateSeance<=:dateFin AND seances.dateSeance>=:dateDebut AND seances_profs.codeRessource=:codeRessource AND enseignements.deleted='0' and seances_profs.deleted='0' and composantes.deleted='0'and ressources_groupes.deleted= '0' AND seances.deleted='0' and seances_groupes.deleted='0' and ($ressource_formation)  order by ressources_groupes.identifiant,enseignements.identifiant,enseignements.codeTypeActivite,ressources_groupes.typePublic,seances.dateSeance,seances.heureSeance";
$req_seance_profs=$dbh->prepare($sql);

$sql="SELECT * FROM lignes_budgetaires_groupes  left join (lignes_budgetaires) on  lignes_budgetaires_groupes.codeLigneBudgetaire=lignes_budgetaires.codeLigneBudgetaire   where  lignes_budgetaires_groupes.codeRessource=:codeGroupe AND lignes_budgetaires_groupes.deleted= '0' AND lignes_budgetaires.deleted= '0'"	;
$req_ligne_budgetaire=$dbh->prepare($sql);	


$sql="SELECT * FROM seances where codeSeance=:codeSeance AND deleted= '0'";
$req_seance=$dbh->prepare($sql);	


$sql="SELECT * FROM enseignements   where  enseignements.codeEnseignement=:codeEnseignement AND enseignements.deleted= '0'"	;
$req_enseignement=$dbh->prepare($sql);	


$sql="SELECT * FROM niveaux  where niveaux.deleted='0'  and niveaux.codeNiveau=:codeNiveau"	;
$req_semestre=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs where seances_profs.deleted='0' and seances_profs.codeSeance=:codeSeance "	;
$req_prof=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_groupes where seances_groupes.deleted='0' and seances_groupes.codeSeance=:codeSeance "	;
$req_groupe=$dbh->prepare($sql);	

$sql="SELECT * FROM seances left join seances_profs on seances.codeSeance=seances_profs.codeSeance where seances.deleted='0' and seances_profs.deleted='0' and seances_profs.codeRessource=:codeProf and seances.codeEnseignement=:codeEnseignement  ";
$req_seance_enseignement=$dbh->prepare($sql);	


$sql="SELECT * FROM enseignements left join (enseignements_profs) on (enseignements.codeEnseignement=enseignements_profs.codeEnseignement )  where enseignements_profs.codeRessource=:codeRessource AND enseignements_profs.deleted='0' AND enseignements.forfaitaire='1' AND enseignements.deleted='0' order by enseignements.nom"	;
$req_enseignement_forfait=$dbh->prepare($sql);	


$sql="SELECT *,  niveaux.identifiant as niveau, composantes.identifiant as identifiant_composante, ressources_groupes.identifiant as identifiant_groupe, ressources_groupes.nom as nom_groupe  FROM ressources_groupes left join (composantes) on (ressources_groupes.codeComposante=composantes.codeComposante) left join (niveaux) on (niveaux.codeNiveau=ressources_groupes.codeNiveau)  where niveaux.deleted='0' and codeGroupe=:codeGroupe AND composantes.deleted='0' and ressources_groupes.deleted= '0'"	;
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
	
	?>
	<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Export Giseh en <?php echo $formation_nom." (".$titre_tableau.")"; ?></span><br>
	<span style="font-size:20px; font-weight:bold;">P&eacute;riode du <?php echo $jour_debut;?>/<?php echo $mois_debut; ?>/<?php echo $annee_debut; ?> au  <?php echo $jour_fin;?>/<?php echo $mois_fin; ?>/<?php echo $annee_fin; ?></span><br>
	<span style="font-size:20px; font-weight:bold;">G&eacute;n&eacute;r&eacute; le <?php echo date('d');?>/<?php echo date('m'); ?>/<?php echo date('y'); ?></span><br></p>	
	<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Ann&eacute;e scolaire <?php echo $anneescolaire;?></span><br></p>
	<table><tr>
	<th align="center" bgcolor="black"><font color="white" >Nom</font></th>
	<th align="center" bgcolor="black"><font color="white" >Prénom</font></th>
	<th align="center" bgcolor="black"><font color="white" >Harpège</font></th>
	<th align="center" bgcolor="black"><font color="white" >Statut prof</font></th>
	<th align="center" bgcolor="black"><font color="white" >Version d'étape</font></th>
	<th align="center" bgcolor="black"><font color="white" >Filière</font></th>
	<th align="center" bgcolor="black"><font color="white" >Code composante</font></th>
	<th align="center" bgcolor="black"><font color="white" >Apog&eacute;e</font></th>
	<th align="center" bgcolor="black"><font color="white" >Niveau</font></th>
	<th align="center" bgcolor="black"><font color="white" >Cycle</font></th>
	<th align="center" bgcolor="black"><font color="white" >Periodicité</font></th>
	<th align="center" bgcolor="black"><font color="white" >Public</font></th>
	<th align="center" bgcolor="black"><font color="white" >Ligne Bugétaire</font></th>
	<th align="center" bgcolor="black"><font color="white" >Type</font></th>
	<th align="center" bgcolor="black"><font color="white" >Durée hebdo</font></th>
	<th align="center" bgcolor="black"><font color="white" >Nombre de semaines</font></th>
	<th align="center" bgcolor="black"><font color="white" >Enseignement</font></th>
	</tr>
	<?php	
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
$variable_prof="";	
$changement_a_la_ligne_suivante=0;
$variable_couleur=0;
$affichage_eqtd=0;
$code_apogee='';
$code_etape="";
$premiere_seance='1';
$nom_prof="";	
$prenom_prof="";	
$harpege_prof="";

//Trouve le codeProf du dernier prof à traiter afin de pouvoir forcer plus loin l'affichage de la dernière ligne du dernier profs. 
$req_compteur_profs->execute(array(':dateDebut'=>$date_debut_pour_requete,':dateFin'=>$date_fin_pour_requete));
$res_compteur_profs=$req_compteur_profs->fetchAll();	
foreach($res_compteur_profs as $res_compteur_prof)
	{	
	$code_du_dernier_prof=$res_compteur_prof['codeProf'];
	}



//boucle pour passer en revu tous les profs.
$req_profs->execute(array());
$res_profs=$req_profs->fetchAll();	
foreach($res_profs as $prof)
{	

$codeRessource=$prof['codeProf'];


//boucle pour passer en revu toutes les seance d'un profs. On en profite pour compter combien il y a de séances afin de pouvoir forcer plus loin l'affichage de la dernière ligne du dernier profs.
$compteur_seance=0;
$req_seance_profs->execute(array(':codeRessource'=>$codeRessource,':dateDebut'=>$date_debut_pour_requete,':dateFin'=>$date_fin_pour_requete));
$res_seance_profs=$req_seance_profs->fetchAll();
$nombre_seance_a_traiter=count($res_seance_profs);
foreach($res_seance_profs as $seance_prof)
{
		
$compteur_seance+=1;	
//nom groupes, version d'étape, filière, niveau et public	
$nom_seance_groupe=$seance_prof['nom_groupe'].", ";
$identifiant_composante=$seance_prof['identifiant_composante'];
$identifiant_groupe=$seance_prof['identifiant_groupe'];
$nouveau_code_etape=$identifiant_groupe;
$niveau=$seance_prof['niveau'];
$public=$seance_prof['groupe_type_public'];
if ($public=="0")
	{
	$public="AUTRE";
	}
elseif ($public=="1")
	{
	$public="FI";
	}
elseif ($public=="2")
	{
	$public="FA";
	}
elseif ($public=="3")
	{
	$public="FC";
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
$nouveau_code_apogee=$enseignement['identifiant'];

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
	
//comptage du nb de groupes associés à la séance
$nb_groupes=0;

$req_groupe->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
$res_groupe=$req_groupe->fetchAll();
foreach($res_groupe as $groupes_seance)
	{	
	$nb_groupes=$nb_groupes+1;
	}	

		

//duree cr td tp
if (strlen($seance['dureeSeance'])==5)
	{
	$heureduree=substr($seance['dureeSeance'],0,3);
	$minduree=substr($seance['dureeSeance'],3,2);
	}		
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

//type d'enseignement

if ($enseignement['codeTypeActivite']==1)
	{
	$type="CM";
	}
elseif ($enseignement['codeTypeActivite']==2)
	{
	$type="TD";
	}
elseif ($enseignement['codeTypeActivite']==3)
	{
	$type="TP";
	}
else
	{
	$type="TD";
	}			

//periodicité (semestre 1 ou 2) correspond au troisème chiffre avant la fin du code apogée
$periode="Erreur";
$req_semestre->execute(array(':codeNiveau'=>$enseignement['codeNiveau']));
$res_semestres=$req_semestre->fetchAll();
foreach($res_semestres as $res_semestre)
	{	
	$periode=$res_semestre['identifiant'];
	}	


if ($periode==1 || $periode==3 || $periode==5 || $periode==7)
	{
	$periode=1;
	}
elseif ($periode==2 || $periode==4 || $periode==6 || $periode==8)
	{
	$periode=2;
	}
elseif ($periode==0)
	{
	//pour les vacataires, la périodicité annuelle n'existe pas donc on force à la valeur 1 (semestre 1)
	if ($categorie_prof=="VACATAIRE")
	{
	$periode=1;
	}
	else
	{
	$periode=0;
	}
	}
else
	{
	$periode="Erreur";
	}



//calcul de la duree

if ($enseignement['volumeReparti']==1)
	{
	$dureeenmin=($heureduree*60+$minduree)/($nb_profs*$nb_groupes);
	}
else
	{
	$dureeenmin=($heureduree*60+$minduree)/$nb_groupes;
	}
$heureduree=intval($dureeenmin/60);
			
if (strlen($heureduree)==1)
	{
	$heureduree="0".$heureduree;
	}
$minduree=$dureeenmin%60;
if (strlen($minduree)==1)
	{
	$minduree="0".$minduree;
	}
if (strlen($minduree)==0)
	{
	$minduree="00";
	}	
$dureeeqtd=$heureduree."h".$minduree;
$total_heure_td+=$heureduree;
$total_min_td+=$minduree;
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
	
//comptage du nb de groupess associés à la séance
$nb_groupes=0;

$req_groupe->execute(array(':codeSeance'=>$seance_groupe_codeSeance));
$res_groupe=$req_groupe->fetchAll();
foreach($res_groupe as $groupes_seance)
	{	
	$nb_groupes=$nb_groupes+1;
	}	


//duree cr td tp
if (strlen($seance['dureeSeance'])==5)
	{
	$heureduree=substr($seance['dureeSeance'],0,3);
	$minduree=substr($seance['dureeSeance'],3,2);
	}	
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
//type d'enseignement			
if ($enseignement['codeTypeActivite']==1)
	{
	$type="CM";
	}
elseif ($enseignement['codeTypeActivite']==2)
	{
	$type="TD";
	}
elseif ($enseignement['codeTypeActivite']==3)
	{
	$type="TP";
	}
else
	{
	$type="TD";
	}
//periodicité (semestre 1 ou 2) correspond au troisème chiffre avant la fin du code apogée
$periode="Erreur";
$req_semestre->execute(array(':codeNiveau'=>$enseignement['codeNiveau']));
$res_semestres=$req_semestre->fetchAll();
foreach($res_semestres as $res_semestre)
	{	
	$periode=$res_semestre['identifiant'];
	}	
if ($periode==1 || $periode==3 || $periode==5 || $periode==7)
	{
	$periode=1;
	}
elseif ($periode==2 || $periode==4 || $periode==6 || $periode==8)
	{
	$periode=2;
	}
elseif ($periode==0)
	{
	//pour les vacataires, la périodicité annuelle n'existe pas donc on force à la valeur 1 (semestre 1)
	if ($categorie_prof=="VACATAIRE")
	{
	$periode=1;
	}
	else
	{
	$periode=0;
	}
	}
else
	{
	$periode="Erreur";
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
		
		



if ($enseignement['volumeReparti']==1)
	{
	$dureeenmin=(($heureduree_forfait*60+$minduree_forfait)/$nb_profs)/$nb_seances/$nb_groupes;
	}
else
	{
	$dureeenmin=($heureduree_forfait*60+$minduree_forfait)/$nb_seances/$nb_groupes;
	}
$heureduree=intval($dureeenmin/60);
										
if (strlen($heureduree)==1)
	{
	$heureduree="0".$heureduree;
	}
$minduree=$dureeenmin%60;
if (strlen($minduree)==1)
	{
	$minduree="0".$minduree;
	}
if (strlen($minduree)==0)
	{
	$minduree="00";
	}	
$dureeeqtd=$heureduree."h".$minduree;

			
			

$total_heure_forfait+=$heureduree;
$total_min_forfait+=$minduree;


?>		
</tr>
<?php
}	
	/*
//pour la dernière ligne du tableau (dernier enseignement du dernier prof), on comptabilise le nombre d'heure	
if	($compteur_seance==$nombre_seance_a_traiter && $code_du_dernier_prof==$prof['codeProf'])
	{
	$total_heure_eqtd+=$heureduree;
	$total_min_eqtd+=$minduree;
	}	
*/	
	
	
	
	
if ($premiere_seance=='0' && (($nouveau_code_apogee!=$code_apogee or $ancien_public!=$public or $nouveau_code_etape!=$code_etape or $prenom_prof!=$prof['prenom'] or $nom_prof!=$prof['nom'] or $ancien_type!=$type)))	
//if ($premiere_seance=='0' && (($nouveau_code_apogee!=$code_apogee or $ancien_public!=$public or $nouveau_code_etape!=$code_etape or $prenom_prof!=$prof['prenom'] or $nom_prof!=$prof['nom'] or $ancien_type!=$type) or ($compteur_seance==$nombre_seance_a_traiter && $code_du_dernier_prof==$prof['codeProf'])))
{






//changement des couleurs
if ($changement_a_la_ligne_suivante==1)
	{
	$changement_a_la_ligne_suivante=0;
	if ($variable_couleur==1)
		{
		$variable_couleur=0;
		}
	else
		{
		$variable_couleur=1;
		}
	}
if ($prenom_prof!=$prof['prenom'] || $nom_prof!=$prof['nom'] ) //test si on a change de prof pour la gestion des couleurs
	{
	$changement_a_la_ligne_suivante=1;
	}	

if ($variable_couleur==1)
	{
	if ($bgcolor=="#FFDCAA")
		{
		$bgcolor="#D2FFD2";
		}
	else
		{
		$bgcolor="#FFDCAA";
		}
	}
else
	{
	if ($bgcolor=="white")
		{
		$bgcolor="#FAFA50";
		}
	else
		{
		$bgcolor="white";
		}	
	}





//correction du code apogée pour master. Si cours avec méca et elec et ener, il faut 3 codes apogée différents et pas toujours le même. La troisieme lettre du code apogée correspond à la filiere.

//si grp des méca (M1 ou M2)
 if ($code_etape=="Z4MSCI91" || $code_etape=="Z5MSCI91" )
	 {
	 $lettre_code_apogee=substr($code_apogee, 2, 1);
	 if ($lettre_code_apogee!="M")
		 {
		 $longueur_code_apogee=strlen($code_apogee);
		 $code_apogee_a_afficher=substr($code_apogee, 0, 2)."M".substr($code_apogee, 3, $longueur_code_apogee-3);
		 }
	 else
		 {
		 $code_apogee_a_afficher=$code_apogee;
		 }
	 }
 //si grp des élec (M1 ou M2)
 elseif ($code_etape=="Z4EESC91" || $code_etape=="Z5EESC91")
	 {
	$lettre_code_apogee=substr($code_apogee, 2, 1);
	if ($lettre_code_apogee!="S")
		 {
		 $longueur_code_apogee=strlen($code_apogee);
		 $code_apogee_a_afficher=substr($code_apogee, 0, 2)."S".substr($code_apogee, 3, $longueur_code_apogee-3);
		 }
	else
		 {
		 $code_apogee_a_afficher=$code_apogee;
		 }
	 }
//si grp des ener (M1 ou M2)
elseif ($code_etape=="Z4ENMA91" || $code_etape=="Z5ENMA91")
	{
	$lettre_code_apogee=substr($code_apogee, 2, 1);
	if (($lettre_code_apogee!="E" && $lettre_code_apogee!="C")  && $code_apogee!='ZMMCO101' && $code_apogee!='ZMMMC101' && $code_apogee!='ZMMMS301') //pour le cours de composite de Manu qui est commun au M1 méca et au M2 éner, les 2 codes apogee ont plus de différences que seulement 1 lettre (ZMMMC101 et ZMEMA301)
		{
		$longueur_code_apogee=strlen($code_apogee);
		$code_apogee_a_afficher=substr($code_apogee, 0, 2)."E".substr($code_apogee, 3, $longueur_code_apogee-3);
		}
	else
		{
		$code_apogee_a_afficher=$code_apogee;
		}
		
	 //exception pour le cours de composite de Manu qui est commun au M1 méca et au M2 éner, les 2 codes apogee  ont plus de différences que seulement 1 lettre (ZMMMC101 et ZMEMA301)
		 if ($code_apogee_a_afficher=="ZMMMC101")
		{
		$code_apogee_a_afficher="ZMEMA301";
		}
 
	}
 


//correction pour la licence L3. Les codes apogée sont au format suivant : "MECA:ZMLRD501 ELEC:ZMLRD501"

elseif ($code_etape=="Z3ELEC91" )
	{
	if(stristr($code_apogee, 'elec:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'elec:'),5,8);
		}
	}
elseif ($code_etape=="Z3ENRG91" )
	{
	if(stristr($code_apogee, 'ener:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'ener:'),5,8);
		}
	}
elseif ($code_etape=="Z3MECA91" )
	{
	if(stristr($code_apogee, 'meca:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'meca:'),5,8);
		}
	}
else
	{
	$code_apogee_a_afficher=$code_apogee;
	}





//si le public est de type "autre", on paye 50% FI et 50%FA pour le tp donc on fait 2 lignes. 
if ($ancien_public=="AUTRE" && $ancien_type=="TP")
{
$n=2;
//la première ligne sera de l'apprentissage
$public_a_afficher="FA";
}
elseif ($ancien_public=="AUTRE" && $ancien_type!="TP")
{
$n=1;
//la première ligne sera de l'apprentissage
$public_a_afficher="FI";
}
else
{
$n=1;
$public_a_afficher=$ancien_public;

}



//mise en forme de la durée
$total_heure_eqtd_en_min=($total_heure_eqtd*60+$total_min_eqtd)/$n;



//pour les vacataire, on regarde si on doit transformer les TP en TD
if ($categorie_prof=="VACATAIRE") 
{
if ($ancien_type=="TP")
	{
	if ($vacataire=="oui")
		{
		$type_a_afficher="TD";
		}
	else
		{
		$type_a_afficher=$ancien_type;
		}
	}
	else
	{
	$type_a_afficher=$ancien_type;
	}
}
else
{
$type_a_afficher=$ancien_type;
}


//recherche de la ligne budgetaire pour payer les vacataires en FA et FC	
$req_ligne_budgetaire->execute(array(':codeGroupe'=>$ancien_code_groupe));
$lignes_budgetaires=$req_ligne_budgetaire->fetchAll();
$compteur_ligne_budgetaire=0;
foreach($lignes_budgetaires as $ligne_budgetaire)
	{	
	
	$compteur_ligne_budgetaire+=1;
	}		
	if ($compteur_ligne_budgetaire!="0")
	{
	$ligne_budgetaire_FA_FC_vac=$ligne_budgetaire['identifiant'];
	}
	else
	{
	$ligne_budgetaire_FA_FC_vac="Erreur";
	}




//verifie sur durée est inférieure à 12h soit 720 min Si oui on affiche une ligne . 
if ($total_heure_eqtd_en_min<=720)
	{

	
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
for ($i=0; $i<$n; $i++)
{			
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>">1</td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}


//si supérieur à 12h et le resultat de la division par 12, 10, 11, 10... est égale à 00min afin de favoriser l'affichage des heures avec des chiffres ronds
elseif ($total_heure_eqtd_en_min>720 and (($total_heure_eqtd_en_min%720==0 and $total_heure_eqtd_en_min/720<=12) or ($total_heure_eqtd_en_min%660==0 and $total_heure_eqtd_en_min/660<=12) or ($total_heure_eqtd_en_min%600==0 and $total_heure_eqtd_en_min/600<=12) or ($total_heure_eqtd_en_min%540==0 and $total_heure_eqtd_en_min/540<=12) or ($total_heure_eqtd_en_min%480==0 and $total_heure_eqtd_en_min/480<=12) or ($total_heure_eqtd_en_min%420==0 and $total_heure_eqtd_en_min/420<=12) ))
	{

	//nb de semaines
	if ($total_heure_eqtd_en_min%720==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/720;
		}	
	elseif ($total_heure_eqtd_en_min%660==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/660;
		}
	elseif ($total_heure_eqtd_en_min%600==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/600;
		}
	elseif ($total_heure_eqtd_en_min%540==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/540;
		}
	elseif ($total_heure_eqtd_en_min%480==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/480;
		}
	elseif ($total_heure_eqtd_en_min%420==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/420;
		}
	$total_heure_eqtd_en_min=$total_heure_eqtd_en_min/$nb_semaine;
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
	for ($i=0; $i<$n; $i++)
{		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}




//si supérieur à 12h et le reste de la division de la durée hebdo par le nombre de semaine est égale à zero et que le nombre de semaine est inférieur à 12
elseif ($total_heure_eqtd_en_min>720 and ( (($total_heure_eqtd_en_min%720)%intval($total_heure_eqtd_en_min/720)==0 and $total_heure_eqtd_en_min/720<=12) or (($total_heure_eqtd_en_min%660)%intval($total_heure_eqtd_en_min/660)==0 and $total_heure_eqtd_en_min/660<=12) or (($total_heure_eqtd_en_min%600)%intval($total_heure_eqtd_en_min/600)==0 and $total_heure_eqtd_en_min/600<=12) or (($total_heure_eqtd_en_min%540)%intval($total_heure_eqtd_en_min/540)==0 and $total_heure_eqtd_en_min/540<=12) or (($total_heure_eqtd_en_min%480)%intval($total_heure_eqtd_en_min/480)==0 and $total_heure_eqtd_en_min/480<=12) or (($total_heure_eqtd_en_min%420)%intval($total_heure_eqtd_en_min/420)==0 and $total_heure_eqtd_en_min/420<=12) or (($total_heure_eqtd_en_min%360)%intval($total_heure_eqtd_en_min/360)==0 and $total_heure_eqtd_en_min/360<=12) or (($total_heure_eqtd_en_min%300)%intval($total_heure_eqtd_en_min/300)==0 and $total_heure_eqtd_en_min/300<=12) or (($total_heure_eqtd_en_min%240)%intval($total_heure_eqtd_en_min/240)==0 and $total_heure_eqtd_en_min/240<=12) or (($total_heure_eqtd_en_min%180)%intval($total_heure_eqtd_en_min/180)==0 and $total_heure_eqtd_en_min/180<=12) or (($total_heure_eqtd_en_min%120)%intval($total_heure_eqtd_en_min/120)==0 and $total_heure_eqtd_en_min/120<=12) ))
	{

	//nb de semaines
	if (($total_heure_eqtd_en_min%720)%intval($total_heure_eqtd_en_min/720)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/720)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/720);
		}
	elseif (($total_heure_eqtd_en_min%660)%intval($total_heure_eqtd_en_min/660)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/660)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/660);
		}
	elseif (($total_heure_eqtd_en_min%600)%intval($total_heure_eqtd_en_min/600)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/600)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/600);
		}
	elseif (($total_heure_eqtd_en_min%540)%intval($total_heure_eqtd_en_min/540)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/540)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/540);
		}
	elseif (($total_heure_eqtd_en_min%480)%intval($total_heure_eqtd_en_min/480)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/480)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/480);
		}
	elseif (($total_heure_eqtd_en_min%420)%intval($total_heure_eqtd_en_min/420)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/420)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/420);
		}
	elseif (($total_heure_eqtd_en_min%360)%intval($total_heure_eqtd_en_min/360)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/360)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/360);
		}
	elseif (($total_heure_eqtd_en_min%300)%intval($total_heure_eqtd_en_min/300)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/300)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/300);
		}
	elseif (($total_heure_eqtd_en_min%240)%intval($total_heure_eqtd_en_min/240)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/240)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/240);
		}
	elseif (($total_heure_eqtd_en_min%180)%intval($total_heure_eqtd_en_min/180)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/180)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/180);
		}
	elseif (($total_heure_eqtd_en_min%120)%intval($total_heure_eqtd_en_min/120)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/120)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/120);
		}
	$total_heure_eqtd_en_min=$total_heure_eqtd_en_min/$nb_semaine;
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
	for ($i=0; $i<$n; $i++)
{		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}

	
	

else
	{
	$nb_de_semaine=intval($total_heure_eqtd_en_min/720);
	$minute_restante=$total_heure_eqtd_en_min%720;
	if ($nb_de_semaine>12)
		{
		$nb_de_semaine=12;
		$minute_restante=$total_heure_eqtd_en_min-(12*12*60);
		}

	//mise en forme de la durée pour la ligne 1
	$total_heure_ligne_1=($nb_de_semaine*720)/(60*$nb_de_semaine);
	$total_min_ligne_1=0;
	if (strlen($total_heure_ligne_1)==1)
		{
		$total_heure_ligne_1="0".$total_heure_ligne_1;
		}
	if (strlen($total_min_ligne_1)==1)
		{
		$total_min_ligne_1="0".$total_min_ligne_1;
		}
	if (strlen($total_min_ligne_1)==0)
		{
		$total_min_ligne_1="00";
		}

	//mise en forme de la durée pour la ligne 2
	if (($minute_restante%720)%intval($minute_restante/720)==0 and $minute_restante/intval($minute_restante/720)<=720 and $minute_restante/720<=12 and intval($minute_restante/720)>0)
		{
		$nb_semaine_l2=intval($minute_restante/720);
		}
	elseif (($minute_restante%660)%intval($minute_restante/660)==0 and $minute_restante/intval($minute_restante/660)<=720 and $minute_restante/660<=12 and intval($minute_restante/660)>0)
		{
		$nb_semaine_l2=intval($minute_restante/660);
		}
	elseif (($minute_restante%600)%intval($minute_restante/600)==0 and $minute_restante/intval($minute_restante/600)<=720 and $minute_restante/600<=12 and intval($minute_restante/600)>0)
		{
		$nb_semaine_l2=intval($minute_restante/600);
		}
	elseif (($minute_restante%540)%intval($minute_restante/540)==0 and $minute_restante/intval($minute_restante/540)<=720 and $minute_restante/540<=12 and intval($minute_restante/540)>0)
		{
		$nb_semaine_l2=intval($minute_restante/540);
		}
	elseif (($minute_restante%480)%intval($minute_restante/480)==0 and $minute_restante/intval($minute_restante/480)<=720 and $minute_restante/480<=12 and intval($minute_restante/480)>0)
		{
		$nb_semaine_l2=intval($minute_restante/480);
		}
	elseif (($minute_restante%420)%intval($minute_restante/420)==0 and $minute_restante/intval($minute_restante/420)<=720 and $minute_restante/420<=12 and intval($minute_restante/420)>0)
		{
		$nb_semaine_l2=intval($minute_restante/420);
		}
	elseif (($minute_restante%360)%intval($minute_restante/360)==0 and $minute_restante/intval($minute_restante/360)<=720 and $minute_restante/360<=12 and intval($minute_restante/360)>0)
		{
		$nb_semaine_l2=intval($minute_restante/360);
		}
	elseif (($minute_restante%300)%intval($minute_restante/300)==0 and $minute_restante/intval($minute_restante/300)<=720 and $minute_restante/300<=12 and intval($minute_restante/300)>0)
		{
		$nb_semaine_l2=intval($minute_restante/300);
		}
	elseif (($minute_restante%240)%intval($minute_restante/240)==0 and $minute_restante/intval($minute_restante/240)<=720 and $minute_restante/240<=12 and intval($minute_restante/240)>0)
		{
		$nb_semaine_l2=intval($minute_restante/240);
		}
	elseif (($minute_restante%180)%intval($minute_restante/180)==0 and $minute_restante/intval($minute_restante/180)<=720 and $minute_restante/180<=12 and intval($minute_restante/180)>0)
		{
		$nb_semaine_l2=intval($minute_restante/180);
		}
	elseif (($minute_restante%120)%intval($minute_restante/120)==0 and $minute_restante/intval($minute_restante/120)<=720 and $minute_restante/120<=12 and intval($minute_restante/120)>0)
		{
		$nb_semaine_l2=intval($minute_restante/120);
		}
	else
		{
		$nb_semaine_l2=1;
		}


	$total_heure_eqtd_en_min=$minute_restante/$nb_semaine_l2;
	$total_heure_ligne_2=intval($total_heure_eqtd_en_min/60);
	$total_min_ligne_2=$total_heure_eqtd_en_min%60;

	if (strlen($total_heure_ligne_2)==1)
		{
		$total_heure_ligne_2="0".$total_heure_ligne_2;
		}
	if (strlen($total_min_ligne_2)==1)
		{
		$total_min_ligne_2="0".$total_min_ligne_2;
		}
	if (strlen($total_min_ligne_2)==0)
		{
		$total_min_ligne_2="00";
		}
	for ($i=0; $i<$n; $i++)
{
	?>

	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_1.":".$total_min_ligne_1; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_de_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_2.":".$total_min_ligne_2; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine_l2 ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}

}

else
	{
	$total_heure_eqtd+=$heureduree;
	$total_min_eqtd+=$minduree;
	}	
	
$code_etape=$nouveau_code_etape;
$code_apogee=$nouveau_code_apogee;	
$premiere_seance='0';
$nom_prof=$prof['nom'];
$prenom_prof=$prof['prenom'];
$harpege_prof=$prof['identifiant'];
$ancien_public=$public;
$ancien_type=$type;
$ancienne_periode=$periode;
$ancien_nomenseignement=$nomenseignement;
$ancien_code_groupe=$seance_prof['codeGroupe'];
}


//affichage de la dernière ligne pour le dernier prof du tableau
if ($premiere_seance=='0' && (  ($compteur_seance==$nombre_seance_a_traiter && $code_du_dernier_prof==$prof['codeProf'])))
{






//changement des couleurs
if ($changement_a_la_ligne_suivante==1)
	{
	$changement_a_la_ligne_suivante=0;
	if ($variable_couleur==1)
		{
		$variable_couleur=0;
		}
	else
		{
		$variable_couleur=1;
		}
	}
if ($prenom_prof!=$prof['prenom'] || $nom_prof!=$prof['nom'] ) //test si on a change de prof pour la gestion des couleurs
	{
	$changement_a_la_ligne_suivante=1;
	}	

if ($variable_couleur==1)
	{
	if ($bgcolor=="#FFDCAA")
		{
		$bgcolor="#D2FFD2";
		}
	else
		{
		$bgcolor="#FFDCAA";
		}
	}
else
	{
	if ($bgcolor=="white")
		{
		$bgcolor="#FAFA50";
		}
	else
		{
		$bgcolor="white";
		}	
	}





//correction du code apogée pour master. Si cours avec méca et elec et ener, il faut 3 codes apogée différents et pas toujours le même. La troisieme lettre du code apogée correspond à la filiere.

//si grp des méca (M1 ou M2)
 if ($code_etape=="Z4MSCI91" || $code_etape=="Z5MSCI91" )
	 {
	 $lettre_code_apogee=substr($code_apogee, 2, 1);
	 if ($lettre_code_apogee!="M")
		 {
		 $longueur_code_apogee=strlen($code_apogee);
		 $code_apogee_a_afficher=substr($code_apogee, 0, 2)."M".substr($code_apogee, 3, $longueur_code_apogee-3);
		 }
	 else
		 {
		 $code_apogee_a_afficher=$code_apogee;
		 }
	 }
 //si grp des élec (M1 ou M2)
 elseif ($code_etape=="Z4EESC91" || $code_etape=="Z5EESC91")
	 {
	$lettre_code_apogee=substr($code_apogee, 2, 1);
	if ($lettre_code_apogee!="S")
		 {
		 $longueur_code_apogee=strlen($code_apogee);
		 $code_apogee_a_afficher=substr($code_apogee, 0, 2)."S".substr($code_apogee, 3, $longueur_code_apogee-3);
		 }
	else
		 {
		 $code_apogee_a_afficher=$code_apogee;
		 }
	 }
//si grp des ener (M1 ou M2)
elseif ($code_etape=="Z4ENMA91" || $code_etape=="Z5ENMA91")
	{
	$lettre_code_apogee=substr($code_apogee, 2, 1);
	if (($lettre_code_apogee!="E" && $lettre_code_apogee!="C") && $code_apogee!='ZMMCO101' && $code_apogee!='ZMMMC101' && $code_apogee!='ZMMMS301') //pour le cours de composite de Manu qui est commun au M1 méca et au M2 éner, les 2 codes apogee ont plus de différences que seulement 1 lettre (ZMMMC101 et ZMEMA301)
		{
		$longueur_code_apogee=strlen($code_apogee);
		$code_apogee_a_afficher=substr($code_apogee, 0, 2)."E".substr($code_apogee, 3, $longueur_code_apogee-3);
		}
	else
		{
		$code_apogee_a_afficher=$code_apogee;
		}
		
	 //exception pour le cours de composite de Manu qui est commun au M1 méca et au M2 éner, les 2 codes apogee  ont plus de différences que seulement 1 lettre (ZMMMC101 et ZMEMA301)
		 if ($code_apogee_a_afficher=="ZMMMC101")
		{
		$code_apogee_a_afficher="ZMEMA301";
		}
 
	}
 


//correction pour la licence L3. Les codes apogée sont au format suivant : "MECA:ZMLRD501 ELEC:ZMLRD501"

elseif ($code_etape=="Z3ELEC91" )
	{
	if(stristr($code_apogee, 'elec:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'elec:'),5,8);
		}
	}
elseif ($code_etape=="Z3ENRG91" )
	{
	if(stristr($code_apogee, 'ener:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'ener:'),5,8);
		}
	}
elseif ($code_etape=="Z3MECA91" )
	{
	if(stristr($code_apogee, 'meca:') === FALSE) 
		{
		$code_apogee_a_afficher=$code_apogee;
		}
	else
		{
		$code_apogee_a_afficher=substr(stristr($code_apogee, 'meca:'),5,8);
		}
	}
else
	{
	$code_apogee_a_afficher=$code_apogee;
	}





//si le public est de type "autre", on paye 50% FI et 50%FA pour le tp donc on fait 2 lignes. 
if ($ancien_public=="AUTRE" && $ancien_type=="TP")
{
$n=2;
//la première ligne sera de l'apprentissage
$public_a_afficher="FA";
}
elseif ($ancien_public=="AUTRE" && $ancien_type!="TP")
{
$n=1;
//la première ligne sera de l'apprentissage
$public_a_afficher="FI";
}
else
{
$n=1;
$public_a_afficher=$ancien_public;

}



//mise en forme de la durée
$total_heure_eqtd_en_min=($total_heure_eqtd*60+$total_min_eqtd)/$n;



//pour les vacataire, on regarde si on doit transformer les TP en TD
if ($categorie_prof=="VACATAIRE") 
{
if ($ancien_type=="TP")
	{
	if ($vacataire=="oui")
		{
		$type_a_afficher="TD";
		}
	else
		{
		$type_a_afficher=$ancien_type;
		}
	}
	else
	{
	$type_a_afficher=$ancien_type;
	}
}
else
{
$type_a_afficher=$ancien_type;
}


//recherche de la ligne budgetaire pour payer les vacataires en FA et FC	
$req_ligne_budgetaire->execute(array(':codeGroupe'=>$ancien_code_groupe));
$lignes_budgetaires=$req_ligne_budgetaire->fetchAll();
$compteur_ligne_budgetaire=0;
foreach($lignes_budgetaires as $ligne_budgetaire)
	{	
	
	$compteur_ligne_budgetaire+=1;
	}		
	if ($compteur_ligne_budgetaire!="0")
	{
	$ligne_budgetaire_FA_FC_vac=$ligne_budgetaire['identifiant'];
	}
	else
	{
	$ligne_budgetaire_FA_FC_vac="Erreur";
	}




//verifie sur durée est inférieure à 12h soit 720 min Si oui on affiche une ligne . 
if ($total_heure_eqtd_en_min<=720)
	{

	
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
for ($i=0; $i<$n; $i++)
{			
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>">1</td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}


//si supérieur à 12h et le resultat de la division par 12, 10, 11, 10... est égale à 00min afin de favoriser l'affichage des heures avec des chiffres ronds
elseif ($total_heure_eqtd_en_min>720 and (($total_heure_eqtd_en_min%720==0 and $total_heure_eqtd_en_min/720<=12) or ($total_heure_eqtd_en_min%660==0 and $total_heure_eqtd_en_min/660<=12) or ($total_heure_eqtd_en_min%600==0 and $total_heure_eqtd_en_min/600<=12) or ($total_heure_eqtd_en_min%540==0 and $total_heure_eqtd_en_min/540<=12) or ($total_heure_eqtd_en_min%480==0 and $total_heure_eqtd_en_min/480<=12) or ($total_heure_eqtd_en_min%420==0 and $total_heure_eqtd_en_min/420<=12) ))
	{

	//nb de semaines
	if ($total_heure_eqtd_en_min%720==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/720;
		}	
	elseif ($total_heure_eqtd_en_min%660==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/660;
		}
	elseif ($total_heure_eqtd_en_min%600==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/600;
		}
	elseif ($total_heure_eqtd_en_min%540==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/540;
		}
	elseif ($total_heure_eqtd_en_min%480==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/480;
		}
	elseif ($total_heure_eqtd_en_min%420==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min/420;
		}
	$total_heure_eqtd_en_min=$total_heure_eqtd_en_min/$nb_semaine;
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
	for ($i=0; $i<$n; $i++)
{		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}




//si supérieur à 12h et le reste de la division de la durée hebdo par le nombre de semaine est égale à zero et que le nombre de semaine est inférieur à 12
elseif ($total_heure_eqtd_en_min>720 and ( (($total_heure_eqtd_en_min%720)%intval($total_heure_eqtd_en_min/720)==0 and $total_heure_eqtd_en_min/720<=12) or (($total_heure_eqtd_en_min%660)%intval($total_heure_eqtd_en_min/660)==0 and $total_heure_eqtd_en_min/660<=12) or (($total_heure_eqtd_en_min%600)%intval($total_heure_eqtd_en_min/600)==0 and $total_heure_eqtd_en_min/600<=12) or (($total_heure_eqtd_en_min%540)%intval($total_heure_eqtd_en_min/540)==0 and $total_heure_eqtd_en_min/540<=12) or (($total_heure_eqtd_en_min%480)%intval($total_heure_eqtd_en_min/480)==0 and $total_heure_eqtd_en_min/480<=12) or (($total_heure_eqtd_en_min%420)%intval($total_heure_eqtd_en_min/420)==0 and $total_heure_eqtd_en_min/420<=12) or (($total_heure_eqtd_en_min%360)%intval($total_heure_eqtd_en_min/360)==0 and $total_heure_eqtd_en_min/360<=12) or (($total_heure_eqtd_en_min%300)%intval($total_heure_eqtd_en_min/300)==0 and $total_heure_eqtd_en_min/300<=12) or (($total_heure_eqtd_en_min%240)%intval($total_heure_eqtd_en_min/240)==0 and $total_heure_eqtd_en_min/240<=12) or (($total_heure_eqtd_en_min%180)%intval($total_heure_eqtd_en_min/180)==0 and $total_heure_eqtd_en_min/180<=12) or (($total_heure_eqtd_en_min%120)%intval($total_heure_eqtd_en_min/120)==0 and $total_heure_eqtd_en_min/120<=12) ))
	{

	//nb de semaines
	if (($total_heure_eqtd_en_min%720)%intval($total_heure_eqtd_en_min/720)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/720)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/720);
		}
	elseif (($total_heure_eqtd_en_min%660)%intval($total_heure_eqtd_en_min/660)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/660)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/660);
		}
	elseif (($total_heure_eqtd_en_min%600)%intval($total_heure_eqtd_en_min/600)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/600)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/600);
		}
	elseif (($total_heure_eqtd_en_min%540)%intval($total_heure_eqtd_en_min/540)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/540)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/540);
		}
	elseif (($total_heure_eqtd_en_min%480)%intval($total_heure_eqtd_en_min/480)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/480)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/480);
		}
	elseif (($total_heure_eqtd_en_min%420)%intval($total_heure_eqtd_en_min/420)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/420)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/420);
		}
	elseif (($total_heure_eqtd_en_min%360)%intval($total_heure_eqtd_en_min/360)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/360)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/360);
		}
	elseif (($total_heure_eqtd_en_min%300)%intval($total_heure_eqtd_en_min/300)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/300)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/300);
		}
	elseif (($total_heure_eqtd_en_min%240)%intval($total_heure_eqtd_en_min/240)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/240)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/240);
		}
	elseif (($total_heure_eqtd_en_min%180)%intval($total_heure_eqtd_en_min/180)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/180)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/180);
		}
	elseif (($total_heure_eqtd_en_min%120)%intval($total_heure_eqtd_en_min/120)==0 and $total_heure_eqtd_en_min/intval($total_heure_eqtd_en_min/120)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min/120);
		}
	$total_heure_eqtd_en_min=$total_heure_eqtd_en_min/$nb_semaine;
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
	for ($i=0; $i<$n; $i++)
{		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd.":".$total_min_eqtd; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
	}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}

	
	

else
	{
	$nb_de_semaine=intval($total_heure_eqtd_en_min/720);
	$minute_restante=$total_heure_eqtd_en_min%720;
	if ($nb_de_semaine>12)
		{
		$nb_de_semaine=12;
		$minute_restante=$total_heure_eqtd_en_min-(12*12*60);
		}

	//mise en forme de la durée pour la ligne 1
	$total_heure_ligne_1=($nb_de_semaine*720)/(60*$nb_de_semaine);
	$total_min_ligne_1=0;
	if (strlen($total_heure_ligne_1)==1)
		{
		$total_heure_ligne_1="0".$total_heure_ligne_1;
		}
	if (strlen($total_min_ligne_1)==1)
		{
		$total_min_ligne_1="0".$total_min_ligne_1;
		}
	if (strlen($total_min_ligne_1)==0)
		{
		$total_min_ligne_1="00";
		}

	//mise en forme de la durée pour la ligne 2
	if (($minute_restante%720)%intval($minute_restante/720)==0 and $minute_restante/intval($minute_restante/720)<=720 and $minute_restante/720<=12 and intval($minute_restante/720)>0)
		{
		$nb_semaine_l2=intval($minute_restante/720);
		}
	elseif (($minute_restante%660)%intval($minute_restante/660)==0 and $minute_restante/intval($minute_restante/660)<=720 and $minute_restante/660<=12 and intval($minute_restante/660)>0)
		{
		$nb_semaine_l2=intval($minute_restante/660);
		}
	elseif (($minute_restante%600)%intval($minute_restante/600)==0 and $minute_restante/intval($minute_restante/600)<=720 and $minute_restante/600<=12 and intval($minute_restante/600)>0)
		{
		$nb_semaine_l2=intval($minute_restante/600);
		}
	elseif (($minute_restante%540)%intval($minute_restante/540)==0 and $minute_restante/intval($minute_restante/540)<=720 and $minute_restante/540<=12 and intval($minute_restante/540)>0)
		{
		$nb_semaine_l2=intval($minute_restante/540);
		}
	elseif (($minute_restante%480)%intval($minute_restante/480)==0 and $minute_restante/intval($minute_restante/480)<=720 and $minute_restante/480<=12 and intval($minute_restante/480)>0)
		{
		$nb_semaine_l2=intval($minute_restante/480);
		}
	elseif (($minute_restante%420)%intval($minute_restante/420)==0 and $minute_restante/intval($minute_restante/420)<=720 and $minute_restante/420<=12 and intval($minute_restante/420)>0)
		{
		$nb_semaine_l2=intval($minute_restante/420);
		}
	elseif (($minute_restante%360)%intval($minute_restante/360)==0 and $minute_restante/intval($minute_restante/360)<=720 and $minute_restante/360<=12 and intval($minute_restante/360)>0)
		{
		$nb_semaine_l2=intval($minute_restante/360);
		}
	elseif (($minute_restante%300)%intval($minute_restante/300)==0 and $minute_restante/intval($minute_restante/300)<=720 and $minute_restante/300<=12 and intval($minute_restante/300)>0)
		{
		$nb_semaine_l2=intval($minute_restante/300);
		}
	elseif (($minute_restante%240)%intval($minute_restante/240)==0 and $minute_restante/intval($minute_restante/240)<=720 and $minute_restante/240<=12 and intval($minute_restante/240)>0)
		{
		$nb_semaine_l2=intval($minute_restante/240);
		}
	elseif (($minute_restante%180)%intval($minute_restante/180)==0 and $minute_restante/intval($minute_restante/180)<=720 and $minute_restante/180<=12 and intval($minute_restante/180)>0)
		{
		$nb_semaine_l2=intval($minute_restante/180);
		}
	elseif (($minute_restante%120)%intval($minute_restante/120)==0 and $minute_restante/intval($minute_restante/120)<=720 and $minute_restante/120<=12 and intval($minute_restante/120)>0)
		{
		$nb_semaine_l2=intval($minute_restante/120);
		}
	else
		{
		$nb_semaine_l2=1;
		}


	$total_heure_eqtd_en_min=$minute_restante/$nb_semaine_l2;
	$total_heure_ligne_2=intval($total_heure_eqtd_en_min/60);
	$total_min_ligne_2=$total_heure_eqtd_en_min%60;

	if (strlen($total_heure_ligne_2)==1)
		{
		$total_heure_ligne_2="0".$total_heure_ligne_2;
		}
	if (strlen($total_min_ligne_2)==1)
		{
		$total_min_ligne_2="0".$total_min_ligne_2;
		}
	if (strlen($total_min_ligne_2)==0)
		{
		$total_min_ligne_2="00";
		}
	for ($i=0; $i<$n; $i++)
{
	?>

	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_1.":".$total_min_ligne_1; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_de_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prenom_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $harpege_prof; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_etape; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($identifiant_composante); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $code_apogee_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancienne_periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public_a_afficher=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public_a_afficher=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public_a_afficher=="FA" || $public_a_afficher=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $type_a_afficher; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_2.":".$total_min_ligne_2; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine_l2 ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $ancien_nomenseignement; ?></td>
	</tr>
	<?php
	$public_a_afficher="FI";
}
	$total_heure_eqtd=$heureduree;
	$total_min_eqtd=$minduree;
	}

}

	






	
	

//forfait sans séance placées
	if ($export_forfait=="oui")
	{
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
	//recherche de la ligne budgetaire pour payer les vacataires en FA et FC	
	$req_ligne_budgetaire->execute(array(':codeGroupe'=>$groupes_enseignement_au_forfait['codeRessource']));
	$lignes_budgetaires=$req_ligne_budgetaire->fetchAll();
	$compteur_ligne_budgetaire=0;
	foreach($lignes_budgetaires as $ligne_budgetaire)
		{	
		
		$compteur_ligne_budgetaire+=1;
		}		
		if ($compteur_ligne_budgetaire!="0")
		{
		$ligne_budgetaire_FA_FC_vac=$ligne_budgetaire['identifiant'];
		}
		else
		{
		$ligne_budgetaire_FA_FC_vac="Erreur";
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

// récupération du code de l'activité
$CodeActivite=$enseignements_au_forfait['codeTypeActivite'];


// on écrit une ligne par groupe afin de répartir les heures sur les différents groupes. Par exemple, en L3, répartition sur les trois parcours
$req_groupe_enseignement->execute(array(':codeEnseignement'=>$codeenseignement));
$res_groupe_enseignement=$req_groupe_enseignement->fetchAll();
$nombre_de_groupes=count($res_groupe_enseignement);
foreach($res_groupe_enseignement as $groupes_enseignement_au_forfait)
{
//recherche des infos sur l'enseignement et sur les groupes
	$codeGroupe=$groupes_enseignement_au_forfait['codeRessource'];
	//nom groupe, version d'étape, filiere
	$req_groupe_forfait->execute(array(':codeGroupe'=>$codeGroupe));
	$res_groupe_forfait=$req_groupe_forfait->fetchAll();
	foreach($res_groupe_forfait as $groupe)
		{	
		$nom_forfait_groupe=$nom_forfait_groupe.$groupe['nom_groupe']." ";
		$identifiant_groupe=$groupe['identifiant_groupe'];
		$identifiant_composante=$groupe['identifiant_composante'];
		$niveau=$groupe['niveau'];
		}


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

//changement des couleurs

if ($changement_a_la_ligne_suivante==1)
	{
	$changement_a_la_ligne_suivante=0;
	if ($variable_couleur==1)
		{
		$variable_couleur=0;
		}
	else
		{
		$variable_couleur=1;
		}
	}
if ($prenom_prof!=$prof['prenom'] || $nom_prof!=$prof['nom'] ) //test si on a change de prof pour la gestion des couleurs
	{
	$changement_a_la_ligne_suivante=1;
	}			

if ($variable_couleur==1)
	{
	if ($bgcolor=="#FFDCAA")
		{
		$bgcolor="#D2FFD2";
		}
	else
		{
		$bgcolor="#FFDCAA";
		}
	}
else
	{
	if ($bgcolor=="white")
		{
		$bgcolor="#FAFA50";
		}
	else
		{
		$bgcolor="white";
		}	
	}	

//Type de public		
$public=$enseignements_au_forfait['typePublic'];
if ($public=="0")
	{
	//si le public est de type "autre" (0), on paye 100% en FI et non pas 50%fi et 50%fa car les forfaits sans séances sont sous forme de TD et non de TP. 
	$public="FI";
	}
elseif ($public=="1")
	{
	$public="FI";
	}
elseif ($public=="2")
	{
	$public="FA";
	}
elseif ($public=="3")
	{
	$public="FC";
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


/*
if ($enseignements_au_forfait['volumeReparti']==1)
	{
	$dureeenmin=$heureduree*60+$minduree;
	$dureeenmin=$dureeenmin/$nb_profs_forfait;
	$heureduree=intval($dureeenmin/60);
						
	if (strlen($heureduree)==1)
		{
		$heureduree="0".$heureduree;
		}
	$minduree=$dureeenmin%60;
	if (strlen($minduree)==1)
		{
		$minduree="0".$minduree;
		}
	if (strlen($minduree)==0)
		{
		$minduree="00";
		}
	}
*/
	
			
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

	
	
	
	
	
	
	
	
//periodicité (semestre 1 ou 2) correspond au troisème chiffre avant la fin du code apogée
$periode="Erreur";
$req_semestre->execute(array(':codeNiveau'=>$enseignements_au_forfait['codeNiveau']));
$res_semestres=$req_semestre->fetchAll();
foreach($res_semestres as $res_semestre)
	{	
	$periode=$res_semestre['identifiant'];
	}	


if ($periode==1 || $periode==3 || $periode==5 || $periode==7)
	{
	$periode=1;
	}
elseif ($periode==2 || $periode==4 || $periode==6 || $periode==8)
	{
	$periode=2;
	}
elseif ($periode==0 )
	{
	//pour les vacataires, la périodicité annuelle n'existe pas donc on force à la valeur 1 (semestre 1)
	if ($categorie_prof=="VACATAIRE")
	{
	$periode=1;
	}
	else
	{
	$periode=0;
	}
	}
else
	{
	$periode="Erreur";
	}

	
	
	
	
	
	
	
	
	
//mise en forme matiere
$pos_dudebut = strpos($enseignements_au_forfait['nom'], "_")+1;	
$pos_defin = strripos($enseignements_au_forfait['nom'], "_");	
$longueur=$pos_defin-$pos_dudebut;
$nomenseignement=substr($enseignements_au_forfait['nom'],$pos_dudebut,$longueur);












//mise en forme de la durée
/*
$total_heure_eqtd_en_min_au_forfait=($heureduree*60+$minduree)/$nombre_de_groupes;
*/
$total_heure_eqtd_en_min_au_forfait=(($heuredureeCM*60+$mindureeCM)/$nombre_de_groupes)+(($heuredureeTD*60+$mindureeTD)/$nombre_de_groupes)+(($heuredureeTP*60+$mindureeTP)/$nombre_de_groupes);


//verifie sur durée est inférieure à 12h soit 720 min Si oui on affiche une ligne . 
if ($total_heure_eqtd_en_min_au_forfait<=720)
	{
	$total_heure_eqtd_au_forfait=intval($total_heure_eqtd_en_min_au_forfait/60);
	$total_min_eqtd_au_forfait=$total_heure_eqtd_en_min_au_forfait%60;
	if (strlen($total_heure_eqtd_au_forfait)==1)
		{
		$total_heure_eqtd_au_forfait="0".$total_heure_eqtd_au_forfait;
		}
	if (strlen($total_min_eqtd_au_forfait)==1)
		{
		$total_min_eqtd_au_forfait="0".$total_min_eqtd_au_forfait;
		}
	if (strlen($total_min_eqtd_au_forfait)==0)
		{
		$total_min_eqtd_au_forfait="00";
		}
		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['nom']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_groupe; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_composante; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public=="FA" || $public=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo "CM";}  elseif($heuredureeTD!="00" or $mindureeTD!="00") {echo "TD";}  elseif($heuredureeTP!="00" or $mindureeTP!="00") {echo "TP";}   else {echo "TD";}  ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd_au_forfait.":".$total_min_eqtd_au_forfait; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>">1</td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
	</tr>
	<?php

	$total_heure_eqtd_au_forfait=$heureduree;
	$total_min_eqtd_au_forfait=$minduree;
	}


//si supérieur à 12h et le resultat de la division par 12, 10, 11, 10... est égale à 00min afin de favoriser l'affichage des heures avec des chiffres ronds
elseif ($total_heure_eqtd_en_min_au_forfait>720 and (($total_heure_eqtd_en_min_au_forfait%720==0 and $total_heure_eqtd_en_min_au_forfait/720<=12) or ($total_heure_eqtd_en_min_au_forfait%660==0 and $total_heure_eqtd_en_min_au_forfait/660<=12) or ($total_heure_eqtd_en_min_au_forfait%600==0 and $total_heure_eqtd_en_min_au_forfait/660<=12) or ($total_heure_eqtd_en_min_au_forfait%540==0 and $total_heure_eqtd_en_min_au_forfait/540<=12) or ($total_heure_eqtd_en_min_au_forfait%480==0 and $total_heure_eqtd_en_min_au_forfait/480<=12) or ($total_heure_eqtd_en_min_au_forfait%420==0 and $total_heure_eqtd_en_min_au_forfait/420<=12) ))
	{
	//nb de semaines
	if ($total_heure_eqtd_en_min_au_forfait%720==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/720;
		}
	elseif ($total_heure_eqtd_en_min_au_forfait%660==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/660;
		}
	elseif ($total_heure_eqtd_en_min_au_forfait%600==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/600;
		}
	elseif ($total_heure_eqtd_en_min_au_forfait%540==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/540;
		}
	elseif ($total_heure_eqtd_en_min_au_forfait%480==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/480;
		}
	elseif ($total_heure_eqtd_en_min_au_forfait%420==0)
		{
		$nb_semaine=$total_heure_eqtd_en_min_au_forfait/420;
		}

	$total_heure_eqtd_en_min_au_forfait=$total_heure_eqtd_en_min_au_forfait/$nb_semaine;
	$total_heure_eqtd_au_forfait=intval($total_heure_eqtd_en_min_au_forfait/60);
	$total_min_eqtd_au_forfait=$total_heure_eqtd_en_min_au_forfait%60;
	if (strlen($total_heure_eqtd_au_forfait)==1)
		{
		$total_heure_eqtd_au_forfait="0".$total_heure_eqtd_au_forfait;
		}
	if (strlen($total_min_eqtd_au_forfait)==1)
		{
		$total_min_eqtd_au_forfait="0".$total_min_eqtd_au_forfait;
		}
	if (strlen($total_min_eqtd_au_forfait)==0)
		{
		$total_min_eqtd_au_forfait="00";
		}		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['nom']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_groupe; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_composante; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public=="FA" || $public=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo "CM";}  elseif($heuredureeTD!="00" or $mindureeTD!="00") {echo "TD";}  elseif($heuredureeTP!="00" or $mindureeTP!="00") {echo "TP";}  else {echo "TD";}  ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd_au_forfait.":".$total_min_eqtd_au_forfait; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
	</tr>
	<?php
	$total_heure_eqtd_au_forfait=$heureduree;
	$total_min_eqtd_au_forfait=$minduree;
	}





//si supérieur à 12h et le reste de la division de la durée hebdo par le nombre de semaine est égale à zero et que le nombre de semaine est inférieur à 12
elseif ($total_heure_eqtd_en_min_au_forfait>720 and ( (($total_heure_eqtd_en_min_au_forfait%720)%intval($total_heure_eqtd_en_min_au_forfait/720)==0 and $total_heure_eqtd_en_min_au_forfait/720<=12) or (($total_heure_eqtd_en_min_au_forfait%660)%intval($total_heure_eqtd_en_min_au_forfait/660)==0 and $total_heure_eqtd_en_min_au_forfait/660<=12) or (($total_heure_eqtd_en_min_au_forfait%600)%intval($total_heure_eqtd_en_min_au_forfait/600)==0 and $total_heure_eqtd_en_min_au_forfait/600<=12) or (($total_heure_eqtd_en_min_au_forfait%540)%intval($total_heure_eqtd_en_min_au_forfait/540)==0 and $total_heure_eqtd_en_min_au_forfait/540<=12) or (($total_heure_eqtd_en_min_au_forfait%480)%intval($total_heure_eqtd_en_min_au_forfait/480)==0 and $total_heure_eqtd_en_min_au_forfait/480<=12) or (($total_heure_eqtd_en_min_au_forfait%420)%intval($total_heure_eqtd_en_min_au_forfait/420)==0 and $total_heure_eqtd_en_min_au_forfait/420<=12) or (($total_heure_eqtd_en_min_au_forfait%360)%intval($total_heure_eqtd_en_min_au_forfait/360)==0 and $total_heure_eqtd_en_min_au_forfait/360<=12) or (($total_heure_eqtd_en_min_au_forfait%300)%intval($total_heure_eqtd_en_min_au_forfait/300)==0 and $total_heure_eqtd_en_min_au_forfait/300<=12) or (($total_heure_eqtd_en_min_au_forfait%240)%intval($total_heure_eqtd_en_min_au_forfait/240)==0 and $total_heure_eqtd_en_min_au_forfait/240<=12) or (($total_heure_eqtd_en_min_au_forfait%180)%intval($total_heure_eqtd_en_min_au_forfait/180)==0 and $total_heure_eqtd_en_min_au_forfait/180<=12) or (($total_heure_eqtd_en_min_au_forfait%120)%intval($total_heure_eqtd_en_min_au_forfait/120)==0 and $total_heure_eqtd_en_min_au_forfait/120<=12) ))
	{
	//nb de semaines
	if (($total_heure_eqtd_en_min_au_forfait%720)%intval($total_heure_eqtd_en_min_au_forfait/720)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/720)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/720);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%660)%intval($total_heure_eqtd_en_min_au_forfait/660)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/660)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/660);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%600)%intval($total_heure_eqtd_en_min_au_forfait/600)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/600)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/600);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%540)%intval($total_heure_eqtd_en_min_au_forfait/540)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/540)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/540);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%480)%intval($total_heure_eqtd_en_min_au_forfait/480)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/480)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/480);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%420)%intval($total_heure_eqtd_en_min_au_forfait/420)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/420)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/420);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%360)%intval($total_heure_eqtd_en_min_au_forfait/360)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/360)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/360);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%300)%intval($total_heure_eqtd_en_min_au_forfait/300)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/300)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/300);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%240)%intval($total_heure_eqtd_en_min_au_forfait/240)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/240)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/240);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%180)%intval($total_heure_eqtd_en_min_au_forfait/180)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/180)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/180);
		}
	elseif (($total_heure_eqtd_en_min_au_forfait%120)%intval($total_heure_eqtd_en_min_au_forfait/120)==0 and $total_heure_eqtd_en_min_au_forfait/intval($total_heure_eqtd_en_min_au_forfait/120)<=720)
		{
		$nb_semaine=intval($total_heure_eqtd_en_min_au_forfait/120);
		}

	$total_heure_eqtd_en_min_au_forfait=$total_heure_eqtd_en_min_au_forfait/$nb_semaine;
	$total_heure_eqtd_au_forfait=intval($total_heure_eqtd_en_min_au_forfait/60);
	$total_min_eqtd_au_forfait=$total_heure_eqtd_en_min_au_forfait%60;
	if (strlen($total_heure_eqtd_au_forfait)==1)
		{
		$total_heure_eqtd_au_forfait="0".$total_heure_eqtd_au_forfait;
		}

	if (strlen($total_min_eqtd_au_forfait)==1)
		{
		$total_min_eqtd_au_forfait="0".$total_min_eqtd_au_forfait;
		}
	if (strlen($total_min_eqtd_au_forfait)==0)
		{
		$total_min_eqtd_au_forfait="00";
		}		
	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['nom']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_groupe; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_composante; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public=="FA" || $public=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo "CM";}  elseif($heuredureeTD!="00" or $mindureeTD!="00") {echo "TD";}  elseif($heuredureeTP!="00" or $mindureeTP!="00") {echo "TP";}  else {echo "TD";}   ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_eqtd_au_forfait.":".$total_min_eqtd_au_forfait; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
	</tr>
	<?php
	$total_heure_eqtd_au_forfait=$heureduree;
	$total_min_eqtd_au_forfait=$minduree;
	}






else
	{
	$nb_de_semaine=intval($total_heure_eqtd_en_min_au_forfait/720);
	$minute_restante=$total_heure_eqtd_en_min_au_forfait%720;
	if ($nb_de_semaine>12)
		{
		$nb_de_semaine=12;
		$minute_restante=$total_heure_eqtd_en_min_au_forfait-(12*12*60);
		}
	//mise en forme de la durée pour la ligne 1
	$total_heure_ligne_1_au_forfait=($nb_de_semaine*720)/(60*$nb_de_semaine);
	$total_min_ligne_1_au_forfait=0;
	if (strlen($total_heure_ligne_1_au_forfait)==1)
		{
		$total_heure_ligne_1_au_forfait="0".$total_heure_ligne_1_au_forfait;
		}

	if (strlen($total_min_ligne_1_au_forfait)==1)
		{
		$total_min_ligne_1_au_forfait="0".$total_min_ligne_1_au_forfait;
		}
	if (strlen($total_min_ligne_1_au_forfait)==0)
		{
		$total_min_ligne_1_au_forfait="00";
		}
	//mise en forme de la durée pour la ligne 2

	if (($minute_restante%720)%intval($minute_restante/720)==0 and $minute_restante/intval($minute_restante/720)<=720 and intval($minute_restante/720)>0)
		{
		$nb_semaine_l2=intval($minute_restante/720);
		}
	elseif (($minute_restante%660)%intval($minute_restante/660)==0 and $minute_restante/intval($minute_restante/660)<=720 and intval($minute_restante/660)>0)
		{
		$nb_semaine_l2=intval($minute_restante/660);
		}
	elseif (($minute_restante%600)%intval($minute_restante/600)==0 and $minute_restante/intval($minute_restante/600)<=720 and intval($minute_restante/600)>0)
		{
		$nb_semaine_l2=intval($minute_restante/600);
		}
	elseif (($minute_restante%540)%intval($minute_restante/540)==0 and $minute_restante/intval($minute_restante/540)<=720 and intval($minute_restante/540)>0)
		{
		$nb_semaine_l2=intval($minute_restante/540);
		}
	elseif (($minute_restante%480)%intval($minute_restante/480)==0 and $minute_restante/intval($minute_restante/480)<=720 and intval($minute_restante/480)>0)
		{
		$nb_semaine_l2=intval($minute_restante/480);
		}
	elseif (($minute_restante%420)%intval($minute_restante/420)==0 and $minute_restante/intval($minute_restante/420)<=720 and intval($minute_restante/420)>0)
		{
		$nb_semaine_l2=intval($minute_restante/420);
		}
	elseif (($minute_restante%360)%intval($minute_restante/360)==0 and $minute_restante/intval($minute_restante/360)<=720 and intval($minute_restante/360)>0)
		{
		$nb_semaine_l2=intval($minute_restante/360);
		}
	elseif (($minute_restante%300)%intval($minute_restante/300)==0 and $minute_restante/intval($minute_restante/300)<=720 and intval($minute_restante/300)>0)
		{
		$nb_semaine_l2=intval($minute_restante/300);
		}
	elseif (($minute_restante%240)%intval($minute_restante/240)==0 and $minute_restante/intval($minute_restante/240)<=720 and intval($minute_restante/240)>0)
		{
		$nb_semaine_l2=intval($minute_restante/240);
		}
	elseif (($minute_restante%180)%intval($minute_restante/180)==0 and $minute_restante/intval($minute_restante/180)<=720 and intval($minute_restante/180)>0)
		{
		$nb_semaine_l2=intval($minute_restante/180);
		}
	elseif (($minute_restante%120)%intval($minute_restante/120)==0 and $minute_restante/intval($minute_restante/120)<=720 and intval($minute_restante/120)>0)
		{
		$nb_semaine_l2=intval($minute_restante/120);
		}
	else
		{
		$nb_semaine_l2=1;
		}

	$total_heure_eqtd_en_min_au_forfait=$minute_restante/$nb_semaine_l2;
	$total_heure_ligne_2_au_forfait=intval($total_heure_eqtd_en_min_au_forfait/60);
	$total_min_ligne_2_au_forfait=$total_heure_eqtd_en_min_au_forfait%60;

	if (strlen($total_heure_ligne_2_au_forfait)==1)
		{
		$total_heure_ligne_2_au_forfait="0".$total_heure_ligne_2_au_forfait;
		}
	if (strlen($total_min_ligne_2_au_forfait)==1)
		{
		$total_min_ligne_2_au_forfait="0".$total_min_ligne_2_au_forfait;
		}
	if (strlen($total_min_ligne_2_au_forfait)==0)
		{
		$total_min_ligne_2_au_forfait="00";
		}

	?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['nom']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_groupe; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_composante; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public=="FA" || $public=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo "CM";}  elseif($heuredureeTD!="00" or $mindureeTD!="00") {echo "TD";} elseif($heuredureeTP!="00" or $mindureeTP!="00") {echo "TP";}  else {echo "TD";}   ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_1_au_forfait.":".$total_min_ligne_1_au_forfait; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_de_semaine; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
	</tr>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['nom']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $prof['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($categorie_prof=="VACATAIRE"){echo "V";} elseif ($categorie_prof=="PERMANENT") {echo "P";}else {echo "erreur";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_groupe; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $identifiant_composante; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($identifiant_composante=="SIT"){echo "909";} else {echo "960";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $niveau; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($niveau==1 || $niveau==2 || $niveau ==3)  {echo "L";}else {echo "M";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $periode; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $public; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($identifiant_composante=="SIT" && $public=="FI" ){echo $ligne_sitec_FI;} elseif ($identifiant_composante=="SIT" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_sitec_titulaire_FA_FC;}  elseif ($identifiant_composante=="TI1" && $public=="FI" ){echo $ligne_iut_FI;} elseif ($identifiant_composante=="TI1" && ($public=="FA" || $public=="FC")  && $categorie_prof=="PERMANENT"){echo $ligne_iut_titulaire_FA_FC;} elseif (($public=="FA" || $public=="FC")  && $categorie_prof=="VACATAIRE"){echo $ligne_budgetaire_FA_FC_vac;}  else {echo "Erreur";}?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if ($heuredureeCM!="00" or $mindureeCM!="00") {echo "CM";}  elseif($heuredureeTD!="00" or $mindureeTD!="00") {echo "TD";} elseif($heuredureeTP!="00" or $mindureeTP!="00") {echo "TP";} else {echo "TD";} ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $total_heure_ligne_2_au_forfait.":".$total_min_ligne_2_au_forfait; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_semaine_l2; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
	</tr>
	<?php
	}
}
}
}
}
}
}
?>
</table>

<?php
}
}
}
}

?>
</div>
<?php
}
}
else
{
echo 'Vous avez été déconnecté. Cliquez <a style="color:#0000EE" href="index.php">ICI </a> pour retourner à la page principale ';
}
?>
</body>
</html>
