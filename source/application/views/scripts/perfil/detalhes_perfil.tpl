{literal}
<script type="text/javascript">
$(document).ready(function(){

});
</script>
{/literal}
<div id="container-form-perfil" style="padding:10px">

<table border="0" cellspacing="1" cellpadding="5" width="100%">
{if $_saoAmigos eq 2}
		<tr>
            <td align="left" colspan="2"><input name="btneditar" type="button" id="btneditar" value="editar" class="botaoLogin" onclick="jqAjaxLink('/perfil/editar?cod={$_usuario->int_idausuario}', 'container-detalhes-perfil', true);"><br /></td>
        </tr>
{/if}        
        <tr>
            <td width="150" align="right" valign="top" height="20"><b>Nome Completo:</b></td>
            <td valign="top" >{$_usuario->vhr_nome}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Data de nascimento:</b></td>
            <td valign="top">{$_usuario->dte_nascimento}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Gênero:</b></td>
            <td valign="top">{if $_usuario->vhr_sexo eq 'F'}Feminino{else}Masculino{/if}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Estado civíl:</b></td>
            <td valign="top">{$_estadoCivil->vhr_nome}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Estado:</b></td>
            <td valign="top">{$_uf->vhr_nome}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Cidade:</b></td>
            <td valign="top">{$_cidade->vhr_nome}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Profissão:</b></td>
            <td valign="top">{$_usuario->vhr_profissao}</td>
        </tr>
        <tr>
            <td align="right" valign="top" height="20"><b>Quem sou eu:</b></td>
            <td valign="top">{$_usuario->txt_quemsoueu}</td>
        </tr>
    </table>