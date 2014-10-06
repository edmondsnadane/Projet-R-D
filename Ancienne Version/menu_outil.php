<div id="topbar" style="margin-bottom:5px">
	<table width="100%" style="border:0px black solid;margin:0px;border-collapse:separate;" >
		<tr style="text-align: left;border:0px black solid;">
			<td width="20%" style="text-align: left;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
			<?php
			if (isset($_SESSION['logged_prof_perso']))
				{
				$sql="SELECT * FROM ressources_profs WHERE deleted='0' and codeProf=:selec_prof";
				$req_nom_prof=$dbh->prepare($sql);
				$req_nom_prof->execute(array(':selec_prof'=>$_SESSION['logged_prof_perso']));
				$res_nom_prof=$req_nom_prof->fetchAll();
				foreach ($res_nom_prof as $res_nom_du_prof)
					{
					?>
					<img alt="prof" src="prof.gif" height="20px"/> <?php echo ucwords(strtolower($res_nom_du_prof['prenom']))." ".$res_nom_du_prof['nom'];?>
					<?php
					}
				}
			?>
				
			</td>
			<?php
	if (isset($_SESSION['logged_prof_perso']) || (isset($_SESSION['logged_prof_generique']) && $autorisation_pdf==1))
{
if (($_SESSION['configuration']!='0' && $afficher_ma_config==1) || (isset($_SESSION['logged_prof_generique']) && $autorisation_pdf==1))
{
?>		
			<td width="20%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
	
  <a href="javascript:document.form2.submit();"><img alt="retour" src="retour.png" height="20px"  border="none"/>  Retour à l'emploi du temps</a>
				
			</td>
		<?php
}
else
{
?>		
			<td width="20%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
	
  <a href="javascript:document.form1.submit();"><img alt="retour" src="retour.png" height="20px"  border="none"/>  Retour à l'emploi du temps</a>
				
			</td>
		<?php
}

}

?>		
			
			
			
			<td width="20%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">

				<img alt="vt_agenda" src="vt_agenda.png" height="20px"  border="none"/>  &raquo; <?php echo $nom_de_la_fenetre;?>
			</td>
						<td width="10%" style="text-align: center;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">

				
			</td>
