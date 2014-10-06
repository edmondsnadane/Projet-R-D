<?php

/**

 * Emploi du temps version profs

 *


 */

?>

<?php 
if (isset($current_prof))
	{
	$semaine_actuelle=date('W');
	$annee_actuelle=date('Y');
	}
if (!isset($_GET['hideprivate']))
	{
	$_GET['hideprivate']='0';
	}
?>



<!--[if IE]>

<form name="form" id="form" action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight">

    Semaine <input name="current_week" type="text"  class="text" value="<?php echo $current_week; ?>"> Ann&eacute;e <input class="text" name="current_year" type="text"  value="<?php echo $current_year; ?>">&nbsp;<select name="current_prof"  onchange="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight;document.form.submit();">

<?php

	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_prof=$dbh->query($sql);
	$res_prof=$req_prof->fetchAll();

foreach ($res_prof as $res)

    {

    echo '<option value="'.$res['codeProf'].'"';

    if ($res['codeProf']==$current_prof)

        echo " SELECTED";

    echo '>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option>

    ';

    }

?>



    </select> &nbsp;&nbsp;

	<input type="hidden" name="lar" id="screen_widt" value="">

	<input type="hidden" name="hau" id="screen_heigh" value="">



	<input name="" type="submit"  value="Envoyer">

</form><br>



	

	

<![endif]-->







<!--[if !IE]>-->

<form name="form" id="form" action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight">



	Semaine  <input name="current_week" type="text"  class="text" value="<?php echo $current_week; ?>">Ann&eacute;e <input class="text"  name="current_year" type="text" value="<?php echo $current_year; ?>"><br><select name="current_prof"   onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">





<?php
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_profbis=$dbh->query($sql);
	$res_prof=$req_profbis->fetchAll();

foreach ($res_prof as $res)

    {

    echo '<option value="'.$res['codeProf'].'"';

    if ($res['codeProf']==$current_prof)

        echo " SELECTED";

    echo '>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option>

    ';

    }

?>



    </select> &nbsp;&nbsp;

	<input type="hidden" name="lar" id="screen_widt" value="">

	<input type="hidden" name="hau" id="screen_heigh" value="">



	<input name="" type="submit"   value="Envoyer">

</form><br>

	



	

<![endif]-->





	



<?php 
	function premierlundi($semaine,$annee)
{
$jour=date("w",mktime(0,0,0,1,1,$annee));
if($jour==0){$jour=7;}
if($jour>4){$premieran=0;}else{$premieran=-1;}
$newdate=mktime(0,0,0,1,(($semaine+$premieran)*7),$annee); 
$jsem=date("w",$newdate);
return $newdate=mktime(0,0,0,1,(($semaine+$premieran)*7)+(1-$jsem),$annee); 
}

// Appel de la fonction
		$nextdate=premierlundi($current_week+1,$current_year);
		$previousdate=premierlundi($current_week-1,$current_year);








if (isset($current_prof) && $current_prof!="")

	{








	echo '<a href="index.php?disconnect=true" style="color:red;">&raquo; Se deconnecter &laquo;</a><br>';

?>

	 

<!--[if IE]>





<?php if (isset($current_prof) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ))

	{

?>	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid').value=document.documentElement.clientWidth;document.getElementById('screen_heig').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wid" value="">

	<input type="hidden" name="hau" id="screen_heig" value="">

	<input type="hidden" name="hideprivate"  <?php if ($_GET['hideprivate']=='1') echo 'value="1" checked'; else echo 'value="0"'; ?> >

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_prof" value="<?php echo $current_prof ?>">



<input name="" type="submit"  value="Retour à la semaine actuelle"></form>	<br>

<?php

	}

?>	

	

<![endif]-->







<!--[if !IE]>-->



	

<?php if (isset($current_prof) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ))

	{

?>	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wid').value=window.innerWidth;document.getElementById('screen_heig').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wid" value="">

	<input type="hidden" name="hau" id="screen_heig" value="">

	<input type="hidden" name="hideprivate"  <?php if ($_GET['hideprivate']=='1') echo 'value="1" checked'; else echo 'value="0"'; ?> >

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">

	<input type="hidden" name="current_prof" value="<?php echo $current_prof ?>">

	

<input name="" type="submit"  value="Retour à la semaine actuelle"></form>	<br>

<?php

	}

?>

	

<![endif]-->	 

	 

<?php	 
 

	 echo '<img alt="" src="vue_prof_smartphone.php?current_year='.$current_year.'&current_prof='.$current_prof.'&current_week='.$current_week.'&hideprivate='.$_GET['hideprivate'].'&lar='.$lar.'&hau='.$hau.'"  style="text-decoration: none; border: none;" USEMAP="#plan">';

	

	}

else echo '</form><a href="index.php?disconnect=true" style="color:red;">&raquo; Se deconnecter &laquo;</a><br><br><span style="color:red;font-weight:bold;">Veuillez choisir un prof dans la liste déroulante.</span>';

?>

<div/>