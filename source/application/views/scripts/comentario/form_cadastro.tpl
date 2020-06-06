{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#formComentario-{/literal}{$_noticia.int_idanoticia}{literal}").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-form-comentario-{/literal}{$_noticia.int_idanoticia}{literal}", true);
		}
	});
	
	$("#cancelarComentario-{/literal}{$_noticia.int_idanoticia}{literal}").click(function(){
		$("#container-lista-comentarios-form-{/literal}{$_noticia.int_idanoticia}{literal}").html("");
	});
});
</script>
{/literal}

<div id="container-resposta-form-comentario-{$_noticia.int_idanoticia}"></div>
<div id="container-form-comentario-{$_noticia.int_idanoticia}">
<form id="formComentario-{$_noticia.int_idanoticia}" name="formComentario-{$_noticia.int_idanoticia}" method="post" action="/comentario/gravar">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td>Comentário:</td>
    </tr>
    <tr>
      <td><textarea name="mensagem" id="mensagem" class="input required" style="width:400px;" rows="3"></textarea></td>
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
      <input type="hidden" name="cod2" id="cod2" value="{$_noticia.int_idanoticia}"/>
      <input type="hidden" name="cod3" id="cod3" value="{$_comentario.int_idacomentario}"/>
      <input type="submit" name="enviar" id="enviar" value="Enviar" class="botaoLogin" />
      <input type="button" name="cancelarComentario-{$_noticia.int_idanoticia}" id="cancelarComentario-{$_noticia.int_idanoticia}" value="Cancelar" class="botaoLogin"/></td>
    </tr>
  </table>
</form>
</div>
