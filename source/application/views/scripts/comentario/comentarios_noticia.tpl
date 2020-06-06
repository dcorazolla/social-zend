<table>
{foreach name=lista from=$comentarios item=coment}
  <tr>
    <td style="padding-right: 5px; padding-bottom: 3px;" valign="top" width="60">
    <img src='/perfil/ver-foto?cod={$coment.foto}&mini=1&alt=200' width='60'/>
    </td>
    <td style="padding-bottom: 3px; border-bottom: 1px dashed rgb(226, 226, 226);" valign="top">
    	<b>{$coment.usuario.vhr_nome}</b> em {$coment.dte_criacao}<br />
    	{$coment.txt_conteudo}
    </td>
  </tr>
{/foreach}
</table>