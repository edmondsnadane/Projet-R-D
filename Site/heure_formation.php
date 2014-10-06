<?php
session_start();

include("config.php");
error_reporting(E_ALL);

	
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
if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone")  
|| strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) { 
 echo '<meta name="viewport" content="initial-scale=1.0">';
} 
?>


<link rel="stylesheet" href="css/heure_formation.css" type="text/css" >



</head>

<body  style="margin: 0px;">
<?php
if (isset($_SESSION['bilan_formation']))
{
if ($_SESSION['bilan_formation']!=0)
{

//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_admin=1;
$afficher_mes_modules=1;
$afficher_mes_droits=1;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=0;
$afficher_giseh=1;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=1;
$nom_de_la_fenetre="Bilan par formation";
include('menu_outil.php');


	?>
	
	
	
	
	
	
	
<div style="text-align:center;width:100%;">


<form name="form2" id="form2" action="index.php" method="get" >


	
	<input type="hidden" name="lar" id="screen_wbis" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hibis" value="<?php echo $hau; ?>">
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

// Selection des différents niveaux.... peut être prendre les diplomes... ou les composantes

//$sql="SELECT distinct (departement)  FROM ressources_groupes WHERE deleted='0' order by departement";
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

<br>

	<input type="hidden" name="jour" id="jours2" value="<?php echo $jour_jour_j; ?>">
<input type=button value="Envoyer" onclick="form.action='heure_formation.php';form.submit()"> 
<input type=button value="Export vers Excel" onclick="form.action='heure_formation_csv.php';form.submit()"> 
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


?>
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Heures des profs en <?php echo $formation_nom." (".$titre_tableau.")"; ?></span><br>
<span style="font-size:20px; font-weight:bold;">P&eacute;riode du <?php echo $jour_debut;?>/<?php echo $mois_debut; ?>/<?php echo $annee_debut; ?> au  <?php echo $jour_fin;?>/<?php echo $mois_fin; ?>/<?php echo $annee_fin; ?></span><br>
<span style="font-size:20px; font-weight:bold;">G&eacute;n&eacute;r&eacute; le <?php echo date('d');?>/<?php echo date('m'); ?>/<?php echo date('y'); ?></span><br></p>	

	
	
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Ann&eacute;e scolaire <?php echo $anneescolaire;?></span><br></p>
	<table><tr>
			

<th align="center" bgcolor="black"><font color="white" >Nom</font></th>
<th align="center" bgcolor="black"><font color="white" >Pr&eacute;nom</font></th>
<th align="center" bgcolor="black"><font color="white" >Formation</font></th>
<th align="center" bgcolor="black"><font color="white" >Apog&eacute;e</font></th>
<th align="center" bgcolor="black"><font color="white" >Mati&egrave;re</font></th>
<th align="center" bgcolor="black"><font color="white" >Date</font></th>
<th align="center" bgcolor="black"><font color="white" >Heure d&eacute;but</font></th>
<th align="center" bgcolor="black"><font color="white" >Heure fin</font></th>
<th align="center" bgcolor="black"><font color="white" >Horaire r&eacute;parti / nb profs</font></th>
<th align="center" bgcolor="black"><font color="white" >Forfait</font></th>
<th align="center" bgcolor="black"><font color="white" >CR</font></th>
<th align="center" bgcolor="black"><font color="white" >TD</font></th>
<th align="center" bgcolor="black"><font color="white" >TP</font></th>
<th align="center" bgcolor="black"><font color="white" >EqTD</font></th>
</tr>

<?php	
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
$variable_couleur=0;
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
		if ($date_seance<=$annee_fin.$mois_fin.$jour_fin and $date_seance>=$annee_debut.$mois_debut.$jour_debut  and $forfait!=1 )
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
				if ($variable_couleur==1)
				{
				$variable_couleur=0;
				}
				else
				{
				$variable_couleur=1;
				}
				
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
					
		
		?>
		<tr>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['nom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($nom_seance_groupe); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignement['identifiant']; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $jour."-".$mois."-".$annee; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heuredebut."h".$mindebut; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heurefin."h".$minfin; ?></td>

		
		<?php
// Indique dans la case du tableau si le volume de la séance est divisé par le nb de prof affectés à la séance		
		if ($enseignement['volumeReparti']==1)
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">OUI / <?php echo $nb_profs; ?></td>
		<?php
		}
		else
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">NON</td>
		<?php
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

		$dureeeqtd=$heureeqtd."h".$mineqtd;?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">NON</td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo $heuredureeCM."h".$mindureeCM;} ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTD!="00" or $mindureeTD!="00") {echo $heuredureeTD."h".$mindureeTD;} ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTP!="00" or $mindureeTP!="00") {echo $heuredureeTP."h".$mindureeTP;} ?></td>
		
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $dureeeqtd; ?></td>
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
	
// FIN Ajout Laurent  
			
		
		?>		
		</tr>
		<?php
		}

	
		
		
	//forfait avec séances
		if ($date_seance<=$annee_fin.$mois_fin.$jour_fin and $date_seance>=$annee_debut.$mois_debut.$jour_debut and $forfait==1)
			{
			
			$affichage_eqtd=1; //initialisation variable pour l affichage du cumul des heures
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
				if ($variable_couleur==1)
				{
				$variable_couleur=0;
				}
				else
				{
				$variable_couleur=1;
				}
				
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
					
		
		?>
		<tr>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['nom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($nom_seance_groupe); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignement['identifiant']; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $jour."-".$mois."-".$annee; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heuredebut."h".$mindebut; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heurefin."h".$minfin; ?></td>
		
		<?php
		if ($enseignement['volumeReparti']==1)
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">OUI / <?php echo $nb_profs; ?></td>
		<?php
		}
		else
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">NON</td>
		<?php
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
    
    		
			$dureeeqtd=$heureeqtd."h".$mineqtd;?>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo "OUI"; ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo $heuredureeCM."h".$mindureeCM;} ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTD!="00" or $mindureeTD!="00") {echo $heuredureeTD."h".$mindureeTD;} ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTP!="00" or $mindureeTP!="00") {echo $heuredureeTP."h".$mindureeTP;} ?></td>
			
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $dureeeqtd; ?></td>
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
		
		?>		
		</tr>
		<?php
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
			if ($variable_prof!=$prof['nom'].$prof['prenom']) //test si on a change de prof pour la gestion des couleurs
			{
				$variable_prof=$prof['nom'].$prof['prenom'];
				if ($variable_couleur==1)
				{
				$variable_couleur=0;
				}
				else
				{
				$variable_couleur=1;
				}
				
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
					
		
		?>
		<tr>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['nom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($prof['prenom']); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($nom_forfait_groupe); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">-</td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">-</td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">-</td>
				<?php
		if ($enseignements_au_forfait['volumeReparti']==1)
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">OUI / <?php echo $nb_profs_forfait; ?>  </td>
		<?php
		}
		else
		{?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">NON</td>
		<?php
		}
		?>
				
		
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo "OUI"; ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeCM!="00" or $mindureeCM!="00") {echo $heuredureeCM."h".$mindureeCM;} ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTD!="00" or $mindureeTD!="00") {echo $heuredureeTD."h".$mindureeTD;} ?></td>
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php if($heuredureeTP!="00" or $mindureeTP!="00") {echo $heuredureeTP."h".$mindureeTP;} ?></td>
			
			<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $dureeeqtd ?></td>
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
  		
		?>		
		</tr>
		<?php
		
    
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
<tr>
		<td align="center" bgcolor="green"><font color="white" ><?php echo stripslashes($prof['nom']); ?></font></td>
		<td align="center" bgcolor="green"><font color="white" ><?php echo stripslashes($prof['prenom']); ?></font></td>
		<td colspan="8" align="center" bgcolor="green"><font color="white" >CUMUL DES HEURES</font></td>
		<?php
		
		
