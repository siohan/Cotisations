<h3>{$nom}</h3>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}&nbsp;&nbsp;</p></div>
{if $itemcount > 0}
	<table border="0" cellspacing="0" cellpadding="0" class="pagetable tablesorter">
	 <thead>
		<tr>
			<th>Licence</th>
			<th>Nom</th>
			<th>Prénom</th> 
			<th>actif</th> 
			<th colspan="4">Actions</th>
			
		</tr>
	</thead>
	 <tbody>
	{foreach from=$items item=entry}
	  <tr class="{$entry->rowclass}">
		<td>{$entry->licence}</td>
		<td>{$entry->nom}</td>
		<td>{$entry->prenom}</td>
		<td>{$entry->actif}</td>
		<td>{$entry->edit}</td>
		<td><a href="{root_url}/admin/moduleinterface.php?mact=Paiements,m1_,view_client_orders,0&amp;m1_licence={$entry->licence}&amp;_sk_={$smarty.cookies._sk_}">{$shopping}</a></td>
		
	   </tr>
	{/foreach}
	 </tbody>
	</table>
	
{/if}
	
