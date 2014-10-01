<?php
session_start();

include("config.php");
error_reporting(E_ALL);

//lignes budgetaires
$ligne_sitec_FI="A90083SITC";
$ligne_sitec_titulaire_FA_FC="F9091HEUR";

$ligne_iut_FI="A90083IUT";
$ligne_iut_titulaire_FA_FC="F9609HEUR";

	
//initialisation de variables
$variable_couleur=0;	
$bgcolor="#FAFA50";

	
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

if (isset ($_GET['diplome']))
	{
	$diplome=$_GET['diplome'];
	}	
	
if (isset ($_GET['composante']))
	{
	$composante=$_GET['composante'];
	}	
if (isset ($_GET['annee_scol']))
	{
	$annee_scol=$_GET['annee_scol'];
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
if (isset($_SESSION['dialogue']))
{
if ($_SESSION['dialogue']!=0)
{
//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_admin=1;
$afficher_mes_modules=1;
$afficher_mes_droits=1;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=1;
$afficher_giseh=1;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=0;
$nom_de_la_fenetre="Dialogue de gestion";
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



<form  enctype="multipart/form-data" action="dialogue_gestion.php" method="get">

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

<p style="text-align:center;">

<p>Composante : <select name="composante" >
<?php


$sql="SELECT *  FROM composantes WHERE deleted='0' and typeComposante='2' order by nom";
$req_composante=$dbh->prepare($sql);	
$req_composante->execute(array());
$res_composante=$req_composante->fetchAll();
foreach($res_composante as $composantes)
	{
	if (isset($composante))
		{
		if ($composantes['codeComposante']==$composante)
			{
			echo '<option value="'.$composantes['codeComposante'].'"  selected="selected">'.$composantes['nom'].'</option>';
			}
		else
			{
			echo '<option value="'.$composantes['codeComposante'].'">'.$composantes['nom'].'</option>';
			}
		}
	else
		{
		echo '<option value="'.$composantes['codeComposante'].'">'.$composantes['nom'].'</option>';
		}
	}


?>
</select>		
</p>		
	
	
	<p>Année scolaire : <select name="annee_scol" >
<?php

	for ($k=0;$k<=$nbdebdd-1;$k++)
	{
	
	$anneescolaire=$annee_scolaire[$k];	
	if (isset($annee_scol))
		{
		if ($annee_scol==$annee_scolaire[$k])
			{
			echo '<option value="'.$anneescolaire.'"  selected="selected">'.$anneescolaire.'</option>';
			}
		else
			{
			echo '<option value="'.$anneescolaire.'">'.$anneescolaire.'</option>';
			}
		}
	else
		{
		
				if ($k==$nbdebdd-1)
			{
			echo '<option value="'.$anneescolaire.'"  selected="selected">'.$anneescolaire.'</option>';
			}
		else
			{
			echo '<option value="'.$anneescolaire.'">'.$anneescolaire.'</option>';
			}
		
		
		
		}
	
	}



?>
</select>		
</p>
	






<input type="hidden" name="jour" id="jours2" value="<?php echo $jour_jour_j; ?>">
<input type=button value="Envoyer" onclick="form.action='dialogue_gestion.php';form.submit()"> 
<?php
/*
<input type=button value="Export vers Excel" onclick="form.action='dialogue_gestion_csv.php';form.submit()"> 
*/
?>


</form>
<br><br>
<?php


	


if (isset($composante))
{
if ($composante!=0)
	{
//choix de la bdd

$dbh=null;
	for ($k=0;$k<=$nbdebdd-1;$k++)
	{
	if ($annee_scol==$annee_scolaire[$k])
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
	
	}
	}
	
	
	
	
?>
	
	<table><tr>
	<th align="center" bgcolor="black"><font color="white" size="2">Grade</font></th>
	<th align="center" bgcolor="black"><font color="white" size="2">Noms des enseignants</font></th>
	<th align="center" bgcolor="black"><font color="white" size="2">Horaires statutaires</font></th>
	<th align="center" bgcolor="black"><font color="white" size="2">Nombre</font></th>
	<th align="center" bgcolor="black"><font color="white" size="2">Potentiel enseignement en heures</font></th>
	
	</tr>
	
<?php

$total_heure=0;
$total_minute=0;



//preparation des requetes
$sql="SELECT distinct grade FROM ressources_profs left join grades on ressources_profs.codeGrade=grades.codeGrade where ressources_profs.codeComposante=:composante and ressources_profs.deleted= '0' and grades.deleted= '0' order by grade";
$req_grade=$dbh->prepare($sql);

$sql="SELECT * FROM grades where grade=:grade and deleted= '0'";
$req_vol_stat=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_profs left join grades on ressources_profs.codeGrade=grades.codeGrade  where grades.grade=:grade and ressources_profs.codeComposante=:composante and ressources_profs.deleted= '0' and grades.deleted= '0' order by grade";
$req_nb_prof=$dbh->prepare($sql);




	$req_grade->execute(array(':composante'=>$composante));
	$res_grades=$req_grade->fetchAll();
	foreach($res_grades as $res_grade)
		{
		//echo $res_grade['grade']." ";
		
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
	//recherche vol horaire statutaire
	
	$req_vol_stat->execute(array(':grade'=>$res_grade['grade']));
	$res_vol_stats=$req_vol_stat->fetchAll();
	foreach($res_vol_stats as $res_vol_stat)
	{
	$heure_vol_stat=substr($res_vol_stat['heuresStatutaires'],0,-2);
	$minutes_vol_stat=substr($res_vol_stat['heuresStatutaires'],-2);
	}
	
	
	//Recherche du nombre de profs par grade et de leurs noms
	$nb_prof=0;
	$nom_prof="";
	$premier_prof=0;
			$req_nb_prof->execute(array(':grade'=>$res_grade['grade'],':composante'=>$composante));
	$res_nb_profs=$req_nb_prof->fetchAll();
	foreach($res_nb_profs as $res_nb_prof)
	{
	$nb_prof+=1;
	if ($premier_prof==0)
	{
	$nom_prof.=substr($res_nb_prof['prenom'],0,1).". ".$res_nb_prof['nom'];
	$premier_prof=1;
	}
	else
	{
	$nom_prof.=" / ".substr($res_nb_prof['prenom'],0,1).". ".$res_nb_prof['nom'];
	
	}
	
		
	}
	
	//calcul du potentiel enseignement
	$minute=$minutes_vol_stat*$nb_prof+$heure_vol_stat*60*$nb_prof;
	$total_minute+=$minute;
	$nb_heure=round($minute/60,2);
	
	if ($nb_heure==0)
	{
	$nb_heure="00";
	}
	
		?>
	<tr>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $res_grade['grade']; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heure_vol_stat."h".$minutes_vol_stat; ?></td>
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_prof; ?></td>		
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nb_heure; ?></td>	
	
	</tr>
<?php	
		}

	$nb_heure=round($total_minute/60,2);
	
	if ($nb_heure==0)
	{
	$nb_heure="00";
	}

?>
<tr>
<td colspan="4" align="right" bgcolor="green"><font color="white" size="2" ><b>POTENTIEL ENSEIGNEMENT TOTAL</b></font></td>
<td align="center" bgcolor="green"><font color="white" size="2"><b><?php echo $nb_heure; ?></b></font></td>	
</tr>
</table>


<?php
}
}













?>
<br>
	<table>
			
<?php
if (isset($composante))
{
if ($composante!=0)
	{
?>
<tr>
<th align="center" bgcolor="black"><font color="white" >Formation</font></th>
<th align="center" bgcolor="black"><font color="white" >CR</font></th>
<th align="center" bgcolor="black"><font color="white" >TD</font></th>
<th align="center" bgcolor="black"><font color="white" >TP</font></th>
<th align="center" bgcolor="black"><font color="white" >EqTD</font></th>
<th align="center" bgcolor="black"><font color="white" >FI</font></th>
<th align="center" bgcolor="black"><font color="white" >FA</font></th>
<th align="center" bgcolor="black"><font color="white" >FC</font></th>
</tr>

<?php
}
}
$variable_couleur=0;

//Sélection des diplomes appartenant à la composante

if (isset($composante))
{
//liste des diplomes
$sql="SELECT * FROM diplomes where codeComposante=:composante and deleted= '0' order by nom";
$req_diplomes=$dbh->prepare($sql);


$req_diplomes->execute(array(':composante'=>$composante));
$res_diplomes=$req_diplomes->fetchAll();
foreach($res_diplomes as $code_diplome)
{

//preparation des requetes

$sql="SELECT * FROM ressources_groupes where codeDiplome=:diplome and deleted= '0' ";
$req_groupes=$dbh->prepare($sql);




//liste des groupes
$code_du_diplome=$code_diplome['codeDiplome'];
$ressource_formation="(";
$req_groupes->execute(array(':diplome'=>$code_du_diplome));
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
	
		
	//$sql="SELECT * FROM ressources_profs  where  affectation='".$vacataire."' and deleted= '0' order by nom asc";
	$sql="SELECT * FROM ressources_profs  where  titulaire!='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);

	$titre_tableau="vacataires";
	}
//si permanents
else
	{

	

	//$sql="SELECT * FROM ressources_profs  where affectation!='".$vacataire."' and deleted= '0' order by nom asc";
	$sql="SELECT * FROM ressources_profs  where titulaire='1' and deleted= '0' order by nom asc";
	$req_profs=$dbh->prepare($sql);
	
	$titre_tableau="permanents";
	}









$sql="SELECT distinct (seances_profs.codeSeance) FROM seances_profs left join (seances) on (seances.codeSeance=seances_profs.codeSeance ) left join (seances_groupes) on (seances.codeSeance=seances_groupes.codeSeance )   where seances_profs.codeRessource=:codeRessource AND seances_profs.deleted='0' AND seances.deleted='0'  and ($ressource_formation)  order by seances.dateSeance,seances.heureSeance";
$req_seance_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances  left join enseignements on (enseignements.codeEnseignement=seances.codeEnseignement) where seances.codeSeance=:codeSeance AND seances.deleted='0' AND seances.deleted='0' and enseignements.deleted='0' ";
$req_seance_profs_fi_fa_fc=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes left join (seances_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) where seances_groupes.codeSeance=:codeSeance  and seances_groupes.deleted= '0'  and ressources_groupes.deleted= '0'";
$req_seance_groupes=$dbh->prepare($sql);	
	
	
$sql="SELECT * FROM seances where codeSeance=:codeSeance AND deleted= '0'";
$req_seance=$dbh->prepare($sql);	


$sql="SELECT * FROM enseignements where codeEnseignement=:codeEnseignement AND deleted= '0'"	;
$req_enseignement=$dbh->prepare($sql);	


$sql="SELECT * FROM seances_profs where seances_profs.deleted='0' and seances_profs.codeSeance=:codeSeance "	;
$req_prof=$dbh->prepare($sql);	


$sql="SELECT * FROM seances where seances.deleted='0' and seances.codeEnseignement=:codeEnseignement  "	;
$req_seance_enseignement=$dbh->prepare($sql);	

$sql="SELECT distinct codeDiplome FROM ressources_groupes left join (seances_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) where seances_groupes.codeSeance=:codeSeance  and seances_groupes.deleted= '0'  and ressources_groupes.deleted= '0'";
$req_nb_diplome_seance_groupes=$dbh->prepare($sql);	

$sql="SELECT * FROM enseignements left join (enseignements_profs) on (enseignements.codeEnseignement=enseignements_profs.codeEnseignement )  where enseignements_profs.codeRessource=:codeRessource AND enseignements_profs.deleted='0' AND enseignements.forfaitaire='1' AND enseignements.deleted='0' order by enseignements.nom"	;
$req_enseignement_forfait=$dbh->prepare($sql);	


$sql="SELECT * FROM ressources_groupes where codeGroupe=:codeGroupe AND deleted= '0'"	;
$req_groupe_forfait=$dbh->prepare($sql);	

$sql="SELECT * FROM enseignements_profs where enseignements_profs.deleted='0' and enseignements_profs.codeEnseignement=:codeEnseignement  "		;
$req_enseignement_prof_forfait=$dbh->prepare($sql);	
	
		
$sql="SELECT distinct ressources_groupes.codeDiplome FROM ressources_groupes left join (enseignements_groupes) on (enseignements_groupes.codeRessource=ressources_groupes.codeGroupe) where enseignements_groupes.codeEnseignement=:codeEnseignement  and enseignements_groupes.deleted= '0'  and ressources_groupes.deleted= '0'";
$req_nb_diplome_seance_groupes_forfait=$dbh->prepare($sql);		
	
	
	
//verification qu'il y a au moins une séance à afficher	
$sql="SELECT * FROM ressources_groupes join (seances_groupes) on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) join (seances) on (seances.codeSeance=seances_groupes.codeSeance ) where  ($ressource_formation)  and seances_groupes.deleted= '0' and  seances.deleted='0'  and ressources_groupes.deleted= '0'";
$req_seance_groupes_verif=$dbh->prepare($sql);
$req_seance_groupes_verif->execute(array());
$res_seance_groupes_verif=$req_seance_groupes_verif->fetchAll();	
$compteur_seance=count($res_seance_groupes_verif);

if (isset($formation))
{
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
}
else
{
$compteur_enseignement_forfait=0;
}
if (isset($formation))
{
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


	}
}	
	

	$total_final_heure_fi="";
	$total_final_heure_fa="";
	$total_final_heure_fc="";
		$total_final_min_fi="";
	$total_final_min_fa="";
	$total_final_min_fc="";
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
	$variable_prof="";
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
		
		
		
//public de la séance
$req_seance_profs_fi_fa_fc->execute(array(':codeSeance'=>$codeSeance));
$res_seance_profs_fi_fa_fc=$req_seance_profs_fi_fa_fc->fetchAll();	


foreach($res_seance_profs_fi_fa_fc as $fi_fa_fc)
	{	
	$public=$fi_fa_fc['typePublic'];
	}
	


		
	
//nb de diplome associés à la séance
$req_nb_diplome_seance_groupes->execute(array(':codeSeance'=>$codeSeance));
$res_nb_diplome_seance_groupes=$req_nb_diplome_seance_groupes->fetchAll();	

$nb_diplome=0;
foreach($res_nb_diplome_seance_groupes as $nb_diplomes)
	{	

	$nb_diplome+=1;
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



// récupération du code de l'activité

$CodeActivite=$enseignement['codeTypeActivite'];
// Teste si l'on autorise ou non l'affichage des heures non rémunérées (0CM 0TD 0TP malgré des heures de présence)
if ($AfficheLignesNonPayees==1 or $TauxTypeEns[$CodeActivite][0]+$TauxTypeEns[$CodeActivite][1]+$TauxTypeEns[$CodeActivite][2]!=0)
{
		if ( $forfait!=1 )
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
				
				
			}	
				
				
	
			
			
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
					
		
		

	
  
  // MODIF LAURENT : utilisation d'une grille de conversion CM TD TP de chaque enseignement.
//Ajout Laurent

      
// calcul de l'affichage de la durée Eq TD				
        if ($enseignement['volumeReparti']==1)
				{
				$dureeenmin=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs/$nb_diplome;
				}
				else
				{
				$dureeenmin=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_diplome;
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
				$dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_profs/$nb_diplome;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_profs/$nb_diplome;
				$dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_profs/$nb_diplome;
        }
				else
				{
				$dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_diplome;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_diplome;
				$dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_diplome;
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

		$dureeeqtd=$heureeqtd."h".$mineqtd;?>
		
		<?php
		
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
		

if ($public=="0")
	{
		$total_final_heure_fi+=$heureeqtd/2;
	$total_final_heure_fa+=$heureeqtd/2;

			$total_final_min_fi+=$mineqtd/2;
	$total_final_min_fa+=$mineqtd/2;

	}
elseif ($public=="1")
	{
		$total_final_heure_fi+=$heureeqtd;
		$total_final_min_fi+=$mineqtd;
	}
elseif ($public=="2")
	{
	$total_final_heure_fa+=$heureeqtd;
	$total_final_min_fa+=$mineqtd;

	}
elseif ($public=="3")
	{
	$total_final_heure_fc+=$heureeqtd;
	$total_final_min_fc+=$mineqtd;
	}				
		
		
		
		
		
		
		
	
// FIN Ajout Laurent  
			
		
	
		}

	
		
		
	//forfait avec séances
		if ( $forfait==1)
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
				
				
			}	
				
		
	
			
			
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
					
		
	

		//comptage du nb de sénaces associé à l'enseignement
			$nb_seances=0;
			
			
	$enseignement_codeenseignement=$enseignement['codeEnseignement'];
	$req_seance_enseignement->execute(array(':codeEnseignement'=>$enseignement_codeenseignement));
$res_seance_enseignement=$req_seance_enseignement->fetchAll();
foreach($res_seance_enseignement as $nb_seances_forfait)
	{	
	$nb_seances=$nb_seances+1;
	}			
		
		


// calcul de la durée CM, TD et TP en fonction du tableau d'équivalence 

			if ($enseignement['volumeReparti']==1)
				{
				$dureeenminCM=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*$TauxTypeEns[$CodeActivite][0])/$nb_profs)/$nb_seances/$nb_diplome;
				$dureeenminTD=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1])/$nb_profs)/$nb_seances/$nb_diplome;
        $dureeenminTP=(($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_profs)/$nb_seances/$nb_diplome;
        }
			else
				{
				$dureeenminCM=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*$TauxTypeEns[$CodeActivite][0])/$nb_seances/$nb_diplome;
			  $dureeenminTD=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1])/$nb_seances/$nb_diplome;
			  $dureeenminTP=($heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_seances/$nb_diplome;
			
        
        
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
                     )/$nb_profs)/$nb_seances/$nb_diplome;
				}
				else
				{
				$dureeenmin=($heureduree_forfait*90*$TauxTypeEns[$CodeActivite][0]+$minduree_forfait*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][1]+$minduree_forfait*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree_forfait*60*$TauxTypeEns[$CodeActivite][2]+$minduree_forfait*$TauxTypeEns[$CodeActivite][2])/$nb_seances/$nb_diplome;
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
    
    		
			$dureeeqtd=$heureeqtd."h".$mineqtd;?>
			
			<?php
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
	