if ($total_heure_cr!="" and $total_min_cr!="")
{?>

			<td align="center" bgcolor="green"><font color="white" ><?php echo $total_heure_cr."h".$total_min_cr; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="green"></td>
		<?php
	}
	if ($total_heure_td!="" and $total_min_td!="")
{?>

			<td align="center" bgcolor="green"><font color="white" ><?php echo $total_heure_td."h".$total_min_td; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="green"></td>
		<?php
	}
	if ($total_heure_tp!="" and $total_min_tp!="")
{?>

			<td align="center" bgcolor="green"><font color="white" ><?php echo $total_heure_tp."h".$total_min_tp; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="green"></td>
		<?php
	}
?>
	
		
			
			<td align="center" bgcolor="green"><font color="white" ><?php echo $total_heure_eqtd."h".$total_min_eqtd; ?></font></td>
			</tr>
			<?php	
	
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
?>
<tr>

	
		<td colspan="10" align="center" bgcolor="#C0CFF1"><font color="black" >CUMUL TOTAL DES HEURES</font></td>

	<?php		
if ($total_final_heure_cm!="" or $total_final_min_cm!="")
{?>

			<td align="center" bgcolor="#C0CFF1"><font color="black" ><?php echo $total_final_heure_cm."h".$total_final_min_cm; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="#C0CFF1"></td>
		<?php
	}
	if ($total_final_heure_td!="" or $total_final_min_td!="")
{?>

			<td align="center" bgcolor="#C0CFF1"><font color="black" ><?php echo $total_final_heure_td."h".$total_final_min_td; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="#C0CFF1"></td>
		<?php
	}
	if ($total_final_heure_tp!="" or $total_final_min_tp!="")
{?>

			<td align="center" bgcolor="#C0CFF1"><font color="black" ><?php echo $total_final_heure_tp."h".$total_final_min_tp; ?></font></td>
<?php
}
else
	{?>
		<td align="center" bgcolor="#C0CFF1"></td>
		<?php
	}
?>
	
		
			
			<td align="center" bgcolor="#C0CFF1"><font color="black" ><?php echo $total_final_heure_eqtd."h".$total_final_min_eqtd; ?></font></td>
			</tr>
			<?php

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
