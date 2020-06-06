<!-- ... {$_num} ... -->
{if $_noticia neq null}

<!-- ================ -->
        <!-- === Mensagem === -->
        
        <div class="msg" style="background-color: #fff; overflow:hidden; width: 400px;" id="container-noticias-{$_noticia.int_idanoticia}">
        
        	<div id="container-noticias-resumo-{$_noticia.int_idanoticia}">

                <div style="border-top: 1px dashed #000; padding-top: 10px;">{$_noticia.dte_criacao}</div>
                    <h3>{$_noticia.vhr_titulo}</h3>
                    <div style="padding-bottom: 10px; padding-top: 15px;">            
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody><tr>
                      {if $_noticia.foto neq 0}
                        <td style="padding-right: 20px;" valign="top" width="145"><img src="/perfil/ver-foto?cod={$_noticia.foto}&cod2={$_noticia.int_idanoticia}&mini=1&alt=200" class="bordaFotosNews" width="145"></td>
                       {/if}
                        <td valign="top">{$_noticia.txt_resumo}</td>
                      </tr>
                    </tbody></table>            
                </div>

            </div>
            
            <div id="container-noticias-detalhe-{$_noticia.int_idanoticia}"></div>
			
           
            <div style="border-bottom: 1px dashed rgb(226, 226, 226); border-top: 1px dashed rgb(226, 226, 226); padding-top: 6px; padding-bottom: 3px;">
                <span style="padding-right: 5px;">
                	<a href="#" onclick="montaInterface('{$_usuarioNoticia.int_idausuario}', '{$_usuarioNoticia.vhr_css}'); return false;">
                    	<img src='/perfil/ver-foto?cod={$_usuarioNoticia.foto}&mini=1&alt=200' width='40' border="0" align="absmiddle"/><!--<img src="/images/site/ic_usuario.gif" width="27" align="absmiddle" border="0" height="26">-->
                        &nbsp;<strong>{$_usuarioNoticia.vhr_nome}</strong>
                    </a>
                </span>
                <span style="padding-right: 5px;"><a href="/noticia/detalhe?cod={$_noticia.int_idfusuario}&cod2={$_noticia.int_idanoticia}" onclick="$('.botaoFechar').click(); jqAjaxLink($(this).attr('href'), 'container-noticias-detalhe-{$_noticia.int_idanoticia}', true); $('#container-noticias-detalhe-{$_noticia.int_idanoticia}').show(); $('#container-noticias-resumo-{$_noticia.int_idanoticia}').hide('slow'); return false;"><img src="/images/site/ic_leia.gif" width="27" align="absmiddle" border="0" height="26">&nbsp;<strong>leia mais</strong></a></span>
                <span><a href="/comentario/ver?cod={$_noticia.int_idfusuario}&cod2={$_noticia.int_idanoticia}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-comentario-{$_noticia.int_idanoticia}', true); $('#container-noticias-comentario-{$_noticia.int_idanoticia}').show(); return false;"><img src="/images/site/ic_comentario.gif" width="27" align="absmiddle" border="0" height="26">&nbsp;<strong>
                <span id="contador-comentarios-{$_noticia.int_idanoticia}">
                {if $_noticia.total_comentarios eq 0}
                Nenhum Comentário
                {else}
                    {if $_noticia.total_comentarios eq 1}
                    1 Comentário
                    {else}
                        {$_noticia.total_comentarios} Comentários
                    {/if}
                {/if}
                </span>
                </strong></a></span>
            </div>

			<div id="container-noticias-comentario-{$_noticia.int_idanoticia}"></div>
        
        </div>
        
        <!-- Final ========== -->
        <!-- === Mensagem === -->
        
       
{/if}
{if $_num is div by 10}
	{literal}
	<script>
	$(document).ready(function(){
		$("#btnMais_{/literal}{$_num}{literal}").click(function(){
			$("#container_botao_mais_{/literal}{$_num}{literal}").remove();
			exibeBlocoNoticias(10, '{/literal}{$_usuario->int_idausuario}{literal}');
		});
	});
	</script>
	{/literal}
	<div id="container_botao_mais_{$_num}" align="center"><input type="button" id="btnMais_{$_num}" value="Mais Notícias" class="botaoLogin" /></div>
{/if}