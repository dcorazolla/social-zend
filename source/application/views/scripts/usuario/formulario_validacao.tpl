{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#formValidacao").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-cadastro", true);
		}
	});
	
	{/literal}
	{if $email neq ""}
		$("#botao").click();
	{/if}
	{literal}
	
});
</script>
{/literal}
<div id="container-form-validacao">
<form name="formValidacao" id="formValidacao" method="post" action="/usuario/verifica-validar">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td style="padding-bottom:5px;">Email: *<br />
            <label class="error" generated="true" for="email"></label></td>
            <td style="padding-bottom:5px;" align="right"><input type="text" name="email" id="email" class="input required email" style="width:200px;" value="{$email}"/></td>
        </tr>
        <tr>
			<td style="padding-bottom:5px;">Chave: *<br />
            <label class="error" generated="true" for="chave"></label></td>
            <td style="padding-bottom:5px;" align="right"><input type="text" name="chave" id="chave" class="input required" size="20" style="width:200px;" value="{$chave}"/></td>
        </tr>
    </table>
	<div align="center" style="padding-top:20px;"><input type="submit" value="Validar" name="botao" id="botao" class="botaoLogin"/></div>
</form>
</div>