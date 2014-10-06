<?php

session_start();

error_reporting(E_ALL);
//error_reporting(0);
 




include("config.php");

//creation des cookies prof
if (isset ($_POST['cookieprof']))
{
 if ($_POST['cookieprof']==1)
 {
setcookie('vtlogprof', $_POST['loginvrac'], time() + 365*24*3600); 
$password=md5($_POST['password']);
setcookie('vtmdpprof', $password, time() + 365*24*3600); 
 }
}



//creation des cookies etudiant
if (isset($_POST['cookieetudiant']))
{
 if ($_POST['cookieetudiant']==1)
 {
setcookie('vtlogetudiant', $_POST['loginstudent'], time() + 365*24*3600); 
setcookie('vtlogetudiantlar', $_POST['larg'], time() + 365*24*3600); 
setcookie('vtlogetudianthau', $_POST['haut'], time() + 365*24*3600); 
	
 }
}


//suppression des cookies prof et etudiant
if (isset ($_GET['disconnect']) && ( isset ($_COOKIE['vtlogprof']) || isset ($_COOKIE['vtlogetudiant'])  ))
{
 if ($_GET['disconnect']=="true" && ($_COOKIE['vtlogprof']!="" || $_COOKIE['vtlogetudiant']!=""))
 {
setcookie('vtlogprof', "", time() - 365*24*3600); 

setcookie('vtmdpprof', "", time() - 365*24*3600); 
setcookie('vtlogetudiant', "", time() - 365*24*3600); 
setcookie('vtlogetudiantlar', "", time() - 365*24*3600); 
setcookie('vtlogetudianthau', "", time() - 365*24*3600); 
header('Location: index.php?disconnect=true');
 }
}





 
//affichage du samedi ou du dimanche

	if ($samedi=='1' && $dimanche=='0')
		{
		$days='6';
		}
	elseif ( $dimanche=='1')
		{
		$days='7';
		}
	else
		{
		$days='5';
		}

	

//compteur de pages vues
$sql="SELECT valeur FROM compteur WHERE id_compteur='1'";
$compteur_req=$dbh->query($sql);
$compteur_res=$compteur_req->fetchAll();
$compteur=$compteur_res['0']['valeur'];


$sql="UPDATE compteur SET valeur=valeur+1 WHERE id_compteur='1'";
$dbh->exec($sql);


	
	
	
//recuperation de variables

if(!isset($_GET['current_year']))
{
    $current_year=date("o");
}
else
{
    $current_year=$_GET['current_year'];
}


if(!isset($_GET['current_week']))
{
    $current_week=date('W');
}
else
{
    $current_week=$_GET['current_week'];
}


if(isset($_GET['current_prof']))
{
    $current_prof=$_GET['current_prof'];
}
else
{
$current_prof="";
	}

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}	

if(isset($_SESSION['logged_prof_smart_perso']))
{
    $current_prof2=$_SESSION['logged_prof_smart_perso'];
}
else
{
$current_prof2="";
}
	
if(!isset($_POST['logintype']))
{
$_POST['logintype']="";
}
if(!isset($_POST['password']))
{
$_POST['password']="";
}
if(!isset($_GET['disconnect']))
{
$_GET['disconnect']="";
}
if(!isset($_POST['loginmodule']))
{
$_POST['loginmodule']="";
}
if(!isset($_POST['loginvrac']))
{
$_POST['loginvrac']="";
}
if(!isset($_POST['loginprof']))
{
$_POST['loginprof']="";
}
if(!isset($_POST['loginstudent']))
{
$_POST['loginstudent']="";
}

	

if(isset($_SESSION['logged_prof_perso']))
{
    $current_prof2=$_SESSION['logged_prof_perso'];
}
else
{
$current_prof2="";
}


if(isset($_GET['current_salle']))
{
    $current_salle=$_GET['current_salle'];
}
	
	
if(isset($_GET['smartphone']))
	{
	$smartphone=$_GET['smartphone'];

	}
else
	{
	$smartphone="";
	}	
	

$salles_multi=array();
if (isset ($_GET['salles_multi']))
{
$salles_multi=$_GET['salles_multi'];
}

$materiels_multi=array();
if (isset ($_GET['materiels_multi']))
{
$materiels_multi=$_GET['materiels_multi'];
}

$groupes_multi=array();
if (isset ($_GET['groupes_multi']))
{
$groupes_multi=$_GET['groupes_multi'];
}






//nombre de profs à afficher
$profs_multi=array();
if (isset ($_GET['profs_multi']))
{
$profs_multi=$_GET['profs_multi'];
}



if(isset($_GET['codeProf']))

    $codeProf=$_GET['codeProf'];

if(isset($_POST['codeProf']))

    $codeProf=$_POST['codeProf'];


$current_student="";
if(isset($_GET['current_student']))
{
    $current_student=$_GET['current_student'];
}
if(isset($_POST['current_student']))
{
    $current_student=$_POST['current_student'];	
}


//on recupere aussi la taille de l ecran qui provient de la page de login en post et non pas en get

if (isset($_POST['larg']))

	{

	$largeur=$_POST['larg']-50;

	if ($largeur<750)

		{

		$largeur=750;

		}

	$hauteur=$_POST['haut']-260;

	if ($hauteur<500)

		{

		$hauteur=500;

		}

	}

//heure de début et de fin de journée
$starttime=$heure_debut_journee;
$endtime=$heure_fin_journee;

//heure de début et de fin de la pause de midi
$lunchstart=$heure_debut_pause_midi;
$lunchstop=$heure_fin_pause_midi;


// 1er Jour de la semaine

$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 

$jsem=date("w",$lundi);

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem),$current_year); 

$current_day=date("Y-m-d",$lundi);






	if (isset($_GET['horiz']))

		$horizon=$_GET['horiz'];

	else

		$horizon="1"; 
if($horizon==4)
{

// 1er lundi du mois



$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}
$jour_quelconque=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 
$jsem=date("w",$jour_quelconque);
$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem),$current_year); 

$datedujour=date("d",$lundi);


//normalement, il faut afficher 6 semaines pour être sûr d'avoir tout le temps les 30 ou 31 jours d'affichés en même temps or dans l'interface on n'affiche que 5 semaines.
//Normalement, si le 31 est un mardi, il faut afficher 6 semaines. idem si le 30 ou 31 sont un lundi. si c'est le cas, on affiche le mois suivant et $numerosemainedanslemois sera = à 0.
if ($datedujour==30 || $datedujour==31)
{
$numerosemainedanslemois=0;
}
else
{

$numerosemainedanslemois = intval($datedujour/7);
}


$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-($numerosemainedanslemois*7),$current_year); 

$datedujour=date("d",$lundi);

// pour les cas foireux par exemple mai2009

if ($datedujour>2 && $datedujour<22) 

{

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7),$current_year); 

//pour l affichage de la semaine courante dans une autre couleur j ai besoin de la ligne suivante

$numerosemainedanslemois=$numerosemainedanslemois+1;

}

$current_day=date("Y-m-d",$lundi);


}











// Pour le calcul de la durée de traitement

$debut = explode(" ",microtime());

$debut = $debut[1]+$debut[0];



	

//ajout rendez vous perso	

if (isset($_POST['ajout_reservation']))

	{

		

	//mise en forme de la date de la reservation

	$dateseance=$_POST['date'];



	$dateseance=str_replace("-","",$dateseance);

	$annee_reservation=substr($dateseance,4,4);

	$mois_reservation=substr($dateseance,2,2);

	$jour_reservation=substr($dateseance,0,2);

	$date_reservation=$annee_reservation."-".$mois_reservation."-".$jour_reservation;
	
	//test si la date rentrée est une vraie date et pas un truc farfelu 
	$format_date_correct=checkdate($mois_reservation,$jour_reservation,$annee_reservation);
	

	//mise en forme de l heure de debut

	$heure_debut_reservation=$_POST['heure_d'].$_POST['minute_d'];

	

	//diffusable ou pas

	$prive=$_POST['prive'];

		

	//mise en forme de la duree

	$heure_debut_en_min=$_POST['heure_d']*60+$_POST['minute_d'];

	$heure_fin_en_min=$_POST['heure_f']*60+$_POST['minute_f'];

	$duree_en_minute=$heure_fin_en_min - $heure_debut_en_min;

	$duree_heure_en_heure=intval($duree_en_minute/60);

	$duree_minute_en_heure=$duree_en_minute%60;

	if (strlen($duree_minute_en_heure)=='1')

					{

						$duree_minute_en_heure="0".$duree_minute_en_heure;

					}

	$duree_en_heure=$duree_heure_en_heure.$duree_minute_en_heure;

	

	//mise en forme datemodif et datecreation

	$jour=date('d');

	$mois=date('m');

	$annee=date('Y');

	$heure=date('H');

	$minute=date('i');

	$seconde=date('s');

	$date_modif_creation=$annee."-".$mois."-".$jour." ".$heure."-".$minute."-".$seconde;

	$commentaire=strip_tags($_POST['texte']);

	$commentaire=preg_replace("/[\/\\\*\<\>\(\)\?\;\!\%]/","",$commentaire);



	

	if ($duree_en_heure>'0' && $heure_debut_reservation!='000' && $annee_reservation!='0000' && $mois_reservation!='00' && $jour_reservation!='00' && $jour_reservation<='31' && $mois_reservation<='12' && $annee_reservation>'2007' && $format_date_correct=='1')

	{
	$sql="INSERT INTO reservations (commentaire,dateReservation,heureReservation,dureeReservation,dateModif,codeProprietaire,diffusable,dateCreation) VALUES (:commentaire, :date_reservation,:heure_debut_reservation,:duree_en_heure,:date_modif_creation,'999',:prive,:date_modif_creation) ";
	$req_ajout_reservation=$dbh->prepare($sql);
	$req_ajout_reservation->execute(array(':commentaire'=>$commentaire,':date_reservation'=>$date_reservation,':heure_debut_reservation'=>$heure_debut_reservation,':duree_en_heure'=>$duree_en_heure,':date_modif_creation'=>$date_modif_creation,':prive'=>$prive,':date_modif_creation'=>$date_modif_creation));


	
	$sql="SELECT * FROM reservations WHERE commentaire=:commentaire  and dateModif=:date_modif_creation and deleted= '0'";
	$req_ajout_reservation2=$dbh->prepare($sql);
	$req_ajout_reservation2->execute(array(':commentaire'=>$commentaire,':date_modif_creation'=>$date_modif_creation));
	$ressource_ajout_reservation2=$req_ajout_reservation2->fetchAll();


$codereservation=$ressource_ajout_reservation2['0']['codeReservation'];


	$sql="INSERT INTO reservations_profs (codeReservation,codeRessource,dateModif,deleted,codeProprietaire) VALUES (:codereservation,:current_prof2,:date_modif_creation,'0','999') ";
	$req_ajout_reservation3=$dbh->prepare($sql);
	$req_ajout_reservation3->execute(array(':codereservation'=>$codereservation,':current_prof2'=>$current_prof2,':date_modif_creation'=>$date_modif_creation));

	}

	unset($_POST['ajout_reservation']);


	}

	

	

//modifier rendez vous perso	

if (isset($_POST['modif_reservation']))

	{

	$codeResa=$_POST['codeResa'];



	
	$sql="SELECT * FROM reservations_profs WHERE codeReservation=:codeResa ";
	$req_modif_reservation=$dbh->prepare($sql);
	$req_modif_reservation->execute(array(':codeResa'=>$codeResa));
	$ressource_modif_reservation=$req_modif_reservation->fetchAll();
	



	if ($ressource_modif_reservation['0']['codeRessource']==$_SESSION['logged_prof_perso'] || $ressource_modif_reservation['0']['codeRessource']==$_SESSION['logged_prof_smart_perso'])

{	
	//mise en forme de la date de la reservation

	$dateseance=$_POST['date'];



	$dateseance=str_replace("-","",$dateseance);

	$annee_reservation=substr($dateseance,4,4);

	$mois_reservation=substr($dateseance,2,2);

	$jour_reservation=substr($dateseance,0,2);

	$date_reservation=$annee_reservation."-".$mois_reservation."-".$jour_reservation;

	//test si la date rentrée est une vraie date et pas un truc farfelu 
	$format_date_correct=checkdate($mois_reservation,$jour_reservation,$annee_reservation);

	//mise en forme de l heure de debut

	$heure_debut_reservation=$_POST['heure_d'].$_POST['minute_d'];

	

	//diffusable ou pas

	$prive=$_POST['prive'];

	
		

	//mise en forme de la duree

	$heure_debut_en_min=$_POST['heure_d']*60+$_POST['minute_d'];

	$heure_fin_en_min=$_POST['heure_f']*60+$_POST['minute_f'];

	$duree_en_minute=$heure_fin_en_min - $heure_debut_en_min;

	$duree_heure_en_heure=intval($duree_en_minute/60);

	$duree_minute_en_heure=$duree_en_minute%60;

	if (strlen($duree_minute_en_heure)=='1')

					{

						$duree_minute_en_heure="0".$duree_minute_en_heure;

					}

	$duree_en_heure=$duree_heure_en_heure.$duree_minute_en_heure;

	

	//mise en forme datemodif et datecreation

	$jour=date('d');

	$mois=date('m');

	$annee=date('Y');

	$heure=date('H');

	$minute=date('i');

	$seconde=date('s');

	$date_modif_creation=$annee."-".$mois."-".$jour." ".$heure."-".$minute."-".$seconde;

	$commentaire=strip_tags($_POST['texte']);

	$commentaire=preg_replace("/[\/\\\*\<\>\(\)\?\;\!\%]/","",$commentaire);

	

	

	if ($duree_en_heure>'0' && $heure_debut_reservation!='000' && $annee_reservation!='0000' && $mois_reservation!='00' && $jour_reservation!='00' && $jour_reservation<='31' && $mois_reservation<='12' && $annee_reservation>'2007' && $format_date_correct=='1')

	{

	$sql="update reservations set commentaire=:commentaire,dateReservation=:date_reservation,heureReservation=:heure_debut_reservation,dureeReservation=:duree_en_heure,diffusable=:prive where codeReservation=:codeResa ";
	$req_modif_reservation=$dbh->prepare($sql);
	$req_modif_reservation->execute(array(':commentaire'=>$commentaire,':date_reservation'=>$date_reservation,':heure_debut_reservation'=>$heure_debut_reservation,':duree_en_heure'=>$duree_en_heure,':prive'=>$prive,':codeResa'=>$codeResa));

	
}	

	

	

	}

	unset($_POST['modif_reservation']);

	

	

	}	

	



