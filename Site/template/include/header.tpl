<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" id="boutonNavBar" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" onClick="loadIndex()"><span class="glyphicon glyphicon-calendar"></span> VT Calendar</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><span>{if isset($firstName)} {$firstName} {/if} {$userName}</span><span class="caret"></span></a>
			{if isset($teachLogin)}
				<!-- l'utilisateur connecté est un enseignant -->
				<ul class="dropdown-menu" role="menu">
					<li onClick="loadTools()"><a href="#"><span class="glyphicon glyphicon-briefcase"></span> Outils</a></li>
					
					{if $droits.admin == 1}
						<li onClick="loadAdmin()"><a href="#"><span class="glyphicon glyphicon-eye-open"></span> Gestion des droits</a></li>
					{/if}
					
					{if $droits.module == 1}
						<li onClick="loadModule()"><a href="#"><span class="glyphicon glyphicon-th-large"></span> Mes Modules</a></li>
					{/if}
					
					{if $droits.mes_droits == 1}
						<li onClick="loadDroits()"><a href="#"><span class="glyphicon glyphicon-lock"></span> Mes Droits</a></li>
					{/if}
					
					{if $droits.bilan_heure == 1}
						<li onClick="loadHeures()"><a href="#"><span class="glyphicon glyphicon-time"></span> Mes Heures</a></li>
					{/if}
					
					{if $droits.bilan_formation == 1}
						<li onClick=""><a href="#"><span class="glyphicon glyphicon-stats"></span> Bilan par formation</a></li>
					{/if}
					
					{if $droits.dialogue == 1}
						<li onClick="loadDialogue()"><a href="#"><span class="glyphicon glyphicon-comment"></span> Dialogue de gestion</a></li>
					{/if}
					
					{if $droits.salle == 1}
						<li onClick=""><a href="#"><span class="glyphicon glyphicon-home"></span> Occupation de salles</a></li>
					{/if}
					
					{if $droits.pdf == 1 || $droits.giseh == 1 || isset($studyLogin)}
						<li onClick="loadExport()"><a href="#"><span class="glyphicon glyphicon-file"></span> Export </a></li>
					{/if}
					
					{if $droits.rss == 1}
						<li onClick="loadRSS()"><a href="#"><span class="glyphicon glyphicon-transfer"></span> Flux RSS</a></li>
					{/if}
					
					{if $droits.configuration == 1}
						<li onClick="loadConfig()"><a href="#"><span class="glyphicon glyphicon-cog"></span> Configuration</a></li>
					{/if}
				</ul>
			{else}
				<!-- l'utilisateur connecté est un étudiant -->
				<ul class="dropdown-menu" role="menu">
					<li onClick="loadTools()"><a href="#"><span class="glyphicon glyphicon-briefcase"></span> Outils</a></li>
					<li onClick="loadExport()"><a href="#"><span class="glyphicon glyphicon-file"></span> Export </a></li>
					<li onClick="loadMesDS()"><a href="#"><span class="glyphicon glyphicon-pencil"></span> Mes DS</a></li>
					<li onClick="loadModule()"><a href="#"><span class="glyphicon glyphicon-th-large"></span> Mes Modules</a></li>
					<li onClick="loadRSS()"><a href="#"><span class="glyphicon glyphicon-transfer"></span> Flux RSS</a></li>
					<li onClick="loadICal()"><a href="#"><span class="glyphicon glyphicon-calendar"></span> Agenda éléctronique</a></li>
				</ul>
			{/if}
        </li>
      </ul>
	  <ul class="nav navbar-nav navbar-right">
		<li onClick="loadIndex()"><a><span class="glyphicon glyphicon-home"></span> Acceuil</a></li>
		{if isset($teachLogin)}
			<li onClick="loadConfig()"><a><span class="glyphicon glyphicon-wrench"></span> Configuration</a></li>
		{/if}
		<li onClick="deconnect()"><a><span class="glyphicon glyphicon-off"></span> Déconnexion</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>