if ($public=="0")
	{
		$total_final_heure_fi+=$heureeqtd/2;
	$total_final_heure_fa+=$heureeqtd/2;

			$total_final_min_fi+=$mineqtd/2;
	$total_final_min_fa+=$mineqtd/2;

	}
elseif ($public=="1")
	{
		$total_final_heure_fi+=$heureeqtd;
		$total_final_min_fi+=$mineqtd;
	}
elseif ($public=="2")
	{
	$total_final_heure_fa+=$heureeqtd;
	$total_final_min_fa+=$mineqtd;

	}
elseif ($public=="3")
	{
	$total_final_heure_fc+=$heureeqtd;
	$total_final_min_fc+=$mineqtd;
	}	


	
		
		}	
	
	// fin de la zone if concernant	l'affichage ou non des séance non rémunérées	
		}		
  
  	
		

	}
	
	
	

	//forfait sans séance placées
	
	//liste des groupes
$ressource_formation2="(";




$req_groupes->execute(array(':diplome'=>$code_du_diplome));
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
$public=$enseignements_au_forfait['typePublic'];
	
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
	
$req_seance_enseignement->execute(array(':codeEnseignement'=>$codeenseignement));
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
	
	
			//comptage du nb de diplomess associés à l'enseignement forfaitaire
		$nb_diplome_forfait=0;
		
		
	
