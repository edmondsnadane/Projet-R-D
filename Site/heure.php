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

	$total_heure_forfait_module_CM='';
	$total_min_forfait_module_CM='';
		$total_heure_forfait_module_TD='';
	$total_min_forfait_module_TD='';
		$total_heure_forfait_module_TP='';
	$total_min_forfait_module_TP='';
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
<link rel="stylesheet" href="css/heure.css" type="text/css" >


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
$afficher_mes_heures=0;
$afficher_bilan_par_formation=1;
$afficher_giseh=1;
$afficher_flux_rss=1;
$afficher_ma_config=1;
$afficher_occupation_des_salles=1;
$afficher_dialogue=1;
$nom_de_la_fenetre="Mes heures";
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
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
<form name="form" id="form" action="heure.php" method="get" >

<p>Année scolaire : <select name="annee_scolaire" onchange="document.form.submit();" >
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

Profs : 
		<select name="selec_prof2"   onchange="document.form.submit();">


<?php
if(isset ($_GET['premier_lancement']))
{
$premier_lancement=0;
}
else
{
$premier_lancement=1;
}
if(isset ($_GET['selec_prof2']))
{
$selec_prof2=$_GET['selec_prof2'];
}

else
{
$selec_prof2="TOUS";
}
$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";
$req_affectation=$dbh->query($sql);
$res_affectation=$req_affectation->fetchAll();

 echo '<option value="TOUS"';
    if ($selec_prof2=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
foreach ($res_affectation as $res)

    {

    echo '<option value="'.$res['codeComposante'].'"';
    if ($res['codeComposante']==$selec_prof2)

        echo " SELECTED";


    echo '>'.$res['nom'].'</option>';

    }

?>
     </select><br>
	
	<select name="prof"  size="5" >

<?php

if ($selec_prof2!="TOUS" && $selec_prof2!="")
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeComposante=:selec_prof  ORDER BY nom,prenom";
	$req_prof=$dbh->prepare($sql);
	$req_prof->execute(array(':selec_prof'=>$selec_prof2));
	$res_prof=$req_prof->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_prof=$dbh->query($sql);
	$res_prof=$req_prof->fetchAll();
	}




foreach ($res_prof as $res)
    {

    echo '<option value="'.$res['codeProf'].'"';

	if($premier_lancement==0 && isset ($_GET['prof']))
		{
			if ($res['codeProf']==$_GET['prof'])
				{
				echo " SELECTED";
				$prof_dans_liste=1;
				}
		}

	
	if ($premier_lancement==1 && $res['codeProf']==$_SESSION['logged_prof_perso'])
		{
		echo " SELECTED";
		$prof_dans_liste=1;
		}
			


	echo '>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option>

    ';

    }
?>
</select>
<br>
<?php
if(isset($_GET['chrono']))
	{
	$chrono=$_GET['chrono'];
	?>
	<input type="hidden" name="chrono" id="chrono_prof" value="<?php echo $chrono; ?>">
	<?php
	}

