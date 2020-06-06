<div id="container-mensagens-form-{$_usuario.int_idausuario}">

{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#formMensagem-{/literal}{$_usuario.int_idausuario}{literal}").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-form-mensagem-{/literal}{$_usuario.int_idausuario}{literal}", true);
		}
	});
	
	$("#cancelarMensagem-{/literal}{$_usuario.int_idausuario}{literal}").click(function(){
		$("#container-mensagens-form-{/literal}{$_usuario.int_idausuario}{literal}").html("");
	});

});
</script>
{/literal}

<div id="container-resposta-form-mensagem-{$_usuario.int_idausuario}"></div>
<div id="container-form-noticia-{$_usuario.int_idausuario}">
<form id="formMensagem-{$_usuario.int_idausuario}" name="formMensagem-{$_usuario.int_idausuario}" method="post" action="/mensagem/gravar">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
  	    <tr>
      <td>&nbsp;</td>
    </tr>
  	<tr>
      <td>Para: {$_usuario.vhr_nome}</td>
    </tr>
  	<tr>
      <td>Título:</td>
    </tr>
    <tr>
      <td><input type="text" name="titulo" id="titulo" class="input required" style="width:400px;" value="{$_titulo}" /></td>
    </tr>
    <tr>
      <td>Mensagem:</td>
    </tr>
    <tr>
      <td><textarea name="mensagem" id="mensagem" class="input required" style="width:400px;" rows="5"></textarea></td>
    </tr>
    <!--
    <tr>
      <td>Privacidade:</td>
    </tr>
    <tr>
      <td><input name="publico" type="radio" id="publico" value="1" checked="checked" />
        <label for="publico">Todos podem ver 
          <input type="radio" name="publico" id="publico2" value="0"/>
        Somente o dono da notícia pode ver</label></td>
    </tr>
    -->
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="hidden" name="cod" id="cod" value="{$_usuario->int_idausuario}"/>
      <input type="submit" name="enviar" id="enviar" value="Enviar" class="botaoLogin" />
      <input type="button" name="cancelarMensagem-{$_usuario.int_idausuario}" id="cancelarMensagem-{$_usuario.int_idausuario}" value="Cancelar" class="botaoLogin"/></td>
    </tr>
  </table>
</form>
</div>
