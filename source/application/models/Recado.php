<?php
/**
 * Classe model da tabela tbl_recado
 * @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.models
 * @version			1.0
*/
class Recado extends Zend_Db_Table_Abstract
{
	protected $_name = "tbl_recado";
	
	protected $_referenceMap = array(
		'UsuarioOrigem' => array(
			'columns' => 'int_idfusuarioorigem',
			'refTableClass' => 'Usuario',
			'refColumns' => 'int_idausuario'
		),
		'UsuarioDestino' => array(
			'columns' => 'int_idfusuariodestino',
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
		$slctUnidade = $this->select();
		
		$slct->from($this, array("int_idarecado",
									"int_idfusuarioorigem",
									"int_idfusuariodestino",
									"txt_conteudo",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"vhr_titulo",
									"bln_ativo"));

		// adicionando clausulas where
		foreach ($where as $coluna=>$valor)
		{
			$slctUnidade->where($coluna." ?", $valor);
		}

		// adicionando linha order ao select
		$slctUnidade->order($order);

		// paginacao 
		if ($tamanho > -1)
		{
			$tmpInicio = 0;
			if ($inicio > -1) 
			{
				$tmpInicio = $inicio;
			}
			$slctUnidade->limit($tamanho, $tmpInicio);
		}
		
		// retornando os registros conforme objeto select
		return $this->fetchAll($slctUnidade);
	}
	
	
	public function buscaRecados($codUsuario, $where=array(), $order=array(), $tamanho=-1, $inicio=-1)
	{
		// criando objeto do tipo select
		$slct = $this->select();
		
		$slct->from($this, array("int_idarecado",
									"int_idfusuarioorigem",
									"int_idfusuariodestino",
									"txt_conteudo",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"vhr_titulo",
									"bln_ativo"));
									
		$slct->where('(int_idfusuarioorigem='.$codUsuario.' or int_idfusuariodestino='.$codUsuario.')');

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
		
		$slctUnidade->from($this, array("COUNT(int_idarecado) as total"));
		
		foreach ($where as $coluna=>$valor)
		{
			$slctUnidade->where($coluna." ?", $valor);
		}
		
		$rows = $this->fetchAll($slctUnidade);
		
		return $rows->current()->total;
	}
}
