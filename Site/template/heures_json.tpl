{
	"new_table" : "{foreach from=$allSeances item=seance}<tr><td>{$seance.nomFormation}</td><td>{$seance.codeApogee}</td><td>{$seance.nomMatiere}</td><td>{$seance.dateSeance}</td><td>{$seance.heureDebut}</td><td>{$seance.heureFin}</td><td>{if $seance.volumeReparti ==0} NON {else} OUI {/if}</td><td>NON</td><td>TODO</td><td>TODO</td><td>TODO</td><td>TODO</td><td>TODO</td></tr>{/foreach}"
}