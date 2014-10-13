<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Gestion des droits</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/droits.css"/>
		<script type="text/javascript" src="js/loadPage.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		<form>
				<table class="table-striped table center-table">
					<tr>
					   <th>Nom</th>
					   <th>Prenom</th>
					   <th>Administrateur</th>
					   <th>Export vers Giseh</th>
					   <th>Bilan des salles</th>
					   <th>Bilan des heures des profs</th>
					   <th>Bilan des formations</th>
					   <th>Afficher ses droits</th>
					   <th>Bilan de ses heures</th>
					   <th>Export PDF</th>
					   <th>RSS</th>
					   <th>Configuration</th>
					   <th>Reservation</th>
					   <th>Detail des modules</th>
					   <th>Séances clicables</th>
					   <th>Dialogue de Gestion</th>
					</tr>
					
					{foreach from=$allTeachers item=teacher}
						<tr>
						   <td>{$teacher.prenom}</td>
						   <td>{$teacher.nom}</td>
						   {foreach from=$teacher.droits item=droit}
								<td {if $droit == 1} class="success" {else} class="danger" {/if} >
									<div class="checkbox">
										<input type="radio" {if $droit == 1} checked {/if} >
									</div>
								</td>
						   {/foreach}
						</tr>
					{/foreach}
				</table>
			
			<button type="submit" class="btn btn-default">Sauvegarder</button>
		</form>
		
		{include file='template/include/footer.tpl'}
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
	</body>
</html>