<?php
if (!(isset($_SESSION['logged_prof_generique']) && (count($groupes_multi)+count($salles_multi)+count($profs_multi)+count($materiels_multi)==0)))			
{
?>
			<td style="text-align: right;border:0px black solid;padding :0px 10px 0px 10px;font-size:8pt;">
			




<script type="text/javascript">
function submitform_admin()
{
document.admin.onsubmit();
document.admin.submit();
}
</script> 
<script type="text/javascript">
function submitform_modules()
{
document.mes_modules.onsubmit();
document.mes_modules.submit();
}
</script> 
<script type="text/javascript">
function submitform_mes_heures()
{
document.mes_heures.onsubmit();
document.mes_heures.submit();
}
</script> 	
<script type="text/javascript">
function submitform_bilan()
{
document.bilan.onsubmit();
document.bilan.submit();
}
</script> 	
<script type="text/javascript">
function submitform_giseh()
{
document.giseh.onsubmit();
document.giseh.submit();
}
</script> 
<script type="text/javascript">
function submitform_salle()
{
document.salle.onsubmit();
document.salle.submit();
}
</script> 

<script type="text/javascript">
function submitform_ma_config()
{
document.ma_config.onsubmit();
document.ma_config.submit();
}
</script> 
<script type="text/javascript">
function submitform_mes_droits()
{
document.mes_droits.onsubmit();
document.mes_droits.submit();
}
</script> 
<script type="text/javascript">
function submitform_dialogue()
{
document.dialogue.onsubmit();
document.dialogue.submit();
}
</script> 

<script type="text/javascript">
function submitform_admin2()
{
document.admin2.onsubmit();
document.admin2.submit();
}
</script> 		
<script type="text/javascript">
function submitform_modules2()
{
document.mes_modules2.onsubmit();
document.mes_modules2.submit();
}
</script> 	
<script type="text/javascript">
function submitform_mes_heures2()
{
document.mes_heures2.onsubmit();
document.mes_heures2.submit();
}
</script> 	
<script type="text/javascript">
function submitform_bilan2()
{
document.bilan2.onsubmit();
document.bilan2.submit();
}
</script> 	
<script type="text/javascript">
function submitform_giseh2()
{
document.giseh2.onsubmit();
document.giseh2.submit();
}
</script> 
<script type="text/javascript">
function submitform_salle2()
{
document.salle2.onsubmit();
document.salle2.submit();
}
</script> 

<script type="text/javascript">
function submitform_ma_config2()
{
document.ma_config2.onsubmit();
document.ma_config2.submit();
}
</script> 
<script type="text/javascript">
function submitform_mes_droits2()
{
document.mes_droits2.onsubmit();
document.mes_droits2.submit();
}
</script> 
<script type="text/javascript">
function submitform_dialogue2()
{
document.dialogue2.onsubmit();
document.dialogue2.submit();
}
</script> 

<ul id="menu">
	
	<li style="height:23px;margin-top:0px"><a href="#"><img alt="menu" src="menu.png" height="25px"  border="none" /> Outils</a>
		<ul>
 	

		
		<?php
		//bouton "admin..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_admin==1)
	{
	if ($_SESSION['admin']!='0')
		{
		?>
		<!--[if  IE]>
  <li><a href="javascript:submitform_admin()"><img alt="admin" src="admin.png" height="25px"  border="none" /> Gestion des droits</a></li>
  <![endif]-->
<!--[if !IE]>-->

<li><a href="javascript:submitform_admin2()"><img alt="admin" src="admin.png" height="25px"  border="none" /> Gestion des droits</a></li>
<!--<![endif]-->
		
		<?php
		}
	}
//bouton "mes modules..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_modules==1)
	{
	if ($_SESSION['module']!='0')
		{
		?>
		<!--[if  IE]>
  <li><a href="javascript:submitform_modules()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none" /> Mes modules</a></li>
  <![endif]-->
<!--[if !IE]>-->

<li><a href="javascript:submitform_modules2()"><img alt="mes_modules" src="mes_modules.png" height="25px"  border="none" /> Mes modules</a></li>
<!--<![endif]-->
		
		<?php
		}
	}
	
	
//bouton "mes droits..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_droits==1)
	{
			if ($_SESSION['mes_droits']!='0')
		{
		?>
		<!--[if  IE]>
  <li><a href="javascript:submitform_mes_droits()"><img alt="mes_droits" src="mes_droits.png" height="25px"  border="none" /> Mes droits</a></li>
  <![endif]-->
<!--[if !IE]>-->

<li><a href="javascript:submitform_mes_droits2()"><img alt="mes_droits" src="mes_droits.png" height="25px"  border="none" /> Mes droits</a></li>
<!--<![endif]-->
		
		<?php
	}	
	}	
	
		
//bouton "mes heures..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_heures==1)
	{
	if ($_SESSION['bilan_heure']!='0' || $_SESSION['bilan_heure_global']!='0')
		{
		?>
				<!--[if  IE]>
<li><a href="javascript:submitform_mes_heures()"><img alt="heure" src="mes_heures.png" height="25px"  border="none" /> Mes heures</a></li>
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_mes_heures2()"><img alt="heure" src="mes_heures.png" height="25px"  border="none" /> Mes heures</a></li>
<!--<![endif]-->
		
		<?php
		}
	}	
	
//bouton "mes bilans..."
if (isset($_SESSION['bilan_formation']) && $afficher_bilan_par_formation==1)
{
if ($_SESSION['bilan_formation']!='0')
{
?>
		<!--[if  IE]>
<li><a href="javascript:submitform_bilan()"><img alt="bilan" src="bilan.png" height="25px"  border="none"/> Bilan par formation</a></li>
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_bilan2()"><img alt="bilan" src="bilan.png" height="25px"  border="none"/> Bilan par formation</a></li>
<!--<![endif]-->

<?php
}
}			

//bouton "Giseh..."
if (isset($_SESSION['giseh']) && $afficher_giseh==1)
{
if ($_SESSION['giseh']!='0')
{
?>
		<!--[if  IE]>
<li><a href="javascript:submitform_giseh()"><img alt="giseh" src="giseh.png" height="25px"  border="none"/> Giseh</a></li>
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_giseh2()"><img alt="giseh" src="giseh.png" height="25px"  border="none"/> Giseh</a></li>
<!--<![endif]-->

<?php
}
}

//bouton "dialogue de gestion..."
if (isset($_SESSION['dialogue']) && $afficher_dialogue==1)
{
if ($_SESSION['dialogue']!='0')
{
?>
		<!--[if  IE]>
<li><a href="javascript:submitform_dialogue()"><img alt="dialogue" src="dialogue.png" height="25px"  border="none"/> Dialogue de gestion</a></li>
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_dialogue2()"><img alt="dialogue" src="dialogue.png" height="25px"  border="none"/> Dialogue de gestion</a></li>
<!--<![endif]-->

<?php
}
}


//bouton "salle..."
if (isset($_SESSION['salle']) && $afficher_occupation_des_salles==1)
{
if ($_SESSION['salle']!='0')
{
?>
		<!--[if  IE]>
<li><a href="javascript:submitform_salle()"><img alt="salle" src="salle.png" height="25px"  border="none"/> Occupation des salles</a></li>
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_salle2()"><img alt="salle" src="salle.png" height="25px"  border="none"/> Occupation des salles</a></li>
<!--<![endif]-->

<?php
}
}
		
//flux RSS
if (isset($_SESSION['logged_prof_perso']) && $_SESSION['rss']!='0' && $_GET['disconnect']!="true" && $afficher_flux_rss==1 )
{
echo '<li><a href="RSS/rss.php?codeProf='.$_SESSION['logged_prof_perso'].'"><img alt="" src="RSS/rss.png" height="25px" style="border:none;"> Flux RSS</a></li>';
}

//bouton "ma config..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_ma_config==1)
{
if ($_SESSION['configuration']!='0')
{
?>
		<!--[if  IE]>
<li><a href="javascript:submitform_ma_config()"><img alt="config"  src="ma_config.png" height="25px"  border="none"/> Ma config</a></li> 
  <![endif]-->
<!--[if !IE]>-->
<li><a href="javascript:submitform_ma_config2()"><img alt="config"  src="ma_config.png" height="25px"  border="none"/> Ma config</a></li>
<!--<![endif]-->
	
<?php
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



<!--[if IE]>
<?php
//bouton "admin..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_admin==1 )
{
if ($_SESSION['admin']!='0')
{
?>
<form action="admin.php" name="admin" method="get" onsubmit="document.getElementById('screen_w22').value=document.documentElement.clientWidth;document.getElementById('screen_h22').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w22" value="">
	<input type="hidden" name="hau" id="screen_h22" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_module" value="<?php echo $jour; ?>">
</form>
<?php
}
}


//bouton "mes modules..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_modules==1 )
{
if ($_SESSION['module']!='0')
{
?>
<form action="module.php" name="mes_modules" method="get" onsubmit="document.getElementById('screen_w').value=document.documentElement.clientWidth;document.getElementById('screen_h').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w" value="">
	<input type="hidden" name="hau" id="screen_h" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_module" value="<?php echo $jour; ?>">
</form>
<?php
}
}

//bouton "mes droits..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_droites==1 )
{
		if ($_SESSION['mes_droits']!='0')
		{
?>
<form action="mes_droite.php" name="mes_droite" method="get" onsubmit="document.getElementById('screen_w20').value=document.documentElement.clientWidth;document.getElementById('screen_h20').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w20" value="">
	<input type="hidden" name="hau" id="screen_h20" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_module" value="<?php echo $jour; ?>">
</form>
<?php
}
}



//bouton "mes heures..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_heures==1)
{
if ($_SESSION['bilan_heure']!='0' || $_SESSION['bilan_heure_global']!='0')
{
?>
<form action="heure.php" name="mes_heures" method="get" onsubmit="document.getElementById('screen_w2').value=document.documentElement.clientWidth;document.getElementById('screen_h2').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w2" value="">
	<input type="hidden" name="hau" id="screen_h2" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_heure" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_heure" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_heure" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_heure" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_heure" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_heure" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_heure" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_heure" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_heure" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour4" value="<?php echo $jour; ?>">
</form>
<?php
}
}

//bouton "mes bilans..."
if (isset($_SESSION['bilan_formation']) && $afficher_bilan_par_formation==1)
{
if ($_SESSION['bilan_formation']!='0')
{
?>
<form action="heure_formation.php" name="bilan" method="get" onsubmit="document.getElementById('screen_w3').value=document.documentElement.clientWidth;document.getElementById('screen_h3').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w3" value="">
	<input type="hidden" name="hau" id="screen_h3" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_bilan" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_bilan" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_bilan" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_bilan" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_bilan" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_bilan" value="<?php echo $jour; ?>">
</form>
<?php
}
}

//bouton "Giseh..."
if (isset($_SESSION['giseh']) && $afficher_giseh==1)
{
if ($_SESSION['giseh']!='0')
{
?>
<form action="heure_giseh.php" name="giseh" method="get" onsubmit="document.getElementById('screen_w8').value=document.documentElement.clientWidth;document.getElementById('screen_h8').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w8" value="">
	<input type="hidden" name="hau" id="screen_h8" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_salle" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_salle" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_salle" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_salle" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_salle" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	
</form>
<?php
}
}


//bouton "Dialogue de gestion..."
if (isset($_SESSION['dialogue']) && $afficher_dialogue==1)
{
if ($_SESSION['dialogue']!='0')
{
?>
<form action="dialogue_gestion.php" name="dialogue" method="get" onsubmit="document.getElementById('screen_w28').value=document.documentElement.clientWidth;document.getElementById('screen_h28').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w28" value="">
	<input type="hidden" name="hau" id="screen_h28" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_dialogue" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_dialogue" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_dialogue" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_dialogue" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_dialogue" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_dialogue" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_dialogue" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_dialogue" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_dialogue" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	
</form>
<?php
}
}






//bouton "occupation des salles"
if (isset($_SESSION['salle']) && $afficher_occupation_des_salles==1)
{
if ($_SESSION['salle']!='0')
{
?>
<form action="bilan_salle.php" name="salle" method="get" onsubmit="document.getElementById('screen_w10').value=document.documentElement.clientWidth;document.getElementById('screen_h10').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="screen_w10" value="">
	<input type="hidden" name="hau" id="screen_h10" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_bilan" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_bilan" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_bilan" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_bilan" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_bilan" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	
</form>
<?php
}
}







//bouton "ma config..."
if (isset($_SESSION['logged_prof_perso']) && $afficher_ma_config==1)
{
if ($_SESSION['configuration']!='0')
{
?>
<form action="ma_config.php" name="ma_config" method="get" onsubmit="document.getElementById('scree_w2').value=document.documentElement.clientWidth;document.getElementById('scree_h2').value=document.documentElement.clientHeight">

    

	<input type="hidden" name="lar" id="scree_w2" value="">
	<input type="hidden" name="hau" id="scree_h2" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_config" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_config" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_config" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_config" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_config" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_config" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_config" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_config" value="4" >
	<?php
	}
	if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_config" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_config" value="<?php echo $jour; ?>">
</form>
<?php
}
}
?>
<![endif]-->
<!--[if !IE]>-->

<?php
//bouton "admin..." 
if (isset($_SESSION['logged_prof_perso']) && $afficher_admin==1 )
{
if ($_SESSION['admin']!='0')
{
?>
<form action="admin.php" name="admin2"  method="get" onsubmit="document.getElementById('screen_width23').value=window.innerWidth;document.getElementById('screen_height23').value=window.innerHeight;">

    

	<input type="hidden" name="lar" id="screen_width23" value="">
	<input type="hidden" name="hau" id="screen_height23" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module2" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module2" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module2" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module2" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module2" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour2" value="<?php echo $jour; ?>">
</form>
<?php
}
}



//bouton "mes modules..." 
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_modules==1 )
{
if ($_SESSION['module']!='0')
{
?>
<form action="module.php" name="mes_modules2"  method="get" onsubmit="document.getElementById('screen_width').value=window.innerWidth;document.getElementById('screen_height').value=window.innerHeight;">

    

	<input type="hidden" name="lar" id="screen_width" value="">
	<input type="hidden" name="hau" id="screen_height" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module2" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module2" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module2" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module2" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module2" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour2" value="<?php echo $jour; ?>">
</form>
<?php
}
}

//bouton "mes droits..." 
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_droits==1 )
{
		if ($_SESSION['mes_droits']!='0')
		{
?>
<form action="mes_droits.php" name="mes_droits2"  method="get" onsubmit="document.getElementById('screen_width21').value=window.innerWidth;document.getElementById('screen_height21').value=window.innerHeight;">

    

	<input type="hidden" name="lar" id="screen_width21" value="">
	<input type="hidden" name="hau" id="screen_height21" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_module2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_module2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_module2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_module2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_module2" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_module2" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_module2" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_module2" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_module2" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour2" value="<?php echo $jour; ?>">
</form>
<?php

}
}



