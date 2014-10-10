<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" ><span class="glyphicon glyphicon-calendar"></span> VT Calendar</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> nom prenom <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li onClick="loadTools()"><a href="#"><span class="glyphicon glyphicon-briefcase"></span> Outils</a></li>
            <li onClick="loadModule()"><a href="#"><span class="glyphicon glyphicon-th-large"></span> Modules</a></li>
            <li onClick="loadDroits()"><a href="#"><span class="glyphicon glyphicon-lock"></span> Droits</a></li>
            <li onClick="loadHeures()"><a href="#"><span class="glyphicon glyphicon-time"></span> Heures</a></li>
			<li onClick="loadExport()"><a href="#"><span class="glyphicon glyphicon-file"></span> Export PDF</a></li>
			<li onClick="loadRSS()"><a href="#"><span class="glyphicon glyphicon-transfer"></span> Flux RSS</a></li>
			<li onClick="loadConfig()"><a href="#"><span class="glyphicon glyphicon-cog"></span> Configuration</a></li>
          </ul>
        </li>
      </ul>
	  <ul class="nav navbar-nav navbar-right">
		<li><a><span class="glyphicon glyphicon-refresh"></span> Rafraichir</a></li>
		<li><a><span class="glyphicon glyphicon-wrench"></span> Configuration</a></li>
		<li onClick="deconnect()"><a><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>