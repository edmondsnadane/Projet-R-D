<html>
	<head>
		<meta charset="utf-8" />
		<title>VT Calendar - Dialogue de gestion</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap-theme.min.css">
		<link href="API/footable/css/footable.core.min.css" rel="stylesheet" type="text/css">
		<link href="API/footable/css/footable.standalone.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/dialogueGestion.css"/>
		<script type="text/javascript" src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="API/footable/js/footable.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
	</head>
	<body>
		{include file='template/include/header.tpl'}
		<div class="container">
		{foreach from=$composantes item=composante}
			<h2>{$composante.nom}</h2>
			<table class="footable">
				<tr>
					<th>Grade</th>
					<th data-hide="phone,tablet">Nom des enseignants</th>
					<th data-hide="phone,tablet">Horaires statuaires</th>
					<th>Nombre</th>
					<th data-hide="phone,tablet">Potentiel enseignement en heure</th>
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
				<tr class="success">
					<td colspan="4" class="potentielLabel">Potentiel Enseignement total</td>
					<td>{$composante.nbHeure}</td>
				</tr>
			</table>
		{/foreach}
		</div>
		
		{include file='template/include/footer.tpl'}
	</body>
	<script type="text/javascript" src="js/footableTest.js"></script>
</html>