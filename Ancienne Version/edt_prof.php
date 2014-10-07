<?php

/**

 * Emploi du temps version prof

 *

 

 */
 //initialisation de variables
 if (!isset($_GET['hideprivate']))
	{
	$_GET['hideprivate']='0';
	$hideprivate='0';
	}
else 
	{
	$hideprivate=$_GET['hideprivate'];
	}
	
 if (!isset($_GET['hideprobleme']))
	{
	$_GET['hideprobleme']='0';
	$hideprobleme='0';
	}
else 
	{
	$hideprobleme=$_GET['hideprobleme'];
	}

 if (!isset($truc))
	{
	$truc='0';
	}

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}	
	
	
$seance_clicable_area="";
include ('menu_principal.php');




if (isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi']))

	{
    $semaine_actuelle=date('W');
	$annee_actuelle=date('Y');
	}

	
	
	//recherche du nom du mois qui est affiché dans la vue mensuelle
	//methode : on cherche la date du premier lundi du mois qui est affiché et on ajoute 2 semaines
if ($horizon=='2' || $horizon=='4' )
{


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


//initialisations de variable
if (!isset($selec_groupe))
{

$selec_groupe="";
}

if (!isset($selec_prof))
{

$selec_prof="";
}

if (!isset($selec_salle))
{

$selec_salle="";
}
if (!isset($selec_materiel))
{

$selec_materiel="";
}


?>







<!--[if IE]>





<div style="height:75px;width:1015px;margin-left:auto;margin-right:auto;">	
<form name="form" id="form" action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight">

<div style="float:left;width:120px;text-align:left;"   >


<?php
if ($horizon=="3")
{
?>
	<input type="hidden" name="current_week" id="current_week" value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>">



<?php
}

?>
</div>

<div style="float:left;text-align:left;margin-left: 6px;"   >
Groupes : 

	<select name="selec_groupe"  class="groupe"  onchange="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight;document.form.submit();">


	<?php
if (isset($_GET['selec_groupe']))
	{
	$selec_groupe=$_GET['selec_groupe'];
	}


if ($filtrage_groupe==0)
{
$sql="SELECT * FROM niveaux WHERE deleted='0' and typeElement='1' order by nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";
}
else
{
$sql="SELECT * FROM diplomes WHERE deleted='0' order by nom";
}

$req_departementbis2=$dbh->query($sql);
$res_departementbis=$req_departementbis2->fetchAll();
 echo '<option value="TOUS"';
    if ($selec_groupe=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_departementbis as $res)

    {
if ($filtrage_groupe==0)
	{
	echo '<option value="'.$res['codeNiveau'].'"';
	if ($res['codeNiveau']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
elseif ($filtrage_groupe==1)
	{
	echo '<option value="'.$res['codeComposante'].'"';
	if ($res['codeComposante']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
else
	{
	echo '<option value="'.$res['codeDiplome'].'"';
	if ($res['codeDiplome']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
 


    echo '>'.$res['nom'].'</option>';

    }

?>
    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	

	

	<select name="groupes_multi[]" class="groupe"  multiple="multiple" size="5"  >

<?php
if ($selec_groupe!="TOUS" && $selec_groupe!="")
{
if ($filtrage_groupe==0)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeComposante=:selec_groupe  ORDER BY nom";
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeDiplome=:selec_groupe  ORDER BY nom";
}
//$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
$req_groupebis2=$dbh->prepare($sql);
$req_groupebis2->execute(array(':selec_groupe'=>$selec_groupe));
$res_groupebis=$req_groupebis2->fetchAll();
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' ORDER BY nom";
$req_groupebis3=$dbh->query($sql);
$res_groupebis=$req_groupebis3->fetchAll();
}
foreach ($res_groupebis as $res)

    {

//recuperation de la couleur associee au groupe et conversion en rvb

$dechex=dechex($res['couleurFond']);

while (strlen($dechex)<6) 
	{
	$dechex = "0".$dechex;
	}
	
$couleur =  substr($dechex,-2,2). substr($dechex,-4,2).substr($dechex,-6,2);		
	
	
    echo '<option style="background-color:#'.$couleur.';" value="'.$res['codeGroupe'].'" ';

 

	 	 for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		if ($res['codeGroupe']==$groupes_multi[$i] )

        echo " SELECTED";

		}	
$nom_grp= substr($res['nom'],0,22);
    echo '>'.$nom_grp.'</option> ';


    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne un groupe gmp puis je choisis ensuite de trier la liste avec geii et le prof gmp disparait donc ceux qui ont été sélectonnés sont écrits en bas de liste

if ($selec_groupe!="TOUS" && $selec_groupe!="")
	{
	if ($filtrage_groupe==0)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeComposante=:selec_groupe  ORDER BY nom";
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeDiplome=:selec_groupe  ORDER BY nom";
}
	//$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
	$req_groupe2bis=$dbh->prepare($sql);
	$req_groupe2bis->execute(array(':selec_groupe'=>$selec_groupe));
	$res_groupe2bis=$req_groupe2bis->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' ORDER BY nom";
	$req_groupe2bis=$dbh->query($sql);
	$res_groupe2bis=$req_groupe2bis->fetchAll();
	}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:groupe ";
	$req_groupe3bis=$dbh->prepare($sql);

for ($m=0; $m<count($groupes_multi); $m++)
    {

	foreach ($res_groupe2bis as $res)
		{ 
		if ($res['codeGroupe']==$groupes_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$groupe=$groupes_multi[$m];
	$req_groupe3bis->execute(array(':groupe'=>$groupe));
	$res_groupe3bis=$req_groupe3bis->fetchAll();
		foreach ($res_groupe3bis as $res)
		{
		$dechex=dechex($res['couleurFond']);
		while (strlen($dechex)<6) 
			{
			$dechex = "0".$dechex;
			}
		$couleur =  substr($dechex,-2,2). substr($dechex,-4,2).substr($dechex,-6,2);	

$nom_grp= substr($res['nom'],0,22);
 	
		echo '<option style="background-color:#'.$couleur.';" value="'.$groupe.'"  SELECTED>'.$nom_grp.'</option> ';
		}
		}
	$dejadansliste='non';
	}
	
	
	

?>



    </select>

</div>


<div style="float:left;text-align:left;margin-left: 6px;"   >
	

Profs : 
		<select name="selec_prof"  class="prof" onchange="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight;document.form.submit();">


<?php
if (isset($_GET['selec_prof']))
	{
	$selec_prof=$_GET['selec_prof'];
	}
//$sql="SELECT distinct (affectation)  FROM ressources_profs WHERE deleted='0' order by affectation ";

$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";




$req_affectationbis=$dbh->query($sql);
$res_affectationbis=$req_affectationbis->fetchAll();
 echo '<option value="TOUS"';
    if ($selec_prof=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_affectationbis as $res)

    {


	 echo '<option value="'.$res['codeComposante'].'"';
    if ($res['codeComposante']==$selec_prof)
{
        echo " SELECTED";
}
echo '>'.$res['nom'].'</option>';
	
	
   

   

    }

?>
    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
	<select name="profs_multi[]" class="prof" multiple="multiple" size="5"  >

<?php
if ($selec_prof!="TOUS" && $selec_prof!="")
	{
	//$sql="SELECT * FROM ressources_profs WHERE deleted='0' and affectation=:selec_prof  ORDER BY nom,prenom";

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeComposante=:selec_prof  ORDER BY nom,prenom";


	
	$req_profbis=$dbh->prepare($sql);
	$req_profbis->execute(array(':selec_prof'=>$selec_prof));
	$res_profbis=$req_profbis->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_profbis=$dbh->query($sql);
	$res_profbis=$req_profbis->fetchAll();
	}


foreach ($res_profbis as $res)

    {

    echo '<option value="'.$res['codeProf'].'"';

 

	 	 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		if ($res['codeProf']==$profs_multi[$i])

        echo " SELECTED";

		}	

		if ($res['codeProf']==$current_prof)

		{

        echo " SELECTED";

		}

	echo '>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option>

    ';

    }
	
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne un prof gmp puis je choisis ensuite de trier la liste avec geii et le prof gmp disparait donc ceux qui ont été sélectonnés sont écrits en bas de liste

if ($selec_prof!="TOUS" && $selec_prof!="")
	{
	//$sql="SELECT * FROM ressources_profs WHERE deleted='0' and affectation=:selec_prof  ORDER BY nom,prenom";

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeComposante=:selec_prof  ORDER BY nom";


	$req_prof2bis=$dbh->prepare($sql);
	$req_prof2bis->execute(array(':selec_prof'=>$selec_prof));
	$res_prof2bis=$req_prof2bis->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_prof2bis=$dbh->query($sql);
	$res_prof2bis=$req_prof2bis->fetchAll();
	}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:prof ";
	$req_prof3bis=$dbh->prepare($sql);	
	
//si on vient juste de se logguer (truc==1) on dit que $profs_multi[0] est egal au code du prof qui vient de se logguer pour que sont edt apparaisse même si le filtre qui a été sauvegardé dans la base ne correspond pas à son département
if ($truc=='1')
{
$profs_multi['0']=$res_login_prof_perso['0']['codeProf'];


}	
	
	
	
for ($m=0; $m<count($profs_multi); $m++)
    {
	foreach ($res_prof2bis as $res)
		{ 
		if ($res['codeProf']==$profs_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		
		$prof=$profs_multi[$m];
		$req_prof3bis->execute(array(':prof'=>$prof));
		$res_prof3bis=$req_prof3bis->fetchAll();
		foreach ($res_prof3bis as $res)
		{
			
		echo '<option value="'.$prof.'"  SELECTED>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option> ';
		}
		}
	$dejadansliste='non';
	}	
		
 
	 
?>	 

    </select>	

	</div>
<div style="float:left;text-align:left;margin-left: 6px;"   >
	

Salles : 
	<select name="selec_salle"  class="salle" onchange="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight;document.form.submit();">


<?php
if (isset($_GET['selec_salle']))
	{
	$selec_salle=$_GET['selec_salle'];
	}
//$sql= "SELECT distinct (ressources_salles.codeZoneSalle), zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE ressources_salles.deleted='0' AND zones_salles.deleted='0' order by zones_salles.nom";	
if ($filtrage_salle==0)
{
$sql= "SELECT distinct (ressources_salles.codeZoneSalle), zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE ressources_salles.deleted='0' AND zones_salles.deleted='0' order by zones_salles.nom";	
}
else
{
$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";
}
$req_sallebis=$dbh->query($sql);
$res_sallebis=$req_sallebis->fetchAll();

 echo '<option value="TOUS"';
    if ($selec_salle=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_sallebis as $res)

    {
if ($filtrage_salle==0)
	{
	 echo '<option value="'.$res['nom_zone'].'"';
    if ($res['nom_zone']==$selec_salle)
{
        echo " SELECTED";
}
 echo '>'.$res['nom_zone'].'</option>';
	}
else
	{
	echo '<option value="'.$res['codeComposante'].'"';
	if ($res['codeComposante']==$selec_salle)
		{
		echo " SELECTED";
		}
		 echo '>'.$res['nom'].'</option>';
	}
	
	
   

   

    }

?>

    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	
	<select name="salles_multi[]" class="salle" multiple="multiple" size="5"  >

<?php
if ($selec_salle!="TOUS" && $selec_salle!="")
{
//$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
if ($filtrage_salle==0)
{
$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0' and codeComposante=:selec_salle  ORDER BY nom";
}
$req_salle2bis=$dbh->prepare($sql);
$req_salle2bis->execute(array(':selec_salle'=>$selec_salle));
$res_salle2bis=$req_salle2bis->fetchAll();
}
else
{
if ($filtrage_salle==0)
{
$sql="SELECT *,  zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE  ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0'   ORDER BY nom";
}




$req_salle2bis=$dbh->query($sql);
$res_salle2bis=$req_salle2bis->fetchAll();
}

foreach ($res_salle2bis as $res)

    {

	
	
	
    echo '<option value="'.$res['codeSalle'].'" ';

 

	 	 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		if ($res['codeSalle']==$salles_multi[$i] )

        echo " SELECTED";

		}	

		
		
		if ($res['commentaire_salle']=="")
			{
			echo '>'.$res['nom_salle'].'</option> ';
			}
		else
			{
			echo '>'.$res['nom_salle']."  (".$res['commentaire_salle'].")".'</option> ';
			}
		
  

    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne une salle gmp puis je choisis ensuite de trier la liste avec geii et la salle gmp disparait donc celles qui ont été sélectonnées sont écrites en bas de liste

if ($selec_salle!="TOUS" && $selec_salle!="")
{
	//$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
		if ($filtrage_salle==0)
{
$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0' and codeComposante=:selec_salle  ORDER BY nom";
}
	$req_salle3bis=$dbh->prepare($sql);
	$req_salle3bis->execute(array(':selec_salle'=>$selec_salle));
	$res_salle3bis=$req_salle3bis->fetchAll();
}
else
{

		if ($filtrage_salle==0)
{
$sql="SELECT *,  zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle    FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE  ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0'   ORDER BY nom";
}




	
	$req_salle3bis=$dbh->query($sql);
	$res_salle3bis=$req_salle3bis->fetchAll();
}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_salles WHERE deleted='0' and codeSalle=:salle ";
	$req_salle4bis=$dbh->prepare($sql);

for ($m=0; $m<count($salles_multi); $m++)
    {

	foreach ($res_salle3bis as $res)
		{ 
		if ($res['codeSalle']==$salles_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$salle=$salles_multi[$m];
		
		$req_salle4bis->execute(array(':salle'=>$salle));
		$res_salle4bis=$req_salle4bis->fetchAll();
		foreach ($res_salle4bis as $res)
{	

		if ($res['commentaire']=="")
			{
			echo '<option  value="'.$salle.'"  SELECTED>'.$res['nom'].'</option> ';
			}
		else
			{
			echo '<option  value="'.$salle.'"  SELECTED>'.$res['nom']."  (".$res['commentaire'].")".'</option> ';
			}
}		
		}
		
	$dejadansliste='non';
	}
	
	
	
?>



    </select>	
</div>


<div style="float:left;text-align:left;margin-left: 6px;"   >
	

Materiels : 
	<select name="selec_materiel"  class="materiel" onchange="document.getElementById('screen_widt').value=document.documentElement.clientWidth;document.getElementById('screen_heigh').value=document.documentElement.clientHeight;document.form.submit();">


<?php
if (isset($_GET['selec_materiel']))
	{
	$selec_materiel=$_GET['selec_materiel'];
	}
$sql= "SELECT distinct (ressources_materiels.codeComposante), composantes.nom AS nom_composante,composantes.codeComposante AS code_Composante   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE ressources_materiels.deleted='0' AND composantes.deleted='0' order by composantes.nom";	
$req_materiel=$dbh->query($sql);
$res_materiel=$req_materiel->fetchAll();

 echo '<option value="TOUS"';
    if ($selec_materiel=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
foreach ($res_materiel as $res)


    {

    echo '<option value="'.$res['nom_composante'].'"';
    if ($res['nom_composante']==$selec_materiel)

        echo " SELECTED";


    echo '>'.$res['nom_composante'].'</option>';

    }

?>
     </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	
	<select name="materiels_multi[]" class="materiel" multiple="multiple" size="5"  >

<?php
if ($selec_materiel!="TOUS" && $selec_materiel!="")
{
$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel, ressources_materiels.commentaire AS commentaire_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE composantes.nom=:selec_materiel and ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
$req_materiel2=$dbh->prepare($sql);
$req_materiel2->execute(array(':selec_materiel'=>$selec_materiel));
$res_materiel2=$req_materiel2->fetchAll();
}
else
{
$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel, ressources_materiels.commentaire AS commentaire_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE  ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
$req_materiel2=$dbh->query($sql);
$res_materiel2=$req_materiel2->fetchAll();
}


foreach ($res_materiel2 as $res)


    {

    echo '<option value="'.$res['codeMateriel'].'" ';

	 	 for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		if ($res['codeMateriel']==$materiels_multi[$i] )
        echo " SELECTED";
		}	
		
		if ($res['commentaire_materiel']=="")
			{
			echo '>'.$res['nom_materiel'].'</option> ';
			}
		else
			{
			echo '>'.$res['nom_materiel']."  (".$res['commentaire_materiel'].")".'</option> ';
			}
 
    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne une salle gmp puis je choisis ensuite de trier la liste avec geii et la salle gmp disparait donc celles qui ont été sélectonnées sont écrites en bas de liste

if ($selec_materiel!="TOUS" && $selec_materiel!="")
{
	$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE composantes.nom=:selec_materiel and ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
	$req_materiel3=$dbh->prepare($sql);
	$req_materiel3->execute(array(':selec_materiel'=>$selec_materiel));
	$res_materiel3=$req_materiel3->fetchAll();
}
else
{
	$sql="SELECT *,  composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel  FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE  ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
	$req_materiel3=$dbh->query($sql);
	$res_materiel3=$req_materiel3->fetchAll();
}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_materiels WHERE deleted='0' and codeMateriel=:materiel ";
	$req_materiel4=$dbh->prepare($sql);
for ($m=0; $m<count($materiels_multi); $m++)
    {
	foreach ($res_materiel3 as $res)
		{ 
		if ($res['codeMateriel']==$materiels_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$materiel=$materiels_multi[$m];
		
		$req_materiel4->execute(array(':materiel'=>$materiel));
		$res_materiel4=$req_materiel4->fetchAll();
		foreach ($res_materiel4 as $res)
{	
	
		if ($res['commentaire']=="")
			{
			echo '<option  value="'.$materiel.'"  SELECTED>'.$res['nom'].'</option> ';
			}
		else
			{
			echo '<option  value="'.$materiel.'"  SELECTED>'.$res['nom']."  (".$res['commentaire'].")".'</option> ';
			}
	
	
	
}		
		}
		
	$dejadansliste='non';
	}
	
	
	
?>



    </select>	
</div>












<div style="float:left;text-align:left;margin-left: 6px;"   >
<br>
<?php
//ajoute un saut de ligne quand on utilise le login générique pour que le bouton envoyer soit une ligne en dessous
 if (!isset($_SESSION['logged_prof_perso']))
{
echo "<br>";
}
?>
<input name="" type="submit" value="Envoyer"><br>

<?php

if (isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi']))

{

?>

 <input type="button" value="Tout désélectionner" onclick="window.location='index.php?current_year=<?php echo $current_year; ?>&horiz=<?php echo $horizon; ?>&current_week=<?php echo $current_week; ?>&lar=<?php echo $_GET['lar']; ?>&hau=<?php echo $_GET['hau']; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?> &selec_materiel=<?php echo $selec_materiel; ?>     '" /><br>


<?php

 }

 
 //affichage bouton mon planning
 if (isset($_SESSION['logged_prof_perso']) && $_SESSION['logged_prof_perso']!='3003781' && $_SESSION['logged_prof_perso']!='3003775' )
{
$dans_liste=0;
 	 	 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])

        $dans_liste=1;

		}
if ($dans_liste=='0' || isset($_GET['salles_multi']) || count($profs_multi)>1 || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi']))
{
?>

 <input type="button" value="Mon planning" onclick="window.location='index.php?current_year=<?php echo $current_year; ?>&horiz=<?php echo $horizon; ?>&current_week=<?php echo $current_week; ?>&lar=<?php echo $_GET['lar']; ?>&hau=<?php echo $_GET['hau']; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>&profs_multi[]=<?php echo $_SESSION['logged_prof_perso']; ?>      '" />


<?php
}		
 }
 
 
 
 ?>








<input type="hidden" name="lar" id="screen_widt" value="">

<input type="hidden" name="hau" id="screen_heigh" value="">
<?php
if (isset($_GET['jour']))
{
?>
<input type="hidden" name="jour" id="jourj" value="<?php echo $_GET['jour']; ?>">
<?php
}
?>

</div>
 </div><br>
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





 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Masquer les RDV<input type="checkbox" name="hideprivate" value="1" <?php if ($_GET['hideprivate']=='1') echo "checked"; ?> >
 &nbsp;&nbsp; Masquer les problèmes<input type="checkbox" name="hideprobleme" value="1" <?php if ($_GET['hideprobleme']=='1') echo "checked"; ?> >

<br>












<![endif]-->



<!--[if !IE]>-->

<div style="height:85px;width:1015px;margin-left:auto;margin-right:auto;">	

<form name="form" id="form" action="index.php" method="get" onsubmit="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight">


<div style="float:left;text-align:left;"   >

<?php
if ($horizon=="3")
{
?>
	<input type="hidden" name="current_week" id="current_week" value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year" id="current_year" value="<?php echo $current_year; ?>">

<?php
}

?>



   
	
</div>	
	
	
<div style="float:left;text-align:left;margin-left: 6px;"   >	
Groupes : 

	
	<select name="selec_groupe"  class="groupe" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">


<?php
if (isset($_GET['selec_groupe']))
	{
	$selec_groupe=$_GET['selec_groupe'];
	}


if ($filtrage_groupe==0)
{
$sql="SELECT * FROM niveaux WHERE deleted='0' and typeElement='1' order by nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";
}
else
{
$sql="SELECT * FROM diplomes WHERE deleted='0' order by nom";
}

$req_departementbis3=$dbh->query($sql);
$res_departementbis=$req_departementbis3->fetchAll();
 echo '<option value="TOUS"';
    if ($selec_groupe=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_departementbis as $res)

    {
if ($filtrage_groupe==0)
	{
	echo '<option value="'.$res['codeNiveau'].'"';
	if ($res['codeNiveau']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
elseif ($filtrage_groupe==1)
	{
	echo '<option value="'.$res['codeComposante'].'"';
	if ($res['codeComposante']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
else
	{
	echo '<option value="'.$res['codeDiplome'].'"';
	if ($res['codeDiplome']==$selec_groupe)
		{
		echo " SELECTED";
		}
	}
 


    echo '>'.$res['nom'].'</option>';

    }

?>
    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	

	

	

	<select name="groupes_multi[]" class="groupe" multiple="multiple" size="5"  >

<?php
if ($selec_groupe!="TOUS" && $selec_groupe!="")
{
if ($filtrage_groupe==0)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeComposante=:selec_groupe  ORDER BY nom";
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeDiplome=:selec_groupe  ORDER BY nom";
}
//$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
$req_groupebis3=$dbh->prepare($sql);
$req_groupebis3->execute(array(':selec_groupe'=>$selec_groupe));
$res_groupebis=$req_groupebis3->fetchAll();
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' ORDER BY nom";
$req_groupebis4=$dbh->query($sql);
$res_groupebis=$req_groupebis4->fetchAll();
}
foreach ($res_groupebis as $res)

    {

//recuperation de la couleur associee au groupe et conversion en rvb

$dechex=dechex($res['couleurFond']);

while (strlen($dechex)<6) 
	{
	$dechex = "0".$dechex;
	}
	
$couleur =  substr($dechex,-2,2). substr($dechex,-4,2).substr($dechex,-6,2);		
	
	
    echo '<option style="background-color:#'.$couleur.';" value="'.$res['codeGroupe'].'" ';

 

	 	 for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		if ($res['codeGroupe']==$groupes_multi[$i] )

        echo " SELECTED";

		}	
$nom_grp= substr($res['nom'],0,22);
    echo '>'.$nom_grp.'</option> ';


    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne un groupe gmp puis je choisis ensuite de trier la liste avec geii et le prof gmp disparait donc ceux qui ont été sélectonnés sont écrits en bas de liste

if ($selec_groupe!="TOUS" && $selec_groupe!="")
	{
	if ($filtrage_groupe==0)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
}
elseif ($filtrage_groupe==1)
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeComposante=:selec_groupe  ORDER BY nom";
}
else
{
$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeDiplome=:selec_groupe  ORDER BY nom";
}
	//$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeNiveau=:selec_groupe  ORDER BY nom";
	$req_groupe3bis=$dbh->prepare($sql);
	$req_groupe3bis->execute(array(':selec_groupe'=>$selec_groupe));
	$res_groupe2bis=$req_groupe3bis->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' ORDER BY nom";
	$req_groupe3bis=$dbh->query($sql);
	$res_groupe2bis=$req_groupe3bis->fetchAll();
	}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:groupe ";
	$req_groupe4bis=$dbh->prepare($sql);

for ($m=0; $m<count($groupes_multi); $m++)
    {

	foreach ($res_groupe2bis as $res)
		{ 
		if ($res['codeGroupe']==$groupes_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$groupe=$groupes_multi[$m];
	$req_groupe4bis->execute(array(':groupe'=>$groupe));
	$res_groupe3bis=$req_groupe4bis->fetchAll();
		foreach ($res_groupe3bis as $res)
		{
		$dechex=dechex($res['couleurFond']);
		while (strlen($dechex)<6) 
			{
			$dechex = "0".$dechex;
			}
		$couleur =  substr($dechex,-2,2). substr($dechex,-4,2).substr($dechex,-6,2);	

$nom_grp= substr($res['nom'],0,22);
 	
		echo '<option style="background-color:#'.$couleur.';" value="'.$groupe.'"  SELECTED>'.$nom_grp.'</option> ';
		}
		}
	$dejadansliste='non';
	}
	
	
	
?>



    </select>	
</div>
	

	


<div style="float:left;text-align:left;margin-left: 6px;"   >
Profs :	

	<select name="selec_prof"  class="prof" onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">


<?php
if (isset($_GET['selec_prof']))
	{
	$selec_prof=$_GET['selec_prof'];
	}


$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";




$req_affectationbis2=$dbh->query($sql);
$res_affectationbis=$req_affectationbis2->fetchAll();
 echo '<option value="TOUS"';
    if ($selec_prof=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_affectationbis as $res)

    {

	 echo '<option value="'.$res['codeComposante'].'"';
    if ($res['codeComposante']==$selec_prof)
{
        echo " SELECTED";
}
echo '>'.$res['nom'].'</option>';
	
	
   

   

    }

?>
    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;





<select name="profs_multi[]" class="prof" multiple="multiple" size="5"  >





<?php
if ($selec_prof!="TOUS" && $selec_prof!="")
	{
	//$sql="SELECT * FROM ressources_profs WHERE deleted='0' and affectation=:selec_prof  ORDER BY nom,prenom";

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeComposante=:selec_prof  ORDER BY nom";


	
	$req_profbis2=$dbh->prepare($sql);
	$req_profbis2->execute(array(':selec_prof'=>$selec_prof));
	$res_profbis=$req_profbis2->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_profbis2=$dbh->query($sql);
	$res_profbis=$req_profbis2->fetchAll();
	}


foreach ($res_profbis as $res)

    {

    echo '<option value="'.$res['codeProf'].'"';

 

	 	 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		if ($res['codeProf']==$profs_multi[$i])

        echo " SELECTED";

		}	

		if ($res['codeProf']==$current_prof)

		{

        echo " SELECTED";

		}

	echo '>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option>

    ';

    }
	
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne un prof gmp puis je choisis ensuite de trier la liste avec geii et le prof gmp disparait donc ceux qui ont été sélectonnés sont écrits en bas de liste

if ($selec_prof!="TOUS" && $selec_prof!="")
	{
	

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeComposante=:selec_prof  ORDER BY nom";


	$req_prof7bis=$dbh->prepare($sql);
	$req_prof7bis->execute(array(':selec_prof'=>$selec_prof));
	$res_prof2bis=$req_prof7bis->fetchAll();
	}
else
	{
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' ORDER BY nom,prenom";
	$req_prof7bis=$dbh->query($sql);
	$res_prof2bis=$req_prof7bis->fetchAll();
	}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:prof ";
	$req_prof4bis=$dbh->prepare($sql);	
	
//si on vient juste de se logguer (truc==1) on dit que $profs_multi[0] est egal au code du prof qui vient de se logguer pour que sont edt apparaisse même si le filtre qui a été sauvegardé dans la base ne correspond pas à son département
if ($truc=='1')
{
$profs_multi['0']=$res_login_prof_perso['0']['codeProf'];


}	
	
	
	
for ($m=0; $m<count($profs_multi); $m++)
    {
	foreach ($res_prof2bis as $res)
		{ 
		if ($res['codeProf']==$profs_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		
		$prof=$profs_multi[$m];
		$req_prof4bis->execute(array(':prof'=>$prof));
		$res_prof3bis=$req_prof4bis->fetchAll();
		foreach ($res_prof3bis as $res)
		{
			
		echo '<option value="'.$prof.'"  SELECTED>'.$res['nom'].' '.ucfirst(strtolower($res['prenom'])).'</option> ';
		}
		}
	$dejadansliste='non';
	}	

	
?>


    </select>		
</div>
	
<div style="float:left;text-align:left;margin-left: 6px;"   >
Salles : 
	<select name="selec_salle" class="salle"  onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">


<?php
if (isset($_GET['selec_salle']))
	{
	$selec_salle=$_GET['selec_salle'];
	}

if ($filtrage_salle==0)
{
$sql= "SELECT distinct (ressources_salles.codeZoneSalle), zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE ressources_salles.deleted='0' AND zones_salles.deleted='0' order by zones_salles.nom";	
}
else
{
$sql="SELECT * FROM composantes WHERE deleted='0' order by nom";
}
$req_sallebis2=$dbh->query($sql);
$res_sallebis=$req_sallebis2->fetchAll();

 echo '<option value="TOUS"';
    if ($selec_salle=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
 
foreach ($res_sallebis as $res)

    {
if ($filtrage_salle==0)
	{
	 echo '<option value="'.$res['nom_zone'].'"';
    if ($res['nom_zone']==$selec_salle)
{
        echo " SELECTED";
}
 echo '>'.$res['nom_zone'].'</option>';
	}
else
	{
	echo '<option value="'.$res['codeComposante'].'"';
	if ($res['codeComposante']==$selec_salle)
		{
		echo " SELECTED";
		}
		 echo '>'.$res['nom'].'</option>';
	}
	
	
   

   

    }

?>

    </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	
	<select name="salles_multi[]" class="salle" multiple="multiple" size="5"  >

<?php
if ($selec_salle!="TOUS" && $selec_salle!="")
{

if ($filtrage_salle==0)
{
$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0' and codeComposante=:selec_salle  ORDER BY nom";
}
$req_salle8bis=$dbh->prepare($sql);
$req_salle8bis->execute(array(':selec_salle'=>$selec_salle));
$res_salle2bis=$req_salle8bis->fetchAll();
}
else
{
if ($filtrage_salle==0)
{
$sql="SELECT *,  zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE  ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0'   ORDER BY nom";
}




$req_salle8bis=$dbh->query($sql);
$res_salle2bis=$req_salle8bis->fetchAll();
}

foreach ($res_salle2bis as $res)

    {

	
	
	
    echo '<option value="'.$res['codeSalle'].'" ';

 

	 	 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		if ($res['codeSalle']==$salles_multi[$i] )

        echo " SELECTED";

		}	

		
		
		if ($res['commentaire_salle']=="")
			{
			echo '>'.$res['nom_salle'].'</option> ';
			}
		else
			{
			echo '>'.$res['nom_salle']."  (".$res['commentaire_salle'].")".'</option> ';
			}
		
  

    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne une salle gmp puis je choisis ensuite de trier la liste avec geii et la salle gmp disparait donc celles qui ont été sélectonnées sont écrites en bas de liste

if ($selec_salle!="TOUS" && $selec_salle!="")
{
	
		if ($filtrage_salle==0)
{
$sql="SELECT *, zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle   FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE zones_salles.nom=:selec_salle and ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0' and codeComposante=:selec_salle  ORDER BY nom";
}
	$req_salle9bis=$dbh->prepare($sql);
	$req_salle9bis->execute(array(':selec_salle'=>$selec_salle));
	$res_salle3bis=$req_salle9bis->fetchAll();
}
else
{
		if ($filtrage_salle==0)
{
$sql="SELECT *,  zones_salles.nom AS nom_zone,zones_salles.codeZoneSalle AS code_zone, ressources_salles.nom AS nom_salle    FROM ressources_salles LEFT JOIN zones_salles ON (ressources_salles.codeZoneSalle=zones_salles.codeZoneSalle) WHERE  ressources_salles.deleted='0' AND zones_salles.deleted='0' order by ressources_salles.nom";
}
else
{
$sql="SELECT *,  ressources_salles.nom AS nom_salle, ressources_salles.commentaire AS commentaire_salle    FROM ressources_salles WHERE deleted='0'   ORDER BY nom";
}



	
	$req_salle9bis=$dbh->query($sql);
	$res_salle3bis=$req_salle9bis->fetchAll();
}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_salles WHERE deleted='0' and codeSalle=:salle ";
	$req_salle5bis=$dbh->prepare($sql);

for ($m=0; $m<count($salles_multi); $m++)
    {

	foreach ($res_salle3bis as $res)
		{ 
		if ($res['codeSalle']==$salles_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$salle=$salles_multi[$m];
		
		$req_salle5bis->execute(array(':salle'=>$salle));
		$res_salle4bis=$req_salle5bis->fetchAll();
		foreach ($res_salle4bis as $res)
{	

		if ($res['commentaire']=="")
			{
			echo '<option  value="'.$salle.'"  SELECTED>'.$res['nom'].'</option> ';
			}
		else
			{
			echo '<option  value="'.$salle.'"  SELECTED>'.$res['nom']."  (".$res['commentaire'].")".'</option> ';
			}
}		
		}
		
	$dejadansliste='non';
	}
	
	
	
?>


    </select>		
	
	
	


</div>


	
<div style="float:left;text-align:left;margin-left: 6px;"   >
Materiels : 
	<select name="selec_materiel" class="materiel"  onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">


<?php
if (isset($_GET['selec_materiel']))
	{
	$selec_materiel=$_GET['selec_materiel'];
	}
$sql= "SELECT distinct (ressources_materiels.codeComposante), composantes.nom AS nom_composante,composantes.codeComposante AS code_Composante   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE ressources_materiels.deleted='0' AND composantes.deleted='0' order by composantes.nom";	
$req_materielbis=$dbh->query($sql);
$res_materiel=$req_materielbis->fetchAll();

 echo '<option value="TOUS"';
    if ($selec_materiel=="TOUS")
{
        echo " SELECTED";
} 
 echo '>TOUS</option>';
foreach ($res_materiel as $res)


    {

    echo '<option value="'.$res['nom_composante'].'"';
    if ($res['nom_composante']==$selec_materiel)

        echo " SELECTED";


    echo '>'.$res['nom_composante'].'</option>';

    }

?>
     </select><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	
	<select name="materiels_multi[]" class="materiel" multiple="multiple" size="5"  >

<?php
if ($selec_materiel!="TOUS" && $selec_materiel!="")
{
$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel, ressources_materiels.commentaire AS commentaire_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE composantes.nom=:selec_materiel and ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
$req_materiel2bis=$dbh->prepare($sql);
$req_materiel2bis->execute(array(':selec_materiel'=>$selec_materiel));
$res_materiel2=$req_materiel2bis->fetchAll();
}
else
{
$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel, ressources_materiels.commentaire AS commentaire_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE  ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
$req_materiel2bis=$dbh->query($sql);
$res_materiel2=$req_materiel2bis->fetchAll();
}


foreach ($res_materiel2 as $res)


    {

    echo '<option value="'.$res['codeMateriel'].'" ';

	 	 for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		if ($res['codeMateriel']==$materiels_multi[$i] )
        echo " SELECTED";
		}	
		
		if ($res['commentaire_materiel']=="")
			{
			echo '>'.$res['nom_materiel'].'</option> ';
			}
		else
			{
			echo '>'.$res['nom_materiel']."  (".$res['commentaire_materiel'].")".'</option> ';
			}
 
    }
	
	//affichage des ressources sélectionnées précedement dans une liste triée qui ne sont plus dans une autre liste.
	// exemple : je sélectionne une salle gmp puis je choisis ensuite de trier la liste avec geii et la salle gmp disparait donc celles qui ont été sélectonnées sont écrites en bas de liste

if ($selec_materiel!="TOUS" && $selec_materiel!="")
{
	$sql="SELECT *, composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel   FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE composantes.nom=:selec_materiel and ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
	$req_materiel3bis=$dbh->prepare($sql);
	$req_materiel3bis->execute(array(':selec_materiel'=>$selec_materiel));
	$res_materiel3=$req_materiel3bis->fetchAll();
}
else
{
	$sql="SELECT *,  composantes.nom AS nom_composante,composantes.codeComposante AS code_composante, ressources_materiels.nom AS nom_materiel  FROM ressources_materiels LEFT JOIN composantes ON (ressources_materiels.codeComposante=composantes.codeComposante) WHERE  ressources_materiels.deleted='0' AND composantes.deleted='0' order by ressources_materiels.nom";
	$req_materiel3bis=$dbh->query($sql);
	$res_materiel3=$req_materiel3bis->fetchAll();
	
}
//preparation requete pour les boucles suivantes
	$sql="SELECT * FROM ressources_materiels WHERE deleted='0' and codeMateriel=:materiel ";
	$req_materiel4bis=$dbh->prepare($sql);
for ($m=0; $m<count($materiels_multi); $m++)
    {
	foreach ($res_materiel3 as $res)
		{ 
		if ($res['codeMateriel']==$materiels_multi[$m] )
			{
			$dejadansliste='oui';
			}
		}
		
	unset ($req);
	unset ($res);
	
	if ($dejadansliste!='oui')
		{
		//recuperation de la couleur associee au groupe et conversion en rvb
		$materiel=$materiels_multi[$m];
		
		$req_materiel4bis->execute(array(':materiel'=>$materiel));
		$res_materiel4=$req_materiel4bis->fetchAll();
		foreach ($res_materiel4 as $res)
{	
	
		if ($res['commentaire']=="")
			{
			echo '<option  value="'.$materiel.'"  SELECTED>'.$res['nom'].'</option> ';
			}
		else
			{
			echo '<option  value="'.$materiel.'"  SELECTED>'.$res['nom']."  (".$res['commentaire'].")".'</option> ';
			}
	
	
	
}		
		}
		
	$dejadansliste='non';
	}
	
	
	
?>



    </select>	
</div>






<input type="hidden" name="lar" id="screen_widt" value="">

<input type="hidden" name="hau" id="screen_heigh" value="">



<div style="float:left;text-align:left;margin-left: 3px;"   >
<br>
<br>
<?php
//ajoute un saut de ligne quand on utilise le login générique pour que le bouton envoyer soit une ligne en dessous
 if (!isset($_SESSION['logged_prof_perso']))
{
echo "<br>";
}
?>
<input name="" type="submit" value="Envoyer"><br>

<?php

if (isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi']))

{

?>

 <input type="button" value="Tout désélectionner" onclick="window.location='index.php?current_year=<?php echo $current_year; ?>&horiz=<?php echo $horizon; ?>&current_week=<?php echo $current_week; ?>&lar=<?php echo $_GET['lar']; ?>&hau=<?php echo $_GET['hau']; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>      '" /><br>


<?php

 }

 
 //affichage bouton mon planning
 if (isset($_SESSION['logged_prof_perso']) && $_SESSION['logged_prof_perso']!='3003781' && $_SESSION['logged_prof_perso']!='3003775')
{
$dans_liste=0;
 	 	 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		if ($_SESSION['logged_prof_perso']==$profs_multi[$i])

        $dans_liste=1;

		}
if ($dans_liste=='0' || isset($_GET['salles_multi']) || count($profs_multi)>1 || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi']))
{
?>

 <input type="button" value="Mon planning" onclick="window.location='index.php?current_year=<?php echo $current_year; ?>&horiz=<?php echo $horizon; ?>&current_week=<?php echo $current_week; ?>&lar=<?php echo $_GET['lar']; ?>&hau=<?php echo $_GET['hau']; ?>&selec_prof=<?php echo $selec_prof; ?>&selec_groupe=<?php echo $selec_groupe; ?>&selec_salle=<?php echo $selec_salle; ?>&selec_materiel=<?php echo $selec_materiel; ?>&profs_multi[]=<?php echo $_SESSION['logged_prof_perso']; ?>      '" />


<?php
}		
 }


if (isset($_GET['jour']))
{
?>
<input type="hidden" name="jour" id="jourj" value="<?php echo $_GET['jour']; ?>">
<?php
}
?>
 
 

 
 

 
 

</div>

</div>
 <br> 

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

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Masquer les RDV<input type="checkbox" name="hideprivate" value="1" <?php if ($_GET['hideprivate']=='1') echo "checked"; ?> onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">
 &nbsp;&nbsp; Masquer les problèmes<input type="checkbox" name="hideprobleme" value="1" <?php if ($_GET['hideprobleme']=='1') echo "checked"; ?> onchange="document.getElementById('screen_widt').value=window.innerWidth;document.getElementById('screen_heigh').value=window.innerHeight;document.form.submit();">

<br>















<!--<![endif]-->

<?php





if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 )

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




   echo '<a href="index.php?current_year='.date("o",$jour_semaine_precedent).'&horiz='.$horizon;
}

else
{
 echo '<a href="index.php?current_year='.date("o",$previousMonth).'&horiz='.$horizon;
}
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
		
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine. Si vue jour j, on décale d'un jour

if ($horizon=='3')
{
$jour_moins_un=$jour-1;
$jour_plus_un=$jour+1;
$jour_moins_sept=$jour-7;
$jour_plus_sept=$jour+7;
echo '&jour='.$jour_moins_sept.'&current_week='.date("W",$jour_semaine_precedent).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> ';
}
else
{
echo '&jour='.$jour.'&current_week='.date("W",$previousMonth).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> '; 
}
}

//fleche de gauche
if ($horizon=='3')
{
   echo '<a href="index.php?current_year='.date("o",$jour_precedent).'&horiz='.$horizon;
}
elseif ($horizon=='2' || $horizon=='4')
{
     echo '<a href="index.php?current_year='.date("o",$previousmonth).'&horiz='.$horizon;
}
else
{
 echo '<a href="index.php?current_year='.date("o",$previousdate).'&horiz='.$horizon;
}
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
		
		
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine. Si vue jour j, on décale d'un jour
if ($horizon=='2' || $horizon=='4')
{
		echo '&jour='.$jour.'&current_week='.date("W",$previousmonth).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_gauche_double.png" style="border:none;vertical-align:middle;"></a> Semaine : <input name="current_week" type="text"  maxlength="2"  class="text"  value="'.$current_week.'"> '.$nom_du_mois.' <input class="text"  maxlength="4" name="current_year" type="text"  value="'.$current_year.'">   <a href="index.php?current_year='.date("o",$nextmonth).'&horiz='.$horizon;
}
elseif ($horizon=='3')
{
$jour_moins_un=$jour-1;
$jour_plus_un=$jour+1;
$jour_moins_sept=$jour-7;
$jour_plus_sept=$jour+7;

echo '&jour='.$jour_moins_un.'&current_week='.date("W",$jour_precedent).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> '.$current_day_nom.' <a href="index.php?current_year='.date("o",$jour_suivant).'&jour='.$jour_plus_un.'&horiz='.$horizon;
}
else
{
echo '&jour='.$jour.'&current_week='.date("W",$previousdate).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> Semaine : <input name="current_week" type="text"  maxlength="2"  class="text"  value="'.$current_week.'"> Ann&eacute;e : <input class="text"  maxlength="4" name="current_year" type="text"  value="'.$current_year.'"> <a href="index.php?current_year='.date("o",$nextdate).'&horiz='.$horizon;
}

//fleche de droite
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


	 

	 

	 
		//si vue mensuelle on se décale de 5 semaines sinon que d'une semaine
if ($horizon=='2'  || $horizon=='4')
{
	 echo '&jour='.$jour.'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$nextmonth).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
elseif ($horizon=='3')
{

 echo '&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$jour_suivant).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a>';
}
else
{
 echo '&jour='.$jour.'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a>';
}



//double fleche de droite
if ($horizon!='2'  && $horizon!='4')
{
if ($horizon=='3')
{
echo ' <a href="index.php?current_year='.date("o",$jour_semaine_suivant).'&jour='.$jour_plus_sept.'&horiz='.$horizon;
}
else
{
echo ' <a href="index.php?current_year='.date("o",$nextMonth).'&horiz='.$horizon;
}
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



	 

	 

	 
		

if ($horizon=='3')
{

 echo '&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$jour_semaine_suivant).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt="" width="20" height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
else
{
 echo '&jour='.$jour.'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$nextMonth).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt=""  height="18" src="fleche_droite_double.png" style="border:none;vertical-align:middle;"></a><br>';
}
}	 

?>
</form>



<?php 
//afichage du bouton retour a la semaine actuelle dans toutes les vues 
if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi'])) && $horizon!='3' && isset($_GET['current_year']) && isset($_GET['current_week']) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) ) 

	{

	?>
<!--[if IE]>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wi').value=document.documentElement.clientWidth;document.getElementById('screen_hei').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wi" value="">

	<input type="hidden" name="hau" id="screen_hei" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour" value="<?php echo $selec_materiel; ?>">
	<?php

	if ($horizon=="1")

	{

	?>

	<input name="horiz" type="hidden" id="horiz1b" value="1" >

	<?php

	}

	if ($horizon=="0")

	{

	?>

	<input name="horiz" type="hidden" id="horiz0b" value="0">

	<?php

	}

	if ($horizon=="2")

	{

	?>

	<input name="horiz" type="hidden" id="horiz2b" value="2" >

	<?php

	}
	
		if ($horizon=="4")

	{

	?>

	<input name="horiz" type="hidden" id="horiz4b" value="4" >

	<?php

	}
	
		if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3b" value="3" >

	<?php

	}

	?>
	<?php
	/*
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	*/
	?>
	
	<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">

<?php

		  for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}
				 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
		
				 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}		

	
	?>

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>
<![endif]-->
<?php

}

?>















<?php 


//afichage du bouton retour a la semaine actuelle dans toutes les vues sauf jour j

if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi'])|| isset($_GET['materiels_multi']))  && $horizon!='3' && isset($_GET['current_year']) && isset($_GET['current_week']) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) ) 
	{

	?>

<!--[if !IE]>-->	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wi').value=window.innerWidth;document.getElementById('screen_hei').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wi" value="">

	<input type="hidden" name="hau" id="screen_hei" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour2" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour2" value="<?php echo $selec_materiel; ?>">

	<?php

	if ($horizon=="1")

	{

	?>

	<input name="horiz" type="hidden" id="horiz1bis" value="1" >

	<?php

	}

	if ($horizon=="0")

	{

	?>

	<input name="horiz" type="hidden" id="horiz0bis" value="0">

	<?php

	}

	if ($horizon=="2")

	{

	?>

	<input name="horiz" type="hidden" id="horiz2bis" value="2" >

	<?php

	}
	
		if ($horizon=="4")

	{

	?>

	<input name="horiz" type="hidden" id="horiz4bis" value="4" >

	<?php

	}
	
	if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3bis" value="3" >

	<?php

	}	

	?>
<?php
	/*
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	*/
	?>
	
	
	<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">

	<?php

		for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}
		 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
		 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}
	
	
	?>



<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>
<!--<![endif]-->
<?php

}

?>





	 











<?php 

$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));

//afichage du bouton retour a la semaine actuelle pour la vue jour j
if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi'])|| isset($_GET['materiels_multi'])) && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) && ($date_du_jour!=$date_visu ) ) 
{
	?>
<!--[if IE]>
<form action="index.php" method="get" onsubmit="document.getElementById('screen_wi3').value=document.documentElement.clientWidth;document.getElementById('screen_hei3').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_wi3" value="">

	<input type="hidden" name="hau" id="screen_hei3" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour3" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour3" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour3" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour3" value="<?php echo $selec_materiel; ?>">	
	<?php

	

		if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3bi" value="3" >

	<?php

	}

	?>

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">

<?php

		  for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}
				 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
			 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}
	
	
	?>

<input name="" type="submit" value="Retour au jour J"></form><br>
<![endif]-->
<?php

}

?>















<?php 

$date_du_jour=date("Y-m-d");
$date_visu=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));