//suppression rendez vous perso

if (isset($_POST['supp_reservation']) )

	{
	$codeResa=$_POST['codeResa'];
	
	$sql="SELECT * FROM reservations_profs WHERE codeReservation=:codeResa ";
	$req_supp_reservation=$dbh->prepare($sql);
	$req_supp_reservation->execute(array(':codeResa'=>$codeResa));
	$ressource_supp_reservation=$req_supp_reservation->fetchAll();
	
		if ($ressource_supp_reservation['0']['codeRessource']==$_SESSION['logged_prof_perso'] || $ressource_supp_reservation['0']['codeRessource']==$_SESSION['logged_prof_smart_perso'])
		{
		
		$sql="update  reservations set deleted='1' WHERE codeReservation=:codeResa ";
		$req_supp_reservation=$dbh->prepare($sql);
		$req_supp_reservation->execute(array(':codeResa'=>$codeResa));

		$sql="update  reservations_profs set deleted='1' WHERE codeReservation=:codeResa ";
		$req_supp_reservation2=$dbh->prepare($sql);
		$req_supp_reservation2->execute(array(':codeResa'=>$codeResa));	
		
		}

	}

	

	

?>

	



<?php
if ((stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || stristr($_SERVER['HTTP_USER_AGENT'], "Mini")  || stristr($_SERVER['HTTP_USER_AGENT'], "Sony")  || stristr($_SERVER['HTTP_USER_AGENT'], "Nokia")  || stristr($_SERVER['HTTP_USER_AGENT'], "BlackBerry")  || stristr($_SERVER['HTTP_USER_AGENT'], "HTC")  || stristr($_SERVER['HTTP_USER_AGENT'], "Android")   || stristr($_SERVER['HTTP_USER_AGENT'], "MOT")  || stristr($_SERVER['HTTP_USER_AGENT'], "SGH")    ) && $smartphone!="non" || $smartphone=="oui") 
{ 
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';
}
else
{

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> ';

}
?>




<html>

<head>

<link rel="icon" type="image/x-icon" href="favicon.png" >

<title><?php echo $nom_fenetre;?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<?php
if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone")  
|| strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) { 
 echo '<meta name="viewport" content="initial-scale=1.0">';
} 

?>


<?php



//affichage du flux rss dans le navigateur dans url pour firefox

//pour interface prof generique smartphone
//et par laraqi, bairi et alilat
if (isset($_SESSION['logged_prof_smart_gene']) && $current_prof!='3003781' && $current_prof!='3003775')
{
echo '<link rel="alternate" type="application/rss+xml" href="RSS/rss.php?codeProf='.$current_prof.'" title="Dernières MAJ de l\'EDT"/>';
}


//pour interface prof perso smartphone
if ( isset($_SESSION['logged_prof_smart_perso']) &&	$_SESSION['rss']!='0' )
{
echo '<link rel="alternate" type="application/rss+xml" href="RSS/rss.php?codeProf='.$current_prof.'" title="Dernières MAJ de l\'EDT"/>';
}

if($_POST['logintype']=="prof" && ($_POST['loginprof']!=$login_smart && $_POST['password']!=$mdp_smart))
	{
	$login=$_POST['loginprof'];
	$motdepasse=$_POST['password'];
	$motdepasse=md5($motdepasse);
$sql="SELECT * FROM login_prof WHERE login=:login and motPasse=:motdepasse ";
$req_login_prof_perso_smartphone2=$dbh->prepare($sql);
$req_login_prof_perso_smartphone2->execute(array(':login'=>$login,':motdepasse'=>$motdepasse));
$res_login_prof_perso_smartphone2=$req_login_prof_perso_smartphone2->fetchAll();
if(count($res_login_prof_perso_smartphone2)>0)
{
	if ($res_login_prof_perso_smartphone2['0']['login']==$login && $res_login_prof_perso_smartphone2['0']['motPasse']==$motdepasse && $res_login_prof_perso_smartphone2['0']['rss']!='0'   && !isset($_SESSION['logged_prof_smart_perso']) )
		{
		$codeProf=$res_login_prof_perso_smartphone2['0']['codeProf'];
		echo '<link rel="alternate" type="application/rss+xml" href="RSS/rss.php?codeProf='.$codeProf.'" title="Dernières MAJ de l\'EDT"/>';
		}
}
		}

	
//pour interface etudiant smartphone

if ( isset($_SESSION['loggedstudentsmartphone']))
{
echo '<link rel="alternate" type="application/rss+xml" href="RSSetudiant/rss.php?codeEtudiant='.$current_student.'" title="Dernières MAJ de l\'EDT"/>';
}
if ($_POST['logintype']=="studentsmartphone" && trim($_POST['loginstudentsmartphone'])!="")
	{
	$sql="SELECT * FROM ressources_etudiants WHERE identifiant=:loginstudent AND deleted='0'";
$req_rss_etudiant_smartphone=$dbh->prepare($sql);
$req_rss_etudiant_smartphone->execute(array(':loginstudent'=>$_POST['loginstudentsmartphone']));
$res_rss_etudiant_smartphone=$req_rss_etudiant_smartphone->fetchAll();
    if (count($res_rss_etudiant_smartphone)>0)
		{
        echo '<link rel="alternate" type="application/rss+xml" href="RSSetudiant/rss.php?codeEtudiant='.$res_rss_etudiant_smartphone['0']['codeEtudiant'].'" title="Dernières MAJ de l\'EDT"/>';
		}
	}


//pour interface etudiant

if (isset($_SESSION['loggedstudent']) && $current_student!="")
{
echo '<link rel="alternate" type="application/rss+xml" href="RSSetudiant/rss.php?codeEtudiant='.$current_student.'" title="Dernières MAJ de l\'EDT"/>';
}
if ($_POST['logintype']=="student" && trim($_POST['loginstudent'])!="")

	{
$sql="SELECT * FROM ressources_etudiants WHERE identifiant=:loginstudent AND deleted='0'";
$req_rss_etudiant=$dbh->prepare($sql);
$req_rss_etudiant->execute(array(':loginstudent'=>$_POST['loginstudent']));
$res_rss_etudiant=$req_rss_etudiant->fetchAll();
    if (count($res_rss_etudiant)>0)
		{
        echo '<link rel="alternate" type="application/rss+xml" href="RSSetudiant/rss.php?codeEtudiant='.$res_rss_etudiant['0']['codeEtudiant'].'" title="Dernières MAJ de l\'EDT"/>';
		}
	}

//pour interface prof

if (isset($_SESSION['logged_prof_perso']) && $_SESSION['rss']!='0' && $_GET['disconnect']!="true" )
{
echo '<link rel="alternate" type="application/rss+xml" href="RSS/rss.php?codeProf='.$_SESSION['logged_prof_perso'].'" title="Dernières MAJ de l\'EDT"/>';
}


?>

<link rel="stylesheet" media="all" type="text/css" href="menu/hover_drop_2.css">

<script src="menu/iefix.js" type="text/javascript"></script>

<style type="text/css">@import url(cal/calendar-blue2.css);</style>

<script type="text/javascript" src="cal/calendar.js"></script>

<script type="text/javascript" src="cal/lang/calendar-en.js"></script>

<script type="text/javascript" src="cal/calendar-setup.js"></script>
<link rel="stylesheet" href="css/index.css" type="text/css" >




</head>

<body  style="margin: 0px;">



<div style="text-align:center;width:100%;">



<?php



// Si on se deconnecte, on change la valeur des variables de session

//on se deconnecte si demande de deconnection et si il manque le paramaetre horiz en multi ressources dans l url sinon ca fait un bug mysql

if ($_GET['disconnect']=="true" || ((!isset($_POST['larg']) && !isset($_GET['lar'])) && !isset($_SESSION['loggedmodule'])) ||(isset($_SESSION['logged_prof_perso']) && !isset($_GET['horiz'])) ||(isset($_SESSION['logged_prof_generique']) && !isset($_GET['horiz'])))

    {

    $_SESSION['logged_prof_smart_gene']=false;

    $_SESSION['loggedstudent']=false;

	$_SESSION['loggedstudentsmartphone']=false;


	$_SESSION['logged_prof_smart_perso']=false;



	$_SESSION['logged_prof_generique']=false;

	$_SESSION['logged_prof_perso']=false;
	
	$_SESSION['reservation']=false;
	$_SESSION['module']=false;
	$_SESSION['bilan_heure']=false;
	$_SESSION['configuration']=false;
	$_SESSION['rss']=false;
	$_SESSION['bilan_heure_global']=false;
	$_SESSION['bilan_formation']=false;
	$_SESSION['pdf']=false;	
	$_SESSION['giseh']=false;	
		$_SESSION['dialogue']=false;
	$_SESSION['seance_clicable']=false;	
	$_SESSION['salle']=false;	
	
	$_SESSION['loggedmodule']=false;
		$_SESSION['mes_droits']=false;
//smart perso
	unset($_SESSION['logged_prof_smart_perso']);

	unset($_SESSION['loggedstudent']);

	unset($_SESSION['loggedstudentsmartphone']);

//smart prof gene
	unset($_SESSION['logged_prof_smart_gene']);

	unset($_SESSION['logged_prof_generique']);
	unset($_SESSION['logged_prof_perso']);
	unset($_SESSION['loggedmodule']);


    }

//validation du login prof générique avec cookies
if (isset($_COOKIE['vtlogprof']) && isset($_COOKIE['vtmdpprof']))
{
if(strtolower($_COOKIE['vtlogprof'])==strtolower($login_prof) && $_COOKIE['vtmdpprof']==md5($mdp_prof))
	{
    $_SESSION['logged_prof_generique']='TRUE';
	}
	}



//validation du login etudiant
if (($_POST['logintype']=="student" && trim($_POST['loginstudent'])!="") || isset($_SESSION['loggedstudent']) || isset($_COOKIE['vtlogetudiant']))
{
if ($_POST['logintype']=="student" && trim($_POST['loginstudent'])!="" || isset($_COOKIE['vtlogetudiant']))

	{
$login_etudiant=$_POST['loginstudent'];
if (isset ($_COOKIE['vtlogetudiant']))
{
$login_etudiant=$_COOKIE['vtlogetudiant'];
}
$sql="SELECT * FROM ressources_etudiants WHERE identifiant=:loginstudent AND deleted='0'";
$req=$dbh->prepare($sql);
$req->execute(array(':loginstudent'=>$login_etudiant));
$res_student=$req->fetchAll();



    if (count($res_student)>0)

		{

        $_SESSION['loggedstudent']=TRUE;

		}
		else

		{

		    include("login.php");

		}

	}
	
	
	
//si session etudiant validee on cherche les groupes auxquels il appartient

if (isset($_SESSION['loggedstudent']))

	{

	//info qui provient de la page login.php

    if (isset($_POST['current_student']))

		{
		$sql="SELECT * FROM ressources_etudiants WHERE codeEtudiant=:current_student AND deleted='0'";
		$req=$dbh->prepare($sql);
		$req->execute(array(':current_student'=>$_POST['current_student']));
		$res_student=$req->fetchAll();
		}

	//info qui provient des autres pages

    if (isset($_GET['current_student']))

		{
		$sql="SELECT * FROM ressources_etudiants WHERE codeEtudiant=:current_student AND deleted='0'";
		$req=$dbh->prepare($sql);
		$req->execute(array(':current_student'=>$_GET['current_student']));
		$res_student=$req->fetchAll();
		}



    $current_student=$res_student['0']['codeEtudiant'];



	//recuperation de la largeur de l ecran provenant de la page login.php

	if (isset($_POST['larg']))

		{
		$lar=$_POST['larg'];
		$hau=$_POST['haut'];
		}

	//recuperation de la largeur de l ecran provenant des cookies

	if (isset($_COOKIE['vtlogetudiantlar']) && isset($_COOKIE['vtlogetudianthau']))

		{
		$lar=$_COOKIE['vtlogetudiantlar'];
		$hau=$_COOKIE['vtlogetudianthau'];
		}		
		
	//recuperation de la hauteur de l ecran provenant des autres pages

	if (isset($_GET['lar']))
		{
		$lar=$_GET['lar'];
		$hau=$_GET['hau'];
		}

	if (isset($_GET['larg']))
		{
		$lar=$_GET['lar'];
		$hau=$_GET['hau'];
		}

    include('edt_etudiant.php');

	}

}	

	
	