?>

	<input type="hidden" name="lar" id="screen_wi_prof" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hei_prof" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_profs_prof" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_prof" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_prof" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_prof" value="<?php echo $selec_materiel; ?>">
		<input type="hidden" name="current_week" id="current_wee_prof" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_yea_prof" value="<?php echo $current_year; ?>">
				
				<input type="hidden" name="premier_lancement" id="premier_lancemen_prof" value="<?php echo $premier_lancement; ?>">
				<?php
				if (isset($_GET['prof']))
				{
				?>
				<input type="hidden" name="prof_precedent" id="prof_preceden_prof" value="<?php echo $_GET['prof']; ?>">
				<?php
				}

	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1_prof" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0_prof" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2_prof" value="2" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3_prof" value="3" >
	<?php
	}
	?>

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
	
	
	
	
	<br>
	<input type=submit value="Envoyer" > <br>
	
	
	 </form><br>
	
	 <?php
	 }}
	 ?>
	

	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
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
		
		
		
		
if ($chrono=='0') //par matière
{
?>	 
<form name="par_chrono" id="par_chrono" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_chrono" value="<?php echo $selec_prof2; ?>">	
	<input type="hidden" name="chrono" id="chrono_chrono" value="1">
	<input type="hidden" name="lar" id="screen_w_chrono" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_chrono" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_chrono" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_chrono" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_chrono" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_ma_chrono" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_scol" value="<?php echo $annee_scolaire_choisie; ?>">
	<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_chrono" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_chrono" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_chrono" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_chrono" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_chrono" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours3_chrono" value="<?php echo $jour_jour_j; ?>">
	<input name="bouton" value="Faire un classement chronologique" type="submit"  >
	 </form>
	 	<?php
		//bouton apogee
		?>
<form name="par_apogee" id="par_apogee" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_apogee" value="<?php echo $selec_prof2; ?>">	
	<input type="hidden" name="chrono" id="chrono_apogee" value="2">
	<input type="hidden" name="lar" id="screen_w_apogee" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_apogee" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_apogee" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_apogee" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_apogee" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_ma_apogee" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_scola" value="<?php echo $annee_scolaire_choisie; ?>">
	<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_apogee" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_apogee" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_apogee" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_apogee" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_apogee" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours3_apogee" value="<?php echo $jour_jour_j; ?>">
	<input name="bouton" value="Faire un classement par code apogée" type="submit"  >
	 </form>
	 	 <?php		 
		//bouton export excel
	?>
	<form name="excel" id="excel" action="heure_csv.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_excel" value="<?php echo $selec_prof2; ?>">	
	<input type="hidden" name="chrono" id="chrono_excel" value="0">
	<input type="hidden" name="lar" id="screen_w_excel" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_excel" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_excel" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_excel" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_excel" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_excel" value="<?php echo $selec_materiel; ?>">	
	<input type="hidden" name="annee_scolaire" id="annee_scolai" value="<?php echo $annee_scolaire_choisie; ?>">
		<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_excel" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_excel" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_excel" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_excel" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_excel" value="<?php echo $horizon; ?>">
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
	
	<input name="" value="Export vers Excel" type="submit">
	 </form>
	 
	 
	 
	 
	 
<?php
}
elseif ($chrono=='1')
{
?>
	 
	 
<form name="pas_chrono" id="pas_chrono" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_matiere" value="<?php echo $selec_prof2; ?>">	
	<input type="hidden" name="chrono" id="chrono_matiere" value="0">
	<input type="hidden" name="lar" id="screen_w_matiere" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_matiere" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_matiere" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_matiere" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_matiere" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_matiere" value="<?php echo $selec_materiel; ?>">	
	<input type="hidden" name="annee_scolaire" id="annee_scolair" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_matiere" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_matiere" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_matiere" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_matiere" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_matiere" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours4_matiere" value="<?php echo $jour_jour_j; ?>">
	<input name="" value="Faire un classement par matière" type="submit">
	 </form>
	 <?php //par code apogee
	 ?>
<form name="pas_chrono" id="pas_chrono" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_apogee" value="<?php echo $selec_prof2; ?>">
	<input type="hidden" name="chrono" id="chrono_apogee" value="2">
	<input type="hidden" name="lar" id="screen_w_apogee" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_apogee" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_apogee" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_apogee" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_apogee" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_apogee" value="<?php echo $selec_materiel; ?>">	
	<input type="hidden" name="annee_scolaire" id="annee_sco" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_apogee" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_apogee" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_apogee" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_apogee" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_apogee" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours4_apogee" value="<?php echo $jour_jour_j; ?>">
	<input name="" value="Faire un classement par code apogée" type="submit">
	 </form>	 
	 <?php
		//bouton export excel
	?>
	<form name="excel" id="excel" action="heure_csv.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_excel2" value="<?php echo $selec_prof2; ?>">
	<input type="hidden" name="chrono" id="chrono_excel2" value="1">
	<input type="hidden" name="lar" id="screen_w_excel2" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_excel2" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_excel2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_excel2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_excel2" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_excel2" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_sc" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_excel2" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_excel2" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_excel2" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_excel2" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_excel2" value="<?php echo $horizon; ?>">
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
	
	<input name="" value="Export vers Excel" type="submit">
	 </form>	 


	 
<?php
	 }
