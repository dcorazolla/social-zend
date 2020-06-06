{literal}
<script type="text/javascript">
$(document).ready(function(){
	
	$("#aceitar{/literal}{$_usuario2->int_idausuario}{literal}").click(function(){
		jqAjaxLink('/usuario/confirma-solicitacao?cod1={/literal}{$_usuario->int_idausuario}{literal}&cod2={/literal}{$_usuario2->int_idausuario}{literal}','container-resposta-solicitacao-aceitar{/literal}{$_usuario2->int_idausuario}{literal}',true);
	});

	$("#recusar{/literal}{$_usuario2->int_idausuario}{literal}").click(function(){
		jqAjaxLink('/usuario/recusa-solicitacao?cod1={/literal}{$_usuario->int_idausuario}{literal}&cod2={/literal}{$_usuario2->int_idausuario}{literal}','container-resposta-solicitacao-aceitar{/literal}{$_usuario2->int_idausuario}{literal}',true);
	});
	
});
</script>
{/literal}
<div id="container-solicitacao-aceitar{$_usuario2->int_idausuario}">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr style="border-top: 1px dashed rgb(226, 226, 226); ">
        	<td style="padding-bottom:5px;" width="70" valign="top"><img src='/perfil/ver-foto?cod={$foto->int_idafotoperfil}&mini=1&alt=200' width='65'/> </td>
            <td style="padding-bottom:5px;" valign="top"><b>{$_usuario2->vhr_nome}</b> Enviou uma solicitação de amizade<br />"{$descricao}"<br />
            <input type="submit" name="aceitar{$_usuario2->int_idausuario}" id="aceitar{$_usuario2->int_idausuario}" value="aceitar" class="botaoLogin"> 
            <input type="submit" name="recusar{$_usuario2->int_idausuario}" id="recusar{$_usuario2->int_idausuario}" value="recusar" class="botaoLogin"> 
            <div id="container-resposta-solicitacao-aceitar{$_usuario2->int_idausuario}"></div>
            </td>
        </tr>
        
    </table>
</div>