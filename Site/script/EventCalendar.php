<?php
/*
*
* Avec connection a la bdd
*
*/
session_start();
include('../config/config.php');

$start = $_REQUEST['from'] / 1000;
$end   = $_REQUEST['to'] / 1000;
$loginUtilisateur = "";
      
 if (isset($_SESSION['teachLogin']))
{
    $loginUtilisateur = $_SESSION['teachLogin'];
}
else
{
    $loginUtilisateur = $_COOKIE['teachLogin'];
}

$out = array();
$sql=sprintf('SELECT seances.dateSeance, seances.heureSeance, seances.dureeSeance,
                enseignements.nom, enseignements.couleurFond,enseignements.alias,
                enseignements.codeTypeSalle, types_activites.codeTypeActivite, types_activites.alias,
                matieres.couleurFond, matieres.nom, login_prof.login
                FROM seances
                LEFT JOIN seances_profs ON seances.codeSeance = seances_profs.codeSeance
                LEFT JOIN enseignements ON seances.codeEnseignement = enseignements.codeEnseignement
                RIGHT JOIN matieres ON matieres.codeMatiere = enseignements.codeMatiere
                LEFT JOIN login_prof ON login_prof.codeprof = seances_profs.codeRessource
                INNER JOIN types_activites on enseignements.codeTypeActivite = types_activites.codeTypeActivite
                WHERE seances_profs.deleted =  "0"
                AND seances.deleted =  "0"
                AND matieres.deleted =  "0"
                AND matieres.deleted =  "0"
                AND seances.annulee =  "0"
                AND login_prof.login = '.$dbh->quote($loginUtilisateur, PDO::PARAM_STR));

$req = $dbh->prepare($sql);
$req->execute();

$out = array();
while($ligneCode = $req->fetch()) {
    $date = explode("-",$ligneCode['dateSeance']);
        
    if(strlen($ligneCode['heureSeance']) > 3)
    {
        $debut = $ligneCode['dateSeance']." ".substr($ligneCode['heureSeance'],0,2).":".substr($ligneCode['heureSeance'],2,2).":00.0";
        if($ligneCode['dureeSeance'] == "130")
        {
            $fHeure = substr($ligneCode['heureSeance'],0,2)+substr($ligneCode['dureeSeance'],0,1);
            $fin = $ligneCode['dateSeance']." ".$fHeure.":".substr($ligneCode['heureSeance'],2,2)+substr($ligneCode['dureeSeance'],1,2).":00.0";
            $temps = substr($ligneCode['heureSeance'],0,2)+substr($ligneCode['dureeSeance'],0,1);
        }
        else
        {
            $fHeure = substr($ligneCode['heureSeance'],0,2)+substr($ligneCode['dureeSeance'],0,1);
           $fin = $ligneCode['dateSeance']." ".$fHeure.":".substr($ligneCode['heureSeance'],2,2).":00.0"; 
            $temps = substr($ligneCode['heureSeance'],0,2)+substr($ligneCode['dureeSeance'],0,1);
        }
    }
    else
    {
        $debut = $ligneCode['dateSeance']." ".substr($ligneCode['heureSeance'],0,1).":".substr($ligneCode['heureSeance'],1,2).":00.0"; 
        if($ligneCode['dureeSeance'] == "130")
        {
            $fHeure = substr($ligneCode['heureSeance'],0,1)+substr($ligneCode['dureeSeance'],0,1);
            $fin = $ligneCode['dateSeance']." ".$fHeure.":".substr($ligneCode['heureSeance'],2,2)+substr($ligneCode['dureeSeance'],1,2).":00.0";
            $temps = substr($ligneCode['heureSeance'],0,1)+substr($ligneCode['dureeSeance'],0,1);
            }
        else
        {
            $fHeure = substr($ligneCode['heureSeance'],0,1)+substr($ligneCode['dureeSeance'],0,1);
            $fin = $ligneCode['dateSeance']." ".$fHeure.":".substr($ligneCode['heureSeance'],2,2).":00.0";
            $temps = substr($ligneCode['heureSeance'],0,1)+substr($ligneCode['dureeSeance'],0,1);
        }
    }
        
    $timeDebut = strtotime($debut);
    $newFormatDebut = date('Y-m-d H:i:s', $timeDebut);
    $timeFin = strtotime($fin);
    $newFormatFin = date('Y-m-d H:i:s', $timeFin);

    if($ligneCode['codeTypeActivite'] == 1) //CM
    {
        $eventC = 'event-info';
    }
    else if($ligneCode['codeTypeActivite'] == 2) //TD
    {
        $eventC = 'event-warning';
    }
    else if($ligneCode['codeTypeActivite'] == 3) //TP
    {
        $eventC = 'event-success';
    }
    else if($ligneCode['codeTypeActivite'] == 4) //PRO
    {
       $eventC = 'event-success';
    }
    else if($ligneCode['codeTypeActivite'] == 5) //STA
    {
        $eventC = 'event-info';
    }
    else if($ligneCode['codeTypeActivite'] == 6) //ADM
    {
        $eventC = 'event-special';
    }
    else if($ligneCode['codeTypeActivite'] == 7) //TUT
    {
        $eventC = 'event-special';
    }
    else if($ligneCode['codeTypeActivite'] == 8) //DS
    {
        $eventC = 'event-3';
    }
    else if($ligneCode['codeTypeActivite'] == 9) //TP APP
    {
        $eventC = 'event-special';
    }
       
    $out[] = array(
        'id' => $ligneCode['nom'],
        'title' =>$ligneCode['alias'] ." - ". str_replace(" ", "h",date("H i",$timeDebut)) ." - ". str_replace(" ", "h",date("H i",$timeFin)) ." ". $ligneCode['nom'],
        'url' => "",
        'class' => $eventC,
        'start' => $timeDebut*1000,
        'end' => $timeFin*1000
    );
}
echo json_encode(array('success' => 1, 'result' => $out));
$req->closeCursor();
exit;


/*
*
* Sans connection a la bdd
*
*/
/*
$out = array();
 
 for($i=1; $i<=15; $i++){ 	//from day 01 to day 15
	$data = date('Y-m-d', strtotime("+".$i." days"));
	$out[] = array(
     	'id' => $i,
		'title' => 'Event name '.$i,
		'url' => "",
		'class' => 'event-important',
		'start' => strtotime($data).'000',
		'end' => strtotime($data).'999'
	);
}
//print_r($out);
echo json_encode(array('success' => 1, 'result' => $out));
exit;
*/
?>