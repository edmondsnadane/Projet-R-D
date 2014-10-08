<?php
session_start();

include('../config/config.php');

if(isset($_POST['loginTeach']) && isset($_POST['oldMdp']) && isset($_POST['newMdp1']) && isset($_POST['newMdp2']) && !empty($_POST['loginTeach']) && !empty($_POST['oldMdp']) && !empty($_POST['newMdp1']) && !empty($_POST['newMdp2']))
{   	       		
	if ($_POST['newMdp1'] == $_POST['newMdp2'])
	{
		// liaison base de données pour modifier le mot de passe
	}
	else
	{
		header('Location: ../index.php?errorID=3');
		exit();
	}
}
else
{
	header('Location: ../index.php?errorID=3');
	exit();
}
?>