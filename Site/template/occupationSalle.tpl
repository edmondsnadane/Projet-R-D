<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Occupation des salles</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/admin.css"/>
		<link href="API/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css">
		<script src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="API/googleCharts/googleCharts.js"></script>
		<script type="text/javascript" src="js/occupationSalle.js"></script>
		<script type="text/javascript" src="API/footable/js/footable.js"></script>
		<script src="API/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
		<script type="text/javascript" src="js/filterTable.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		
		<div class="container">
			<a role="button" class="btn">Exporter vers EXCEL</a>
			<br>
			<table class="table center-table col-sm-9 footable">
				<thead>
					<tr>
						<th>Salle</th>
						<th>Zone</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Séance (en heure)</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Réservation (en heure)</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Total (en heure)</th>
						<th data-hide="phone,tablet" data-sort-ignore="true">Taux d'occupation</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$occupations item=occupation}
						<tr>
							<td>{$occupation.nom_salle}</td>
							<td>{$occupation.nom_zone}</td>
							<td>{$occupation.heure}</td>
							<td>{$occupation.heureReserve}</td>
							<td>{$occupation.total}</td>
							<td>{$occupation.taux}</td>
						</tr>
						{if $occupation.cumul == TRUE}
							<tr class="success" data-hide="phone,tablet">
								<td colspan="2">TOTAL</td>
								<td>{$occupation.total_seance}</td>
								<td>{$occupation.total_reserve}</td>
								<td>{$occupation.total_zone}</td>
								<td>{$occupation.total_taux}</td>
							<tr>
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