//bouton "mes heures..." 
if (isset($_SESSION['logged_prof_perso']) && $afficher_mes_heures==1)
{
if ($_SESSION['bilan_heure']!='0' || $_SESSION['bilan_heure_global']!='0')
{
?>
<form action="heure.php" name="mes_heures2" method="get" onsubmit="document.getElementById('screen_w0').value=window.innerWidth;document.getElementById('screen_h0').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w0" value="">
	<input type="hidden" name="hau" id="screen_h0" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_heure2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_heure2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_heure2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_heure2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_heure2" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_heure2" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_heure2" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_heure2" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_heure2" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour3" value="<?php echo $jour; ?>">
</form>
<?php
}
}


//bouton "mes bilans..." 
if (isset($_SESSION['bilan_formation']) && $afficher_bilan_par_formation==1 )
{
if ($_SESSION['bilan_formation']!='0' )
{
?>
<form action="heure_formation.php" name="bilan2" method="get" onsubmit="document.getElementById('screen_w4').value=window.innerWidth;document.getElementById('screen_h4').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w4" value="">
	<input type="hidden" name="hau" id="screen_h4" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1c_bilan" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0c_bilan" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2c_bilan" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4c_bilan" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3c_bilan" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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

	<input type="hidden" name="jour" id="jour1_bilan" value="<?php echo $jour; ?>">

</form>
<?php
}
}