//afichage du bouton retour a la semaine actuelle pour la vue jour j
if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi'])) && $horizon=='3' && isset($_GET['current_year']) && isset($_GET['current_week']) && ($date_du_jour!=$date_visu ) ) 
{

	?>

	<!--[if !IE]>-->

<form action="index.php" method="get" onsubmit="document.getElementById('screen_wi').value=window.innerWidth;document.getElementById('screen_hei').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_wi" value="">

	<input type="hidden" name="hau" id="screen_hei" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour4" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour4" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour4" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour4" value="<?php echo $selec_materiel; ?>">

	<?php





	
	if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3c" value="3" >

	<?php

	}	

	?>

	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">
<input type="hidden" name="jour"  value="0">
	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">

	<?php

		for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}
		 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
			 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}
	
	
	?>



<input name="" type="submit" value="Retour au jour J"></form><br>
<!--<![endif]-->
	
<?php

}

?>





 













	 

<?php	 


 if (($horizon=="1" ) && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 ))
 {


	 echo '<img alt="" src="vue_prof_horizontale.php?current_year='.$current_year;

	 }

	 if ($horizon=="0" && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 ) )
	 {

	  if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>1 )
 {

	echo '<img alt="" src="vue_prof_verticale_multiressources.php?current_year='.$current_year; 

	}



