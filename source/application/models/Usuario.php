<?php
/**
 * Classe model da tabela tbl_usuario
 * @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.models
 * @version			1.0
*/
class Usuario extends Zend_Db_Table_Abstract
{
	protected $_name = "tbl_usuario";
	protected $_dependentTables = array("Acesso",
										"Recado",
										"Noticia",
										"Comentario",
										"Amigo",
										"FotoPerfil",
										"Comentario");
	protected $_referenceMap = array(
		'Perfil' => array(
			'columns' => 'int_idfperfil',
			'refTableClass' => 'Perfil',
			'refColumns' => 'int_idaperfil'
		),
		'Cidade' => array(
			'columns' => 'int_idfcidade',
			'refTableClass' => 'Cidade',
			'refColumns' => 'int_idacidade'
		),
		'EstadoCivil' => array(
			'columns' => 'int_idfestadocivil',
			'refTableClass' => 'EstadoCivil',
			'refColumns' => 'int_idaestadocivil'
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
		
		$slct->setIntegrityCheck(false);

		$slct->from(array("u"=>"tbl_usuario")); 
		$slct->joinInner(array("p"=>"tbr_perfil"), 
										"u.int_idfperfil = p.int_idaperfil", 
										array("perfil_nome"=>"p.vhr_nome",
												"perfil_id"=>"p.int_idaperfil"));

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
		
//		xd($this->fetchAll($slct));
		
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
		$slct = $this->select();
		
		$slct->setIntegrityCheck(false);

		$slct->from(array("u"=>"tbl_usuario"), array("COUNT(u.int_idausuario) as total")); 
		$slct->joinInner(array("p"=>"tbr_perfil"), 
										"u.int_idfperfil = p.int_idaperfil");
		
		foreach ($where as $coluna=>$valor)
		{
			$slct->where($coluna." ?", $valor);
		}
		
		$rows = $this->fetchAll($slct);
		
		return $rows->current()->total;
	}
	
	
	public function buscaSugestaoAmigo($usuario)
	{
/*		
select t1.* 
    from tbl_usuario t1
    where 
        not t1.int_idausuario = 1
        and
        t1.int_idausuario not in (
            select t2.int_idfusuario1 from tbl_amigo t2 where t2.int_idfusuario2 = 1
        )
        and
        t1.int_idausuario not in (
            select t3.int_idfusuario2 from tbl_amigo t3 where t3.int_idfusuario1 = 1
        )
*/
		
		$slct = $this->select();
		$retorno = array();
		
		$cidade = $usuario->findParentRow("Cidade");
		if ($cidade) $uf = $cidade->findParentRow("Uf");
		
		$ordens = array("u.int_idausuario", "u.vhr_nome", "u.vhr_login", "u.dte_cadastro", "u.dte_ativacao", "u.vhr_email");
		$ordens2 = array("asc", "desc");
	
		$ordem = $ordens[rand(0,count($ordens)-1)]." ".$ordens2[rand(0,count($ordens2)-1)];

		// usuarios mesma cidade
		$slct->from(array("u"=>"tbl_usuario"), array("int_idausuario"=>"u.int_idausuario",
													"vhr_nome"=>"u.vhr_nome",
													"vhr_css"=>"u.vhr_css"));
		$slct->where('not u.int_idausuario = '.$usuario->int_idausuario);
		$slct->where('u.int_idausuario not in (select a1.int_idfusuario1 from tbl_amigo a1 where a1.int_idfusuario2 = '.$usuario->int_idausuario.' and bln_aceito in (3,1))');
		$slct->where('u.int_idausuario not in (select a2.int_idfusuario2 from tbl_amigo a2 where a2.int_idfusuario1 = '.$usuario->int_idausuario.' and bln_aceito in (3,1))');
		$slct->where('u.bln_ativo = 1');
//		$slct->where('u.int_idfcidade = '.$usuario->int_idfcidade);
		// se tiver cidade, vai pela cidade
//		if ($usuario->int_idfcidade && $usuario->int_idfcidade!="" && $usuario->int_idfcidade>0)
//		{
//			$slct->where('u.int_idfcidade = '.$usuario->int_idfcidade);
//		}
		
		$slct->order($ordem);
		
// limite
		$slct->limit(4, 0);
		
		$rows = $this->fetchAll($slct)->toArray();
		
		return $rows;
		
	}
}
