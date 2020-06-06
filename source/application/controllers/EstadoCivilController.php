<?php
/**
* Controlador EstadoCivil
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/
class EstadoCivilController extends Zend_Controller_Action
{
	
	private $intTamPag;
	
	/**
	 * Este metodo sera executado sempre que a classe for instanciada,
	 * depois do construtor.
	 * Faz o carregamento das classes que serao usadas pelo controlador.
	 * @return void
	 */
	public function init()
	{
		Zend_Loader::loadClass('EstadoCivil');
		
		// inicializando variaveis com valor padrao
		$this->intTamPag = 10;
	}
	
	public function selectAction()
	{
		$get = Zend_Registry::get('get');
		
		$cod = $get->cod;
		
		$arrOpcoes=array();
		
		$tblEstadoCivil = new EstadoCivil();
		$rsEstadoCivil = $tblEstadoCivil->busca(array("bln_ativo="=>1),
								array("int_idaestadocivil"));
								
		foreach ($rsEstadoCivil as $estadoCivil)
		{
			$arrOpcoes[] = array("id"=>$estadoCivil->int_idaestadocivil,
									"nome"=>$estadoCivil->vhr_nome);
		}
		
		$this->montaTela("index/options_select.tpl", 
							array("dados_lista"=>$arrOpcoes,
									"cod"=>$cod), 
							false);
	}
	
	/**
	 * Monta a tela de retorno ao usuario
	 * @param string $corpo - arquivo tpl do corpo
	 * @param array $dados - array com os dados a serem inseridos na tela, no seguinte formato "nome"=>"valor"
	 * @param boolean $exibeHeader - true ou false para exibir header, menu e rodape 
	 * @return void
	 */
	private function montaTela($corpo, $dados=array(), $exibeHeader=true)
	{
		// iniciando view
		$view = Zend_Registry::get('view');
		// setando corpo
		$view->assign('_corpo',$corpo);

		// pegando variaveis globais do site
		$_site = Zend_Registry::get("site");
		// setando variaveis globais ao template
		$view->assign('_site', $_site);
		
		// percorrendo array de dados e inserindo no template
		foreach ($dados as $dado=>$valor)
		{
			$view->assign($dado, $valor);
		}
		
		// define o template master
		$tplLayout = $_site["layout"];
		// se exibirHeader for verdadeiro
		if ($exibeHeader)
		{
			// adiciona cabecalho
			$view->assign('_cabecalho', $_site["header"]);
			// adiciona menu
			$view->assign('_menu', $_site["menu"]);
			// adiciona rodape
			$view->assign('_rodape', $_site["footer"]);
		}
		// se exibirHeader for falso
		else
		{
			// define template master sem cabecalho
			$tplLayout = $_site["layout_sem_header"];
		}
		// retorna o tempalte master, com corpo e variaveis setadas
		$view->output($tplLayout);
	}
}