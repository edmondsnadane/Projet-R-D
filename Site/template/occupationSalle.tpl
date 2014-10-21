<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Occupation des salles</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/admin.css"/>
		<script src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="js/occupationSalle.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		
		<div class="container">
			<form>
				<table class="table-striped table center-table col-md-12">
					<thead>
						<tr>
							<th>Salle</th>
							<th>Zone</th>
							<th>Séance (en heure)</th>
							<th>Réservation (en heure)</th>
							<th>Total (en heure)</th>
							<th>Taux d'occupation</th>
						</tr>
					</thead>
					<tbody>
						{foreach from=$occupations item=occupation}
							   {if isset($occupation.cumul) == FALSE}
								 <tr>
									<td>{$occupation.nom_salle}</td>
									<td>{$occupation.nom_zone}</td>
									<td>{$occupation.heure}</td>
									<td>{$occupation.heureReserve}</td>
									<td>{$occupation.total}</td>
									<td>{$occupation.taux}</td>
								 </tr>
							   {else}
									<tr>
										<td>{$occupation.nom_salle}</td>
										<td>{$occupation.nom_zone}</td>
										<td>{$occupation.heure}</td>
										<td>{$occupation.heureReserve}</td>
										<td>{$occupation.total}</td>
										<td>{$occupation.taux}</td>
									</tr>
									<tr>
										<td colspan="2">CUMUL DES HEURES DE LA ZONE CI-DESSUS</td>
										<td>{$occupation.total_seance_par_zone}</td>
										<td>{$occupation.total_res_par_zone}</td>
										<td>{$occupation.total_zone}</td>
										<td>{$occupation.total_taux}</td>
									<tr>
							   {/if}
						{/foreach}
					</tbody>
				</table>
			</form>
			
			<div id="mouseoverdiv"></div>
		</div>
		{include file='template/include/footer.tpl'}
	</body>
</html>