//bouton "Giseh..." 
if (isset($_SESSION['giseh']) && $afficher_giseh==1 )
{
if ($_SESSION['giseh']!='0' )
{
?>
<form action="heure_giseh.php" name="giseh2" method="get" onsubmit="document.getElementById('screen_w9').value=window.innerWidth;document.getElementById('screen_h9').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w9" value="">
	<input type="hidden" name="hau" id="screen_h9" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan3" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan3" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan3" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan3" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1c_giseh" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0c_giseh" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2c_giseh" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4c_giseh" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3c_giseh" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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

	

</form>
<?php
}
}


//bouton "Dialogue de gestion..." 
if (isset($_SESSION['dialogue']) && $afficher_dialogue==1 )
{
if ($_SESSION['dialogue']!='0' )
{
?>
<form action="dialogue_gestion.php" name="dialogue2" method="get" onsubmit="document.getElementById('screen_w29').value=window.innerWidth;document.getElementById('screen_h29').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w29" value="">
	<input type="hidden" name="hau" id="screen_h29" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_dialogue3" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_dialogue3" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_dialogue3" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_dialogue3" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1c_dialogue" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0c_dialogue" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2c_dialogue" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4c_dialogue" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3c_dialogue" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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

	

</form>
<?php
}
}



//bouton "occupation des salles..." 
if (isset($_SESSION['salle']) && $afficher_occupation_des_salles==1 )
{
if ($_SESSION['salle']!='0' )
{
?>
<form action="bilan_salle.php" name="salle2" method="get" onsubmit="document.getElementById('screen_w11').value=window.innerWidth;document.getElementById('screen_h11').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="screen_w11" value="">
	<input type="hidden" name="hau" id="screen_h11" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_bilan3" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_bilan3" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_bilan3" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_bilan3" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1c_salle" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0c_salle" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2c_salle" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4c_salle" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3c_salle" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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

	

</form>
<?php
}
}






