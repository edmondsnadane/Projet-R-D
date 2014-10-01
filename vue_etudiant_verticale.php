<?php

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


// 1er Jour de la semaine

$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 

$jsem=date("w",$lundi);

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem),$current_year); 

$current_day=date("Y-m-d",$lundi);

	


//nombre de groupes à afficher

$nbdegroupe=1;



//nombre de ressources a afficher

$nbressource=1;


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



// Largeur et hauteur des entêtes du calendrier

$leftwidth=30;

$topheight=40;





// [GD] On crée l'image

// le 75 sert pour inclure la legende sous l edt

$im = imagecreate ($largeur, $hauteur+($hauteur-$topheight)*($nbressource-1)+75)

		or die ("Erreur lors de la création de l'image");



// [GD] Declaration des couleurs

$blanc = imagecolorallocate ($im, 255, 255, 255);

$noir = imagecolorallocate ($im, 0, 0, 0);

$gris = imagecolorallocate ($im, 200, 200, 200);

$grisclair = imagecolorallocate ($im, 225, 225, 225);

$couleur_vacances=imagecolorallocate ($im, 206, 243, 187);



$couleur_TP = imagecolorallocate ($im, 169, 252, 173);

$couleur_TD = imagecolorallocate ($im, 249,252,169);

$couleur_CR = imagecolorallocate ($im, 181,169, 252);

$couleur_DS = imagecolorallocate ($im, 252, 169, 169);

$couleur_defaut = imagecolorallocate ($im, 30, 255, 30);

$couleur_pro = imagecolorallocate($im, 255, 200,0);

$couleur_jur = imagecolorallocate($im, 64, 224, 208);



$cours = imagecolorallocate ($im, 211, 255, 236);





$rdv[1] = imagecolorallocate ($im, 255, 187, 246);

$rdv[2] = imagecolorallocate ($im, 255, 222, 132);

$rdv[3] = imagecolorallocate ($im, 190, 132, 255);

$rdv[4] = imagecolorallocate ($im, 255, 255, 0);

$rdv[5] = imagecolorallocate ($im, 139, 172, 255);



// [GD] Création des polygones et mise en gris



$greycadre= array(0, 0, $largeur, 0, $largeur, $topheight, $leftwidth, $topheight, $leftwidth, $topheight+($hauteur-$topheight)*$nbressource, 0, $topheight+($hauteur-$topheight)*$nbressource, 0, 0);

imagefilledpolygon ($im, $greycadre, 7, $gris);



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



// affichage des vacances scolaires des groupes

	// affichage des vacances scolaires des groupes

	if ($samedi=='1' && $dimanche=='0')
		{
		$days='6';
		}
	elseif ( $dimanche=='1')
		{
		$days='7';
		}
	else
		{
		$days='5';
		}
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
			for ($day=0;$day<$days;$day++)
				{
				$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
				$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
				$vacance_groupe=$req_vacances_groupe->fetchAll();
				if (count($vacance_groupe)>0)
					{
					foreach ($vacance_groupe as $vacance_groupes)
						{
						if ($vacance_groupes['date']!="")
							{
							if ($days==6)
								{
								imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/6*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/6*($day+1)), $couleur_vacances);
								}
								
							elseif ($days==7)
								{
								imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/7*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/7*($day+1)), $couleur_vacances);
								}
							else
								{	
								imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/5*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/5*($day+1)), $couleur_vacances);	
								}
							}
		
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
		
	
	
	

// affichage des jours fériés de la filière


	if ($samedi=='1' && $dimanche=='0')
		{
		$days='6';
		}
	elseif ( $dimanche=='1')
		{
		$days='7';
		}
	else
		{
		$days='5';
		}
//preparation requete
	$sql="SELECT * from calendriers_filieres where date=:current_day and deleted='0'";
	$req_vacances_filiere=$dbh->prepare($sql);	
		for ($day=0;$day<$days;$day++)
		{
		$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
		$req_vacances_filiere->execute(array(':current_day'=>$current_day));
		$vacance=$req_vacances_filiere->fetchAll();
		
		foreach($vacance as $vacances)
			{
				if ($days==6)
				{
				imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/6*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/6*($day+1)), $couleur_vacances);
				}
				
				elseif ($days==7)
				{
				imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/7*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/7*($day+1)), $couleur_vacances);
				}				
			else
				{
				imagefilledrectangle($im, $leftwidth,$topheight+round(($hauteur-$topheight)*$nbressource/5*$day),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/5*($day+1)), $couleur_vacances);	
				}
			}
		}
		
	
	
}