else

{

echo '<img alt="" src="vue_prof_verticale.php?current_year='.$current_year;



}	

	 

	 }

	  if ($horizon=="2" && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 ))

	  {

 

	 

	 echo '<img alt="" src="vue_prof_mensuelle.php?current_year='.$current_year;

	 }
	 
	  if ($horizon=="4" && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 ))

	  {

 

	 

	 echo '<img alt="" src="vue_prof_mensuelle2.php?current_year='.$current_year;

	 }	 
	 
	  if ($horizon=="3" && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 ))

	  {

	 echo '<img alt="" src="vue_prof_journaliere.php?current_year='.$current_year.'&jour='.$jour;

	 }	 

	 

	  for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '&groupes_multi[]='.$groupes_multi[$i];

		}
	 

	 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '&salles_multi[]='.$salles_multi[$i];

		}

		for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '&profs_multi[]='.$profs_multi[$i];

		}
	for ($i=0; $i<count($materiels_multi); $i++)
		{ 
		echo '&materiels_multi[]='.$materiels_multi[$i];
		}



	 
if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>=1 )
{
	 echo '&current_week='.$current_week.'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.' " style="text-decoration: none; border: none;" USEMAP="#plan1">';
}
	}

else echo '<span style="color:red;font-weight:bold;">Veuillez choisir un groupe, un prof ou une salle dans les listes déroulantes.</span>';




//affichage des flêches de changement de semaine si le nombre de ressources est superieur ou egal a 2 dans vue verticale

 if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>1 && $horizon==0)

 {

 
 $current_date=premierlundi($current_week,$current_year);


		$nextdate=premierlundi($current_week+1,$current_year);

		$previousdate=premierlundi($current_week-1,$current_year);
 





     echo '<br><a href="index.php?current_year='.date("o",$previousdate).'&horiz='.$horizon;

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



		echo '&current_week='.date("W",$previousdate).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt="" width="20" height="18" src="fleche_gauche.png" style="border:none;vertical-align:middle;"></a> Semaine '.$current_week.' - Année '.$current_year.' <a href="index.php?current_year='.date("o",$nextdate).'&horiz='.$horizon;

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

	 

	 

	 

	 echo '&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&current_week='.date("W",$nextdate).'&lar='.$lar.'&hau='.$hau.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'"><img alt="" width="20" height="18" src="fleche_droite.png" style="border:none;vertical-align:middle;"></a><br>';

	 

?>

<!--[if IE]>


<?php 

if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi']) || isset($_GET['materiels_multi'])) && isset($_GET['current_year']) && isset($_GET['current_week']) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) ) 

	{

	?>

<form action="index.php" method="get" onsubmit="document.getElementById('screen_w5').value=document.documentElement.clientWidth;document.getElementById('screen_he5').value=document.documentElement.clientHeight">
    

	<input type="hidden" name="lar" id="screen_w5" value="">

	<input type="hidden" name="hau" id="screen_he5" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour5" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour5" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour5" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour5" value="<?php echo $selec_materiel; ?>">

	<?php

	if ($horizon=="1")

	{

	?>

	<input name="horiz" type="hidden" id="horiz1" value="1" >

	<?php

	}

	if ($horizon=="0")

	{

	?>

	<input name="horiz" type="hidden" id="horiz0" value="0">

	<?php

	}

	if ($horizon=="2")

	{

	?>

	<input name="horiz" type="hidden" id="horiz2" value="2" >

	<?php

	}

	if ($horizon=="4")

	{

	?>

	<input name="horiz" type="hidden" id="horiz4" value="4" >

	<?php

	}	
	
		if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3" value="3" >

	<?php

	}

	?>

	<?php
	/*
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	*/
	?>
	<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">

<?php

		  for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}

				 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
		 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}
	
	

	?>

<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}

else

{

echo '<br>';

}

?>




<![endif]-->



<!--[if !IE]>-->





<?php 