//bouton "ma config..." 
if (isset($_SESSION['logged_prof_perso']) && $afficher_ma_config==1)
{
if ($_SESSION['configuration']!='0')
{
?>
<form action="ma_config.php" name="ma_config2" method="get" onsubmit="document.getElementById('scree_w').value=window.innerWidth;document.getElementById('scree_h').value=window.innerHeight">

    

	<input type="hidden" name="lar" id="scree_w" value="">
	<input type="hidden" name="hau" id="scree_h" value="">
	<input type="hidden" name="selec_prof" id="selec_profs_config2" value="<?php echo $selec_prof; ?>">
	<input type="hidden" name="selec_groupe" id="selec_groupes_config2" value="<?php echo $selec_groupe; ?>">
	<input type="hidden" name="selec_salle" id="selec_salle_config2" value="<?php echo $selec_salle; ?>">
		<input type="hidden" name="selec_materiel" id="selec_materiel_config2" value="<?php echo $selec_materiel; ?>">
	<?php
	if ($horizon=="1")
	{
	?>
	<input name="horiz" type="hidden" id="horiz1b_config2" value="1" >
	<?php
	}
	if ($horizon=="0")
	{
	?>
	<input name="horiz" type="hidden" id="horiz0b_config2" value="0">
	<?php
	}
	if ($horizon=="2")
	{
	?>
	<input name="horiz" type="hidden" id="horiz2b_config2" value="2" >
	<?php
	}
		if ($horizon=="4")
	{
	?>
	<input name="horiz" type="hidden" id="horiz4b_config2" value="4" >
	<?php
	}
		if ($horizon=="3")
	{
	?>
	<input name="horiz" type="hidden" id="horiz3b_config2" value="3" >
	<?php
	}
	?>
	<input type="hidden" name="current_week"  value="<?php echo $current_week; ?>">
	<input type="hidden" name="current_year"  value="<?php echo $current_year; ?>">
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


	<input type="hidden" name="jour" id="jour1_config2" value="<?php echo $jour; ?>">
</form>
<?php
}

}
?>
<!--<![endif]-->