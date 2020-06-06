<!--
cod = {$_usuario->int_idausuario}<br />
amigo? {$saoAmigos}
-->
{if $saoAmigos eq 2}
{literal}
<script type="text/javascript">
function apagar(cod_foto)
{
	if (confirm("Deseja realmente apagar a foto?")){
		jqAjaxLink("/perfil/apagar-foto?cod={/literal}{$_usuario->int_idausuario}{literal}&codFoto="+cod_foto, "container-resposta-foto", true);
	}
}

function perfil(cod_foto)
{
	if (confirm("Colocar foto selecionada como foto do perfil?")){
		jqAjaxLink("/perfil/colocar-foto-perfil?cod={/literal}{$_usuario->int_idausuario}{literal}&codFoto="+cod_foto, "container-resposta-foto", true);
	}
}
</script>
{/literal}
{/if}
<div id="container-resposta-foto"></div>

{if $_fotos eq 0}
    <div align="center">Não foram enviadas fotos ainda</div>
{else}
	{php}$cont = 0;{/php}
<br />
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
    {foreach name=lista from=$_fotos item=foto}
    {php}$cont++;
    if ($cont>3){
    	echo "</tr><tr>";
        $cont = 1;
    }{/php}
    <td valign="middle" align="center">
    	<a href="/perfil/ver-foto?cod={$foto.int_idafotoperfil}" onclick="return hs.expand(this, config1 )" title="foto" target="_blank"><img src="/perfil/ver-foto?cod={$foto.int_idafotoperfil}&mini=1" width="130" style="border:2px dotted {if $foto.bln_ativa eq 1}#f00{else}#000{/if}; padding: 1px; margin: 2px;" ></a><br />
        {if $saoAmigos eq 2}
            {if $foto.bln_ativa neq 1}
	        	<a href="#" onclick="perfil('{$foto.int_idafotoperfil}'); return false;">perfil</a>
        	{/if}
            <a href="#" onclick="apagar('{$foto.int_idafotoperfil}'); return false;">apagar</a>
        {/if}
    </td>
    {/foreach}
    </tr>
    </table>
{/if}