else//classement par code apogee
{
?>
	 
	 
<form name="pas_chrono" id="pas_chrono" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_matiere" value="<?php echo $selec_prof2; ?>">
	<input type="hidden" name="chrono" id="chrono_matiere" value="0">
	<input type="hidden" name="lar" id="screen_w_matiere" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_matiere" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_matiere" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_matiere" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_matiere" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_matiere" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_s" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_matiere" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_matiere" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_matiere" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_matiere" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_matiere" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours4_matiere" value="<?php echo $jour_jour_j; ?>">
	<input name="" value="Faire un classement par matière" type="submit">
	 </form>
	 
 
<form name="par_chrono" id="par_chrono" action="heure.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_chrono" value="<?php echo $selec_prof2; ?>">
	<input type="hidden" name="chrono" id="chrono_chrono" value="1">
	<input type="hidden" name="lar" id="screen_w_chrono" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_chrono" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_chrono" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_chrono" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_chrono" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_chrono" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_scol2" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_chrono" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_chrono" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_chrono" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_chrono" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_chrono" value="<?php echo $horizon; ?>">
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
		<input type="hidden" name="jour" id="jours4_chrono" value="<?php echo $jour_jour_j; ?>">
	<input name="" value="Faire un classement chronologique" type="submit">
	 </form>	 
	 
	 <?php
		//bouton export excel
	?>
	<form name="excel" id="excel" action="heure_csv.php" method="get" >

	<input type="hidden" name="selec_prof2" id="selec_prof2_excel2" value="<?php echo $selec_prof2; ?>">
	<input type="hidden" name="chrono" id="chrono_excel2" value="2">
	<input type="hidden" name="lar" id="screen_w_excel2" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi_excel2" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr_excel2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou_excel2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa_excel2" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_ma_excel2" value="<?php echo $selec_materiel; ?>">
	<input type="hidden" name="annee_scolaire" id="annee_sco2" value="<?php echo $annee_scolaire_choisie; ?>">
			<?php
if (isset($_SESSION['bilan_heure_global']))
{
if ($_SESSION['bilan_heure_global']=='1')
{
	?>
			<input type="hidden" name="prof" id="pro_excel2" value="<?php echo $codeProf; ?>">
			<input type="hidden" name="premier_lancement" id="premier_lancemen_excel2" value="<?php echo $premier_lancement; ?>">
			<?php
			}}
			?>
		<input type="hidden" name="current_week" id="current_w_excel2" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y_excel2" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho_excel2" value="<?php echo $horizon; ?>">
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
	
	<input name="" value="Export vers Excel" type="submit">
	 </form>	 


	 
<?php
	 }	 
	 

	 
	 
	 
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
?>	
	 
	 
	 
	 
<p style="text-align:center;"><span style="font-size:30px; font-weight:bold;">Liste de mes heures</span><br>
<span style="font-size:15px; "><?php echo "(".$prof_prenom." ".$prof_nom.")"; ?></span><br>

<span style="font-size:15px; ">G&eacute;n&eacute;r&eacute; le <?php echo $jour;?>/<?php echo $mois; ?>/<?php echo $annee; ?> à <?php echo $heure; ?>h<?php echo $minute; ?></span><br></p>	



	
	
	
	
	<table><tr>

<th align="center" bgcolor="black" ><font color="white" >Formation</font></th>
<th align="center" bgcolor="black" ><font color="white" >Code apog&eacute;e</font></th>
<th align="center" bgcolor="black" ><font color="white" >Mati&egrave;re</font></th>
<th align="center" bgcolor="black" ><font color="white" >Date</font></th>
<th align="center" bgcolor="black" ><font color="white" >Heure d&eacute;but</font></th>
<th align="center" bgcolor="black" ><font color="white" >Heure fin</font></th>
<th align="center" bgcolor="black" ><font color="white" >Horaire r&eacute;parti / nb profs</font></th>
<th align="center" bgcolor="black" ><font color="white" >Forfait</font></th>
<th align="center" bgcolor="black" ><font color="white" >CR</font></th>
<th align="center" bgcolor="black" ><font color="white" >TD</font></th>
<th align="center" bgcolor="black" ><font color="white" >TP</font></th>
<th align="center" bgcolor="black" ><font color="white" >EqTD</font></th>
<th align="center" bgcolor="black" ><font color="white" >Effectué</font></th>
<?php

if ($chrono=='1')
{
?>
<th align="center" bgcolor="black" ><font color="white" >Cumul</font></th>
<?php
}

?>
</tr>

<?php


	



//initialisation des variables
$total_heure_eqtd_effectue="";
$total_min_eqtd_effectue="";
$total_heure_eqtd_effectue_total="";
$total_min_eqtd_effectue_total="";
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

