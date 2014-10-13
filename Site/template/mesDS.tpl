<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Acceuil</title>

		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="API/bootstrap-calendar-master/css/calendar.css">
		<link rel="stylesheet" href="css/common.css"/>
		
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="API/bootstrap-calendar-master/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		
		<table class="table-striped table center-table">
			<tr>
				<th>Date</th>
				<th>Groupes</th>
				<th>Type</th>
				<th>Enseignement</th>
				<th>Profs</th>
				<th>Salles</th>
				<th>Heure de début</th>
				<th>Durée</th>
				<th>Effectué</th>
			</tr>
			{foreach from=$composante.grades item=grade}
				<tr>
					<td>{$grade.nom}</td>
					<td class="resource_cell">{$grade.resources}</td>
					<td>{$grade.heure_vol_stat}h{$grade.minutes_vol_stat}</td>
					<td>{$grade.nb_prof}</td>
					<td>{$grade.nb_heure}</td>
				</tr>
			{/foreach}
		</table>
		
		{include file='template/include/footer.tpl'}
	
	</body>
</html>