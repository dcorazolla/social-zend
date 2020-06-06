<?php
/**
* Controlador ANUNCIO
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/
class AnuncioController extends Zend_Controller_Action
{
	
	private $intTamPag;
	

	public function init()
	{
//		Zend_Loader::loadClass('Usuario');
		
		// inicializando variaveis com valor padrao
//		$this->intTamPag = 10;
	}


//	public function indexAction()
//	{
//		$this->_redirect("/index");
//	}
	
	public function exibeAnunciosHomeAction()
	{
		$auth = Zend_Auth::getInstance();
		$usuario = $auth->getIdentity();
		$acessos = array();
		$acesso = array();
		
		// exibe tela
		$this->montaTela("anuncio/anuncios_home.tpl", 
							array("_usuario"=>$usuario),
							false);
	}
	

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
		if ($exibeHeader) $tplLayout = $_site["layout"];
		else $tplLayout = $_site["layout_sem_header"];
		// retorna o tempalte master, com corpo e variaveis setadas
		$view->output($tplLayout);
	}

}