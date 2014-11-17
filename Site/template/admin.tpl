<html>
	<head>
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no" charset="utf-8"/>
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
							<div data-toggle="buttons">
								<label class="btn btn-primary"  name="admin" id="admin">
									<input type="checkbox" autocomplete="off"> Admin
								</label>
								<label class="btn btn-primary" name="giseh" id="giseh">
									<input type="checkbox" autocomplete="off"> Giseh
								</label>
								<label class="btn btn-primary" name="bilan_salle" id="bilan_salle">
									<input type="checkbox" autocomplete="off"> Bilan Salles
								</label>
								<label class="btn btn-primary" name="bilan_heure" id="bilan_heure">
									<input type="checkbox" autocomplete="off"> Bilan Heures
								</label>
								<label class="btn btn-primary" name="bilan_formation" id="bilan_formation">
									<input type="checkbox" autocomplete="off"> Bilan Formation
								</label>
								<label class="btn btn-primary" name="droits" id="droits">
									<input type="checkbox" autocomplete="off"> Mes Droits
								</label>
								<label class="btn btn-primary" name="heures" id="heures">
									<input type="checkbox" autocomplete="off"> Mes Heures
								</label>
								<label class="btn btn-primary" name="pdf" id="pdf">
									<input type="checkbox" autocomplete="off"> PDF
								</label>
								<label class="btn btn-primary" name="rss" id="rss">
									<input type="checkbox" autocomplete="off"> RSS
								</label>
								<label class="btn btn-primary" name="config" id="config">
									<input type="checkbox" autocomplete="off"> Configuration
								</label>
								<label class="btn btn-primary" name="reservation" id="reservation">
									<input type="checkbox" autocomplete="off"> Reservation
								</label>
								<label class="btn btn-primary" name="modules" id="modules">
									<input type="checkbox" autocomplete="off"> Modules
								</label>
								<label class="btn btn-primary" name="dialogue" id="dialogue">
									<input type="checkbox" autocomplete="off"> Dialogue
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