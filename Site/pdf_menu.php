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
 if (!isset($_GET['hideprivate']))
	{
	$_GET['hideprivate']='0';
	$hideprivate='0';
	}
else 
	{
	$hideprivate=$_GET['hideprivate'];
	}
	
if(!isset($_GET['disconnect']))
{
$_GET['disconnect']="";
}
	
	
 if (!isset($_GET['hideprobleme']))
	{
	$_GET['hideprobleme']='0';
	$hideprobleme='0';
	}
else 
	{
	$hideprobleme=$_GET['hideprobleme'];
	}
if (isset ($_GET['horiz']))
{
$horizon=$_GET['horiz'];
}

if (isset ($_GET['current_student']))
{
$current_student=$_GET['current_student'];
}
else
{
 $current_student=0;
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

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
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



//mise en forme de la date de début et de fin pour préremplir les champs "date de début" et "date de fin"
if ($horizon==0 || $horizon==1)
{
	// 1er Jour de la semaine

	$jour=date("w",mktime(0,0,0,1,1,$current_year));

	if($jour==0){$jour=7;}

	if($jour>4){$premieran=0;}else{$premieran=-1;}

	$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 

	$jsem=date("w",$lundi);

	$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem),$current_year); 

	$date_du_debut=date("d-m-Y",$lundi);
	$date_de_fin=date("d-m-Y",$lundi+6*24*60*60);
	
}
elseif ($horizon==2 || $horizon==4)
{
	// 1er lundi du mois

	$jour=date("w",mktime(0,0,0,1,1,$current_year));
	if($jour==0){$jour=7;}
	if($jour>4){$premieran=0;}else{$premieran=-1;}
	$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 
	$datedujour=date("d",$lundi);
	$numerosemainedanslemois = intval($datedujour/7);
	$jsem=date("w",$lundi);
	$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-($numerosemainedanslemois*7),$current_year); 
	$datedujour=date("d",$lundi);
	// pour les cas foireux par exemple mai2009
	if ($datedujour>2 && $datedujour<22) 
	{
	$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7),$current_year); 
	}

	
	$date_du_debut=date("d-m-Y",$lundi);
	$date_de_fin=date("d-m-Y",$lundi+34*24*60*60);

}
elseif ($horizon==3)
{
$date_du_debut=date("d-m-Y",mktime(0, 0, 0, date("m")  , date("d")+$jour_jour_j, date("Y")));
$date_de_fin=date("d-m-Y",mktime(0, 0, 0, date("m")  , date("d")+$jour_jour_j, date("Y")));
}
else
{
	$date_du_debut=date("d-m-Y");
	$date_de_fin=date("d-m-Y");
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
<style type="text/css">@import url(cal/calendar-blue2.css);</style>

<script type="text/javascript" src="cal/calendar.js"></script>

<script type="text/javascript" src="cal/lang/calendar-en.js"></script>

<script type="text/javascript" src="cal/calendar-setup.js"></script>
<link rel="stylesheet" href="css/pdf_menu.css" type="text/css" >


</head>

<body  style="margin: 0px;">

<?php
//Version des profs
if (isset($_SESSION['pdf']) || (isset($_SESSION['logged_prof_generique']) && $autorisation_pdf==1))
{
if ($_SESSION['pdf']==1 || (isset($_SESSION['logged_prof_generique']) && $autorisation_pdf==1))
{

if ($_SESSION['pdf']==1)
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
$afficher_dialogue=1;
$nom_de_la_fenetre="Export PDF";
include('menu_outil.php');
}
elseif (isset($_SESSION['logged_prof_generique']) && $autorisation_pdf==1)
{
//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_mes_modules=0;
$afficher_mes_heures=0;
$afficher_bilan_par_formation=0;
$afficher_giseh=0;
$afficher_flux_rss=0;
$afficher_ma_config=0;
$afficher_occupation_des_salles=0;
$afficher_dialogue=0;
$nom_de_la_fenetre="Export PDF";
include('menu_outil.php');
}
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
	<input type="hidden" name="jour" id="jours2_retour" value="<?php echo $jour_jour_j; ?>">
	
	 </form><br><br>
	 
	

<form  enctype="multipart/form-data" action="pdf_generateur.php" method="get">

	<input type="hidden" name="lar" id="screen_w2" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi2" value="<?php echo $hau; ?>">
	<input type="hidden" name="selec_prof" id="selec_pr2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_grou2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_sa2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_ma2" value="<?php echo $selec_materiel; ?>">
		<input type="hidden" name="current_week" id="current_w2" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_y2" value="<?php echo $current_year; ?>">
				<input type="hidden" name="horiz" id="ho2" value="<?php echo $horizon; ?>">
				<input type="hidden" name="hideprobleme" id="hideprobleme" value="<?php echo $hideprobleme; ?>">
				<input type="hidden" name="hideprivate" id="hideprivate" value="<?php echo $hideprivate; ?>">				
				
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
	<span style="font-size:16px;  font-weight:bold;">Export PDF de la vue <?php if ($horizon==0) {echo "verticale";} elseif ($horizon==1) {echo "horizontale";} elseif ($horizon==2 || $horizon==4) {echo "mensuelle"; } elseif ($horizon==3) {echo "jour J"; }?></span><br><br>
<?php
	if ($hideprobleme==1 && $hideprivate==1)
					{
					echo '<span style="font-size:12px;font-style:italic;  font-weight:bold;">Les éventuels conflits et les réservations ne sont pas affichés sur ce planning</span> <br><br>';
					}
					elseif ($hideprobleme==0 && $hideprivate==1)
					{
					echo '<span style="font-size:12px;font-style:italic;  font-weight:bold;">Les réservations ne sont pas affichées sur ce planning</span> <br><br>';
					}
					elseif ($hideprobleme==1 && $hideprivate==0)
					{
					echo '<span style="font-size:12px;font-style:italic;  font-weight:bold;">Les éventuels conflits ne sont pas affichés sur ce planning</span> <br><br>';
					}
					else
					{
					echo '<span style="font-size:12px;font-style:italic;  font-weight:bold;">Les éventuels conflits et les réservations sont affichés sur ce planning</span> <br><br>';
				
					}
	
	?>
	Titre (facultatif) : <input name="titre" id="titre" type="text" value="" maxlength="150" size="30"><br>	
<br>
Date de début : <input name="datedebut" id="datedeb" type="text" value="<?php echo $date_du_debut; ?>" maxlength="10" size="10"><br>	
<br>
Date de fin : <input name="datefin" id="datefin" type="text" value="<?php echo $date_de_fin; ?>" maxlength="10" size="10"><br>	
<br>
Format du papier : <select name="format">
<option value="A4" selected>A4</option>
<option value="A3">A3</option>
</select>
<br>		
	
	
<script type="text/javascript">

    Calendar.setup({

        inputField     :    "datedeb",   // id of the input field

        ifFormat       :    "%d-%m-%Y",       // format of the input field

        daFormat	   :   "%d-%m-%Y",

		showsTime      :    false,

        timeFormat     :    "24",

		align 		: "Tc"



    });

</script>	
	
<script type="text/javascript">

    Calendar.setup({

        inputField     :    "datefin",   // id of the input field

        ifFormat       :    "%d-%m-%Y",       // format of the input field

        daFormat	   :   "%d-%m-%Y",

		showsTime      :    false,

        timeFormat     :    "24",

		align 		: "Tc"



    });

</script>		
	

<br>

	<input type="hidden" name="jour" id="jours2" value="<?php echo $jour_jour_j; ?>">
		<input type="hidden" name="pdf_prof" id="pdfprof" value="1">
<input name="" value="Export en PDF" type="submit">
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



<?php
//version étudiant

if (isset($_SESSION['loggedstudent']))
{
if ($_SESSION['loggedstudent']!="")
{

//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_mes_ds=1;
$afficher_mes_modules=1;
$afficher_flux_rss=1;
$afficher_export_pdf=0;
$afficher_ics=1;


$nom_de_la_fenetre="Export PDF";
include('menu_outil_etudiant.php');


?>


<div style="text-align:center;width:100%;">

<?php //retour à l'edt
?>
<form name="form2" id="form2" action="index.php" method="get" >


	<input type="hidden" name="lar" id="screen_wid" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_heig" value="<?php echo $hau; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">
<input type="hidden" name="horiz"  value="<?php echo $horizon; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour_jour_j; ?>">
	

	 </form><br><br>
	 
	
<?php

?>	

<form  enctype="multipart/form-data" action="pdf_generateur.php" method="get">
	<input type="hidden" name="lar" id="screen_wid2bis" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_heig2bis" value="<?php echo $hau; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">
<input type="hidden" name="horiz"  value="<?php echo $horizon; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour_jour_j; ?>">
	

Date de début : <input name="datedebut" id="datedebu" type="text" value="<?php echo $date_du_debut; ?>" maxlength="10" size="10"><br>	
<br>
Date de fin : <input name="datefin" id="datefi" type="text" value="<?php echo $date_de_fin; ?>" maxlength="10" size="10"><br>	
<br>
Format du papier : <select name="format">
<option value="A4" selected>A4</option>
<option value="A3">A3</option>
</select>
<br>		
	
	
<script type="text/javascript">

    Calendar.setup({

        inputField     :    "datedebu",   // id of the input field

        ifFormat       :    "%d-%m-%Y",       // format of the input field

        daFormat	   :   "%d-%m-%Y",

		showsTime      :    false,

        timeFormat     :    "24",

		align 		: "Tc"



    });

</script>	
	
<script type="text/javascript">

    Calendar.setup({

        inputField     :    "datefi",   // id of the input field

        ifFormat       :    "%d-%m-%Y",       // format of the input field

        daFormat	   :   "%d-%m-%Y",

		showsTime      :    false,

        timeFormat     :    "24",

		align 		: "Tc"



    });

</script>		
	

<br>

	
		<input type="hidden" name="pdf_etudiant" id="pdfetudiant" value="1">
<input name="" value="Export en PDF" type="submit">
	</form>
	
	
	
	
	
</div>
<?php
}


else
{




echo 'Vous avez été déconnectée. Cliquez <a style="color:#0000EE" href="index.php">ICI </a> pour retourner à la page principale ';



}
}

?>










</body>
</html>


