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
	
	
//récupération de variables
$horizon=$_GET['horiz'];
$lar=$_GET['lar'];
$hau=$_GET['hau'];
$selec_prof=$_GET['selec_prof'];
$selec_groupe=$_GET['selec_groupe'];
$selec_salle=$_GET['selec_salle'];
$selec_materiel=$_GET['selec_materiel'];
$current_year=$_GET['current_year'];
$current_week=$_GET['current_week'];
if(!isset($_GET['disconnect']))
{
$_GET['disconnect']="";
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

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}	

 //mise à jour de la table login_prof afin de prendre en compte les modifs
if (isset($_GET['maj']))
{


if ($_GET['weekend']=='dimanche')
{
$weekend='2';
}
elseif ($_GET['weekend']=='samedi')
{
$weekend='1';
}

else
{
$weekend='0';
}

if (isset($_GET['debut']))
{
$heureDebut=$_GET['debut'];
}

if (isset($_GET['fin']))
{
$heureFin=$_GET['fin'];
}

if (isset($_GET['debut_bouton_1']))
{
$debut_bouton_1=$_GET['debut_bouton_1'];
}
else
{
$debut_bouton_1=8;
}

if (isset($_GET['debut_bouton_2']))
{
$debut_bouton_2=$_GET['debut_bouton_2'];
}
else
{
$debut_bouton_2=10;
}

if (isset($_GET['debut_bouton_3']))
{
$debut_bouton_3=$_GET['debut_bouton_3'];
}
else
{
$debut_bouton_3=14;
}

if (isset($_GET['debut_bouton_4']))
{
$debut_bouton_4=$_GET['debut_bouton_4'];
}
else
{
$debut_bouton_4=16;
}

if (isset($_GET['fin_bouton_1']))
{
$fin_bouton_1=$_GET['fin_bouton_1'];
}
else
{
$fin_bouton_1=10;
}

if (isset($_GET['fin_bouton_2']))
{
$fin_bouton_2=$_GET['fin_bouton_2'];
}
else
{
$fin_bouton_2=12;
}

if (isset($_GET['fin_bouton_3']))
{
$fin_bouton_3=$_GET['fin_bouton_3'];
}
else
{
$fin_bouton_3=16;
}

if (isset($_GET['fin_bouton_4']))
{
$fin_bouton_4=$_GET['fin_bouton_4'];
}
else
{
$fin_bouton_4=18;
}

if (isset($_GET['couleur_groupe']))
{
$couleur_des_seances_groupe_prof=$_GET['couleur_groupe'];
}

if (isset($_GET['couleur_prof']))
{
$couleur_des_seances_prof_prof=$_GET['couleur_prof'];
}

if (isset($_GET['couleur_salle']))
{
$couleur_des_seances_salle_prof=$_GET['couleur_salle'];
}

if (isset($_GET['couleur_matiere']))
{
$couleur_des_seances_matiere_prof=$_GET['couleur_matiere'];
}


	$sql="update login_prof set weekend=:weekend,heureDebut=:heureDebut,heureFin=:heureFin, bouton1Debut=:debut_bouton_1,bouton2Debut=:debut_bouton_2,bouton3Debut=:debut_bouton_3,bouton4Debut=:debut_bouton_4,bouton1Fin=:fin_bouton_1,bouton2Fin=:fin_bouton_2,bouton3Fin=:fin_bouton_3,bouton4Fin=:fin_bouton_4,couleur_groupe=:couleur_groupe,couleur_prof=:couleur_prof,couleur_salle=:couleur_salle,couleur_materiel=:couleur_materiel where codeProf=:codeProf ";
	$req_modif_config=$dbh->prepare($sql);
	$req_modif_config->execute(array(':weekend'=>$weekend,':heureDebut'=>$heureDebut,':heureFin'=>$heureFin,':codeProf'=>$codeProf,':debut_bouton_1'=>$debut_bouton_1,':debut_bouton_2'=>$debut_bouton_2,':debut_bouton_3'=>$debut_bouton_3,':debut_bouton_4'=>$debut_bouton_4,':fin_bouton_1'=>$fin_bouton_1,':fin_bouton_2'=>$fin_bouton_2,':fin_bouton_3'=>$fin_bouton_3,':fin_bouton_4'=>$fin_bouton_4,':couleur_groupe'=>$couleur_des_seances_groupe_prof,':couleur_prof'=>$couleur_des_seances_prof_prof,':couleur_salle'=>$couleur_des_seances_salle_prof,':couleur_materiel'=>$couleur_des_seances_materiel_prof));

	
	if ($weekend=='0')
		{
		$dimanche='0';
		$samedi='0';
		}
	elseif($weekend=='1')
		{
		$dimanche='0';
		$samedi='1';
		}
	else
		{
		$dimanche='1';
		$samedi='1';
		}	
$heure_debut_journee=$heureDebut;
$heure_fin_journee=$heureFin;
	
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
<link rel="stylesheet" href="css/ma_config.css" type="text/css" >


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
$afficher_mes_droits=1;
$afficher_mes_heures=1;
$afficher_bilan_par_formation=1;
$afficher_giseh=1;
$afficher_flux_rss=1;
$afficher_ma_config=0;
$afficher_occupation_des_salles=1;

$nom_de_la_fenetre="Ma configuration";
include('menu_outil.php');
	
?>


<div style="text-align:center;width:100%;">





<form name="form1" id="form1" action="index.php" method="get" >


	
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
	<input type="hidden" name="jour" id="jours" value="<?php echo $jour; ?>">
	
	 </form><br><br>
	 
	 
	 
<form name="form2" id="form2" action="ma_config.php" method="get" >


		<input type="hidden" name="maj" id="mise_a_jour" value="1">
	<input type="hidden" name="lar" id="scree_w" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="scree_hi" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_p" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_gro" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_s" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_m" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="current_week" id="curren_w" value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year" id="curren_y" value="<?php echo $current_year; ?>">
	<input type="hidden" name="horiz" id="h" value="<?php echo $horizon; ?>">
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
	Affichage du samedi et du dimanche : 
	<select name="weekend">
	
	<?php
	if ($dimanche=='0' && $samedi=='0')
	{
	?>
	<option selected value="rien">Ni samedi ni dimanche</option>
	 <?php
	}
	else
	{
	?>
	<option value="rien">Ni samedi ni dimanche</option>
	 <?php
	}
	if ($samedi=='1' && $dimanche=='0')
	{
	?>
	<option selected value="samedi">Samedi</option>
	 <?php
	}
	else
	{
	?>
	<option value="samedi">Samedi</option>
	 <?php
	}
	if ($dimanche=='1' )
	{
	?>
	 <option selected value="dimanche">Samedi et dimanche</option>
	 <?php
	}
	else
	{
	?>
	 <option value="dimanche">Samedi et dimanche</option>
	  <?php
	}
  ?>


</select><br><br>

	La couleur des séances des groupes correspond à la couleur des : 
	<select name="couleur_groupe">
	
	<?php
	if ($couleur_des_seances_groupe_prof==0)
	{
	?>
	<option selected value="0">Groupes</option>
	 <?php
	}
	else
	{
	?>
	<option value="0">Groupes</option>
	 <?php
	}
	if ($couleur_des_seances_groupe_prof==1)
	{
	?>
	<option selected value="1">Matières</option>
	 <?php
	}
	else
	{
	?>
	<option value="1">Matières</option>
	 <?php
	}
	if ($couleur_des_seances_groupe_prof==2 )
	{
	?>
	 <option selected value="2">Profs</option>
	 <?php
	}
	else
	{
	?>
	 <option value="2">Profs</option>
	  <?php
	}
  ?>


</select><br><br>

	La couleur des séances des profs correspond à la couleur des : 
	<select name="couleur_prof">
	
	<?php
	if ($couleur_des_seances_prof_prof==0)
	{
	?>
	<option selected value="0">Groupes</option>
	 <?php
	}
	else
	{
	?>
	<option value="0">Groupes</option>
	 <?php
	}
	if ($couleur_des_seances_prof_prof==1)
	{
	?>
	<option selected value="1">Matières</option>
	 <?php
	}
	else
	{
	?>
	<option value="1">Matières</option>
	 <?php
	}
	if ($couleur_des_seances_prof_prof==2 )
	{
	?>
	 <option selected value="2">Profs</option>
	 <?php
	}
	else
	{
	?>
	 <option value="2">Profs</option>
	  <?php
	}
  ?>


</select><br><br>

	La couleur des séances des salles correspond à la couleur des : 
	<select name="couleur_salle">
	
	<?php
	if ($couleur_des_seances_salle_prof==0)
	{
	?>
	<option selected value="0">Groupes</option>
	 <?php
	}
	else
	{
	?>
	<option value="0">Groupes</option>
	 <?php
	}
	if ($couleur_des_seances_salle_prof==1)
	{
	?>
	<option selected value="1">Matières</option>
	 <?php
	}
	else
	{
	?>
	<option value="1">Matières</option>
	 <?php
	}
	if ($couleur_des_seances_salle_prof==2 )
	{
	?>
	 <option selected value="2">Profs</option>
	 <?php
	}
	else
	{
	?>
	 <option value="2">Profs</option>
	  <?php
	}
  ?>


</select><br><br>

	La couleur des séances des materiels correspond à la couleur des : 
	<select name="couleur_materiel">
	
	<?php
	if ($couleur_des_seances_materiel_prof==0)
	{
	?>
	<option selected value="0">Groupes</option>
	 <?php
	}
	else
	{
	?>
	<option value="0">Groupes</option>
	 <?php
	}
	if ($couleur_des_seances_materiel_prof==1)
	{
	?>
	<option selected value="1">Matières</option>
	 <?php
	}
	else
	{
	?>
	<option value="1">Matières</option>
	 <?php
	}
	if ($couleur_des_seances_materiel_prof==2 )
	{
	?>
	 <option selected value="2">Profs</option>
	 <?php
	}
	else
	{
	?>
	 <option value="2">Profs</option>
	  <?php
	}
  ?>


</select><br><br>

	Heure de début de journée : 
	<select name="debut">
	<?php 
	for ($i=0;$i<=$heure_debut_journee_bis;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_debut_journee )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select><br><br>
	Heure de fin de journée : 
	<select name="fin">
	<?php 
	for ($i=$heure_fin_journee_bis;$i<=24;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}	
	if ($i==$heure_fin_journee)
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	
	
	
	}	
	