//memorisation du code de la matière pour afficher le sous total des heures lors du changmeent de matiere
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
	
	?>
	
		<tr>
		<td align="center" bgcolor="green"><?php echo $nom_groupe_niv_sup; ?></td>
		<td align="center" bgcolor="green"><?php echo $memoire_code_identifiant; ?></td>
		
	<td colspan="6" align="center" bgcolor="green">CUMUL DES HEURES POUR L'EC CI-DESSUS</td>
	<?php		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_cr_module."h".$total_min_cr_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_td_module."h".$total_min_td_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_tp_module."h".$total_min_tp_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
?>

	<td align="center" bgcolor="green"><?php echo $total_heure_eqtd_module."h".$total_min_eqtd_module; ?></td>
		<td align="center" bgcolor="green"></td>
	</tr>
	
	<?php
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

	?>
	
		<tr>
		<td align="center" bgcolor="green"><?php echo $nom_groupe_niv_sup; ?></td>
		<td align="center" bgcolor="green"><?php echo $memoire_code_identifiant; ?></td>
		
	<td colspan="6" align="center" bgcolor="green">CUMUL DES HEURES POUR L'EC CI-DESSUS</td>
	<?php		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_cr_module."h".$total_min_cr_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_td_module."h".$total_min_td_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_tp_module."h".$total_min_tp_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
?>

	<td align="center" bgcolor="green"><?php echo $total_heure_eqtd_module."h".$total_min_eqtd_module; ?></td>
		<td align="center" bgcolor="green"></td>
	</tr>
	
	<?php
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

	//memorisation de l'identifiant (code apogée) pour l'afficher dans le cumul des heures de l'EC
	$memoire_code_identifiant=$enseignement['identifiant'];
	
	//date du jour actuel pour savoir si la séance a été effectuée.
