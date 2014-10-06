<?php

//version qui permet d'afficher le bandeau des heures chaque jour s il y a au moins deux ressources de selectionnees





session_start();

include("config.php");







//recuperation de la largeur de l ecran a laquelle on enleve 50 pour que ca rentre en largeur dans firefox


$largeur=$_GET['lar']-50;

if ($largeur<750)
	{
	$largeur=750;
	}



//recuperation de la hauteur de l ecran a laquelle on enleve 295 pour que ca rentre en hauteur dans firefox

$hauteur=$_GET['hau']-210;

if ($hauteur<520)

{

$hauteur=520;

}




//activation ou non du mode debug

//si mode debug actif il faut changer dans url index.php par drawvtstudent.php

$debug=0;

if ($debug)

	{

	echo "Debug mode";

	error_reporting(E_ALL);

	}







	

//[GD] Définition de la variable d'environnement

putenv('GDFONTPATH=' . realpath('.').'/fonts/');



// Nom de la police à utiliser

$font = "verdana.ttf";

$fontb = "verdanab.ttf";





// On recopie les données GET


if (isset($_GET['current_week']) &&  $_GET['current_week']>0)

	$current_week = $_GET['current_week'];

else

	$current_week = date('W');





if(!isset($_GET['current_year'])  || $_GET['current_year']==0)

	$current_year=date("Y");

else

	$current_year=$_GET['current_year'];

$current_student=$_GET['current_student'];


//heure de début et de fin de journée
$starttime=$heure_debut_journee;
$endtime=$heure_fin_journee;

//heure de début et de fin de la pause de midi
$lunchstart=$heure_debut_pause_midi;
$lunchstop=$heure_fin_pause_midi;


// 1er lundi du mois



$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}
$jour_quelconque=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 
$jsem=date("w",$jour_quelconque);
$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem),$current_year); 

$datedujour=date("d",$lundi);


//normalement, il faut afficher 6 semaines pour être sûr d'avoir tout le temps les 30 ou 31 jours d'affichés en même temps or dans l'interface on n'affiche que 5 semaines.
//Normalement, si le 31 est un mardi, il faut afficher 6 semaines. idem si le 30 ou 31 sont un lundi. si c'est le cas, on affiche le mois suivant et $numerosemainedanslemois sera = à 0.
if ($datedujour==30 || $datedujour==31)
{
$numerosemainedanslemois=0;
}
else
{

$numerosemainedanslemois = intval($datedujour/7);
}


$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-($numerosemainedanslemois*7),$current_year); 

$datedujour=date("d",$lundi);

// pour les cas foireux par exemple mai2009

if ($datedujour>2 && $datedujour<22) 

{

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7),$current_year); 

//pour l affichage de la semaine courante dans une autre couleur j ai besoin de la ligne suivante

$numerosemainedanslemois=$numerosemainedanslemois+1;

}

$current_day=date("Y-m-d",$lundi);






	//nombre de groupes à afficher

$nbdegroupe=1;


//nombre de ressources a afficher
$nbressource=1;


//heures début et fin de journée et affichage du samedi ou du dimanche avec les logins perso prof quand on fait export pdf
if (isset($_GET['hdeb']))
{
$heure_debut_journee=$_GET['hdeb'];
$starttime = str_replace("_", ".", $heure_debut_journee);

}
if (isset($_GET['hfin']))
{
$heure_fin_journee=$_GET['hfin'];
$endtime = str_replace("_", ".", $heure_fin_journee);
}
if (isset($_GET['weekend']))
{
	if ($_GET['weekend']==0)
	{
	$samedi=0;
	$dimanche=0;
	}
	elseif ($_GET['weekend']==1)
	{
	$samedi=1;
	$dimanche=0;
	}
	else
	{
	$samedi=1;
	$dimanche=1;
	}
}

// Pour le calcul de la durée de traitement

$debut = explode(" ",microtime());

$debut = $debut[1]+$debut[0];





/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*                         Génération trame calendrier                       */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/



// [GD] On genere un png

if (!$debug) header ("Content-type: image/png");



// Largeur et hauteur des entêtes du calendrier20

$leftwidth=60;

$topheight=23;





// [GD] On crée l'image





$im = imagecreate ($largeur, $hauteur+($hauteur-$topheight)*($nbressource-1)+4*$topheight+20)

		or die ("Erreur lors de la création de l'image");





// [GD] Declaration des couleurs

$blanc = imagecolorallocate ($im, 255, 255, 255);

$noir = imagecolorallocate ($im, 0, 0, 0);

$gris = imagecolorallocate ($im, 200, 200, 200);

$grisclair = imagecolorallocate ($im, 225, 225, 225);

$couleur_vacances=imagecolorallocate ($im, 206, 243, 187);

$couleursemaineavtive=imagecolorallocate ($im, 104, 169, 248);



$couleur_TP = imagecolorallocate ($im, 169, 252, 173);

$couleur_TD = imagecolorallocate ($im, 249,252,169);

$couleur_CR = imagecolorallocate ($im, 181,169, 252);

$couleur_DS = imagecolorallocate ($im, 252, 169, 169);

$couleur_defaut = imagecolorallocate ($im, 255, 229, 255);

$couleur_pro = imagecolorallocate($im, 255, 200,0);

$couleur_jur = imagecolorallocate($im, 64, 224, 208);



$cours = imagecolorallocate ($im, 211, 255, 236);





$rdv[1] = imagecolorallocate ($im, 255, 187, 246);

$rdv[2] = imagecolorallocate ($im, 255, 222, 132);

$rdv[3] = imagecolorallocate ($im, 190, 132, 255);

$rdv[4] = imagecolorallocate ($im, 139, 255, 139);

$rdv[5] = imagecolorallocate ($im, 139, 172, 255);




// affichage des vacances scolaires 
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



	
	
	if ($samedi=='1' && $dimanche=='0')
		{
		
		$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);
