<?php
class MyPluginAuth extends Zend_Controller_Plugin_Abstract
{
	private $_auth;
	private $_acl;

	private $_noauth = array('module' => 'default',
	'controller' => 'usuario',
	'action' => 'form-login');

	private $_noacl = array('module' => 'default',
	'controller' => 'error',
	'action' => 'sem-autorizacao');

	public function __construct($auth, $acl)
	{
		$this->_auth = $auth;
		$this->_acl = $acl;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{

		$bAltera = false;
                $role = 'guest';
		// Verifica se tem usuario logado
		if ($this->_auth->hasIdentity()) {
			// Caso tenha, pega dados do usuario
			$identity = $this->_auth->getIdentity();
                        //xd($identity);
			if (isset($identity['perfil_nome'])) $role = $identity['perfil_nome']; 
			
		} else {
			 // Caso contrario, associa o perfil de visitante
			$role = 'guest';
		}
		
		$controller = strtolower($request->controller);
		$action = strtolower($request->action);
		$module = strtolower($request->module);
		$resource = $controller;
		 
		 
		 
		if (!$this->_acl->has(strtolower($resource))) {
			//$this->log->debug("Resource $resource nao encontrada.");
			$resource = null;
		}

		if (!$this->_acl->isAllowed($role, $resource, $action)) {

			//$this->log->debug("Não Tem permissão - role: $role - resource: $resource - action: $action.");
			if (!$this->_auth->hasIdentity()) {
				//$this->log->debug("Nao Tem Identity");
				$module = $this->_noauth['module'];
				$controller = $this->_noauth['controller'];
				$action = $this->_noauth['action'];
				
			} else {
				//$this->log->debug("Tem Identity");
				$module = $this->_noacl['module'];
				$controller = $this->_noacl['controller'];
				$action = $this->_noacl['action'];				
			}
			$bAltera = true;
		}
		
		if( $bAltera )
		{
			// seta a action 
			$request->setModuleName($module);
			$request->setControllerName($controller);
			$request->setActionName($action);
			}
	}
}
?>