<?php



/**

 * Emploi du temps version etudiants



 */



?>

<?php if (isset($current_student) )
	{
    $semaine_actuelle=date('W');
	$annee_actuelle=date('Y');
	}
	
	
	
$info_bulle="";


if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}	
	
	
	//recherche du nom du mois qui est affiché dans la vue mensuelle
	//methode : on cherche la date du premier lundi du mois qui est affiché et on ajoute 2 semaines
if ($horizon=='2' || $horizon=='4' )
{


$jours=date("w",mktime(0,0,0,1,1,$current_year));

if($jours==0){$jours=7;}

if($jours>4){$premieran=0;}else{$premieran=-1;}
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




$troisieme_lundi_du_mois=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7)+14,$current_year); 

$nom_du_mois=date("F",$troisieme_lundi_du_mois);






if ($nom_du_mois=='January')
{
$nom_du_mois='Janvier';
}

if ($nom_du_mois=='February')
{
$nom_du_mois='Février';
}

if ($nom_du_mois=='March')
{
$nom_du_mois='Mars';
}

if ($nom_du_mois=='April')
{
$nom_du_mois='Avril';
}

if ($nom_du_mois=='May')
{
$nom_du_mois='Mai';
}

if ($nom_du_mois=='June')
{
$nom_du_mois='Juin';
}

if ($nom_du_mois=='July')
{
$nom_du_mois='Juillet';
}

if ($nom_du_mois=='August')
{
$nom_du_mois='Août';
}

if ($nom_du_mois=='September')
{
$nom_du_mois='Septembre';
}

if ($nom_du_mois=='October')
{
$nom_du_mois='Octobre';
}

if ($nom_du_mois=='November')
{
$nom_du_mois='Novembre';
}

if ($nom_du_mois=='December')
{
$nom_du_mois='Décembre';
}

}




// Largeur et hauteur des entêtes du calendrier
if ($horizon==0)
{
$leftwidth=30;
$topheight=40;
}
elseif ($horizon==1)
{
$leftwidth=50;
$topheight=50;
}
elseif ($horizon==2)
{
$leftwidth=40;
$topheight=23;
}
elseif ($horizon==3)
{
$leftwidth=30;
$topheight=40;
}
elseif ($horizon==4)
{
$leftwidth=80;
$topheight=23;
}

//recuperation de la largeur de l ecran a laquelle on enleve 50 pour que ca rentre en largeur dans firefox
if (isset($_GET['lar']))
{
$largeur=$_GET['lar']-50;

if ($largeur<750)
	{
	$largeur=750;
	}
}

//recuperation de la hauteur de l ecran a laquelle on enleve 235 pour que ca rentre en hauteur dans firefox
if (isset($_GET['hau']))
{
$hauteur=$_GET['hau']-210;

if ($hauteur<520)
	{
	$hauteur=520;
	}
	}

//on recupere aussi la taille de l ecran qui provient de la page de login en post et non pas en get

if (isset($_POST['larg']))

	{

	$largeur=$_POST['larg']-50;

	if ($largeur<750)

		{

		$largeur=750;

		}

	$hauteur=$_POST['haut']-210;

	if ($hauteur<520)

		{

		$hauteur=520;

		}

	}	
	
	
	
	
	
	
	
	
	
	
	
	


//bandeau du haut	
include ('menu_principal_etudiant.php');

?>


<!--[if IE]>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wi').value=document.documentElement.clientWidth;document.getElementById('screen_hei').value=document.documentElement.clientHeight">



	<input type="hidden" name="lar" id="screen_wi" value="">

	<input type="hidden" name="hau" id="screen_hei" value="">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input type="hidden" name="jour" value="<?php echo $jour ?>">

<?php

if ($horizon=="1")

{

?>

Vue hebdo horizontale :<input name="horiz" checked="checked" type="radio" id="horiz1" value="1" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" >

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" >

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" >

&nbsp;&nbsp;Jour J :<input name="horiz" type="radio" id="horiz3" value="3" >

<?php

}

