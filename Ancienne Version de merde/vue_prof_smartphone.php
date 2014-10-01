<?php

session_start();



include("config.php");

 









//activation du mod debug qui permet de voir le resultat des requetes

$debug=0;

if ($debug)

	{

		echo "Debug mode";

		error_reporting(E_ALL);

	}





//taille de l'image.

// pas les memes parametre avec l iphone qu avec les autres telephones

if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) 

{ 

 //recuperation de la largeur de l ecran a laquelle on enleve 50 pour que ca rentre en largeur dans firefox





$largeur=288;

//recuperation de la hauteur de l ecran a laquelle on enleve 260 pour que ca rentre en hauteur dans firefox





$hauteur=260;

} 



elseif (stristr($_SERVER['HTTP_USER_AGENT'], "HTC")  ) 

{ 

 //recuperation de la largeur de l ecran a laquelle on enleve 50 pour que ca rentre en largeur dans firefox





$largeur=225;

//recuperation de la hauteur de l ecran a laquelle on enleve 260 pour que ca rentre en hauteur dans firefox





$hauteur=240;

} 

else

{

//recuperation de la largeur de l ecran a laquelle on enleve 50 pour que ca rentre en largeur dans firefox

$largeur=$_GET['lar']-30;



//recuperation de la hauteur de l ecran a laquelle on enleve 260 pour que ca rentre en hauteur dans firefox

$hauteur=$_GET['hau']-80;

}

	







//taille police heures

$taillepoliceheure=1;



//taille police jours

$taillepolicejour=1;



//taille police date

$taillepolicedate=1;









//[GD] Définition de la variable d'environnement

putenv('GDFONTPATH=' . realpath('.').'/fonts/');



// Nom de la police à utiliser

$font = "verdana.ttf";

$fontb = "verdanab.ttf";





// On recopie les données GET

if (isset ($_GET['hideprivate']) && $_GET['hideprivate']=='1')

	$hideprivate = 1;

else

	$hideprivate = 0;





$current_prof=$_GET['current_prof'];



if(isset($_GET['codeProf']))

    $codeProf=$_GET['codeProf'];



if (isset($_GET['current_week']) &&  $_GET['current_week']>0)

	$current_week = $_GET['current_week'];

else

	$current_week = date('W');





if(!isset($_GET['current_year'])  || $_GET['current_year']==0)

	$current_year=date("Y");

else

	$current_year=$_GET['current_year'];


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



// Largeur et hauteur des entêtes du calendrier qui correspond aux zone ou il y a les heures et les jours

$leftwidth=26;

$topheight=15;



// [GD] On crée l'image



$im = imagecreate ($largeur, $hauteur)

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

$couleur_defaut = imagecolorallocate ($im, 255, 229, 255);

$couleur_pro = imagecolorallocate($im, 255, 200,0);

$couleur_jur = imagecolorallocate($im, 64, 224, 208);



$cours = imagecolorallocate ($im, 211, 255, 236);



$rdv[1] = imagecolorallocate ($im, 255, 187, 246);

$rdv[2] = imagecolorallocate ($im, 255, 222, 132);

$rdv[3] = imagecolorallocate ($im, 135, 206, 235);

$rdv[4] = imagecolorallocate ($im, 255, 255, 0);

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

