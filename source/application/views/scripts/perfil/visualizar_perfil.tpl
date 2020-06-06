<div id="container-perfil" style="padding:10px">
<!--
codigo = {$_usuario->int_idausuario}<br />
amigos? {$_saoAmigos}<br />
-->
{literal}
<script type="text/javascript">
$(document).ready(function() {
	jqAjaxLink("/perfil/detalhe?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-detalhes-perfil", true);
});
</script>
{/literal}
<table border="0" cellspacing="1" cellpadding="5" width="100%">
    <tr>
        <td>
        	<h1>Perfil</h1>
        </td>
    </tr>
    <tr>
    	<td>
        	<div id="container-detalhes-perfil"></div>
        </td>
    </tr>
    {if $_saoAmigos eq 2}
    <tr>
        <td>
        	<h1>Detalhes da conta</h1>
        </td>
    </tr>
    {/if}
</table>
<br />
</div>