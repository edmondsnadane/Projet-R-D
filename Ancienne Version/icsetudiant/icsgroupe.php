﻿<?php
include("../config.php");
//Connection a la bdd
mysql_connect($serveur,$user,$pass);
mysql_select_db($dernierebase);


$jour=date('d');
$mois=date('m');
$annee=date('Y');
$heure=date('H');
$minute=date('i');
$i=0;
setlocale(LC_TIME, 'fr_FR');

	

$ressources_groupes = mysql_query("SELECT * FROM ressources_groupes WHERE deleted='0'");




while ($groupe = mysql_fetch_array($ressources_groupes) )
	{
	$fichier="";
	$fichier="BEGIN:VCALENDAR". "\n";
	$fichier.="VERSION:2.0". "\n";
	$fichier.="PRODID:-//Developpe par Bruno Million//NONSGML v1.0//EN". "\n";
	$fichier.="CALSCALE:GREGORIAN". "\n";
	$fichier.="METHOD:PUBLISH". "\n";
	$fichier.="X-WR-CALNAME:".$groupe['nom']. "\n";
	$fichier.="X-WR-TIMEZONE:Europe/paris". "\n";
	
	while ($groupe['codeGroupe']!="")
	{
	$seances_groupes=mysql_query("SELECT * FROM seances_groupes WHERE codeRessource='$groupe[codeGroupe]' AND deleted= '0'");
	while ($seances_groupe = mysql_fetch_array($seances_groupes) )
		{
			$seances=mysql_query("SELECT * FROM seances WHERE codeSeance='$seances_groupe[codeSeance]' AND deleted= '0'");
			$seances_salles=mysql_query("SELECT * FROM seances_salles WHERE codeSeance='$seances_groupe[codeSeance]' AND deleted= '0'");
			
			while ($seance = mysql_fetch_array($seances) )
				{
				$fichier.="BEGIN:VEVENT". "\n";
				

				
				//nom de la seance
				$enseignements=mysql_query("SELECT * FROM enseignements WHERE codeEnseignement='$seance[codeEnseignement]' AND deleted= '0'");
				$enseignement = mysql_fetch_array($enseignements);	
				$numero_type=$enseignement['codeTypeActivite'];
				$types=mysql_query("SELECT * FROM types_activites WHERE codeTypeActivite='$numero_type'");
				$type_enseignement = mysql_fetch_array($types);
				$type=$type_enseignement['alias'];
				//création de la ligne summary
				//récupération de différentes infos du champs nom de la table enseignement
				$cursename=explode("_",$enseignement['nom']);
				$fichier.="SUMMARY:".$cursename[1]." - ".$type."\n";
				
				
				$fichier.="CLASS:PUBLIC". "\n";
				
				//date debut seance
				$dateseance=$seance['dateSeance'];
				//$dateseance=ereg_replace("[-:]","",$dateseance);
				$dateseance=preg_replace('/-/s',"",$dateseance);
				$heuredebutseance=$seance['heureSeance'];


				if (strlen($heuredebutseance)<=3)
					{
					$heuredebutseance="0".$heuredebutseance;
					}
				$anneeseance=substr($dateseance,0,4);
				$moisseance=substr($dateseance,4,2);
				$jourseance=substr($dateseance,6,2);
				$heureseance=substr($heuredebutseance,0,2);
				$minuteseance=substr($heuredebutseance,2,2);
				
				$dates= gmstrftime("DTSTART:%Y%m%dT%H%M%SZ", mktime($heureseance, $minuteseance, 0, $moisseance, $jourseance, $anneeseance));
				
				$fichier.=$dates."\n";
				
				//date fin seance
				$heuredebut=gmstrftime("%H", mktime($heureseance, $minuteseance, 0, $moisseance, $jourseance, $anneeseance));
				$mindebut=gmstrftime("%M", mktime($heureseance, $minuteseance, 0, $moisseance, $jourseance, $anneeseance));
				$heuredebutenmin=$heuredebut*60+$mindebut;

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
				$heurefinenmin=$heuredebutenmin+$heureduree*60+$minduree;
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
				$fichier.="DTEND:".$dateseance."T".$heurefin.$minfin."00Z"."\n";
				
				//numero de la salle
				$nomsalle="";
				while($seance_salle = mysql_fetch_array($seances_salles))
				{	
				$ressources_salles=mysql_query("SELECT * FROM ressources_salles WHERE codeSalle='$seance_salle[codeRessource]' AND deleted= '0'");
				$salle = mysql_fetch_array($ressources_salles);	
				$nomsalle = $nomsalle.$salle['nom']." ";	
				}
				$nomsalle=trim($nomsalle);
				$fichier.="LOCATION:".$nomsalle."\n";
				
				//detail de la seance
				$seances_profs=mysql_query("SELECT * FROM seances_profs WHERE codeSeance='$seances_groupe[codeSeance]' AND deleted= '0'");
				$nomprof="";
				while ($seance_prof = mysql_fetch_array($seances_profs))
					{
					$profs=mysql_query("SELECT * FROM ressources_profs WHERE codeProf='$seance_prof[codeRessource]' AND deleted= '0'");
					$prof = mysql_fetch_array($profs);				
					$nomprof=$nomprof.$prof['nom']." ";
					}
				$nomprof=trim($nomprof);
				if($seance['commentaire']!="")
				{
	
				$commentaire=utf8_encode($seance['commentaire']);
				$commentaire=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$commentaire);
				$commentaire=strtoupper($commentaire);
				$fichier.="DESCRIPTION;LANGUAGE=fr-CA:MATIERE : ".$cursename[1]." - ".$type."\\nPROF : ".$nomprof."\\nDUREE : ".$heureduree."h".$minduree. "\\nCOMMENTAIRE : ".$commentaire."\n";
				}
				else
				{
				$fichier.="DESCRIPTION;LANGUAGE=fr-CA:MATIERE : ".$cursename[1]." - ".$type."\\nPROF : ".$nomprof."\\nDUREE : ".$heureduree."h".$minduree. "\n";
				}
			$fichier.="DTSTAMP:".$annee.$mois.$jour."T".$heure.$minute."00Z"."\n";		
			$fichier.="UID:".$annee.$mois.$jour."T"."000001Z-".$i."@ufrsitec.u-paris10.fr". "\n";	
			$i=$i+1;
			$fichier.="CATEGORIES:Emplois du temps du PST". "\n";
				
			$fichier.="END:VEVENT". "\n";
			
				}
			

		}
		
		
//reservations		
$reservations_groupes=mysql_query("SELECT * FROM reservations_groupes WHERE codeRessource='$groupe[codeGroupe]' AND deleted= '0'");
while ($reservation_groupe = mysql_fetch_array($reservations_groupes) )
		{
			$reservations=mysql_query("SELECT * FROM reservations WHERE codeReservation='$reservation_groupe[codeReservation]' AND deleted= '0' AND diffusable='1'");
			$reservations_salles=mysql_query("SELECT * FROM reservations_salles WHERE codeReservation='$reservation_groupe[codeReservation]' AND deleted= '0'");
			
			
			while ($reservation = mysql_fetch_array($reservations) )
				{
				$fichier.="BEGIN:VEVENT". "\n";
				
			
				
				//nom de la reservation
				$commentaire=utf8_encode($reservation['commentaire']);	
				$commentaire=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$commentaire);
				$commentaire=strtoupper($commentaire);
				$fichier.="SUMMARY:".$commentaire."\n";
				
				$fichier.="CLASS:PUBLIC". "\n";
				
				
				
				//date debut reservation
				$datereservation=$reservation['dateReservation'];
				//$datereservation=ereg_replace("[-:]","",$datereservation);
				$datereservation=preg_replace('/-/s',"",$datereservation);
				$heuredebutreservation=$reservation['heureReservation']-100;
				if (strlen($heuredebutreservation)<=3)
					{
					$heuredebutreservation="0".$heuredebutreservation;
					}
					
				$anneereservation=substr($datereservation,0,4);
				$moisreservation=substr($datereservation,4,2);
				$jourreservation=substr($datereservation,6,2);
				$heurereservation=substr($heuredebutreservation,0,2);
				$minutereservation=substr($heuredebutreservation,2,2);	
					
				$dates= gmstrftime("DTSTART:%Y%m%dT%H%M%SZ", mktime($heurereservation, $minutereservation, 0, $moisreservation, $jourreservation, $anneereservation));
				
				$fichier.=$dates."\n";
					
				
				
					//date fin seance
				$heuredebut=gmstrftime("%H", mktime($heurereservation, $minutereservation, 0, $moisreservation, $jourreservation, $anneereservation));
				$mindebut=gmstrftime("%M", mktime($heurereservation, $minutereservation, 0, $moisreservation, $jourreservation, $anneereservation));
				$heuredebutenmin=$heuredebut*60+$mindebut;
				
				
				//date fin reservation
				$heuredebut=gmstrftime("%H", mktime($heurereservation, $minutereservation, 0, $moisreservation, $jourreservation, $anneereservation));
				$mindebut=gmstrftime("%M", mktime($heurereservation, $minutereservation, 0, $moisreservation, $jourreservation, $anneereservation));
				$heuredebutenmin=$heuredebut*60+$mindebut;

				if (strlen($reservation['dureeReservation'])==4)
					{
						$heureduree=substr($reservation['dureeReservation'],0,2);
						$minduree=substr($reservation['dureeReservation'],2,2);
					}
				if (strlen($reservation['dureeReservation'])==3)
					{
						$heureduree=substr($reservation['dureeReservation'],0,1);
						$minduree=substr($reservation['dureeReservation'],1,2);

					}
				if (strlen($reservation['dureeReservation'])==2)
					{
						$heureduree=0;
						$minduree=$reservation['dureeReservation'];
					}
				$heurefinenmin=$heuredebutenmin+$heureduree*60+$minduree;
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
				$fichier.="DTEND:".$datereservation."T".$heurefin.$minfin."00Z"."\n";
				
				//numero de la salle
				$nomsalle="";
				$reservations_salles=mysql_query("SELECT * FROM reservations_salles WHERE codeReservation='$reservation_groupe[codeReservation]' AND deleted= '0' AND codeRessource!='0'");
				while($reservation_salle = mysql_fetch_array($reservations_salles))
				{
				$ressources_salles=mysql_query("SELECT * FROM ressources_salles WHERE codeSalle='$reservation_salle[codeRessource]' AND deleted= '0' ");
				while($salle = mysql_fetch_array($ressources_salles))
				{
				$nomsalle = $nomsalle.$salle['nom']." ";	
				}
				}
				$nomsalle=trim($nomsalle);
				$fichier.="LOCATION:".$nomsalle. "\n";
				
				//detail de la seance
				$fichier.="DESCRIPTION;LANGUAGE=fr-CA:INTITULE : ".$commentaire." \\nDUREE : ".$heureduree."h".$minduree."\n";
				
				$fichier.="CATEGORIES:Emplois du temps du PST". "\n";
				$fichier.="DTSTAMP:".$annee.$mois.$jour."T".$heure.$minute."00Z"."\n";		
				$fichier.="UID:".$annee.$mois.$jour."T"."000001Z-".$i."@ufrsitec.u-paris10.fr"."\n";	
				$i=$i+1;
				$fichier.="END:VEVENT"."\n";
			
				}
			
		}
		$groupes_de_niveau_sup=mysql_query("SELECT * FROM hierarchies_groupes WHERE codeRessourceFille='$groupe[codeGroupe]' AND deleted= '0'");
		$groupe_de_niveau_sup = mysql_fetch_array($groupes_de_niveau_sup);
		$groupe['codeGroupe']=$groupe_de_niveau_sup['codeRessource'];
		}
		

		
		
	$fichier.="END:VCALENDAR";

	$nomfichier=$groupe['nom'].".ics";
	//$nomfichier=ereg_replace("[ ]","_",$nomfichier);
$nomfichier=preg_replace('/\s/',"_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	file_put_contents($nomfichier,$fichier);
	
	
	}

?>








		