// affichage des vacances scolaires des profs
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
	//preparation des requete pour la boucle suivante
	$sql="SELECT * from vacances where date=:current_day";
	$req_vacances=$dbh->prepare($sql);
	for ($day=0;$day<$days;$day++)
		{
		$current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
		$req_vacances->execute(array(':current_day'=>$current_day));
		$vacance=$req_vacances->fetchAll();
		
		foreach($vacance as $vacances)
			{
				if ($days==6)
					{
					imagefilledrectangle($im, round(($largeur-$leftwidth)/6*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/6*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
					}
				elseif ($days==7)
					{
					imagefilledrectangle($im, round(($largeur-$leftwidth)/7*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/7*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
					}		
				else
					{	
					imagefilledrectangle($im, round(($largeur-$leftwidth)/5*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/5*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
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
					imagefilledrectangle($im, round(($largeur-$leftwidth)/6*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/6*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
					}
				elseif ($days==7)
					{
					imagefilledrectangle($im, round(($largeur-$leftwidth)/7*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/7*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
					}		
				else
					{	
					imagefilledrectangle($im, round(($largeur-$leftwidth)/5*$day+$leftwidth), $topheight,  round(($largeur-$leftwidth)/5*($day+1)+$leftwidth), $hauteur-1, $couleur_vacances);
					}
			}
		}		
		
		
		
		}
	






// [GD] Création d'un polygone qui entoure les zones d en-tête

$greycadre= array(0, 0, $largeur, 0, $largeur, $topheight, $leftwidth, $topheight, $leftwidth, $hauteur-1, 0, $hauteur-1, 0, 0);


// [GD] Mise en gris des entêtes

imagefilledpolygon ($im, $greycadre, 7, $gris);



// [GD] mise en gris de la pause de midi

if ($lunchstart>$starttime)

	imagefilledrectangle($im, $leftwidth+1 ,abs($lunchstart-$starttime)/($endtime-$starttime+0.25)*($hauteur-$topheight)+$topheight , $largeur-1, abs($lunchstop-$starttime)/($endtime-$starttime+0.25)*($hauteur-$topheight)+$topheight, $grisclair);



// [GD] Dessin des cadres

imageline ($im,  $leftwidth+1, $topheight, $largeur-1, $topheight, $noir);




// [GD] On affiche les heures

$currenttime=$starttime;

$nbintervalles=round(($endtime-$starttime)/0.25)+1;

for($i=0;$i<=$nbintervalles-1;$i++)

	{

	imageline ($im, $leftwidth+1, $topheight+(($hauteur-$topheight)/$nbintervalles)*$i, $largeur-1, $topheight+(($hauteur-$topheight)/$nbintervalles)*$i, $gris);

	if (!($i%2))

		imagestring ($im, $taillepoliceheure, 1, $topheight-3+($hauteur-1-$topheight)/$nbintervalles*$i, substr(intval($currenttime)+100,-2,2).":".substr(($currenttime-intval($currenttime))*60+100,-2,2), $noir);

	$currenttime+=0.25;

	}





// [GD] On trace les lignes verticales et on met les jours

	//si semaine de 5 jours

if ($samedi=='0' && $dimanche=='0')

	{

	for($i=0;$i<=5;$i++)

		imageline ($im, round(($largeur-$leftwidth)/5*$i+$leftwidth), 0,  round(($largeur-$leftwidth)/5*$i+$leftwidth), $hauteur-1, $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+((($largeur-$leftwidth)/5)-22)/2, 1, "Lundi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-22)/2, 1, "Mardi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+2*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-38)/2, 1, "Mercredi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+3*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-26)/2, 1, "Jeudi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+4*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-38)/2, 1, "Vendredi", $noir);



	

	//pense bete     largeur en pixel de la date vaut 37

	imagestring ($im, $taillepolicedate, $leftwidth+((($largeur-$leftwidth)/5)-21)/2, 8, date("d/m",$lundi), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-21)/2, 8, date("d/m",strtotime("+1 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+2*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-21)/2, 8, date("d/m",strtotime("+2 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+3*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-21)/2, 8, date("d/m",strtotime("+3 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+4*(($largeur-$leftwidth)/5)+((($largeur-$leftwidth)/5)-21)/2, 8, date("d/m",strtotime("+4 day",$lundi)), $noir);



	$days=5;

	}
	
elseif ($dimanche=='1')

	{

	for($i=0;$i<=6;$i++)

		imageline ($im, round(($largeur-$leftwidth)/7*$i+$leftwidth), 0,  round(($largeur-$leftwidth)/7*$i+$leftwidth), $hauteur-1, $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+((($largeur-$leftwidth)/7)-22)/2, 1, "Lundi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-22)/2, 1, "Mardi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+2*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-38)/2, 1, "Mercredi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+3*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-26)/2, 1, "Jeudi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+4*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-38)/2, 1, "Vendredi", $noir);
	
	imagestring ($im, $taillepolicejour,$leftwidth+5*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-38)/2, 1, "Samedi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+6*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-38)/2, 1, "Dimanche", $noir);
	

	//pense bete     largeur en pixel de la date vaut 37

	imagestring ($im, $taillepolicedate, $leftwidth+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",$lundi), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+1 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+2*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+2 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+3*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+3 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+4*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+4 day",$lundi)), $noir);
	
	imagestring ($im, $taillepolicedate, $leftwidth+5*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+5 day",$lundi)), $noir);
	
	imagestring ($im, $taillepolicedate, $leftwidth+6*(($largeur-$leftwidth)/7)+((($largeur-$leftwidth)/7)-21)/2, 8, date("d/m",strtotime("+6 day",$lundi)), $noir);

	$days=7;

	}	

	//si semaine de six jours

else

	{

	for($i=0;$i<=6;$i++)

		imageline ($im, round(($largeur-$leftwidth)/6*$i+$leftwidth), 0,  round(($largeur-$leftwidth)/6*$i+$leftwidth), $hauteur-1, $noir);

		//pense bete   largeur en px Lundi 22 Mardi 22 Mercredi 38 Jeudi 26  Vendredi 38  Samedi 28

		

	imagestring ($im, $taillepolicejour,$leftwidth+((($largeur-$leftwidth)/6)-22)/2, 1, "Lundi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-22)/2, 1, "Mardi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+2*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-38)/2, 1, "Mercredi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+3*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-26)/2, 1, "Jeudi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+4*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-38)/2, 1, "Vendredi", $noir);

	imagestring ($im, $taillepolicejour,$leftwidth+5*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-28)/2, 1, "Samedi", $noir);

	

	//pense bete    largeur en pixel de la date vaut 21

	imagestring ($im, $taillepolicedate, $leftwidth+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",$lundi), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",strtotime("+1 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+2*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",strtotime("+2 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+3*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",strtotime("+3 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+4*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",strtotime("+4 day",$lundi)), $noir);

	imagestring ($im, $taillepolicedate, $leftwidth+5*(($largeur-$leftwidth)/6)+((($largeur-$leftwidth)/6)-21)/2, 8, date("d/m",strtotime("+5 day",$lundi)), $noir);

	$days=6;

	}







/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*                                Affichage cours                            */

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

//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire, matieres.couleurFond, enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement  FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement)  left join matieres on (enseignements.codeMatiere=matieres.codeMatiere) WHERE matieres.deleted=0 and seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0 ";
$req_seance2=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles2=$dbh->prepare($sql);	

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:current_prof";
$req_profs2=$dbh->prepare($sql);

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0'  order by ressources_profs.nom";
$req_profs=$dbh->prepare($sql);

// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<$days;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour le prof et le jour choisi l'ensemble des séances

$req_seance2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof));
$res_seances=$req_seance2->fetchAll();

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

		$leftx = round($leftwidth + ($largeur - $leftwidth) / $days * $day); // Coté gauche

		$rightx = round($leftwidth + ($largeur - $leftwidth) / $days * ($day + 1)); // Coté droit

		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut

		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche


$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes3->fetchAll();
$dechex="FFFFFF";//couleur par défaut si pas de groupe (blanc)


		

	

		//recuperation de la couleur associee au groupe ou à la matiere ou au prof et conversion en rvb
if ($couleur_des_seances_prof_prof==0) // si couleur des groupes
{
foreach($res_groupe as $res_groupes)
{
$dechex=dechex($res_groupes['couleurFond']);
}
}
elseif ($couleur_des_seances_prof_prof==1) // si couleur des matieres
{
$dechex=dechex($res_seance['couleurFond']);
}
elseif ($couleur_des_seances_prof_prof==2) // si couleur des matieres
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

        while (strlen($dechex)<6)

			{

			$dechex = "0".$dechex;

			}



	//dessiner un rectangle avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins
//couleur
$couleur = imagecolorallocate ($im, hexdec(substr($dechex,-2,2)), hexdec(substr($dechex,-4,2)), hexdec(substr($dechex,-6,2)));
//valeur du rayon 15min
//$ray=($hauteur-$topheight)/$nbintervalles;
$ray=3;

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+$ray,$rightx,$bottomy-$ray,$couleur);
		imagefilledrectangle($im,$leftx+$ray,$topy,$rightx-$ray,$bottomy,$couleur);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2, $couleur);
		imagefilledellipse($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2, $couleur);
	
		imagearc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);



		

		

		

		// On compte le nombre d'elements dans la case

		// on met deja nb element egal 1 pour le nom de la matiere

		$nbelements=1;





		// On recherche pour cette séance le ou les groupes associés
$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();
		
		
			if (count($res_groupes)>=1)
				{
				$nbelements+=count($res_groupes);
				}



		// On recherche pour cette séance la ou les salles associées

$req_salles2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles2->fetchAll();		
		if (count($res_salle)>=1)
			{
			//on affiche les salles sur 1 seule ligne donc nbelement +1

			$nbelements+=1;
			}
		$position= - ceil($nbelements / 2) + 1;	

		

		

		//on calcule le nombre de ligne de la chaine commentaire

		// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

			$resaname=strtoupper($resaname);

		

			$compteur_ligne='0';

			if($res_seance['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*25/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*25/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*25/92);

						

						}

					

					$compteur_ligne=1;

					



	while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*25/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*25/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

													}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*25/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*25/92);

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

		$size=imagettfbbox (4 , 0, $font, $text.$horaire_debut."-".$horaire_fin);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		
		


	//dessin de la case de l en-tete
	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+$ray,$rightx,$topy+8,$couleur);
		imagefilledrectangle($im,$leftx+$ray,$topy,$rightx-$ray,$topy+8,$couleur);

	// dessin des 2 cercles

		imagefilledarc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $couleur,IMG_ARC_EDGED);
		imagefilledarc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $couleur,IMG_ARC_EDGED);	
		imagearc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);
		
		//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+$ray, $topy,$rightx-$ray, $topy, $noir);
		imageline($im, $leftx+$ray, $bottomy,$rightx-$ray, $bottomy, $noir);
		imageline($im, $leftx, $topy+$ray,$leftx, $bottomy-$ray, $noir);
		imageline($im, $rightx, $topy+$ray,$rightx, $bottomy-$ray, $noir);
		imageline($im, $leftx, $topy+8,$rightx, $topy+8, $noir);


		imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2, $topy + 6  , $noir, $font, $text.$horaire_debut."-".$horaire_fin);

		//decalage de la hauteur de l en-tête

        $topy+=8;



		

		//on affiche le nom de la seance

	//pense bete   vingt caracteres ont une longueur de 92px

        $cursename=substr($cursename[1],0,round((($largeur-$leftwidth)/$days)*15/92)-1);

		$size=imagettfbbox (5 , 0, $font, $cursename);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , ($bottomy + $topy) / 2 +4 -6 * (($nbelements-1)/2) , $noir, $fontb, $cursename);

		$position=($bottomy + $topy) / 2 +4 -6 * (($nbelements-1)/2)+6;

		



		

		

		

		

	// [GD] On affiche les commentaires sur la seance

	

	// on decoupe la chaine commantaire en fonction de la taille de la case et au niveau des espaces

			//conversion en majuscule

			$resaname=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

			$resaname=strtoupper($resaname);

			

			if($res_seance['commentaire']!="")

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*25/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*25/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*25/92);

						$size=imagettfbbox (4 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=6;

						}

					else

					{	

					$chaine2=substr($resaname,0,$dernier_espace);

						$size=imagettfbbox (4 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=6;

					}

								

					while ($dernier_espace<strlen($res_seance['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*25/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*25/92))

							{

							$chaine2=substr($resaname,$dernier_espace);

						$size=imagettfbbox (4 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

												

							imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=6;

						$dernier_espace=2000;

						

							}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000 )

							{

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*25/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*25/92);

							$size=imagettfbbox (4 , 0, $font, $chaine2);

							$box_lenght=$size[2]-$size[0];

							

							imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=6;

							}

						elseif ($dernier_espace<1000)

						{

						

						

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

						$size=imagettfbbox (4 , 0, $font, $chaine2);

						$box_lenght=$size[2]-$size[0];

						

						imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $chaine2);

						$position+=6;

						

						}			

						}

					}

				else

					{

					$size=imagettfbbox (4 , 0, $font, $resaname);

					$box_lenght=$size[2]-$size[0];

					imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, $resaname);

					$position+=6;

					}

	

			}



			

			



			



		// [GD] On affiche les groupes concernés

