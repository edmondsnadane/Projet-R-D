<div id="topbar" style="margin-bottom:5px">
	<table width="100%"  style="border:0px black solid;margin:0px;border-collapse:separate;" >
		<tr style="text-align:left;border:0px black solid;">
			<td width="20%" style="text-align: left;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
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
							<img  alt="etudiant" src="etudiant.png" height="20px"/> <?php echo ucwords(strtolower($ressource_nom_de_etudiant['prenom']))." ".$ressource_nom_de_etudiant['nom'];?>
							<?php
							}
						else
							{
							?>
							<img  alt="etudiant" src="etudiant.png" height="20px"/> <?php echo $ressource_nom_de_etudiant['nom'];?>
							<?php
							}
					
					
					}
	

			?>
				
			</td>
						<td width="20%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">

  <a href="javascript:document.form2.submit();"><img alt="retour" src="retour.png" height="20px"  border="none"/>  Retour à l'emploi du temps</a>

				
			</td>
			<td width="20%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">

				<img alt="vt_agenda" src="vt_agenda.png" height="20px"  border="none"/>  &raquo; <?php echo $nom_de_la_fenetre; ?> 
			</td>
			<td width="10%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">

				
			</td>

			
			
			
<?php
if (!(isset($_SESSION['logged_prof_generique']) && (count($groupes_multi)+count($salles_multi)+count($profs_multi)==0)))			
{
?>
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

<ul id="menu">
	
	<li style="height:23px;margin-top:0px"><a href="#"><img alt="menu" src="menu.png" height="25px"  border="none" /> Outils</a>
		<ul>




		
		<?php




				foreach ($ressource_nom_etudiant as $ressource_nom_de_etudiant)
					{
	if ($afficher_mes_modules==1)
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

					
	if ($afficher_mes_ds==1)
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
					
					
					
	//export pdf
	if ($afficher_export_pdf==1)
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
	
}	
	
	
	
	
	
//flux RSS
if ($afficher_flux_rss==1)
{
echo '<li><a href="RSSetudiant/rss.php?codeEtudiant='.$current_student.'"><img alt="" src="RSS/rss.png" height="25px" style="border:none;"> Flux RSS</a></li>';
}


// Abonnement ics
if ($afficher_ics==1)
{

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
	
	
	
}	


		
					
?>			
		</ul>
	</li>
	
	
	
</ul>
		

			</td>
			<?php
			}
			?>			
			
			
			
			<td style="text-align: right;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
				<a href="index.php?disconnect=true" style="font-size:8pt"> D&eacute;connexion <img alt="porte" src="porte.png" height="20px"  border="none"/></a>
			</td>
		</tr>
	</table>
</div>

<?php
	
	//si pas login générique (chaque étudiant a son login perso)
 if ($ressource_nom_de_etudiant['0']['nom']!=$ressource_nom_de_etudiant['0']['prenom'])

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


<!--<![endif]-->



	

	<?php
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

<!--<![endif]-->






	<?php
	}
	?>
<!--[if IE]>

<?php
//bouton "mes modules" 
?>
<form action="module_etudiant.php" name="module" method="get" onsubmit="document.getElementById('screen_wid3').value=document.documentElement.clientWidth;document.getElementById('screen_heig3').value=document.documentElement.clientHeight">

   

	<input type="hidden" name="lar" id="screen_wid3" value="">

	<input type="hidden" name="hau" id="screen_heig3" value="">
	<input type="hidden" name="horiz" id="horiz3" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<![endif]-->


<!--[if !IE]>-->

<?php
//bouton "mes modules..." 
?>
<form action="module_etudiant.php" name="module2" method="get" onsubmit="document.getElementById('screen_wid2').value=window.innerWidth;document.getElementById('screen_heig2').value=window.innerHeight;">

   

	<input type="hidden" name="lar" id="screen_wid2" value="">

	<input type="hidden" name="hau" id="screen_heig2" value="">
	<input type="hidden" name="horiz" id="horiz2" value="<?php echo $horizon; ?>">
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
<input type="hidden" name="jour"  value="<?php echo $jour; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">

	<input type="hidden" name="current_student" value="<?php echo $current_student ?>">	
	
	

</form>

<!--<![endif]-->

<!--[if IE]>

<?php
//bouton "mes DS" 
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
//bouton "mes DS..." 
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

