{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#formPerfil").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-perfil", true);
		}
	});
	
	populaSelect("estadoCivil", "/estado-civil/select?cod={/literal}{$_estadoCivil->int_idaestadocivil}{literal}");
	populaSelect("estado", "/uf/select?cod={/literal}{$_uf->int_idauf}{literal}");
	populaSelect("cidade", "/cidade/select?coduf={/literal}{$_uf->int_idauf}{literal}&cod={/literal}{$_cidade->int_idacidade}{literal}");
	
	$("#estado").change(function(){
		populaSelect("cidade", "/cidade/select?coduf="+$(this).attr("value"));
	});
	
	$("#dataNascimento").mask("99/99/9999");
});
</script>
{/literal}
<div id="container-form-perfil" style="padding:10px">

<div id="container-resposta-perfil"></div>
<form name="formPerfil" id="formPerfil" method="post" action="/perfil/grava-editar?cod={$_usuario->int_idausuario}">
<table border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" width="150" align="right" valign="top">Nome Completo: *</td>
                <td style="padding-bottom:5px; padding-left:10px;"><input type="text" name="nome" id="nome" class="input required" style="width:250px;" value="{$_usuario->vhr_nome}"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Data de nascimento: *</td>
                <td style="padding-bottom:5px; padding-left:10px;"><input type="text" name="dataNascimento" id="dataNascimento" class="input required dateBR" style="width:100px;" value="{$_usuario->dte_nascimento}"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Gênero: *</td>
                <td style="padding-bottom:5px; padding-left:10px;">
                    <select name="genero" id="genero" class="input required">
                    <option value="">. Selecione .</option>
                    <option value="M" {if $_usuario->vhr_sexo eq "M"}selected{/if}>Masculino</option>
                    <option value="F" {if $_usuario->vhr_sexo eq "F"}selected{/if}>Feminino</option>
                    </select>                
                </td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Estado civíl:</td>
                <td style="padding-bottom:5px; padding-left:10px;">
                <select class="input" name="estadoCivil" id="estadoCivil" >
                </select>
                </td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Estado:</td>
                <td style="padding-bottom:5px; padding-left:10px;">
                <select class="input" name="estado" id="estado" >
                </select>                       
                </td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Cidade:</td>
                <td style="padding-bottom:5px; padding-left:10px;">
                <select class="input" name="cidade" id="cidade">
                </select>
                </td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" align="right" valign="top">Profissão:</td>
                <td style="padding-bottom:5px; padding-left:10px;"><input type="text" name="profissao" id="profissao" class="input" style="width:250px;" value="{$_usuario->vhr_profissao}"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px; padding-top:5px;" valign="top" align="right">Quem sou eu:</td>
                <td style="padding-bottom:5px; padding-left:10px;"><textarea rows="3" name="quemSouEu" id="quemSouEu" class="input" style="width:250px;"> {$_usuario->txt_quemsoueu}</textarea></td>
              </tr>
            </table>
            <div align="center" style="padding-top:20px;">
            <span style="padding-right:15px;"><input name="enviar" type="submit" id="enviar2" value="gravar" class="botaoLogin"></span>
            <span style="padding-left:15px;"><input name="limpar" type="button" id="limpar" value="cancelar" class="botaoLogin" onclick="jqAjaxLink('/perfil/detalhe?cod={$_usuario->int_idausuario}', 'container-detalhes-perfil', true);"></span>
            </div>
</form>
</div>