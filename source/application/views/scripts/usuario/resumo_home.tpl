<div style="background-color:#FFF; width: 192px; margin-left: 9px; position:relative;">
<!-- === Foto do Perfil === -->
        <div style="position: absolute; margin-bottom: -19px; margin-left: 5px; z-index: 44; width: 187px;" align="right"><img src="/images/site/nada.gif" class="aba" width="37" height="19"></div>
        <div style="position: relative; width: 187px; z-index: 11; padding-left: 5px;">
        <a href="/perfil/visualizar-foto?cod={$_usuario->int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;" >
        {if $_foto eq false}
        	<img src="/images/site/user.jpg" width="187" border="0">
        {else}
        	<img src="/perfil/ver-foto?cod={$_foto->int_idafotoperfil}&mini=1" width="187" border="0">
        {/if}
        </a>
        </div>
        <!-- Final === Foto do Perfil === -->
</div>
                <!-- === Nome do Usuário === -->
        <div class="sombraTitAzul" style="">
        <div class="bgTitAzul">
        <div align="center">{$_usuario->vhr_nome}</div>
        <div align="center">{$_cidade->vhr_nome} - {$_uf->vhr_sigla}</div>
        </div>
        </div>

        <!-- Final === Nome do Usuário === -->