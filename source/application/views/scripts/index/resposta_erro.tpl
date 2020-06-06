{literal}
<script type="text/javascript">
if (jQuery) {
	$(document).ready(function(){
	{/literal}
	{$scripts}
	{literal}
	});
}
</script>
<style>
.erro {
    background:#fed url(/images/erro.gif) 3px 3px no-repeat;
    border: 1px solid red;
    text-align:center;
    padding: 10px;
	padding-left: 45px;
/*	margin-top: 10px;*/
/*	margin-bottom: 10px;*/
/*    font-size:12px;*/
    display:block;
}
</style>
{/literal}
<div class="erro">
<p>{$descricao}</p>
<!--
{$trace}
-->
</div>