// [GD] pause de midi



	if ($lunchstart>$starttime)

	imagefilledrectangle($im, abs($lunchstart-$starttime)/($endtime-$starttime+0.25)*($largeur-$leftwidth)+$leftwidth , $topheight+1, abs($lunchstop-$starttime)/($endtime-$starttime+0.25)*($largeur-$leftwidth)+$leftwidth,  $topheight+( $hauteur-$topheight)*$nbressource, $grisclair);	


// [GD] Dessin du trait de droite

imageline ($im,  $largeur-1, 0, $largeur-1, $topheight+($hauteur-$topheight)*$nbressource, $noir);

// [GD] Dessin du deuxieme trait de gauche

imageline ($im,  $leftwidth+1, $topheight, $leftwidth+1, $topheight+($hauteur-$topheight)*$nbressource, $noir);



// [GD] On affiche les heures

$currenttime=$starttime;

$nbintervalles=round(($endtime-$starttime)/0.25)+1;

for($i=0;$i<=$nbintervalles-1;$i++)

	{

	

		imageline ($im, $leftwidth+round((($largeur-$leftwidth)/$nbintervalles)*$i), $topheight, $leftwidth+round((($largeur-$leftwidth)/$nbintervalles)*$i), $topheight+($hauteur-$topheight)*$nbressource-1, $gris);

	

	

	if (!($i%2))

	$policeheure=8;

	$size=imagettfbbox ($policeheure , 0, $font, "xxhxx");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policeheure,90,$leftwidth+(($largeur-$leftwidth)/$nbintervalles)*$i+$box_width/2, $topheight-3, $noir,$font, substr(intval($currenttime)+100,-2,2).":".substr(($currenttime-intval($currenttime))*60+100,-2,2));

	



	$currenttime+=0.25;

	}







// [GD] On trace les lignes, on met les jours



if ($samedi=='1' && $dimanche=='0')

	{

	for($i=0;$i<=5;$i++)

		imageline ($im, 0, $topheight+round(($hauteur-$topheight)*$nbressource/6*$i),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/6*$i), $noir);

	

	$policejour=8;

	$size=imagettfbbox ($policejour , 0, $font, "Lundi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+0*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Lundi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+1*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Mardi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+2*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Mercredi");

	

		$size=imagettfbbox ($policejour , 0, $font, "jeudi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+3*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Jeudi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+4*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Vendredi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Samedi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+5*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, "Samedi");

	

	

	

	

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+0*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+1*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+2*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+3*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+4*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+5 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,3*$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/6)/2)+5*(($hauteur-$topheight)*$nbressource/6)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+5 day",$lundi)));

	$days=6;

	}


elseif ($dimanche=='1')

	{

	for($i=0;$i<=6;$i++)

		imageline ($im, 0, $topheight+round(($hauteur-$topheight)*$nbressource/7*$i),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/7*$i), $noir);

	

	$policejour=6;

	$size=imagettfbbox ($policejour , 0, $font, "Lundi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+0*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font,"Lundi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+1*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Mardi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+2*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Mercredi");

	

		$size=imagettfbbox ($policejour , 0, $font, "jeudi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+3*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Jeudi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+4*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Vendredi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Samedi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+5*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Samedi");

			$size=imagettfbbox ($policejour , 0, $font, "Dimanche");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+6*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, "Dimanche");

	

	

	

	

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+0*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+1*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+2*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+3*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+4*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+5 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+5*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+5 day",$lundi)));

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+6 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/7)/2)+6*(($hauteur-$topheight)*$nbressource/7)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+6 day",$lundi)));
	
	
	
	$days=7;

	}

	