//validation du login etudiant smartphone

elseif (($_POST['logintype']=="studentsmartphone" && trim($_POST['loginstudentsmartphone'])!="") || isset($_SESSION['loggedstudentsmartphone']))
{
if ($_POST['logintype']=="studentsmartphone" && trim($_POST['loginstudentsmartphone'])!="")
	{

$sql="SELECT * FROM ressources_etudiants WHERE identifiant=:loginstudent AND deleted='0'";
$req=$dbh->prepare($sql);
$req->execute(array(':loginstudent'=>$_POST['loginstudentsmartphone']));
$res_student=$req->fetchAll();


    if (count($res_student)>0)

		{

        $_SESSION['loggedstudentsmartphone']=TRUE;

		

		}
			else

		{

		    include("login_smartphone.php");

		}

	}
	
	//si session etudiant SMARTPHONE validee on cherche les groupes auxquels il appartient

if (isset($_SESSION['loggedstudentsmartphone']))

	{

	//info qui provient de la page login.php

    if (isset($_POST['current_student']))

		{
		$sql="SELECT * FROM ressources_etudiants WHERE codeEtudiant=:current_student AND deleted='0'";
		$req=$dbh->prepare($sql);
		$req->execute(array(':current_student'=>$_POST['current_student']));
		$res_student=$req->fetchAll();
		
		}

	//info qui proient des autres pages

    if (isset($_GET['current_student']))

		{
		$sql="SELECT * FROM ressources_etudiants WHERE codeEtudiant=:current_student AND deleted='0'";
		$req=$dbh->prepare($sql);
		$req->execute(array(':current_student'=>$_GET['current_student']));
		$res_student=$req->fetchAll();
		}



    $current_student=$res_student['0']['codeEtudiant'];

	
	
	//recuperation de la largeur de l ecran provenant de la page login.php

	if (isset($_POST['larg']))

		{

		$lar=$_POST['larg'];

		$hau=$_POST['haut'];

		}

	//recuperation de la hauteur de l ecran provenant des autres pages

	if (isset($_GET['lar']))

		{

		$lar=$_GET['lar'];

		$hau=$_GET['hau'];

		}

	if (isset($_GET['larg']))

		{

		$lar=$_GET['lar'];

		$hau=$_GET['hau'];

		}


    include('edt_etudiant_smartphone.php');



		}	
}
	
	
	
		



//validation du login prof smartphone generique

elseif(isset($_SESSION['logged_prof_smart_gene']) || ((strtolower($_POST['loginprof'])==strtolower($login_smart) && $_POST['password']==$mdp_smart) ) && $_POST['logintype']=="prof")

	{

    $_SESSION['logged_prof_smart_gene']=TRUE;

	

	if (isset($_POST['larg']))

		{

		$lar=$_POST['larg'];

		$hau=$_POST['haut'];

		}

	if (isset($_GET['lar']))

	{

	$lar=$_GET['lar'];

	$hau=$_GET['hau'];

	}

		if (isset($_GET['larg']))

	{

	$lar=$_GET['lar'];

	$hau=$_GET['hau'];

	}

    include("edt_prof_smartphone.php");

	}

	

	
	

//validation du login prof smartphone personnel

elseif(isset($_SESSION['logged_prof_smart_perso']) ||  $_POST['logintype']=="prof" && ($_POST['loginprof']!=$login_smart && $_POST['password']!=$mdp_smart))

	{
	$login=$_POST['loginprof'];
	$motdepasse=$_POST['password'];
	$motdepasse=md5($motdepasse);

$sql="SELECT * FROM login_prof WHERE login=:login and motPasse=:motdepasse ";
$req_login_prof_perso_smartphone=$dbh->prepare($sql);
$req_login_prof_perso_smartphone->execute(array(':login'=>$login,':motdepasse'=>$motdepasse));
$res_login_prof_perso_smartphone=$req_login_prof_perso_smartphone->fetchAll();

if(count($res_login_prof_perso_smartphone)>0)
{
	if (strtolower($res_login_prof_perso_smartphone['0']['login'])==strtolower($login) && $res_login_prof_perso_smartphone['0']['motPasse']==$motdepasse  && !isset($_SESSION['logged_prof_smart_perso']) )

		{
		$codeProf=$res_login_prof_perso_smartphone['0']['codeProf'];

		$current_prof=$res_login_prof_perso_smartphone['0']['codeProf'];

		$_SESSION['logged_prof_smart_perso']=$codeProf;

		//recuperation de la taille de l ecran depuis la page login.php	

		if (isset($_POST['larg']))

			{

			$lar=$_POST['larg'];

			$hau=$_POST['haut'];

			}

		//recuperation de la taille de l ecran depuis les autres pages

		if (isset($_GET['lar']))

			{
			$lar=$_GET['lar'];
			$hau=$_GET['hau'];
			}

		if (isset($_GET['larg']))

			{

			$lar=$_GET['lar'];

			$hau=$_GET['hau'];

			}
    include("edt_prof_smartphone.php");

	}
}
	elseif (isset($_SESSION['logged_prof_smart_perso']))

		{

		//recuperation de la taille de l ecran depuis la page login.php			

		if (isset($_POST['larg']))

			{

			$lar=$_POST['larg'];

			$hau=$_POST['haut'];

			}

		//recuperation de la taille de l ecran depuis les autres pages

		if (isset($_GET['lar']))

			{

			$lar=$_GET['lar'];

			$hau=$_GET['hau'];

			}

		if (isset($_GET['larg']))

			{

			$lar=$_GET['lar'];

			$hau=$_GET['hau'];

			}

		include("edt_prof_smartphone.php");

		}

	//si aucun login ne marche on retourne a la page login.php

	else

	{

		    include("login_smartphone.php");

	}

	}

		
		
	
//validation du login prof generique
elseif(isset($_SESSION['logged_prof_generique']) || ((strtolower($_POST['loginvrac'])==strtolower($login_prof) && $_POST['password']==$mdp_prof) ) && $_POST['logintype']=="vrac" )
	{
    $_SESSION['logged_prof_generique']='TRUE';

	//recuperation de la taille de l ecran depuis la page login.php		

	if (isset($_POST['larg']))

	{

	$lar=$_POST['larg'];

	$hau=$_POST['haut'];

	}

	//recuperation de la taille de l ecran depuis les autres pages

	
	if (isset($_GET['lar']))

		{
		$lar=$_GET['lar'];

		$hau=$_GET['hau'];

		}

	if (isset($_GET['larg']))

		{

		$lar=$_GET['lar'];

		$hau=$_GET['hau'];

		}

		
	//orientation du planning	

	if (isset($_GET['horiz']))

		$horizon=$_GET['horiz'];

	else

		$horizon="1"; 		

		
		
		
		
		
		
    include("edt_prof.php");

	}
		
//validation du login prof perso

elseif(isset($_SESSION['logged_prof_perso']) || (($_POST['loginvrac']!=$login_prof && $_POST['password']!=$mdp_prof) && $_POST['logintype']=="vrac") || (isset($_COOKIE['vtlogprof']) && isset($_COOKIE['vtmdpprof'])))
	{
	$login=$_POST['loginvrac'];
	$motdepasse=$_POST['password'];
	$motdepasse=md5($motdepasse);

if (isset ($_COOKIE['vtlogprof']) && isset($_COOKIE['vtmdpprof']) )
{
$login=$_COOKIE['vtlogprof'];
$motdepasse=$_COOKIE['vtmdpprof'];
}




	
$sql="SELECT * FROM login_prof WHERE login=:login and motPasse=:motdepasse ";
$req_login_prof_perso=$dbh->prepare($sql);
$req_login_prof_perso->execute(array(':login'=>$login,':motdepasse'=>$motdepasse));
$res_login_prof_perso=$req_login_prof_perso->fetchAll();
$login_et_mot_passe_existe='0';
foreach($res_login_prof_perso as $res_login_prof_persobis)
{
$login_et_mot_passe_existe='1';
}

	
		if(!isset($_SESSION['logged_prof_perso']) && $login_et_mot_passe_existe=='1'  )
		{
			
			// la variable truc sert a savoir si on vient juste de se logguer ou non afin d afficher l edt perso juste apres s etre loggue avec login perso
			$truc='1';

			$codeProf=$res_login_prof_perso['0']['codeProf'];
			
			$current_prof=$res_login_prof_perso['0']['codeProf'];
			$horizon=$res_login_prof_perso['0']['horizontal'];
			$selec_prof=$res_login_prof_perso['0']['selecProf'];
			$selec_groupe=$res_login_prof_perso['0']['selecGroupe'];
			$selec_salle=$res_login_prof_perso['0']['selecSalle'];
			$selec_materiel=$res_login_prof_perso['0']['selecMateriel'];
			$_SESSION['logged_prof_perso']=$codeProf;
			$autorisation_reservation=$res_login_prof_perso['0']['reservation'];
			$_SESSION['reservation']=$autorisation_reservation;
			$autorisation_module=$res_login_prof_perso['0']['module'];
			$_SESSION['module']=$autorisation_module;	
			$autorisation_heure=$res_login_prof_perso['0']['bilan_heure'];
			$_SESSION['bilan_heure']=$autorisation_heure;	
			$autorisation_configuration=$res_login_prof_perso['0']['configuration'];
			$_SESSION['configuration']=$autorisation_configuration;	
			$autorisation_rss=$res_login_prof_perso['0']['rss'];
			$_SESSION['rss']=$autorisation_rss;	
			$autorisation_heure_global=$res_login_prof_perso['0']['bilan_heure_global'];
			$_SESSION['bilan_heure_global']=$autorisation_heure_global;		
			$autorisation_bilan_formation=$res_login_prof_perso['0']['bilan_formation'];
			$_SESSION['bilan_formation']=$autorisation_bilan_formation;	
			$autorisation_pdf=$res_login_prof_perso['0']['pdf'];
			$_SESSION['pdf']=$autorisation_pdf;	
			$autorisation_giseh=$res_login_prof_perso['0']['giseh'];
			$_SESSION['giseh']=$autorisation_giseh;	
			$autorisation_dialogue=$res_login_prof_perso['0']['dialogue'];
			$_SESSION['dialogue']=$autorisation_dialogue;	
			$autorisation_salle=$res_login_prof_perso['0']['salle'];
			$_SESSION['salle']=$autorisation_salle;	
				$autorisation_mes_droits=$res_login_prof_perso['0']['mes_droits'];
			$_SESSION['mes_droits']=$autorisation_mes_droits;			
							$autorisation_admin=$res_login_prof_perso['0']['admin'];
			$_SESSION['admin']=$autorisation_admin;		
			
			$autorisation_seance_clicable=$res_login_prof_perso['0']['seance_clicable'];
			$_SESSION['seance_clicable']=$autorisation_seance_clicable;	

			
		//recuperation de la taille de l ecran depuis la page login.php		

			if (isset($_POST['larg']))

				{

				$lar=$_POST['larg'];

				$hau=$_POST['haut'];

				}

		//recuperation de la taille de l ecran depuis les autres pages

			if (isset($_GET['lar']))

				{

				$lar=$_GET['lar'];

				$hau=$_GET['hau'];

				}

			if (isset($_GET['larg']))

				{

				$lar=$_GET['lar'];

				$hau=$_GET['hau'];

				}


			include("edt_prof.php");

			// la variable truc passe a 0. la variable truc sert a savoir si on vient juste de se logguer ou non afin d afficher l edt perso juste apres s etre loggue avec login perso

			$truc='0';

			}
		

		elseif (isset($_SESSION['logged_prof_perso']))

		{
			
	//recuperation de la taille de l ecran depuis la page login.php	

		if (isset($_POST['larg']))

			{

			$lar=$_POST['larg'];

			$hau=$_POST['haut'];

			}

	//recuperation de la taille de l ecran depuis les autres pages

		if (isset($_GET['lar']))

			{

			$lar=$_GET['lar'];

			$hau=$_GET['hau'];

			}

		if (isset($_GET['larg']))

			{

			$lar=$_GET['larg'];

			$hau=$_GET['haut'];

			}

			
		
		//sauvegarde orientation du planning	
		if (isset($_GET['horiz']))
			{
			$horizon=$_GET['horiz'];
			}
		$logprof=$_SESSION['logged_prof_perso'];
		//je ne sauvegarde pas la vue mensuelle (horizon==2) car elle n'est pas pratique au quotidien
		if ($horizon=='0' || $horizon=='1' ||$horizon=='3' ||$horizon=='4')
			{
			$sql="UPDATE login_prof SET horizontal=:horizon WHERE codeProf=:logprof";
			$req_login_prof_perso_horiz=$dbh->prepare($sql);
			$req_login_prof_perso_horiz->execute(array(':horizon'=>$horizon,':logprof'=>$logprof));
			
			}
			
			

			
			
			
			
			
		//sauvegarde pre-tri groupes	
		if (isset($_GET['selec_groupe']))
			{
			$selec_groupe=$_GET['selec_groupe'];
			}
		$logprof=$_SESSION['logged_prof_perso'];
				
			$sql="UPDATE login_prof SET selecGroupe=:selec_groupe WHERE codeProf=:logprof";
			$req_login_prof_perso_groupe=$dbh->prepare($sql);
			$req_login_prof_perso_groupe->execute(array(':selec_groupe'=>$selec_groupe,':logprof'=>$logprof));
			
			
		//sauvegarde pre-tri profs	
		if (isset($_GET['selec_prof']))
			{
			$selec_prof=$_GET['selec_prof'];
			}
		$logprof=$_SESSION['logged_prof_perso'];
			$sql="UPDATE login_prof SET selecProf=:selec_prof WHERE codeProf=:logprof";
			$req_login_prof_perso_prof=$dbh->prepare($sql);
			$req_login_prof_perso_prof->execute(array(':selec_prof'=>$selec_prof,':logprof'=>$logprof));
			
			//sauvegarde pre-tri salles	
		if (isset($_GET['selec_salle']))
			{
			$selec_salle=$_GET['selec_salle'];
			}
		$logprof=$_SESSION['logged_prof_perso'];
			$sql="UPDATE login_prof SET selecSalle=:selec_salle WHERE codeProf=:logprof";
			$req_login_prof_perso_salle=$dbh->prepare($sql);
			$req_login_prof_perso_salle->execute(array(':selec_salle'=>$selec_salle,':logprof'=>$logprof));			

			//sauvegarde pre-tri materiels	
		if (isset($_GET['selec_materiel']))
			{
			$selec_materiel=$_GET['selec_materiel'];
			}
		$logprof=$_SESSION['logged_prof_perso'];
			$sql="UPDATE login_prof SET selecMateriel=:selec_materiel WHERE codeProf=:logprof";
			$req_login_prof_perso_materiel=$dbh->prepare($sql);
			$req_login_prof_perso_materiel->execute(array(':selec_materiel'=>$selec_materiel,':logprof'=>$logprof));					
			
		include("edt_prof.php");

		}
		
	else

		{

		    include("login.php");

		}

	}	


