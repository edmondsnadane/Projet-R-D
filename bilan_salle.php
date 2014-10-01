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
$materiels_multi=array(); 	
if(isset($_GET['materiels_multi']))
{
 $materiels_multi=$_GET['materiels_multi'];
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
<link rel="stylesheet" media="all" type="text/css" href="menu/hover_drop_2.css" />

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
<link rel="stylesheet" href="css/bilan_salle.css" type="text/css" >

</head>

<body  style="margin: 0px;">


<?php

if (isset($_SESSION['logged_prof_perso']))
{
if ($_SESSION['logged_prof_perso']!='')
{
//recuperation de la date du jour pour l'afficher au dessus du tableau
$jour=date('d');
$mois=date('m');
$annee=date('y');
$heure=date('H');
$minute=date('i');
	
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
$afficher_occupation_des_salles=0;
$afficher_dialogue=1;
$nom_de_la_fenetre="Occupation des salles";
include('menu_outil.php');



?>





<div style="text-align:center;width:100%;">










<form name="form2" id="form2" action="index.php" method="get" >


	
	<input type="hidden" name="lar" id="screen_w_retour" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_retour" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_retour" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_retour" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_retour" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_ma_retour" value="<?php echo $selec_materiel; ?>">
		<input type="hidden" name="current_week" id="current_w_retour" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_retour" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_retour" value="<?php echo $horizon; ?>">
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
	<input type="hidden" name="jour" id="jours2_retour" value="<?php echo $jour_jour_j; ?>">
	
	 </form><br><br>
	 
	 
	 
<?php
if (isset($_SESSION['salle']))
{

if ($_SESSION['salle']=='1')
{

	

?>	
	 



<form  name="form" enctype="multipart/form-data" action="bilan_salle.php" method="get" >

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


<p>Année universitaire : <select name="annee_scolaire" onchange="form.action='bilan_salle.php'; document.form.submit();" >
<?php
	for ($k=0;$k<=$nbdebdd-1;$k++)

	
{
if ($annee_scolaire_choisie==$k)
{
echo '<option value="'.$k.'"  selected="selected">'.$annee_scolaire[$k].'</option>';
}
else
{
echo '<option value="'.$k.'"  >'.$annee_scolaire[$k].'</option>';
}



}


?>
</select>		
</p>				


<br>

	<input type="hidden" name="jour" id="jours2" value="<?php echo $jour_jour_j; ?>">

<input type=button value="Export vers Excel" onclick="form.action='bilan_salle_csv.php';form.submit()"> 
	</form>











<?php
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
?>









	 
	 
	 
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Bilan de l'occupation des salles</span><br>


<span style="font-size:15px; ">G&eacute;n&eacute;r&eacute; le <?php echo $jour;?>/<?php echo $mois; ?>/<?php echo $annee; ?> à <?php echo $heure; ?>h<?php echo $minute; ?></span><br></p>	



	
	
	
	
	<table><tr>

<th align="center" bgcolor="black" ><font color="white" >Salle</font></th>
<th align="center" bgcolor="black" ><font color="white" >Zone</font></th>
<th align="center" bgcolor="black" ><font color="white" >Séance (en heure)</font></th>
<th align="center" bgcolor="black" ><font color="white" >Réservation (en heure)</font></th>
<th align="center" bgcolor="black" ><font color="white" >Total (en heure)</font></th>
<th align="center" bgcolor="black" ><font color="white" >Taux d'occupation</font></th>
</tr>

<?php


	



//initialisation des variables

$bgcolor="silver";
$variable_couleur=0;
$affichage_eqtd=0;
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
?>
<tr>

	<td colspan="2" align="center" bgcolor="green">CUMUL DES HEURES DE LA ZONE CI-DESSUS</td>
			<td align="center" bgcolor="green"><?php echo $total_seance_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo $total_réservation_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo $total_seance_par_zone+$total_réservation_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo round(($total_seance_par_zone+$total_réservation_par_zone)/(1120*($compteur_de_salle_zone-1))*100,2); ?>%</td>
				
	</tr>
<?php	//remise à zéro du compteur
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
	if ($i%2 == 1)
	{	
	
	
	?>
	
		<tr>
		<td align="center" bgcolor="gray"><?php echo $res_liste_salles['salle']; ?></td>
		<td align="center" bgcolor="gray"><?php echo $res_liste_salles['nom_zone']; ?></td>
		<td align="center" bgcolor="gray"><?php echo round($res_salles['heure'],2); ?></td>
				<td align="center" bgcolor="gray"><?php echo round($duree_reservation,2); ?></td>
						<td align="center" bgcolor="gray"><?php echo round($res_salles['heure'],2)+round($duree_reservation,2); ?></td>
						<td align="center" bgcolor="gray"><?php echo round(((round($res_salles['heure'],2)+round($duree_reservation,2))/1120)*100,2); ?>%</td>
		</tr>
	<?php
	$total_seance+=round($res_salles['heure'],2);
	$total_réservation+=round($duree_reservation,2);
	$total_seance_par_zone+=round($res_salles['heure'],2);
$total_réservation_par_zone+=round($duree_reservation,2);
	}
	else
	{
		?>
	
		<tr>
		<td align="center" bgcolor="white"><?php echo $res_liste_salles['salle']; ?></td>
		<td align="center" bgcolor="white"><?php echo $res_liste_salles['nom_zone']; ?></td>
		<td align="center" bgcolor="white"><?php echo round($res_salles['heure'],2); ?></td>
			<td align="center" bgcolor="white"><?php echo round($duree_reservation,2); ?></td>
				<td align="center" bgcolor="white"><?php echo round($res_salles['heure'],2)+round($duree_reservation,2); ?></td>
				<td align="center" bgcolor="white"><?php echo round(((round($res_salles['heure'],2)+round($duree_reservation,2))/1120)*100,2); ?>%</td>
				
		</tr>
	<?php
		$total_seance+=round($res_salles['heure'],2);
	$total_réservation+=round($duree_reservation,2);
		$total_seance_par_zone+=round($res_salles['heure'],2);
$total_réservation_par_zone+=round($duree_reservation,2);
	}

		//ligne bilan de la dernière zone
		if ($compteur_de_salle==$nb_de_salle)
	{
?>
<tr>

	<td colspan="2" align="center" bgcolor="green">CUMUL DES HEURES DE LA ZONE CI-DESSUS</td>
			<td align="center" bgcolor="green"><?php echo $total_seance_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo $total_réservation_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo $total_seance_par_zone+$total_réservation_par_zone; ?></td>
				<td align="center" bgcolor="green"><?php echo round(($total_seance_par_zone+$total_réservation_par_zone)/(1120*($compteur_de_salle_zone))*100,2); ?>%</td>
	</tr>
<?php	
	}
	
	
	
	}
	unset ($req_salle);
	$memoire_zone=$res_liste_salles['nom_zone'];
}	
	
//derniere ligne du tableau
?>
<tr>

	<td colspan="2" align="center" bgcolor="#6699FF">CUMUL TOAL DES HEURES</td>
			<td align="center" bgcolor="#6699FF"><?php echo $total_seance; ?></td>
				<td align="center" bgcolor="#6699FF"><?php echo $total_réservation; ?></td>
				<td align="center" bgcolor="#6699FF"><?php echo $total_seance+$total_réservation; ?></td>
				<td align="center" bgcolor="#6699FF"><?php echo round(($total_seance+$total_réservation)/(1120*$nb_de_salle)*100,2); ?>%</td>
	</tr>
</table><br>
<img src='graph_salle.php?base=<?php echo $annee_scolaire_choisie; ?>' /><br><br>
</div>
<?php
}
}
}
}
else
{
echo 'Vous avez été déconnecté. Cliquez <a style="color:#0000EE" href="index.php">ICI </a> pour retourner à la page principale ';
}
?>

</body>
</html>