$req_groupes->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes->fetchAll();


		//preparation requete
		$sql="SELECT * from calendriers_groupes where date=:current_day and codeRessource=:groupeaafficher and deleted='0'";
		$req_vacances_groupe=$dbh->prepare($sql);	
		$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
		$req_groupes_de_niveau_sup=$dbh->prepare($sql);
		
		
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							}
					
					
					if ($vacance!="")
						{
					if ($day>=0 && $day<=5)
					{
					imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/6), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/6), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=7 && $day<=12)
					{
					imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/6), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/6), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=14 && $day<=19)
					{
					imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/6), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/6), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=21 && $day<=26)
					{
					imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/6), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/6), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=28 && $day<=33)
					{
					imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/6), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/6), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			}
		}
	
	
	elseif ($dimanche=='1')
		{
		
		$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);
$req_groupes->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes->fetchAll();
		//preparation requete
		$sql="SELECT * from calendriers_groupes where date=:current_day and codeRessource=:groupeaafficher and deleted='0'";
		$req_vacances_groupe=$dbh->prepare($sql);	
		$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
		$req_groupes_de_niveau_sup=$dbh->prepare($sql);
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<=34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							}
					
					
					if ($vacance!="")
						{
					if ($day>=0 && $day<=6)
					{
					imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/7), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/7), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=7 && $day<=13)
					{
					imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/7), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/7), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=14 && $day<=20)
					{
					imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/7), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/7), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=21 && $day<=27)
					{
					imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/7), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/7), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=28 && $day<=34)
					{
					imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/7), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/7), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			}
		}	
	
	else
		{
		//preparation requete
		$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);
$req_groupes->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes->fetchAll();
		
		$sql="SELECT * from calendriers_groupes where date=:current_day and codeRessource=:groupeaafficher and deleted='0'";
		$req_vacances_groupe=$dbh->prepare($sql);	
		$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
		$req_groupes_de_niveau_sup=$dbh->prepare($sql);
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<=34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							}
					if ($vacance!="")
						{
					if ($day>=0 && $day<=4)
					{
					imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/5), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/5), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=7 && $day<=11)
					{
					imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/5), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/5), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=14 && $day<=18)
					{
					imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/5), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/5), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=21 && $day<=25)
					{
					imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/5), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/5), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
				if ($day>=28 && $day<=32)
					{
					imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/5), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/5), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
					}
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			}
		}
	
	
	
	
	
	
	

// affichage des jours fériés de la filière



//preparation requete
	$sql="SELECT * from calendriers_filieres where date=:current_day and deleted='0'";
	$req_vacances_filiere=$dbh->prepare($sql);	
	
	if ($samedi=='1' && $dimanche=='0')
	{

	
	for ($day=0;$day<=34;$day++)
		{
		$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
		$req_vacances_filiere->execute(array(':current_day'=>$current_day));
		$vacance=$req_vacances_filiere->fetchAll();
		foreach($vacance as $vacances)
			{
			if ($day>=0 && $day<=5)
				{
				imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/6), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/6), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=7 && $day<=12)
				{
				imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/6), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/6), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=14 && $day<=19)
				{
				imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/6), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/6), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=21 && $day<=26)
				{
				imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/6), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/6), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}	
			if ($day>=28 && $day<=33)
				{
				imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/6), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/6), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}					
			}
		}
		}
		
		
	elseif ($dimanche=='1')
	{

	
	for ($day=0;$day<=34;$day++)
		{
		$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
		$req_vacances_filiere->execute(array(':current_day'=>$current_day));
		$vacance=$req_vacances_filiere->fetchAll();
		foreach($vacance as $vacances)
			{
			if ($day>=0 && $day<=6)
				{
				imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/7), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/7), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=7 && $day<=13)
				{
				imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/7), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/7), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=14 && $day<=20)
				{
				imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/7), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/7), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=21 && $day<=27)
				{
				imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/7), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/7), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}	
			if ($day>=28 && $day<=34)
				{
				imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/7), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/7), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}						
			}
		}
		}		
		
		
	else
	{	

	for ($day=0;$day<=34;$day++)
		{
		$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
		$req_vacances_filiere->execute(array(':current_day'=>$current_day));
		$vacance=$req_vacances_filiere->fetchAll();
		foreach($vacance as $vacances)
			{
			if ($day>=0 && $day<=4)
				{
				imagefilledrectangle($im, $leftwidth+$day*(($largeur-$leftwidth)/5), $topheight, $leftwidth+($day+1)*(($largeur-$leftwidth)/5), $topheight+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=7 && $day<=11)
				{
				imagefilledrectangle($im, $leftwidth+($day-7)*(($largeur-$leftwidth)/5), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-6)*(($largeur-$leftwidth)/5), 2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=14 && $day<=18)
				{
				imagefilledrectangle($im, $leftwidth+($day-14)*(($largeur-$leftwidth)/5), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-13)*(($largeur-$leftwidth)/5), 3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}
			if ($day>=21 && $day<=25)
				{
				imagefilledrectangle($im, $leftwidth+($day-21)*(($largeur-$leftwidth)/5), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-20)*(($largeur-$leftwidth)/5), 4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}	
			if ($day>=28 && $day<=32)
				{
				imagefilledrectangle($im, $leftwidth+($day-28)*(($largeur-$leftwidth)/5), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+($day-27)*(($largeur-$leftwidth)/5), 5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+round((($hauteur-$topheight)*$nbressource)/5)/$nbressource, $couleur_vacances);
				}					
			}
		}
		}
			
	
	
	
	
	
	
	
	

}
// [GD] Création des polygones et mise en gris



$greycadre= array(0, 0, $largeur, 0, $largeur, $topheight, $leftwidth, $topheight, $leftwidth, $topheight+round((($hauteur-$topheight)*$nbressource)/5),$largeur,$topheight+round((($hauteur-$topheight)*$nbressource)/5),$largeur,2*$topheight+round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,2*$topheight+round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,2*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5),$largeur,2*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5),$largeur,3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,3*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)



,$largeur,3*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5),$largeur,4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,4*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5) 