if ($horizon=="0")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" checked="checked" type="radio" id="horiz0" value="0" >

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" >

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" >

&nbsp;&nbsp;Jour J :<input name="horiz"  type="radio" id="horiz3" value="3" >
<?php

}



if ($horizon=="2")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" >

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" >

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" checked="checked" type="radio" id="horiz2" value="2" >

&nbsp;&nbsp;Jour J :<input name="horiz"  type="radio" id="horiz3" value="3" >

<?php

}

if ($horizon=="3")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" >

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" >

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" >

&nbsp;&nbsp;Jour J :<input name="horiz" checked="checked" type="radio" id="horiz3" value="3" >
<?php

}

if ($horizon=="4")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" >

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" checked="checked" type="radio" id="horiz4" value="4" >

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" >

&nbsp;&nbsp;Jour J :<input name="horiz"  type="radio" id="horiz3" value="3" >
<?php

}

?>
<input name="" type="submit" value="Envoyer">

<br>
<![endif]-->



<!--[if !IE]>-->

<form name="form" id="form" action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight">



	<input type="hidden" name="lar" id="screen_widt" value="">

	<input type="hidden" name="hau" id="screen_heigh" value="">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input type="hidden" name="jour" value="<?php echo $jour ?>">


 <?php



if ($horizon=="1")

{

?>

Vue hebdo horizontale :<input name="horiz" checked="checked" type="radio" id="horiz1" value="1" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();" >

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Jour J :<input name="horiz" type="radio" id="horiz3" value="3" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

<?php

}

if ($horizon=="0")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" checked="checked" type="radio" id="horiz0" value="0" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Jour J :<input name="horiz" type="radio" id="horiz3" value="3" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">
<?php

}



if ($horizon=="2")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" checked="checked" type="radio" id="horiz2" value="2" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Jour J :<input name="horiz" type="radio" id="horiz3" value="3" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">
<?php

}

if ($horizon=="3")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" type="radio" id="horiz4" value="4" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Jour J :<input name="horiz" checked="checked" type="radio" id="horiz3" value="3" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">
<?php

}
if ($horizon=="4")

{

?>

Vue hebdo horizontale :<input name="horiz"  type="radio" id="horiz1" value="1" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue hebdo verticale :<input name="horiz" type="radio" id="horiz0" value="0" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle :<input name="horiz" checked="checked" type="radio" id="horiz4" value="4" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Vue mensuelle réduite :<input name="horiz" type="radio" id="horiz2" value="2" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

&nbsp;&nbsp;Jour J :<input name="horiz"  type="radio" id="horiz3" value="3" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">
<?php

}


 ?>
 <input name="" type="submit"  value="Envoyer">

 <br>

<!--<![endif]-->