$req_nb_diplome_seance_groupes_forfait->execute(array(':codeEnseignement'=>$codeenseignement));
$res_nb_diplome_seance_groupes_forfait=$req_nb_diplome_seance_groupes_forfait	->fetchAll();
foreach($res_nb_diplome_seance_groupes_forfait as $enseignement_nb_diplome_forfait)
	{		

		$nb_diplome_forfait=$nb_diplome_forfait+1;
			}	
	
	
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
			
				
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
		{	  $dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_profs_forfait/$nb_diplome_forfait;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_profs_forfait/$nb_diplome_forfait;
        $dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_profs_forfait/$nb_diplome_forfait;
     }
else   
    {	  $dureeenminCM=($heureduree*60*$TauxTypeEns[$CodeActivite][0]+$minduree*$TauxTypeEns[$CodeActivite][0])/$nb_diplome_forfait;
				$dureeenminTD=($heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1])/$nb_diplome_forfait;
        $dureeenminTP=($heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_diplome_forfait;
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
                     )/$nb_profs_forfait)/$nb_diplome_forfait;
				}
				else
				{
				$dureeenmin=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2])/$nb_diplome_forfait;
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
  		
		
		if ($public=="0")
	{
		$total_final_heure_fi+=$heureeqtd/2;
	$total_final_heure_fa+=$heureeqtd/2;

			$total_final_min_fi+=$mineqtd/2;
	$total_final_min_fa+=$mineqtd/2;

	}
