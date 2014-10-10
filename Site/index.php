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

/* l'utilisateur est connecté */
if (isset($_SESSION['studyLogin']) || isset($_SESSION['teachLogin']) || !empty($_COOKIE['teachLogin']) || !empty($_COOKIE['studyLogin']))
{
	$loginUtilisateur = "";
	$user = array();
	/* l'utilisateur connecté est un étudiant */
	if (isset($_SESSION['studyLogin']) ||!empty($_COOKIE['studyLogin']))
	{
		if (isset($_SESSION['studyLogin']))
		{
			$loginUtilisateur = $_SESSION['studyLogin'];
		}
		else
		{
			$loginUtilisateur = $_COOKIE['studyLogin'];
		}
		include('script/getStudyInfos.php');
	}
	/* l'utilisateur connecté est un enseignant */
	else if (isset($_SESSION['studyLogin']) || !empty($_COOKIE['teachLogin']))
	{
		if (isset($_SESSION['studyLogin']))
		{
			$loginUtilisateur = $_SESSION['studyLogin'];
		}
		else
		{
			$loginUtilisateur = $_COOKIE['studyLogin'];
		}
		include('script/getTeachInfos.php');
	}
	
	$smarty->assign("user", $user);
	
	if (isset($_GET['page']))
	{
		if ($_GET['page' ] == "deconnection")
		{
			include('script/disconnect.php');
			$smarty->assign("successMsg", "Déconnection reussie");
			$smarty->display("template/login.tpl");
		}
		else if ($_GET['page' ] == "module")
		{
			$smarty->display("template/module.tpl");
		}
		else if ($_GET['page' ] == "heure")
		{
			$smarty->display("template/heures.tpl");
		}
		else if ($_GET['page' ] == "export")
		{
			$smarty->display("template/exportPDF.tpl");
		}
		else if ($_GET['page' ] == "maconfig")
		{
			$smarty->display("template/maConfig.tpl");
		}
		else if ($_GET['page' ] == "RSS")
		{
			$smarty->display("template/fluxRSS.tpl");
		}
		else if ($_GET['page' ] == "droits")
		{
			$smarty->display("template/droits.tpl");
		}
		else if ($_GET['page' ] == "tools")
		{
			$smarty->display("template/tools.tpl");
		}
		else
		{
			$smarty->display("template/index.tpl");
		}
	}
	else
	{
		$smarty->display("template/index.tpl");
	}
}
/* l'utilisateur n'est pas connecté */
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
		else if (isset($_GET['successId']) && !empty($_GET['successId']))
		{
			$msg = "";
			if($_GET['successId'] == 1)
			{
				$msg = "Votre mot de passe a été modifié";
			}
			$smarty->assign("successMsg", $msg);
		}

		$smarty->display("template/login.tpl");
	}
}
?>