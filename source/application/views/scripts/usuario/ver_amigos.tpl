<div id="container-perfil" style="padding:10px">
<!--
codigo = {$_usuario->int_idausuario}<br />
amigos? {$_saoAmigos}<br />
-->
{literal}
<script type="text/javascript">
$(document).ready(function() {
	
	
	
	
	//jqAjaxLink("/perfil/foto?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-fotos-perfil", true);
	//jqAjaxLink("/perfil/detalhe?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-detalhes-perfil", true);
});
</script>
{/literal}
<table border="0" cellspacing="1" cellpadding="5" width="100%">
    <tr>
        <td>
        	<h1>Amigos</h1>
            Total: {$totalAmigos}
        </td>
    </tr>
    <tr>
    	<td>
        	<div id="container-resposta-amigos"></div>
            <br />
            <div id="container-lista-amigos">
			<table width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tbody>
          {foreach name=lista from=$amigos item=amigo}
          <tr>
          
            <td style="padding-right: 5px; padding-bottom: 3px;" valign="top" width="59">
            <a href="#" onclick="montaInterface('{$amigo.int_idausuario}', '{$amigo.vhr_css}'); return false;"><img src='/perfil/ver-foto?cod={$amigo.foto}&mini=1&alt=200' width='59'/></a>
            </td>
            <td style="padding-bottom: 3px;" valign="top">
            <a href="#" onclick="montaInterface('{$amigo.int_idausuario}', '{$amigo.vhr_css}'); return false;">
            <div>{if $amigo.sao_amigos eq 1}<b style="color:#000">{/if}{if $amigo.sao_amigos eq 2}<b style="color:#F00">{/if}{$amigo.vhr_nome}{if $amigo.sao_amigos eq 1 or $amigo.sao_amigos eq 2}</b>{/if}</div>
            <div>({$amigo.total_noticias}) Notícias</div></a>
            
            <a href="#" onclick="return false;"><div>Enviar Mensagem</div></a>
			</td>
          </tr>
          
          {/foreach}
          
        </tbody></table>
            </div>
        </td>
    </tr>
</table>

            
            <br />

</div>