elseif ($public=="1")
	{
		$total_final_heure_fi+=$heureeqtd;
		$total_final_min_fi+=$mineqtd;
	}
elseif ($public=="2")
	{
	$total_final_heure_fa+=$heureeqtd;
	$total_final_min_fa+=$mineqtd;

	}
elseif ($public=="3")
	{
	$total_final_heure_fc+=$heureeqtd;
	$total_final_min_fc+=$mineqtd;
	}		
		
    
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

		
		
		
?>

			<?php	
	
	$affichage_eqtd=0;
	}


}
//bilan total de toute les heures de la formation
//mise en forme de l'heure
$total_final_heure_eqtd_en_min=$total_final_heure_eqtd*60+$total_final_min_eqtd;
		$total_final_heure_eqtd=round($total_final_heure_eqtd_en_min/60,2);
		
			
			
$total_final_heure_fi_en_min=$total_final_heure_fi*60+$total_final_min_fi;
		$total_final_heure_fi=round($total_final_heure_fi_en_min/60,2);
				
			
$total_final_heure_fa_en_min=$total_final_heure_fa*60+$total_final_min_fa;
		$total_final_heure_fa=round($total_final_heure_fa_en_min/60,2);
		
						
	$total_final_heure_fc_en_min=$total_final_heure_fc*60+$total_final_min_fc;
		$total_final_heure_fc=round($total_final_heure_fc_en_min/60,2);
					
			
			
		$total_final_heure_cm_en_min=$total_final_heure_cm*60+$total_final_min_cm;
		$total_final_heure_cm=round($total_final_heure_cm_en_min/60,2);
		

		$total_final_heure_td_en_min=$total_final_heure_td*60+$total_final_min_td;
		$total_final_heure_td=round($total_final_heure_td_en_min/60,2);
		
			
		$total_final_heure_tp_en_min=$total_final_heure_tp*60+$total_final_min_tp;
		$total_final_heure_tp=round($total_final_heure_tp_en_min/60,2);
		
	
		$total_final_heure_forfait_en_min=$total_final_heure_forfait*60+$total_final_min_forfait;
		$total_final_heure_forfait=round($total_final_heure_forfait_en_min/60,2);
		
			
			
			

				
				
				
				
		if ($variable_couleur==1)
		{
			
				$bgcolor="#C0CFF1";
			
		

		}
		else
		{
		
			
			
			$bgcolor="white";
		
		}			
			
			
?>
<tr>

	
		<td  align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $code_diplome['nom']." (".$titre_tableau.")"; ?></font></td>

	<?php		
if ($total_final_heure_cm!="" or $total_final_min_cm!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_cm; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}
	if ($total_final_heure_td!="" or $total_final_min_td!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_td; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}
	if ($total_final_heure_tp!="" or $total_final_min_tp!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_tp; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}

	
		if ($total_final_heure_eqtd!="")
{?>	
			
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_eqtd; ?></font></td>
			
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}			
			
			
			
			
	if ($total_final_heure_fi!="" or $total_final_min_fi!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_fi; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}		
			
		if ($total_final_heure_fa!="" or $total_final_min_fa!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_fa; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}	

	if ($total_final_heure_fc!="" or $total_final_min_fc!="")
{?>

			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><font color="black" ><?php echo $total_final_heure_fc; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"></td>
		<?php
	}	
	
			
			?>
			</tr>
			<?php

}
if ($variable_couleur==1)
				{
				$variable_couleur=0;
				}
				else
				{
				$variable_couleur=1;
				}
}
}	
?>
</table>

<?php

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
