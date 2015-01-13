<div id="panelFilter">
    <div class="col-md-12 col-centered" style="padding-top: 15px;">
	<div class="panel panel-default">
	    <div class="panel-heading"> 
                <form class="form-horizontal" role="form">
		    <div class="form-group">
			<label for="groupesFilter" class="col-md-12">Groupes</label>
			    <div class="col-md-12">
				<select name="groupesFilter" class="form-control" id="groupesFilter" required="" onChange="loadGroupesListFilter()">
				    <option value="all" selected>TOUS</option>
                                    {foreach from=$formations item=formation}
                                        <option value={$formation.codeNiveau}>{$formation.nom}</option>
                                    {/foreach}
				</select>
                            </div>
			</div>
                </form>                                     
	    </div>
	    <div class="panel-body">
		<form class="form-horizontal" role="form">
		    <div class="form-group">
			<div class="col-md-12">
			    <select name="groupesFormationsFilter" class="form-control" id="groupesFormationsFilter" required="">
				{foreach from=$groupes item=groupe}
                                    <option value={$groupe.codeGroupe}>{$groupe.nom}</option>
				{/foreach}
			    </select>
			</div>
		    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-centered">
	<div class="panel panel-default">
	    <div class="panel-heading"> 
                <form class="form-horizontal" role="form">
		    <div class="form-group">
			<label for="profsComposantesFilter" class="col-md-12">Profs</label>
			    <div class="col-md-12">
				<select name="profsComposantesFilter" class="form-control" id="profsComposantesFilter" required="" onChange="loadProfsListFilter()">
				    <option value="all" selected>TOUS</option>
                                    {foreach from=$composantes item=composante}
					<option value={$composante.codeComposante}>{$composante.nom}</option>
				    {/foreach}
				</select>
                            </div>
			</div>
                </form>                                     
	    </div>
	    <div class="panel-body">
		<form class="form-horizontal" role="form">
		    <div class="form-group">
			<div class="col-md-12">
			    <select name="profsFilter" class="form-control" id="profsFilter" required="">
				{foreach from=$profs item=prof}
                                    <option value={$prof.codeProf} {if $prof.codeProf == $code}selected{/if}>{$prof.nom} {$prof.prenom}</option>
				{/foreach}
			    </select>
			</div>
		    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-centered">
	<div class="panel panel-default">
	    <div class="panel-heading"> 
                <form class="form-horizontal" role="form">
		    <div class="form-group">
			<label for="departementFilter" class="col-md-12">Salles</label>
			    <div class="col-md-12">
				<select name="departementFilter" class="form-control" id="departementFilter" required="">
				    <option value="all" selected>TOUS</option>
                                    {foreach from=$departements item=departement}
					<option value={$departement.codeZoneSalle}>{$departement.nom_zone}</option>
				    {/foreach}
				</select>
                            </div>
			</div>
                </form>                                     
	    </div>
	    <div class="panel-body">
		<form class="form-horizontal" role="form">
		    <div class="form-group">
			<div class="col-md-12">
			    <select name="anneeProf" class="form-control" id="anneeProf" required="">
				{foreach from=$annees item=annee}
                                    <option value=0 selected>{$annees[0]}</option>
				{/foreach}
			    </select>
			</div>
		    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-centered">
	<div class="panel panel-default">
	    <div class="panel-heading"> 
                <form class="form-horizontal" role="form">
		    <div class="form-group">
			<label for="materielFilter" class="col-md-12">Materiels</label>
			    <div class="col-md-12">
				<select name="materielFilter" class="form-control" id="materielFilter" required="">
				    <option value="all" selected>TOUS</option>
                                    {foreach from=$materiels item=materiel}
					<option value={$materiel.codeComposante}>{$materiel.nom_composante}</option>
				    {/foreach}
				</select>
                            </div>
			</div>
                </form>                                     
	    </div>
	    <div class="panel-body">
		<form class="form-horizontal" role="form">
		    <div class="form-group">
			<div class="col-md-12">
			    <select name="anneeProf" class="form-control" id="anneeProf" required="">
				{foreach from=$annees item=annee}
                                    <option value=0 selected>{$annees[0]}</option>
				{/foreach}
			    </select>
			</div>
		    </div>
                </form>
            </div>
        </div>
    </div>
</div>