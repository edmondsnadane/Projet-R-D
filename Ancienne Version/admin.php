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
$afficher_admin=0;
$afficher_mes_modules=1;
$afficher_mes_droits=1;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=1;
$afficher_giseh=1;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=1;
$nom_de_la_fenetre="Gestion des droits";
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
if (isset($_SESSION['admin']))
{

if ($_SESSION['admin']=='1')
{


if (isset($_POST['update']))
{
 if ($_POST['update']=='TRUE') {

//liste de tous les comptes
 $sql="SELECT * FROM login_prof   ";

$req_liste_prof=$dbh->query($sql);
$res_liste_prof=$req_liste_prof->fetchAll();	
$i=0;
foreach ($res_liste_prof as $res_liste_profs)		
{
$codeProf=$res_liste_profs['codeProf'];
 	if (isset($_POST['admin'][$codeProf]))
	{
	if ($_POST['admin'][$codeProf]==1)
	{
	$admin=1;
	}
	else
	{
	$admin=0;
	}
	}
	else
	{
	$admin=0;
	}

	if (isset($_POST['reservation'][$codeProf]))
	{
	if ($_POST['reservation'][$codeProf]==1)
	{
	$reservation=1;
	}
	else
	{
	$reservation=0;
	}	
	}
	else
	{
	$reservation=0;
	}

	if (isset($_POST['mes_droits'][$codeProf]))
	{
		if ($_POST['mes_droits'][$codeProf]==1)
	{
	$mes_droits=1;
	}
	else
	{
	$mes_droits=0;
	}	
		}
	else
	{
	$mes_droits=0;
	}

		if (isset($_POST['module'][$codeProf]))
	{
	
		if ($_POST['module'][$codeProf]==1)
	{
	$module=1;
	}
	else
	{
	$module=0;
	}	
	}
	else
	{
	$module=0;
	}	

	
		if (isset($_POST['bilan_heure'][$codeProf]))
	{
		if ($_POST['bilan_heure'][$codeProf]==1)
	{
	$bilan_heure=1;
	}
	else
	{
	$bilan_heure=0;
	}	
	}
	else
	{
	$bilan_heure=0;
	}		

		if (isset($_POST['configuration'][$codeProf]))
	{	
		if ($_POST['configuration'][$codeProf]==1)
	{
	$configuration=1;
	}
	else
	{
	$configuration=0;
	}	
	}
	else
	{
	$configuration=0;
	}

		if (isset($_POST['rss'][$codeProf]))
	{		
		if ($_POST['rss'][$codeProf]==1)
	{
	$rss=1;
	}
	else
	{
	$rss=0;
	}	
	}
	else
	{
	$rss=0;
	}


			if (isset($_POST['bilan_heure_global'][$codeProf]))
	{	
		if ($_POST['bilan_heure_global'][$codeProf]==1)
	{
	$bilan_heure_global=1;
	}
	else
	{
	$bilan_heure_global=0;
	}	
		}
	else
	{
	$bilan_heure_global=0;
	}
	
				if (isset($_POST['bilan_formation'][$codeProf]))
	{	
		if ($_POST['bilan_formation'][$codeProf]==1)
	{
	$bilan_formation=1;
	}
	else
	{
	$bilan_formation=0;
	}
	}
	else
	{
	$bilan_formation=0;
	}	

	
				if (isset($_POST['pdf'][$codeProf]))
	{		
		if ($_POST['pdf'][$codeProf]==1)
	{
	$pdf=1;
	}
	else
	{
	$pdf=0;
	}	
		}
	else
	{
	$pdf=0;
	}	
	
		if (isset($_POST['seance_clicable'][$codeProf]))
	{	
		if ($_POST['seance_clicable'][$codeProf]==1)
	{
	$seance_clicable=1;
	}
	else
	{
	$seance_clicable=0;
	}
	}
	else
	{
	$seance_clicable=0;
	}	
	
			if (isset($_POST['giseh'][$codeProf]))
	{	
			if ($_POST['giseh'][$codeProf]==1)
	{
	$giseh=1;
	}
	else
	{
	$giseh=0;
	}	
		}
	else
	{
	$giseh=0;
	}	
	
	
			if (isset($_POST['salle'][$codeProf]))
	{	
			if ($_POST['salle'][$codeProf]==1)
	{
	$salle=1;
	}
	else
	{
	$salle=0;
	}	
	}
	else
	{
	$salle=0;
	}		
	
				if (isset($_POST['dialogue'][$codeProf]))
	{	
			if ($_POST['dialogue'][$codeProf]==1)
	{
	$dialogue=1;
	}
	else
	{
	$dialogue=0;
	}	
		}
	else
	{
	$dialogue=0;
	}	
	
	
	
	
	
	
	
	
	

	
	if ($res_liste_profs['admin']!=$admin 
	|| $res_liste_profs['reservation']!=$reservation 
	|| $res_liste_profs['mes_droits']!=$mes_droits  
	|| $res_liste_profs['module']!=$module 
|| $res_liste_profs['bilan_heure']!=$bilan_heure 
|| $res_liste_profs['configuration']!=$configuration 
|| $res_liste_profs['rss']!=$rss 
|| $res_liste_profs['bilan_heure_global']!=$bilan_heure_global 
|| $res_liste_profs['bilan_formation']!=$bilan_formation 
|| $res_liste_profs['pdf']!=$pdf
|| $res_liste_profs['seance_clicable']!=$seance_clicable
|| $res_liste_profs['giseh']!=$giseh
|| $res_liste_profs['salle']!=$salle
|| $res_liste_profs['dialogue']!=$dialogue
	)
	{

$sql="UPDATE login_prof SET admin=".$admin." ,
reservation=".$reservation.",
mes_droits=".$mes_droits.",
module=".$module.",
bilan_heure=".$bilan_heure.",
configuration=".$configuration.",
rss=".$rss.",
bilan_heure_global=".$bilan_heure_global.",
bilan_formation=".$bilan_formation.",
pdf=".$pdf.",
seance_clicable=".$seance_clicable.",
giseh=".$giseh.",
dialogue=".$dialogue.",
salle=".$salle."



  WHERE codeProf=:codeProf";



						$data=array("codeProf"=>$codeProf);

						$stmt=$dbh->prepare($sql);

						$stmt->execute($data);

						unset($stmt);	
	
	}
}	

 	

 }
}


















	

?>	
	



















	 
	 
	 
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Gestion des droits</span><br></p>	
<?php
$ressource="";
for ($i=0; $i<count($groupes_multi); $i++)
		{ 
		$ressource.= '&groupes_multi['.$i.']='.$groupes_multi[$i]; 
		}
		 for ($i=0; $i<count($salles_multi); $i++)
		{ 
		$ressource.= '&salles_multi['.$i.']='.$salles_multi[$i]; 
		}
		 for ($i=0; $i<count($profs_multi); $i++)
		{ 
		$ressource.= '&profs_multi['.$i.']='.$profs_multi[$i];
		}
		 for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		$ressource.= '&materiels_multi['.$i.']='.$materiels_multi[$i];   
		}	

		
?>
	
	<form name="admin" id="admin" action="admin.php?lar=<?php echo $lar; ?>&hau=<?php echo $hau; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>&horiz=<?php echo $horizon; ?>&current_week=<?php echo $current_week; ?>&current_year=<?php echo $current_year; ?>&jour=<?php echo $jour_jour_j; ?><?php echo $ressource; ?>" method="POST">
	
	
	<table><tr>

<th align="center" bgcolor="black" ><font color="white" >Nom</font></th>
<th align="center" bgcolor="black" ><font color="white" >Prénom</font></th>
<th align="center" bgcolor="black" ><font color="white" >Administrateur</font></th>
<th align="center" bgcolor="black" ><font color="white" >Export vers Giseh</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des salles</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des heures des profs</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des formations</font></th>
<th align="center" bgcolor="black" ><font color="white" >Afficher ses droits</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan de ses heures</font></th>
<th align="center" bgcolor="black" ><font color="white" >Export PDF</font></th>
<th align="center" bgcolor="black" ><font color="white" >RSS</font></th>
<th align="center" bgcolor="black" ><font color="white" >Configuration</font></th>
<th align="center" bgcolor="black" ><font color="white" >Réservation</font></th>
<th align="center" bgcolor="black" ><font color="white" >Détail des modules</font></th>
<th align="center" bgcolor="black" ><font color="white" >Séance clicable</font></th>
<th align="center" bgcolor="black" ><font color="white" >Dialogue de gestion</font></th>

</tr>

<?php


	




	//requete pour avoir la liste des droits des utilisateurs

$sql="SELECT * FROM login_prof left join ressources_profs on (ressources_profs.codeProf=login_prof.codeProf) WHERE ressources_profs.deleted='0' order by ressources_profs.nom,ressources_profs.prenom Asc";

$req_liste_droit=$dbh->query($sql);
$res_liste_droit=$req_liste_droit->fetchAll();	
$i=0;
foreach ($res_liste_droit as $res_liste_droits)		
{
$reservation=$res_liste_droits['reservation'];
$mes_droits=$res_liste_droits['mes_droits'];
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
$salle=$res_liste_droits['salle'];
$dialogue=$res_liste_droits['dialogue'];
?>
<tr>
<td  align="center" bgcolor="white"><?php echo $res_liste_droits['nom']; ?></td>
<td  align="center" bgcolor="white"><?php echo $res_liste_droits['prenom']; ?></td>

<td align="center" bgcolor="<?php if ($admin=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="admin_<?php echo $i; ?>" name="admin[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($admin=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>



<td align="center" bgcolor="<?php if ($giseh=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="giseh_<?php echo $i; ?>" name="giseh[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($giseh=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>


<td align="center" bgcolor="<?php if ($salle=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="salle_<?php echo $i; ?>" name="salle[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($salle=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>


<td align="center" bgcolor="<?php if ($bilan_heure_global=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="bilan_heure_global_<?php echo $i; ?>" name="bilan_heure_global[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($bilan_heure_global=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

<td align="center" bgcolor="<?php if ($bilan_formation=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="bilan_formation_<?php echo $i; ?>" name="bilan_formation[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($bilan_formation=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>
<td align="center" bgcolor="<?php if ($mes_droits=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="mes_droits_<?php echo $i; ?>" name="mes_droits[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($mes_droits=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>
<td align="center" bgcolor="<?php if ($bilan_heure=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="bilan_heure_<?php echo $i; ?>" name="bilan_heure[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($bilan_heure=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

<td align="center" bgcolor="<?php if ($pdf=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="pdf_<?php echo $i; ?>" name="pdf[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($pdf=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

<td align="center" bgcolor="<?php if ($rss=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="rss_<?php echo $i; ?>" name="rss[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($rss=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

<td align="center" bgcolor="<?php if ($configuration=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="configuration_<?php echo $i; ?>" name="configuration[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($configuration=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

<td align="center" bgcolor="<?php if ($reservation=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="reservation_<?php echo $i; ?>" name="reservation[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($reservation=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>
<td align="center" bgcolor="<?php if ($module=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="module_<?php echo $i; ?>" name="module[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($module=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>
<td align="center" bgcolor="<?php if ($seance_clicable=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="seance_clicable_<?php echo $i; ?>" name="seance_clicable[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($seance_clicable=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>
<td align="center" bgcolor="<?php if ($dialogue=='1') {echo 'green';} else { echo 'red'; } ?>"><input type="checkbox" id="dialogue_<?php echo $i; ?>" name="dialogue[<?php echo $res_liste_droits['codeProf']; ?>]" tabindex="<?php echo $i; ?>"  style="border:none;background-color:silver;" <?php if ($dialogue=='1') {echo 'checked="checked" value="1"';} else { echo 'value="1"'; } ?> ></td>

</tr>
<?php
$i+=1;
 if ($i % 15 == 0)
{
?>
<tr style="background-color:white;"><td class="semestres_list" colspan="15"><input type="submit" id="input<?php echo $i; ?>" style="font-size:8pt;" value="Sauvegarder"></td></tr>
<tr>

<th align="center" bgcolor="black" ><font color="white" >Nom</font></th>
<th align="center" bgcolor="black" ><font color="white" >Prénom</font></th>
<th align="center" bgcolor="black" ><font color="white" >Administrateur</font></th>
<th align="center" bgcolor="black" ><font color="white" >Export vers Giseh</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des salles</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des heures des profs</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan des formations</font></th>
<th align="center" bgcolor="black" ><font color="white" >Afficher ses droits</font></th>
<th align="center" bgcolor="black" ><font color="white" >Bilan de ses heures</font></th>
<th align="center" bgcolor="black" ><font color="white" >Export PDF</font></th>
<th align="center" bgcolor="black" ><font color="white" >RSS</font></th>
<th align="center" bgcolor="black" ><font color="white" >Configuration</font></th>
<th align="center" bgcolor="black" ><font color="white" >Réservation</font></th>
<th align="center" bgcolor="black" ><font color="white" >Détail des modules</font></th>
<th align="center" bgcolor="black" ><font color="white" >Séance clicable</font></th>
<th align="center" bgcolor="black" ><font color="white" >Dialogue de gestion</font></th>

</tr>
<?php
}






}	

?>
</table><br>
<input type="hidden" id="update" name="update" value="TRUE">
</form>
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