,$largeur,4*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5),$largeur,5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5),$leftwidth,5*$topheight+5*round((($hauteur-$topheight)*$nbressource)/5) 





,0,5*$topheight+5*round((($hauteur-$topheight)*$nbressource)/5),0,0);

imagefilledpolygon ($im, $greycadre, 23, $gris);



//affichage d une autre couleur de la semaine actuelle

$premiere_semaine_du_mois=date("W",$lundi);
$annee_du_mois=date("o",$lundi);
$semaine_actuelle=date("W");
$annee_actuelle=date("o");
if ($semaine_actuelle>=$premiere_semaine_du_mois && $semaine_actuelle<=$premiere_semaine_du_mois+4 && $annee_du_mois==$annee_actuelle)
{
$date_du_jour=date("d");
$numero_semaine_dans_le_mois = intval($date_du_jour/7);

$redcadre= array(0,($numero_semaine_dans_le_mois)*($topheight+round((($hauteur-$topheight)*$nbressource)/5)),$largeur,($numero_semaine_dans_le_mois)*($topheight+round((($hauteur-$topheight)*$nbressource)/5)),$largeur,($numero_semaine_dans_le_mois)*($topheight+round((($hauteur-$topheight)*$nbressource)/5))+$topheight,$leftwidth,($numero_semaine_dans_le_mois)*($topheight+round((($hauteur-$topheight)*$nbressource)/5))+$topheight,$leftwidth,($numero_semaine_dans_le_mois+1)*($topheight+round((($hauteur-$topheight)*$nbressource)/5)),0,($numero_semaine_dans_le_mois+1)*($topheight+round((($hauteur-$topheight)*$nbressource)/5)),0,($numero_semaine_dans_le_mois)*($topheight+round((($hauteur-$topheight)*$nbressource)/5)));

imagefilledpolygon ($im, $redcadre, 7, $couleursemaineavtive);
}


// [GD] pause de midi

if ($lunchstart>$starttime)
	{
	//pour chaque semaine
	for($f=1;$f<=5;$f++)
		{
		//transformation en pourcentage de l'heure de début et de fin de la pause de midi
		$start_time=abs($lunchstart-$starttime)/($endtime-$starttime+0.25);
		$end_time=abs($lunchstop-$starttime)/($endtime-$starttime+0.25);
		//pour chaque ressource
		for($i=0;$i<$nbressource;$i++)
			{
			//coordonnées de la zone à griser.
			$topy = $f*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($f-1)*round(($hauteur-$topheight)*$nbressource/5); 
			$bottomy = $f*$topheight +$end_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($f-1)*round(($hauteur-$topheight)*$nbressource/5); 
			$leftx = $leftwidth ; 
			$rightx = $largeur ; 
			//dessin de la zone
			imagefilledrectangle($im, $leftx ,$topy , $rightx, $bottomy, $grisclair);	
			}
		}
	}


// [GD] On affiche les heures

$currenttime=$starttime;

$nbintervalles=round(($endtime-$starttime)/0.25)+1;

for($i=0;$i<=$nbintervalles-1;$i++)

	{
for($j=0;$j<=4;$j++)
{
	imageline ($im, $leftwidth+1, ($j+1)*$topheight+$j*round(($hauteur-$topheight)/5)+((($hauteur-$topheight)/5)/$nbintervalles)*$i, $largeur , ($j+1)*$topheight+$j*round(($hauteur-$topheight)/5)+((($hauteur-$topheight)/5)/$nbintervalles)*$i, $gris);
	//imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource,  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource, IMG_COLOR_STYLED);

	if (!($i%4))

		imagestring ($im, 2, 30, ($j+1)*$topheight+$j*round(($hauteur-$topheight)/5)+((($hauteur-$topheight)/5)/$nbintervalles)*$i-5, substr(intval($currenttime)+100,-2,2).":".substr(($currenttime-intval($currenttime))*60+100,-2,2), $noir);

	

	}
	$currenttime+=0.25;
}





















// [GD] Dessin du trait de droite


imageline ($im,  $largeur-1, 0, $largeur-1, 5*$topheight+($hauteur-$topheight)*$nbressource, $noir);



// [GD] On trace les lignes, on met les jours

if ($samedi=='1' && $dimanche=='0')

	{

	for($i=0;$i<=4;$i++)

		{

		imageline ($im, 0, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

		//separation en pointillet entre les ressources

		for($numeroressource=1;$numeroressource<$nbressource;$numeroressource++)

		{	

		$style = array($noir, $noir, $noir, $noir, $noir, $blanc, $blanc, $blanc, $blanc, $blanc);

imagesetstyle($im, $style);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource,  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource, IMG_COLOR_STYLED);

}



		$policejour=8;

		

		$size=imagettfbbox ($policejour , 0, $font, "Lundi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Lundi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	





		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+(($largeur-$leftwidth)/6)*1, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mardi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/6)*1, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/6)*1, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+(($largeur-$leftwidth)/6)*2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mercredi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/6)*2, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/6)*2, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Jeudi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+(($largeur-$leftwidth)/6)*3, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Jeudi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/6)*3, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/6)*3, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);		



		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+(($largeur-$leftwidth)/6)*4, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Vendredi");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/6)*4, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/6)*4, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Samedi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+(($largeur-$leftwidth)/6)*5, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Samedi");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/6)*5, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/6)*5, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		}

	}	

elseif ( $dimanche=='1')

	{

	for($i=0;$i<=4;$i++)

		{

		imageline ($im, 0, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

		//separation en pointillet entre les ressources

		for($numeroressource=1;$numeroressource<$nbressource;$numeroressource++)

		{	

		$style = array($noir, $noir, $noir, $noir, $noir, $blanc, $blanc, $blanc, $blanc, $blanc);

imagesetstyle($im, $style);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource,  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource, IMG_COLOR_STYLED);

}



		$policejour=8;

		

		$size=imagettfbbox ($policejour , 0, $font, "Lundi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Lundi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	





		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*1, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mardi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*1, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*1, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mercredi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*2, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*2, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Jeudi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*3, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Jeudi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*3, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*3, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);		



		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*4, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Vendredi");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*4, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*4, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Samedi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*5, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Samedi");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*5, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*5, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	


		$size=imagettfbbox ($policejour , 0, $font, "Dimanche");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+(($largeur-$leftwidth)/7)*6, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Dimanche");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/7)*6, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/7)*6, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		}

	}		