?>
</select><br><br>
<br>
<?php
if ($_SESSION['reservation']!='0')
{
?>

<p style="text-align:center; color:black;"><span style="font-size:10px; font-weight:bold;">Définition des boutons de raccourci pour les horaires des réservations</span></p>

<?php
//recuperation des heures de début et de fin pour les 4 boutons
$sql="SELECT * FROM login_prof WHERE codeProf=:codeProf ";
$req_boutons_prof_perso=$dbh->prepare($sql);
$req_boutons_prof_perso->execute(array(':codeProf'=>$_SESSION['logged_prof_perso']));
$res_boutons_prof_perso=$req_boutons_prof_perso->fetchAll();
foreach($res_boutons_prof_perso as $res_bouton_prof_perso)
{
$heure_debut_bouton1=$res_bouton_prof_perso['bouton1Debut'];
$heure_debut_bouton2=$res_bouton_prof_perso['bouton2Debut'];
$heure_debut_bouton3=$res_bouton_prof_perso['bouton3Debut'];
$heure_debut_bouton4=$res_bouton_prof_perso['bouton4Debut'];
$heure_fin_bouton1=$res_bouton_prof_perso['bouton1Fin'];
$heure_fin_bouton2=$res_bouton_prof_perso['bouton2Fin'];
$heure_fin_bouton3=$res_bouton_prof_perso['bouton3Fin'];
$heure_fin_bouton4=$res_bouton_prof_perso['bouton4Fin'];
}
?>
<span style="font-size:10px; font-weight:bold;">Bouton 1</span><br>
Début :  
	<select name="debut_bouton_1">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_debut_bouton1 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	Fin : 	<select name="fin_bouton_1">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_fin_bouton1 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	
	
	
	
	
	<br><br>
	
	
<span style="font-size:10px; font-weight:bold;">Bouton 2</span><br>
Début :  
	<select name="debut_bouton_2">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_debut_bouton2 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	Fin : 	<select name="fin_bouton_2">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_fin_bouton2 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	
	
	
	
	
	<br><br>

<span style="font-size:10px; font-weight:bold;">Bouton 3</span><br>
Début :  
	<select name="debut_bouton_3">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_debut_bouton3 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	Fin : 	<select name="fin_bouton_3">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_fin_bouton3 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	
	
	
	
	
	<br><br>

<span style="font-size:10px; font-weight:bold;">Bouton 4</span><br>
Début :  
	<select name="debut_bouton_4">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_debut_bouton4 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	Fin : 	<select name="fin_bouton_4">
	<?php 
	for ($i=$heure_debut_journee;$i<=$heure_fin_journee;$i+=0.25)
	{
$heure=floor($i);
$minute=($i-$heure)*60;
if($minute=='0')
{
$minute='00';
}
		if ($i==$heure_fin_bouton4 )
	{
	echo '<option selected value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	else
	{
	echo '<option value="'.$i.'">'.$heure.'h'.$minute.'</option>';
	}
	
	}
		
	?>
	</select>
	
	
	
	
	
	<br><br>	
	<?php
	}
	?>

	<input type="hidden" name="jour" id="jours2" value="<?php echo $jour; ?>">
	<input name="" value="Sauvegarder les modifications" type="submit">
	 </form><br><br>	 
<?php 
if (isset($_GET['maj']))
{	
?>	
<p style="text-align:center; color:blue;"><span style="font-size:12px; font-weight:bold;">Modifications sauvegardées. Vous pouvez retourner à l'emploi du temps.</span></p>
<?php

 

}?>	 
	 
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


	




