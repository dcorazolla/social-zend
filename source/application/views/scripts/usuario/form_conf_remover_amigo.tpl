{literal}
<script type="text/javascript">
$(document).ready(function(){
	
	$("#sim{/literal}{$_usuario->int_idausuario}{literal}").click(function(){
		jqAjaxLink('/usuario/confirma-remover-amigo?cod={/literal}{$_usuario->int_idausuario}{literal}','container-resposta-solicitacao-remover-amigo{/literal}{$_usuario->int_idausuario}{literal}',true);
	});

	$("#nao{/literal}{$_usuario->int_idausuario}{literal}").click(function(){
		$("#container-solicitacao-remover-amigo{/literal}{$_usuario->int_idausuario}{literal}").hide("slow");
	});
	
});
</script>
{/literal}
<div id="container-solicitacao-remover-amigo{$_usuario->int_idausuario}">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
            <td style="padding-bottom:5px;" valign="top">Deixar de ser amigo de <b>{$_usuario->vhr_nome}</b> ? <br />
            <input type="submit" name="sim{$_usuario->int_idausuario}" id="sim{$_usuario->int_idausuario}" value="sim" class="botaoLogin"> 
            <input type="submit" name="nao{$_usuario->int_idausuario}" id="nao{$_usuario->int_idausuario}" value="não" class="botaoLogin"> 
            <div id="container-resposta-solicitacao-remover-amigo{$_usuario->int_idausuario}"></div>
            </td>
        </tr>
        
    </table>
</div>