else

	{

	for($i=0;$i<=4;$i++)

		{

		imageline ($im, 0, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, $i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5),  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir);

				//separation en pointillet entre les ressources

		for($numeroressource=1;$numeroressource<$nbressource;$numeroressource++)

		{	

		$style = array($noir, $noir, $noir, $noir, $noir, $blanc, $blanc, $blanc, $blanc, $blanc);

imagesetstyle($im, $style);

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource,  $largeur, ($i+1)*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5)+$numeroressource*round(($hauteur-$topheight)*$nbressource/5)/$nbressource, IMG_COLOR_STYLED);

}





		$policejour=8;

		

		$size=imagettfbbox ($policejour , 0, $font, "Lundi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Lundi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	





		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+(($largeur-$leftwidth)/5)*1, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mardi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/5)*1, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/5)*1, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+(($largeur-$leftwidth)/5)*2, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Mercredi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/5)*2, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/5)*2, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	



		$size=imagettfbbox ($policejour , 0, $font, "Jeudi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+(($largeur-$leftwidth)/5)*3, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Jeudi");

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/5)*3, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/5)*3, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);		



		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, $policejour,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+(($largeur-$leftwidth)/5)*4, $topheight-3*($topheight-$box_width)/4+$i*$topheight+$i*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, "Vendredi");	

		//trait vertical à gauche du jour

		imageline ($im, $leftwidth+(($largeur-$leftwidth)/5)*4, ($i+1)*$topheight+$i*round((($hauteur-$topheight)*$nbressource)/5), $leftwidth+(($largeur-$leftwidth)/5)*4, ($i+1)*$topheight+($i+1)*round((($hauteur-$topheight)*$nbressource)/5), $noir);	







		}

	}		

	



	



		

if ($samedi=='1' && $dimanche=='0')

	{	

	//date semaine 1

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+0*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+1*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+2*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+3*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+4*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+5 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+5*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+5 day",$lundi)));

	

	//date semaine 2

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+7 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+0*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+7 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+8 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+1*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+8 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+9 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+2*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+9 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+10 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+3*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+10 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+11 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+4*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+11 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+12 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+5*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+12 day",$lundi)));

	

		//date semaine 3

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+14 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+0*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+14 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+15 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+1*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+15 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+16 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+2*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+16 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+17 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+3*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+17 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+18 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+4*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+18 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+19 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+5*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+19 day",$lundi)));

	

		//date semaine 4

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+21 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+0*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+21 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+22 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+1*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+22 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+23 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+2*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+23 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+24 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+3*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+24 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+25 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+4*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+25 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+26 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+5*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+26 day",$lundi)));

	

	

	

		//date semaine 5

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+28 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+0*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+28 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+29 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+1*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+29 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+30 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+2*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+30 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+31 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+3*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+31 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+32 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+4*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+32 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+33 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/6) -$box_lenght)/2+5*(($largeur-$leftwidth)/6), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+33 day",$lundi)));	

	

	//noumbre de jour à afficher par semaine

	$days='6';

}

elseif ($dimanche=='1')

	{	

	//date semaine 1

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+0*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+1*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+2*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+3*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+4*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+5 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+5*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+5 day",$lundi)));

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+6 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+6*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+6 day",$lundi)));

		

	//date semaine 2

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+7 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+0*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+7 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+8 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+1*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+8 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+9 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+2*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+9 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+10 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+3*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+10 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+11 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+4*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+11 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+12 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+5*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+12 day",$lundi)));

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+13 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+6*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+13 day",$lundi)));


		//date semaine 3

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+14 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+0*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+14 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+15 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+1*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+15 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+16 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+2*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+16 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+17 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+3*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+17 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+18 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+4*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+18 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+19 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+5*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+19 day",$lundi)));

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+20 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+6*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+20 day",$lundi)));

	

		//date semaine 4

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+21 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+0*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+21 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+22 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+1*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+22 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+23 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+2*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+23 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+24 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+3*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+24 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+25 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+4*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+25 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+26 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+5*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+26 day",$lundi)));

	
			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+27 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+6*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+27 day",$lundi)));


	

	

		//date semaine 5

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+28 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+0*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+28 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+29 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+1*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+29 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+30 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+2*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+30 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+31 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+3*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+31 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+32 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+4*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+32 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+33 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+5*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+33 day",$lundi)));	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+34 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/7) -$box_lenght)/2+6*(($largeur-$leftwidth)/7), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+34 day",$lundi)));	
	

	//noumbre de jour à afficher par semaine

	$days='7';

}

else

	{	

	//date semaine 1

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+0*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+1*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+2*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+3*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+4*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+0*$topheight+0*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	



	

	//date semaine 2

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+7 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+0*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+7 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+8 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+1*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+8 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+9 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+2*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+9 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+10 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+3*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+10 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+11 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+4*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+1*$topheight+1*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+11 day",$lundi)));

	



	

		//date semaine 3

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+14 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+0*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+14 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+15 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+1*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+15 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+15 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+2*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+15 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+17 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+3*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+17 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+18 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+4*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+2*$topheight+2*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+18 day",$lundi)));

	



	

		//date semaine 4

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+21 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+0*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+21 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+22 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+1*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+22 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+23 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+2*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+23 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+24 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+3*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+24 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+25 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+4*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+3*$topheight+3*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+25 day",$lundi)));

	

	



		//date semaine 5

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+28 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+0*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+28 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+29 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+1*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+29 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+30 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+2*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+30 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+31 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+3*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+31 day",$lundi)));

	

			$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+32 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,0,$leftwidth+( (($largeur-$leftwidth)/5) -$box_lenght)/2+4*(($largeur-$leftwidth)/5), $topheight-1*($topheight-$box_width)/4+4*$topheight+4*round(($hauteur-$topheight)*$nbressource/5), $noir,$font, date("d/m",strtotime("+32 day",$lundi)));

	

