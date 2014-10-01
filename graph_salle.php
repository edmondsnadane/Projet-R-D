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




include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_bar.php");
include ("jpgraph/src/jpgraph_line.php");



 unset ($req_zone);
$sql="SELECT * FROM zones_salles WHERE zones_salles.deleted='0' order by nom";
$req_zone=$dbh->query($sql);
$res_zone=$req_zone->fetchAll();

		foreach ($res_zone as $zone)
			{
 unset ($req_salle);
$sql="SELECT *  FROM ressources_salles WHERE ressources_salles.codeZoneSalle=".$zone['codeZoneSalle']." and ressources_salles.deleted=0";
$req_salle=$dbh->query($sql);
$res_salle=$req_salle->fetchAll();			
$nb_salle=count($res_salle);			

//compte combien il y a de minutes par zone
$duree_en_min_cumul=0;

//durée des séances
 unset ($req_seance);
$sql="SELECT *  FROM seances_salles left join seances on seances.codeSeance=seances_salles.codeSeance left join ressources_salles on ressources_salles.codeSalle=seances_salles.CodeRessource WHERE ressources_salles.codeZoneSalle=".$zone['codeZoneSalle']." and seances_salles.deleted='0' and seances.deleted='0' and ressources_salles.deleted=0";
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


$duree_en_min_cumul+=$heureduree*60+	$minduree;
}

//durée des réservations
 unset ($req_seance);
$sql="SELECT *  FROM reservations_salles left join reservations on reservations.codeReservation=reservations_salles.codeReservation left join ressources_salles on ressources_salles.codeSalle=reservations_salles.CodeRessource WHERE ressources_salles.codeZoneSalle=".$zone['codeZoneSalle']." and reservations_salles.deleted='0' and reservations.deleted='0' and ressources_salles.deleted=0";
$req_seance=$dbh->query($sql);
$res_seance=$req_seance->fetchAll();
$duree_en_min=0;
		foreach ($res_seance as $seance)
			{
	if (strlen($seance['dureeReservation'])==4)
		{
		$heureduree=substr($seance['dureeReservation'],0,2);
		$minduree=substr($seance['dureeReservation'],2,2);
		}
	if (strlen($seance['dureeReservation'])==3)
		{
		$heureduree=substr($seance['dureeReservation'],0,1);
		$minduree=substr($seance['dureeReservation'],1,2);
		}
	if (strlen($seance['dureeReservation'])==2)
		{
		$heureduree=0;
		$minduree=$seance['dureeReservation'];
		}
	if (strlen($heureduree)==1)
		{
		$heureduree="0".$heureduree;
		}


$duree_en_min_cumul+=$heureduree*60+	$minduree;
}




//$datay[] = $nb_salle;
$datay[] = $duree_en_min_cumul/(1120*60*$nb_salle)*100;

$datax[] = $zone['nom'];

}




//mise en forme du graphique


// taille du graph

$width=750;

$height=550;



// Set the basic parameters of the graph

$graph = new Graph($width,$height,'auto');

$graph->SetScale("textlin");



// set margin

$graph->SetMargin(50,20,50,160);







// Setup title
$graph->title->Set("Taux d'occupation des salles");
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
$graph->yaxis->SetLabelFormat('%0.0f %%');






// Now create a bar pot

$bplot = new BarPlot($datay);




// Add the bar and line to the graph

$graph->Add($bplot);
$bplot->SetFillColor("orange");
$bplot->SetColor("black");




//You can change the width of the bars if you like

$bplot->SetWidth(0.8);



// We want to display the value of each bar at the bottom

$bplot->value->Show();

$bplot->value->SetFont(FF_VERDANA,FS_NORMAL,10);



$bplot->SetValuePos('top');

$bplot->value->SetColor("black","red");

$bplot->value->SetFormat('%0.0f %%');




$graph->footer-> center->Set("Hypothese : 1120h/an" );
$graph->footer-> center-> SetColor("black");
$graph->footer-> center-> SetFont( FF_FONT2, FS_BOLD);



// .. and stroke the graph

$graph->Stroke();

?>