else

	{

	for($i=0;$i<=4;$i++)

	imageline ($im, 0, $topheight+round(($hauteur-$topheight)*$nbressource/5*$i),  $largeur, $topheight+round(($hauteur-$topheight)*$nbressource/5*$i), $noir);



	$policejour=8;

	$size=imagettfbbox ($policejour , 0, $font, "Lundi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+0*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, "Lundi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mardi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+1*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, "Mardi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Mercredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+2*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, "Mercredi");

	

		$size=imagettfbbox ($policejour , 0, $font, "jeudi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+3*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, "Jeudi");

	

		$size=imagettfbbox ($policejour , 0, $font, "Vendredi");

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policejour,90,$leftwidth/4+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+4*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, "Vendredi");

		

		$policedate=8;

	$size=imagettfbbox ($policedate , 0, $font, date("d/m",$lundi));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+0*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, date("d/m",$lundi));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+1 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+1*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+1 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+2 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+2*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+2 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+3 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+3*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+3 day",$lundi)));

	

		$size=imagettfbbox ($policedate , 0, $font, date("d/m",strtotime("+4 day",$lundi)));

	$box_lenght=$size[2]-$size[0];

	$box_width=$size[1]-$size[7];

	imagettftext ($im, $policedate,90,$leftwidth/2+$box_width/2, $topheight+((($hauteur-$topheight)*$nbressource/5)/2)+4*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2, $noir,$font, date("d/m",strtotime("+4 day",$lundi)));

	



	$days=5;

	}
	
	
//on affiche à quoi correspondent les congés des groupes ( exam, stage...)

	if ($samedi=='1' && $dimanche=='0')
		{
		$days='6';
		}
	elseif ( $dimanche=='1')
		{
		$days='7';
		}
	else
		{
		$days='5';
		}
//preparation requete
//requete déjà préparée avec les vacances  des groupes
foreach($res_groupe as $res_groupes)
    {
		$groupeaafficher=$res_groupes['codeGroupe'];
		$stop=0;
		while ($stop!=1)
			{
			for ($day=0;$day<$days;$day++)
				{
				$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
				$req_vacances_groupe->execute(array(':current_day'=>$current_day,':groupeaafficher'=>$groupeaafficher));
				$vacance_groupe=$req_vacances_groupe->fetchAll();
				if (count($vacance_groupe)>0)
					{
					foreach ($vacance_groupe as $vacance_groupes)
						{
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
							$size=imagettfbbox (18 , 0, $fontb, $text);

							$box_lenght=$size[2]-$size[0];

							$box_width=$size[1]-$size[7];
							
							
							
							
							if ($days==6)
								{
								imagettftext ($im, 18, 0,$leftwidth+($largeur-$leftwidth)/2  -$box_lenght/2   ,$topheight+round(($hauteur-$topheight)/6*$day)+ round((($hauteur-$topheight)/6)/2)+$box_width/2  , $noir, $fontb, $text);
								}
								
							elseif ($days==7)
								{
								imagettftext ($im, 18, 0,$leftwidth+($largeur-$leftwidth)/2  -$box_lenght/2   ,$topheight+round(($hauteur-$topheight)/7*$day)+ round((($hauteur-$topheight)/7)/2)+$box_width/2  , $noir, $fontb, $text);
								
								}
							else
								{	
								imagettftext ($im, 18, 0,$leftwidth+($largeur-$leftwidth)/2  -$box_lenght/2   ,$topheight+round(($hauteur-$topheight)/5*$day)+ round((($hauteur-$topheight)/5)/2)+$box_width/2  , $noir, $fontb, $text);	
								}
							}
		
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

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0'  order by ressources_profs.nom";
$req_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 and ressources_salles.deleted='0' order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
$req_groupes2=$dbh->prepare($sql);

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

for ($day=0;$day<$days;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
	//unset($req_seance);
	//$sql="SELECT *, seances.dureeSeance, seances.commentaire, matieres.couleurFond, enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement  FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) left join matieres on (enseignements.codeMatiere=matieres.codeMatiere) WHERE matieres.deleted=0 and  seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
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









		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = round($topheight + ($hauteur - $topheight) / $days * $day   ); 

		$bottomy = round($topheight + ($hauteur - $topheight) / $days * ($day + 1)); 

		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 

		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 

		
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
$req_profs->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs->fetchAll();
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
$ray=3;

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+2+$ray,$rightx,$bottomy-2-$ray,$couleur);
		imagefilledrectangle($im,$leftx+$ray,$topy+2,$rightx-$ray,$bottomy-2,$couleur);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $leftx+$ray, $bottomy-2-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-$ray, $bottomy-2-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2, $couleur);
	
		imagearc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+$ray, $bottomy-2-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-$ray, $bottomy-2-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $noir);





		// On compte le nombre d'elements dans la case

		

		// on met deja nbelement egal 1 pour le nom de la matiere

		$nbelements=1;



		// On compte le nombre de profs a afficher



$req_profs->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs->fetchAll();
		
		
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

				if (strlen($resaname)>round(($rightx-$leftx)*10/92))

					{

					$chaine2=substr($resaname,0,round(($rightx-$leftx)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round(($rightx-$leftx)*10/92);

						

						}

					

					$compteur_ligne=1;

					



	while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));



						if (strlen($chaine2)<round(($rightx-$leftx)*10/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

													}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));

							$dernier_espace+=round(($rightx-$leftx)*10/92);

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



		

		


	// [GD] On affiche le type et la date des seances
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
	    
//affectation de la couleur au type d'enseignement
        if ($res_seance['codeTypeActivite']==2)

        {

            $couleur = $couleur_TD;

        }



        elseif ($res_seance['codeTypeActivite']==1)

        {

            $couleur = $couleur_CR;

        }



        elseif ($res_seance['codeTypeActivite']==3)

        {

            $couleur = $couleur_TP;

        }



        elseif ($res_seance['codeTypeActivite']==9)

        {

            $couleur = $couleur_DS;

        }



        elseif ($res_seance['codeTypeActivite']==4)

        {

            $couleur = $couleur_pro;

        }



        else

        {

            $couleur = $couleur_defaut;

        }


	unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$text = $res_type['alias']." - ";
	}

		

		// [GD] On affiche les horaires

		$size=imagettfbbox (8 , 0, $font, $text.$horaire_debut." - ".$horaire_fin);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];



	//dessin de la case de l en-tete
	// dessin des 2 rectangles
