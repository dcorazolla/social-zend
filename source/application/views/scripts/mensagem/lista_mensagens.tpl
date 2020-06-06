<div align="center">
{foreach name=lista from=$recados item=recado}
<table width="90%" align="center" border="0" cellpadding="2" cellspacing="1" style="padding-bottom: 5px; border-bottom: 1px dashed rgb(226, 226, 226);">
  <tr>
    <td style="padding-right: 5px; padding-bottom: 5px; padding-top: 5px;" valign="top" width="60">
    	<a href="#" onclick="montaInterface('{$recado.usuario.int_idausuario}', '{$recado.usuario.vhr_css}'); return false;"><img src='/perfil/ver-foto?cod={$recado.foto}&mini=1&alt=200' width='100' border="0"/></a>
    </td>
    <td style="padding-bottom: 5px; padding-top: 5px;" valign="top">
    	{if $recado.acao eq 'Recebida de '}<font color="#000066">{else}<font color="#006600">{/if}( {$recado.acao} <b>{$recado.usuario.vhr_nome}</b> em {$recado.dte_criacao} )</font><br />
        <b>{$recado.vhr_titulo}</b><br />
    	{$recado.txt_conteudo}
    </td>
  </tr>
  {if $recado.responder neq 0}
  <tr>
  	<td colspan="2" style="padding-bottom: 5px; padding-top: 5px;" align="right">
    	<input type="button" value="Responder" onclick="jqAjaxLink('/mensagem/form-cadastro?cod={$recado.usuario.int_idausuario}&tit=RE: {$recado.vhr_titulo}', 'container-resposta-mensagem-interno-{$recado.usuario.int_idausuario}', true);" class="botaoLogin"/> &nbsp;
        <div id="container-resposta-mensagem-interno-{$recado.usuario.int_idausuario}"></div>
    </td>
  </tr>
  {/if}
</table>
{/foreach}
</div>