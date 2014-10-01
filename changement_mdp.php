

<?php



error_reporting(E_ALL);



include("config.php");





//compteur de pages vues
//compteur de pages vues
$sql="SELECT valeur FROM compteur WHERE id_compteur='1'";
$compteur_req=$dbh->query($sql);
$compteur_res=$compteur_req->fetchAll();
$compteur=$compteur_res['0']['valeur'];
$sql="UPDATE compteur SET valeur=valeur+1 WHERE id_compteur='1'";
$dbh->exec($sql);


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>

<head>

<link rel="icon" type="image/x-icon" href="http://www.favicon.cc/favicon/15/38/favicon.png" >

<title><?php echo $nom_fenetre; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" href="css/changement_mdp.css" type="text/css" >





</head>

<body>







<?php

if (isset($_POST['nmotpasse1']) and isset($_POST['nmotpasse2'])and isset($_POST['amotpasse'])and isset($_POST['login']) and $_POST['nmotpasse1']==$_POST['nmotpasse2'])

{

$login=$_POST['login'];
$ancien_mot_passe=md5($_POST['amotpasse']);
$nouveau_mot_passe=md5($_POST['nmotpasse1']);


	

$sql="select * from login_prof where login=:login and motPasse=:ancien_mot_passe";
$req_login=$dbh->prepare($sql);
$req_login->execute(array(':login'=>$login,':ancien_mot_passe'=>$ancien_mot_passe));
$res_login=$req_login->fetchAll();

if (count($res_login)>0)


{
$sql="update  login_prof set motPasse=:nouveau_mot_passe WHERE login=:login and motPasse=:ancien_mot_passe";
$req_login_maj=$dbh->prepare($sql);
$req_login_maj->execute(array(':login'=>$login,':nouveau_mot_passe'=>$nouveau_mot_passe,':ancien_mot_passe'=>$ancien_mot_passe));


echo '<div style="width:155px;margin-left:auto;margin-right:auto;">Mot de passe changé<br>';

echo '<a href="index.php">Retour à la page d\'accueil</a><br></div><br>';

}

else

{

echo '<div style="width:270px;margin-left:auto;margin-right:auto;">Problème : vous avec fait une erreur de saisie<br>';

echo '<a href="index.php">Retour à la page d\'accueil</a><br></div><br>';

}



}



else

{

?>

<div style="width:331px;margin-left:auto;margin-right:auto;">

<form  action="changement_mdp.php"     method="post">



Login

<input name="login" id="login" type="text"   size="12"><br>

Ancien mot de passe :

<input name="amotpasse" id="amotpasse" type="password"   size="12"><br>

Nouveau mot de passe :

<input name="nmotpasse1" id="nmotpasse1" type="password"   size="12"><br>

Retappez votre nouveau mot de passe :

<input name="nmotpasse2" id="nmotpasse2" type="password"  size="12"><br>

<input name="Input" type="submit" value="Changer de mot de passe !">

</form>

<br><a href="index.php">Retour à la page d'accueil</a><br></div><br><br>



<?php

}

?>





<div style="width:740px;margin-left:auto;margin-right:auto;">



D&eacute;velopp&eacute; par <span style="font-weight:bold;">COLOMBIER Ga&euml;tan</span> (GMP) et par <span style="font-weight:bold;">MILLION Bruno</span> (SITEC)  pour le PST de Ville d'Avray - <?php echo $compteur; ?> pages vues <br>

</div>

</body>

</html>






