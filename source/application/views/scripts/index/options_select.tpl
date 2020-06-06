{foreach name=lista from=$dados_lista item=opcao}
	<option value="{$opcao.id}" {if $cod eq $opcao.id}selected{/if}>{$opcao.nome}</option>
{/foreach}