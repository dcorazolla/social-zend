<!-- ======================== -->
        <!-- === Adicionar Amigos === -->

        <div class="SombraTitDireitaAzul">
        <div class="bgTitDireitaAzul">
        <div align="left">Sugestões Amizades</div>
        </div>
        </div>
        
        <div align="center">
{if $_sugestoes eq 0}
    <div align="center">Nenhuma sugestão de amizade no momento</div>
{else}
	{php}$cont = 0;{/php}
<br />
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
    {foreach name=lista from=$_sugestoes item=sug}
    {php}$cont++;
    if ($cont>2){
    	echo "</tr><tr>";
        $cont = 1;
    }{/php}
    <td style="padding: 10px;" valign="top" width="50%">
    	<div style="padding-bottom: 5px;"><a href="#" onclick="montaInterface('{$sug.int_idausuario}', '{$sug.vhr_css}'); return false;"><img src='/perfil/ver-foto?cod={$sug.foto}&mini=1&alt=200' width='120'/></a><!--<img src="/images/site/foto_teste.jpg" width="103" height="87">--></div>
            <div class="bold"><a href="#" onclick="montaInterface('{$sug.int_idausuario}', '{$sug.vhr_css}'); return false;">{$sug.vhr_nome}</a><br>
<!--            <a href="/usuario/adicionar-amigo?cod={$sug.int_idausuario}" onclick="jqAjaxLink($(this).attr('href'), 'container-noticias-home', true); return false;">Adicionar</a>--></div>
     </td>
    {/foreach}
    </tr>
    </table>
{/if}
        
        
<!--        
        <table border="0" cellpadding="0" cellspacing="0">
          <tbody><tr>

            <td style="padding: 10px;" valign="top" width="50%">
            <div style="padding-bottom: 5px;"><img src="/images/site/foto_teste.jpg" width="103" height="87"></div>
            <div class="bold"><a href="#" title="">Fulano de Tal<br>Adicionar</a></div>
            </td>
            <td style="padding: 10px;" valign="top" width="50%">
            <div style="padding-bottom: 5px;"><img src="/images/site/foto_teste.jpg" width="103" height="87"></div>
            <div class="bold"><a href="#" title="">Fulano de Tal<br>Adicionar</a></div>

            </td>
          </tr>
          <tr>
            <td style="padding: 10px;" valign="top" width="50%">
            <div style="padding-bottom: 5px;"><img src="/images/site/foto_teste.jpg" width="103" height="87"></div>
            <div class="bold"><a href="#" title="">Fulano de Tal<br>Adicionar</a></div>
            </td>
            <td style="padding: 10px;" valign="top" width="50%">

            <div style="padding-bottom: 5px;"><img src="/images/site/foto_teste.jpg" width="103" height="87"></div>
            <div class="bold"><a href="#" title="">Fulano de Tal<br>Adicionar</a></div>
            </td>
          </tr>
        </tbody></table>
        -->
        </div>
        
        <!-- Final ================== -->
        <!-- === Adicionar Amigos === -->