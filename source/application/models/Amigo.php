<?php
/**
 * Classe model da tabela tbl_acesso
 * @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.models
 * @version			1.0
*/
class Amigo extends Zend_Db_Table_Abstract
{
	protected $_name = "tbl_amigo";
	protected $_referenceMap = array(
		'Usuario1' => array(
			'columns' => 'int_idfusuario1',
			'refTableClass' => 'Usuario',
			'refColumns' => 'int_idausuario'
		),
		'Usuario2' => array(
			'columns' => 'int_idfusuario2',
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
		
		$slct->from($this, array("int_idaamigo",
									"int_idfusuario1",
									"int_idfusuario2",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"dte_aceito"=>"DATE_FORMAT(dte_aceito, '%d/%m/%Y %H:%i:%s')",
									"bln_aceito",
									"txt_solicitacao"));

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
	Verifica se dois usuarios sao amigos
	// 0 = nao sao amigos e não existe solicitação
	// 1 = sao amigos
	// 2 = mesmo usuario
	// 3 = nao sao amigos e exise solicitacao de amizade
	// 4 = nao sao amigos e a solicitacao foi recusada
	// 5 = sao amigos e o usuario esta bloqueado
	// 6 = nao sao amigos e o usuario esta bloqueado
	// 7 = amigo removido
	*/
	public function saoAmigos($usuario1, $usuario2)
	{
		// eh o mesmo usuario
		if ($usuario1 == $usuario2) return 2;
		
		// nao existe solicitacao
		$retorno = 0;
		
		$linha = $this->ultimaSolicitacao($usuario1, $usuario2);
		
		// existe solicitação
		if ($linha) {
			
			$retorno = $linha->bln_aceito;
			
		}

		return $retorno;
	}
	
	public function ultimaSolicitacao($usuario1, $usuario2)
	{
		$slct = $this->select();
		
//		x($usuario1);
//		xd($usuario2);
		
		$slct->from($this, array("int_idaamigo",
									"int_idfusuario1",
									"int_idfusuario2",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"dte_aceito"=>"DATE_FORMAT(dte_aceito, '%d/%m/%Y %H:%i:%s')",
									"bln_aceito",
									"txt_solicitacao"));

		$slct->where('(int_idfusuario1='.$usuario1.' and int_idfusuario2='.$usuario2.')');
        $slct->orWhere('(int_idfusuario1='.$usuario2.' and int_idfusuario2='.$usuario1.')');
		
		$slct->order("int_idaamigo desc");
		
		$slct->limit(1, 0);
		
//		xd("parada");
		
		return $this->fetchAll($slct)->current();
	}
	
	public function solicitacoesPendentes($usuario)
	{
		
		$slct = $this->select();
		
		$slct->from($this, array("int_idaamigo",
									"int_idfusuario1",
									"int_idfusuario2",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"dte_aceito"=>"DATE_FORMAT(dte_aceito, '%d/%m/%Y %H:%i:%s')",
									"bln_aceito",
									"txt_solicitacao"));

		$slct->where('(int_idfusuario2='.$usuario->int_idausuario.' and bln_aceito = 3 and dte_aceito is null)');
		
		$slct->order(array("dte_criacao desc"));
		
		$retorno = $this->fetchAll($slct);
		
		return $retorno;
		
	}
	
	public function buscaAmigos($usuario)
	{
		$slct = $this->select();
		
		$slct->from(array("a"=>"tbl_amigo"), array("int_idaamigo",
									"int_idfusuario1",
									"int_idfusuario2",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"dte_aceito"=>"DATE_FORMAT(dte_aceito, '%d/%m/%Y %H:%i:%s')",
									"bln_aceito",
									"txt_solicitacao"));
/*		$slct->joinInner(array("ac"=>"tbl_acesso"), 
										"u.int_idausuario = a.int_idfusuario1", 
										array("perfil_nome"=>"p.vhr_nome",
												"perfil_id"=>"p.int_idaperfil"));*/

		$slct->where('((int_idfusuario2='.$usuario->int_idausuario.' or int_idfusuario1='.$usuario->int_idausuario.') and bln_aceito = 1)');
		
		$retorno = array();
		
		$amigos = $this->fetchAll($slct)->toArray();
		
		return $amigos;
		
	}
	
	public function buscaAmigosHome($usuario)
	{
		$slct = $this->select();
		
		$ordens = array("int_idaamigo", "int_idfusuario1", "int_idfusuario2", "dte_criacao", "dte_aceito");
		$ordens2 = array("asc", "desc");
	
		$ordem = $ordens[rand(0,count($ordens)-1)]." ".$ordens2[rand(0,count($ordens2)-1)];
		
		$slct->from(array("a"=>"tbl_amigo"), array("int_idaamigo",
									"int_idfusuario1",
									"int_idfusuario2",
									"dte_criacao"=>"DATE_FORMAT(dte_criacao, '%d/%m/%Y %H:%i:%s')",
									"dte_aceito"=>"DATE_FORMAT(dte_aceito, '%d/%m/%Y %H:%i:%s')",
									"bln_aceito",
									"txt_solicitacao"));
/*		$slct->joinInner(array("ac"=>"tbl_acesso"), 
										"u.int_idausuario = a.int_idfusuario1", 
										array("perfil_nome"=>"p.vhr_nome",
												"perfil_id"=>"p.int_idaperfil"));*/

		$slct->where('((int_idfusuario2='.$usuario->int_idausuario.' or int_idfusuario1='.$usuario->int_idausuario.') and bln_aceito = 1)');
		
		$slct->order($ordem);
		
		$slct->limit(10, 0);
		
		$retorno = array();
		
		$amigos = $this->fetchAll($slct)->toArray();
		
		return $amigos;
		
	}
	
	public function buscaTotalAmigos($usuario)
	{
		
		$slct = $this->select();
		
		$slct->from($this, array("count(*) as total"));

		$slct->where('((int_idfusuario2='.$usuario->int_idausuario.' or int_idfusuario1='.$usuario->int_idausuario.') and bln_aceito = 1)');
		
		$rows = $this->fetchAll($slct);
		
		return $rows->current()->total;
		
	}
	
	
	
	
	

	
	
	
	/**
	 * retorna total de registros do banco
	 * @param array $where - array com dados where no formato "nome_coluna_1"=>"valor_1","nome_coluna_2"=>"valor_2"
	 * @return int
	 */
	public function pegaTotal($where=array())
	{
		$slctUnidade = $this->select();
		
		$slctUnidade->from($this, array("COUNT(*) as total"));
		
		foreach ($where as $coluna=>$valor)
		{
			$slctUnidade->where($coluna." ?", $valor);
		}
		
		$rows = $this->fetchAll($slctUnidade);
		
		return $rows->current()->total;
	}
}
