        <!-- ======================= -->
        <!-- === Menu do Usuário === -->
        <div style="padding-left: 14px; padding-bottom: 10px; background-color:#FFF; width: 178px; margin-left: 9px;">
<!--
codigo = {$_usuario->int_idausuario}<br />
amigos? {$_saoAmigos}<br />
-->
        <div class="linkBottom"><a href="/index"><img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Home</a></div>
        
        {if $_saoAmigos eq 2}
            <div class="linkBottom">
            	<a href="/mensagem/lista?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_mensagens.gif" style="margin-right: 10px;" align="absmiddle">Minhas Mensagens
                </a>
            </div>
            
            <div class="linkBottom">
            	<a href="/perfil/visualizar?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Meu Perfil
                </a>
            </div>
            
            <div class="linkBottom">
            	<a href="/perfil/visualizar-foto?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Minhas Fotos
                </a>
            </div>
            <div class="linkBottom">
            	<a href="/noticia/lista?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="exibeNoticiasUsuario('{$_usuario->int_idausuario}'); return false;">
            		<img src="/images/site/ic_m_mensagens.gif" style="margin-right: 10px;" align="absmiddle">Minhas Notícias
            	</a>
            </div>
            <div class="linkBottom">
            	<a href="/usuario/ver-amigo?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_m_amigos.gif" style="margin-right: 10px;" align="absmiddle">Meus Amigos
                </a>
            </div>
            <!--
            <div class="linkBottom">
            	<a href="/noticia/amigo?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_n_amigos.gif" style="margin-right: 10px;" align="absmiddle">Notícias de Amigos
                </a>
            </div>
            -->
        {else}
        	<div class="linkBottom">
            	<a href="/perfil/visualizar?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Perfil
                </a>
            </div>
            <div class="linkBottom">
            	<a href="/perfil/visualizar-foto?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Fotos
                </a>
            </div>
            <div class="linkBottom">
            	<a href="/noticia/lista" class="ajaxLinkHome" onclick="exibeNoticiasUsuario('{$_usuario->int_idausuario}'); return false;">
            		<img src="/images/site/ic_n_portal.gif" style="margin-right: 10px;" align="absmiddle">Notícias
            	</a>
            </div>
        	{if $_saoAmigos neq 1}
            <!--
               	<div class="linkBottom">
                    <a href="/usuario/adicionar-amigo?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                    	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Adicionar Amigo
                    </a>
                </div>
            -->
            {else}
            	<div class="linkBottom">
                	<a href="/mensagem/lista?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                    	<img src="/images/site/ic_mensagens.gif" style="margin-right: 10px;" align="absmiddle">Mensagens
                    </a>
                </div>
                <div class="linkBottom">
                	<a href="/usuario/ver-amigo?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                    	<img src="/images/site/ic_m_amigos.gif" style="margin-right: 10px;" align="absmiddle">Amigos
                    </a>
                </div>
                <div class="linkBottom">
                    <a href="/usuario/remover-amigo?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">
                    	<img src="/images/site/ic_perfil.gif" style="margin-right: 10px;" align="absmiddle">Remover Amizade
                    </a>
                </div>
            {/if}
            
        {/if}
        <!--
        <div class="linkBottom"><a href="/noticia/portal" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;"><img src="/images/site/ic_n_portal.gif" style="margin-right: 10px;" align="absmiddle">Notícias do Portal</a></div>
        -->
        </div>
        <!-- Final ================= -->
        <!-- === Menu do Usuário === -->