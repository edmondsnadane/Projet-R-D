{foreach from=$allSeances item=seance}
	{if $seance.type == 'cumul' }
		<tr class="cumul">
			<td></td>
			<td></td>
			<td colspan="6">{$seance.nomMatiere} - cumul des seances : </td>
			<td>{if $seance.dureeCM !=0}{$seance.dureeCM}{else} {/if} </td>
			<td>{if $seance.dureeTD !=0}{$seance.dureeTD}{else} {/if} </td>
			<td>{if $seance.dureeTP !=0}{$seance.dureeTP}{else} {/if} </td>
			<td>{$seance.eqTD}</td>
			<td></td>
		</tr> 
	{else}
		<tr>
			<td>{$seance.nomFormation}</td>
			<td>{$seance.codeApogee}</td>
			<td>{$seance.nomMatiere}</td>
			<td>{$seance.dateSeance}  </td>
			<td>{$seance.heureDebut}</td>
			<td>{$seance.heureFin}</td>
			<td>{if $seance.volumeReparti == 0} NON {else} OUI {/if}</td>
			<td>{if $seance.forfaitaire == 0} NON {else} OUI {/if} </td>
			<td>{if $seance.dureeCM !=0}{$seance.dureeCM}{else} - {/if} </td>
			<td>{if $seance.dureeTD !=0}{$seance.dureeTD}{else} - {/if} </td>
			<td>{if $seance.dureeTP !=0}{$seance.dureeTP}{else} - {/if} </td>
			<td>{$seance.eqTD}</td>
			<td>{if $date_actuelle  >= $seance.dateSeanceFormatee } <span class='glyphicon glyphicon-ok-circle'></span><span class="hide">+</span> {/if}</td>
		</tr>
	{/if}
{/foreach}