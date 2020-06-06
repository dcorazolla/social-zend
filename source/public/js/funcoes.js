/*
Arquivo de funções javascript para controle de requisições ajax, loaders
Diogo Corazolla - LogicBSB - 2011
socialzend
*/
var num = 0;
var totalLoaders = 0;
var timeoutMilisegundos = 120*1000;
var contNoticias = 0;
var tempo = 1000;
var tipoNoticia = "";

function exibeBlocoNoticias(tamanho,cod){
	var funcao = "";

	for (i=0; i<tamanho; i++) {
		
		if (tipoNoticia=="") {
			tempTempo = 500;
			tipoNoticia = "append";
			funcao = "chamaAjaxNoticia('','"+cod+"')";
			contNoticias = 0;
		}
		else {
			tempTempo = tempo;
			funcao = "chamaAjaxNoticia('"+tipoNoticia+"','"+cod+"')";
		}
		
		setTimeout(funcao, (i*tempTempo));
	}
}

function exibeNoticiasUsuario(cod) {
	tipoNoticia = "";
	exibeBlocoNoticias(10,cod);
}

function chamaAjaxNoticia(tipoNoticia,cod) {
	jqAjaxLink("/noticia/exibe-noticia?num="+contNoticias+"&cod="+cod, "container-noticias-home", true, tipoNoticia);
	contNoticias++;
}

function montaInterface(codUsuario, cssUsuario)
{
	tipoNoticia = "";
	
	if ( !cssUsuario || cssUsuario=="") cssUsuario = "css/1.css";
	
	$("#fundoSite").attr("href", "/"+cssUsuario);
	
	// lado esquerdo
	jqAjaxLink("/usuario/exibe-resumo-home?cod="+codUsuario, "container-resumo-usuario-home", true);
	jqAjaxLink("/usuario/exibe-links-home?cod="+codUsuario, "container-links-usuario-home", true);
	
	// centro
	jqAjaxLink("/usuario/destaque?cod="+codUsuario, "container-destaques-home", true);
	
	// lado direito
	jqAjaxLink("/usuario/exibe-amigos-home?cod="+codUsuario, "container-amigos-usuario-home", true);
	jqAjaxLink("/anuncio/exibe-anuncios-home?cod="+codUsuario, "container-publicidade-home", true);
	jqAjaxLink("/usuario/exibe-sugestao-amigos-home?cod="+codUsuario, "container-sugestao-home", true);
	
	// centro
	exibeBlocoNoticias(10, codUsuario);
}

function exibirLoading()
{
	if (totalLoaders<0) totalLoaders=0;
	totalLoaders++;
	if (totalLoaders==1)
	{
		$("body").append('<div id="loading" class="loading" style="display:none">carregando...</div>');
		$("body div#loading").show("slow");
	}
}

function removerLoading()
{
	totalLoaders--;
	if (totalLoaders<=0)
	{
		$("body div#loading").hide("slow", function(){
			$("body div#loading").remove();
		});
	}
}

function exibirConteudo(conteudo, local, tipo)
{
	if (tipo && tipo=="append")
	{
		$("#"+local).append(conteudo);
	}
	else
	{
//		var cor = $("#"+local).css("backgroundColor","000");
//		$("#"+local).fadeOut("slow", function(){
			$("#"+local).html(conteudo);
//		});
//		$("#"+local).fadeIn("slow");
	}
	
}


function jqAjaxLink(fUrlDestino, fLocalExibir, exibirloading, tipo) {

    $.ajax({
        method: "get",
        url: fUrlDestino,
        data: "",
        dataType: "html",
        timeout: timeoutMilisegundos,
        beforeSend: function(){
			if (exibirloading) exibirLoading();
        },
        complete: function(){
            if (exibirloading) removerLoading();
        },
        success: function(html){ 
			exibirConteudo(html, fLocalExibir, tipo);
        },
        error: function(d,msg) {
			//alert("Erro - "+msg+"\nNao foi possivel carregar arquivo: "+fUrlDestino);
			if (exibirloading) removerLoading();
        }
    });
}

function jqAjaxForm(fDados, fLocalExibir, exibirloading, tipo) {
    // pega todos os campos do formulario
    var params = $(fDados.elements).serialize();

    $.ajax({
        type: 'post',
        data: params,
        url: fDados.action,
        dataType: "html",
        timeout: timeoutMilisegundos,
        beforeSend: function(){
            if (exibirloading) exibirLoading();
        },
        complete: function(){
            if (exibirloading) removerLoading();
        }, //esconde loadig ao terminar
        success: function(html){ //se for bem sucedido exibe html do arquivo
			exibirConteudo(html, fLocalExibir, tipo);
//            $("#"+fLocalExibir).html(html); //insere html na div corpo
        },
        error: function(d,msg) {
            //alert("Erro - "+msg+"\nNao foi possivel carregar arquivo: "+fDados.action);
			if (exibirloading) removerLoading();
        }
    });
}

function populaSelect(destino, url)
{
	$("#" + destino).html("<option value=''>.procurando.</option>");
	jqAjaxLink(url, destino, true);
}

function busca_cep(){

	var cep = $("#cep").attr("value");

	$.ajax({
        method: "get",
        url: "http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+cep,
        data: "",
        dataType: "script",
        timeout: 10000,
        complete: function(){
            $("#lodcep").html("");
        },
        success: function(html){ 
            $("#endereco").val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
			$("#bairro").val(unescape(resultadoCEP["bairro"]));
			$("#cidade").val(unescape(resultadoCEP["cidade"]));
			$("#estado").val(unescape(resultadoCEP["uf"]));
        },
        error: function(d,msg) {
			alert("Nao foi possivel buscar o endereco pelo cep");
			$("#lodcep").html("");
        }
    });

}

