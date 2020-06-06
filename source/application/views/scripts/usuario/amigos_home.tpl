<!-- ============== -->
        <!-- === Amigos === -->
        <div class="sombraTitVermelho">

        <div class="bgTitVermelho">
        <div align="center"><a href="/usuario/ver-amigo?cod={$_usuario->int_idausuario}" class="ajaxLinkHome" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;"><font color="#FFFFFF">Amigos ({$totalAmigos})</font></a></div>
        </div>
        </div>
        
        <div style="margin-left:9px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px; background-color:#FFF; width: 172px;" >
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
          {foreach name=lista from=$amigos item=amigo}
          <tr>
          
            <td style="padding-right: 5px; padding-bottom: 3px;" valign="top" width="59">
            <a href="#" onclick="montaInterface('{$amigo.int_idausuario}', '{$amigo.vhr_css}'); return false;"><img src='/perfil/ver-foto?cod={$amigo.foto}&mini=1&alt=150' width='59'/></a>
            </td>
            <td style="padding-bottom: 3px;" valign="top">
            <a href="#" onclick="montaInterface('{$amigo.int_idausuario}', '{$amigo.vhr_css}'); return false;"><div style="font-size:11px;">{if $amigo.sao_amigos eq 1}<b style="color:#000">{/if}{if $amigo.sao_amigos eq 2}<b style="color:#F00">{/if}{$amigo.vhr_nome}{if $amigo.sao_amigos eq 1 or $amigo.sao_amigos eq 2}</b>{/if}</div>
            <div style="font-size:11px;">
            {if $amigo.total_noticias eq 0}
            	Nenhuma Notícia
            {else}
            	({$amigo.total_noticias}) 
            	{if $amigo.total_noticias eq 1}
                	Notícia
                {else}
                	Notícias
                {/if}
            {/if}
            </div>
            <div style="font-size:11px;">
            {if $amigo.total_amigos eq 0}
            	Nenhum Amigo
            {else}
            	({$amigo.total_amigos}) 
            	{if $amigo.total_amigos eq 1}
                	Amigo
                {else}
                	Amigos
                {/if}
            {/if}
            </div></a>
			</td>
          </tr>
          
          {/foreach}
          
        </tbody></table>
        </div>
        <!-- Final ======== -->
        <!-- === Amigos === -->