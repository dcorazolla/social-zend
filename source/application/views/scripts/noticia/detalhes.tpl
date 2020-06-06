{literal}
<script type="text/javascript">
$(document).ready(function(){

});
</script>
{/literal}

<div id="container-formulario-noticia-{$_noticia.int_idanoticia}" class='contnoticia' style="margin-left: -170px; padding: 25px; background-color: #fff; border: 1px solid #000; width: 850px; position: absolute; border-top: 1px dashed #000; padding-top: 6px; padding-bottom: 3px; z-index: 999; color: #000;">
  <table width="100%" border="0" cellspacing="1" cellpadding="2">
  	<tr>
      <td align="right">Por <b>{$_usuarioNoticia.vhr_nome}</b> em <b>{$_noticia.dte_criacao}</b></td>
    </tr>
     
    <tr>
      <td><h3>{$_noticia.vhr_titulo}</h3></td>
    </tr>
    
    {if $_noticia.vhr_subtitulo neq ""}
    <tr>
      <td><h2>{$_noticia.vhr_subtitulo}</h2></td>
    </tr>
    {/if}
    
    {if $_noticia.txt_resumo neq ""}
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><blockquote><i>{$_noticia.txt_resumo}</i></blockquote></td>
    </tr>
    {/if}
    
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
      	{if $_noticia.foto neq 0}
        	<img src="/perfil/ver-foto?cod={$_noticia.foto}&cod2={$_noticia.int_idanoticia}" class="bordaFotosNews" width="250" align="left" />
        {/if}
      
      {$_noticia.txt_conteudo}</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    
    {if $_noticia.vhr_fonte neq ""}
    <tr>
      <td>Fonte: {$_noticia.vhr_fonte}</td>
    </tr>
    {/if}
    {if $_noticia.vhr_link neq ""}
    <tr>
      <td><a href="{$_noticia.vhr_link}" target="_blank">{$_noticia.vhr_link}</a></td>
    </tr>
    {/if}
    {if $_noticia.vhr_tags neq ""}
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tags: {$_noticia.vhr_tags}</td>
    </tr>
    {/if}
  </table>
  <div style="border-top: 1px dashed rgb(226, 226, 226); padding-top: 6px; padding-bottom: 3px;" align="right">
            <span style="padding-right: 5px;  text-align: right;"><a href="#" class="botaoFechar" onclick="$('#container-noticias-detalhe-{$_noticia.int_idanoticia}').hide(); $('#container-noticias-resumo-{$_noticia.int_idanoticia}').show('slow'); return false;">&nbsp;<strong>fechar</strong></a></span>
  </div>
</div>
