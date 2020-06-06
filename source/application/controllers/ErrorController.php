<?php
/**
* Controlador ERROR
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

		$mensagem = "";
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
				$mensagem = "Página não encontrada";
//                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
				$mensagem = "Erro na aplicação";
//                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
//        if ($log = $this->getLog()) {
//            $log->crit($this->view->message, $errors->exception);
//        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
//        $this->view->request   = $errors->request;
		$this->montaTela("index/resposta_erro.tpl", 
							array("descricao"=>$mensagem,
									"trace"=>$errors->exception,
									"scripts"=>""),
							false);
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }
	
	public function semAutorizacaoAction()
	{
		
		$trace = "referer: ".$_SERVER['HTTP_REFERER']."<br>\n
					self: ".$_SERVER['PHP_SELF'];
		
		$this->montaTela("index/resposta_erro.tpl", 
							array("descricao"=>"Você não tem permissão para ver esta página.", 
									"trace"=>$trace,
									"scripts"=>""),
							false);
	}
	
	public function naoLogadoAction()
	{
		
		$this->montaTela("index/resposta_erro.tpl", 
							array("descricao"=>"Acesse...", 
									"trace"=>"",
									"scripts"=>""),
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
		// adiciona cabecalho
		$view->assign('_cabecalho', $_site["header"]);
		// adiciona rodape
		$view->assign('_rodape', $_site["footer"]);
		// retorna o tempalte master, com corpo e variaveis setadas
		$view->output($tplLayout);
	}
}

