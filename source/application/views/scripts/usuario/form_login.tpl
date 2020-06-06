<form action="/usuario/realiza-login" method="post" name="formLogin" id="formLogin">
            
                <div align="left"><strong>Login:</strong> <label class="error" generated="true" for="login"></label></div>
                <div style="padding-top:5px; padding-bottom:10px;"><input type="text" name="login" id="login"  class="input required" style="width:220px;"></div>
                <div align="left"><strong>Senha:</strong>  <label class="error" generated="true" for="senha"></label></div>
                <div style="padding-top:5px; padding-bottom:5px;"><input type="password" name="senha" id="senha" class="input required" style="width:220px;"></div>
                <div style="padding-top:15px;" align="center"><input type="submit" name="enviar" id="enviar" value="logar" class="botaoLogin"></div>
                
                {if $mensagem != ""}
                <span class='erro'>{$mensagem}</span>
                {/if}
            
            </form>