<div class="pageoptions"><p><span class="pageoptions warning">{$add_edit_types_cotis} </span></p></div>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p></div>

{if $itemcount > 0}

<table cellpadding="0" class="pagetable cms_sortable tablesorter" id="articlelist">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom</th>
		<th>Description</th>
		<th>Tarif</th>
		<th>Actif</th>
		<th>Nb utilisateurs</th>
		<th colspan="3">Actions</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td> {$entry->nom}</td>
	<td>{$entry->description}</td>
	<td>{$entry->tarif}</td>
	<td>{$entry->actif}</td>
	<td>{$entry->nb_users}</td>
	<td>{$entry->editlink}</td>
	<td>{$entry->delete}</td>
	<td>{$entry->add_users}</td>
  </tr>
{/foreach}
 </tbody>
</table>

{/if}

