{*<pre>{$rowarray|var_dump}</pre>
*}<div class="pageoverflow">
	
{$formstart}

<div class="pageoverflow">
    <p class="pagetext">Licence :</p>
    <p class="pageinput">{$licence1}</p>
  </div>

{foreach from=$rowarray key=key item=entry}
<div class="pageoverflow">
    <p class="pageinput"><input type="checkbox"  name="m1_licence[{$entry['id_cotisation']}]" id="m1_licence[{$key}]" {if $entry['participe'] ==1}checked='checked' {/if} value = '1'>{$entry['nom']}</p>
  </div>
{/foreach}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
  </div>
{$formend}
</div>
{**}