else


{

	if(isset($_GET['smartphone']))
		{
		$smartphone=$_GET['smartphone'];

		}
	else
		{
		$smartphone="";
		}
	
	
if ((stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod") || stristr($_SERVER['HTTP_USER_AGENT'], "Mini")  || stristr($_SERVER['HTTP_USER_AGENT'], "Sony")  || stristr($_SERVER['HTTP_USER_AGENT'], "Nokia")  || stristr($_SERVER['HTTP_USER_AGENT'], "BlackBerry")  || stristr($_SERVER['HTTP_USER_AGENT'], "HTC")  || stristr($_SERVER['HTTP_USER_AGENT'], "Android")   || stristr($_SERVER['HTTP_USER_AGENT'], "MOT")  || stristr($_SERVER['HTTP_USER_AGENT'], "SGH")    ) && $smartphone!="non" || $smartphone=="oui") 
{ 
include("login_smartphone.php");
} 

elseif ($smartphone=="non")
{
include("login.php");
}
elseif ($smartphone=="oui")
{
include("login_smartphone.php?");
}	

else
{
include("login.php");
}		

	}

	
	
//affichage de la possibilite de mettre des reservations que si on est logge avec compte prof perso et si javascript actif
 //test si prof concerne par rdv perso a son edt affiche sur ressources multi
$ok='0';
 for ($i=0; $i<count($profs_multi); $i++)
	{
	if (isset($_SESSION['logged_prof_perso']))
	{
		if ($_SESSION['logged_prof_perso']==$profs_multi[$i] && $_SESSION['reservation']!='0')
			{
			$ok='1';
			$codeprof=$profs_multi[$i];
			break;
			}
	}
		else
			{
			$ok='0';
			}
	}

	
	

if(( $ok=='1' && $horizon!='2' ) && (isset($_POST['larg']) || isset($_GET['lar'])))
{
if ($_GET['lar']!="")
	{
//on rend les croix des réservations clicables
if ($ok!='0')
{
// si on est dans emploi du temps multi ressources
if (isset($_SESSION['logged_prof_perso']))
{

	
//si verticale mono ressource calibrage par rapport firefox
if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)==1 && count($profs_multi)==1 && $horizon==0)
{
//recuperation de la largeur de l ecran 
if (isset($_GET['lar']))
	{
	$largeur=$_GET['lar'];
	}
//recuperation de la hauteur de l ecran 
if (isset($_GET['hau']))
	{
	$hauteur=$_GET['hau'];
	}
//calibrage par rapport a firefox
$hauteur=$hauteur-385;
if ($hauteur<346)
{
$hauteur=346;
}
$largeur=$largeur-50;
if ($largeur<974)
{
$largeur=974;
}
// Largeur et hauteur des entêtes du calendrier
$leftwidth=50;
$topheight=40;


}


//si verticale multi ressources calibrage par rapport firefox
if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>1 && count($profs_multi)>=1 && $horizon==0)
{
//recuperation de la largeur de l ecran 
if (isset($_GET['lar']))
	{
	$largeur=$_GET['lar'];
	}
//recuperation de la hauteur de l ecran 
if (isset($_GET['hau']))
	{
	$hauteur=$_GET['hau'];
	}
//calibrage par rapport a firefox
$hauteur=$hauteur-325;
if ($hauteur<417)
{
$hauteur=417;
}
$largeur=$largeur-50;
if ($largeur<974)
{
$largeur=974;
}
// Largeur et hauteur des entêtes du calendrier
$leftwidth=50;
$topheight=40;
}



//si horizontale, calibrage par rapport firefox
if ( $horizon==1 && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>0))
{
//largeur des bandes grises sur l edt horizontal. 
$leftwidth=50;
$topheight=75;
//recuperation de la largeur de l ecran 
if (isset($_GET['lar']))
	{
	$largeur=$_GET['lar'];

}
//recuperation de la hauteur de l ecran 
if (isset($_GET['hau']))
	{
	$hauteur=$_GET['hau'];
	}
//calibrage par rapport a firefox
$hauteur=$hauteur-405;
if ($hauteur<326)
{
$hauteur=326;
}

$largeur=$largeur-50;
if ($largeur<850)
{
$largeur=850;
}

	
}




//si mensuelle complete, calibrage par rapport firefox
if ( $horizon==4 && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>0))
{
//largeur des bandes grises sur l edt horizontal. 
$leftwidth=80;
$topheight=23;
//recuperation de la largeur de l ecran 
if (isset($_GET['lar']))
	{
	$largeur=$_GET['lar'];

}
//recuperation de la hauteur de l ecran 
if (isset($_GET['hau']))
	{
	$hauteur=$_GET['hau'];
	}
//calibrage par rapport a firefox
$hauteur=$hauteur-360;

if ($hauteur<382)

{

$hauteur=382;

}
$hauteur=$hauteur*6;

$largeur=$largeur-50;

if ($largeur<974)

{

$largeur=974;

}

	
}





//si jour j calibrage par rapport firefox
if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 && count($profs_multi)>=1 && $horizon==3)
{
//recuperation de la largeur de l ecran 
if (isset($_GET['lar']))
	{
	$largeur=$_GET['lar'];

}
//recuperation de la hauteur de l ecran 
if (isset($_GET['hau']))
	{
	$hauteur=$_GET['hau'];
	}
//calibrage par rapport a firefox
$hauteur=$hauteur-345;
if ($hauteur<387)
{
$hauteur=387;
}
$largeur=$largeur-50;
if ($largeur<974)
{
$largeur=974;
}
// Largeur et hauteur des entêtes du calendrier
$leftwidth=50;
$topheight=40;
}




//mise en place des croix clicables dans les differentes vues 
if ($hideprivate!='1') 

{

//preparation des requetes des boucles suivantes
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof2 AND reservations.codeProprietaire='999' and reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0  ";
$req_reservation=$dbh->prepare($sql);
/*
if ($horizon=='4')
{
$days=34;
}
*/


if ($horizon=='4')
{
$day_fin=34;
}
else
{
$day_fin=$days;
}



for ($day=0;$day<$day_fin;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));


$req_reservation->execute(array(':current_prof2'=>$current_prof2,':current_day'=>$current_day));
$res_reservation=$req_reservation->fetchAll();

foreach ($res_reservation as $res_resa)
		{



	// On convertit l'horaire en %age de la journée



			/* Explication conversion :



			   On extrait d'une part les minutes et d'autre part l'heure.

			   On transforme les minutes en fraction d'heure.

			   On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

			   On obtient un %age correspondant à la position du début du cours.

			   Idem pour la durée mais sans enlever 8.15



			*/



			

		$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);

			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



			

if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)==1 && count($profs_multi)==1 && $horizon==0)

{

	


	// On calcule les coordonnées du rectangle :



		$topy = round($topheight + (($hauteur - $topheight) / $days) * $day   ); 

		$bottomy = round($topheight + (($hauteur - $topheight)) / $days * $day +13  ) ;

		$leftx = round(($start_time+($duree/2)) * ($largeur - $leftwidth) + $leftwidth +32    ); 

		$rightx = round(($start_time+($duree/2))* ($largeur - $leftwidth) + $leftwidth +52   );

			

		

			

			

		//modification de reservations	



		

		echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?modrdv=1&codeResa='.$res_resa['codeReservation'].'&profs_multi[]='.$_SESSION['logged_prof_perso'].'&codeProf='.$_SESSION['logged_prof_perso'].'&horiz='.$horizon.'&current_week='.$current_week .'&current_year='.$current_year.'&lar='.$lar.'&hau='.$hau.'&selec_prof='. $selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'      " onclick="if (window.confirm(\'Etes vous sûr de vouloir MODIFIER ou SUPPRIMER la réservation ?\')) {return true;} else {return false;}">';	

			

			

			

}			



if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>1 && count($profs_multi)>=1&& $horizon==0)

{

			

	// On calcule les coordonnées du rectangle :

		// calcul du nb de ressources

		$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);

		$nbdegroupe=count($groupes_multi);

		//calcul de la position du prof parmi tous les profs de la liste

		 for ($i=0; $i<count($profs_multi); $i++)

		{

		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])

		{

		$j=$i;

		

		break;

		}

		}

		
		



	$topy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days ) +(($j+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource ; 

	$bottomy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days ) +(($j+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource +16; 

	$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth +($duree) * ($largeur - $leftwidth)/2+32    ); 

	$rightx = round($start_time * ($largeur - $leftwidth) + $leftwidth +($duree) * ($largeur - $leftwidth)/2+52    );	



			



echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?modrdv=1&codeResa='.$res_resa['codeReservation'];

			

		 for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}	

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}
	for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '&materiels_multi[]='.$materiels_multi[$i];

		}
			

		echo '&codeProf='.$_SESSION['logged_prof_perso'].'&horiz='.$horizon.'&current_week='.$current_week .'&current_year='.$current_year.'&lar='.$lar.'&hau='.$hau.'&selec_prof='. $selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'" onclick="if (window.confirm(\'Etes vous sûr de vouloir MODIFIER ou SUPPRIMER la réservation ?\')) {return true;} else {return false;}">';		

		

}





if ( $horizon==1 && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>0))

{



			

	// On calcule les coordonnées du rectangle :

		// calcul du nb de ressources

		$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);

		$nbdegroupe=count($groupes_multi);

		//calcul de la position du prof parmi tous les profs de la liste

		 for ($i=0; $i<count($profs_multi); $i++)

		{

		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])

		{

		$j=$i;

		

		break;

		}

		}

		

	

			$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day) + ($j+$nbdegroupe)*(($largeur - $leftwidth)*$nbressource) / $days/$nbressource +(($largeur - $leftwidth)*$nbressource) / $days/$nbressource/2+32;  // Coté gauche

			$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day) + ($j+$nbdegroupe)*(($largeur - $leftwidth)*$nbressource) / $days/$nbressource +(($largeur - $leftwidth)*$nbressource) / $days/$nbressource/2+52; // Coté droit

			$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
				//si vue horizontale et seance de durée inférieure à 1h
				if ($res_resa['dureeReservation']<=100)
				{
				$epaisseur=11;
				}
				else
				{
				$epaisseur=16;
				}	
			
			$bottomy = $start_time * ($hauteur - $topheight) + $topheight+$epaisseur; // bas



		//modification de reservations	

	

				echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?modrdv=1&codeResa='.$res_resa['codeReservation'];

			

		 for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}	

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}
	for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '&materiels_multi[]='.$materiels_multi[$i];

		}
			

		echo '&codeProf='.$_SESSION['logged_prof_perso'].'&horiz='.$horizon.'&current_week='.$current_week .'&current_year='.$current_year.'&lar='.$lar.'&hau='.$hau.'&selec_prof='. $selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'" onclick="if (window.confirm(\'Etes vous sûr de vouloir MODIFIER ou SUPPRIMER la réservation ?\')) {return true;} else {return false;}">';	

		

}



