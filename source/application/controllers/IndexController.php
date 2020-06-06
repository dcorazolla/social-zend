<?php
/**
* Controlador principal
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/
class IndexController extends Zend_Controller_Action
{
	
	public function init()
	{
		Zend_Loader::loadClass('Usuario');
		Zend_Loader::loadClass('Amigo');
		//xd(phpinfo());
	}

	public function indexAction()
	{
		$authUsuario = Zend_Auth::getInstance()->getIdentity();
		$cod_usuario = $authUsuario["id"];
		
		$tblUsuario = new Usuario();
		
		$css = "";
		$usuario = "";
		$mensagem = "";
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
			
			if ($usuario)
			{
				$css = $usuario->vhr_css;
				if (!$css || $css=="")
				{
					$css="css/1.css";
				}
				$pagina = "index/bodyindex.tpl";
			} 
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Usuário não encontrado";
			}
			
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não informado";
		}
		
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_css"=>$css),
									true);
	}
	
	public function montaInterfaceAction()
	{
		
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$mensagem = "";
		$scripts = "";

		$get = Zend_Registry::get('get');
		$cod_usuario = $get->cod;
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				switch ($saoAmigos)
				{
					case 0:
					case 1:
					case 2:
					case 3:
					case 5:
					case 6:
					case 7:
					case 4:
						$pagina = "index/index_interface.tpl";
						break;
				}
				
			} 
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Usuário não encontrado";
			}
			
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não informado";
		}
		
		
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem),
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