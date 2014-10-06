<div id="topbar" style="margin-bottom:5px">
	<table width="100%"  >
		<tr>
			<td width="33%" style="text-align: left;">
			<?php

				$sql="SELECT * FROM ressources_etudiants WHERE codeEtudiant=:current_student AND deleted='0'";
				$req_nom_etudiant=$dbh->prepare($sql);
				$req_nom_etudiant->execute(array(':current_student'=>$current_student));
				$ressource_nom_etudiant=$req_nom_etudiant->fetchAll();
				foreach ($ressource_nom_etudiant as $ressource_nom_de_etudiant)
					{
						if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])
							{
							?>
							<img alt="etudiant" src="etudiant.png" height="20px"/> <?php echo ucwords(strtolower($ressource_nom_de_etudiant['prenom']))." ".$ressource_nom_de_etudiant['nom'];?>
							<?php
							}
						else
							{
							?>
							<img alt="etudiant" src="etudiant.png" height="20px"/> <?php echo $ressource_nom_de_etudiant['nom'];?>
							<?php
							}
					
					
					}
	

			?>
				
			</td>
			<td width="33%" style="text-align: center;">

				<img alt="vt_agenda" src="vt_agenda.png" height="20px"  border="none"/>  &raquo; <?php 
				if (isset($_GET['horiz']))
					{
					if ($_GET['horiz']==0)
						{
						echo "Vue hebdomadaire verticale";
						}
					elseif ($_GET['horiz']==1)
						{
						echo "Vue hebdomadaire horizontale";
						}
					elseif ($_GET['horiz']==2)
						{
						echo "Vue mensuelle réduite";
						}
					elseif ($_GET['horiz']==3)
						{
						echo "Vue jour J";
						}
					elseif ($_GET['horiz']==4)
						{
						echo "Vue mensuelle";
						}						
					}
				else
					{				
					echo "Vue hebdomadaire verticale";
					}
				?>
			</td>
<td style="text-align: right;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
			








	<script type="text/javascript">
function submitform_pdf()
{
document.pdf.onsubmit();
document.pdf.submit();
}
</script> 

<script type="text/javascript">
function submitform_pdf2()
{
document.pdf2.onsubmit();
document.pdf2.submit();
}
</script> 
	<script type="text/javascript">
function submitform_pdf3()
{
document.pdf3.onsubmit();
document.pdf3.submit();
}
</script> 

<script type="text/javascript">
function submitform_pdf4()
{
document.pdf4.onsubmit();
document.pdf4.submit();
}
</script> 
<script type="text/javascript">
function submitform_module()
{
document.module.onsubmit();
document.module.submit();
}
</script> 

<script type="text/javascript">
function submitform_module2()
{
document.module2.onsubmit();
document.module2.submit();
}
</script> 
<script type="text/javascript">
function submitform_module3()
{
document.module3.onsubmit();
document.module3.submit();
}
</script> 

<script type="text/javascript">
function submitform_module4()
{
document.module4.onsubmit();
document.module4.submit();
}
</script> 

<script type="text/javascript">
function submitform_ds()
{
document.ds.onsubmit();
document.ds.submit();
}
</script> 

<script type="text/javascript">
function submitform_ds2()
{
document.ds2.onsubmit();
document.ds2.submit();
}
</script> 
<script type="text/javascript">
function submitform_ds3()
{
document.ds3.onsubmit();
document.ds3.submit();
}
</script> 

<script type="text/javascript">
function submitform_ds4()
{
document.ds4.onsubmit();
document.ds4.submit();
}
</script> 




<ul id="menu">
	
	<li style="height:23px;margin-top:0px"><a href="#"><img alt="menu" src="menu.png" height="25px"  border="none" /> Outils</a>
		<ul>



		
		<?php


//bouton "Export PDF..." 

				foreach ($ressource_nom_etudiant as $ressource_nom_de_etudiant)
					{
 if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])

	{
	
	?>

		<!--[if  IE]>
<li><a href="javascript:submitform_pdf()"><img alt="pdf" src="pdf.png" height="25px"  border="none"/> Export PDF</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_pdf2()"><img alt="pdf" src="pdf.png" height="25px"  border="none"/> Export PDF</a></li>	
<!--<![endif]-->

<?php
	}
	else
		{
	?>

		<!--[if  IE]>
<li><a href="javascript:submitform_pdf3()"><img alt="pdf" src="pdf.png" height="25px"  border="none"/> Export PDF</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_pdf4()"><img alt="pdf" src="pdf.png" height="25px"  border="none"/> Export PDF</a></li>	
<!--<![endif]-->

<?php
	}

 if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])

	{
	
	?>


		<!--[if  IE]>
<li><a href="javascript:submitform_ds()"><img alt="mes_ds" src="mes_ds.png" height="25px"  border="none"/> Mes DS</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_ds2()"><img alt="mes_ds" src="mes_ds.png" height="25px"  border="none"/> Mes DS</a></li>	
<!--<![endif]-->
<?php
}
else
{
?>

		<!--[if  IE]>
<li><a href="javascript:submitform_ds3()"><img alt="mes_ds" src="mes_ds.png" height="25px"  border="none"/> Mes DS</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_ds4()"><img alt="mes_ds" src="mes_ds.png" height="25px"  border="none"/> Mes DS</a></li>	
<!--<![endif]-->

<?php
}	
	
	
	
	
	
	
				
 if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])

	{
	
	?>


		<!--[if  IE]>
<li><a href="javascript:submitform_module()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none"/> Mes modules</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_module2()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none"/> Mes modules</a></li>	
<!--<![endif]-->
<?php
}
else
{
?>

		<!--[if  IE]>
<li><a href="javascript:submitform_module3()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none"/> Mes modules</a></li>	  
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_module4()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none"/> Mes modules</a></li>	
<!--<![endif]-->

<?php
}	
	
	
//flux RSS

echo '<li><a href="RSSetudiant/rss.php?codeEtudiant='.$current_student.'"><img alt="" src="RSS/rss.png" height="25px" style="border:none;"> Flux RSS</a></li>';

// Abonnement ics
  if ($ressource_nom_de_etudiant['nom']!=$ressource_nom_de_etudiant['prenom'])

	{

	$nomfichier=$ressource_nom_de_etudiant['nom']."_".$ressource_nom_de_etudiant['prenom'].".ics";

	$nomfichier=str_replace(" ","_",$nomfichier);

	$nomfichier=strtolower($nomfichier);

	

	echo '<li><a href="'.$url_ics_etudiant.$nomfichier.'"><img alt="" src="ical.png" height="25px" style="border:none;"> Agenda électronique</a></li>';
	
	}
	else
		{

	$nomfichier=$ressource_nom_de_etudiant['identifiant'].".ics";

	$nomfichier=str_replace(" ","_",$nomfichier);

	$nomfichier=strtolower($nomfichier);



	

	echo '<li><a href="'.$url_ics_etudiant.$nomfichier.'"><img alt="" src="ical.png" height="25px" style="border:none;"> Agenda électronique</a></li>';
	
	}
}	


		
					
?>			
		</ul>
	</li>
	
	
	
</ul>
		

			</td>
		
			<td style="text-align: right;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
				<a href="index.php?disconnect=true" style="font-size:8pt"> D&eacute;connexion <img alt="porte" src="porte.png" height="20px"  border="none"/></a>
			</td>
		</tr>
	</table>
</div>