if ((isset($_GET['salles_multi']) || isset($_GET['profs_multi']) || isset($_GET['groupes_multi'])|| isset($_GET['materiels_multi'])) && isset($_GET['current_year']) && isset($_GET['current_week']) && ($semaine_actuelle!=$current_week || $annee_actuelle!=$current_year || $semaine_actuelle!=$current_week && $annee_actuelle!=$current_year ) ) 

	{

	?>

	

<form action="index.php" method="get" onsubmit="document.getElementById('screen_w6').value=window.innerWidth;document.getElementById('screen_he6').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w6" value="">

	<input type="hidden" name="hau" id="screen_he6" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_retour6" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_retour6" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_retour6" value="<?php echo $selec_salle; ?>">
	<input type="hidden" name="selec_materiel" id="selec_materiel_retour6" value="<?php echo $selec_materiel; ?>">


	<?php

	if ($horizon=="1")

	{

	?>

	<input name="horiz" type="hidden" id="horiz1" value="1" >

	<?php

	}

		if ($horizon=="0")

	{

	?>

	<input name="horiz" type="hidden" id="horiz0" value="0">

	<?php

	}

	if ($horizon=="2")

	{

	?>

	<input name="horiz" type="hidden" id="horiz2" value="2" >

	<?php

	}
	
	if ($horizon=="4")

	{

	?>

	<input name="horiz" type="hidden" id="horiz4" value="4" >

	<?php

	}	
	
	if ($horizon=="3")

	{

	?>

	<input name="horiz" type="hidden" id="horiz3" value="3" >

	<?php

	}

	?>

	<?php
	/*
	<input type="hidden" name="current_week"  value="<?php echo $semaine_actuelle; ?>">

	<input type="hidden" name="current_year"  value="<?php echo $annee_actuelle; ?>">
	*/
	?>
	
<input type="hidden" name="hideprivate"  value="<?php echo $_GET['hideprivate']; ?>">
	<input type="hidden" name="hideprobleme"  value="<?php echo $_GET['hideprobleme']; ?>">
	<?php

		for ($i=0; $i<count($groupes_multi); $i++)

		{ 

		echo '<input type="hidden" name="groupes_multi['.$i.']" value="'.$groupes_multi[$i].'">';

		}

		 for ($i=0; $i<count($salles_multi); $i++)

		{ 

		echo '<input type="hidden" name="salles_multi['.$i.']" value="'.$salles_multi[$i].'">';

		}

		 for ($i=0; $i<count($profs_multi); $i++)

		{ 

		echo '<input type="hidden" name="profs_multi['.$i.']" value="'.$profs_multi[$i].'">';

		}
		 for ($i=0; $i<count($materiels_multi); $i++)

		{ 

		echo '<input type="hidden" name="materiels_multi['.$i.']" value="'.$materiels_multi[$i].'">';

		}
	
	

	?>



<input name="" type="submit" value="Retour à la semaine actuelle"></form><br>

<?php

}

else
{

echo '<br>';

}

?>
<!--<![endif]-->
<?php

}



//aller directment sur son emploi du temps quand on utilise son login perso

?>



<?php

if ($truc=='1')

	{

?>
<!--[if IE]>
<script>

window.onload = function()

{

document.getElementById('screen_widt').value=document.documentElement.clientWidth;

document.getElementById('screen_heigh').value=document.documentElement.clientHeight

document.getElementById('form').submit();

}</script>
<![endif]-->
<?php

}

?>







<?php
if ($truc=='1')
	{

?>
<!--[if !IE]>-->
<script>

window.onload = function()

{

document.getElementById('screen_widt').value=window.innerWidth;

document.getElementById('screen_heigh').value=window.innerHeight

document.getElementById('form').submit();

}</script>
<!--<![endif]-->
<?php

}

?>









<?php

//affichage des infobulles 



if ($horizon=='2')

{

?>

<map name="plan1">

<?php

//largeur des bandes grises sur l edt mensuel. 

$leftwidth=40;

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



$largeur=$largeur-50;

if ($largeur<974)

{

$largeur=974;

}	



//heure de début et de fin de journée
$starttime=$heure_debut_journee;
$endtime=$heure_fin_journee;

//heure de début et de fin de la pause de midi
$lunchstart=$heure_debut_pause_midi;
$lunchstop=$heure_fin_pause_midi;


/*
// 1er lundi du mois

$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 

$datedujour=date("d",$lundi);

$numerosemainedanslemois = intval($datedujour/7);

$jsem=date("w",$lundi);

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-($numerosemainedanslemois*7),$current_year); 

$datedujour=date("d",$lundi);

// pour les cas foireux par exemple mai2009

if ($datedujour>2 && $datedujour<22) 

{

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7),$current_year); 

//pour rendre le numero de la semaine cliquable j ai besoin de la ligne suivante

$numerosemainedanslemois=$numerosemainedanslemois+1;

}

$current_day=date("Y-m-d",$lundi);
*/
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



// calcul du nb de ressources

$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
if (isset($_GET['groupes_multi']))
{
$nbdegroupe=count($_GET['groupes_multi']);
}
else
{
$nbdegroupe='0';
}
if (isset($_GET['profs_multi']))
{
$nbdeprof=count($_GET['profs_multi']);
}
else
{
$nbdeprof='0';
}
if (isset($_GET['salles_multi']))
{
$nbdesalle=count($_GET['salles_multi']);
}
else
{
$nbdesalle='0';
}
if (isset($_GET['materiels_multi']))
{
$nbdemateriel=count($_GET['materiels_multi']);
}
else
{
$nbdemateriel='0';
}

//semaine cliquable

	//définition de la font

putenv('GDFONTPATH=' . realpath('.').'/fonts/');

	// Nom de la police à utiliser

$font = "verdana.ttf";

$fontb = "verdanab.ttf";

$numerodelapremieresemainedumois=$current_week-$numerosemainedanslemois;

$nextweek=$lundi;

	for ($k=1;$k<=5;$k++)

		{

		$text="Semaine ".$numerodelapremieresemainedumois;

		$size=imagettfbbox (7 , 0, $font, $text);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		$leftx=1*$leftwidth/4-$box_width/2;

		$topy=($k-1)*(($hauteur-$topheight)*$nbressource/5+$topheight)+((($hauteur-$topheight)*$nbressource/5)+$topheight-$box_lenght)/2;

		$rightx=1*$leftwidth/4+$box_width/2;

		$bottomy=($k-1)*(($hauteur-$topheight)*$nbressource/5+$topheight)+((($hauteur-$topheight)*$nbressource/5)+$topheight-$box_lenght)/2+$box_lenght;

		

	$current_date=mktime(0,0,0,1,1,intval($current_year));

    $current_date=strtotime("+".($current_week-1)." weeks",$current_date);


   


if (isset($_SESSION['logged_prof_perso']))
{
		$codeprof=$_SESSION['logged_prof_perso'];
}
else
{
$codeprof="";
}
	$sql="SELECT * FROM login_prof WHERE codeProf=:codeprof ";
$req_log_prof=$dbh->prepare($sql);
$req_log_prof->execute(array(':codeprof'=>$codeprof));
$res_log_prof=$req_log_prof->fetchAll();
	
	
		if (count($res_log_prof)>0 && $res_log_prof['0']['horizontal']!=3)

		{

		$memoirehorizon=$res_log_prof['0']['horizontal'];
	

		}

		else

		{

		$memoirehorizon='0';

		}

		?>

<area title="" alt="semaine" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>"  <?php    echo 'href="index.php?current_year='.date("o",$nextweek).'&horiz='.$memoirehorizon;



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



			echo '&current_week='.date("W",$nextweek).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'">';

		

		

		

		$numerodelapremieresemainedumois+=1;

		  $nextweek=strtotime("+1 week",$nextweek);

	    }	

/////////////////////////////////////////////////////////////////////////////////////
//                                                                 				   //
//                                                                  			   //
//                                                                 				   //
//       affichage des infobulles pour les seances des groupes  (vue mensuelle)    //
//                                                                 				   //
//                                                                				   //
//                                                                				   //
/////////////////////////////////////////////////////////////////////////////////////


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
//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom";
$req_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
$req_groupes2=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels=$dbh->prepare($sql);
	

//pour chaque groupe

for ($i=0; $i<count($groupes_multi); $i++)
	{
	$groupeaafficher=$groupes_multi[$i];
	$critere="AND (";
	$stop=0;
	while ($stop!=1 )
		{
		$req_groupes_de_niveau_supbis->execute(array(':groupeaafficher'=>$groupeaafficher));
		$res_groupes_de_niveau_supbis=$req_groupes_de_niveau_supbis->fetchAll();

				$critere .= "seances_groupes.codeRessource='".$groupeaafficher."' OR ";
				if (count($res_groupes_de_niveau_supbis)>0)
				{
				$groupeaafficher=$res_groupes_de_niveau_supbis['0']['codeRessource'];
				}
				else 
					{
					$stop=1;
					}
			
		
		}

	$critere .= "0)";





for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));






	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances

	unset($req_seance);
	//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND enseignements.deleted='0' ";
	$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) right JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND seances_profs.deleted=0 AND enseignements.deleted='0' ";
	$req_seance=$dbh->prepare($sql);	
	$req_seance->execute(array(':current_day'=>$current_day));
	$res_seances=$req_seance->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)

		{
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut   ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	


	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;

		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";
unset($res_salle);
		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
		if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}






	
	
		
		
			$info_bulle.=" / ";

		}
	}
			

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/








		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;



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

		

// nombre de jour a afficher par semaine

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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		

$req_groupes->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes->fetchAll();





	

		//requette pour avoir infos sur prof et salle

$req_profs->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs->fetchAll();



		$req_salles->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles->fetchAll();	

		

		



	
		//horaires
$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
	

		//nom séance

	

		
		

		
		if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
	//type de seance	
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.=$cursetype." - ";

		



	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

				{

		$info_bulle.= $res_seance['commentaire']." - ";

		}

		//noms profs
$nbprofs=0;
unset($profs);
$profs="";
				foreach ($res_prof as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;
		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
			
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;

}






			
			

//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
		






		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	



		//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";
unset($res_salle);
		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}









		

	}				
			
			
$seance_clicable_area.='<area title="'.$info_bulle.'" alt="seance groupe" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" href="'.$lien.'">';			
		



}




}

}



}


//affichage des infobulles pour les reservations des groupes (vue mensuelle)



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


//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis2=$dbh->prepare($sql);

for ($i=0; $i<count($groupes_multi); $i++)
	{
	$groupeaafficher=$groupes_multi[$i];
	$critere="AND (";
	$stop=0;
	while ($stop!=1 )
		{
		$req_groupes_de_niveau_supbis2->bindValue(':groupeaafficher', $groupeaafficher, PDO::PARAM_STR);
		$req_groupes_de_niveau_supbis2->execute(array(':groupeaafficher'=>$groupeaafficher));
		$res_groupes_de_niveau_supbis2=$req_groupes_de_niveau_supbis2->fetchAll();
		
		

				$critere .= "reservations_groupes.codeRessource='".$groupeaafficher."' OR ";
				if (count($res_groupes_de_niveau_supbis2)>0)
				{
				$groupeaafficher=$res_groupes_de_niveau_supbis2['0']['codeRessource'];
				}
				else 
					{
					$stop=1;
					}
			
		
		}

	$critere .= "0)";



//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);





// Pour les 35 jours de la vue, on interroge la DB

for ($day=0;$day<35;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances

		unset ($req_resa);
		$sql="SELECT *, reservations.dureeReservation, reservations.commentaire FROM reservations_groupes LEFT JOIN (reservations) ON (reservations_groupes.codereservation=reservations.codereservation)  WHERE reservations.datereservation=:current_day AND reservations.deleted=0 ".$critere." AND reservations_groupes.deleted=0  ";
		$req_resa=$dbh->prepare($sql);	
		$req_resa->execute(array(':current_day'=>$current_day));
		$res_resas=$req_resa->fetchAll();



		// Pour chaque séance

		foreach($res_resas as $res_resa)

		{



			// On convertit l'horaire en %age de la journée


			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);


			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



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

		

		// recherche si une salle est associée à la réservation
$req_resa_salle->execute(array(':codeReservation'=>$res_resa['codeReservation']));
$res_resa_salles=$req_resa_salle->fetchAll();
$nb_resa_salle=0;
$nom_resa_salle="";
foreach($res_resa_salles as $res_resa_salle)
	{
	if ($nb_resa_salle>0)
		{
		$nom_resa_salle.=", ";
		}
	$nb_resa_salle++;
			if ($nom_salle_afficher_alias==1)
	{
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
	
	}

//affichage du mot "salle" devant la liste des salles
if ($affichage_mot_salle_pour_prof=='1')
{
 if ($nb_resa_salle==1)
	 {
	 $nom_resa_salle="Salle : ".$nom_resa_salle;
	 }
  
 if($nb_resa_salle>1)
	 {
	 $nom_resa_salle="Salles : ".$nom_resa_salle;
	 }
}
	

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+10 ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 

		

		

		

		

				?>

		<area title="

		<?php



		

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		



		

		//commentaire seance

		echo $res_resa['commentaire']." ";

// nom des salles
echo $nom_resa_salle;
 


		?>" alt="reservation groupe" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

		

		}

		}

		}

		}




//affichage des infobulles pour les seances des profs (vue mensuelle)



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

	

//preparation des requetes
//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND enseignements.deleted='0' AND seances_profs.deleted=0 ";
$req_seance2=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles2=$dbh->prepare($sql);	

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:current_prof";
$req_profs2=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels2=$dbh->prepare($sql);


for ($i=0; $i<count($profs_multi); $i++)

{

$current_prof= $profs_multi[$i];



// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour le prof et le jour choisi l'ensemble des séances

$req_seance2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof));
$res_seances=$req_seance2->fetchAll();

	// Pour chaque séance

	foreach($res_seances as $res_seance)

		{

		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;	
			
			
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
		
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}





		
		
			$info_bulle.=" / ";

		}
	}
		
				

		
		
		
		
		


		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/

		


		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);

		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



	//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;
	



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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 





$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes3->fetchAll();

		

		

$req_salles2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles2->fetchAll();

		

	
		//horaires

		$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
		

	//nom séance	
				if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";


//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		



		

	

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." ";

			}

	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;


//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;


		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;
		}

			
		//si séance annulée		
		if ( $res_seance['annulee']=='1')
		{
		$info_bulle.= "(Séance annulée)"." ";
		}
		

	


	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;	
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;	

}

	}	



$seance_clicable_area.='<area title="'.$info_bulle.'" alt="seance prof" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';

	



}



}}}





// affichage infobulles reservation profs (vue mensuelle)



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

	

	



for ($i=0; $i<count($profs_multi); $i++)

{

$current_prof= $profs_multi[$i];




// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));





if (!$hideprivate) {

//test si prof loggué avec login perso
$test_login=0;
if (isset($_SESSION['logged_prof_perso']))
{
if ($current_prof==$_SESSION['logged_prof_perso'])
{
$test_login=1;
}
}

//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);


if ($pas_afficher_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

elseif($contenu_reservation_privee==0)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==1 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==0 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

//$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0  ";
$req_resa2=$dbh->prepare($sql);	
$req_resa2->execute(array(':current_day'=>$current_day,':current_prof'=>$current_prof));
$res_resas=$req_resa2->fetchAll();

		// Pour chaque reservation

	foreach($res_resas as $res_resa)

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

// recherche si une salle est associée à la réservation
$req_resa_salle->execute(array(':codeReservation'=>$res_resa['codeReservation']));
$res_resa_salles=$req_resa_salle->fetchAll();
$nb_resa_salle=0;
$nom_resa_salle="";
foreach($res_resa_salles as $res_resa_salle)
	{
	if ($nb_resa_salle>0)
		{
		$nom_resa_salle.=", ";
		}
	$nb_resa_salle++;
			if ($nom_salle_afficher_alias==1)
	{
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
	
	}
	
	
//affichage du mot "salle" devant la liste des salles
if ($affichage_mot_salle_pour_prof=='1')
{
 if ($nb_resa_salle==1)
	 {
	 $nom_resa_salle="Salle : ".$nom_resa_salle;
	 }
  
 if($nb_resa_salle>1)
	 {
	 $nom_resa_salle="Salles : ".$nom_resa_salle;
	 }
}		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+10 ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) -10; 


echo '<area title="';

		
				//horaires
		echo $horaire_debut."-".$horaire_fin." ";

	

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1' || $test_login==1  )
			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		echo " ".$nom_resa_salle;
		

		?>" alt="reservation prof" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

		

}}}}


//affichage infobulles seances salles (vue mensuelle)

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


//preparation des requetes
$sql="SELECT * FROM ressources_salles WHERE deleted='0' and codeSalle=:current_salle";
$req_salle3=$dbh->prepare($sql);

//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_salles.deleted=0 ";
$req_seance3=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels3=$dbh->prepare($sql);



for ($i=0; $i<count($salles_multi); $i++)

{

$current_salle= $salles_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{

    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance3->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle));
$res_seances=$req_seance3->fetchAll();


	// Pour chaque séance
	foreach($res_seances as $res_seance)

		{

	
		
		
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement, enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}
	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		
		
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;


}



	
		
		
			$info_bulle.=" / ";

		}
	}
				
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/









		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;




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

		

		

	// On calcule les coordonnées du rectangle :


		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 



$req_groupes4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes4->fetchAll();

		
$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll();





	
		//horaires

		$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
	//nom séance	

					if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		


		

		

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." - ";

		}



	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;		

	//noms profs
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;
			
//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;
			}
	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}

		

	}			
			
			
			
			
$seance_clicable_area.='<area title="'.$info_bulle.'" alt="seance salle" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';		



}

}}}










//affichage infobulles reservation salles (vue mensuelle)

if (!$hideprivate) {

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





for ($i=0; $i<count($salles_multi); $i++)

{

$current_salle= $salles_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{


    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));

$sql="SELECT * FROM reservations_salles LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_salles.codeRessource=:current_salle AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_salles.deleted=0  AND diffusable='1'";
$req_resa3=$dbh->prepare($sql);	
$req_resa3->execute(array(':current_day'=>$current_day,':current_salle'=>$current_salle));
$res_resas=$req_resa3->fetchAll();





		// Pour chaque reservation
	foreach($res_resas as $res_resa)

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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) +10; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 



		


				

	echo '<area title="';

	

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1'   )

			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		

		?>" alt="reservation salle" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

}}}}



//affichage infobulles seances materiels (vue mensuelle)

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


//preparation des requetes
$sql="SELECT * FROM ressources_materiels WHERE deleted='0' and codeMateriel=:current_materiel";
$req_materiel4=$dbh->prepare($sql);

