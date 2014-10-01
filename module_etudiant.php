<?php

session_start();

include("config.php");
error_reporting(E_ALL);
//r�cup�ration de variables

$lar=$_GET['lar'];
$hau=$_GET['hau'];
$current_year=$_GET['current_year'];
$current_week=$_GET['current_week'];

if(isset($_GET['horiz']))
{
 $horizon=$_GET['horiz'];
}
else 
{
$horizon=1;
}

if(isset($_GET['jour']))
{
 $jour=$_GET['jour'];
}
else 
{
$jour=0;
}

if(isset($_GET['classement']))
{
 $classement=$_GET['classement'];
}
else 
{
$classement="chrono";
}
if(!isset($_GET['disconnect']))
{
$_GET['disconnect']="";
}
if(isset($_GET['code_seance']))
{
 $code_de_la_seance=$_GET['code_seance'];
}
else 
{
$code_de_la_seance=0;
}
if (isset ($_GET['annee_scolaire']))
{
$annee_scolaire_choisie=$_GET['annee_scolaire'];
}
else 
{
$annee_scolaire_choisie=$nbdebdd-1;
}

if (isset($_GET['current_student']))
{
$current_student=$_GET['current_student'];
}
//initialisation variables
$nom_prof_avant="";
$nom_groupe_avant="";
$nom_salle_avant="";
$nom_type_seance_avant="";
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
<link rel="stylesheet" href="css/module_etudiant.css" type="text/css" >


</head>

<body  style="margin: 0px;">
<?php

