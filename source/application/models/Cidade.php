<?php
/**
 * Classe model da tabela tbr_cidade
 * @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.models
 * @version			1.0
*/
class Cidade extends Zend_Db_Table_Abstract
{
	protected $_name = "tbr_cidade";
	protected $_dependentTables = array("Usuario");
	protected $_referenceMap = array(
		'Uf' => array(
			'columns' => 'int_idfuf',
			'refTableClass' => 'Uf',
			'refColumns' => 'int_idauf'
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
		
		$slctUnidade->from($this, array("COUNT(int_idaperfil) as total"));
		
		foreach ($where as $coluna=>$valor)
		{
			$slctUnidade->where($coluna." ?", $valor);
		}
		
		$rows = $this->fetchAll($slctUnidade);
		
		return $rows->current()->total;
	}
}