$epaisseur=12;
		imagefilledrectangle($im,$leftx,$topy+2+$ray,$rightx,$topy+$epaisseur,$couleur);
		imagefilledrectangle($im,$leftx+$ray,$topy+2,$rightx-$ray,$topy+$epaisseur,$couleur);

	// dessin des 2 cercles

		imagefilledarc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $couleur,IMG_ARC_EDGED);
		imagefilledarc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $couleur,IMG_ARC_EDGED);	
		imagearc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $noir);
		
		//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+$ray, $topy+2,$rightx-$ray, $topy+2, $noir);
		imageline($im, $leftx+$ray, $bottomy-2,$rightx-$ray, $bottomy-2, $noir);
		imageline($im, $leftx, $topy+2+$ray,$leftx, $bottomy-2-$ray, $noir);
		imageline($im, $rightx, $topy+2+$ray,$rightx, $bottomy-2-$ray, $noir);
		imageline($im, $leftx, $topy+$epaisseur,$rightx, $topy+$epaisseur, $noir);

		imagettftext ($im, 8, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $topy + 11  , $noir, $font, $text.$horaire_debut." - ".$horaire_fin);

	



		//on affiche le nom de la seance

			//dix caracteres ont une longueur de 92px

        $cursename=substr($cursename[1],0,round(($rightx-$leftx)*10/92)-1);

		$size=imagettfbbox (9 , 0, $fontb, $cursename);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, 9, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , ($bottomy + $topy+$epaisseur) / 2 +10 -10 * ($nbelements/2)  , $noir, $fontb, $cursename);

		$position=($bottomy + $topy+$epaisseur) / 2 +10- 10 * ($nbelements/2)+10;







		// [GD] On affiche les commentaires sur la seance

	

	// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

			$resaname=strtoupper($resaname);

			

			if($res_seance['commentaire']!="")

			{

				if (strlen($resaname)>round((($rightx-$leftx))*10/92))

					{

					$chaine2=substr($resaname,0,round(($rightx-$leftx)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round(($rightx-$leftx)*10/92);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=10;

						}

					else

					{	

					$chaine2=substr($resaname,0,$dernier_espace);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=10;

					}

								

					while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));



						if (strlen($chaine2)<round(($rightx-$leftx)*10/92))

							{

							$chaine2=substr($resaname,$dernier_espace+1);

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

												

							imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=10;

						$dernier_espace=2000;

						

							}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000 )

							{

							$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));

							$dernier_espace+=round(($rightx-$leftx)*10/92);

							$size=imagettfbbox (7 , 0, $font, $chaine2);

							$box_lenght=$size[2]-$size[0];

							

							imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=10;

							}

						elseif ($dernier_espace<1000)

						{

						

						

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

						$size=imagettfbbox (7 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

						

						imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=10;

						

						}			

						}

					}

				else

					{

					$size=imagettfbbox (7 , 0, $font, $resaname);

					$box_lenght=$size[2]-$size[0];

					imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $resaname);

					$position+=10;

					}

	

			}

	



	

	

		// [GD] On affiche les profs concernés