if ( $horizon==4 && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>0))

{



			

	// On calcule les coordonnées du rectangle :

		// calcul du nb de ressources

		$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);

		$nbdegroupe=count($groupes_multi);

		//calcul de la position du prof parmi tous les profs de la liste

		 for ($i=0; $i<count($profs_multi); $i++)

		{

		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])

		{

		$j=$i;

		

		break;

		}

		}

		
// numero de la semaine dans le mois

if	($day>=0 && $day<=6)

		$numsemaine='1';

if	($day>=7 && $day<=13)

		$numsemaine='2';

if	($day>=14 && $day<=20)

		$numsemaine='3';

if	($day>=21 && $day<=27)

		$numsemaine='4';

if	($day>=28 && $day<=34)

		$numsemaine='5';
	

		if ($res_resa['dureeReservation']<=100)
				{
				$epaisseur=11;
				}
				else
				{
				$epaisseur=16;
				}	

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $topy+$epaisseur;

		$leftx = $leftwidth +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+(($largeur-$leftwidth)/$days)/2+32 ; 

		$rightx = $leftwidth +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+(($largeur-$leftwidth)/$days)/2+52; 

		//modification de reservations	

	

				echo '<area alt="TOTO" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?modrdv=1&codeResa='.$res_resa['codeReservation'];

			

		 for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}	

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}
	for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '&materiels_multi[]='.$materiels_multi[$i];

		}
			

		echo '&codeProf='.$_SESSION['logged_prof_perso'].'&horiz='.$horizon.'&current_week='.$current_week .'&current_year='.$current_year.'&lar='.$lar.'&hau='.$hau.'&selec_prof='. $selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'" onclick="if (window.confirm(\'Etes vous sûr de vouloir MODIFIER ou SUPPRIMER la réservation ?\')) {return true;} else {return false;}">';	

		

}			

}

}



//croix clicable pour vue jour J
if ($horizon=='3')
{
if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
 $current_day_jour=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
	
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof2 AND reservations.codeProprietaire='999' and reservations.dateReservation=:current_day_jour AND reservations.deleted=0  AND reservations_profs.deleted=0  ";
$req_reservation_J=$dbh->prepare($sql);
$req_reservation_J->execute(array(':current_prof2'=>$current_prof2,':current_day_jour'=>$current_day_jour));
$res_reservation_J=$req_reservation_J->fetchAll();

foreach ($res_reservation_J as $res_resa)	
	

		{

	// On convertit l'horaire en %age de la journée
			/* Explication conversion :
			   On extrait d'une part les minutes et d'autre part l'heure.
			   On transforme les minutes en fraction d'heure.
			   On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
			   On obtient un %age correspondant à la position du début du cours.
			   Idem pour la durée mais sans enlever 8.15

			*/

			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);
			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);
			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);
			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

	

if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 && count($profs_multi)>=1&& $horizon==3)
{
	// On calcule les coordonnées du rectangle :
		// calcul du nb de ressources
		$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
		$nbdegroupe=count($groupes_multi);
		//calcul de la position du prof parmi tous les profs de la liste
		 for ($i=0; $i<count($profs_multi); $i++)
		{
		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])
		{
		$j=$i;
		break;
		}
		}
	$topy = $topheight  +(($j+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / 5)/$nbressource ; 
	$bottomy = $topheight  +(($j+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) /5)/$nbressource +12; 
	$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth +($duree) * ($largeur - $leftwidth)/2+32    ); 
	$rightx = round($start_time * ($largeur - $leftwidth) + $leftwidth +($duree) * ($largeur - $leftwidth)/2+52    );	


echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?modrdv=1&codeResa='.$res_resa['codeReservation'];

		 for ($i=0; $i<count($groupes_multi); $i++)
		{ 
		echo '&groupes_multi[]='.$groupes_multi[$i];
		}	
	for ($i=0; $i<count($profs_multi); $i++)
		{ 
		echo '&profs_multi[]='.$profs_multi[$i];
		}
	for ($i=0; $i<count($salles_multi); $i++)
		{ 
		echo '&salles_multi[]='.$salles_multi[$i];
		}
		for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '&materiels_multi[]='.$materiels_multi[$i];
		}
	echo '&codeProf='.$_SESSION['logged_prof_perso'].'&horiz='.$horizon.'&current_week='.$current_week .'&current_year='.$current_year.'&lar='.$lar.'&hau='.$hau.'&jour='.$jour.'&selec_prof='. $selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'" onclick="if (window.confirm(\'Etes vous sûr de vouloir MODIFIER ou SUPPRIMER la réservation ?\')) {return true;} else {return false;}">';		

		
}


}




}


}
















// affichage des zones correspondant aux seances clicables. Les zones sont générées dans le fichier edt_prof.php. Il faut que ces zones soient dans le code html après la déclaration des zones des séances clicables car en cas de croix superposée avec une séance, si la zone de la croix est écrite après elle est en premier plan.

if (isset($seance_clicable_area))
{
if ($seance_clicable_area!="")
{
echo $seance_clicable_area;
}
}

?>

</map>

<?php

 }



 }
	
	
	
	
	
	
	
	
	
	
	
	
	?>

<div style="height:72px;width:985px;margin-left:auto;margin-right:auto;pading:0px;margin-top:0px;">	

<?php



if(!isset($_GET['modrdv']))

    $modrdv='0';

else

    $modrdv=$_GET['modrdv'];	



//si on ne demande pas a modifier une reservation	

if ($modrdv!='1')

{



if ($ok=='1')

{






?>

<form id="rdv" action="index.php?current_week=<?php echo $current_week; ?>&jour=<?php echo $jour; ?>&current_year=<?php echo $current_year; ?>

<?php

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

		

	for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}		
for ($i=0; $i<count($materiels_multi); $i++)


{ 


echo '&materiels_multi[]='.$materiels_multi[$i];


}
?>





&lar=<?php echo $lar; ?>&horiz=<?php echo $horizon; ?>&hau=<?php echo $hau; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>" name="resa" onSubmit="return verif_champs()"     method="post">

<?php

}

else

{

?>

<form id="rdv" action="index.php?current_week=<?php echo $current_week; ?>&jour=<?php echo $jour; ?>&current_year=<?php echo $current_year; ?>&current_prof=<?php echo $current_prof; ?>&lar=<?php echo $lar; ?>&hau=<?php echo $hau; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>" name="resa" onSubmit="return verif_champs()"     method="post">

<?php

}

?>

<div style="float:left;">

Le

<input name="date" id="date" type="text" value="<?php echo date("d-m-Y"); ?>" maxlength="10" size="12"><br>

de

<select name="heure_d">
<?php
for ($i=floor($heure_debut_journee);$i<=$heure_fin_journee;$i++)
{
if (strlen($i)==1)
{
echo '<option value="'.$i.'">0'.$i.'</option>';
}
else
{
echo '<option value="'.$i.'">'.$i.'</option>';
}
}
?>

</select>

h

<select name="minute_d">

<?php
for ($i=0;$i<60;$i=$i+15)
{
echo '<option ';
if (strlen($i)==1)
{
 echo 'value="0'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}

}
?>

</select>

à

<select name="heure_f">

 <?php
for ($i=floor($heure_debut_journee);$i<=$heure_fin_journee;$i++)
{

if (strlen($i)==1)
{
echo '<option value="'.$i.'">0'.$i.'</option>';
}
else
{
echo '<option value="'.$i.'">'.$i.'</option>';
}



}
?>
  

</select>

h

<select name="minute_f">

<?php

for ($i=0;$i<60;$i=$i+15)
{
echo '<option ';
// 
if ($i== 15) 
{
echo 'selected ';
}

if (strlen($i)==1)
{
 echo 'value="0'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}

}
?>

</select>

</div>

<?php
//ecart entre l'heure de début matinée et l'heure de début par défaut de l'interface
$ecart_heure_debut_matin=floor($heure_debut_journee_bis)-floor($heure_debut_journee);
$heure_debut_matin=floor($heure_debut_journee_bis);
if (strlen($heure_debut_matin)=='1')
{
$heure_debut_matin="0".$heure_debut_matin;
}
//ecart entre l'heure du debut de la pause du matin et l'heure de début par défaut de l'interface
$ecart_heure_debut_pause_matin=floor($heure_debut_pause_matin)-floor($heure_debut_journee);
$heure_debut_pause_matinee=floor($heure_debut_pause_matin);
if (strlen($heure_debut_pause_matinee)=='1')
{
$heure_debut_pause_matinee="0".$heure_debut_pause_matinee;
}
//ecart entre l'heure de fin de la pause du matin et l'heure de début par défaut de l'interface
$ecart_heure_fin_pause_matin=floor($heure_fin_pause_matin)-floor($heure_debut_journee);
$heure_fin_pause_matinee=floor($heure_fin_pause_matin);
if (strlen($heure_debut_pause_matinee)=='1')
{
$heure_debut_pause_matinee="0".$heure_debut_pause_matinee;
}
//ecart entre l'heure de fin de matiné et l'heure de début par défaut de l'interface
$ecart_heure_fin_matin=floor($heure_debut_pause_midi)-floor($heure_debut_journee);
$heure_fin_matin=floor($heure_debut_pause_midi);
if (strlen($heure_fin_matin)=='1')
{
$heure_fin_matin="0".$heure_fin_matin;
}
//ecart entre l'heure de début d'apres midi et l'heure de début par défaut de l'interface
$ecart_heure_debut_apresmidi=floor($heure_fin_pause_midi)-floor($heure_debut_journee);
$heure_debut_apresmidi=floor($heure_fin_pause_midi);
if (strlen($heure_debut_apresmidi)=='1')
{
$heure_debut_apresmidi="0".$heure_debut_apresmidi;
}
//ecart entre l'heure du debut de la pause de l'après-midi et l'heure de début par défaut de l'interface
$ecart_heure_debut_pause_apresmidi=floor($heure_debut_pause_apresmidi)-floor($heure_debut_journee);
$heure_debut_pause_apres_midi=floor($heure_debut_pause_apresmidi);
if (strlen($heure_debut_pause_apres_midi)=='1')
{
$heure_debut_pause_apres_midi="0".$heure_debut_pause_apres_midi;
}
//ecart entre l'heure de fin de la pause de l'après-midi et l'heure de début par défaut de l'interface
$ecart_heure_fin_pause_apresmidi=floor($heure_fin_pause_apresmidi)-floor($heure_debut_journee);
$heure_fin_pause_apres_midi=floor($heure_fin_pause_apresmidi);
if (strlen($heure_fin_pause_apres_midi)=='1')
{
$heure_fin_pause_apres_midi="0".$heure_fin_pause_apres_midi;
}
//ecart entre l'heure de fin d'apres midi et l'heure de fin par défaut de l'interface
$ecart_heure_fin_apresmidi=floor($heure_fin_journee_bis)-floor($heure_debut_journee);
$heure_fin_apresmidi=floor($heure_fin_journee_bis);
if (strlen($heure_fin_apresmidi)=='1')
{
$heure_fin_apresmidi="0".$heure_fin_apresmidi;
}



