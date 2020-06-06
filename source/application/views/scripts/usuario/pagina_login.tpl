<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>{$_site.titulo}</title>

<link rel="stylesheet" type="text/css" href="{$_site.url}css/estilos.css" /> 
<link rel="stylesheet" type="text/css" href="{$_site.url}css/login.css" /> 

<script type="text/javascript" src="{$_site.url}js/jquery/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/funcoes.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate.adicionais.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate-messages_ptbr.js"></script>
{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#formLogin").validate();
	
	$("#formCadastro").validate({
		submitHandler:function(form){
			jqAjaxForm(form, "container-resposta-cadastro", true);
		}
	});
	
	{/literal}
	{$scripts}
	{literal}
});
</script>
<style>
.error {
	color:#ff0000;
	}
</style>
{/literal}
</head>
<body>

<!-- ================ -->
<!-- === Div 100% === -->

<div style="min-height: 100%; width: 100%; margin: auto; position: relative;">

    <div style="margin: auto; padding-bottom:80px;" align="center">
    
    <!-- ======================== -->
    <!-- === Login e Cadastro === -->
       
	<div style="width:944px; padding-top:80px;" align="left">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="541" style="padding-right:43px;">
        
        <!-- ============= -->
        <!-- === Login === -->
        
        <div><img src="/images/site/nada.gif" width="541" height="207" class="bglogo" /></div>
        <div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="260" valign="top" class="bgBottomlogo"><div class="bold gama" style="padding-top:20px;" align="center"><a href="#"><img src="/images/site/login_esqueceu.gif" align="absmiddle" style="margin-right:10px;" />Esqueceu sua senha?</a></div></td>
            <td width="281" valign="top">
            <div class="bgLogin" id="container-form-login">
            
            {include file="usuario/form_login.tpl"}
            
            </div>
            <div><img src="/images/site/login_bottom_login.gif" /></div>
            </td>
          </tr>
        </table>
        </div>
        
        <!-- Final ======= -->
        <!-- === Login === -->
        
        </td>
        <td width="360" valign="top">
        
        <!-- =================== -->
        <!-- === Cadastre-se === -->
        <div><img src="/images/site/nada.gif" width="360" height="68" class="bgCadastreTopo" /></div>
        <div class="bgCadastreCenter"><div style="background-color:#eeeeee; padding-left:20px; padding-right:20px;">
            <div style="padding-bottom:20px;" class="bold">Os campos que apresentarem * são de Preenchimento obrigatório.</div>
            <div class="bold" id="container-form-cadastro">
            <form action="/usuario/grava-cadastro-inicial" method="post" name="formCadastro" id="formCadastro">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding-bottom:5px;">Nome Completo: *<br />
                <label class="error" generated="true" for="nome"></td>
                <td style="padding-bottom:5px;" align="right"><input type="text" name="nome" id="nome" class="input required" style="width:160px;"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px;">E-mail: *<br />
                <label class="error" generated="true" for="email"></td>
                <td style="padding-bottom:5px;" align="right"><input type="text" name="email" id="email" class="input required email" style="width:160px;"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px;">Confirmar e-mail: *<br />
                <label class="error" generated="true" for="email2"></td>
                <td style="padding-bottom:5px;" align="right"><input type="text" name="email2" id="email2" class="input required email" style="width:160px;"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px;">Password: *<br />
                <label class="error" generated="true" for="senha"></td>
                <td style="padding-bottom:5px;" align="right"><input type="password" name="senha" id="senha" class="input required" style="width:160px;"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px;">Confirmar password: *<br />
                <label class="error" generated="true" for="senha2"></td>
                <td style="padding-bottom:5px;" align="right"><input type="password" name="senha2" id="senha2" class="input required" style="width:160px;"></td>
              </tr>
              <tr>
                <td style="padding-bottom:5px;">Gênero: *<br />
                <label class="error" generated="true" for="genero"></td>
                <td style="padding-bottom:5px;" align="right">
                    <select name="genero" id="genero" class="input required">
                    <option value="">. Selecione .</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    </select>                
                </td>
              </tr>
            </table>
            <div align="center" style="padding-top:20px;"><input name="enviar" type="submit" id="enviar2" value="cadastar-se" class="botaoLogin"></div>
            </form>
            </div>
            <div id="container-resposta-cadastro"></div>
        </div></div>
        <div><img src="/images/site/login_cadastre_bottom.gif" /></div>
        
        <!-- Final ============= -->
        <!-- === Cadastre-se === -->
        
        </td>
      </tr>
    </table>
    </div>
    
    <!-- Final ================== -->
    <!-- === Login e Cadastro === --> 
    
    </div>

    <!-- ================= -->
    <!-- === Copyright === -->
    
    <div style="width: 100%; left:0; bottom: 0; position: absolute; background-color:#FFFFFF;" align="center">    
        <div style="padding-top:10px; padding-bottom:10px; width:980px;" align="left">&nbsp;&nbsp;&nbsp;<strong>socialzend</strong> - Rede Social de Notícias </div>    
    </div>
    
    <!-- Final =========== -->
    <!-- === Copyright === -->

</div>

<!-- Final ========== -->
<!-- === Div 100% === -->

</body>
</html>