<?php if (isset($current_student))

	{

	function premierlundi($semaine,$annee)
	{
	$jours=date("w",mktime(0,0,0,1,1,$annee));
	if($jours==0){$jours=7;}
	if($jours>4){$premieran=0;}else{$premieran=-1;}
	$newdate=mktime(0,0,0,1,(($semaine+$premieran)*7),$annee); 
	$jsem=date("w",$newdate);
	return $newdate=mktime(0,0,0,1,(($semaine+$premieran)*7)+(1-$jsem),$annee); 
	}


// Appel de la fonction

$current_date=premierlundi($current_week,$current_year);
		$nextdate=premierlundi($current_week+1,$current_year);
		$previousdate=premierlundi($current_week-1,$current_year);
		$nextMonth=premierlundi($current_week+5,$current_year);
		$previousMonth=premierlundi($current_week-5,$current_year);
		if ($horizon=='2' || $horizon=='4')
			{
			$nextmonth=premierlundi($current_week-$numerosemainedanslemois+5,$current_year);
			$previousmonth=premierlundi($current_week-$numerosemainedanslemois-4,$current_year);
			}

//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine. Si vue jour j, on décale d'un jour.
//double fleche de gauche
if ($horizon !='2' && $horizon !='4' )
{
if ($horizon =='3')
{
if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
$jour_precedent=  mktime(0, 0, 0, date("m")  , date("d")+$jour-1, date("Y"));
$jour_suivant=  mktime(0, 0, 0, date("m")  , date("d")+$jour+1, date("Y"));
$jour_semaine_precedent=  mktime(0, 0, 0, date("m")  , date("d")+$jour-7, date("Y"));
$jour_semaine_suivant=  mktime(0, 0, 0, date("m")  , date("d")+$jour+7, date("Y"));

$current_day_nom_jour=date("l",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));



//traduction francais du nom du jour
		if ($current_day_nom_jour=='Monday')
			{
			$current_day_nom_jour='Lundi';
			}
		if ($current_day_nom_jour=='Tuesday')
			{
			$current_day_nom_jour='Mardi';
			}
		if ($current_day_nom_jour=='Wednesday')
			{
			$current_day_nom_jour='Mercredi';
			}
		if ($current_day_nom_jour=='Thursday')
			{
			$current_day_nom_jour='Jeudi';
			}
		if ($current_day_nom_jour=='Friday')
			{
			$current_day_nom_jour='Vendredi';
			}
		if ($current_day_nom_jour=='Saturday')
			{
			$current_day_nom_jour='Samedi';
			}
		if ($current_day_nom_jour=='Sunday')
			{
			$current_day_nom_jour='Dimanche';
			}

//traduction francais du nom du mois
$current_day_nom_mois=date("F",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
		if ($current_day_nom_mois=='January')
			{
			$current_day_nom_mois='janvier';
			}
		if ($current_day_nom_mois=='February')
			{
			$current_day_nom_mois='février';
			}
		if ($current_day_nom_mois=='March')
			{
			$current_day_nom_mois='mars';
			}
		if ($current_day_nom_mois=='April')
			{
			$current_day_nom_mois='avril';
			}
		if ($current_day_nom_mois=='May')
			{
			$current_day_nom_mois='mai';
			}
		if ($current_day_nom_mois=='June')
			{
			$current_day_nom_mois='juin';
			}
		if ($current_day_nom_mois=='July')
			{
			$current_day_nom_mois='juillet';
			}			
		if ($current_day_nom_mois=='August')
			{
			$current_day_nom_mois='août';
			}	
		if ($current_day_nom_mois=='September')
			{
			$current_day_nom_mois='septembre';
			}	
		if ($current_day_nom_mois=='October')
			{
			$current_day_nom_mois='octobre';
			}	
		if ($current_day_nom_mois=='November')
			{
			$current_day_nom_mois='novembre';
			}	
		if ($current_day_nom_mois=='December')
			{
			$current_day_nom_mois='décembre';
			}		
			
			
$current_day_nom=$current_day_nom_jour." ".date("d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")))." ".$current_day_nom_mois." ".date("o",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));



	

   echo '<a href="index.php?current_year='.date("o",$jour_semaine_precedent).'&current_student='.$current_student.'&horiz='.$horizon;
}

else
{
 echo '<a href="index.php?current_year='.date("o",$previousMonth).'&current_student='.$current_student.'&horiz='.$horizon;
}
		 
		
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine. Si vue jour j, on décale d'un jour

if ($horizon=='3')
{
$jour_moins_un=$jour-1;
$jour_plus_un=$jour+1;
$jour_moins_sept=$jour-7;
$jour_plus_sept=$jour+7;
echo '&jour='.$jour_moins_sept.'&current_week='.date("W",$jour_semaine_precedent).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> ';
}
else
{
echo '&jour='.$jour.'&current_week='.date("W",$previousMonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> '; 
}
}