foreach ($res_groupes as $res_groupe)

			{

			if ($res_groupe['nom']!="")

				{

			$size=imagettfbbox (5 , 0, $font, substr($res_groupe['nom'],0,round((($largeur-$leftwidth)/$days)*20/92)-1));

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $font, substr($res_groupe['nom'],0,round((($largeur-$leftwidth)/$days)*20/92)-1));

			$position+=6;

			}

			}



			

		$nbsalles=0;

		unset($salles);

		$salles="";

	foreach ($res_salle as $res_salles)

			{

			if ($nbsalles>0)

				$salles.=",";

			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof_smartphone);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof_smartphone);
	}		
			

			}



			$size=imagettfbbox (5 , 0, $font, $salles);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position  , $noir, $font, $salles);

//marque seance annulée
if ( $res_seance['annulee']=='1')
	{
	

		//dessiner un rectangle noir avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins
//couleur noire
$couleur = imagecolorallocate ($im, 0, 0,0 );
//valeur du rayon 2

$ray=2;

	// dessin des 2 rectangles

imagefilledrectangle($im,$leftx+2+10,$topy+$ray+10,$rightx-2-10,$bottomy-$ray-4,$couleur);
imagefilledrectangle($im,$leftx+2+$ray+10,$topy+10,$rightx-2-$ray-10,$bottomy-4,$couleur);

	

	// dessin des 4 cercles

imagefilledellipse($im, $leftx+2+$ray+10, $topy+$ray+10, $ray*2, $ray*2, $couleur);
imagefilledellipse($im, $leftx+2+$ray+10, $bottomy-$ray-4, $ray*2, $ray*2, $couleur);
imagefilledellipse($im, $rightx-2-$ray-10, $bottomy-$ray-4, $ray*2, $ray*2, $couleur);
imagefilledellipse($im, $rightx-2-$ray-10, $topy+$ray+10, $ray*2, $ray*2, $couleur);

imagearc($im, $leftx+2+$ray+10, $topy+$ray+10, $ray*2, $ray*2,180,270, $couleur);
imagearc($im, $leftx+2+$ray+10, $bottomy-$ray-4, $ray*2, $ray*2,90,180, $couleur);
imagearc($im, $rightx-2-$ray-10, $bottomy-$ray-4, $ray*2, $ray*2,0,90, $couleur);
imagearc($im, $rightx-2-$ray-10, $topy+$ray+10, $ray*2, $ray*2,270,0, $couleur);
	
	
	
	
	
	$seance_annulee="Séance annulée";
	$size=imagettfbbox (5 , 0, $fontb, $seance_annulee);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , ($bottomy + $topy) / 2 +9 , $blanc, $fontb, $seance_annulee);

	
	}	



		}





