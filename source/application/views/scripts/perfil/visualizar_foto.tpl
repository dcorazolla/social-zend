<div id="container-perfil" style="padding:10px">
<!--
codigo = {$_usuario->int_idausuario}<br />
amigos? {$_saoAmigos}<br />
-->

{literal}
<script type="text/javascript">
$(document).ready(function() {

{/literal}
{if $_saoAmigos eq 2}
{literal}

		

{/literal}
{/if}
{literal}

//
//	$("#Filedata").change(function(){
//		micoxUpload2(this.form, 300, 'Carregando', fotoEnviada);
//	});

//		var campo_upload = document.getElementById('Filedata')
//		campo_upload.onchange = function(){
//			micoxUpload2(this.form, 10, 'Carregando', fotoEnviada);
//		}

	jqAjaxLink("/perfil/foto?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-fotos-perfil", true);
});
/*
function fotoEnviada(data)
{
	$("#container-resposta-upload-fotos-perfil").html(data);
	jqAjaxLink("/perfil/foto?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-fotos-perfil", false);
	jqAjaxLink("/usuario/exibe-resumo-home?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-resumo-usuario-home", false);
	
	$("#Filedata").change(function(){
		micoxUpload2(this.form, 300, 'Carregando', fotoEnviada);
	});
}
*/
</script>
{/literal}
<table border="0" cellspacing="1" cellpadding="5" width="100%">
    <tr>
        <td>
        	<h1>Fotos</h1>
        </td>
    </tr>
    {if $_saoAmigos eq 2}
    <tr>
        <td align="right">
        
        	<form id="multipleDemo" enctype="multipart/form-data">
            <br style="clear: left;" />
            <div id="multiple"></div>
            <br style="clear: left;" /><br />
            <input type="button" id="botao_enviar_fotos" value="Enviar Fotos" onclick="document.getElementById('agileUploaderSWF').submit();" class="botaoLogin" style="display:none;"/>
            </form>
            {literal}
			<script type="text/javascript">
			$('#multiple').agileUploader({
				formId: 'multipleDemo',
				progressBarColor: '#00ff00',
				flashVars: {
					firebug: false,
					form_action: '/perfil/upload-foto',
					file_limit: 50,
					max_post_size: (10000 * 1024)
				},
				submit_callback: function (texto) {
					alert("ok");
				}
			});  
			</script>
            {/literal}
        <!--
        	<form action='/perfil/upload-foto' id='form_upload_foto'> 
 				Enviar: <input type="file" name="Filedata" id='Filedata' class="input" /> 
			</form> 
         -->
        	<div id="container-resposta-upload-fotos-perfil"></div>
        </td>
    </tr>
    {/if}
    <tr>
    	<td>
        	<div id="container-fotos-perfil"></div>
        </td>
    </tr>
</table>

            
            <br />
</div>