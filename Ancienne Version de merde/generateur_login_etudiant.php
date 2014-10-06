<?php

include("config.php");



$sql="SELECT * FROM ressources_etudiants WHERE identifiant='' AND nom!='' AND prenom!=''";
$req_etudiant=$dbh->query($sql);
$res_etudiant=$req_etudiant->fetchAll();

echo "Utilisateurs sans login :<br>";
//preparation requete pour boucles suivantes
$sql="SELECT * FROM ressources_etudiants WHERE identifiant=:identifiant";
$req_identifiant=$dbh->prepare($sql);

$sql="UPDATE ressources_etudiants SET identifiant=:identifiant WHERE codeEtudiant=:codeEtudiant";
$req_update=$dbh->prepare($sql);

	foreach ($res_etudiant as $res)



    {

    echo "- Le login de ".$res['nom']."  ".$res['prenom']." est : ";

    $trans=array(" " => "","-" => "","_" =>"", "é" => "e", "è" => "e", "ë" => "e", "ê" => "e", "î" => "i", "ï" => "i", "ô" => "o");

    $indice=1;


    do {

    $identifiant=substr(strtr($res['prenom'], $trans),0,1).substr(strtr($res['nom'], $trans),0,6).$indice;


$req_identifiant->execute(array(':identifiant'=>$identifiant));
$res_identifiant=$req_identifiant->fetchAll();


    $indice++;

    }
    while(count($res_identifiant)>0);


    echo strtolower($identifiant).".<br>";



$req_update->execute(array(':identifiant'=>$identifiant,':codeEtudiant'=>$res['codeEtudiant']));

  

    }