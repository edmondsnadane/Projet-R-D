<html>
	<head>
		<meta charset="utf-8">
		<title>VT Calendar - Acceuil</title>
		<link rel="stylesheet" href="API/bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/login.css"/>
	</head>
	<body>
		<div class="page-header">
			<h1><img src="img/calendar_31.png" alt="Powered by Mysql" width="60px">
				VT CALENDAR 
				<small>consultation des emplois du temps faits avec VT</small><br>
			</h1>
		</div>
		<div id="loginTabContent" class="tab-content container">
			<ul id="myTab" class="nav nav-tabs col-md-4">
				<li class="active"><a href="#teachContainer" data-toggle="tab">Enseignant</a></li>
				<li><a href="#studyContainer" data-toggle="tab">Etudiant</a></li>
			</ul>
			<div id="teachContainer" class="tab-pane fade in active">
				<div class="row">
					<div class="col-md-4 col-centered">
						<div class="panel panel-default">
							<div class="panel-heading"> <strong class="">Planning des enseignants</strong>

							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label for="inputLogin3" class="col-sm-3 control-label">Login</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="inputLogin3" required="" placeholder="Login">
										</div>
									</div>
									<div class="form-group">
										<label for="inputPassword3" class="col-sm-3 control-label">Mot de passe</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" id="inputPassword3" placeholder="Mot de passe" required="">
										</div>
									</div>
									<div class="form-group">
										<div class="checkbox">
											<input type="checkbox" class="">Rester connecté</label>
										</div>
									</div>
									<div class="form-group last" id="teachButtons">
										<button type="submit" class="btn btn-success btn-sm col-md-6">Valider</button>
										<button type="reset" class="btn btn-danger btn-sm col-md-6">Annuler</button>
									</div>
								</form>
							</div>
							<div class="panel-footer">
								<a role="button" class="btn" data-toggle="modal" data-target="#modifyMdp">Modifier le mot de passe</a>
								<a href="config/aide.pdf" role="button" class="btn" class="">Mode d'emploi</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="studyContainer" class="container tab-pane fade in">
				<div class="row">
					<div class="col-md-4 col-centered">
						<div class="panel panel-default">
							<div class="panel-heading"> <strong class="">Planning des étudiants</strong>

							</div>
							<div class="panel-body">
								<form class="form-horizontal" role="form">
									<div class="form-group">
										<label for="inputLoginEtudiant" class="col-sm-3 control-label">Login</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="inputLoginEtudiant" required="" placeholder="Login">
										</div>
									</div>
									<div class="form-group">
										<div class="checkbox">
											<input type="checkbox" class="">Rester connecté</label>
										</div>
									</div>
									<div class="form-group last" id="studyButtons">
										<button type="submit" class="btn btn-success btn-sm col-md-6">Valider</button>
										<button type="reset" class="btn btn-danger btn-sm col-md-6">Annuler</button>
									</div>
								</form>
							</div>
							<div class="panel-footer"><a href="config/aide.pdf" class="">Mode d'emploi</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- POPUP MODAL DE MODIFICATION DE MOT DE PASSE -->
		<div class="modal fade" id="modifyMdp" tabindex="-1" role="dialog" aria-labelledby="modifyMdpLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modifyMdpLabel">Modification de mot de passe</h4>
			  </div>
			  <div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputLogin" class="col-sm-3 control-label">Login</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputLogin" placeholder="Login">
						</div>
					</div>
					<div class="form-group">
						<label for="inputOldPassword" class="col-sm-3 control-label">Ancien Mdp</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="inputOldPassword" placeholder="Ancien Mot de passe">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNewPassword1" class="col-sm-3 control-label">Nouveau Mdp</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="inputNewPassword1" placeholder="Nouveau Mot de passe">
						</div>
					</div>
					<div class="form-group">
						<label for="inputNewPassword2" class="col-sm-3 control-label">Retappez Mdp</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="inputNewPassword2" placeholder="Nouveau Mot de passe">
						</div>
					</div>
				</form>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
				<button type="button" class="btn btn-success">Valider</button>
			  </div>
			</div>
		  </div>
		</div>
		
		<div class="container">
			<br><br>
			D&eacute;velopp&eacute; par <span style="font-weight:bold;">Bruno MILLION</span> (IUT GMP) et par <span style="font-weight:bold;">Ga&euml;tan COLOMBIER</span> (IUT GMP) pour le PST de Ville d'Avray (Université Paris Ouest) - {$compteur} pages vues.<br>
			<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-html401-blue" alt="Valid HTML 4.01 Transitional" ></a>
			<a href="http://jigsaw.w3.org/css-validator/check/referer/"><img src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" ></a>
			<a href="http://www.php.net/"><img src="http://www.php.net/images/logos/php-power-white.png" alt="Powered by PHP" ></a>
			<a href="http://www.mysql.com"><img src="http://www.cygneweb.com/images/logo_mysql.gif" alt="Powered by Mysql" ></a><br><br>
			<a href="version.html" role="button" class="btn">Version 6.0.0</a>	
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="API/bootstrap/js/bootstrap.js"></script>
	</body>
</html>