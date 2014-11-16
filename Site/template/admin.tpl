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
				<div class="panel panel-default">
					<div class="panel-heading"> 
						<strong class="">Modification des droits</strong>
					</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form">
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
							<div class="form-group">
								<label for="admin" class="col-sm-3 control-label">Admin </label>
								<div class="col-sm-9">
									<input type="checkbox" name="admin" id="admin" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="giseh" class="col-sm-3 control-label">Giseh </label>
								<div class="col-sm-9">
									<input type="checkbox" name="giseh" id="giseh" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="bilan_salle" class="col-sm-3 control-label">Bilan Salles </label>
								<div class="col-sm-9">
									<input type="checkbox" name="bilan_salle" id="bilan_salle" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="bilan_heure" class="col-sm-3 control-label">Bilan Heures </label>
								<div class="col-sm-9">
									<input type="checkbox" name="bilan_heure" id="bilan_heure" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="bilan_formation" class="col-sm-3 control-label">Bilan Formation </label>
								<div class="col-sm-9">
									<input type="checkbox" name="bilan_formation" id="bilan_formation" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="droits" class="col-sm-3 control-label">Mes droits </label>
								<div class="col-sm-9">
									<input type="checkbox" name="droits" id="droits" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="heures" class="col-sm-3 control-label">Mes Heures </label>
								<div class="col-sm-9">
									<input type="checkbox" name="heures" id="heures" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="pdf" class="col-sm-3 control-label">PDF </label>
								<div class="col-sm-9">
									<input type="checkbox" name="pdf" id="pdf" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="rss" class="col-sm-3 control-label">RSS </label>
								<div class="col-sm-9">
									<input type="checkbox" name="rss" id="rss" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="config" class="col-sm-3 control-label">Configuration </label>
								<div class="col-sm-9">
									<input type="checkbox" name="config" id="config" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="reservation" class="col-sm-3 control-label">Reservation </label>
								<div class="col-sm-9">
									<input name="reservation" id="reservation" required="" type="checkbox">
								</div>
							</div>
							<div class="form-group">
								<label for="modules" class="col-sm-3 control-label">Modules </label>
								<div class="col-sm-9">
									<input type="checkbox" name="modules" id="modules" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="dialogue" class="col-sm-3 control-label">Dialogue de gestion </label>
								<div class="col-sm-9">
									<input type="checkbox" name="dialogue"  id="dialogue" required="">
								</div>
							</div>
							<div class="form-group">
								<label for="agenda" class="col-sm-3 control-label">Agenda ICS </label>
								<div class="col-sm-9">
									<input type="checkbox" checked name="agenda" id="agenda" required="">
								</div>
							</div>
							
							<button type="submit" class="btn btn-default">Sauvegarder</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		{include file='template/include/footer.tpl'}
	</body>
</html>