/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*                                Affichage des reservation                  */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

		

		

		

if (!$hideprivate) {

//test si prof loggué avec login perso
$test_login=0;
if (isset($_SESSION['logged_prof_perso']))
{
if ($current_prof==$_SESSION['logged_prof_perso'])
{
$test_login=1;
}
}

//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);


if ($pas_afficher_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

elseif($contenu_reservation_privee==0)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==1 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==0 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

//$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0  ";
$req_resa2=$dbh->prepare($sql);	
$req_resa2->execute(array(':current_day'=>$current_day,':current_prof'=>$current_prof));
$res_resas=$req_resa2->fetchAll();

		// Pour chaque reservation

	foreach($res_resas as $res_resa)
		{



		

			// On convertit l'horaire en %age de la journée



			/* Explication conversion :



			   On extrait d'une part les minutes et d'autre part l'heure.

			   On transforme les minutes en fraction d'heure.

			   On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

			   On obtient un %age correspondant à la position du début du cours.

			   Idem pour la durée mais sans enlever 8.15



			*/







			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);

			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



			//calcul des coordonnees du rectangle

			$leftx = round($leftwidth + ($largeur - $leftwidth) / $days * $day)+3; // Coté gauche

			$rightx = round($leftwidth + ($largeur - $leftwidth) / $days * ($day + 1))-3; // Coté droit

			$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut

			$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche

			

		



	//dessiner un rectangle avec les angles arrondies car gd ne le fait pas de base
//on dessine 2 rectangle pour faire une croix et on met 4 cercles dans les coins

//valeur du rayon 15min
//$ray=($hauteur-$topheight)/$nbintervalles;
$ray=3;
if ($res_resa['diffusable']=='1')
{
	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+$ray,$rightx,$bottomy-$ray,$rdv[1]);
		imagefilledrectangle($im,$leftx+$ray,$topy,$rightx-$ray,$bottomy,$rdv[1]);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[1]);
		imagefilledellipse($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2, $rdv[1]);
	
		imagearc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);		
}
else
{

	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+$ray,$rightx,$bottomy-$ray,$rdv[3]);
		imagefilledrectangle($im,$leftx+$ray,$topy,$rightx-$ray,$bottomy,$rdv[3]);

	

	// dessin des 4 cercles

		imagefilledellipse($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2, $rdv[3]);
		imagefilledellipse($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[3]);
		imagefilledellipse($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2, $rdv[3]);
		imagefilledellipse($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2, $rdv[3]);
	
		imagearc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $leftx+$ray, $bottomy-$ray, $ray*2, $ray*2,90,180, $noir);
		imagearc($im, $rightx-$ray, $bottomy-$ray, $ray*2, $ray*2,0,90, $noir);
		imagearc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);		
}
			

	

			

			// [GD] On affiche les horaires
