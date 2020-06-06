<?php
/**
 * Classe model da tabela tbl_noticia
 * @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.models
 * @version			1.0
*/
class Noticia extends Zend_Db_Table_Abstract
{
	protected $_name = "tbl_noticia";
	protected $_dependentTables = array("NoticiaTag", 
										"Comentario");
	protected $_referenceMap = array(
		'Usuario' => array(
			'columns' => 'int_idfusuario',
			'refTableClass' => 'Usuario',
			'refColumns' => 'int_idausuario'
		)
	);
	
	/**
	 * Retorna registros do banco de dados
	 * @param array $where - array com dados where no formato "nome_coluna_1"=>"valor_1","nome_coluna_2"=>"valor_2"
	 * @param array $order - array com orders no formado "coluna_1 desc","coluna_2"...
	 * @param int $tamanho - numero de registros que deve retornar
	 * @param int $inicio - offset
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function busca($where=array(), $order=array(), $tamanho=-1, $inicio=-1)
	{
		// criando objeto do tipo select
		$slct = $this->select();
		
		$slct->from($this, array("int_idanoticia",
									"vhr_titulo",
									"txt_conteudo",
									"int_idfusuario",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"bln_ativo",
									"vhr_foto",
									"vhr_video",
									"txt_resumo",
									"vhr_subtitulo",
									"int_cliques",
									"vhr_fonte",
									"vhr_link",
									"vhr_tags",
									"bln_admin",
									"bln_publica"));
		
		// adicionando clausulas where
		foreach ($where as $coluna=>$valor)
		{
			$slct->where($coluna." ?", $valor);
		}

		// adicionando linha order ao select
		$slct->order($order);

		// paginacao 
		if ($tamanho > -1)
		{
			$tmpInicio = 0;
			if ($inicio > -1) 
			{
				$tmpInicio = $inicio;
			}
			$slct->limit($tamanho, $tmpInicio);
		}
		
		// retornando os registros conforme objeto select
		return $this->fetchAll($slct);
	}
	
	public function buscaRestricao($cod, $saoAmigos, $where=array(), $order=array(), $tamanho=-1, $inicio=-1)
	{
		$slct = $this->select();
		/*
		SELECT * FROM `tbl_noticia`
where bln_ativo=1
and (
(bln_publica=1 or bln_admin=1)
or (
int_idfusuario=3
or int_idfusuario in (select int_idfusuario1 from tbl_amigo where int_idfusuario2=3 and bln_aceito=1)
or int_idfusuario in (select int_idfusuario2 from tbl_amigo where int_idfusuario1=3 and bln_aceito=1)
)
)
*/
		
		$slct->from($this, array("int_idanoticia",
									"vhr_titulo",
									"txt_conteudo",
									"int_idfusuario",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"bln_ativo",
									"vhr_foto",
									"vhr_video",
									"txt_resumo",
									"vhr_subtitulo",
									"int_cliques",
									"vhr_fonte",
									"vhr_link",
									"vhr_tags",
									"bln_admin",
									"bln_publica"));
									
		$slct->where('(bln_admin=1)');
		
		if ($saoAmigos==2) {
			$slct->orWhere('(int_idfusuario='.$cod.' or int_idfusuario in (select int_idfusuario1 from tbl_amigo where int_idfusuario2='.$cod.' and bln_aceito=1) or int_idfusuario in (select int_idfusuario2 from tbl_amigo where int_idfusuario1='.$cod.' and bln_aceito=1))');
		}
		elseif ($saoAmigos==1) {
			$slct->orWhere('(int_idfusuario='.$cod.')');
		}
		else
		{
			$slct->orWhere('(int_idfusuario='.$cod.' and bln_publica=1)');
		}
		
        foreach ($where as $coluna=>$valor)
		{
			$slct->where($coluna." ?", $valor);
		}
		
		$slct->order($order);
		
		// paginacao 
		if ($tamanho > -1)
		{
			$tmpInicio = 0;
			if ($inicio > -1) 
			{
				$tmpInicio = $inicio;
			}
			$slct->limit($tamanho, $tmpInicio);
		}
		
		return $this->fetchAll($slct);
	}
	
	/**
	 * apaga um registro da tabela
	 * @param int $codigo - codigo do registro para apagar
	 * @return void
	 */
	public function apaga($codigo)
	{
		$row = $this->find($codigo)->current();
		$row->bln_ativo = 0;
		$row->save();
		//$where = $this->getAdapter()->quoteInto('id = ?', $codigo);
		//$this->delete($where);
	}
	
	
	/**
	 * retorna total de registros do banco
	 * @param array $where - array com dados where no formato "nome_coluna_1"=>"valor_1","nome_coluna_2"=>"valor_2"
	 * @return int
	 */
	public function pegaTotal($where=array())
	{
		$slctUnidade = $this->select();
		
		$slctUnidade->from($this, array("COUNT(int_idanoticia) as total"));
		
		foreach ($where as $coluna=>$valor)
		{
			$slctUnidade->where($coluna." ?", $valor);
		}
		
		$rows = $this->fetchAll($slctUnidade);
		
		return $rows->current()->total;
	}
}