//noumbre de jour à afficher par semaine

	$days='5';

}







//on affiche le numero de la semaine dans la zone grise

$numerodelapremieresemainedumois=$current_week-$numerosemainedanslemois;

	for ($k=1;$k<=5;$k++)

	{

	$text="Semaine ".$numerodelapremieresemainedumois;

	$size=imagettfbbox (7 , 0, $font, $text);

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];



	imagettftext ($im, 7,90,1*$leftwidth/4+$box_width/2, ($k-1)*(($hauteur-$topheight)*$nbressource/5+$topheight)+((($hauteur-$topheight)*$nbressource/5)+$topheight-$box_lenght)/2+$box_lenght, $noir,$font, $text);

	$numerodelapremieresemainedumois+=1;

	
    }	


//on affiche à quoi correspondent les congés des groupes ( exam, stage...)


	if ($samedi=='1' && $dimanche=='0')
		{
//preparation requete
//requete déjà préparé avec les vacances  des groupes
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
		
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							
							if ($vacance_groupes['date']!="")
							{
							if ($vacance_groupes['etat']==2)
							{
							$text="Congé";
							}
							elseif ($vacance_groupes['etat']==3)
							{
							$text="Examen";
							}
							elseif ($vacance_groupes['etat']==5)
							{
							$text="Stage / Entreprise";
							}	
							else
							{
							$text="";
							}							
							$size=imagettfbbox (10 , 0, $fontb, $text);

							$box_lenght=$size[2]-$size[0];

							$box_width=$size[1]-$size[7];
							
							}
					}
					
					if ($vacance!="")
						{
					if ($day>=0 && $day<=5)
					{
					imagettftext ($im, 10, 0,$leftwidth+$day*(($largeur-$leftwidth)/6)+(($largeur-$leftwidth)/6)/2  -$box_lenght/2   ,1*$topheight+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
				if ($day>=7 && $day<=12)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-7)*(($largeur-$leftwidth)/6)+(($largeur-$leftwidth)/6)/2  -$box_lenght/2    ,2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);

					}
				if ($day>=14 && $day<=19)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-14)*(($largeur-$leftwidth)/6)+(($largeur-$leftwidth)/6)/2  -$box_lenght/2     ,3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
					
				if ($day>=21 && $day<=26)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-21)*(($largeur-$leftwidth)/6)+(($largeur-$leftwidth)/6)/2  -$box_lenght/2   ,4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
				if ($day>=28 && $day<=33)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-28)*(($largeur-$leftwidth)/6)+(($largeur-$leftwidth)/6)/2  -$box_lenght/2  ,5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			
		}
	}
	
	elseif ($dimanche=='1')
		{
//preparation requete
//requete déjà préparé avec les vacances  des groupes
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<=34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							if ($vacance_groupes['date']!="")
							{
							if ($vacance_groupes['etat']==2)
							{
							$text="Congé";
							}
							elseif ($vacance_groupes['etat']==3)
							{
							$text="Examen";
							}
							elseif ($vacance_groupes['etat']==5)
							{
							$text="Stage / Entreprise";
							}	
							else
							{
							$text="";
							}							
							$size=imagettfbbox (10 , 0, $fontb, $text);

							$box_lenght=$size[2]-$size[0];

							$box_width=$size[1]-$size[7];
							}}
					
					
									if ($vacance!="")
						{
					if ($day>=0 && $day<=5)
					{
					imagettftext ($im, 10, 0,$leftwidth+$day*(($largeur-$leftwidth)/7)+(($largeur-$leftwidth)/7)/2  -$box_lenght/2   ,1*$topheight+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
				if ($day>=7 && $day<=12)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-7)*(($largeur-$leftwidth)/7)+(($largeur-$leftwidth)/7)/2  -$box_lenght/2    ,2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);

					}
				if ($day>=14 && $day<=19)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-14)*(($largeur-$leftwidth)/7)+(($largeur-$leftwidth)/7)/2  -$box_lenght/2     ,3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
					
				if ($day>=21 && $day<=26)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-21)*(($largeur-$leftwidth)/7)+(($largeur-$leftwidth)/7)/2  -$box_lenght/2   ,4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
				if ($day>=28 && $day<=33)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-28)*(($largeur-$leftwidth)/7)+(($largeur-$leftwidth)/7)/2  -$box_lenght/2  ,5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			}
		}	
	
	else
		{
//preparation requete
//requete déjà préparé avec les vacances  des groupes
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
			$stop=0;
			while ($stop!=1)
				{
				for ($day=0;$day<=34;$day++)
					{
					$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
					$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
					$vacance_groupe=$req_vacances_groupe->fetchAll();
					$vacance="";
					foreach ($vacance_groupe as $vacance_groupes)
							{
							$vacance=$vacance_groupes;
							if ($vacance_groupes['date']!="")
							{
							if ($vacance_groupes['etat']==2)
							{
							$text="Congé";
							}
							elseif ($vacance_groupes['etat']==3)
							{
							$text="Examen";
							}
							elseif ($vacance_groupes['etat']==5)
							{
							$text="Stage / Entreprise";
							}	
							else
							{
							$text="";
							}							
							$size=imagettfbbox (10 , 0, $fontb, $text);

							$box_lenght=$size[2]-$size[0];

							$box_width=$size[1]-$size[7];
							}}
									if ($vacance!="")
						{
					
					if ($day>=0 && $day<=5)
					{
					imagettftext ($im, 10, 0,$leftwidth+$day*(($largeur-$leftwidth)/5)+(($largeur-$leftwidth)/5)/2  -$box_lenght/2   ,1*$topheight+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
						
				if ($day>=7 && $day<=12)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-7)*(($largeur-$leftwidth)/5)+(($largeur-$leftwidth)/5)/2  -$box_lenght/2    ,2*$topheight+round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);

					}
					
				if ($day>=14 && $day<=19)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-14)*(($largeur-$leftwidth)/5)+(($largeur-$leftwidth)/5)/2  -$box_lenght/2     ,3*$topheight+2*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
					
				if ($day>=21 && $day<=26)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-21)*(($largeur-$leftwidth)/5)+(($largeur-$leftwidth)/5)/2  -$box_lenght/2  ,4*$topheight+3*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
					
					}
					
				if ($day>=28 && $day<=33)
					{
					imagettftext ($im, 10, 0,$leftwidth+($day-28)*(($largeur-$leftwidth)/5)+(($largeur-$leftwidth)/5)/2  -$box_lenght/2  ,5*$topheight+4*round((($hauteur-$topheight)*$nbressource)/5)+ round((((($hauteur-$topheight)*$nbressource)/5)/$nbressource)/2)+$box_width/2  , $noir, $fontb, $text);
				
					}
					
						}
					}
				

					$req_groupes_de_niveau_sup->execute(array(':groupeaafficher'=>$groupeaafficher));
					$res_groupes_de_niveau_sup=$req_groupes_de_niveau_sup->fetchAll();
					if (count($res_groupes_de_niveau_sup)>0)
						{
						foreach ($res_groupes_de_niveau_sup as $groupe_de_niveau_sup)
							{
							$groupeaafficher=$groupe_de_niveau_sup['codeRessource'];
							}
						}
					else 
						{
						$stop=1;		
						}				
				}
			}
		}
	
	
	
