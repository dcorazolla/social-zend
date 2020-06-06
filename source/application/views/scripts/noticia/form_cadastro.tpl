{literal}
<script type="text/javascript">
var editor, html = '';
$(document).ready(function(){
	
	
	
	$("#formNoticia").validate({
		submitHandler:function(form){
//			removeEditor();
			jqAjaxForm(form, "container-resposta-noticia", true);
		}
	});
	
	$("#cancelar").click(function(){
//		removeEditor();
		$("#container-destaques-interno").html("");
	});
	
//	createEditor();
});

function createEditor()
{
	if ( editor )
	{
		editor.destroy();
		editor = null;
	}

	var config = {};
	editor = CKEDITOR.appendTo( 'editor', config, html );
}

function removeEditor()
{
	if ( !editor )
		return;

	editor.destroy();
	editor = null;
}

</script>
{/literal}

<div id="container-resposta-noticia"></div>
<div id="container-formulario-noticia">
<form id="formNoticia" name="formNoticia" method="post" action="/noticia/gravar" onsubmit="$('#texto').html(editor.getData())">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <td>Título:</td>
    </tr>
    <tr>
      <td><label for="titulo"></label>
      <input type="text" name="titulo" id="titulo" class="input required" style="width:400px;"/></td>
    </tr>
    <!--
    <tr>
      <td>Subtítulo:</td>
    </tr>
    <tr>
      <td><input type="text" name="subtitulo" id="subtitulo" class="input" style="width:400px;"/></td>
    </tr>
    <tr>
      <td>Resumo:</td>
    </tr>
    
    <tr>
      <td><textarea name="resumo" id="resumo" class="input" style="width:400px;" rows="5"></textarea></td>
    </tr>
    -->
    <tr>
      <td>Texto:</td>
    </tr>
    <tr>
      <td>
      <textarea name="texto" id="texto" class="input required" style="width:400px;" rows="10"></textarea>
      <div id="editor"></div>
      </td>
    </tr>
    <!--
    <tr>
      <td>Fonte:</td>
    </tr>
    <tr>
      <td><input type="text" name="fonte" id="fonte" class="input"  style="width:400px;"/></td>
    </tr>
    <tr>
      <td>Link para notícia original:</td>
    </tr>
    <tr>
      <td><input type="text" name="link" id="link" class="input url"  style="width:400px;"/></td>
    </tr>
    <tr>
      <td>Palavras chave:</td>
    </tr>
    <tr>
      <td><input type="text" name="tags" id="tags" class="input"  style="width:400px;"/></td>
    </tr>
    -->
    <tr>
      <td>Privacidade:</td>
    </tr>
    <tr>
      <td><input name="publico" type="radio" id="publico" value="1" checked="checked" />
        <label for="publico">Todos podem ver </label>
          <input type="radio" name="publico" id="publico2" value="0"/>
        <label for="publico2">Somente amigos podem ver</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="enviar" id="enviar" value="Enviar" class="botaoLogin" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" class="botaoLogin"/></td>
    </tr>
  </table>
</form>
</div>