//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_materiels.deleted=0 ";
$req_seance4=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs4=$dbh->prepare($sql);

	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles4=$dbh->prepare($sql);	




for ($i=0; $i<count($materiels_multi); $i++)

{

$current_materiel= $materiels_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{

    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance4->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel));
$res_seances=$req_seance4->fetchAll();


	// Pour chaque séance
	foreach($res_seances as $res_seance)

		{

	
		
		
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement, enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}
	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		//$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
				if (count($res_materiel)>=1)
		{
		$salles=" - ";
		
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
}


		
	
		
		
			$info_bulle.=" / ";

		}
	}
				
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/









		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;

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

		

		

	// On calcule les coordonnées du rectangle :


		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 



$req_groupes5->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes5->fetchAll();

		
$req_profs4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs4->fetchAll();

$req_salles4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles4->fetchAll();



	
		//horaires

$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
	//nom séance	

					if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		


		

		

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." - ";

		}



	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;		

	//noms profs
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;



		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
				
		//si séance annulée		
		if ( $res_seance['annulee']=='1')
		{
		$info_bulle.= "(Séance annulée)"." ";
		}

			

			
	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;


//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		//$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
						if (count($res_materiel)>=1)
		{
		$salles=" - ";
		
		
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

}


	
		

	}			
			
			
				
			
$seance_clicable_area.='<area title="'.$info_bulle.'" alt="seance materiel" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';		



}

}}}










//affichage infobulles reservation materiels (vue mensuelle)

if (!$hideprivate) {

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





for ($i=0; $i<count($materiels_multi); $i++)

{

$current_materiel= $materiels_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{


    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));

$sql="SELECT * FROM reservations_materiels LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_materiels.codeRessource=:current_materiel AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_materiels.deleted=0  AND diffusable='1'";
$req_resa4=$dbh->prepare($sql);	
$req_resa4->execute(array(':current_day'=>$current_day,':current_materiel'=>$current_materiel));
$res_resas=$req_resa4->fetchAll();





		// Pour chaque reservation
	foreach($res_resas as $res_resa)

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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) +10; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 



		


	echo '<area title="';

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1'   )

			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		

		?>" alt="reservation salle" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

}}}}





















// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//Vue mensuelle
// etudiant cliquable  pour avoir l'abonement aux fichiers ics





//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable=$dbh->prepare($sql);
	
for ($i=0; $i<count($groupes_multi); $i++)
	{
	$current_student=$groupes_multi[$i];
	$req_groupe_clicable->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable=$req_groupe_clicable->fetchAll();
	
	$policegroupe=6;
foreach ($res_groupe_clicable as $res)
	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{	
			$xhautgauche=3*$leftwidth/4+$box_width/2-6;
			$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
			$xbasdroit=3*$leftwidth/4+$box_width/2;
			$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
				
		echo '<area title="" alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
		}	
	}
}


// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	

	$req_prof_clicable->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable=$req_prof_clicable->fetchAll();

	$policeprof=6;
foreach ($res_prof_clicable as $res)

		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		
		for ($p=1;$p<=5;$p++)
			{	
			$xhautgauche=3*$leftwidth/4+$box_width/2-6;
			$yhautgauche=($p)*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
			$xbasdroit=3*$leftwidth/4+$box_width/2;
			$ybasdroit=($p)*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
				
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
			}	
		}	
	}
	
	
//salle cliquable pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
	
	$req_salle_clicable->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable=$req_salle_clicable->fetchAll();
foreach ($res_salle_clicable as $res)
		{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=6;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{
				$xhautgauche=3*$leftwidth/4+$box_width/2-6;
				$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
				$xbasdroit=3*$leftwidth/4+$box_width/2;
				$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
					
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
		}
    }

//materiel cliquable pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
	
	$req_materiel_clicable->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable=$req_materiel_clicable->fetchAll();
foreach ($res_materiel_clicable as $res)
		{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=6;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{
				$xhautgauche=3*$leftwidth/4+$box_width/2-6;
				$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
				$xbasdroit=3*$leftwidth/4+$box_width/2;
				$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
					
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
		}
    }	
	
	


	
}




if ($horizon=='4')

{

?>

<map name="plan1">

<?php

//largeur des bandes grises sur l edt mensuel. 

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
$largeur=$largeur-50;

if ($largeur<974)

{

$largeur=974;

}


$hauteur=$hauteur-360;

if ($hauteur<382)

{

$hauteur=382;

}
$hauteur=$hauteur*6;



//heure de début et de fin de journée
$starttime=$heure_debut_journee;
$endtime=$heure_fin_journee;

//heure de début et de fin de la pause de midi
$lunchstart=$heure_debut_pause_midi;
$lunchstop=$heure_fin_pause_midi;


/*
// 1er lundi du mois

$jour=date("w",mktime(0,0,0,1,1,$current_year));

if($jour==0){$jour=7;}

if($jour>4){$premieran=0;}else{$premieran=-1;}

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7),$current_year); 

$datedujour=date("d",$lundi);

$numerosemainedanslemois = intval($datedujour/7);

$jsem=date("w",$lundi);

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-($numerosemainedanslemois*7),$current_year); 

$datedujour=date("d",$lundi);

// pour les cas foireux par exemple mai2009

if ($datedujour>2 && $datedujour<22) 

{

$lundi=mktime(0,0,0,1,(($current_week+$premieran)*7)+(1-$jsem)-(($numerosemainedanslemois+1)*7),$current_year); 

//pour rendre le numero de la semaine cliquable j ai besoin de la ligne suivante

$numerosemainedanslemois=$numerosemainedanslemois+1;

}

$current_day=date("Y-m-d",$lundi);
*/
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
// calcul du nb de ressources

$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
if (isset($_GET['groupes_multi']))
{
$nbdegroupe=count($_GET['groupes_multi']);
}
else
{
$nbdegroupe='0';
}
if (isset($_GET['profs_multi']))
{
$nbdeprof=count($_GET['profs_multi']);
}
else
{
$nbdeprof='0';
}
if (isset($_GET['salles_multi']))
{
$nbdesalle=count($_GET['salles_multi']);
}
else
{
$nbdesalle='0';
}
if (isset($_GET['materiels_multi']))
{
$nbdemateriel=count($_GET['materiels_multi']);
}
else
{
$nbdemateriel='0';
}

//semaine cliquable

	//définition de la font

putenv('GDFONTPATH=' . realpath('.').'/fonts/');

	// Nom de la police à utiliser

$font = "verdana.ttf";

$fontb = "verdanab.ttf";

$numerodelapremieresemainedumois=$current_week-$numerosemainedanslemois;

$nextweek=$lundi;

	for ($k=1;$k<=5;$k++)

		{

		$text="Semaine ".$numerodelapremieresemainedumois;

		$size=imagettfbbox (7 , 0, $font, $text);

		$box_lenght=$size[2]-$size[0];

		$box_width=$size[1]-$size[7];

		
		
		$leftx=1*$leftwidth/4-$box_width/2;

		$topy=($k-1)*(($hauteur-$topheight)*$nbressource/5+$topheight)+((($hauteur-$topheight)*$nbressource/5)-$box_lenght)/2+$topheight;

		$rightx=1*$leftwidth/4+$box_width/2;

		$bottomy=($k-1)*(($hauteur-$topheight)*$nbressource/5+$topheight)+((($hauteur-$topheight)*$nbressource/5)-$box_lenght)/2+$topheight+$box_lenght;

		

	$current_date=mktime(0,0,0,1,1,intval($current_year));

    $current_date=strtotime("+".($current_week-1)." weeks",$current_date);


   


if (isset($_SESSION['logged_prof_perso']))
{
		$codeprof=$_SESSION['logged_prof_perso'];
}
else
{
$codeprof="";
}
	$sql="SELECT * FROM login_prof WHERE codeProf=:codeprof ";
$req_log_prof=$dbh->prepare($sql);
$req_log_prof->execute(array(':codeprof'=>$codeprof));
$res_log_prof=$req_log_prof->fetchAll();
	
	
		if (count($res_log_prof)>0 && $res_log_prof['0']['horizontal']!=3 && $res_log_prof['0']['horizontal']!=4)

		{

		$memoirehorizon=$res_log_prof['0']['horizontal'];
	

		}

		else

		{

		$memoirehorizon='0';

		}

		?>

<area title="" alt="semaine" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>"  <?php    echo 'href="index.php?current_year='.date("o",$nextweek).'&horiz='.$memoirehorizon;



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



			echo '&current_week='.date("W",$nextweek).'&hideprivate='.$_GET['hideprivate'].'&hideprobleme='.$_GET['hideprobleme'].'&lar='.$lar.'&hau='.$hau.'&selec_salle='.$selec_salle.'&selec_materiel='.$selec_materiel.'&selec_prof='.$selec_prof.'&selec_groupe='.$selec_groupe.'">';

		

		

		

		$numerodelapremieresemainedumois+=1;

		  $nextweek=strtotime("+1 week",$nextweek);

	    }	

/////////////////////////////////////////////////////////////////////////////////////
//                                                                 				   //
//                                                                  			   //
//                                                                 				   //
//       affichage des infobulles pour les seances des groupes  (vue mensuelle)    //
//                                                                 				   //
//                                                                				   //
//                                                                				   //
/////////////////////////////////////////////////////////////////////////////////////


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
//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 AND ressources_groupes.deleted='0' ";
$req_groupes=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom";
$req_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);

$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
$req_groupes2=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels=$dbh->prepare($sql);
	

//pour chaque groupe

for ($i=0; $i<count($groupes_multi); $i++)
	{
	$groupeaafficher=$groupes_multi[$i];
	$critere="AND (";
	$stop=0;
	while ($stop!=1 )
		{
		$req_groupes_de_niveau_supbis->execute(array(':groupeaafficher'=>$groupeaafficher));
		$res_groupes_de_niveau_supbis=$req_groupes_de_niveau_supbis->fetchAll();

				$critere .= "seances_groupes.codeRessource='".$groupeaafficher."' OR ";
				if (count($res_groupes_de_niveau_supbis)>0)
				{
				$groupeaafficher=$res_groupes_de_niveau_supbis['0']['codeRessource'];
				}
				else 
					{
					$stop=1;
					}
			
		
		}

	$critere .= "0)";





for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));






	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances

	unset($req_seance);
	
	$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND seances_profs.deleted=0 AND enseignements.deleted='0' ";
	$req_seance=$dbh->prepare($sql);	
	$req_seance->execute(array(':current_day'=>$current_day));
	$res_seances=$req_seance->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)

		{
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut   ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	


	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;

		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";
unset($res_salle);
		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
		if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}






	
	
		
		
			$info_bulle.=" / ";

		}
	}
			

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/








		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;


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

		

// nombre de jour a afficher par semaine

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

		

		

	// On calcule les coordonnées du rectangle :





		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		
		

$req_groupes->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes->fetchAll();





	

		//requette pour avoir infos sur prof et salle

$req_profs->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_prof=$req_profs->fetchAll();



		$req_salles->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles->fetchAll();	

		

		



	
		//horaires

		$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
	

		//nom séance

	

		
		

		
		if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
	//type de seance	
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		



	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

				{

		$info_bulle.= $res_seance['commentaire']." - ";

		}

		//noms profs
$nbprofs=0;
unset($profs);
$profs="";
				foreach ($res_prof as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;
		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
			
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;

}






			
			

//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	



		//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";
unset($res_salle);
		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}









		

	}				
		
			
			
	$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';	

		

}




}

}



}


//affichage des infobulles pour les reservations des groupes (vue mensuelle)



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


//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis2=$dbh->prepare($sql);

for ($i=0; $i<count($groupes_multi); $i++)
	{
	$groupeaafficher=$groupes_multi[$i];
	$critere="AND (";
	$stop=0;
	while ($stop!=1 )
		{
		$req_groupes_de_niveau_supbis2->bindValue(':groupeaafficher', $groupeaafficher, PDO::PARAM_STR);
		$req_groupes_de_niveau_supbis2->execute(array(':groupeaafficher'=>$groupeaafficher));
		$res_groupes_de_niveau_supbis2=$req_groupes_de_niveau_supbis2->fetchAll();
		
		

				$critere .= "reservations_groupes.codeRessource='".$groupeaafficher."' OR ";
				if (count($res_groupes_de_niveau_supbis2)>0)
				{
				$groupeaafficher=$res_groupes_de_niveau_supbis2['0']['codeRessource'];
				}
				else 
					{
					$stop=1;
					}
			
		
		}

	$critere .= "0)";



//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);





// Pour les 35 jours de la vue, on interroge la DB

for ($day=0;$day<35;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour les groupes de l'etudiant et le jour choisi l'ensemble des séances

		unset ($req_resa);
		$sql="SELECT *, reservations.dureeReservation, reservations.commentaire FROM reservations_groupes LEFT JOIN (reservations) ON (reservations_groupes.codereservation=reservations.codereservation)  WHERE reservations.datereservation=:current_day AND reservations.deleted=0 ".$critere." AND reservations_groupes.deleted=0  ";
		$req_resa=$dbh->prepare($sql);	
		$req_resa->execute(array(':current_day'=>$current_day));
		$res_resas=$req_resa->fetchAll();



		// Pour chaque séance

		foreach($res_resas as $res_resa)

		{



			// On convertit l'horaire en %age de la journée


			$start_time=((substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

			$duree=((substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60))/($endtime-$starttime+0.25);


			$horaire_debut = substr((100+substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)),-2,2)."h".substr($res_resa['heureReservation'],-2,2);

			$horaire_fin = (substr($res_resa['heureReservation'],-strlen($res_resa['heureReservation']),strlen($res_resa['heureReservation'])-2)+substr($res_resa['heureReservation'],-2,2)/60) + (substr($res_resa['dureeReservation'],-strlen($res_resa['dureeReservation']),strlen($res_resa['dureeReservation'])-2)+substr($res_resa['dureeReservation'],-2,2)/60);

			$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);



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

		

		// recherche si une salle est associée à la réservation
$req_resa_salle->execute(array(':codeReservation'=>$res_resa['codeReservation']));
$res_resa_salles=$req_resa_salle->fetchAll();
$nb_resa_salle=0;
$nom_resa_salle="";
foreach($res_resa_salles as $res_resa_salle)
	{
	if ($nb_resa_salle>0)
		{
		$nom_resa_salle.=", ";
		}
	$nb_resa_salle++;
			if ($nom_salle_afficher_alias==1)
	{
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
	
	}

//affichage du mot "salle" devant la liste des salles
if ($affichage_mot_salle_pour_prof=='1')
{
 if ($nb_resa_salle==1)
	 {
	 $nom_resa_salle="Salle : ".$nom_resa_salle;
	 }
  
 if($nb_resa_salle>1)
	 {
	 $nom_resa_salle="Salles : ".$nom_resa_salle;
	 }
}
	

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +$i*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+10 ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 

		

		

		

		

		echo '<area title="';



		

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		



		

		//commentaire seance

		echo $res_resa['commentaire']." ";

// nom des salles
echo $nom_resa_salle;
 


		?>" alt="reservation groupe" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

		

		}

		}

		}

		}




//affichage des infobulles pour les seances des profs (vue mensuelle)



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

	

//preparation des requetes
//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND enseignements.deleted='0' AND seances_profs.deleted=0 ";
$req_seance2=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles2=$dbh->prepare($sql);	

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:current_prof";
$req_profs2=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels2=$dbh->prepare($sql);


for ($i=0; $i<count($profs_multi); $i++)

{

$current_prof= $profs_multi[$i];



// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour le prof et le jour choisi l'ensemble des séances

$req_seance2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof));
$res_seances=$req_seance2->fetchAll();

	// Pour chaque séance

	foreach($res_seances as $res_seance)

		{

		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
		
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}





		
		
			$info_bulle.=" / ";

		}
	}
		
				

		
		
		
		
		


		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/

		


		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);

		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//création du lien
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
						 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;	

		



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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 





$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes3->fetchAll();

		

		

$req_salles2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles2->fetchAll();

		

		//horaires

		$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
		

	//nom séance	
				if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";


//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		



		

	

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." ";

			}

	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;


//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;




		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;
		}

			
		//si séance annulée		
		if ( $res_seance['annulee']=='1')
		{
		$info_bulle.= "(Séance annulée)"." ";
		}
		

	


	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;	
		
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;	

}

	}	


$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
	

		

		

}



}}}





// affichage infobulles reservation profs (vue mensuelle)



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

	

	



for ($i=0; $i<count($profs_multi); $i++)

{

$current_prof= $profs_multi[$i];




// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{



    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));





