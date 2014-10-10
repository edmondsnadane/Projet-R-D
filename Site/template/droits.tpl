<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Acceuil</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/login.css"/>
		<link rel="stylesheet" href="css/droits.css"/>
		<script type="text/javascript" src="js/loadPage.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		
		<div class="table-responsive">
			<table class="table-striped center-table">
				<tr>
				   <th>Droits</th>
				   <th>Activation</th>
				</tr>
			    <tr>
				   <td>Administrateur</td>
				   <td>
						{if $droits.admin == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
			    <tr>
				   <td>Dialogue de gestion</td>
				   <td>
						{if $droits.dialogue == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Export vers Giseh (Université Paris Ouest uniquement)</td>
				   <td>
						{if $droits.giseh == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Export PDF</td>
				   <td>
						{if $droits.pdf == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Faire le bilan de l'occupation des salles</td>
				   <td>
						{if $droits.salle == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Faire le bilan de ses heures</td>
				   <td>
						{if $droits.bilan_heure == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Faire le bilan des heures de tout le monde</td>
				   <td>
						{if $droits.bilan_heure_global == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Faire le bilan des heures des formations</td>
				   <td>
						{if $droits.bilan_formation == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Flux RSS</td>
				   <td>
						{if $droits.rss == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Modifier sa configuration</td>
				   <td>
						{if $droits.configuration == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Se placer des réservations</td>
				   <td>
						{if $droits.reservation == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
				<tr>
				   <td>Séances clicables</td>
				   <td>
						{if $droits.seance_clicable == 1}
							<span class="glyphicon glyphicon-ok-circle"></span>
						{else}
							<span class="glyphicon glyphicon-ban-circle"></span>
						{/if}
					</td>
			    </tr>
			</table>
		</div>
		
		{include file='template/include/footer.tpl'}
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
	</body>
</html>