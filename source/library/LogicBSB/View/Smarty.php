<?php

/**

 * classe que estende o smarty

 * @filesource

 * @author Diogo Corazolla

 * @copyright 2011

 * @package logicbsb

 * @subpackage logicbsb.View

 * @version 1.0

 */



require_once("LogicBSB/View/Smarty-2.6.26/libs/Smarty.class.php");



class LogicBSB_View_Smarty extends Zend_View_Abstract

{

	private $_smarty;

	private $_operationSystem;

	private $_bar;

	private $_pathSeparator;

	private $_documentRoot;

	private $_libraryPath;



	public function __construct($data = array())

	{



		parent::__construct($data);



		$this->_smarty = new Smarty();



		/**

		 * Identifica o sistema operacional do servidor, considerando que pode

		 * ser Windows ou Linux

		 */

		$this->_operationSystem = stripos($_SERVER["SERVER_SOFTWARE"], 'win32')!==FALSE?'WINDOWS':'LINUX';

		$this->_bar = $this->_operatingSystem == 'WINDOWS'?'\\':'/';

		$this->_pathSeparator = $this->_operationSystem=='WINDOWS'?';':':';

		$this->_documentRoot = ($this->_operationSystem=='WINDOWS'?str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']):$_SERVER['DOCUMENT_ROOT']).$this->_bar;

		if(@$data['documentRoot'])

		{

			$this->_documentRoot = $data['documentRoot'];

		}

		//$this->_documentRoot = "/mnt/dados/Projetos/broffices/sistema/";

		//$this->_documentRoot = "/var/www/osm/";

		

		$this->_libraryPath = $this->_documentRoot."library".$this->_bar."LogicBSB".$this->_bar;

		

		/**

		 * recupera as configuracoes do smarty

		 */

		$config = parse_ini_file($this->_libraryPath."config.ini", TRUE);

		

		/**

		 * o diretorio dos templates sera definido pela aplica��o, por isso esta em branco

		 */

		$this->_smarty->caching = (bool)$config["smarty"]["caching"];

		$this->_smarty->cache_lifetime = (int)$config["smarty"]["cachelifetime"];

		$this->_smarty->template_dir = "";

		$this->_smarty->compile_dir = SISPATH.'templates_c';

		$this->_smarty->config_dir = $this->_libraryPath.'View'.$this->_bar.'Smarty-2.6.26'.$this->_bar.'configs';

		$this->_smarty->cache_dir = $this->_libraryPath.'View'.$this->_bar.'Smarty-2.6.26'.$this->_bar.'cache';

		

		/**

		 * coloca o diret�rio do smarty no path do php

		 */

		$smartyPAth = $this->_pathSeparator.$this->_libraryPath.'View'.$this->_bar."Smarty-2.6.26".$this->_bar."libs";

		set_include_path(get_include_path().$smartyPAth);

	}

	

	/**

	 * metodo que configura

	 * diretorio de templates do smarty

	 * @return void

	 */

	public function setTemplateDir($applicationName)

	{

		$this->_smarty->template_dir = $this->_documentRoot.

		//"ZF".$this->_bar.$applicationName.

		//$this->_bar.$applicationName.

		$this->_bar."application".$this->_bar."views".

		$this->_bar."scripts".$this->_bar;

			

	}

	

	/**

	 * o metodo run e o unico que precisa ser implementado em qualquer

	 * subclasse de Zend_View_Abstract.

	 * e chamado automaticamente dentro do metodo render.

	 * a implementacao abaixo, publicada originalmente por Ralf Eggert no

	 * site da Zend, usa o metodo display do Smarty para gerar e imprimir o

	 * template. o exemplo foi modificado por obsolescencia do original.

	 * @return void

	 */

	protected function _run($template="index.tpl")

	{

		$this->_smarty->display($template);

	}

	

	public function assign($spec, $value = NULL)

	{

		if (is_string($spec))

		{

			$this->_smarty->assign($spec, $value);

		}

		elseif (is_array($spec))

		{

			foreach ($spec as $key=>$value)

			{

				$this->_smarty->assign($key, $value);

			}

		}

		else

		{

			throw new Zend_View_Exception("assign() expects a string or array, got ".gettype($var));

		}

	}

	

	public function escape($var)

	{

		if (is_string($var))

		{

			return parent::escape($var);

		}

		elseif (is_array($var))

		{

			foreach ($var as $key=>$val)

			{

				$var[$key] = $this->escape($val);

			}

			return $var;

		}

		else 

		{

			return $var;			

		}

	}

	

	public function output($name)

	{

		$this->_smarty->display($this->_smarty->template_dir.$name);

		exit;

	}

}