$date_actuelle=date('Y').date('m').date('d');
$date_seance=$annee.$mois.$jour;
	
	
	?>
	<tr>
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
		
			
			
			
			?>
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
					
			
			
		if ($date_actuelle>$date_seance)
{		
			$total_heure_eqtd_effectue_total+=$heureeqtd;
$total_min_eqtd_effectue_total+=$mineqtd;
}			
		
		
			
		?>	
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:green; font-weight:bold;"><?php if ($date_actuelle>$date_seance){ echo "&#10003;";} else{ echo "";} ?></span></td>	
			<?php	
			
	if ($chrono=="1")
	{
	?>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $cumul; ?></td>
	<?php
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
			
	//	$dureeeqtd=$heureduree."h".$minduree;
	?>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>">OUI</td>
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
		
		
if ($date_actuelle>$date_seance)
{		
			$total_heure_eqtd_effectue_total+=$heureeqtd;
$total_min_eqtd_effectue_total+=$mineqtd;
}	
		
		
		
			?>	
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:green; font-weight:bold;"><?php if ($date_actuelle>$date_seance){ echo "&#10003;";} else{ echo "";} ?></span></td>	
			<?php
		
		
			if ($chrono=="1")
	{
	?>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $cumul; ?></td>
	<?php
	}
		
		
		}
	?>		
	</tr>
	<?php
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
	
	?>
	
		<tr>
		<td align="center" bgcolor="green"><?php echo $nom_groupe_niv_sup; ?></td>
		<td align="center" bgcolor="green"><?php echo $memoire_code_identifiant; ?></td>
		
	<td colspan="6" align="center" bgcolor="green">CUMUL DES HEURES POUR L'EC CI-DESSUS</td>
	<?php		
	if ($total_heure_cr_module!='' || $total_min_cr_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_cr_module."h".$total_min_cr_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_td_module!='' || $total_min_td_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_td_module."h".$total_min_td_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
	if ($total_heure_tp_module!='' || $total_min_tp_module!='')
		{?>
		<td align="center" bgcolor="green"><?php echo $total_heure_tp_module."h".$total_min_tp_module; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="green"></td>
		<?php
		}
?>

	<td align="center" bgcolor="green"><?php echo $total_heure_eqtd_module."h".$total_min_eqtd_module; ?></td>
	<td align="center" bgcolor="green"></td>
	</tr>
	
	<?php
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


		?>
		<tr>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_forfait_groupe; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $enseignements_au_forfait['identifiant']; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nomenseignement; ?></td>
		<td  colspan="3" align="center" bgcolor="<?php echo $bgcolor; ?>"> </td>
		
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
	
    			$total_heure_eqtd_effectue_total+=$heureeqtd;
$total_min_eqtd_effectue_total+=$mineqtd;
    	
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

	?>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>">&#10003;</td>
	<?php
			if ($chrono=="1")
	{
	?>	
	<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $cumul; ?></td>
	<?php
	}
?>	
		</tr>
		<?php
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
		
	$total_heure_effectue_en_min=$total_heure_eqtd_effectue_total*60+$total_min_eqtd_effectue_total;
	$total_heure_effectue=intval($total_heure_effectue_en_min/60);
	$total_min_effectue=$total_heure_effectue_en_min%60;
	if ($total_heure_effectue==0 and $total_min_effectue==0)
		{
		$total_heure_effectue="";
		$total_min_effectue="";
		}
	if (strlen($total_heure_effectue)==1)
		{
		$total_heure_effectue="0".$total_heure_effectue;
		}

	if (strlen($total_min_effectue)==1)
		{
		$total_min_effectue="0".$total_min_effectue;
		}		
		
	?>
	<tr>
	<td colspan="8" align="center" bgcolor="#6699FF">CUMUL DES HEURES DE L'ANNEE</td>
	<?php	
	
	if ($total_heure_cr!="" || $total_min_cr!="")
		{?>
		<td align="center" bgcolor="#6699FF"><?php echo $total_heure_cr."h".$total_min_cr; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="#6699FF"></td>
		<?php
		}
	if ($total_heure_td!="" || $total_min_td!="")
		{?>
		<td align="center" bgcolor="#6699FF"><?php echo $total_heure_td."h".$total_min_td; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="#6699FF"></td>
		<?php
		}
	if ($total_heure_tp!="" || $total_min_tp!="")
		{?>
		<td align="center" bgcolor="#6699FF"><?php echo $total_heure_tp."h".$total_min_tp; ?></td>
		<?php
		}
	else
		{?>
		<td align="center" bgcolor="#6699FF"></td>
		<?php
		}?>

	<td align="center" bgcolor="#6699FF"><?php echo $total_heure_eqtd."h".$total_min_eqtd; ?></td>
	<?php
	if ($total_heure_effectue!="" || $total_min_effectue!="")
		{?>
			<td align="center" bgcolor="#6699FF"><?php echo $total_heure_effectue."h".$total_min_effectue; ?></td>
			<?php
		}
	else
		{?>
		<td align="center" bgcolor="#6699FF"></td>
		<?php
		}?>
		
<?php
if ($chrono=="1")
{
?>
<td align="center" bgcolor="#6699FF"></td>
<?php
}
?>		
		
	</tr>
	<?php	
	$affichage_eqtd=0;
	}




?>
</table>
<br>
<img src='graph_pourcentage.php?selec_prof=<?php echo $codeProf; ?>&base=<?php echo $annee_scolaire_choisie; ?>' /><br><br>
<img src='graph_heure.php?selec_prof=<?php echo $codeProf; ?>&base=<?php echo $annee_scolaire_choisie; ?>' /><br><br>
<form name="form3" id="form3" action="index.php" method="get" >
<input type="hidden" name="lar" id="screen_w2_retour2" value="<?php echo $lar; ?>">
<input type="hidden" name="hau" id="screen_hi2_retour2" value="<?php echo $hau; ?>">
<input type="hidden" name="selec_prof" id="selec_pro_retour2" value="<?php echo $selec_prof; ?>">
<input type="hidden" name="selec_groupe" id="selec_group_retour2" value="<?php echo $selec_groupe; ?>">
<input type="hidden" name="selec_salle" id="selec_sal_retour2" value="<?php echo $selec_salle; ?>">
<input type="hidden" name="selec_materiel" id="selec_mat_retour2" value="<?php echo $selec_materiel; ?>">
<input type="hidden" name="current_week" id="current_we_retour2" value="<?php echo $current_week; ?>">
<input type="hidden" name="current_year" id="current_ye_retour2" value="<?php echo $current_year; ?>">
<input type="hidden" name="horiz" id="hor_retour2" value="<?php echo $horizon; ?>">
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
?>
<input type="hidden" name="jour" id="jours_retour2" value="<?php echo $jour_jour_j; ?>">
<input name="" value="Retour à l'emploi du temps" type="submit">
</form>
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