// minute de début de matinee
$ecart_minute_debut_matin=($heure_debut_journee_bis-floor($heure_debut_journee_bis))*4;
$minute_debut_matin=($heure_debut_journee_bis-floor($heure_debut_journee_bis))*60;
if (strlen($minute_debut_matin)=='1')
{
$minute_debut_matin="0".$minute_debut_matin;
}
//minute du debut de la pause du matin 
$ecart_minute_debut_pause_matin=($heure_debut_pause_matin-floor($heure_debut_pause_matin))*4;
$minute_debut_pause_matin=($heure_debut_pause_matin-floor($heure_debut_pause_matin))*60;
if (strlen($minute_debut_pause_matin)=='1')
{
$minute_debut_pause_matin="0".$minute_debut_pause_matin;
}
// minute de fin de la pause du matin 
$ecart_minute_fin_pause_matin=($heure_fin_pause_matin-floor($heure_fin_pause_matin))*4;
$minute_fin_pause_matin=($heure_fin_pause_matin-floor($heure_fin_pause_matin))*60;
if (strlen($minute_fin_pause_matin)=='1')
{
$minute_fin_pause_matin="0".$minute_fin_pause_matin;
}
// minute de fin de matiné 
$ecart_minute_fin_matin=($heure_debut_pause_midi-floor($heure_debut_pause_midi))*4;
$minute_fin_matin=($heure_debut_pause_midi-floor($heure_debut_pause_midi))*60;
if (strlen($minute_fin_matin)=='1')
{
$minute_fin_matin="0".$minute_fin_matin;
}
// minute de début d'apres midi 
$ecart_minute_debut_apresmidi=($heure_fin_pause_midi-floor($heure_fin_pause_midi))*4;
$minute_debut_apresmidi=($heure_fin_pause_midi-floor($heure_fin_pause_midi))*60;
if (strlen($minute_debut_apresmidi)=='1')
{
$minute_debut_apresmidi="0".$minute_debut_apresmidi;
}
// minute du debut de la pause d'apres midi
$ecart_minute_debut_pause_apresmidi=($heure_debut_pause_apresmidi-floor($heure_debut_pause_apresmidi))*4;
$minute_debut_pause_apres_midi=($heure_debut_pause_apresmidi-floor($heure_debut_pause_apresmidi))*60;
if (strlen($minute_debut_pause_apres_midi)=='1')
{
$minute_debut_pause_apres_midi="0".$minute_debut_pause_apres_midi;
}
// minute de fin de la pause d'apres midi 
$ecart_minute_fin_pause_apresmidi=($heure_fin_pause_apresmidi-floor($heure_fin_pause_apresmidi))*4;
$minute_fin_pause_apres_midi=($heure_fin_pause_apresmidi-floor($heure_fin_pause_apresmidi))*60;
if (strlen($minute_fin_pause_apres_midi)=='1')
{
$minute_fin_pause_apres_midi="0".$minute_fin_pause_apres_midi;
}
// minute de fin d'apres midi 
$ecart_minute_fin_apresmidi=($heure_fin_journee_bis-floor($heure_fin_journee_bis))*4;
$minute_fin_apresmidi=($heure_fin_journee_bis-floor($heure_fin_journee_bis))*60;
if (strlen($minute_fin_apresmidi)=='1')
{
$minute_fin_apresmidi="0".$minute_fin_apresmidi;
}