/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*                                Affichage cours  GROUPES                   */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

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
//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs1=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
$req_groupes2=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 and ressources_salles.deleted='0' order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMateriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0  and ressources_materiels.deleted='0' order by ressources_materiels.nom";
$req_materiels=$dbh->prepare($sql);

// Pour tous les groupes dont l'etudiant fait partie

$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes2=$dbh->prepare($sql);
$req_groupes2->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes2->fetchAll();

$critere="AND (";
foreach($res_groupe as $res_groupes)
{
 $critere .= "seances_groupes.codeRessource='".$res_groupes['codeGroupe']."' OR ";
}


$critere .= "0)";


//preparation des requetes des boucles suivantes
if ($diffusable==1)
{
$sql="SELECT *, seances.dureeSeance, seances.commentaire,matieres.couleurFond, enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement  FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) left join matieres on enseignements.codeMatiere=matieres.codeMatiere WHERE matieres.deleted=0 and seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
$req_seance=$dbh->prepare($sql);
}
else
{
$sql="SELECT *, seances.dureeSeance, seances.commentaire,matieres.couleurFond, enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement)  left join matieres on (enseignements.codeMatiere=matieres.codeMatiere) WHERE matieres.deleted=0 and seances.dateSeance=:current_day AND seances.deleted=0 AND seances.diffusable=1 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
$req_seance=$dbh->prepare($sql);
}



// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
//	unset($req_seance);
	//$sql="SELECT *, seances.dureeSeance, seances.commentaire, matieres.couleurFond, enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement  FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement)  left join matieres on (enseignements.codeMatiere=matieres.codeMatiere) WHERE matieres.deleted=0 and seances.dateSeance=:current_day AND seances.deleted=0 AND seances.diffusable=1 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
	//$req_seance=$dbh->prepare($sql);	
	$req_seance->execute(array(':current_day'=>$current_day));
	$res_seances=$req_seance->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)

		{



		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/



		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);




		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
	



// numero de la semaine dans le mois

if	($day>=0 && $day<=6)

		$numsemaine='1';

if	($day>=7 && $day<=13)

		$numsemaine='2';

if	($day>=14 && $day<=20)

		$numsemaine='3';

if	($day>=21 && $day<=27)

		$numsemaine='4';

if	($day>=28 && $day<=34)

		$numsemaine='5';

		

		

	// On calcule les coordonnées du rectangle :



		/*

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		*/
		
		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		

$req_groupes->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes->fetchAll();
$dechex="FFFFFF"; //couleur par défaut : blanc




		// [GD] On trace la case correspondante
		//recuperation de la couleur associee au groupe ou à la matiere ou au prof et conversion en rvb
if ($couleur_des_seances_groupe_prof==0) // si couleur des groupes
{
foreach($res_groupe as $res_groupes)
	{
$dechex=dechex($res_groupes['couleurFond']);
}
}
elseif ($couleur_des_seances_groupe_prof==1) // si couleur des matieres
{
$dechex=dechex($res_seance['couleurFond']);
}
elseif ($couleur_des_seances_groupe_prof==2) // si couleur des matieres
{
$req_profs1->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs1->fetchAll();
foreach($res_prof as $res_profs)
	{
	$dechex=dechex($res_profs['couleurFond']);
	}
unset ($res_prof);
}
else
{
$dechex=dechex($res_groupes['couleurFond']);
}

        while (strlen($dechex)<6) {

        $dechex = "0".$dechex;

        }





	//dessiner un rectangle avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins
//couleur
$couleur = imagecolorallocate ($im, hexdec(substr($dechex,-2,2)), hexdec(substr($dechex,-4,2)), hexdec(substr($dechex,-6,2)));
//valeur du rayon
$ray=2;

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx+2,$topy+$ray,$rightx-2,$bottomy-$ray,$couleur);
		imagefilledrectangle($im,$leftx+2+$ray,$topy,$rightx-2-$ray,$bottomy,$couleur);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+2+$ray, $topy+$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $leftx+2+$ray, $bottomy-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-2-$ray, $bottomy-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-2-$ray, $topy+$ray, $ray*2, $ray*2, $couleur);
	
		imagearc($im, $leftx+2+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+2+$ray, $bottomy-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-2-$ray, $bottomy-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-2-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);
	
			//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+2+$ray, $topy,$rightx-2-$ray, $topy, $noir);
		imageline($im, $leftx+2+$ray, $bottomy,$rightx-2-$ray, $bottomy, $noir);
		imageline($im, $leftx+2, $topy+$ray,$leftx+2, $bottomy-$ray, $noir);
		imageline($im, $rightx-2, $topy+$ray,$rightx-2, $bottomy-$ray, $noir);



		
	

		// On compte le nombre d'elements dans la case

		

		// on met deja nbelement egal 1 pour le nom de la matiere

		$nbelements=1;



		// On compte le nombre de profs a afficher