foreach ($res_prof as $res_profs)

			{

			if ($res_profs['nom']!="")

				{

	

				$size=imagettfbbox (8 , 0, $font, substr($res_profs['nom'],0,round(($rightx-$leftx)*10/92)-1));

				$box_lenght=$size[2]-$size[0];

				$box_width=$size[1]-$size[7];

				imagettftext ($im, 8, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position  , $noir, $font, substr($res_profs['nom'],0,round(($rightx-$leftx)*10/92)-1));

				

				

				$position+=10;

				}



			}

			

			

		// [GD] On affiche les salles

		$nbsalles=0;

		unset($salles);

		$salles="";



			foreach ($res_salle as $res_salles)

			{

			if ($nbsalles>0)

				$salles.=", ";

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

			imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position-2, $noir, $font, $salles);


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

			imagettftext ($im, 7, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position-4, $noir, $font, $materiels);




		}

		

		


	}

	//}

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




// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<$days;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));


	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances

		unset ($req_resa);
		$sql="SELECT *, reservations.dureeReservation, reservations.commentaire FROM reservations_groupes LEFT JOIN (reservations) ON (reservations_groupes.codereservation=reservations.codereservation)  WHERE reservations.datereservation=:current_day AND reservations.deleted=0 ".$critere." AND reservations_groupes.deleted=0  ";
		$req_resa=$dbh->prepare($sql);	
		$req_resa->execute(array(':current_day'=>$current_day));
		$res_resas=$req_resa->fetchAll();



		// Pour chaque séance

		foreach($res_resas as $res_resa)

		{



			// On convertit l'horaire en %age de la journée



			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);



			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



	// On calcule les coordonnées du rectangle :

		$topy = round($topheight + ($hauteur - $topheight) / $days * $day   ); 

		$bottomy = round($topheight + ($hauteur - $topheight) / $days * ($day + 1)); 

		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 

		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 

			

		

		//dessiner un rectangle avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins
$ray=3;

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+2+$ray,$rightx,$bottomy-2-$ray,$rdv[1]);
		imagefilledrectangle($im,$leftx+$ray,$topy+2,$rightx-$ray,$bottomy-2,$rdv[1]);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $leftx+$ray, $bottomy-2-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-$ray, $bottomy-2-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2, $rdv[1]);
	
		imagearc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+$ray, $bottomy-2-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-$ray, $bottomy-2-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $noir);	



			// [GD] On affiche les horaires
$text=$horaire_debut." - ".$horaire_fin;
			$size=imagettfbbox (8 , 0, $font, $text);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];



			



			//dessin de la case de l en-tete
	// dessin des 2 rectangles
