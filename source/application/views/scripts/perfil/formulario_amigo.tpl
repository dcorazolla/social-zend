{literal}
<script type="text/javascript">

$(document).ready(function(){
	$("#formAmigo").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-perfil", true);
		}
	});
});

</script>
{/literal}

<table border="0" cellspacing="1" cellpadding="5" width="100%">
    <tr>
        <td>
        	<h1>Adicionar Amigo</h1>
        </td>
    </tr>
</table>

<br />

<div id="container-resposta-perfil"></div>
<form name="formAmigo" id="formAmigo" method="post" action="/usuario/adicionar-amigo-gravar?cod={$_usuario->int_idausuario}">
<table border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" width="150" align="right">Usuário:</td>
                <td style="padding-bottom:5px; padding-left:10px;">{$_usuario->vhr_nome} <input type="hidden" name="nomeUsuario" value="{$_usuario->vhr_nome}" /></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" valign="top" align="right">Mensagem:</td>
                <td style="padding-bottom:5px; padding-left:10px;"><textarea rows="3" name="mensagem" id="mensagem" class="input" style="width:250px;"> Deseja ser meu amigo?</textarea></td>
              </tr>
            </table>
            <div align="center" style="padding-top:20px;">
            <span style="padding-right:15px;"><input name="enviar" type="submit" id="enviar2" value="enviar" class="botaoLogin"></span>
            <span style="padding-left:15px;"><input name="limpar" type="reset" id="limpar" value="limpar" class="botaoLogin"></span>
            </div>
</form>
