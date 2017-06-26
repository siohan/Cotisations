<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom</th>
		<th>Montant total</th>
		<th colspan="3">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->licence}</td>
	<td> {$entry->nom} {$entry->prenom}</td>
	<td>{$entry->montant_total}</td>
	<td>{$entry->view}</td>
	<!--<td>{$entry->actif}</td>
	<td>{$entry->nb_users}</td>
	<td><a href="{root_url}/admin/moduleinterface.php?mact=Cotisations,m1_,view_adherent_cotis,0&amp;m1_licence={$entry->licence}&amp;_sk_={$smarty.cookies._sk_}">{$shopping}</a></td>
	{if $entry->montant_total == 0}	
	
	<td>{$entry->delete}</td>{/if}
  </tr>-->
{/foreach}
 </tbody>
</table>

{/if}

