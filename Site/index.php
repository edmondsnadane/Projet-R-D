<?php

session_start();

require('API/Smarty/Smarty.class.php'); // On inclut la classe Smarty

$smarty = new Smarty();

include('config/config.php');
					
//compteur de pages vues
$sql="SELECT valeur FROM compteur WHERE id_compteur='1'";
$compteur_req=$dbh->query($sql);
$compteur_res=$compteur_req->fetchAll();
$compteur=$compteur_res['0']['valeur'];
$smarty->assign("compteur", $compteur);

if (isset($_SESSION['login']) && isset($_SESSION['codeProf']))
{
	// chargement vue prof
}
else if (isset($_SESSION['login']))
{
	// chargement vue étudiant
}
else
{
	if (isset($_GET['page']) && $_GET['page'] == "version")
	{
		// chargement vue de versions
	}
	else
	{
		if (isset($_GET['errorID']) && !empty($_GET['errorID']))
		{	
			$msg = "";
			if($_GET['errorID'] == 1)
			{
				$msg = "Vous n'avez pas saisi toutes les informations";
			}
			elseif ($_GET['errorID'] == 2)
			{
				$msg = "L'utilisateur saisi n'existe pas";
			}
			elseif ($_GET['errorID'] == 3)
			{
				$msg = "La modification de mot de passe a echoué. Les variables saisies ne sont pas correctes";
			}
			
			$smarty->assign("errorMsg", $msg);
		}

		$smarty->display("template/login.tpl");
	}
}
?>