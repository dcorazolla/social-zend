<!--
amigos = {$saoAmigos}
-->
{literal}
<script type="text/javascript">
$(document).ready(function(){
{/literal}
{$scripts}
{literal}
});
</script>
{/literal}
<div style="background-color: #fff; margin-top: 2px; margin-bottom: 2px; margin-left: 10px; margin-right: 10px;">
    <div style="border-bottom: 1px dashed rgb(226, 226, 226); padding-top: 3px;">
    {foreach name=lista from=$links item=link}
    	<input type="button" value="{$link.0}" onclick="jqAjaxLink('{$link.1}', 'container-destaques-interno', true);" class="botaoLogin"/> &nbsp;
	{/foreach}
    
        <div id="container-destaques-interno"></div>
    </div>
</div>
