{literal}
<script type="text/javascript">
$(document).ready(function(){
	{/literal}
	jqAjaxLink("/comentario/form-cadastro?cod={$_usuario->int_idausuario}&cod2={$_noticia.int_idanoticia}", "container-lista-comentarios-form-{$_noticia.int_idanoticia}", true);
	jqAjaxLink("/comentario/lista?cod={$_usuario->int_idausuario}&cod2={$_noticia.int_idanoticia}", "container-lista-comentarios-{$_noticia.int_idanoticia}", true);
	{literal}
});
</script>
{/literal}
<div id="container-lista-comentarios-{$_noticia.int_idanoticia}"></div>
<div id="container-lista-comentarios-form-{$_noticia.int_idanoticia}"></div>