<?php



/**

 * Emploi du temps version etudiants

 *


 */



?>

<?php if (isset($current_student) )
	{
	$semaine_actuelle=date('W');
	$annee_actuelle=date('Y');
	}
?>



<!--[if IE]>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight">

    Semaine : <input name="current_week" type="text" class="text" value="<?php echo $current_week; ?>"> Ann&eacute;e : <input class="text" name="current_year" type="text" value="<?php echo $current_year; ?>">



	<input type="hidden" name="lar" id="screen_widt" value="">

	<input type="hidden" name="hau" id="screen_heigh" value="">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Envoyer"></form><br>



<![endif]-->



<!--[if !IE]>-->

<form action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight">

    Semaine : <input name="current_week" type="text" class="text" value="<?php echo $current_week; ?>"> Ann&eacute;e : <input class="text" name="current_year" type="text" value="<?php echo $current_year; ?>">

	<input type="hidden" name="lar" id="screen_widt" value="">

	<input type="hidden" name="hau" id="screen_heigh" value="">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit"  value="Envoyer"></form><br>



<![endif]-->







<?php 

if (isset($current_student))

	{





	function premierlundi($semaine,$annee)

{

$jour=date("w",mktime(0,0,0,1,1,$annee));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}



$newdate=mktime(0,0,0,1,(($semaine+$premieran)*7),$annee); 

$jsem=date("w",$newdate);



return $newdate=mktime(0,0,0,1,(($semaine+$premieran)*7)+(1-$jsem),$annee); 

}








		$nextdate=premierlundi($current_week+1,$current_year);

		$previousdate=premierlundi($current_week-1,$current_year);


	

	echo '<a href="index.php?disconnect=true" style="color:red;">&raquo; Se deconnecter &laquo;</a><br>';

	

?>	

	<!--[if IE]>

<?php 

if (isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) 

	{

	?>	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid').value=document.documentElement.clientWidth;document.getElementById('screen_heig').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wid" value="">

	<input type="hidden" name="hau" id="screen_heig" value="">

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}

?>





<![endif]-->



<!--[if !IE]>-->



<?php if (isset($current_student) && $semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) 

	{

	?>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid').value=window.innerWidth;document.getElementById('screen_heig').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wid" value="">

	<input type="hidden" name="hau" id="screen_heig" value="">

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}

?>

<![endif]-->

	

	

	

	

	

	<?php

		echo '<img alt=""  src="vue_etudiant_smartphone.php?current_year='.$current_year.'&current_student='.$current_student.'&current_week='.$current_week.'&lar='.$lar.'&hau='.$hau.'"  style="text-decoration: none; border: none;" USEMAP="#plan">';

	

	

	

 

	}

else echo "</form><br><br><br><span style=\"color:red;font-weight:bold;\">Problème lors de la sélection de l'etudiant, contactez le webmaster.</span><br><a href=\"index.php?disconnect=true\" style=\"color:red;\">&raquo; Se deconnecter &laquo;</a>";

?>