$req_profs1->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs1->fetchAll();
		
		
			if (count($res_prof)>=1)
				{
				$nbelements+=count($res_prof);
				}
		$nbprof=count($res_prof);



		// On compte le nombre de salles a afficher
		$req_salles->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles->fetchAll();		
		


		if (count($res_salle))
			{
			//on affiche les salles sur 1 seule ligne donc nbelement +1

			$nbelements+=1;
			}
		$nbsalle=count($res_salle);

		// On compte le nombre de materiels a afficher
		$req_materiels->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_materiel=$req_materiels->fetchAll();		
		


		if (count($res_materiel))
			{
			//on affiche les materiels sur 1 seule ligne donc nbelement +1

			$nbelements+=1;
			}
		$nbmateriel=count($res_materiel);			
		
		
		// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

			$resaname=strtoupper($resaname);

		

			$compteur_ligne='0';

			if($res_seance['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*10/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*10/92);

						

						}

					

					$compteur_ligne=1;

					



	while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*10/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

													}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*10/92);

							}

						elseif ($dernier_espace<1000)

						{

						$compteur_ligne=$compteur_ligne+1;

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

												

						}			

						}

					}

				else					

					{

					$compteur_ligne=1;

					}

			$nbelements+=$compteur_ligne;	

			}



		

		



//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	

if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}

			
	


	unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$text = $res_type['alias']."-";
	}
 
		










		//on affiche le nom de la seance

			//dix caracteres ont une longueur de 92px

        $cursename=substr($cursename[1],0,round((($largeur-$leftwidth)/$days)*10/100)-1);

		$size=imagettfbbox (9 , 0, $fontb, $text.$cursename);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , ($bottomy + $topy) / 2 +11 -9 * ($nbelements/2) , $noir, $fontb, $text.$cursename);

		$position=($bottomy + $topy) / 2 +11- 9 * ($nbelements/2)+9;







		// [GD] On affiche les commentaires sur la seance

	

	// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

			$resaname=strtoupper($resaname);

			

			if($res_seance['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*10/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*10/92);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=9;

						}

					else

					{	

					$chaine2=substr($resaname,0,$dernier_espace);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=9;

					}

								

					while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*10/92))

							{

							$chaine2=substr($resaname,$dernier_espace);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

												

							imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=9;

						$dernier_espace=2000;

						

							}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000 )

							{

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*10/92);

							$size=imagettfbbox (7 , 0, $font, $chaine2);

							$box_lenght=$size[2]-$size[0];

							

							imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=9;

							}

						elseif ($dernier_espace<1000)

						{

						

						

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

						

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=9;

						

						}			

						}

					}

				else

					{

					$size=imagettfbbox (7 , 0, $font, $resaname);

					$box_lenght=$size[2]-$size[0];

					imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $resaname);

					$position+=9;

					}

	

			}

	



	

	

		// [GD] On affiche les profs concernés
foreach ($res_prof as $res_profs)


			{

			if ($res_profs['nom']!="")

				{

	

				$size=imagettfbbox (8 , 0, $font, substr($res_profs['nom'],0,round((($largeur-$leftwidth)/$days)*10/92)-1));

				$box_lenght=$size[2]-$size[0];

				$box_width=$size[1]-$size[7];

				imagettftext ($im, 8, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position  , $noir, $font, substr($res_profs['nom'],0,round((($largeur-$leftwidth)/$days)*10/92)-1));

				$position+=9;

				}



			}

			

			

		// [GD] On affiche les salles

		$nbsalles=0;

		unset($salles);

		$salles="";



		foreach ($res_salle as $res_salles)

			{

			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}

			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
			{
			 if ($nbsalles==1)
				 {
				 $salles="Salle : ".$salles;
				 }
			  
			 if($nbsalles>1)
				 {
				 $salles="Salles : ".$salles;
				 }
			}
			
			
			

			$size=imagettfbbox (7 , 0, $font, $salles);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position-4, $noir, $font, $salles);
		
		// [GD] On affiche les materiels
$position+=10;
		$nbmateriels=0;

		unset($materiels);

		$materiels="";



		foreach ($res_materiel as $res_materiels)

			{

			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}

			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
			{
			 if ($nbmateriels==1)
				 {
				 $materiels="Materiel : ".$materiels;
				 }
			  
			 if($nbmateriels>1)
				 {
				 $materiels="Materiels : ".$materiels;
				 }
			}
			
			
			

			$size=imagettfbbox (7 , 0, $font, $materiels);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position-2, $noir, $font, $materiels);

	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		}

	}



	
	
	}

	
	
	


/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*                                Affichage reservation  groupes             */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/	

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

// Pour tous les groupes dont l'etudiant fait partie

$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes4=$dbh->prepare($sql);
$req_groupes4->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes4->fetchAll();


$critere="AND (";
foreach($res_groupe as $res_groupes)
   {
   $critere .= "reservations_groupes.codeRessource='".$res_groupes['codeGroupe']."' OR ";
   }
$critere .= "0)";



//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);






// Pour les 35 jours de la vue, on interroge la DB

