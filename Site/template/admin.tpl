<html>
	<head>
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no" charset="utf-8"/>
		<title>VT Agenda - Gestion des droits</title>
		<link rel="icon" type="image/png" href="img/glyphicons_calendar_title.png"/>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/admin.css"/>
		<link href="API/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css">
		<script src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="API/footable/js/footable.js"></script>
		<script src="API/footable/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
		<script src="API/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
		<script type="text/javascript" src="js/filterTable.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		<div class="container">
			<form>
				<div class="form-group">
					<label for="filter" class="col-sm-3 control-label">Rechercher</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="filter">
					</div>
				</div>
				<table class="table center-table col-sm-9 footable" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
						   <th>Nom</th>
						   <th>Prenom</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Admin</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Giseh</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Bilan salles</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Bilan heures</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Bilan formations</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Droits</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Bilan mes heures</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">PDF</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">RSS</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Configuration</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Reservation</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Modules</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Dialogue</th>
						   <th data-hide="phone,tablet" data-sort-ignore="true">Agenda ICS</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$allTeachers item=teacher}
							<tr>
							   <td>{$teacher.prenom}</td>
							   <td>{$teacher.nom}</td>
							   {foreach from=$teacher.droits item=droit}
									<td {if $droit == 1} class="success" {else} class="danger" {/if} >
										<div class="checkbox">
											<input type="checkbox" {if $droit == 1} checked {/if} >
										</div>
									</td>
							   {/foreach}
							</tr>
						{/foreach}
					</tbody>
				</table>
			
			<button type="submit" class="btn btn-default">Sauvegarder</button>
		</form>
		</div>
		{include file='template/include/footer.tpl'}
	</body>
</html>