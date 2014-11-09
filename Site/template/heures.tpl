<html>
	<head>
		
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no" charset="utf-8"/>
		<title>VT Calendar - Mes heures</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/dialogueGestion.css"/>
		<link href="API/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>		
		<script type="text/javascript" src="js/filterTable.js"></script>
		<script type="text/javascript" src="js/heure.js"></script>
		<script type="text/javascript" src="API/footable/js/footable.js"></script>
		<script src="API/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
		<script type="text/javascript" src="API/tableExport/tableExport.js"></script>
		<script type="text/javascript" src="API/tableExport/jquery.base64.js"></script>
		<script type="text/javascript" src="API/googleCharts/googleCharts.js"></script>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/login.css"/>
		
	</head>
	
	<body>
		{include file='template/include/header.tpl'}
		<div class="container">
			<div class="col-md-4 col-centered">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong class="">Afficher mes Heures</strong>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" name="form" id="form" method="get" >
	
							<input type="hidden" name="page" value="heure" />
							<label>Année scolaire :</label> 
							<select class="form-control" name="annee_scolaire">
								{foreach from=$annees item=annee}
									<option>{$annee}</option>
								{/foreach}
							</select><br>

							<label>Tri par Département :</label> 
							<select class="form-control" name="composante" onchange="document.form.submit();">
								<option value="all">TOUS</option>
								{foreach from=$composantes item=composante}
									<option {if $composante.codeComposante == $code}selected="selected"{/if} value="{$composante.codeComposante}">{$composante.nom}</option>
								{/foreach}
							</select></p><br>

							<label>Choix du professeur :</label> 
							<select name="prof" class="form-control" id="prof" required="">
								{foreach from=$allCSTeachers item=csTeacher}
									<option {if $csTeacher.codeProf == $codeProf}selected="selected"{/if}  value="{$csTeacher.codeProf}">{$csTeacher.nom}   {$csTeacher.prenom}</option>
								{/foreach}
							</select><br>
						</form>
					</div>
					<div class="panel-footer">
						{literal}
							<a download="seances.csv" onClick ="this.href = $('#tableSeance').tableExportInline({type:'csv',escape:'false',separator:';',consoleLog:true}); return true;">Exporter vers Excel</a>
						{/literal}
					</div>
					
				</div>
				
			</div>		
			
			
			<table class="table-striped table center-table col-sm-9 footable" id="tableSeance">
				<thead>
					<tr>
						<th data-sort-ignore="true">Formation</th>
						<th data-hide="phone,tablet">Code apogée</th>
						<th >Matière</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Date</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Heure début</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Heure fin</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Horaire réparti / nb profs</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Forfait</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">CM</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">TD</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">TP</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">EqTD</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Effectué</th>
					</tr>
				</thead>
				
				<tbody id="tableContent"> 
						{foreach from=$allSeances item=seance}
							{if $seance.type == 'cumul' }
								<tr class="cumul">
									<td></td>
									<td></td>
									<td colspan="6">{$seance.nomMatiere} - cumul des seances : </td>
									<td>{if $seance.dureeCM !=0}{$seance.dureeCM}{else} {/if} </td>
									<td>{if $seance.dureeTD !=0}{$seance.dureeTD}{else} {/if} </td>
									<td>{if $seance.dureeTP !=0}{$seance.dureeTP}{else} {/if} </td>
									<td>{$seance.eqTD}</td>
									<td></td>
								</tr> 
							{else}
								<tr>
									<td>{$seance.nomFormation}</td>
									<td>{$seance.codeApogee}</td>
									<td>{$seance.nomMatiere}</td>
									<td>{$seance.dateSeance}</td>
									<td>{$seance.heureDebut}</td>
									<td>{$seance.heureFin}</td>
									<td>{if $seance.volumeReparti == 0} NON {else} OUI {/if}</td>
									<td>{if $seance.forfaitaire == 0} NON {else} OUI {/if} </td>
									<td>{if $seance.dureeCM !=0}{$seance.dureeCM}{else} - {/if} </td>
									<td>{if $seance.dureeTD !=0}{$seance.dureeTD}{else} - {/if} </td>
									<td>{if $seance.dureeTP !=0}{$seance.dureeTP}{else} - {/if} </td>
									<td>{$seance.eqTD}</td>
									<td>{if $date_actuelle  >= $seance.dateSeanceFormatee } <span value="+" class='glyphicon glyphicon-ok-circle'></span> {else}{/if}</td>
								</tr>
							{/if}
						{/foreach}

				</tbody>
				
			</table>
			
			<br>
			<div id="chart_div" class="hidden-xs hidden-sm"></div>
		</div>
		
		{include file='template/include/footer.tpl'}

	</body>
		
</html>		