for ($day=0;$day<35;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));


	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances
		unset ($req_resa);
		$sql="SELECT *, reservations.dureeReservation, reservations.commentaire FROM reservations_groupes LEFT JOIN (reservations) ON (reservations_groupes.codereservation=reservations.codereservation)  WHERE reservations.datereservation=:current_day AND reservations.deleted=0 ".$critere." AND reservations_groupes.deleted=0  ";
		$req_resa=$dbh->prepare($sql);	
		$req_resa->execute(array(':current_day'=>$current_day));
		$res_resas=$req_resa->fetchAll();



		// Pour chaque réservation

		foreach($res_resas as $res_resa)

		{



			// On convertit l'horaire en %age de la journée


			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);


			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



// numero de la semaine dans le mois

if	($day>=0 && $day<=6)

		$numsemaine='1';

if	($day>=7 && $day<=13)

		$numsemaine='2';

if	($day>=14 && $day<=20)

		$numsemaine='3';

if	($day>=21 && $day<=27)

		$numsemaine='4';

if	($day>=28 && $day<=34)

		$numsemaine='5';

		

		

	// On calcule les coordonnées du rectangle :



		
		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+10 ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 

			
		

		//dessiner un rectangle avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins
$ray=2;

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx+2,$topy+$ray,$rightx-2,$bottomy-$ray,$rdv[1]);
		imagefilledrectangle($im,$leftx+2+$ray,$topy,$rightx-2-$ray,$bottomy,$rdv[1]);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+2+$ray, $topy+$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $leftx+2+$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-2-$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-2-$ray, $topy+$ray, $ray*2, $ray*2, $rdv[1]);
	
		imagearc($im, $leftx+2+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+2+$ray, $bottomy-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-2-$ray, $bottomy-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-2-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);			
			//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+2+$ray, $topy,$rightx-2-$ray, $topy, $noir);
		imageline($im, $leftx+2+$ray, $bottomy,$rightx-2-$ray, $bottomy, $noir);
		imageline($im, $leftx+2, $topy+$ray,$leftx+2, $bottomy-$ray, $noir);
		imageline($im, $rightx-2, $topy+$ray,$rightx-2, $bottomy-$ray, $noir);	


	// recherche si une salle est associée à la réservation
$req_resa_salle->execute(array(':codeReservation'=>$res_resa['codeReservation']));
$res_resa_salles=$req_resa_salle->fetchAll();
$nb_resa_salle=0;
$nom_resa_salle="";
foreach($res_resa_salles as $res_resa_salle)
	{
	if ($nb_resa_salle>0)
		{
		$nom_resa_salle.=", ";
		}
	$nb_resa_salle++;
	
	if ($nom_salle_afficher_alias==1)
	{
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}		
	
	
	}
	
	
//affichage du mot "salle" devant la liste des salles
if ($affichage_mot_salle_pour_prof=='1')
{
 if ($nb_resa_salle==1)
	 {
	 $nom_resa_salle="Salle : ".$nom_resa_salle;
	 }
  
 if($nb_resa_salle>1)
	 {
	 $nom_resa_salle="Salles : ".$nom_resa_salle;
	 }
}		

			

		// comptage des lignes a afficher pour la reservation

		// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_resa['commentaire']);

			$resaname=strtoupper($resaname);

		

			$compteur_ligne='0';

			if($res_resa['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*10/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*10/92);

						

						}

					

					$compteur_ligne=1;

					



					while ($dernier_espace<strlen($res_resa['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace+1,round((($largeur-$leftwidth)/$days)*10/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*10/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

								}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*10/92);

							}

						elseif ($dernier_espace<1000)

						{

						$compteur_ligne=$compteur_ligne+1;

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

												

						}			

						}

					}

				else					

					{

					$compteur_ligne=1;

					}
			if  ($nb_resa_salle>0)
			{
			$compteur_ligne+=1;
			}
			

			}				

			

			

			//On affiche le titre de la reservation

			// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_resa['commentaire']);

			$resaname=strtoupper($resaname);

			

			//coordonnees en y de la premiere ligne

			
$position=($bottomy + $topy) / 2 +10- 10 * ($compteur_ligne/2);
			

			

			if($res_resa['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*10/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*10/92);

						$size=imagettfbbox (9 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=10;

						}

					else

					{	

					$chaine2=substr($resaname,0,$dernier_espace);

						$size=imagettfbbox (9 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=10;

					}

								

					while ($dernier_espace<strlen($res_resa['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*10/92))

							{

							$chaine2=substr($resaname,$dernier_espace);

						$size=imagettfbbox (9 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

												

							imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=10;

						$dernier_espace=2000;

						

							}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000 )

							{

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*10/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*10/92);

							$size=imagettfbbox (9 , 0, $fontb, $chaine2);

							$box_lenght=$size[2]-$size[0];

							

							imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=10;

							}

						elseif ($dernier_espace<1000)

						{

						

						

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

						$size=imagettfbbox (9 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

						

						imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=10;

						

						}			

						}

					}

				else

					{

					$size=imagettfbbox (9 , 0, $fontb, $resaname);

					$box_lenght=$size[2]-$size[0];

					imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $resaname);

					$position+=10;

					}

			//affichage de la salle associée à la réservation	
 if ($nb_resa_salle>0)
	 {		
			$size=imagettfbbox (7 , 0, $font,  $nom_resa_salle);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position, $noir, $font,  $nom_resa_salle);
	

			}
			
			}

		
		
		
		
		
		
		
		



		}

		}



	





}

	
















// [GD] On dessine un cadre autour de l'EDT



imagerectangle ($im, 0, 0, $largeur , 5*$topheight+5*round((($hauteur-$topheight)*$nbressource)/5), $noir);





// Calcul du temps d'execution du script

$fin = explode(" ",microtime());

$fin = $fin[1]+$fin[0];

$temps_passe = $fin-$debut;



// [GD] Affichage durée execution



imagestring($im, 1, ($largeur-94)/2, 5*$topheight+($hauteur-$topheight)*$nbressource+5, "Généré le ".date("d/m/Y"). " a " .date("H:i:s"). " en ".number_format($temps_passe,3)."s", $noir);









// [GD] Generation de l'image

if (!$debug) ImagePng ($im);

?>