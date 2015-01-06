<html>
	<head>
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<meta charset="utf-8">
		<title>VT Agenda - Gestion des droits</title>
		<link rel="icon" type="image/png" href="img/glyphicons_calendar_title.png"/>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/common.css"/>
		<link rel="stylesheet" href="css/admin.css"/>
		<script src="API/jquery/jquery.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="js/loadPage.js"></script>
		<script type="text/javascript" src="js/admin.js"></script>
	</head>
	<body>
		
		{include file='template/include/header.tpl'}
		<div class="container">
			<div class="col-md-4 col-centered">
			
				<!-- div - retour login.js -->
					<div id="retourLoginJs"></div>
				<!-- ./div - retour login.js -->
				
				
				<div class="panel panel-default">
					<form class="form-horizontal" role="form" id="modifyConfigForm">
						<div class="panel-body">
							<div class="form-group">
								<label for="profs" class="col-sm-3 control-label">Enseignent </label>
								<div class="col-sm-9">
									<select name="profs" class="form-control" id="profs" required="" onChange="displayDroits()">
										{foreach from=$allTeachers item=teacher}
											<option value={$teacher.codeProf}>{$teacher.nom} {$teacher.prenom}</option>
										{/foreach}
									</select>
								</div>
							</div>
							<div data-toggle="buttons" id="userDroits">
								<label class="btn btn-primary"  id="admin">
									<input type="checkbox"><span class="glyphicon glyphicon-eye-open"></span> Admin
								</label>
								<label class="btn btn-primary" id="giseh">
									<input type="checkbox"><span class="glyphicon glyphicon-send"></span> Giseh
								</label>
								<label class="btn btn-primary" id="bilan_salle">
									<input type="checkbox"><span class="glyphicon glyphicon-home"></span> Bilan Salles
								</label>
								<label class="btn btn-primary" id="bilan_heure">
									<input type="checkbox"><span class="glyphicon glyphicon-dashboard"></span> Bilan Heures
								</label>
								<label class="btn btn-primary" id="droits">
									<input type="checkbox"><span class="glyphicon glyphicon-lock"></span> Mes Droits
								</label>
								<label class="btn btn-primary" id="heures">
									<input type="checkbox"><span class="glyphicon glyphicon-time"></span> Mes Heures
								</label>
								<label class="btn btn-primary" id="pdf">
									<input type="checkbox"><span class="glyphicon glyphicon-file"></span> PDF
								</label>
								<label class="btn btn-primary" id="rss">
									<input type="checkbox"><span class="glyphicon glyphicon-transfer"></span> RSS
								</label>
								<label class="btn btn-primary" id="config">
									<input type="checkbox"><span class="glyphicon glyphicon-cog"></span> Configuration
								</label>
								<label class="btn btn-primary" id="reservation">
									<input type="checkbox"><span class="glyphicon glyphicon-shopping-cart"></span> Reservation
								</label>
								<label class="btn btn-primary" id="modules">
									<input type="checkbox"><span class="glyphicon glyphicon-th-large"></span> Modules
								</label>
								<label class="btn btn-primary" id="dialogue">
									<input type="checkbox"><span class="glyphicon glyphicon-comment"></span> Dialogue
								</label>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-success" name="modify" id="modify">Modifier les droits</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		{include file='template/include/footer.tpl'}
	</body>
</html>