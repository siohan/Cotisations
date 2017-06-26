<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}
<h3>Cotisation(s) de {$joueur}</h3>
<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom</th>
		<th>Montant total</th>
		<th>Restant dü</th>
		<th colspan="2">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->licence}</td>
	<td> {$entry->nom} {$entry->prenom}</td>
	<td>{$entry->montant_total}</td>
	<td>{$entry->restant}</td>
	{if $entry->restant > 0}	
	<td><a href="{root_url}/admin/moduleinterface.php?mact=Paiements,m1_,add_edit_reglement,0&amp;m1_record_id={$entry->ref_action}&amp;_sk_={$smarty.cookies._sk_}">{$shopping}</a></td>
	<td>{$entry->delete}</td>{/if}
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