if (!$hideprivate) {

//test si prof loggué avec login perso
$test_login=0;
if (isset($_SESSION['logged_prof_perso']))
{
if ($current_prof==$_SESSION['logged_prof_perso'])
{
$test_login=1;
}
}

//preparation de requetes
$sql="SELECT * FROM reservations_salles left join (ressources_salles ) on ressources_salles.codeSalle=reservations_salles.codeRessource WHERE reservations_salles.codeReservation=:codeReservation AND reservations_salles.deleted=0 and ressources_salles.deleted=0 order by ressources_salles.nom";
$req_resa_salle=$dbh->prepare($sql);


if ($pas_afficher_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

elseif($contenu_reservation_privee==0)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==1 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0 ";
}
elseif ($test_login==0 && $contenu_reservation_privee==1)
{
$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0 AND reservations.diffusable=1  AND reservations_profs.deleted=0 ";
}

//$sql="SELECT * FROM reservations_profs LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_profs.codeRessource=:current_prof AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_profs.deleted=0  ";
$req_resa2=$dbh->prepare($sql);	
$req_resa2->execute(array(':current_day'=>$current_day,':current_prof'=>$current_prof));
$res_resas=$req_resa2->fetchAll();

		// Pour chaque reservation

	foreach($res_resas as $res_resa)

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

// recherche si une salle est associée à la réservation
$req_resa_salle->execute(array(':codeReservation'=>$res_resa['codeReservation']));
$res_resa_salles=$req_resa_salle->fetchAll();
$nb_resa_salle=0;
$nom_resa_salle="";
foreach($res_resa_salles as $res_resa_salle)
	{
	if ($nb_resa_salle>0)
		{
		$nom_resa_salle.=", ";
		}
	$nb_resa_salle++;
			if ($nom_salle_afficher_alias==1)
	{
	$nom_resa_salle .= substr($res_resa_salle['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$nom_resa_salle .= substr($res_resa_salle['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
	
	}
	
	
//affichage du mot "salle" devant la liste des salles
if ($affichage_mot_salle_pour_prof=='1')
{
 if ($nb_resa_salle==1)
	 {
	 $nom_resa_salle="Salle : ".$nom_resa_salle;
	 }
  
 if($nb_resa_salle>1)
	 {
	 $nom_resa_salle="Salles : ".$nom_resa_salle;
	 }
}		

		

	// On calcule les coordonnées du rectangle :



		if ($res_resa['dureeReservation']<=100)
				{
				$epaisseur=11;
				}
				else
				{
				$epaisseur=16;
				}	

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5)+$epaisseur; 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)+10 ; 

		$rightx = $leftwidth +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) -10; 



		

echo '<area title="';

		

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1' || $test_login==1  )
			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		echo " ".$nom_resa_salle;
		

		?>" alt="reservation prof" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

		

}}}}


//affichage infobulles seances salles (vue mensuelle)

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


//preparation des requetes
$sql="SELECT * FROM ressources_salles WHERE deleted='0' and codeSalle=:current_salle";
$req_salle3=$dbh->prepare($sql);

//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_salles.deleted=0 ";
$req_seance3=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels3=$dbh->prepare($sql);



for ($i=0; $i<count($salles_multi); $i++)

{

$current_salle= $salles_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{

    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance3->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle));
$res_seances=$req_seance3->fetchAll();


	// Pour chaque séance
	foreach($res_seances as $res_seance)

		{

	
		
		
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement, enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}
	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		
		
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;


}



	
		
		
			$info_bulle.=" / ";

		}
	}
				
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/









		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;	

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

		

		

	// On calcule les coordonnées du rectangle :


		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 



$req_groupes4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes4->fetchAll();

		
$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll();





		//horaires

	$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
	//nom séance	

					if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		


		

		

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." - ";

		}



	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;		

	//noms profs
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;
			
//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.= $materiels;
			}
	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		//$materiels=" - ";

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}

		

	}			
			
			
			
			
		
			
	$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';	



}

}}}










//affichage infobulles reservation salles (vue mensuelle)

if (!$hideprivate) {

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





for ($i=0; $i<count($salles_multi); $i++)

{

$current_salle= $salles_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{


    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));

$sql="SELECT * FROM reservations_salles LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_salles.codeRessource=:current_salle AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_salles.deleted=0  AND diffusable='1'";
$req_resa3=$dbh->prepare($sql);	
$req_resa3->execute(array(':current_day'=>$current_day,':current_salle'=>$current_salle));
$res_resas=$req_resa3->fetchAll();





		// Pour chaque reservation
	foreach($res_resas as $res_resa)

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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) +10; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 



		


					?>

		<area title="

		<?php

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1'   )

			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		

		?>" alt="reservation salle" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

}}}}



//affichage infobulles seances materiels (vue mensuelle)

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


//preparation des requetes
$sql="SELECT * FROM ressources_materiels WHERE deleted='0' and codeMateriel=:current_materiel";
$req_materiel4=$dbh->prepare($sql);

//$sql="SELECT *, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0 ";
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_materiels.deleted=0 ";
$req_seance4=$dbh->prepare($sql);

$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs4=$dbh->prepare($sql);

	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles4=$dbh->prepare($sql);	




for ($i=0; $i<count($materiels_multi); $i++)

{

$current_materiel= $materiels_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{

    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance4->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel));
$res_seances=$req_seance4->fetchAll();


	// Pour chaque séance
	foreach($res_seances as $res_seance)

		{

	
		
		
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement, enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}
	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		//$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
				if (count($res_materiel)>=1)
		{
		$salles=" - ";
		
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
}


		
	
		
		
			$info_bulle.=" / ";

		}
	}
				
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :



		On extrait d'une part les minutes et d'autre part l'heure.

		On transforme les minutes en fraction d'heure.

		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.

		On obtient un %age correspondant à la position du début du cours.

		Idem pour la durée mais sans enlever 8.15



		*/









		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);

		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);







		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);

		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);

		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;	

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

		

		

	// On calcule les coordonnées du rectangle :


		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) ; 



$req_groupes5->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupe=$req_groupes5->fetchAll();

		
$req_profs4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs4->fetchAll();

$req_salles4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_salle=$req_salles4->fetchAll();



		
		//horaires

		$info_bulle.=$horaire_debut."-".$horaire_fin." - ";
		
	//nom séance	

					if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias'];
}
}
else
{
$cursename=explode("_",$res_seance['nom']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom'];
}
}
	$info_bulle.= $cursename[1]." - ";
//type de seance
		unset($req_type);
	$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
	$req_type=$dbh->prepare($sql);	
	$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
	$res_types=$req_type->fetchAll();		
		      
		foreach($res_types as $res_type)
	{
	$cursetype = $res_type['alias'];
	}

	    

		$info_bulle.= $cursetype." - ";

		


		

		

	

		

		//commentaire seance

		if ($res_seance['commentaire']!="")

			{

		$info_bulle.= $res_seance['commentaire']." - ";

		}



	//noms groupes
$nbgroupes=0;
unset($groupes);
$groupes="";
				foreach ($res_groupe as $res_groupes)

			{
			if ($nbgroupes>0)
				{
				$groupes.=", ";
				}
				$nbgroupes++;
			if ($res_groupes['nom']!="")

				{
				$groupes.=$res_groupes['nom'];
				

				}

		}
$info_bulle.= $groupes;		

	//noms profs
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.= $profs;



		//noms salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";


		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			$info_bulle.= $salles." "; 
				
		//si séance annulée		
		if ( $res_seance['annulee']=='1')
		{
		$info_bulle.= "(Séance annulée)"." ";
		}

			

			
	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type5->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type5->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;


//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		//$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
						if (count($res_materiel)>=1)
		{
		$salles=" - ";
		
		
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

}


	
		

	}			
			
			
					
			

$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';			
		



}

}}}










//affichage infobulles reservation materiels (vue mensuelle)

if (!$hideprivate) {

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





for ($i=0; $i<count($materiels_multi); $i++)

{

$current_materiel= $materiels_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB

for ($day=0;$day<34;$day++)

	{


    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));

$sql="SELECT * FROM reservations_materiels LEFT JOIN (reservations) USING (codeReservation) WHERE reservations_materiels.codeRessource=:current_materiel AND reservations.dateReservation=:current_day AND reservations.deleted=0  AND reservations_materiels.deleted=0  AND diffusable='1'";
$req_resa4=$dbh->prepare($sql);	
$req_resa4->execute(array(':current_day'=>$current_day,':current_materiel'=>$current_materiel));
$res_resas=$req_resa4->fetchAll();





		// Pour chaque reservation
	foreach($res_resas as $res_resa)

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

		

		

	// On calcule les coordonnées du rectangle :



		

		$topy = $numsemaine*$topheight +$start_time*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$bottomy = $numsemaine*$topheight +($start_time + $duree)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource) +($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(round(($hauteur-$topheight)*$nbressource/5)/$nbressource)+($numsemaine-1)*round(($hauteur-$topheight)*$nbressource/5); 

		$leftx = $leftwidth+ +($day-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days) +10; 

		$rightx = $leftwidth+ +($day+1-($numsemaine-1)*7)*(($largeur-$leftwidth)/$days)-10 ; 



		


					?>

		<area title="

		<?php

		//horaires

		echo $horaire_debut."-".$horaire_fin." ";

		

		if($res_resa['commentaire']!=""  && $res_resa['diffusable']=='1'   )

			{

			echo $res_resa['commentaire'];

			}

		else

		{

		echo "Privé";

		}

		

		?>" alt="reservation salle" shape="rect" coords="<?php echo $leftx; ?>,<?php echo $topy; ?>,<?php echo $rightx; ?>,<?php echo $bottomy; ?>" href="#">

<?php

}

}}}}





















// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//Vue mensuelle complete
// etudiant cliquable  pour avoir l'abonement aux fichiers ics




//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable=$dbh->prepare($sql);
	
for ($i=0; $i<count($groupes_multi); $i++)
	{
	$current_student=$groupes_multi[$i];
	$req_groupe_clicable->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable=$req_groupe_clicable->fetchAll();
	
	$policegroupe=8;
foreach ($res_groupe_clicable as $res)
	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{	
			$xhautgauche=2*$leftwidth/4+$box_width/2-6;
			$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
			$xbasdroit=2*$leftwidth/4+$box_width/2;
			$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
				
		echo '<area title="" alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
		}	
	}
}


// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	

	$req_prof_clicable->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable=$req_prof_clicable->fetchAll();

	$policeprof=8;
foreach ($res_prof_clicable as $res)

		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		
		for ($p=1;$p<=5;$p++)
			{	
			$xhautgauche=2*$leftwidth/4+$box_width/2-6;
			$yhautgauche=($p)*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
			$xbasdroit=2*$leftwidth/4+$box_width/2;
			$ybasdroit=($p)*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
				
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
			}	
		}	
	}
	
	
//salle cliquable pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
	
	$req_salle_clicable->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable=$req_salle_clicable->fetchAll();
foreach ($res_salle_clicable as $res)
		{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=8;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{
				$xhautgauche=2*$leftwidth/4+$box_width/2-6;
				$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
				$xbasdroit=2*$leftwidth/4+$box_width/2;
				$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
					
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
		}
    }

//materiel cliquable pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
	
	$req_materiel_clicable->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable=$req_materiel_clicable->fetchAll();
foreach ($res_materiel_clicable as $res)
		{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=8;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($p=1;$p<=5;$p++)
		{
		 
				$xhautgauche=2*$leftwidth/4+$box_width/2-6;
				$yhautgauche=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)-$box_lenght/2;
				$xbasdroit=2*$leftwidth/4+$box_width/2;
				$ybasdroit=$p*$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+($p-1)*(($hauteur-$topheight)*$nbressource/5)+$box_lenght/2;
					
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
		}
    }	
	
	


	
}


























// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//vue horizontale

if ($horizon=='1' && (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>'0')  )
{

//calibrage par rapport à l'image
//largeur des bandes grises. 
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


 //test si prof concerne par rdv perso a son edt affiche sur ressources multi. Si non, on agrandi l'image de 75 px
 //pour rappel : affichage de la possibilite de mettre des reservations que si on est logge avec compte prof perso et si javascript actif
 //recuperation des numeros des profs affichés
 
$profs_multi=array();
if (isset($_GET['profs_multi']))
{
$profs_multi=$_GET['profs_multi'];
}

$ok='0';
if (isset ($_SESSION['logged_prof_perso']) )
{
for ($i=0; $i<count($profs_multi); $i++)
	{
		if ($_SESSION['logged_prof_perso']==$profs_multi[$i] && $_SESSION['reservation']!='0' )
			{
			$ok='1';
			$codeprof=$profs_multi[$i];
			break;
			}
		else
			{
			$ok='0';
			}
	}
	}
if ($ok=='0')
{
$hauteur=$hauteur+72;
}


// calcul du nb de ressources
$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
$nbdegroupe=count($groupes_multi);
$nbdeprof=count($profs_multi);
$nbdesalle=count($salles_multi);
$nbdemateriel=count($materiels_multi);
//définition de la font
putenv('GDFONTPATH=' . realpath('.').'/fonts/');

// Nom de la police à utiliser
$font = "verdana.ttf";
$fontb = "verdanab.ttf";

echo '<map name="plan1">';
//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable2=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable2=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable2=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable2=$dbh->prepare($sql);	
	
// etudiant cliquable  pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($groupes_multi); $i++)
	{

			
$current_student=$groupes_multi[$i];
	$req_groupe_clicable2->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable2=$req_groupe_clicable2->fetchAll();
	

	$policegroupe=8;
foreach ($res_groupe_clicable2 as $res)

	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
		for ($day=0;$day<$days;$day++)
		{	
		//coordonnes du bord gauche d'une colonne
		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +($i*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		//coordonnes du bord droit d'une colonne
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		//coordonnees de la zone clicable
		$xhautgauche=$leftx + ($rightx - $leftx - $box_lenght)/2;
		$yhautgauche='52';
		$xbasdroit=$rightx - ($rightx - $leftx - $box_lenght)/2;
		$ybasdroit='60';
		echo '<area title="" alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
		}	
	}
}

// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	

	$req_prof_clicable2->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable2=$req_prof_clicable2->fetchAll();
	
	$policeprof=8;
	foreach($res_prof_clicable2 as $res)
		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		
	for ($day=0;$day<$days;$day++)
			{
	
		//coordonnes du bord gauche d'une colonne
		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		//coordonnes du bord droit d'une colonne
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-(($i+$nbdegroupe)+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
	
		//coordonnees de la zone clicable
		$xhautgauche=$leftx + ($rightx - $leftx - $box_lenght)/2;
		$yhautgauche='52';
		$xbasdroit=$rightx - ($rightx - $leftx - $box_lenght)/2;
		$ybasdroit='60';
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
			}	
			
		}	
	}
		
	
//salle cliquable pour avoir l'abonement aux fichiers ics
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

for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
	
	
	$req_salle_clicable2->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable2=$req_salle_clicable2->fetchAll();
	
		
	
foreach ($res_salle_clicable2 as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=8;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnes du bord gauche d'une colonne
		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		//coordonnes du bord droit d'une colonne
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		//coordonnees de la zone clicable
		$xhautgauche=$leftx + ($rightx - $leftx - $box_lenght)/2;
		$yhautgauche='52';
		$xbasdroit=$rightx - ($rightx - $leftx - $box_lenght)/2;
		$ybasdroit='60';
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
		}
    }
	
//materiel cliquable pour avoir l'abonement aux fichiers ics
	

for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
	
	
	$req_materiel_clicable2->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable2=$req_materiel_clicable2->fetchAll();
	
		
	
foreach ($res_materiel_clicable2 as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=8;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnes du bord gauche d'une colonne
		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		//coordonnes du bord droit d'une colonne
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+$nbdesalle+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		//coordonnees de la zone clicable
		$xhautgauche=$leftx + ($rightx - $leftx - $box_lenght)/2;
		$yhautgauche='52';
		$xbasdroit=$rightx - ($rightx - $leftx - $box_lenght)/2;
		$ybasdroit='60';
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
		}
    }	
		
}







// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//vue verticale avec une ressource d'affichée

if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)=='1' && $horizon=='0'  )
{

//calibrage par rapport à l'image
//largeur des bandes grises. 
$leftwidth=50;
$topheight=40;

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


 //test si prof concerne par rdv perso a son edt affiche sur ressources multi. Si non, on agrandi l'image de 75 px
 //pour rappel : affichage de la possibilite de mettre des reservations que si on est logge avec compte prof perso et si javascript actif
 //recuperation des numeros des profs affichés
 
$profs_multi=array();
if (isset($_GET['profs_multi']))
{
$profs_multi=$_GET['profs_multi'];
}
$ok='0';
for ($i=0; $i<count($profs_multi); $i++)
	{
	if (isset($_SESSION['logged_prof_perso']))
	{
if ($_SESSION['logged_prof_perso']==$profs_multi[$i] && $_SESSION['reservation']!='0' )
			{
			$ok='1';
			$codeprof=$profs_multi[$i];
			break;
			}
		else
			{
			$ok='0';
			}
			
	}
	}
if ($ok=='0')
{
$hauteur=$hauteur+72;
}


// calcul du nb de ressources
$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
$nbdegroupe=count($groupes_multi);
$nbdeprof=count($profs_multi);
$nbdesalle=count($salles_multi);
$nbdemateriel=count($materiels_multi);
//définition de la font
putenv('GDFONTPATH=' . realpath('.').'/fonts/');

// Nom de la police à utiliser
$font = "verdana.ttf";
$fontb = "verdanab.ttf";




echo '<map name="plan1">';
//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable3=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable3=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable3=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable3=$dbh->prepare($sql);

// etudiant cliquable  pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($groupes_multi); $i++)
	{
	$current_student=$groupes_multi[$i];

	$req_groupe_clicable3->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable3=$req_groupe_clicable3->fetchAll();

	$policegroupe=6;
foreach ($res_groupe_clicable3 as $res)

	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	
	for ($day=0;$day<$days;$day++)
		{	
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
		echo '<area title=""  alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
		}	
	}
}



// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	
	$req_prof_clicable3->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable3=$req_prof_clicable3->fetchAll();
	
	$policeprof=6;
foreach ($res_prof_clicable3 as $res)

		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		
		
	for ($day=0;$day<$days;$day++)
			{	
		
		
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
			}	
		}	
	}
	
	
//salle cliquable pour avoir l'abonement aux fichiers ics
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

for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
	$req_salle_clicable3->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable3=$req_salle_clicable3->fetchAll();
foreach ($res_salle_clicable3 as $res)
{	

	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=6;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
    }
	}
	
//materiel cliquable pour avoir l'abonement aux fichiers ics
	

for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
	$req_materiel_clicable3->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable3=$req_materiel_clicable3->fetchAll();
foreach ($res_materiel_clicable3 as $res)
{	

	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=6;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			
				echo '<area title=""  alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
    }
	}	
	
	
		
}



// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//vue verticale avec plusieurs ressources d'affichées

 if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>'1' && $horizon=='0' )
{

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

//calibrage par rapport à l'image
//largeur des bandes grises. 
$leftwidth=50;
$topheight=40;

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

// calcul du nb de ressources
$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
$nbdegroupe=count($groupes_multi);
$nbdeprof=count($profs_multi);
$nbdesalle=count($salles_multi);
$nbdemateriel=count($materiels_multi);
//définition de la font
putenv('GDFONTPATH=' . realpath('.').'/fonts/');

// Nom de la police à utiliser
$font = "verdana.ttf";
$fontb = "verdanab.ttf";

echo '<map name="plan1">';
//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable4=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable4=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable4=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable4=$dbh->prepare($sql);
// etudiant cliquable  pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($groupes_multi); $i++)
	{
	$current_student=$groupes_multi[$i];

	$req_groupe_clicable4->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable4=$req_groupe_clicable4->fetchAll();
	$policegroupe=6;
foreach ($res_groupe_clicable4  as $res)
	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{	
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
		echo '<area title="" alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
		}	
	}
}

// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	
	$req_prof_clicable4->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable4=$req_prof_clicable4->fetchAll();
	


	$policeprof=6;
foreach ($res_prof_clicable4  as $res)
		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		
	for ($day=0;$day<$days;$day++)
			{	
		
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
			}	
		}	
	}
	
//salle cliquable pour avoir l'abonement aux fichiers ics
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

for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
		
	$req_salle_clicable4->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable4=$req_salle_clicable4->fetchAll();
	
foreach ($res_salle_clicable4 as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=6;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
    }
	}
//materiel cliquable pour avoir l'abonement aux fichiers ics


for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
		
	$req_materiel_clicable4->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable4=$req_materiel_clicable4->fetchAll();
	
foreach ($res_materiel_clicable4 as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=6;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	for ($day=0;$day<$days;$day++)
		{
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=($day+1)*$topheight+((($hauteur-$topheight)*$nbressource/$days)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/$days)/$nbressource)/2+$day*(($hauteur-$topheight)*$nbressource/$days)+$box_lenght/2;
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
    }
	}	
	
}



// etudiant, prof et salle clicable dans la zone grise pour abonement fichier ics
//vue jour J

 if (count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi)>='1' && $horizon=='3'  )

{
//calibrage par rapport à l'image
//largeur des bandes grises. 
$leftwidth=50;
$topheight=40;

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

// calcul du nb de ressources
$nbressource=count($salles_multi)+count($profs_multi)+count($groupes_multi)+count($materiels_multi);
$nbdegroupe=count($groupes_multi);
$nbdeprof=count($profs_multi);
$nbdesalle=count($salles_multi);
$nbdemateriel=count($materiels_multi);
//définition de la font
putenv('GDFONTPATH=' . realpath('.').'/fonts/');

// Nom de la police à utiliser
$font = "verdana.ttf";
$fontb = "verdanab.ttf";

echo '<map name="plan1">';

//preparation des requetes pour les boucles suivantes
	$sql="SELECT * FROM ressources_groupes WHERE deleted='0' and codeGroupe=:current_student";
	$req_groupe_clicable5=$dbh->prepare($sql);	
	$sql="SELECT * FROM ressources_profs WHERE codeProf=:profs_multi AND deleted= '0'";
	$req_prof_clicable5=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_salles WHERE codeSalle=:current_salle AND deleted= '0'";
	$req_salle_clicable5=$dbh->prepare($sql);
	$sql="SELECT * FROM ressources_materiels WHERE codeMateriel=:current_materiel AND deleted= '0'";
	$req_materiel_clicable5=$dbh->prepare($sql);
// etudiant cliquable  pour avoir l'abonement aux fichiers ics
for ($i=0; $i<count($groupes_multi); $i++)
	{

	$current_student=$groupes_multi[$i];
	$req_groupe_clicable5->execute(array(':current_student'=>$current_student));
	$res_groupe_clicable5=$req_groupe_clicable5->fetchAll();
	
	

	$policegroupe=6;
foreach ($res_groupe_clicable5 as $res)

	{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);
	$size=imagettfbbox ($policegroupe , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	
	
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+$box_lenght/2;
		echo '<area title="" alt="ics etudiant" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_etudiant.$nomfichier.'">';
			
	}
}


// prof cliquable pour avoir l'abonement aux fichiers ics

for ($i=0; $i<count($profs_multi); $i++)
	{
	//nom du fichier ics	

	
	$req_prof_clicable5->execute(array(':profs_multi'=>$profs_multi[$i]));
	$res_prof_clicable5=$req_prof_clicable5->fetchAll();
	
	$policeprof=6;
foreach ($res_prof_clicable5  as $res)
		{
		$nomfichier=$res['nom']."_".$res['prenom'].".ics";
		$nomfichier=str_replace(" ","_",$nomfichier);
		$nomfichier=strtolower($nomfichier);
		$size=imagettfbbox ($policeprof , 0, $font, $res['nom']);
		$box_lenght=$size[2]-$size[0];
		$box_width=$size[1]-$size[7];
		

		
		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+$box_lenght/2;
			echo '<area title="" alt="ics prof" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_prof.$nomfichier.'">';
				
		}	
	}
	
//salle cliquable pour avoir l'abonement aux fichiers ics


for ($i=0; $i<count($salles_multi); $i++)
	{
	$current_salle=$salles_multi[$i];
		
	//nom du fichier ics
														
	
	$req_salle_clicable5->execute(array(':current_salle'=>$current_salle));
	$res_salle_clicable5=$req_salle_clicable5->fetchAll();
	
	foreach ($res_salle_clicable5  as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policesalle=6;
	$size=imagettfbbox ($policesalle , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	

		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+$box_lenght/2;
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_salle.$nomfichier.'">';	
		}
    }
//materiel cliquable pour avoir l'abonement aux fichiers ics


for ($i=0; $i<count($materiels_multi); $i++)
	{
	$current_materiel=$materiels_multi[$i];
		
	//nom du fichier ics
														
	
	$req_materiel_clicable5->execute(array(':current_materiel'=>$current_materiel));
	$res_materiel_clicable5=$req_materiel_clicable5->fetchAll();
	
	foreach ($res_materiel_clicable5  as $res)
{
	$nomfichier=$res['nom'].".ics";
	$nomfichier=str_replace(" ","_",$nomfichier);
	$nomfichier=strtolower($nomfichier);

	$policemateriel=6;
	$size=imagettfbbox ($policemateriel , 0, $font, $res['nom']);
	$box_lenght=$size[2]-$size[0];
	$box_width=$size[1]-$size[7];
	

		//coordonnees de la zone clicable
		$xhautgauche=3*$leftwidth/4+$box_width/2-6;
		$yhautgauche=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2-$box_lenght/2;
		$xbasdroit=3*$leftwidth/4+$box_width/2;
		$ybasdroit=$topheight+((($hauteur-$topheight)*$nbressource/5)/$nbressource)*($i+$nbdegroupe+$nbdeprof+$nbdesalle+1)-((($hauteur-$topheight)*$nbressource/5)/$nbressource)/2+$box_lenght/2;
			
				echo '<area title="" alt="ics salle" shape="rect" coords="'.$xhautgauche.','.$yhautgauche.' ,'.$xbasdroit.' ,'.$ybasdroit.'" href="'.$url_ics_materiel.$nomfichier.'">';	
		}
    }		
		
}

/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*  SEANCES DES GROUPES CLICABLES POUR OBTENIR LE DETAIL DU MODULE           */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

 if (isset($_SESSION['logged_prof_perso']))
{
if (isset($_SESSION['seance_clicable']) )
{
if ($_SESSION['seance_clicable']!='0' )
{

//pour chaque bdd

$dbh=null;
	for ($k=0;$k<=$nbdebdd-1;$k++)
	{
	$base_a_utiliser=$base[$k];
	//print_r($base_a_utiliser);
		try
		{
		$dbh=new PDO("mysql:host=$serveur;dbname=$base_a_utiliser;",$user,$pass);
		}

		catch(PDOException $e)
		{
		die("erreur ! : " .$e->getMessage());
		}
//preparation requete pour la boucle qui suit
$sql="SELECT * FROM hierarchies_groupes WHERE codeRessourceFille=:groupeaafficher AND deleted= '0'";
$req_groupes_de_niveau_supbis=$dbh->prepare($sql);

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom ";
$req_profs=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 order by ressources_salles.nom";
$req_salles=$dbh->prepare($sql);

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type=$dbh->prepare($sql);	

for ($i=0; $i<count($groupes_multi); $i++)
	{
	$groupeaafficher=$groupes_multi[$i];
	$critere="AND (";
	$stop=0;
	while ($stop!=1 )
		{
		$req_groupes_de_niveau_supbis->execute(array(':groupeaafficher'=>$groupeaafficher));
		$res_groupes_de_niveau_supbis=$req_groupes_de_niveau_supbis->fetchAll();

				$critere .= "seances_groupes.codeRessource='".$groupeaafficher."' OR ";
				if (count($res_groupes_de_niveau_supbis)>0)
				{
				$groupeaafficher=$res_groupes_de_niveau_supbis['0']['codeRessource'];
				}
				else 
					{
					$stop=1;
					}
			
		
		}

	$critere .= "0)";

// Pour les 5 ou 6 jours à afficher, on interroge la DB
if ($horizon!='2' && $horizon!='3') //si pas vue mensuelle et pas jour j
{

for ($day=0;$day<$days;$day++)
	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));
	unset($req_seance);
	$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND seances_profs.deleted=0 AND enseignements.deleted='0' ";
	$req_seance=$dbh->prepare($sql);	
	$req_seance->execute(array(':current_day'=>$current_day));
	$res_seances=$req_seance->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
$info_bulle="";
	

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}
		
	
		
		
			$info_bulle.=" / ";

		}
	}
		
				

		
		























		// On convertit l'horaire en %age de la journée



		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
				 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];		
$lien.="&annee_scolaire=".$k;


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
		if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

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
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

			//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}


					


//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )   ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

	
	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}
		

	}	
















//si vue horizontale
if ($horizon=='1')
{
	// On calcule les coordonnées du rectangle :

		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +($i*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche
		
	
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
	
}

	

if ($horizon=='0')
{	
//vue verticale mono ressource
if ((count($groupes_multi)+count($salles_multi)+count($profs_multi)+count($materiels_multi))==1)
{
		$topy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * $day +($i*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * ($day + 1)-($nbressource-($i+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
		
	
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
	
}
else
{	


		
//Vue verticale multiressources
		$topy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days) +($i*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource ; 
		$bottomy = ($day+1)*$topheight + ($day + 1)*round((($hauteur - $topheight)*$nbressource) / $days) -($nbressource-($i+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource; 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
}
}

		}
		
		
		
	}	
if ($horizon=='3') //si jour j
{

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
$current_day=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
		unset($req_seance);
		$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances.dateSeance=:current_day AND seances.deleted=0 ".$critere." AND seances_groupes.deleted=0 AND seances_profs.deleted=0 AND enseignements.deleted='0' ";
		$req_seance=$dbh->prepare($sql);	
		$req_seance->execute(array(':current_day'=>$current_day));
		$res_seances=$req_seance->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
//recherche s'il y a des conflits
		
$info_bulle="";
//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
			//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}


		
		
			$info_bulle.=" / ";

		}
	}
		
		
		
		
		
		
		
		
		
		// On convertit l'horaire en %age de la journée
		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
						 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;		
		

	



		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

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
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}
		

//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_groupes LEFT JOIN (seances) ON (seances_groupes.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )   ".$critere." AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_groupes.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

	
	//noms profs
	unset ($res_profs3);
	$req_profs->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
			//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}
	

	}	



		
		
		$topy = round($topheight  +($i*(($hauteur - $topheight)*$nbressource) / 5)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / 5 -($nbressource-($i+1))*(($hauteur - $topheight)*$nbressource / 5)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
		
		}
		
}
}		
}			
		
/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*  SEANCES DES PROFS CLICABLES POUR OBTENIR LE DETAIL DU MODULE           */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

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
		
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND enseignements.deleted='0' AND seances_profs.deleted=0 ";
$req_seance2=$dbh->prepare($sql);		
	
$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted='0' order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles2=$dbh->prepare($sql);	

$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:current_prof";
$req_profs2=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type2=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels2=$dbh->prepare($sql);
	
for ($i=0; $i<count($profs_multi); $i++)

{

$current_prof= $profs_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB
if ($horizon!='2' && $horizon!='3') //si pas vue mensuelle et pas jour j
{

for ($day=0;$day<$days;$day++)
	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));



	// On recherche pour le prof et le jour choisi l'ensemble des séances

$req_seance2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof));
$res_seances=$req_seance2->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
		//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;	
	
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;

}
	
		
		
			$info_bulle.=" / ";

		}
	}
		
				

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		// On convertit l'horaire en %age de la journée



		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
						 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;		
	






		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
	//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;
		
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}

	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
		//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;		
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
			//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;	
}
	}	










	

//si vue horizontale
if ($horizon=='1')
{
	// On calcule les coordonnées du rectangle :

		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-(($i+$nbdegroupe)+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche
				
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}

	

if ($horizon=='0')
{	
//vue verticale mono ressource
if ((count($groupes_multi)+count($salles_multi)+count($profs_multi)+count($materiels_multi))==1)
{
		$topy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * $day +(($i+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
else
{	


		
//Vue verticale multiressources
		$topy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days ) +(($i+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource ; 
		$bottomy = ($day+1)*$topheight + ($day + 1)*round((($hauteur - $topheight)*$nbressource) / $days) -($nbressource-($i+$nbdegroupe+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource; 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
}
}

		}
		
	}	
if ($horizon=='3') //si jour j
{

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
$current_day=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) WHERE seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND enseignements.deleted='0' AND seances_profs.deleted=0 ";
$req_seance2=$dbh->prepare($sql);

$req_seance2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof));
$res_seances=$req_seance2->fetchAll();


		

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{

		
$info_bulle="";		

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
			//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
		}
		
			$info_bulle.=" / ";

		}
	}
		
				

				
		
		
		
		
		
		
		
		
		
		
		// On convertit l'horaire en %age de la journée
		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
						 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;		
	
	
	


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

			
		//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;
	
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
}
	
//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_profs LEFT JOIN (seances) ON (seances_profs.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_profs.codeRessource=:current_prof AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_profs.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_prof'=>$current_prof,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type2->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type2->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes3->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	//noms profs 	
 

$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll(); 
$nbprofs=0; 
unset($profs); 
$profs=" - "; 
	foreach ($res_profs3 as $res_profs)  
		{ 		
		if ($nbprofs>0) 
			{ 
			$profs.=", "; 
			} 				
		$nbprofs++; 
		if ($res_profs['nom']!="")  				
		{ 				
		$profs.=$res_profs['nom']; 	
		}  	
		} 
$info_bulle.=$profs;			
			
			
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles2->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels2->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels2->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;		
}
	}	






	
		
		$topy = round($topheight  +(($i+$nbdegroupe)*(($hauteur - $topheight)*$nbressource) / 5)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / 5 -($nbressource-($i+$nbdegroupe+1))*(($hauteur - $topheight)*$nbressource / 5)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
				
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
		
		}
			
}
}		
}		
		
		
		
/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*  SEANCES DES SALLES CLICABLES POUR OBTENIR LE DETAIL DU MODULE           */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

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
		
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_salles.deleted=0 ";
$req_seance3=$dbh->prepare($sql);	
		
$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs3=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type3=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_materiels LEFT JOIN ressources_materiels ON (ressources_materiels.codeMAteriel=seances_materiels.codeRessource) WHERE codeSeance=:codeSeance AND seances_materiels.deleted=0 order by ressources_materiels.nom";
$req_materiels3=$dbh->prepare($sql);


		
for ($i=0; $i<count($salles_multi); $i++)

{

$current_salle= $salles_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB
if ($horizon!='2' && $horizon!='3') //si pas vue mensuelle et pas jour j
{

for ($day=0;$day<$days;$day++)
	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));




	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance3->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle));
$res_seances=$req_seance3->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
$info_bulle="";

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	
		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}


	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	

		
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
	

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
		}
			$info_bulle.=" / ";

		}
	}
		
















		// On convertit l'horaire en %age de la journée



		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;	







		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
		if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//  On affiche les profs concernés
		$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_prof=$req_profs3->fetchAll();	
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
	
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
		}


//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	
	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
				
}
			}
			
	
	
		

		







	

//si vue horizontale
if ($horizon=='1')
{
	// On calcule les coordonnées du rectangle :

		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}

	

if ($horizon=='0')
{	
//vue verticale mono ressource
if ((count($groupes_multi)+count($salles_multi)+count($profs_multi)+count($materiels_multi)+count($materiels_multi))==1)
{
		$topy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
else
{	


		
//Vue verticale multiressources
		$topy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days) +(($i+$nbdegroupe+$nbdeprof)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource ; 
		$bottomy = ($day+1)*$topheight + ($day + 1)*round((($hauteur - $topheight)*$nbressource) / $days) -($nbressource-($i+$nbdegroupe+$nbdeprof+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource; 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
}
}

		}
			
	}	
if ($horizon=='3') //si jour j
{

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
$current_day=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_salles.deleted=0 ";
$req_seance3=$dbh->prepare($sql);

$req_seance3->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle));
$res_seances=$req_seance3->fetchAll();


		

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
//recherche s'il y a des conflits
		
$info_bulle="";
//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	
		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}


	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	

		
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
			
		}
		
			$info_bulle.=" / ";

		}
	}
		


		
		
		
		
		
		
		
		
		
		
		
		// On convertit l'horaire en %age de la journée
		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];
$lien.="&annee_scolaire=".$k;					
	


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//  On affiche les profs concernés
		$req_profs3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_prof=$req_profs3->fetchAll();	
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
	//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
	

		$req_materiels3->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
	}		

