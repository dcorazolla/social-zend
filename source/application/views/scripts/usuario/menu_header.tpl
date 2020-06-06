{literal}
<script type="text/javascript">
$(document).ready(function(){
	jqAjaxLink("/usuario/exibe-resumo-home", "container-resumo-usuario-home", true);
	jqAjaxLink("/usuario/exibe-links-home", "container-links-usuario-home", true);
	jqAjaxLink("/usuario/exibe-amigos-home", "container-amigos-usuario-home", true);
	jqAjaxLink("/anuncio/exibe-anuncios-home", "container-publicidade-home", true);
	jqAjaxLink("/usuario/exibe-sugestao-amigos-home", "container-sugestao-home", true);

});
</script>
{/literal}
<a href="/usuario/sair">Sair</a>