<?php





include("config.php");
if (isset($_GET['base']))
{
$annee_scolaire_choisie=$_GET['base'];
}
else
{
$annee_scolaire_choisie=$nbdebdd;
}
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


//recuperation du code du prof concerné
$selec_prof=$_GET['selec_prof'];



include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_bar.php");
include ("jpgraph/src/jpgraph_line.php");


//compte combien il y a de de minute en tout sur l'ensemble des séances
$sql="SELECT *  FROM seances_profs left join seances on seances.codeSeance=seances_profs.codeSeance left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement WHERE enseignements.deleted=0 and seances_profs.codeRessource=".$selec_prof." and seances_profs.deleted='0' and seances.deleted='0' ";
$req_nb_seance=$dbh->query($sql);
$res_nb_seance=$req_nb_seance->fetchAll();

$duree_en_min_annee=0;
		foreach ($res_nb_seance as $seance)
			{
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

$duree_en_min_annee+=$heureduree*60+	$minduree;
}





//compte combien il y a de minutes par mois
$duree_en_min_cumul=0;
for ($i = 1; $i <= 12; $i++) {
// on commence en septembre donc septembre=$i+8
 $j=$i+8;
 if ($j>12)
 {
 $j=$j-12;
 }
 unset ($req_seance);
$sql="SELECT *, seances.dureeSeance as dureeSeance  FROM seances_profs left join seances on seances.codeSeance=seances_profs.codeSeance left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE enseignements.deleted=0 and seances_profs.codeRessource=".$selec_prof." and seances_profs.deleted='0' and seances.deleted='0' and month(seances.dateSeance)=".$j;

$req_seance=$dbh->query($sql);
$res_seance=$req_seance->fetchAll();
$duree_en_min=0;

		foreach ($res_seance as $seance)
			{
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

		
		
	
	$CodeActivite=$seance['codeTypeActivite'];	
	
		if ($seance['forfaitaire']==0)
		{
	
        if ($seance['volumeReparti']==1)
				{
				$duree_en_min+=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs;
				$duree_en_min_cumul+=($heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                     $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+ 
                     $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2]
                     )/$nb_profs;	 
					 
					 
				}
				else
				{
				$duree_en_min+=$heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2];
						 
				$duree_en_min_cumul+=$heureduree*90*$TauxTypeEns[$CodeActivite][0]+$minduree*1.5*$TauxTypeEns[$CodeActivite][0]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][1]+$minduree*$TauxTypeEns[$CodeActivite][1]+
                         $heureduree*60*$TauxTypeEns[$CodeActivite][2]+$minduree*$TauxTypeEns[$CodeActivite][2];
						 		 
						 
						 
				}		
		}
		else
		{
		
		}

		
		

}


//mise en forme du nom du mois

if($j==1)
{
$nom_mois="Janvier";
}
if($j==2)
{
$nom_mois="Février";
}
if($j==3)
{
$nom_mois="Mars";
}
if($j==4)
{
$nom_mois="Avril";
}
if($j==5)
{
$nom_mois="Mai";
}
if($j==6)
{
$nom_mois="Juin";
}
if($j==7)
{
$nom_mois="Juillet";
}
if($j==8)
{
$nom_mois="Août";
}
if($j==9)
{
$nom_mois="Septembre";
}
if($j==10)
{
$nom_mois="Octobre";
}
if($j==11)
{
$nom_mois="Novembre";
}
if($j==12)
{
$nom_mois="Decembre";
}

$datay[] = $duree_en_min/60;

$dataycumul[] = $duree_en_min_cumul/60;
$datax[] = $nom_mois;
}





//mise en forme du graphique


// taille du graph

$width=750;

$height=550;



// Set the basic parameters of the graph

$graph = new Graph($width,$height,'auto');

$graph->SetScale("textlin");



// set margin

$graph->SetMargin(50,20,50,80);







// Setup title
$graph->title->Set("Répartition des heures sur l'année (en heure)");
$graph->title->SetFont(FF_VERDANA,FS_NORMAL,12);
$graph->title->SetColor("black");

//couleur de la bordure
$graph->SetFrame(true,'black',1);

//couleur du fond
$graph->SetMarginColor('gray');



// Setup X-axis

$graph->xaxis->SetTickLabels($datax);

$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
$graph->xaxis->SetColor("black");


// Some extra margin looks nicer

$graph->xaxis->SetLabelMargin(10);



// Label align for X-axis

$graph->xaxis->SetLabelAlign('center','top');

$graph->xaxis->SetLabelAngle(90);

// Add some grace to y-axis so the bars doesn't go

// all the way to the end of the plot area

$graph->yaxis->scale->SetGrace(20);
//$graph->yaxis->SetLabelFormat('%0.0fh');







// Now create a bar pot

$bplot = new BarPlot($datay);


//création de la ligne du cumul
$lplot = new LinePlot($dataycumul);

// Add the bar and line to the graph

$graph->Add($bplot);
$graph->Add($lplot);
$bplot->SetFillColor("orange");
$bplot->SetColor("black");
$bplot->SetLegend("Par mois");


//mise en forme de la ligne 
$lplot->SetBarCenter();
$lplot->SetColor("blue");
$lplot->SetLegend("Cumulé");
$lplot->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$lplot->mark->SetWeight(3);
$lplot->mark->SetWidth(5);
$lplot->mark->setColor("red");
$lplot->mark->setFillColor("red");
$lplot->value->Show();
$lplot->value->SetFormat('%0.1fh');



//You can change the width of the bars if you like

$bplot->SetWidth(0.8);



// We want to display the value of each bar at the bottom

$bplot->value->Show();

$bplot->value->SetFont(FF_VERDANA,FS_NORMAL,8);



$bplot->SetValuePos('bottom');

$bplot->value->SetColor("black","red");

$bplot->value->SetFormat('%0.1fh');







// .. and stroke the graph

$graph->Stroke();

?>