//fleche de gauche
if ($horizon=='3')
{
   echo '<a href="index.php?current_year='.date("o",$jour_precedent).'&current_student='.$current_student.'&horiz='.$horizon;
}
elseif ($horizon=='2' || $horizon=='4')
{
     echo '<a href="index.php?current_year='.date("o",$previousmonth).'&current_student='.$current_student.'&horiz='.$horizon;
}
else
{
 echo '<a href="index.php?current_year='.date("o",$previousdate).'&current_student='.$current_student.'&horiz='.$horizon;
}
		
		
		
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine. Si vue jour j, on décale d'un jour
if ($horizon=='2' || $horizon=='4')
{
		echo '&jour='.$jour.'&current_week='.date("W",$previousmonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> Semaine : <input name="current_week" type="text"  maxlength="2"  class="text"  value="'.$current_week.'"> '.$nom_du_mois.' <input class="text"  maxlength="4" name="current_year" type="text"  value="'.$current_year.'">   <a href="index.php?current_year='.date("o",$nextmonth).'&current_student='.$current_student.'&horiz='.$horizon;
}
elseif ($horizon=='3')
{
$jour_moins_un=$jour-1;
$jour_plus_un=$jour+1;
$jour_moins_sept=$jour-7;
$jour_plus_sept=$jour+7;

echo '&jour='.$jour_moins_un.'&current_week='.date("W",$jour_precedent).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> <input name="current_week" type="hidden" value="'.$current_week.'"><input name="current_year" type="hidden"  value="'.$current_year.'">'.$current_day_nom.' <a href="index.php?current_year='.date("o",$jour_suivant).'&jour='.$jour_plus_un.'&current_student='.$current_student.'&horiz='.$horizon;
}
else
{
echo '&jour='.$jour.'&current_week='.date("W",$previousdate).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> Semaine : <input name="current_week" type="text"  maxlength="2"  class="text"  value="'.$current_week.'"> Ann&eacute;e : <input class="text"  maxlength="4" name="current_year" type="text"  value="'.$current_year.'"> <a href="index.php?current_year='.date("o",$nextdate).'&current_student='.$current_student.'&horiz='.$horizon;
}

//fleche de droite
	 	


	 

	 

	 
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine
if ($horizon=='2'  || $horizon=='4')
{
	 echo '&jour='.$jour.'&current_week='.date("W",$nextmonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
elseif ($horizon=='3')
{

 echo '&current_week='.date("W",$jour_suivant).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a>';
}
else
{
 echo '&jour='.$jour.'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a>';
}



//double fleche de droite
if ($horizon!='2'  && $horizon!='4')
{
if ($horizon=='3')
{
echo ' <a href="index.php?current_year='.date("o",$jour_semaine_suivant).'&jour='.$jour_plus_sept.'&current_student='.$current_student.'&horiz='.$horizon;
}
else
{
echo ' <a href="index.php?current_year='.date("o",$nextMonth).'&current_student='.$current_student.'&horiz='.$horizon;
}
	 	


	 

	 

	 
		

if ($horizon=='3')
{

 echo '&current_week='.date("W",$jour_semaine_suivant).'&lar='.$lar.'&hau='.$hau.'"><img alt="" width="20" height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
else
{
 echo '&jour='.$jour.'&current_week='.date("W",$nextMonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
}	 

?>
</form>



<?php 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	//si pas login générique (chaque étudiant a son login perso)
 if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])

	{

	
?>
<!--[if IE]>

<?php
//bouton "Export PDF..." 
?>
<form action="pdf_menu.php" name="pdf" method="get" onsubmit="document.getElementById('screen_wid3').value=document.documentElement.clientWidth;document.getElementById('screen_heig3').value=document.documentElement.clientHeight">


   
   

	<input type="hidden" name="lar" id="screen_wid3" value="">

	<input type="hidden" name="hau" id="screen_heig3" value="">
	<input type="hidden" name="horiz" id="horiz3" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>
<?php
//bouton "mes modules" 
?>
<form action="module_etudiant.php" name="module" method="get" onsubmit="document.getElementById('screen_wid4').value=document.documentElement.clientWidth;document.getElementById('screen_heig4').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid4" value="">

	<input type="hidden" name="hau" id="screen_heig4" value="">
	<input type="hidden" name="horiz" id="horiz4" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<?php
//bouton "mes ds" 
?>
<form action="mes_ds_etudiant.php" name="ds" method="get" onsubmit="document.getElementById('screen_wid10').value=document.documentElement.clientWidth;document.getElementById('screen_heig10').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid10" value="">

	<input type="hidden" name="hau" id="screen_heig10" value="">
	<input type="hidden" name="horiz" id="horiz10" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>


<![endif]-->


<!--[if !IE]>-->
<?php
//bouton "Export PDF..." 
?>
<form action="pdf_menu.php" name="pdf2" method="get" onsubmit="document.getElementById('screen_wid5').value=window.innerWidth;document.getElementById('screen_heig5').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid5" value="">

	<input type="hidden" name="hau" id="screen_heig5" value="">
	<input type="hidden" name="horiz" id="horiz5" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>
<?php
//bouton "mes modules..." 
?>
<form action="module_etudiant.php" name="module2" method="get" onsubmit="document.getElementById('screen_wid6').value=window.innerWidth;document.getElementById('screen_heig6').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid6" value="">

	<input type="hidden" name="hau" id="screen_heig6" value="">
	<input type="hidden" name="horiz" id="horiz6" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>


<?php
//bouton "mes ds..." 
?>
<form action="mes_ds_etudiant.php" name="ds2" method="get" onsubmit="document.getElementById('screen_wid11').value=window.innerWidth;document.getElementById('screen_heig11').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid11" value="">

	<input type="hidden" name="hau" id="screen_heig11" value="">
	<input type="hidden" name="horiz" id="horiz11" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>



<!--<![endif]-->



	<!--[if IE]>

<?php 
$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
if ((isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) && $horizon!='3') 

	{

	?>	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid').value=document.documentElement.clientWidth;document.getElementById('screen_heig').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wid" value="">

	<input type="hidden" name="hau" id="screen_heig" value="">
	<input type="hidden" name="horiz" id="horiz" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}
elseif (isset($current_student) && $date_visu!=$date_du_jour   && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) )
{
?>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid7b').value=document.documentElement.clientWidth;document.getElementById('screen_heig7b').value=document.documentElement.clientHeight">
  

	<input type="hidden" name="lar" id="screen_wid7b" value="">

	<input type="hidden" name="hau" id="screen_heig7b" value="">
	<input type="hidden" name="horiz" id="horiz7" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour au jour J"></form><br>
<?php
}

?>





<![endif]-->



<!--[if !IE]>-->



<?php 
$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));


if ((isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) && $horizon!='3') 

	{

	?>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid2').value=window.innerWidth;document.getElementById('screen_heig2').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wid2" value="">

	<input type="hidden" name="hau" id="screen_heig2" value="">
	<input type="hidden" name="horiz" id="horiz2" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}

elseif (isset($current_student) && $date_visu!=$date_du_jour   && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) )
{
?>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid15').value=window.innerWidth;document.getElementById('screen_heig15').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wid15" value="">

	<input type="hidden" name="hau" id="screen_heig15" value="">
	<input type="hidden" name="horiz" id="horiz15" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour au jour J"></form><br>
<?php
}


?>

<!--<![endif]-->

	

	

	

	

	

	<?php
if ($horizon=="0" )
{
echo '<img src="vue_etudiant_verticale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="1")
{
echo '<img src="vue_etudiant_horizontale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}

elseif ($horizon=="2")
{
echo '<img src="vue_etudiant_mensuelle.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="3")
{
echo '<img src="vue_etudiant_journaliere.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.'&jour='.$jour.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="4")
{
echo '<img src="vue_etudiant_mensuelle2.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}

else
{
echo '<img src="vue_etudiant_verticale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
		

	}
	//si login générique
	else

	{
	
	
?>
<!--[if IE]>
<?php
//bouton "Export PDF..." 
?>
<form action="pdf_menu.php" name="pdf3" method="get" onsubmit="document.getElementById('screen_wid7').value=document.documentElement.clientWidth;document.getElementById('screen_heig7').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid7" value="">

	<input type="hidden" name="hau" id="screen_heig7" value="">
	<input type="hidden" name="horiz" id="horiz7" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>
<?php
//bouton "mes modules" 
?>
<form action="module_etudiant.php" name="module3" method="get" onsubmit="document.getElementById('screen_wid8').value=document.documentElement.clientWidth;document.getElementById('screen_heig8').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid8" value="">

	<input type="hidden" name="hau" id="screen_heig8" value="">
	<input type="hidden" name="horiz" id="horiz8" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<?php
//bouton "mes ds" 
?>
<form action="mes_ds_etudiant.php" name="ds3" method="get" onsubmit="document.getElementById('screen_wid12').value=document.documentElement.clientWidth;document.getElementById('screen_heig12').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid12" value="">

	<input type="hidden" name="hau" id="screen_heig12" value="">
	<input type="hidden" name="horiz" id="horiz12" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>


<![endif]-->


<!--[if !IE]>-->
<?php
//bouton "Export PDF..." 
?>
<form action="pdf_menu.php" name="pdf4" method="get" onsubmit="document.getElementById('screen_wid9').value=window.innerWidth;document.getElementById('screen_heig9').value=window.innerHeight">

   

	<input type="hidden" name="lar" id="screen_wid9" value="">

	<input type="hidden" name="hau" id="screen_heig9" value="">
	<input type="hidden" name="horiz" id="horiz9" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>
<?php
//bouton "mes modules..." 
?>
<form action="module_etudiant.php" name="module4" method="get" onsubmit="document.getElementById('screen_wid14').value=window.innerWidth;document.getElementById('screen_heig14').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid14" value="">

	<input type="hidden" name="hau" id="screen_heig14" value="">
	<input type="hidden" name="horiz" id="horiz14" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<?php
//bouton "mes ds..." 
?>
<form action="mes_ds_etudiant.php" name="ds4" method="get" onsubmit="document.getElementById('screen_wid13').value=window.innerWidth;document.getElementById('screen_heig13').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid13" value="">

	<input type="hidden" name="hau" id="screen_heig13" value="">
	<input type="hidden" name="horiz" id="horiz13" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<!--<![endif]-->

<?php	
	

		
	
	//echo '<a href="index.php?current_year='.date("o",$previousmonth).'&current_student='.$current_student.'&current_week='.date("W",$previousmonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> <a href="index.php?current_year='.date("o",$previousdate).'&current_student='.$current_student.'&current_week='.date("W",$previousdate).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> '.$res_student['0']['nom'].' - Semaine '.$current_week.' - Année '.$current_year.' <a href="index.php?current_year='.date("o",$nextdate).'&current_student='.$current_student.'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a> <a href="index.php?current_year='.date("o",$nextmonth).'&current_student='.$current_student.'&current_week='.date("W",$nextmonth).'&lar='.$lar.'&hau='.$hau.'"><img alt=""  height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';

	

	

?>	

	<!--[if IE]>

<?php 
$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
if ((isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) && $horizon!='3')

	{

	?>	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid11b').value=document.documentElement.clientWidth;document.getElementById('screen_heig11b').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wid11b" value="">

	<input type="hidden" name="hau" id="screen_heig11b" value="">
	<input type="hidden" name="horiz" id="horiz11b" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form>

<?php

}
elseif (isset($current_student) && $date_visu!=$date_du_jour   && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) )
{
?>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid17').value=document.documentElement.clientWidth;document.getElementById('screen_heig17').value=document.documentElement.clientHeight">
  

	<input type="hidden" name="lar" id="screen_wid17" value="">

	<input type="hidden" name="hau" id="screen_heig17" value="">
	<input type="hidden" name="horiz" id="horiz17" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour au jour J"></form><br>
<?php
}

?>





<![endif]-->



<!--[if !IE]>-->



<?php 
$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
if ((isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) && $horizon!='3')

	{

	?>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid12b').value=window.innerWidth;document.getElementById('screen_heig12b').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wid12b" value="">

	<input type="hidden" name="hau" id="screen_heig12b" value="">
	<input type="hidden" name="horiz" id="horiz12b" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form>

<?php

}
elseif (isset($current_student) && $date_visu!=$date_du_jour   && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) )
{
?>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid18').value=window.innerWidth;document.getElementById('screen_heig18').value=window.innerHeight">
 

	<input type="hidden" name="lar" id="screen_wid18" value="">

	<input type="hidden" name="hau" id="screen_heig18" value="">
	<input type="hidden" name="horiz" id="horiz18" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
	<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour au jour J"></form><br>
<?php
}
?>

<!--<![endif]-->

	

	

	

	

	

	<?php
if ($horizon=="0" )
{
echo '<img src="vue_etudiant_verticale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="1")
{
echo '<img src="vue_etudiant_horizontale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}

elseif ($horizon=="2")
{
echo '<img src="vue_etudiant_mensuelle.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="3")
{
echo '<img src="vue_etudiant_journaliere.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.'&jour='.$jour.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
elseif ($horizon=="4")
{
echo '<img src="vue_etudiant_mensuelle2.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}

else
{
echo '<img src="vue_etudiant_verticale.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1"/>';
}
		

	}

	

	
	
	
	
	
	
	
	

/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*  SEANCES DES GROUPES CLICABLES POUR OBTENIR LE DETAIL DU MODULE           */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/
if($horizon==1 || $horizon==0 || $horizon==3 || $horizon==2 || $horizon==4)
{
//ouverture de la balise map
echo '<map name="plan1">';


//pour chaque bdd

$dbh=null;
	for ($k=0;$k<=$nbdebdd-1;$k++)
	{
	$base_a_utiliser=$base[$k];
		try
		{
		$dbh=new PDO("mysql:host=$serveur;dbname=$base_a_utiliser;",$user,$pass);
		}

		catch(PDOException $e)
		{
		die("erreur ! : " .$e->getMessage());
		}


// Pour tous les groupes dont l'etudiant fait partie
$sql="SELECT *,ressources_etudiants.nom AS nom, ressources_groupes.nom AS nom_groupe FROM ressources_etudiants LEFT JOIN ressources_groupes_etudiants USING (codeEtudiant) LEFT JOIN ressources_groupes USING (codeGroupe) WHERE ressources_etudiants.codeEtudiant=:current_student AND ressources_etudiants.deleted='0' AND ressources_groupes_etudiants.deleted='0' AND ressources_groupes.deleted='0' ";
$req_groupes2=$dbh->prepare($sql);
$req_groupes2->execute(array(':current_student'=>$current_student));
$res_groupe=$req_groupes2->fetchAll();

$critere="AND (";
foreach($res_groupe as $res_groupes)
{
 $critere .= "seances_groupes.codeRessource='".$res_groupes['codeGroupe']."' OR ";
}
$critere .= "0)";


//preparation des requetes
if ($diffusable==1)
{
$sql="SELECT *,seances.dureeSeance as duree_de_la_seance,seances.commentaire as commentaire_seance FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
$req_seance=$dbh->prepare($sql);
}
else
{
$sql="SELECT *,seances.dureeSeance as duree_de_la_seance,seances.commentaire as commentaire_seance FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances.dateSeance=:current_day AND seances.deleted=0 AND seances.diffusable=1 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
$req_seance=$dbh->prepare($sql);
}	


$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom ";
$req_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type=$dbh->prepare($sql);	


//création de l'affichage de l'info bulle
if ($horizon==3)
{
$compteur_jour=1;
}
elseif ($horizon==2 )
{
$compteur_jour=34;
}
elseif  ($horizon==4)
{
//$hauteur=$hauteur*6;

$compteur_jour=34;
}
else
{
$compteur_jour=$days;
}
// Pour les 5 ou 6 jours à afficher, on interroge la DB
for ($day=0;$day<$compteur_jour;$day++)
	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
	
if ($horizon==3)	
{
$current_day=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
}	

	
	
	$req_seance->execute(array(':current_day'=>$current_day));
	$res_seances=$req_seance->fetchAll();
	


	
	
	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['duree_de_la_seance'],-strlen($res_seance['duree_de_la_seance']),strlen($res_seance['duree_de_la_seance'])-2)+substr($res_seance['duree_de_la_seance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['duree_de_la_seance'],-strlen($res_seance['duree_de_la_seance']),strlen($res_seance['duree_de_la_seance'])-2)+substr($res_seance['duree_de_la_seance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		if ($horizon==1)
		{
		// On calcule les coordonnées du rectangle :
		$leftx = round($leftwidth + ($largeur - $leftwidth) / $days * $day); // Coté gauche
		$rightx = round($leftwidth + ($largeur - $leftwidth) / $days * ($day + 1)); // Coté droit
		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche
}
elseif ($horizon==0)
{
		$topy = round($topheight + ($hauteur - $topheight) / $days * $day   ); 

		$bottomy = round($topheight + ($hauteur - $topheight) / $days * ($day + 1)); 

		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 

		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
		}
elseif ($horizon==3)
{
		$topy = round($topheight ); 

		$bottomy = round($topheight + ($hauteur - $topheight) / 5 ); 

		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 

		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 

		}
		
elseif ($horizon==2 ||  $horizon==4)
{
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

		
if ($horizon==2)
{

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)/5)) +($numsemaine-1)*round(($hauteur-$topheight)/5); 
		
		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)/5)) +($numsemaine-1)*round(($hauteur-$topheight)/5); 

		$leftx = $leftwidth +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 
}
elseif ($horizon==4)
{


		$topy = $numsemaine*$topheight +$start_time*(round((6*$hauteur-$topheight)/5)) +($numsemaine-1)*round((6*$hauteur-$topheight)/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round((6*$hauteur-$topheight)/5)) +($numsemaine-1)*round((6*$hauteur-$topheight)/5); 

		$leftx = $leftwidth +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 
}		
		
}		
		

//creation du lien pour accéder au détail du module		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module_etudiant.php?&lar=".$lar."&hau=".$hau."&current_week=".$current_week."&current_year=".$current_year;
			

		$lien.=	"&selec_module=".$nom_enseignement;
		$lien.="&current_student=".$current_student;
		$lien.="&horiz=".$horizon;
		$lien.="&jour=".$jour;
		$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;
		$info_bulle.='<area title="';



//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
		$cursename=explode("_",$res_seance['nom']);

	
		//on affiche le nom de la seance

		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$nom_de_la_seance." - ";


//affichage du type (CM TD TP)

	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
			{
			$text = $res_type['alias'];
			}
		$info_bulle.=$text;

		//  On affiche les commentaires sur la seance

			$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire_seance']);

			$comm=strtoupper($comm);
			if ($comm!="")
			{
			$info_bulle.=" - ".$comm;
			}	



		//  On affiche les profs concernés
		$req_profs->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_prof=$req_profs->fetchAll();	
		if (count($res_prof)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_prof=1;
		foreach ($res_prof as $res_profs)
			{

			$info_bulle.=$res_profs['nom'];
			if(count($res_prof)>$compteur_prof)
				{
				$info_bulle.=", ";
				}
			$compteur_prof+=1;	

			}

			

		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;

			$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_etudiant);

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_etudiant=='1')
				{
				 if ($nbsalles==1)
					 {
					 $salles="Salle : ".$salles;
					 }
				  
				 if($nbsalles>1)
					 {
					 $salles="Salles : ".$salles;
					 }
				}

$info_bulle.=$salles;


$info_bulle.='" alt="seance" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';	


}
echo $info_bulle;

		}
	
}		
		echo '</map>';

	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	

 

	}

else echo "</form><br><br><br><span style=\"color:red;font-weight:bold;\">Problème lors de la sélection de l'etudiant, contactez le webmaster.</span><br>";

?>