//recuperation des heures de début et de fin pour les 4 boutons
$sql="SELECT * FROM login_prof WHERE codeProf=:codeProf ";
$req_boutons_prof_perso=$dbh->prepare($sql);
$req_boutons_prof_perso->execute(array(':codeProf'=>$_SESSION['logged_prof_perso']));
$res_boutons_prof_perso=$req_boutons_prof_perso->fetchAll();
foreach($res_boutons_prof_perso as $res_bouton_prof_perso)
{
$heure_debut_bouton_1=floor($res_bouton_prof_perso['bouton1Debut']);
$minute_debut_bouton_1=($res_bouton_prof_perso['bouton1Debut']-floor($res_bouton_prof_perso['bouton1Debut']))*60;
if (strlen($heure_debut_bouton_1)=='1')
{
$heure_debut_bouton_1="0".$heure_debut_bouton_1;
}
if (strlen($minute_debut_bouton_1)=='1')
{
$minute_debut_bouton_1="0".$minute_debut_bouton_1;
}
$heure_debut_bouton_1_index=floor($res_bouton_prof_perso['bouton1Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_1_index=($res_bouton_prof_perso['bouton1Debut']-floor($res_bouton_prof_perso['bouton1Debut']))*4;


$heure_debut_bouton_2=floor($res_bouton_prof_perso['bouton2Debut']);
$minute_debut_bouton_2=($res_bouton_prof_perso['bouton2Debut']-floor($res_bouton_prof_perso['bouton2Debut']))*60;
if (strlen($heure_debut_bouton_2)=='1')
{
$heure_debut_bouton_2="0".$heure_debut_bouton_2;
}
if (strlen($minute_debut_bouton_2)=='1')
{
$minute_debut_bouton_2="0".$minute_debut_bouton_2;
}
$heure_debut_bouton_2_index=floor($res_bouton_prof_perso['bouton2Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_2_index=($res_bouton_prof_perso['bouton2Debut']-floor($res_bouton_prof_perso['bouton2Debut']))*4;


$heure_debut_bouton_3=floor($res_bouton_prof_perso['bouton3Debut']);
$minute_debut_bouton_3=($res_bouton_prof_perso['bouton3Debut']-floor($res_bouton_prof_perso['bouton3Debut']))*60;
if (strlen($heure_debut_bouton_3)=='1')
{
$heure_debut_bouton_3="0".$heure_debut_bouton_3;
}
if (strlen($minute_debut_bouton_3)=='1')
{
$minute_debut_bouton_3="0".$minute_debut_bouton_3;
}
$heure_debut_bouton_3_index=floor($res_bouton_prof_perso['bouton3Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_3_index=($res_bouton_prof_perso['bouton3Debut']-floor($res_bouton_prof_perso['bouton3Debut']))*4;


$heure_debut_bouton_4=floor($res_bouton_prof_perso['bouton4Debut']);
$minute_debut_bouton_4=($res_bouton_prof_perso['bouton4Debut']-floor($res_bouton_prof_perso['bouton4Debut']))*60;
if (strlen($heure_debut_bouton_4)=='1')
{
$heure_debut_bouton_4="0".$heure_debut_bouton_4;
}
if (strlen($minute_debut_bouton_4)=='1')
{
$minute_debut_bouton_4="0".$minute_debut_bouton_4;
}
$heure_debut_bouton_4_index=floor($res_bouton_prof_perso['bouton4Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_4_index=($res_bouton_prof_perso['bouton4Debut']-floor($res_bouton_prof_perso['bouton4Debut']))*4;


$heure_fin_bouton_1=floor($res_bouton_prof_perso['bouton1Fin']);
$minute_fin_bouton_1=($res_bouton_prof_perso['bouton1Fin']-floor($res_bouton_prof_perso['bouton1Fin']))*60;
if (strlen($heure_fin_bouton_1)=='1')
{
$heure_fin_bouton_1="0".$heure_fin_bouton_1;
}
if (strlen($minute_fin_bouton_1)=='1')
{
$minute_fin_bouton_1="0".$minute_fin_bouton_1;
}
$heure_fin_bouton_1_index=floor($res_bouton_prof_perso['bouton1Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_1_index=($res_bouton_prof_perso['bouton1Fin']-floor($res_bouton_prof_perso['bouton1Fin']))*4;


$heure_fin_bouton_2=floor($res_bouton_prof_perso['bouton2Fin']);
$minute_fin_bouton_2=($res_bouton_prof_perso['bouton2Fin']-floor($res_bouton_prof_perso['bouton2Fin']))*60;
if (strlen($heure_fin_bouton_2)=='1')
{
$heure_fin_bouton_2="0".$heure_fin_bouton_2;
}
if (strlen($minute_fin_bouton_2)=='1')
{
$minute_fin_bouton_2="0".$minute_fin_bouton_2;
}
$heure_fin_bouton_2_index=floor($res_bouton_prof_perso['bouton2Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_2_index=($res_bouton_prof_perso['bouton2Fin']-floor($res_bouton_prof_perso['bouton2Fin']))*4;


$heure_fin_bouton_3=floor($res_bouton_prof_perso['bouton3Fin']);
$minute_fin_bouton_3=($res_bouton_prof_perso['bouton3Fin']-floor($res_bouton_prof_perso['bouton3Fin']))*60;
if (strlen($heure_fin_bouton_3)=='1')
{
$heure_fin_bouton_3="0".$heure_fin_bouton_3;
}
if (strlen($minute_fin_bouton_3)=='1')
{
$minute_fin_bouton_3="0".$minute_fin_bouton_3;
}
$heure_fin_bouton_3_index=floor($res_bouton_prof_perso['bouton3Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_3_index=($res_bouton_prof_perso['bouton3Fin']-floor($res_bouton_prof_perso['bouton3Fin']))*4;


$heure_fin_bouton_4=floor($res_bouton_prof_perso['bouton4Fin']);
$minute_fin_bouton_4=($res_bouton_prof_perso['bouton4Fin']-floor($res_bouton_prof_perso['bouton4Fin']))*60;
if (strlen($heure_fin_bouton_4)=='1')
{
$heure_fin_bouton_4="0".$heure_fin_bouton_4;
}
if (strlen($minute_fin_bouton_4)=='1')
{
$minute_fin_bouton_4="0".$minute_fin_bouton_4;
}
$heure_fin_bouton_4_index=floor($res_bouton_prof_perso['bouton4Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_4_index=($res_bouton_prof_perso['bouton4Fin']-floor($res_bouton_prof_perso['bouton4Fin']))*4;

}




?>
<div  style="float:left;">

<input name="Matin" type="button" id="Matin" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_matin; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_matin; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_matin; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_matin; ?>"' value="Matin" />

<br>

<input name="Aprem" type="button" id="Aprem" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_apresmidi; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_apresmidi; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_apresmidi; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_apresmidi; ?>"' value="Après-midi" />

<br>

<input name="Journee" type="button" id="Journee" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_matin; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_apresmidi; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_matin; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_apresmidi; ?>"' value="Journée" />

</div>

<div  style="float:left;">

<input name="Q1" type="button" id="Q1" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_1_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_1_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_1_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_1_index; ?>"' value="<?php echo $heure_debut_bouton_1."h".$minute_debut_bouton_1."->".$heure_fin_bouton_1."h".$minute_fin_bouton_1; ?>" />

<br>

<input name="Q2" type="button" id="Q2" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_2_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_2_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_2_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_2_index; ?>"' value="<?php echo $heure_debut_bouton_2."h".$minute_debut_bouton_2."->".$heure_fin_bouton_2."h".$minute_fin_bouton_2; ?>" />

</div>

<div  style="float:left;">

<input name="Q3" type="button" id="Q3" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_3_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_3_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_3_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_3_index; ?>"' value="<?php echo $heure_debut_bouton_3."h".$minute_debut_bouton_3."->".$heure_fin_bouton_3."h".$minute_fin_bouton_3; ?>" />

<br>

<input name="Q4" type="button" id="Q4" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_4_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_4_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_4_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_4_index; ?>"' value="<?php echo $heure_debut_bouton_4."h".$minute_debut_bouton_4."->".$heure_fin_bouton_4."h".$minute_fin_bouton_4; ?>" />

</div>



<?php

if ($autoriser_reservation_privee==1)
{

?>
<div  style="float:left;">

Visible par tout le monde : <input name="prive" checked="checked" type="radio" id="prive1" value="1" >

<br>



&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Privé : <input name="prive" type="radio" id="prive0" value="0">

</div>
<?php

}

else

{

echo '<input name="prive" type="hidden" id="prive" value="1">';

}

?>


<div  style="float:left;">

<input type="hidden" name="ajout_reservation" value="ajout_reservation">

<input type="hidden" name="codeProf" value="<?php echo $codeProf; ?>">
<?php
if (isset($_GET['jour']))
{
?>
<input type="hidden" name="jour" value="<?php echo $_GET['jour']; ?>">
<?php
}
?>

Sujet :

<input name="texte" type="text" maxlength="99" size="15">

<input name="Input" type="submit" value="Ajouter">

 </div>

 <br>

  <br> <br><br> <br>





</form>

</div>



<?php

}

//si on demande a modifier une reservation

else

{
echo '<div style="height:72px;width:1000px;margin-left:auto;margin-right:auto;">';	


//recuperation de variables

if(!isset($_GET['codeResa']))

    $res='0';

else

    $res=$_GET['codeResa'];	

if ($res!='0')

{


$sql="SELECT * FROM reservations LEFT JOIN reservations_profs ON (reservations.codeReservation=reservations_profs.codeReservation)  WHERE reservations.codeReservation=:res AND reservations.codeProprietaire='999' and reservations.deleted='0' ";
$req_reservation_modif=$dbh->prepare($sql);
$req_reservation_modif->execute(array(':res'=>$res));
$reservation=$req_reservation_modif->fetchAll();







				//date debut reservation

				$datereservation=$reservation['0']['dateReservation'];

				$datereservation=str_replace("-","",$datereservation);

				$heuredebutreservation=$reservation['0']['heureReservation'];

				if (strlen($heuredebutreservation)<=3)

					{

					$heuredebutreservation="0".$heuredebutreservation;

					}

				$anneereservation=substr($datereservation,0,4);

				$moisreservation=substr($datereservation,4,2);

				$jourreservation=substr($datereservation,6,2);

				$heurereservation=substr($heuredebutreservation,0,2);

				$minutereservation=substr($heuredebutreservation,2,2);	

					
				

				

				//date fin reservation



				$heuredebutenmin=$heurereservation*60+$minutereservation;



				if (strlen($reservation['0']['dureeReservation'])==4)

					{

						$heureduree=substr($reservation['0']['dureeReservation'],0,2);

						$minduree=substr($reservation['0']['dureeReservation'],2,2);

					}

				if (strlen($reservation['0']['dureeReservation'])==3)

					{

						$heureduree=substr($reservation['0']['dureeReservation'],0,1);

						$minduree=substr($reservation['0']['dureeReservation'],1,2);



					}

				if (strlen($reservation['0']['dureeReservation'])==2)

					{

						$heureduree=0;

						$minduree=$reservation['0']['dureeReservation'];

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





		

		

		

}















if ($ok=='1')

{







?>







<form id="rdv" action="index.php?current_week=<?php echo $current_week; ?>&jour=<?php echo $jour; ?>&current_year=<?php echo $current_year; ?>

<?php

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

		

	for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}		
		for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '&materiels_multi[]='.$materiels_multi[$i];
		}
?>





&lar=<?php echo $lar; ?>&horiz=<?php echo $horizon; ?>&hau=<?php echo $hau; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?> " name="resa" onSubmit="return verif_champs()"     method="post">

<?php

}

else

{

?>



<form id="rdv" action="index.php?current_week=<?php echo $current_week; ?>&jour=<?php echo $jour; ?>&current_year=<?php echo $current_year; ?>&current_prof=<?php echo $current_prof; ?>&lar=<?php echo $lar; ?>&hau=<?php echo $hau; ?>&horiz=<?php echo $horizon; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?> " name="resa" onSubmit="return verif_champs()"     method="post">



<?php

}

?>

<div style="float:left;">
Le

<input name="date" id="date" type="text" value="<?php echo date("d-m-Y",mktime(0,0,0,$moisreservation,$jourreservation,$anneereservation)); ?>" maxlength="10" size="12"><br>


de

<select name="heure_d">

<?php

for ($i=floor($heure_debut_journee);$i<=$heure_fin_journee;$i++)
{

echo '<option ';
if ($i==$heurereservation) {echo 'selected ';};

if (strlen($i)==1)
{
 echo 'value="'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}

}
?>




</select>

h
<select name="minute_d">

<?php

for ($i=0;$i<60;$i=$i+15)
{
echo '<option ';
if ($i==$minutereservation) 
{
echo 'selected ';
}
if (strlen($i)==1)
{
 echo 'value="0'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}

}
?>

</select>


à

<select name="heure_f">
<?php
for ($i=floor($heure_debut_journee);$i<=$heure_fin_journee;$i++)
{
echo '<option ';
if ($i==$heurefin) 
{
echo 'selected ';
}


if (strlen($i)==1)
{
echo 'value="'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}
}
?>

  

</select>

h

<select name="minute_f">
<?php

for ($i=0;$i<60;$i=$i+15)
{
echo '<option ';
if ($i==$minfin)
 {
echo 'selected ';
}
if (strlen($i)==1)
{
 echo 'value="0'.$i.'">0'.$i.'</option>';
}
else
{
echo 'value="'.$i.'">'.$i.'</option>';
}

}
?>
 

</select>

</div>

<?php
//ecart entre l'heure de début matinée et l'heure de début par défaut de l'interface
$ecart_heure_debut_matin=floor($heure_debut_journee_bis)-floor($heure_debut_journee);
$heure_debut_matin=floor($heure_debut_journee_bis);
if (strlen($heure_debut_matin)=='1')
{
$heure_debut_matin="0".$heure_debut_matin;
}
//ecart entre l'heure du debut de la pause du matin et l'heure de début par défaut de l'interface
$ecart_heure_debut_pause_matin=floor($heure_debut_pause_matin)-floor($heure_debut_journee);
$heure_debut_pause_matinee=floor($heure_debut_pause_matin);
if (strlen($heure_debut_pause_matinee)=='1')
{
$heure_debut_pause_matinee="0".$heure_debut_pause_matinee;
}
//ecart entre l'heure de fin de la pause du matin et l'heure de début par défaut de l'interface
$ecart_heure_fin_pause_matin=floor($heure_fin_pause_matin)-floor($heure_debut_journee);
$heure_fin_pause_matinee=floor($heure_fin_pause_matin);
if (strlen($heure_debut_pause_matinee)=='1')
{
$heure_debut_pause_matinee="0".$heure_debut_pause_matinee;
}
//ecart entre l'heure de fin de matiné et l'heure de début par défaut de l'interface
$ecart_heure_fin_matin=floor($heure_debut_pause_midi)-floor($heure_debut_journee);
$heure_fin_matin=floor($heure_debut_pause_midi);
if (strlen($heure_fin_matin)=='1')
{
$heure_fin_matin="0".$heure_fin_matin;
}
//ecart entre l'heure de début d'apres midi et l'heure de début par défaut de l'interface
$ecart_heure_debut_apresmidi=floor($heure_fin_pause_midi)-floor($heure_debut_journee);
$heure_debut_apresmidi=floor($heure_fin_pause_midi);
if (strlen($heure_debut_apresmidi)=='1')
{
$heure_debut_apresmidi="0".$heure_debut_apresmidi;
}
//ecart entre l'heure du debut de la pause de l'après-midi et l'heure de début par défaut de l'interface
$ecart_heure_debut_pause_apresmidi=floor($heure_debut_pause_apresmidi)-floor($heure_debut_journee);
$heure_debut_pause_apres_midi=floor($heure_debut_pause_apresmidi);
if (strlen($heure_debut_pause_apres_midi)=='1')
{
$heure_debut_pause_apres_midi="0".$heure_debut_pause_apres_midi;
}
//ecart entre l'heure de fin de la pause de l'après-midi et l'heure de début par défaut de l'interface
$ecart_heure_fin_pause_apresmidi=floor($heure_fin_pause_apresmidi)-floor($heure_debut_journee);
$heure_fin_pause_apres_midi=floor($heure_fin_pause_apresmidi);
if (strlen($heure_fin_pause_apres_midi)=='1')
{
$heure_fin_pause_apres_midi="0".$heure_fin_pause_apres_midi;
}
//ecart entre l'heure de fin d'apres midi et l'heure de fin par défaut de l'interface
$ecart_heure_fin_apresmidi=floor($heure_fin_journee_bis)-floor($heure_debut_journee);
$heure_fin_apresmidi=floor($heure_fin_journee_bis);
if (strlen($heure_fin_apresmidi)=='1')
{
$heure_fin_apresmidi="0".$heure_fin_apresmidi;
}



// minute de début de matinee
$ecart_minute_debut_matin=($heure_debut_journee_bis-floor($heure_debut_journee_bis))*4;
$minute_debut_matin=($heure_debut_journee_bis-floor($heure_debut_journee_bis))*60;
if (strlen($minute_debut_matin)=='1')
{
$minute_debut_matin="0".$minute_debut_matin;
}
//minute du debut de la pause du matin 
$ecart_minute_debut_pause_matin=($heure_debut_pause_matin-floor($heure_debut_pause_matin))*4;
$minute_debut_pause_matin=($heure_debut_pause_matin-floor($heure_debut_pause_matin))*60;
if (strlen($minute_debut_pause_matin)=='1')
{
$minute_debut_pause_matin="0".$minute_debut_pause_matin;
}
// minute de fin de la pause du matin 
$ecart_minute_fin_pause_matin=($heure_fin_pause_matin-floor($heure_fin_pause_matin))*4;
$minute_fin_pause_matin=($heure_fin_pause_matin-floor($heure_fin_pause_matin))*60;
if (strlen($minute_fin_pause_matin)=='1')
{
$minute_fin_pause_matin="0".$minute_fin_pause_matin;
}
// minute de fin de matiné 
$ecart_minute_fin_matin=($heure_debut_pause_midi-floor($heure_debut_pause_midi))*4;
$minute_fin_matin=($heure_debut_pause_midi-floor($heure_debut_pause_midi))*60;
if (strlen($minute_fin_matin)=='1')
{
$minute_fin_matin="0".$minute_fin_matin;
}
// minute de début d'apres midi 
$ecart_minute_debut_apresmidi=($heure_fin_pause_midi-floor($heure_fin_pause_midi))*4;
$minute_debut_apresmidi=($heure_fin_pause_midi-floor($heure_fin_pause_midi))*60;
if (strlen($minute_debut_apresmidi)=='1')
{
$minute_debut_apresmidi="0".$minute_debut_apresmidi;
}
// minute du debut de la pause dd'apres midi
$ecart_minute_debut_pause_apresmidi=($heure_debut_pause_apresmidi-floor($heure_debut_pause_apresmidi))*4;
$minute_debut_pause_apres_midi=($heure_debut_pause_apresmidi-floor($heure_debut_pause_apresmidi))*60;
if (strlen($minute_debut_pause_apres_midi)=='1')
{
$minute_debut_pause_apres_midi="0".$minute_debut_pause_apres_midi;
}
// minute de fin de la pause d'apres midi 
$ecart_minute_fin_pause_apresmidi=($heure_fin_pause_apresmidi-floor($heure_fin_pause_apresmidi))*4;
$minute_fin_pause_apres_midi=($heure_fin_pause_apresmidi-floor($heure_fin_pause_apresmidi))*60;
if (strlen($minute_fin_pause_apres_midi)=='1')
{
$minute_fin_pause_apres_midi="0".$minute_fin_pause_apres_midi;
}
// minute de fin d'apres midi 
$ecart_minute_fin_apresmidi=($heure_fin_journee_bis-floor($heure_fin_journee_bis))*4;
$minute_fin_apresmidi=($heure_fin_journee_bis-floor($heure_fin_journee_bis))*60;
if (strlen($minute_fin_apresmidi)=='1')
{
$minute_fin_apresmidi="0".$minute_fin_apresmidi;
}




//recuperation des heures de début et de fin pour les 4 boutons
$sql="SELECT * FROM login_prof WHERE codeProf=:codeProf ";
$req_boutons_prof_perso=$dbh->prepare($sql);
$req_boutons_prof_perso->execute(array(':codeProf'=>$_SESSION['logged_prof_perso']));
$res_boutons_prof_perso=$req_boutons_prof_perso->fetchAll();
foreach($res_boutons_prof_perso as $res_bouton_prof_perso)
{
$heure_debut_bouton_1=floor($res_bouton_prof_perso['bouton1Debut']);
$minute_debut_bouton_1=($res_bouton_prof_perso['bouton1Debut']-floor($res_bouton_prof_perso['bouton1Debut']))*60;
if (strlen($heure_debut_bouton_1)=='1')
{
$heure_debut_bouton_1="0".$heure_debut_bouton_1;
}
if (strlen($minute_debut_bouton_1)=='1')
{
$minute_debut_bouton_1="0".$minute_debut_bouton_1;
}
$heure_debut_bouton_1_index=floor($res_bouton_prof_perso['bouton1Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_1_index=($res_bouton_prof_perso['bouton1Debut']-floor($res_bouton_prof_perso['bouton1Debut']))*4;


$heure_debut_bouton_2=floor($res_bouton_prof_perso['bouton2Debut']);
$minute_debut_bouton_2=($res_bouton_prof_perso['bouton2Debut']-floor($res_bouton_prof_perso['bouton2Debut']))*60;
if (strlen($heure_debut_bouton_2)=='1')
{
$heure_debut_bouton_2="0".$heure_debut_bouton_2;
}
if (strlen($minute_debut_bouton_2)=='1')
{
$minute_debut_bouton_2="0".$minute_debut_bouton_2;
}
$heure_debut_bouton_2_index=floor($res_bouton_prof_perso['bouton2Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_2_index=($res_bouton_prof_perso['bouton2Debut']-floor($res_bouton_prof_perso['bouton2Debut']))*4;


$heure_debut_bouton_3=floor($res_bouton_prof_perso['bouton3Debut']);
$minute_debut_bouton_3=($res_bouton_prof_perso['bouton3Debut']-floor($res_bouton_prof_perso['bouton3Debut']))*60;
if (strlen($heure_debut_bouton_3)=='1')
{
$heure_debut_bouton_3="0".$heure_debut_bouton_3;
}
if (strlen($minute_debut_bouton_3)=='1')
{
$minute_debut_bouton_3="0".$minute_debut_bouton_3;
}
$heure_debut_bouton_3_index=floor($res_bouton_prof_perso['bouton3Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_3_index=($res_bouton_prof_perso['bouton3Debut']-floor($res_bouton_prof_perso['bouton3Debut']))*4;


$heure_debut_bouton_4=floor($res_bouton_prof_perso['bouton4Debut']);
$minute_debut_bouton_4=($res_bouton_prof_perso['bouton4Debut']-floor($res_bouton_prof_perso['bouton4Debut']))*60;
if (strlen($heure_debut_bouton_4)=='1')
{
$heure_debut_bouton_4="0".$heure_debut_bouton_4;
}
if (strlen($minute_debut_bouton_4)=='1')
{
$minute_debut_bouton_4="0".$minute_debut_bouton_4;
}
$heure_debut_bouton_4_index=floor($res_bouton_prof_perso['bouton4Debut'])-floor($heure_debut_journee);
$minute_debut_bouton_4_index=($res_bouton_prof_perso['bouton4Debut']-floor($res_bouton_prof_perso['bouton4Debut']))*4;


$heure_fin_bouton_1=floor($res_bouton_prof_perso['bouton1Fin']);
$minute_fin_bouton_1=($res_bouton_prof_perso['bouton1Fin']-floor($res_bouton_prof_perso['bouton1Fin']))*60;
if (strlen($heure_fin_bouton_1)=='1')
{
$heure_fin_bouton_1="0".$heure_fin_bouton_1;
}
if (strlen($minute_fin_bouton_1)=='1')
{
$minute_fin_bouton_1="0".$minute_fin_bouton_1;
}
$heure_fin_bouton_1_index=floor($res_bouton_prof_perso['bouton1Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_1_index=($res_bouton_prof_perso['bouton1Fin']-floor($res_bouton_prof_perso['bouton1Fin']))*4;


$heure_fin_bouton_2=floor($res_bouton_prof_perso['bouton2Fin']);
$minute_fin_bouton_2=($res_bouton_prof_perso['bouton2Fin']-floor($res_bouton_prof_perso['bouton2Fin']))*60;
if (strlen($heure_fin_bouton_2)=='1')
{
$heure_fin_bouton_2="0".$heure_fin_bouton_2;
}
if (strlen($minute_fin_bouton_2)=='1')
{
$minute_fin_bouton_2="0".$minute_fin_bouton_2;
}
$heure_fin_bouton_2_index=floor($res_bouton_prof_perso['bouton2Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_2_index=($res_bouton_prof_perso['bouton2Fin']-floor($res_bouton_prof_perso['bouton2Fin']))*4;


$heure_fin_bouton_3=floor($res_bouton_prof_perso['bouton3Fin']);
$minute_fin_bouton_3=($res_bouton_prof_perso['bouton3Fin']-floor($res_bouton_prof_perso['bouton3Fin']))*60;
if (strlen($heure_fin_bouton_3)=='1')
{
$heure_fin_bouton_3="0".$heure_fin_bouton_3;
}
if (strlen($minute_fin_bouton_3)=='1')
{
$minute_fin_bouton_3="0".$minute_fin_bouton_3;
}
$heure_fin_bouton_3_index=floor($res_bouton_prof_perso['bouton3Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_3_index=($res_bouton_prof_perso['bouton3Fin']-floor($res_bouton_prof_perso['bouton3Fin']))*4;


$heure_fin_bouton_4=floor($res_bouton_prof_perso['bouton4Fin']);
$minute_fin_bouton_4=($res_bouton_prof_perso['bouton4Fin']-floor($res_bouton_prof_perso['bouton4Fin']))*60;
if (strlen($heure_fin_bouton_4)=='1')
{
$heure_fin_bouton_4="0".$heure_fin_bouton_4;
}
if (strlen($minute_fin_bouton_4)=='1')
{
$minute_fin_bouton_4="0".$minute_fin_bouton_4;
}
$heure_fin_bouton_4_index=floor($res_bouton_prof_perso['bouton4Fin'])-floor($heure_debut_journee);
$minute_fin_bouton_4_index=($res_bouton_prof_perso['bouton4Fin']-floor($res_bouton_prof_perso['bouton4Fin']))*4;

}













?>
<div  style="float:left;">

<input name="Matin" type="button" id="Matin" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_matin; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_matin; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_matin; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_matin; ?>"' value="Matin" />

<br>

<input name="Aprem" type="button" id="Aprem" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_apresmidi; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_apresmidi; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_apresmidi; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_apresmidi; ?>"' value="Après-midi" />

<br>

<input name="Journee" type="button" id="Journee" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $ecart_heure_debut_matin; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $ecart_heure_fin_apresmidi; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $ecart_minute_debut_matin; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $ecart_minute_fin_apresmidi; ?>"' value="Journée" />

</div>

<div  style="float:left;">

<input name="Q1" type="button" id="Q1" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_1_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_1_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_1_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_1_index; ?>"' value="<?php echo $heure_debut_bouton_1."h".$minute_debut_bouton_1."->".$heure_fin_bouton_1."h".$minute_fin_bouton_1; ?>" />

<br>

<input name="Q2" type="button" id="Q2" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_2_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_2_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_2_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_2_index; ?>"' value="<?php echo $heure_debut_bouton_2."h".$minute_debut_bouton_2."->".$heure_fin_bouton_2."h".$minute_fin_bouton_2; ?>" />

</div>

<div  style="float:left;">

<input name="Q3" type="button" id="Q3" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_3_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_3_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_3_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_3_index; ?>"' value="<?php echo $heure_debut_bouton_3."h".$minute_debut_bouton_3."->".$heure_fin_bouton_3."h".$minute_fin_bouton_3; ?>" />

<br>

<input name="Q4" type="button" id="Q4" onclick='document.forms["rdv"].elements["heure_d"].selectedIndex = "<?php echo $heure_debut_bouton_4_index; ?>";document.forms["rdv"].elements["heure_f"].selectedIndex = "<?php echo $heure_fin_bouton_4_index; ?>";document.forms["rdv"].elements["minute_d"].selectedIndex = "<?php echo $minute_debut_bouton_4_index; ?>";document.forms["rdv"].elements["minute_f"].selectedIndex = "<?php echo $minute_fin_bouton_4_index; ?>"' value="<?php echo $heure_debut_bouton_4."h".$minute_debut_bouton_4."->".$heure_fin_bouton_4."h".$minute_fin_bouton_4; ?>" />

</div>



<?php
if ($autoriser_reservation_privee==1)
{
?>
<div  style="float:left;">

Visible par tout le monde : 

<?php

if ($reservation['0']['diffusable']=='1')

{

echo '<input name="prive" checked="checked" type="radio" id="prive" value="1" ><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Privé : <input name="prive" type="radio" id="prive" value="0">';

}

else

{

echo '<input name="prive" type="radio" id="prive" value="1" ><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Privé : <input name="prive" checked="checked" type="radio" id="prive" value="0">';

}

?>







</div>
<?php
}
else
{
echo '<input name="prive" type="hidden" id="prive" value="1">';
}
?>


<div  style="float:left;">

<input type="hidden" name="modif_reservation" value="modif_reservation">

<input type="hidden" name="codeProf" value="<?php echo $codeProf; ?>">

<input type="hidden" name="codeResa" value="<?php echo $res; ?>">



Sujet :

<input name="texte" type="text" maxlength="99" size="15" value="<?php echo $reservation['0']['commentaire']; ?>" >

</div>

<div  style="float:left">

<input name="Input" type="submit" value="Modifier">



</form>

 

 

 <?php

 //suppression reservation

if ($ok=='1')

{


?>

<form id="rdv2" action="index.php?current_week=<?php echo $current_week; ?>&current_year=<?php echo $current_year; ?>

<?php

	for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}

		

	for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}

	for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}		
		for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '&materiels_multi[]='.$materiels_multi[$i];
		}
?>





&lar=<?php echo $lar; ?>&horiz=<?php echo $horizon; ?>&hau=<?php echo $hau; ?>&jour=<?php echo $jour; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?> " name="resa" onSubmit="return verif_champs()"     method="post">

<?php

}

else

{

?>



<form id="rdv2" action="index.php?current_week=<?php echo $current_week; ?>&jour=<?php echo $jour; ?>&current_year=<?php echo $current_year; ?>&current_prof=<?php echo $current_prof; ?>&lar=<?php echo $lar; ?>&hau=<?php echo $hau; ?>&horiz=<?php echo $horizon; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?> " name="resa" onSubmit="return verif_champs()"     method="post">



<?php

}

?>

<input type="hidden" name="supp_reservation" value="supp_reservation">

<input type="hidden" name="codeProf" value="<?php echo $codeProf; ?>">

<input type="hidden" name="codeResa" value="<?php echo $res; ?>">

<input name="Input" type="submit" value="Supprimer">



</form>

 </div>





</div>



<?php

}









?>







<script type="text/javascript">

    Calendar.setup({

        inputField     :    "date",   // id of the input field

        ifFormat       :    "%d-%m-%Y",       // format of the input field

        daFormat	   :   "%d-%m-%Y",

		showsTime      :    false,

        timeFormat     :    "24",

		align 		: "Tc"



    });

</script>



<script type="text/javascript">

function verif_champs()

{

if(document.resa.texte.value == "")

{

alert("Veuillez entrer le sujet de votre réservation");

document.resa.texte.focus();

return false;

}



}

</script> 






<?php

}

 }
 
 if( $ok=='1' && $horizon=='2' && isset($_SESSION['logged_prof_perso'] ))
 
 
 	
			
				{
				
				if (isset($seance_clicable_area))
					{
					if ($seance_clicable_area!="")
					{
					echo $seance_clicable_area;
					}
					}
				echo "</map>";
				
				}
 
 
 
 
 
//si on utilise le login générique pour se loguer, on ferme la balise map car sinon elle reste ouverte car autrement elle n'est fermée qu' avec le login perso
 if (isset($_SESSION['logged_prof_generique']) && $ok=='0')
 {
 echo '</map>';
  echo '</div>';
 }

//si on utilise le login perso pour se loguer, on ferme la balise div car sinon elle reste ouverte 
 if (isset($_SESSION['logged_prof_perso']) )
 {
  echo '</div>';
 }



// si on est dans emploi du temps smartphone

 if (isset($_SESSION['logged_prof_smart_perso']) || isset($_SESSION['logged_prof_smart_gene']) || isset($_SESSION['loggedstudentsmartphone']))

 {

 ?>

	<map name="plan">

<?php

//largeur des bandes grises sur l edt. 

$leftwidth=26;

$topheight=15;







//recuperation de la largeur de l ecran 



if (isset($_GET['lar']))

	{

	$largeur=$_GET['lar'];
	

}

//recuperation de la hauteur de l ecran 



if (isset($_GET['hau']))

	{

	$hauteur=$_GET['hau'];

	}



	

//on recupere aussi la taille de l ecran qui provient de la page de login en post et non pas en get si get pas encore defini

if (!isset($_GET['hau']))

{

if (isset($_POST['larg']))

	{

	$largeur=$_POST['larg'];

	

	$hauteur=$_POST['haut'];

		}

	}	

	

//calibrage par rapport a firefox

$hauteur=$hauteur-0;

if ($hauteur<482)

{

$hauteur=$hauteur;

}

$largeur=$largeur;

if ($largeur<974)

{

$largeur=$largeur;

}	





















//coordonnees des zones

//zone de gauche
//si iphone
if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) 
{ 
$leftx=0;
$rightx=($leftwidth+288)/3;
$topy=0;
$bottomy=260+$topheight;
} 
//si htc
elseif (stristr($_SERVER['HTTP_USER_AGENT'], "HTC") ) 
{ 
$leftx=0;
$rightx=($leftwidth+225)/3;
$topy=0;
$bottomy=240+$topheight;	
} 
//si autre tel
else
{
$leftx=0;
$rightx=($leftwidth+$largeur)/3;
$topy=0;
$bottomy=$hauteur+$topheight;	
}
if (isset($_SESSION['logged_prof_smart_perso']) || isset($_SESSION['logged_prof_smart_gene']) )
		{
			echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?current_year='.date("o",$previousdate).'&current_prof='.$current_prof.'&current_week='.date("W",$previousdate).'&hideprivate='.$_GET['hideprivate'].'&lar='.$lar.'&hau='.$hau.'" >';		
		}	
else
{
echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?current_year='.date("o",$previousdate).'&current_student='.$current_student.'&current_week='.date("W",$previousdate).'&lar='.$lar.'&hau='.$hau.'" >';		
}

//coordonnees des zones

//zone de droite
//si iphone
if (stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || strpos($_SERVER['HTTP_USER_AGENT'], "iPod")) 
{ 
$leftx=2*($leftwidth+288)/3;
$rightx=($leftwidth+288);
$topy=0;
$bottomy=260+$topheight;	
} 
//si htc
elseif (stristr($_SERVER['HTTP_USER_AGENT'], "HTC") ) 
{ 
$leftx=2*($leftwidth+225)/3;
$rightx=($leftwidth+225);
$topy=0;
$bottomy=240+$topheight;	
} 
//si autre tel
else
{
$leftx=2*($leftwidth+$largeur)/3;
$rightx=($leftwidth+$largeur);
$topy=0;
$bottomy=$hauteur+$topheight;	
}
																																				

if (isset($_SESSION['logged_prof_smart_perso']) || isset($_SESSION['logged_prof_smart_gene']))
{
echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?current_year='.date("o",$nextdate).'&current_prof='.$current_prof.'&hideprivate='.$_GET['hideprivate'].'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'" >';		
}
else
{
echo '<area alt="" shape="rect" coords="' .$leftx. ',' .$topy. ',' .$rightx. ',' .$bottomy. '" HREF="index.php?current_year='.date("o",$nextdate).'&current_student='.$current_student.'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'" >';		
}



?>

</map>







<?php

 

 }

 

 

 



?>





<?php

if (!isset($_SESSION['logged_prof_smart_gene']) && !isset($_SESSION['logged_prof_smart_perso']) && !isset($_SESSION['loggedstudentsmartphone']) )

{

?>

<div style="width:980px;margin-left:auto;margin-right:auto;">


<?php
//MERCI DE NE PAS EFFACER LE NOM DE MON COLLEGUE ET LE MIEN. VOUS POUVEZ MODIFIER TOUTE L'INTERFACE WEB MAIS LA SEULE CHOSE QU'ON DEMANDE, C'EST DE LAISSER NOS DEUX NOMS.
?>
D&eacute;velopp&eacute; par <span style="font-weight:bold;">Bruno MILLION</span> (IUT GMP) et par <span style="font-weight:bold;">Ga&euml;tan COLOMBIER</span> (IUT GMP) pour le PST de Ville d'Avray (Université Paris Ouest) - <?php echo $compteur;?> pages vues.<br>

</div>

<?php

}

?>




</body>

</html>






