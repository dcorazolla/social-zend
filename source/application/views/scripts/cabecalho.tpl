<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>{$_site.titulo}</title>
<link rel="stylesheet" type="text/css" href="{$_site.url}css/estilos.css" />
<link rel="stylesheet" type="text/css" href="{$_site.url}css/1.css" id="fundoSite" />
<link rel="stylesheet" type="text/css" href="{$_site.url}css/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="{$_site.url}css/thickbox.css" />
<link rel="stylesheet" type="text/css" href="{$_site.url}css/agile-uploader.css" />

<script type="text/javascript" src="{$_site.url}js/jquery/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate.adicionais.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.validate-messages_ptbr.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.maskedinput-1.2.2.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/funcoes.js"></script>
<script language="javascript" type="text/javascript" src="{$_site.url}js/easySlider1.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/thickbox-compressed.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.autocomplete.js"></script>
<script type="text/javascript" src="{$_site.url}js/jquery/jquery.flash.min.js"></script>
<script type="text/javascript" src="{$_site.url}js/agile-uploader-3.0.js"></script>

{literal}

<script type="text/javascript">
	$(document).ready(function() {
		$("#menu li a").click(function() {
			jqAjaxLink("/usuario/troca-fundo?fundo="+$(this).attr('rel'), "", true);
			$("#fundoSite").attr("href",$(this).attr('rel'));
			return false;
		});
		
		$("#slider").easySlider({
			controlsBefore:	'<p id="controls">',
			controlsAfter:	'</p>',
			auto: true, 
			continuous: true,
			pause: 3000,
			prevId: 'prevBtn',
			nextId: 'nextBtn'
		});
		
		$("#campoBuscaAmigo").autocomplete("/usuario/complete-nome", {
			width: 300,
			max: 10,
			scrollHeight: 300,
			formatItem: function(data, i, n, value) {
				return "<img src='/perfil/ver-foto?cod="+value.split(";")[2]+"&mini=1&alt=200' width='50'/> " + value.split(";")[1];
			},
			formatResult: function(data, value) {
				return value.split(";")[1];
			}
		});
		
		$("#campoBuscaAmigo").result(function(event, data, formatted) {
			montaInterface(formatted.split(";")[0], formatted.split(";")[3]);
		});
		
	});
	
	
</script>

{/literal}
</head>
<body>

<!-- ================ -->
<!-- === Div 100% === -->

<div style="min-height: 100%; width: 100%; margin: auto; position: relative;">

    <div style="margin: auto; padding-bottom:80px;" align="center">
    
    <!-- ================== -->

    <!-- === Barra Topo === -->
    
    <div class="bgBarra" align="center">
    
    <div style=" width:980px;" class="mercurio bold" align="left">    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left">
        {literal}
        <script language="JavaScript">
        var agora = new Date();
        var hora = agora.getHours()
        var minuto = agora.getMinutes()
        var aNome = agora.getYear()
        var mNome = agora.getMonth() + 1;
        var dNome = agora.getDay() + 1;
        var diaNr = ((agora.getDate()<10) ? "0" : "")+ agora.getDate();
        var hora = ((hora<10) ? "0" : "")+ hora;
        var minuto = ((minuto<10) ? "0" : "")+ minuto;
        if (aNome < 2000) { aNome = agora.getYear() + 1900; }
        if(dNome==1) dia = "Domingo";
        if(dNome==2) dia = "Segunda";
        if(dNome==3) dia = "Terça-feira";
        if(dNome==4) dia = "Quarta-feira";
        if(dNome==5) dia = "Quinta-feira";
        if(dNome==6) dia = "Sexta-feira";
        if(dNome==7) dia = "Sábado";
        if(mNome==1) mes="Janeiro";
        if(mNome==2) mes="Fevereiro";
        if(mNome==3) mes="Março";
        if(mNome==4) mes="Abril";
        if(mNome==5) mes="Maio";
        if(mNome==6) mes="Junho";
        if(mNome==7) mes="Julho";
        if(mNome==8) mes="Agosto";
        if(mNome==9) mes="Setembro";
        if(mNome==10) mes="Outubro";
        if(mNome==11) mes="Novembro";
        if(mNome==12) mes="Dezembro";
        var DiaHoje =(" "+diaNr+" de "+mes+" de "+aNome);
        var DiaHora =(" "+dia+" - "+hora+":"+minuto);
        document.write(""+DiaHoje+" - "+DiaHora+"");
        </script>
        {/literal}
        </td>
        <td align="center">

        <div id="menu">
            <ul>
                <li><span style="padding-right:10px;">Temas</span></li>
                <li><a href="#" rel="/css/1.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema1.gif" /></a></li>
                <li><a href="#" rel="/css/2.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema2.gif" /></a></li>        
                <li><a href="#" rel="/css/3.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema3.gif" /></a></li>
                <li><a href="#" rel="/css/4.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema4.gif" /></a></li>
                <li><a href="#" rel="/css/5.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema5.gif" /></a></li>        
                <li><a href="#" rel="/css/6.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema6.gif" /></a></li>
                <li><a href="#" rel="/css/7.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema7.gif" /></a></li>
                <li><a href="#" rel="/css/8.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema8.gif" /></a></li>        
                <li><a href="#" rel="/css/9.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema9.gif" /></a></li>
                <li><a href="#" rel="/css/10.css" title="Clique para mudar o tema" class="vtip"><img src="/images/site/tema10.gif" /></a></li>
            </ul>
        </div>
        </td>
        <td align="right">{$_usuario.vhr_login}<span style="padding-left:10px; padding-right:10px;">|</span><a href="/usuario/sair" title="Clique para sair" class="vtip">sair</a></td>

      </tr>
    </table>    
    </div>
    
    </div>
    
    <!-- Final ============ -->
    <!-- === Barra Topo === -->
    
    <!-- ==================== -->
    <!-- === Logo e Busca === -->
    
    <div style=" width:980px; padding-top:10px;" align="left">    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td align="left"><a href="/index"><img src="/images/site/nada.gif" width="327" height="60" class="logo" /></a></td>
        <td align="right">
        <input name="campoBuscaAmigo" class="inputBusca" id="campoBuscaAmigo" value="procurar amigos" type="text" onclick="this.value = ''">
        </td>
      </tr>
    </table>    
    </div>
    
    <!-- Final ============== -->
    <!-- === Logo e Busca === -->

    
    <!-- ============ -->
    <!-- === site === -->
    
	<div style="width:993px;" align="left">
    
    <div><img src="/images/site/nada.gif" width="993" height="9" class="topo" /></div>
    <div class="bgSite" style="height:100%;"><div class="bgSiteTop" style="height:100%;">