if (isset($_SESSION['loggedstudent']))
{
if ($_SESSION['loggedstudent']!="")
{


//bandeau du haut	

//bandeau du haut
//outils qu'il est possible d'afficher
$afficher_mes_ds=1;
$afficher_mes_modules=0;
$afficher_flux_rss=1;
$afficher_export_pdf=1;
$afficher_ics=1;


$nom_de_la_fenetre="Mes modules";
include('menu_outil_etudiant.php');

?>



			
			
			
			
<div style="text-align:center;width:100%;">


<?php //retour � l'edt
?>


<form name="form2" id="form2" action="index.php" method="get" >


	
	<input type="hidden" name="lar" id="screen_w" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hi" value="<?php echo $hau; ?>">
	<input type="hidden" name="horiz" id="horiz" value="<?php echo $horizon; ?>">
		<input type="hidden" name="current_week" id="current_we" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_ye" value="<?php echo $current_year; ?>">
				<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
<input type="hidden" name="current_student" value="<?php echo $current_student ?>">
	<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	
	 </form>	<br>
	 
	 



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







	
	 
<form name="form" id="form" action="module_etudiant.php" method="get" >
<p>Ann�e scolaire : <select name="annee_scolaire" onchange="document.form.submit();" >
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
	Modules : 

	
	<select name="selec_module" onchange="document.form.submit();"> 


<?php
// Pour tous les groupes dont l'etudiant fait partie

$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes2=$dbh->prepare($sql);
$req_groupes2->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes2->fetchAll();

$critere=" (";
foreach($res_groupe as $res_groupes)
{
 $critere .= "seances_groupes.codeRessource='".$res_groupes['codeGroupe']."' OR ";
}


$critere .= "0)";







		$sql="SELECT * FROM seances_groupes WHERE  deleted='0' and ".$critere;
		
		$req_seance_groupe=$dbh->query($sql);
	
		$res_seance_groupe=$req_seance_groupe->fetchAll();
	



 $condition1="";

	foreach ($res_seance_groupe as $res1)
    {
	
	$condition1=$condition1." codeSeance='".$res1['codeSeance']."' or";
	
	}
$condition1=$condition1." codeSeance='bidon' and";




$sql="SELECT distinct (codeEnseignement)  FROM seances WHERE ".$condition1." deleted='0'";
$req_seance_groupe2=$dbh->query($sql);
$res_seance_groupe2=$req_seance_groupe2->fetchAll();




$liste_enseignement = array();
$i='0';
//preparation des requetes pour boucles suivantes
$sql="SELECT * FROM enseignements WHERE  deleted='0' and codeEnseignement=:enseignement";
$req_seance_groupe2=$dbh->prepare($sql);


foreach ($res_seance_groupe2 as $res2)
    {
	$enseignement=$res2['codeEnseignement'];

$req_seance_groupe2->execute(array(':enseignement'=>$enseignement));
$res_seance_groupe2=$req_seance_groupe2->fetchAll();	

	

		$enseignement_explode=explode("_",$res_seance_groupe2['0']['nom']);

	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		

  if( ! in_array($nom_enseignement,$liste_enseignement))
		{
		$liste_enseignement[$i] = $nom_enseignement;
		$i+=1;
		}

	
	}
	

asort($liste_enseignement);

foreach ($liste_enseignement as $key => $val)
 {
   
	
     echo '<option value="'.$val.'"';
	if (isset($_GET['selec_module']))
	{
    if ($val==$_GET['selec_module'])
{
        echo " SELECTED";
}
}
    echo '>'.$val.'</option>';
}
   

?>
    </select><br><br>
	
	<input type="hidden" name="lar" id="screen_wi" value="<?php echo $lar; ?>">
	<input type="hidden" name="hau" id="screen_hei" value="<?php echo $hau; ?>">
		<input type="hidden" name="horiz" id="horiz" value="<?php echo $horizon; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
		<input type="hidden" name="current_week" id="current_wee" value="<?php echo $current_week; ?>">
				<input type="hidden" name="current_year" id="current_yea" value="<?php echo $current_year; ?>">
				<?php

	
		
		
		
	if(isset($_GET['classement']))
{
$classe=$_GET['classement'];
		echo '<input type="hidden" name="classement" value="'.$classe.'">';
	}	
		?>
	
	
	
	<input type="hidden" name="current_student" id="current_student" value="<?php echo $current_student; ?>">
		
	<input name="" value="Envoyer" type="submit">
	 </form>	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 



	Cliquez sur l'intitul� des colonnes pour changer de type de classement.<br><br>


	
	


	
	
	
	
<?php












if (isset ($_GET['selec_module']) )
{
?>
	<table>

<tr>

<?php
$lien="module_etudiant.php?&lar=".$lar."&hau=".$hau."&current_week=".$current_week."&current_year=".$current_year;



$lien.=	"&selec_module=".$_GET['selec_module'];

$lien.="&code_seance=".$code_de_la_seance;
$lien.="&current_student=".$current_student;
$lien.="&annee_scolaire=".$annee_scolaire_choisie;


?>

			

<th align="center" bgcolor="black" ><a href="<?php echo $lien."&classement=chrono" ?>"><font color="white" ><?php if ($classement=="chrono") echo "> " ?>Date</font></a></th>
<th align="center" bgcolor="black"><a href="<?php echo $lien."&classement=groupe" ?>"><font color="white" ><?php if ($classement=="groupe") echo "> " ?>Groupes</font></a></th>
<th align="center" bgcolor="black"><a href="<?php echo $lien."&classement=type" ?>"><font color="white" ><?php if ($classement=="type") echo "> " ?>Type</font></a></th>
<th align="center" bgcolor="black"><font color="white" >Enseignement</font></th>
<th align="center" bgcolor="black"><a href="<?php echo $lien."&classement=prof" ?>"><font color="white" ><?php if ($classement=="prof") echo "> " ?>Profs</font></a></th>
<th align="center" bgcolor="black"><a href="<?php echo $lien."&classement=salle" ?>"><font color="white" ><?php if ($classement=="salle") echo "> " ?>Salles</font></a></th>
<th align="center" bgcolor="black"><font color="white" >Heure de d�but</font></th>
<th align="center" bgcolor="black"><font color="white" >Dur�e</font></th>
<th align="center" bgcolor="black"><font color="white" >Effectu�e</font></th>

</tr>

<?php
}




if (isset ($_GET['selec_module']))
{
$bgcolor="white";
$nom_module=$_GET['selec_module']."\_"; // j'ai mis un \ devant le _ afin d'echapper le caract�re

//classement par salle
if($classement=="salle")
{
$sql="SELECT *,  enseignements.nom as nom_enseignement,seances.dureeSeance as seanceDuree, seances.commentaire as seancesCommentaire FROM seances LEFT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) LEFT JOIN (seances_salles) ON (seances_salles.codeSeance=seances.codeSeance)  LEFT JOIN (ressources_salles) ON (seances_salles.codeRessource=ressources_salles.codeSalle)   WHERE  ressources_salles.deleted='0'  and  seances_salles.deleted='0' and seances.deleted='0' and seances.codeSeance!=''  AND enseignements.deleted='0' and enseignements.nom like :nom_module order by  ressources_salles.nom,seances.dateSeance,seances.heureSeance ";	
}


//classement par prof
elseif($classement=="prof")
{
$sql="SELECT *, enseignements.nom as nom_enseignement,seances.dureeSeance as seanceDuree, seances.commentaire as seancesCommentaire FROM seances LEFT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) LEFT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance)  LEFT JOIN (ressources_profs) ON (seances_profs.codeRessource=ressources_profs.codeProf)   WHERE  ressources_profs.deleted='0' and  seances_profs.deleted='0' and  seances.deleted='0' and seances.codeSeance!=''  AND enseignements.deleted='0' and enseignements.nom like :nom_module order by  ressources_profs.nom,seances.dateSeance,seances.heureSeance ";	
}

//classement par groupe
elseif($classement=="groupe")
{
$sql="SELECT *,  enseignements.nom as nom_enseignement,seances.dureeSeance as seanceDuree, seances.commentaire as seancesCommentaire FROM seances LEFT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) LEFT JOIN (seances_groupes) ON (seances_groupes.codeSeance=seances.codeSeance)  LEFT JOIN (ressources_groupes) ON (seances_groupes.codeRessource=ressources_groupes.codeGroupe)  WHERE  ressources_groupes.deleted='0' and  seances_groupes.deleted='0' and seances.deleted='0' and seances.codeSeance!=''  AND enseignements.deleted='0' and enseignements.nom like :nom_module order by  ressources_groupes.nom,seances.dateSeance,seances.heureSeance ";	
}

//classement par type
elseif ($classement=="type")
{
$sql="SELECT *,  enseignements.nom as nom_enseignement,seances.dureeSeance as seanceDuree, seances.commentaire as seancesCommentaire FROM seances LEFT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement)   where seances.deleted='0' and seances.codeSeance!=''  AND enseignements.deleted='0' and enseignements.nom like :nom_module order by enseignements.codeTypeActivite,seances.dateSeance,seances.heureSeance ";	
}

//classement par ordre chronomogique
else
{
$sql="SELECT *,  enseignements.nom as nom_enseignement,seances.dureeSeance as seanceDuree, seances.commentaire as seancesCommentaire FROM seances LEFT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement)   where seances.deleted='0' and seances.codeSeance!=''  AND enseignements.deleted='0' and enseignements.nom like :nom_module order by seances.dateSeance,seances.heureSeance ";	
}

$req4=$dbh->prepare($sql);
$req4->execute(array(':nom_module'=>$nom_module."%"));
$res_4=$req4->fetchAll();
//preparation des requetes des boucles suiantes
$sql="SELECT * from seances_profs left join ressources_profs on (seances_profs.codeRessource=ressources_profs.codeProf) WHERE seances_profs.codeSeance=:code_seance and seances_profs.deleted='0' and ressources_profs.deleted='0' order by ressources_profs.nom"; 
$req5=$dbh->prepare($sql);
$sql="SELECT * from ressources_profs WHERE codeProf=:code_prof and deleted='0'"; 
$req6=$dbh->prepare($sql);			
$sql="SELECT * from seances_salles left join ressources_salles on (seances_salles.codeRessource=ressources_salles.codeSalle)  WHERE seances_salles.codeSeance=:code_seance and seances_salles.deleted='0' and ressources_salles.deleted='0' order by ressources_salles.nom";
$req7=$dbh->prepare($sql);			
$sql="SELECT * from ressources_salles WHERE codeSalle=:code_salle and deleted='0'"; 
$req8=$dbh->prepare($sql);			
$sql="SELECT * from seances_groupes left join ressources_groupes on (seances_groupes.codeRessource=ressources_groupes.codeGroupe) WHERE seances_groupes.codeSeance=:code_seance and seances_groupes.deleted='0' and ressources_groupes.deleted='0' order by ressources_groupes.nom" ;
$req9=$dbh->prepare($sql);			
$sql="SELECT * from ressources_groupes WHERE codeGroupe=:code_groupe and deleted='0'";
$req10=$dbh->prepare($sql);	


//initialisation de la variable qui v�rifie si on a d�j� trac� le trait de s�paration entre les s�naces pass�es et futures et si des s�ances pass�es existent
$trait_dessine="0";
$seance_passe_existe="0";


	foreach ($res_4 as $res4)	
    {
	//mise en forme de la date
		$annee=substr($res4['dateSeance'],0,4);
		$mois=substr($res4['dateSeance'],5,2);
		$jour=substr($res4['dateSeance'],8,2);
		$nom_jour=date("l", mktime(0, 0, 0, $mois, $jour, $annee));
		//traduction francais du nom du jour
		if ($nom_jour=='Monday')
			{
			$nom_jour='Lundi';
			}
		if ($nom_jour=='Tuesday')
			{
			$nom_jour='Mardi';
			}
		if ($nom_jour=='Wednesday')
			{
			$nom_jour='Mercredi';
			}
		if ($nom_jour=='Thursday')
			{
			$nom_jour='Jeudi';
			}
		if ($nom_jour=='Friday')
			{
			$nom_jour='Vendredi';
			}
		if ($nom_jour=='Saturday')
			{
			$nom_jour='Samedi';
			}
		if ($nom_jour=='Sunday')
			{
			$nom_jour='Dimanche';
			}
	// type de seance
	

	
	unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res4['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$nom_type_seance = $res_type['alias'];
	}	
	
//association d'une couleur au type de s�ance

$couleur_tp = '#a9fcad';
$couleur_td = '#f9fca9';
$couleur_cr ='#b5a9fc';
$couleur_ds = '#fca9a9';
$couleur_defaut ='#e1ffe1';
$couleur_pro = '#ffc800';
$couleur_jur = '#40e0d0';

	


      if ($res4['codeTypeActivite']==2)

        {

            $couleur = $couleur_td;

        }



        elseif ($res4['codeTypeActivite']==1)

        {

            $couleur = $couleur_cr;

        }



        elseif ($res4['codeTypeActivite']==3)

        {

            $couleur = $couleur_tp;

        }



        elseif ($res4['codeTypeActivite']==9)

        {

            $couleur = $couleur_ds;

        }



        elseif ($res4['codeTypeActivite']==4)

        {

            $couleur = $couleur_pro;

        }



        else

        {

            $couleur = $couleur_defaut;

        }
	
	
	
	
	// enseignement
	$type=explode("_",$res4['nom_enseignement']);
	$enseignement=$type[1];
	
	//mise en forme de la duree des seances
		
	if (strlen($res4['seanceDuree'])==4)
		{
			$heureduree=substr($res4['seanceDuree'],0,2);
			$minduree=substr($res4['seanceDuree'],2,2);
		}
	if (strlen($res4['seanceDuree'])==3)
		{
			$heureduree=substr($res4['seanceDuree'],0,1);
			$minduree=substr($res4['seanceDuree'],1,2);

		}
	if (strlen($res4['seanceDuree'])==2)
		{
			$heureduree=0;
			$minduree=$res4['seanceDuree'];
		}
	if (strlen($heureduree)==1)
		{
			$heureduree="0".$heureduree;
		}	
	$duree=$heureduree."h".$minduree;
	
	//mise en forme de l'heure de d�but des seances
		
	
				if (strlen($res4['heureSeance'])==4)
					{
						$heuredebut=substr($res4['heureSeance'],0,2);
						$mindebut=substr($res4['heureSeance'],2,2);
					}
				if (strlen($res4['heureSeance'])==3)
					{
						$heuredebut=substr($res4['heureSeance'],0,1);
						$mindebut=substr($res4['heureSeance'],1,2);

					}
				if (strlen($res4['heureSeance'])==2)
					{
						$heuredebut=0;
						$mindebut=$res4['heureSeance'];
					}
				if (strlen($heuredebut)==1)
					{
						$heuredebut="0".$heuredebut;
						
					}
	$heure=$heuredebut."h".$mindebut;	
	
	//recherche du prof associ� � la seance
$code_seance=$res4['codeSeance'];
if($classement!="prof")
{
$req5->execute(array(':code_seance'=>$code_seance));
$res_5=$req5->fetchAll();
	
	$nom_prof="";
	$compteur_prof=1;
	foreach ($res_5 as $res5)
	{
	
	$code_prof=$res5['codeRessource'];
	$req6->execute(array(':code_prof'=>$code_prof));
$res_6=$req6->fetchAll();	
	
	foreach ($res_6 as $res6)

		{
		$nom=ucwords(strtolower($res6['prenom'])) ;



		$nom_prof=$nom_prof.$nom." ".$res6['nom'];
			if(count($res_5)>$compteur_prof)
			{
			$nom_prof.=" - ";
			}
		$compteur_prof+=1;	
		}
	}
}
else
{

		$nom=ucwords(strtolower($res4['prenom'])) ;


		$nom_prof=$nom." ".$res4['nom']." ";

}



	//recherche de la salle associ�e � la seance
if($classement!="salle")
{
	$nom_salle="";
$req7->execute(array(':code_seance'=>$code_seance));
$res_7=$req7->fetchAll();
	foreach ($res_7 as $res7)
	
	{
	$code_salle=$res7['codeRessource'];
	
$req8->execute(array(':code_salle'=>$code_salle));
$res_8=$req8->fetchAll();	
	
	
	
	foreach ($res_8 as $res8)
		{
		$nom_salle=$nom_salle.$res8['nom']." ";
		
		}
	}
	
}
else
{
$nom_salle=$res4['nom'];
}	

	
//date du jour actuel pour tracer un trait de s�paration entre les s�ances pass�es et les s�ances futures.
$date_actuelle=date('Y').date('m').date('d');
$date_seance=$annee.$mois.$jour;
	
		//recherche du groupe associ�e � la seance
		
if($classement!="groupe")
{
$req9->execute(array(':code_seance'=>$code_seance));
$res_9=$req9->fetchAll();	
	

	$nom_groupe="";
	foreach ($res_9 as $res9)
	{
	$code_groupe=$res9['codeRessource'];

$req10->execute(array(':code_groupe'=>$code_groupe));
$res_10=$req10->fetchAll();	

	
	
	foreach ($res_10 as $res10)
		{
		$nom_groupe=$nom_groupe.$res10['nom']." ";
		
		}
	}
}
else
{
$nom_groupe=$res4['nom'];
}
	
//Commence chaque ligne par tr si classment chronologique
if ($classement=="chrono")
{
echo "<tr>";
}
	
	
//test si changement de prof pour tracer le trait bleu de s�paration lors du classement par prof
if ($classement=="prof")
{
	if ($nom_prof_avant!=$nom_prof && $classement=="prof" && $nom_prof_avant!="")
	{
	?>
	<tr style="border-top:blue 5px solid">
	<?php
	$nom_prof_avant=$nom_prof;
	}
	else
	{
	$nom_prof_avant=$nom_prof;
	echo "<tr>";
	}	
}

//test si changement de groupe pour tracer le trait bleu de s�paration lors du classement par groupe
if ($classement=="groupe")
{
	if ($nom_groupe_avant!=$nom_groupe && $classement=="groupe" && $nom_groupe_avant!="")
	{
	?>
	<tr style="border-top:blue 5px solid">
	<?php
	$nom_groupe_avant=$nom_groupe;
	}
	else
	{
	$nom_groupe_avant=$nom_groupe;
	echo "<tr>";
	}	
}
	
//test si changement de salle pour tracer le trait bleu de s�paration lors du classement par salle
if ($classement=="salle")
{
	if ($nom_salle_avant!=$nom_salle && $classement=="salle" && $nom_salle_avant!="")
	{
	?>
	<tr style="border-top:blue 5px solid">
	<?php
	$nom_salle_avant=$nom_salle;
	}
	else
	{
	$nom_salle_avant=$nom_salle;
	echo "<tr>";
	}	
}
	
//test si changement de type pour tracer le trait bleu de s�paration lors du classement par type
if ($classement=="type")
{
	if ($nom_type_seance_avant!=$nom_type_seance && $classement=="type" && $nom_type_seance_avant!="")
	{
	?>
	<tr style="border-top:blue 5px solid">
	<?php
	$nom_type_seance_avant=$nom_type_seance;
	}
	else
	{
	$nom_type_seance_avant=$nom_type_seance;
	echo "<tr>";
	}		
}


if ($code_de_la_seance!=$res4['codeSeance'])
{
	
?>

	
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_jour." ".$jour."-".$mois."-".$annee; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($nom_groupe); ?></td>
		<td align="center" bgcolor="<?php echo $couleur; ?>"><?php echo stripslashes($nom_type_seance); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo stripslashes($enseignement); ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_prof; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $nom_salle; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $heure; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><?php echo $duree; ?></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:green; font-weight:bold;"><?php if ($date_actuelle>$date_seance){ echo "&#10003;";} else{ echo "";} ?></span></td>
		
	


	</tr>
<?php	
}
else
{

?>

	
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo $nom_jour." ".$jour."-".$mois."-".$annee; ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo stripslashes($nom_groupe); ?></span></td>
		<td align="center" bgcolor="<?php echo $couleur; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo stripslashes($nom_type_seance); ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo stripslashes($enseignement); ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo $nom_prof; ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo $nom_salle; ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo $heure; ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php echo $duree; ?></span></td>
		<td align="center" bgcolor="<?php echo $bgcolor; ?>"><span style="font-size:12px;color:blue; font-weight:bold;"><?php if ($date_actuelle>$date_seance){ echo "&#10003;";} else{ echo "";} ?></span></td>
	</tr>
<?php	
}
			if ($bgcolor=="white")
			{
				$bgcolor="silver";
			}
			else
			{
			$bgcolor="white";
			}

	}
	?>
</table><br>
<?php
	}	



}
}
else
{
echo 'Vous avez �t� d�connect�. Cliquez <a style="color:#0000EE" href="index.php">ICI </a> pour retourner � la page principale ';
}
?>
</div>
</body>

</html>