$text=$horaire_debut."-".$horaire_fin;
			$size=imagettfbbox (4 , 0, $font, $text);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];





			




	//dessin de la case de l en-tete
	// dessin des 2 rectangles

		imagefilledrectangle($im,$leftx,$topy+$ray,$rightx,$topy+8,$rdv[4]);
		imagefilledrectangle($im,$leftx+$ray,$topy,$rightx-$ray,$topy+8,$rdv[4]);

	// dessin des 2 cercles

		imagefilledarc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $rdv[4],IMG_ARC_EDGED);
		imagefilledarc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $rdv[4],IMG_ARC_EDGED);	
		imagearc($im, $leftx+$ray, $topy+$ray, $ray*2, $ray*2,180,270, $noir);
		imagearc($im, $rightx-$ray, $topy+$ray, $ray*2, $ray*2,270,0, $noir);
		
		//ajout des traits noir qui manquent autour de la seance
		imageline($im, $leftx+$ray, $topy,$rightx-$ray, $topy, $noir);
		imageline($im, $leftx+$ray, $bottomy,$rightx-$ray, $bottomy, $noir);
		imageline($im, $leftx, $topy+$ray,$leftx, $bottomy-$ray, $noir);
		imageline($im, $rightx, $topy+$ray,$rightx, $bottomy-$ray, $noir);
		imageline($im, $leftx, $topy+8,$rightx, $topy+8, $noir);



			imagettftext ($im, 4, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $topy + 6  , $noir, $font, $text);
	

			
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
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof_smartphone);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof_smartphone);
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

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*15/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*15/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*15/92);

						

						}

					

					$compteur_ligne=1;

					



					while ($dernier_espace<strlen($res_resa['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace+1,round((($largeur-$leftwidth)/$days)*15/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*15/92))

							{

							

						$dernier_espace=2000;

						$compteur_ligne+=1;

								}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000)

							{

							$compteur_ligne=$compteur_ligne+1;

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*15/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*15/92);

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

			$position=($bottomy + $topy+8) / 2 +4- 6 * (($compteur_ligne-1)/2);

			

			

			if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1' || $test_login==1  )

			{

				if (strlen($resaname)>round((($largeur-$leftwidth)/$days)*15/92))

					{

					$chaine2=substr($resaname,0,round((($largeur-$leftwidth)/$days)*15/92));

					$dernier_espace=strrpos($chaine2," ");

					if ($dernier_espace=="")

						{

						$dernier_espace=round((($largeur-$leftwidth)/$days)*15/92);

						$size=imagettfbbox (5 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=6;

						}

					else

					{	

					$chaine2=substr($resaname,0,$dernier_espace);

						$size=imagettfbbox (5 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

											

						imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=6;

					}

								

					while ($dernier_espace<strlen($res_resa['commentaire']) )

						{

						$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*15/92));



						if (strlen($chaine2)<round((($largeur-$leftwidth)/$days)*15/92))

							{

							$chaine2=substr($resaname,$dernier_espace);

						$size=imagettfbbox (5 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

												

							imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=6;

						$dernier_espace=2000;

						

							}

						$dernier_espace2=strrpos($chaine2," ");

						//si mot vraiment trop long pour rentrer dans case on le coupe en deux

						if ($dernier_espace2=="" && $dernier_espace<1000 )

							{

							$chaine2=substr($resaname,$dernier_espace,round((($largeur-$leftwidth)/$days)*15/92));

							$dernier_espace+=round((($largeur-$leftwidth)/$days)*15/92);

							$size=imagettfbbox (5 , 0, $fontb, $chaine2);

							$box_lenght=$size[2]-$size[0];

							

							imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=6;

							}

						elseif ($dernier_espace2!="" && $dernier_espace<1000)

						{

						

						

						$chaine2=substr($resaname,$dernier_espace,$dernier_espace2);

						$dernier_espace+= $dernier_espace2;

						$size=imagettfbbox (5 , 0, $fontb, $chaine2);

						$box_lenght=$size[2]-$size[0];

						

						imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $chaine2);

						$position+=6;

						

						}			

						}

					}

				else

					{

					$size=imagettfbbox (5 , 0, $fontb, $resaname);

					$box_lenght=$size[2]-$size[0];

					imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $resaname);

					$position+=6;

					}

	

			}

			

			else

			{

			$position=($bottomy + $topy) / 2 +4- 5 +5;

			$resaname="Privé";

			$size=imagettfbbox (5 , 0, $font, $resaname);

			$box_lenght=$size[2]-$size[0];

			imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position , $noir, $fontb, $resaname);

			$position+=6;

			}
			//affichage de la salle associée à la réservation	
 if ($nb_resa_salle>0)
	 {		
			$size=imagettfbbox (5 , 0, $font,  $nom_resa_salle);

			$box_lenght=$size[2]-$size[0];

			$box_width=$size[1]-$size[7];

			imagettftext ($im, 5, 0, $leftx + ($rightx - $leftx - $box_lenght)/2 , $position, $noir, $font,  $nom_resa_salle);
	

			}


		}

	}

}

}









// [GD] On dessine un cadre autour de l'EDT

imagerectangle ($im, 0, 0, $largeur-1, $hauteur-1, $noir);



// Calcul du temps d'execution du script

$fin = explode(" ",microtime());

$fin = $fin[1]+$fin[0];

$temps_passe = $fin-$debut;



// [GD] Affichage durée execution

imagestring($im, 1, ($largeur-94)/2, $hauteur+60, "Généré en : ".number_format($temps_passe,3)." s ", $noir);



// [GD] Generation de l'image

if (!$debug) ImagePng ($im);

?>