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

	
//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_admin=1;
$afficher_mes_modules=1;
$afficher_mes_droits=0;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=1;
$afficher_giseh=1;
$afficher_dialogue=1;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=1;
$nom_de_la_fenetre="Mes droits";
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
if (isset($_SESSION['mes_droits']))
{

if ($_SESSION['mes_droits']=='1')
{

	

?>	
	



















	 
	 
	 
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Mes droits</span><br></p>	



	
	
	
	
	<table><tr>

<th align="center" bgcolor="black" ><font color="white" >Droits</font></th>
<th align="center" bgcolor="black" ><font color="white" >Activation</font></th>

</tr>

<?php


	




	//requete pour avoir la liste des droits de l'utilisateur

$sql="SELECT * FROM login_prof WHERE codeProf='".$codeProf."'";

$req_liste_droit=$dbh->query($sql);
$res_liste_droit=$req_liste_droit->fetchAll();	

foreach ($res_liste_droit as $res_liste_droits)		
{
$reservation=$res_liste_droits['reservation'];

$admin=$res_liste_droits['admin'];
$module=$res_liste_droits['module'];
$bilan_heure=$res_liste_droits['bilan_heure'];
$configuration=$res_liste_droits['configuration'];
$rss=$res_liste_droits['rss'];
$bilan_heure_global=$res_liste_droits['bilan_heure_global'];
$bilan_formation=$res_liste_droits['bilan_formation'];
$pdf=$res_liste_droits['pdf'];
$seance_clicable=$res_liste_droits['seance_clicable'];
$giseh=$res_liste_droits['giseh'];
$dialogue=$res_liste_droits['dialogue'];
$salle=$res_liste_droits['salle'];
}	


?>
<tr>
<td  align="center" bgcolor="white">Administrateur</td>
<td align="center" bgcolor="white"><?php if ($admin=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="silver">Dialogue de gestion</td>
<td align="center" bgcolor="silver"><?php if ($dialogue=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="white">Export vers Giseh (Université Paris Ouest uniquement)</td>
<td align="center" bgcolor="white"><?php if ($giseh=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="silver">Export PDF</td>
<td align="center" bgcolor="silver"><?php if ($pdf=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; }  ?></td>
</tr>

<tr>
<td  align="center" bgcolor="white">Faire le bilan de l'occupation des salles</td>
<td align="center" bgcolor="white"><?php if ($salle=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>

<tr>
<td  align="center" bgcolor="silver">Faire le bilan de ses heures</td>
<td align="center" bgcolor="silver"><?php if ($bilan_heure=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="white">Faire le bilan des heures de tout le monde</td>
<td align="center" bgcolor="white"><?php if ($bilan_heure_global=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="silver">Faire le bilan des heures des formations</td>
<td align="center" bgcolor="silver"><?php if ($bilan_formation=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>


<tr>
<td  align="center" bgcolor="white">Flux RSS</td>
<td align="center" bgcolor="white"><?php if ($rss=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="silver">Modifier sa configuration</td>
<td align="center" bgcolor="silver"><?php if ($configuration=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>

<tr>
<td  align="center" bgcolor="white">Se placer des réservations</td>
<td align="center" bgcolor="white"><?php if ($reservation=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>
<tr>
<td  align="center" bgcolor="silver">Séances clicables</td>
<td align="center" bgcolor="silver"><?php if ($seance_clicable=='1') {echo '<span style="font-size:18px;color:green; font-weight:bold;">&#10003;</span>';} else { echo '<span style="font-size:18px;color:red; font-weight:bold;">&#10006;</span>'; } ?></td>
</tr>



</table><br>

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