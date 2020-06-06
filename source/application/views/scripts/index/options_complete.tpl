{foreach name=lista from=$dados_lista item=opcao}
	{$opcao.id};{$opcao.nome};{$opcao.foto};{$opcao.css}
{/foreach}