$epaisseur=12;
		imagefilledrectangle($im,$leftx,$topy+2+$ray,$rightx,$topy+$epaisseur,$rdv[4]);
		imagefilledrectangle($im,$leftx+$ray,$topy+2,$rightx-$ray,$topy+$epaisseur,$rdv[4]);

	// dessin des 2 cercles

		imagefilledarc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $rdv[4],IMG_ARC_EDGED);
		imagefilledarc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $rdv[4],IMG_ARC_EDGED);	
		imagearc($im, $leftx+$ray, $topy+2+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $rightx-$ray, $topy+2+$ray, $ray*2, $ray*2,270,0, $noir);
		
		//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+$ray, $topy+2,$rightx-$ray, $topy+2, $noir);
		imageline($im, $leftx+$ray, $bottomy-2,$rightx-$ray, $bottomy-2, $noir);
		imageline($im, $leftx, $topy+2+$ray,$leftx, $bottomy-2-$ray, $noir);
		imageline($im, $rightx, $topy+2+$ray,$rightx, $bottomy-2-$ray, $noir);
		imageline($im, $leftx, $topy+$epaisseur,$rightx, $topy+$epaisseur, $noir);

			imagettftext ($im, 8, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $topy + 11  , $noir, $font, $text);

			
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

				if (strlen($resaname)>round(($rightx-$leftx)*10/92))

					{

					$chaine2=substr($resaname,0,round(($rightx-$leftx)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round(($rightx-$leftx)*10/92);

						

						}

					

					$compteur_ligne=1;

					



					while ($dernier_espace<strlen($res_resa['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));



						if (strlen($chaine2)<round(($rightx-$leftx)*10/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

													}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));

							$dernier_espace+=round(($rightx-$leftx)*10/92);

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

			$position=($bottomy + $topy+$epaisseur) / 2 +10- 10 * ($compteur_ligne/2);

			

			

			if($res_resa['commentaire']!="")

			{

				if (strlen($resaname)>round(($rightx-$leftx)*10/92))

					{

					$chaine2=substr($resaname,0,round(($rightx-$leftx)*10/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round(($rightx-$leftx)*10/92);

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

						$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));



						if (strlen($chaine2)<round(($rightx-$leftx)*10/92))

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

							$chaine2=substr($resaname,$dernier_espace,round(($rightx-$leftx)*10/92));

							$dernier_espace+=round(($rightx-$leftx)*10/92);

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



	
	




// [GD] On dessine la légende


//largeur en px de toute la legende : 558 px



imagestring($im, 10, ($largeur-558)/2, $hauteur+13, "Légende des en-tetes :", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+200, $hauteur+10, ($largeur-558)/2+200+30, $hauteur+30, $couleur_CR);

imagerectangle($im, ($largeur-558)/2+200, $hauteur+10, ($largeur-558)/2+200+30, $hauteur+29, $noir);

imagestring($im, 10, ($largeur-558)/2+200+40, $hauteur+13, "Cours", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+300, $hauteur+10, ($largeur-558)/2+300+30, $hauteur+30, $couleur_TD);

imagerectangle($im, ($largeur-558)/2+300, $hauteur+10, ($largeur-558)/2+300+30, $hauteur+29, $noir);

imagestring($im, 10, ($largeur-558)/2+300+40, $hauteur+13, "TD", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+400, $hauteur+10, ($largeur-558)/2+400+30, $hauteur+30, $couleur_TP);

imagerectangle($im, ($largeur-558)/2+400, $hauteur+10, ($largeur-558)/2+400+30, $hauteur+29, $noir);

imagestring($im, 10, ($largeur-558)/2+400+40, $hauteur+13, "TP", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+500, $hauteur+10, ($largeur-558)/2+500+30, $hauteur+30, $couleur_DS);

imagerectangle($im, ($largeur-558)/2+500, $hauteur+10, ($largeur-558)/2+500+30, $hauteur+29, $noir);

imagestring($im, 10, ($largeur-558)/2+500+40, $hauteur+13, "DS", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+200, $hauteur+35, ($largeur-558)/2+200+30, $hauteur+55, $couleur_pro);

imagerectangle($im, ($largeur-558)/2+200, $hauteur+35, ($largeur-558)/2+200+30, $hauteur+54, $noir);

imagestring($im, 10, ($largeur-558)/2+200+40, $hauteur+38, "Projet", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+300, $hauteur+35, ($largeur-558)/2+300+30, $hauteur+55, $couleur_defaut);

imagerectangle($im, ($largeur-558)/2+300, $hauteur+35, ($largeur-558)/2+300+30, $hauteur+54, $noir);

imagestring($im, 10, ($largeur-558)/2+300+40, $hauteur+38, "Autre", $noir);



imagefilledrectangle ($im, ($largeur-558)/2+400, $hauteur+35, ($largeur-558)/2+400+30, $hauteur+55, $rdv[4]);

imagerectangle($im, ($largeur-558)/2+400, $hauteur+35, ($largeur-558)/2+400+30, $hauteur+54, $noir);

imagestring($im, 10, ($largeur-558)/2+400+40, $hauteur+38, "Réservation", $noir);







// [GD] On dessine un cadre autour de l'EDT

imagerectangle ($im, 0, 0, $largeur , $topheight+($hauteur-$topheight)*$nbressource, $noir);



// Calcul du temps d'execution du script

$fin = explode(" ",microtime());

$fin = $fin[1]+$fin[0];

$temps_passe = $fin-$debut;



// [GD] Affichage durée execution

imagestring($im, 1, ($largeur-94)/2, $topheight+($hauteur-$topheight)*$nbressource+60, "Généré le ".date("d/m/Y"). " a " .date("H:i:s"). " en ".number_format($temps_passe,3)."s", $noir);



// [GD] Generation de l'image

if (!$debug) ImagePng ($im);

?>