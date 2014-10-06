<?php

include("config.php");



//parcours de la liste des profs

$sql="SELECT * FROM ressources_profs WHERE deleted=0 ";
$req_prof=$dbh->query($sql);
$res_prof=$req_prof->fetchAll();
echo "Utilisateurs sans login :<br>";
//preparation requete pour boucles suivantes
$sql="SELECT * FROM login_prof WHERE codeProf=:prof";
$req_verif=$dbh->prepare($sql);

$sql="SELECT * FROM login_prof WHERE login=:identifiant";
$req_test=$dbh->prepare($sql);

foreach ($res_prof as $res)


	{

	//verification si prof a deja un login

	$prof=$res['codeProf'];

$req_verif->execute(array(':prof'=>$prof));
$res_verif=$req_verif->fetchAll();

	//si prof a pas de login creation login et mot de passe


$verif='';
foreach ($res_verif as $res_verification)
	{
	$verif=$res_verification['codeProf'];
	}
		
	if ($verif=='')

		{

		echo "- Pour ".ucwords(strtolower($res['nom']))."  ".ucwords(strtolower($res['prenom'])).", ";

		$initiale_prenom=substr($res['prenom'],0,1);
	$nom=$res['nom'];		
		$caractere = Array('/\-/', '/\_/', '/\ /', '/\(/', '/\)/');
       

$nom=preg_replace($caractere,"",$nom);
		
		
		
		$nom=substr($nom,0,6);

		$indice=1;

		$identifiant=$initiale_prenom.$nom.$indice;

		$identifiant=strtolower($identifiant);

		$motPasse=strtolower($res['prenom']);
		$mem_motPasse=$motPasse;
		$motPasse=md5($motPasse);

		//test si login unique et si pas homonyme

do

			{
$req_test->execute(array(':identifiant'=>$identifiant));
$res_test=$req_test->fetchAll();


$test='';
foreach ($res_test as $res_tests)
	{
	$test=$res_tests['login'];
	}


if ($test!="")
{
			//creation d un autre login si homonyme

			$indice=$indice+1;

			$identifiant=$initiale_prenom.$nom.$indice;

			$identifiant=strtolower($identifiant);


}
			}
while ($test!="");


		

		echo "le login est ".$identifiant;

		//ajout du login et du mot de passe dans la table login_prof
/*
		$req3="INSERT INTO login_prof (codeProf,login,motPasse) VALUES ('".$res['codeProf']."','$identifiant','$motPasse')";

		mysql_query($req3)or die(mysql_error());
*/
$sql="INSERT INTO login_prof (codeProf,login,motPasse) VALUES (:codeProf,:identifiant,:motPasse)";
$req_update=$dbh->prepare($sql);
$req_update->execute(array(':codeProf'=>$res['codeProf'],':identifiant'=>$identifiant,':motPasse'=>$motPasse));

		echo " et le mot de passe est ".$mem_motPasse.".<br>";

		}
		

	}