//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_salles LEFT JOIN (seances) ON (seances_salles.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_salles.codeRessource=:current_salle AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_salles.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_salle'=>$current_salle,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes4->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	
	//noms profs
	unset ($res_profs3);
	$req_profs3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs3->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les materiels
		$nbmateriels=0;
		unset($materiels);
		

		$req_materiels3->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_materiel=$req_materiels3->fetchAll();
				if (count($res_materiel)>=1)
		{
		$materiels=" - ";
		foreach ($res_materiel as $res_materiels)
			{
			if ($nbmateriels>0)
				{
				$materiels.=", ";
				}
			$nbmateriels++;
	if ($nom_materiel_afficher_alias==1)
	{
	$materiels .= substr($res_materiels['alias'],0,$nb_caractere_materiel_pour_vue_prof);
	}
	else
	{
	$materiels .= substr($res_materiels['nom'],0,$nb_caractere_materiel_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "materiel" devant la liste des materiels
			if ($affichage_mot_materiel_pour_prof=='1')
				{
				 if ($nbmateriels==1)
					 {
					 $materiels="Materiel : ".$materiels;
					 }
				  
				 if($nbmateriels>1)
					 {
					 $materiels="Materiels : ".$materiels;
					 }
				}

$info_bulle.=$materiels;
	}			

			}	
	
	
	
	
	
	

	
		
		
		$topy = round($topheight  +(($i+$nbdegroupe+$nbdeprof)*(($hauteur - $topheight)*$nbressource) / 5)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / 5 -($nbressource-($i+$nbdegroupe+$nbdeprof+1))*(($hauteur - $topheight)*$nbressource / 5)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
				
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
		
		}

}
}		
}		
		


/*****************************************************************************/

/*                                                                           */

/*                                                                           */

/*  SEANCES DES MATERIELS CLICABLES POUR OBTENIR LE DETAIL DU MODULE           */

/*                                                                           */

/*                                                                           */

/*****************************************************************************/

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
		
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_materiels.deleted=0 ";
$req_seance4=$dbh->prepare($sql);	
		
$sql="SELECT * FROM seances_groupes LEFT JOIN ressources_groupes ON (ressources_groupes.codeGroupe=seances_groupes.codeRessource) WHERE codeSeance=:codeSeance AND seances_groupes.deleted=0 order by ressources_groupes.nom";
$req_groupes5=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_profs LEFT JOIN ressources_profs ON (ressources_profs.codeProf=seances_profs.codeRessource) WHERE codeSeance=:codeSeance AND seances_profs.deleted=0 AND ressources_profs.deleted=0 order by ressources_profs.nom";
$req_profs4=$dbh->prepare($sql);

$sql="SELECT * FROM types_activites WHERE codeTypeActivite=:type_activite" ;
$req_type4=$dbh->prepare($sql);	

$sql="SELECT * FROM seances_salles LEFT JOIN ressources_salles ON (ressources_salles.codeSalle=seances_salles.codeRessource) WHERE codeSeance=:codeSeance AND seances_salles.deleted=0 AND ressources_salles.deleted=0 order by ressources_salles.nom";
$req_salles4=$dbh->prepare($sql);	



		
for ($i=0; $i<count($materiels_multi); $i++)

{

$current_materiel= $materiels_multi[$i];


// Pour les 5 ou 6 jours à afficher, on interroge la DB
if ($horizon!='2' && $horizon!='3') //si pas vue mensuelle et pas jour j
{

for ($day=0;$day<$days;$day++)
	{
    $current_day=date('Y-m-d',(strtotime("+".$day." days",$lundi)));




	// On recherche pour la salle et le jour choisi l'ensemble des séances
$req_seance4->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel));
$res_seances=$req_seance4->fetchAll();

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
$info_bulle="";

//recherche s'il y a des conflits
		

//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type3->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type3->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	
		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}


	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	

		
	
	//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		
			$info_bulle.=" / ";

		}
	}
		
















		// On convertit l'horaire en %age de la journée



		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		 for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];					
$lien.="&annee_scolaire=".$k;	







		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
		if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//  On affiche les profs concernés
		$req_profs4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_prof=$req_profs4->fetchAll();	
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

		$req_salles4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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


//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	
	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

			}
			
	
	
		

		







	

//si vue horizontale
if ($horizon=='1')
{
	// On calcule les coordonnées du rectangle :

		$leftx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(($largeur - $leftwidth)*$nbressource) / $days)/$nbressource  ); // Coté gauche
		$rightx = round($leftwidth + (($largeur - $leftwidth)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+$nbdesalle+1))*(($largeur - $leftwidth)*$nbressource / $days)/$nbressource); // Coté droit
		$topy = $start_time * ($hauteur - $topheight) + $topheight; // Haut
		$bottomy = ($start_time + $duree) * ($hauteur - $topheight) + $topheight; // Coté gauche
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}

	

if ($horizon=='0')
{	
//vue verticale mono ressource
if ((count($groupes_multi)+count($salles_multi)+count($profs_multi)+count($materiels_multi))==1)
{
		$topy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * $day +(($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / $days * ($day + 1)-($nbressource-($i+$nbdegroupe+$nbdeprof+$nbdesalle+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
else
{	


		
//Vue verticale multiressources
		$topy = ($day+1)*$topheight + $day*round((($hauteur - $topheight)*$nbressource) / $days) +(($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(($hauteur - $topheight)*$nbressource) / $days)/$nbressource ; 
		$bottomy = ($day+1)*$topheight + ($day + 1)*round((($hauteur - $topheight)*$nbressource) / $days) -($nbressource-($i+$nbdegroupe+$nbdeprof+$nbdesalle+1))*(($hauteur - $topheight)*$nbressource / $days)/$nbressource; 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
			
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
}
}
}

		}
			
	}	
if ($horizon=='3') //si jour j
{

if (isset ($_GET['jour']))
{
$jour=$_GET['jour'];
}
else 
{
$jour=0;
}
$current_day=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$jour, date("Y")));
//preparation des requetes
$sql="SELECT *, seances.dureeSeance, seances.commentaire,enseignements.nom as nom_enseignement, enseignements.alias as alias_enseignement,seances_profs.codeRessource as code_prof FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) RIGHT JOIN (enseignements) ON (seances.codeEnseignement=enseignements.codeEnseignement) RIGHT JOIN (seances_profs) ON (seances_profs.codeSeance=seances.codeSeance) WHERE seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0 AND enseignements.deleted='0'  AND seances_materiels.deleted=0 ";
$req_seance4=$dbh->prepare($sql);

$req_seance4->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel));
$res_seances=$req_seance4->fetchAll();


		

		

	// Pour chaque séance
		foreach($res_seances as $res_seance)
		{
//recherche s'il y a des conflits
		
$info_bulle="";
//cas 1 (seance qui chevauche l'heure de début)
unset($req_seance_conflit1);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance as durSea FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance) left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and seances.heureSeance<=:h_debut  and  seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance";
$req_seance_conflit1=$dbh->prepare($sql);
$req_seance_conflit1->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':h_debut'=>$res_seance['heureSeance'], ':code_seance'=>$res_seance['codeSeance']));

$res_seances_conflit1=$req_seance_conflit1->fetchAll();
foreach($res_seances_conflit1 as $res_seance_conflit1)
	{
	$horaire_debut = substr((100+substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit1['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit1['heureSeance'],-strlen($res_seance_conflit1['heureSeance']),strlen($res_seance_conflit1['heureSeance'])-2)+substr($res_seance_conflit1['heureSeance'],-2,2)/60) + (substr($res_seance_conflit1['durSea'],-strlen($res_seance_conflit1['durSea']),strlen($res_seance_conflit1['durSea'])-2)+substr($res_seance_conflit1['durSea'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);		

	if ($horaire_fin>$res_seance['heureSeance'])
		{


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit1['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit1['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit1['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit1['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	
		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}


	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;	

		
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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
		
		
			$info_bulle.=" / ";

		}
	}
		


		
		
		
		
		
		
		
		
		
		
		
		// On convertit l'horaire en %age de la journée
		/* Explication conversion :
		On extrait d'une part les minutes et d'autre part l'heure.
		On transforme les minutes en fraction d'heure.
		On enlève starttime et on divise par la durée de la journée affichée endtime-starttime.
		On obtient un %age correspondant à la position du début du cours.
		Idem pour la durée mais sans enlever 8.15

		*/

		$start_time=((substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60)-$starttime)/($endtime-$starttime+0.25);
		$duree=((substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60))/($endtime-$starttime+0.25);
		$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
		$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
		$horaire_fin = substr(intval($horaire_fin + 100),-2,2)."h".substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);

		
//creation du lien		
		//nom de l'enseignement:
		$enseignement_explode=explode("_",$res_seance['nom_enseignement']);
	    $nom_enseignement=$enseignement_explode[0]."_".$enseignement_explode[1];
		$lien="module.php?&lar=".$lar."&hau=".$hau."&selec_prof=".$selec_prof."&selec_groupe=".$selec_groupe."&selec_salle=".$selec_salle.'&selec_materiel='.$selec_materiel."&current_week=".$current_week."&current_year=".$current_year."&horiz=".$horizon;
			
		for ($j=0; $j<count($groupes_multi); $j++)
		{ 
		$lien.="&groupes_multi[]=".$groupes_multi[$j];
		}
		 for ($j=0; $j<count($salles_multi); $j++)
		{
		$lien.="&salles_multi[]=".$salles_multi[$j];		
		}
		 for ($j=0; $j<count($profs_multi); $j++)
		{ 
		$lien.="&profs_multi[]=".$profs_multi[$j];
		}
		for ($j=0; $j<count($materiels_multi); $j++)
		{ 
		$lien.="&materiels_multi[]=".$materiels_multi[$j];
		}
$lien.=	"&selec_prof2=TOUS";
$lien.=	"&selec_module=".$nom_enseignement;
$lien.="&jour=".$jour;
$lien.="&prof=".$res_seance['code_prof'];	
$lien.="&premier_lancement=0&prof_precedent=".$res_seance['code_prof'];
$lien.="&code_seance=".$res_seance['codeSeance'];
$lien.="&annee_scolaire=".$k;					
	


		//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".$horaire_fin." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

		//  On affiche les profs concernés
		$req_profs4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_prof=$req_profs4->fetchAll();	
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

		$req_salles4->execute(array(':codeSeance'=>$res_seance['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

//recherche s'il y a des conflits
//cas 2 (seance qui chevauche l'heure de fin)
unset($req_seance_conflit2);
//mise en forme de l'heure de fin en faisant l'adition heure de debut plus durée.
$horaire_debut = substr((100+substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)),-2,2)."h".substr($res_seance['heureSeance'],-2,2);
$horaire_fin = (substr($res_seance['heureSeance'],-strlen($res_seance['heureSeance']),strlen($res_seance['heureSeance'])-2)+substr($res_seance['heureSeance'],-2,2)/60) + (substr($res_seance['dureeSeance'],-strlen($res_seance['dureeSeance']),strlen($res_seance['dureeSeance'])-2)+substr($res_seance['dureeSeance'],-2,2)/60);
$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);
$sql="SELECT *,enseignements.alias as alias_enseignement,enseignements.nom as nom_enseignement, seances.dureeSeance, seances.commentaire FROM seances_materiels LEFT JOIN (seances) ON (seances_materiels.codeSeance=seances.codeSeance)   left join enseignements on enseignements.codeEnseignement=seances.codeEnseignement  WHERE  enseignements.deleted=0 and   (seances.heureSeance>:heure_debut  AND seances.heureSeance<:heure_fin )  and seances_materiels.codeRessource=:current_materiel AND seances.dateSeance=:current_day AND seances.deleted=0  AND seances_materiels.deleted=0  AND seances.codeSeance!=:code_seance order by seances.heureSeance ";	
$req_seance_conflit2=$dbh->prepare($sql);
$req_seance_conflit2->execute(array(':current_day'=>$current_day, ':current_materiel'=>$current_materiel,  ':heure_debut'=>$res_seance['heureSeance'], ':heure_fin'=>$horaire_fin, ':code_seance'=>$res_seance['codeSeance']));


$res_seances_conflit2=$req_seance_conflit2->fetchAll();
foreach($res_seances_conflit2 as $res_seance_conflit2)
	{
	$info_bulle.=" / ";
	$horaire_debut = substr((100+substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)),-2,2)."h".substr($res_seance_conflit2['heureSeance'],-2,2);
	$horaire_fin = (substr($res_seance_conflit2['heureSeance'],-strlen($res_seance_conflit2['heureSeance']),strlen($res_seance_conflit2['heureSeance'])-2)+substr($res_seance_conflit2['heureSeance'],-2,2)/60) + (substr($res_seance_conflit2['dureeSeance'],-strlen($res_seance_conflit2['dureeSeance']),strlen($res_seance_conflit2['dureeSeance'])-2)+substr($res_seance_conflit2['dureeSeance'],-2,2)/60);
	$horaire_fin = substr(intval($horaire_fin + 100),-2,2).substr(($horaire_fin-intval($horaire_fin))*60+100,-2,2);			
			//on affiche le nom de la seance
//découpage du nom de l'enseignement afin de récupérer ce qu'il y a entre les 2 premiers _
	if ($nom_enseignement_afficher_alias==1)
{
$cursename=explode("_",$res_seance_conflit2['alias_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['alias_enseignement'];
}
}
else
{
$cursename=explode("_",$res_seance_conflit2['nom_enseignement']);
if (!isset($cursename[1]))
{
$cursename[1]=$res_seance_conflit2['nom_enseignement'];
}
}
		
		$nom_de_la_seance=$cursename[1];
		$info_bulle.=$horaire_debut."-".substr($horaire_fin,0,-2)."h".substr($horaire_fin,-2)." - ".$nom_de_la_seance." - ";



//affichage du type (CM TD TP)
$req_type4->execute(array(':type_activite'=>$res_seance_conflit2['codeTypeActivite']));
$res_types=$req_type4->fetchAll();	

foreach($res_types as $res_type)
	{
	$text = $res_type['alias'];
	}
$info_bulle.=$text;

//  On affiche les commentaires sur la seance

$comm=str_replace(array('à', 'â', 'ä', 'á', 'ã', 'å','î', 'ï', 'ì', 'í', 'ô', 'ö', 'ò', 'ó', 'õ', 'ø','ù', 'û', 'ü', 'ú','é', 'è', 'ê', 'ë','ç', 'ÿ', 'ñ'),array('a', 'a', 'a', 'a', 'a', 'a','i', 'i', 'i', 'i','o', 'o', 'o', 'o', 'o', 'o','u', 'u', 'u', 'u','e', 'e', 'e', 'e','c', 'y', 'n'),$res_seance['commentaire']);

$comm=strtoupper($comm);
if ($comm!="")
	{
	$info_bulle.=" - ".$comm;
	}	

		//  On affiche les groupes concernés
$req_groupes5->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_groupes=$req_groupes5->fetchAll();

	
		if (count($res_groupes)>0)
		{
		$info_bulle.=" - ";
		}
		$compteur_groupe=1;
		foreach ($res_groupes as $res_groupe)
			{

			$info_bulle.=$res_groupe['nom'];
			if(count($res_groupes)>$compteur_groupe)
				{
				$info_bulle.=", ";
				}
			$compteur_groupe+=1;	

			}

	
	//noms profs
	unset ($res_profs3);
	$req_profs4->execute(array(':codeSeance'=>$res_seance_conflit2['codeSeance']));
$res_profs3=$req_profs4->fetchAll();
$nbprofs=0;
unset($profs);
$profs=" - ";
				foreach ($res_profs3 as $res_profs)

			{
			if ($nbprofs>0)
				{
				$profs.=", ";
				}
				$nbprofs++;
			if ($res_profs['nom']!="")

				{
				$profs.=$res_profs['nom'];
				

				}

		}
$info_bulle.=$profs;
	
		//  On affiche les salles
		$nbsalles=0;
		unset($salles);
		$salles=" - ";

		$req_salles4->execute(array(':codeSeance'=>$res_seance_conflit1['codeSeance']));
		$res_salle=$req_salles4->fetchAll();
		foreach ($res_salle as $res_salles)
			{
			if ($nbsalles>0)
				{
				$salles.=", ";
				}
			$nbsalles++;
	if ($nom_salle_afficher_alias==1)
	{
	$salles .= substr($res_salles['alias'],0,$nb_caractere_salle_pour_vue_prof);
	}
	else
	{
	$salles .= substr($res_salles['nom'],0,$nb_caractere_salle_pour_vue_prof);
	}	
			

			}
			
			//affichage du mot "salle" devant la liste des salles
			if ($affichage_mot_salle_pour_prof=='1')
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

			}	
	
	
	
	
	
	

	
		
		
		$topy = round($topheight  +(($i+$nbdegroupe+$nbdeprof+$nbdesalle)*(($hauteur - $topheight)*$nbressource) / 5)/$nbressource  ); 
		$bottomy = round($topheight + (($hauteur - $topheight)*$nbressource) / 5 -($nbressource-($i+$nbdegroupe+$nbdeprof+$nbdesalle+1))*(($hauteur - $topheight)*$nbressource / 5)/$nbressource); 
		$leftx = round($start_time * ($largeur - $leftwidth) + $leftwidth); 
		$rightx = round(($start_time + $duree) * ($largeur - $leftwidth) + $leftwidth); 
				
		$seance_clicable_area.='<area title="'.$info_bulle.'" alt="module" shape="rect" coords="'.$leftx.','.$topy.','.$rightx.','.$bottomy.'" '.'href="'.$lien.'">';
		
		
		}

}
}		
}	



















		
}
}
}

//Fermeture de la balise MAP si l'utilisateur ne visualise pas sont edt perso et si loggin perso car sinon, elle n'est pas fermée. Si login générique, elle est fermée dans le fichier index.php
		//on teste si le prof a son edt d'affiché. (pas affiché-->$ok=0)
		
		$ok='0';
for ($i=0; $i<count($profs_multi); $i++)
	{
	if (isset($_SESSION['logged_prof_perso']))
	{
if ($_SESSION['logged_prof_perso']==$profs_multi[$i] && $_SESSION['reservation']!='0' )
			{
			$ok='1';
			$codeprof=$profs_multi[$i];
			break;
			}
		else
			{
			$ok='0';
			}
			
	}
	}
		
		
	
			if (isset($ok) && isset($_SESSION['logged_prof_perso']))
				{
				if ($ok==0)
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
				}
		


