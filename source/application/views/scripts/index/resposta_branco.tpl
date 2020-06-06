{literal}
<script language="javascript">
$(document).ready(function(){
{/literal}
{$scripts}
{literal}
});
{/literal}
</script>
{if $mensagem}
{$mensagem}
{else}
{$descricao}
{/if}