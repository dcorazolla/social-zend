<?php

/**
* Arquivo principal da aplicacao
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @version			1.0
*/

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

/*************************************************************************************
 * CONFIGURACOES DE AMBIENTE
 *************************************************************************************/
include("config.php");
include_once("funcoes/FuncoesGerais.php");
//include_once("funcoes/FuncoesData.php");
//include_once("application/Constantes.php");
//include_once("application/class.datetimecalc.php");

/*************************************************************************************
 * INCLUINDO E INICIANDO CLASSES ZEND
 *************************************************************************************/
include('Zend/Loader.php');

Zend_Loader::loadClass('Zend_Registry');			
Zend_Loader::loadClass('Zend_Session');				/** Classe para controle de sessoes */
Zend_Loader::loadClass('Zend_Controller_Front'); 	/** Classe de controladores */
Zend_Loader::loadClass('Zend_View'); 				/** Classe das visoes */
Zend_Loader::loadClass('Zend_Config_Ini'); 			/** Classe usada para configuracoes */
Zend_Loader::loadClass('Zend_Db'); 					/** Classe para acesso a base de dados */
Zend_Loader::loadClass('Zend_Db_Table'); 			/** Classe para usar as tabelas como objetos */
Zend_Loader::loadClass('Zend_Filter_Input'); 		/** Classe usada para filtrar os dados */
Zend_Loader::loadClass('Zend_Session'); 			/** Classe usada para gerenciar a sessao */
Zend_Loader::loadClass('Zend_Session_Namespace');	/** Classe usada para armazenar e recuperar dados da sessao */
Zend_Loader::loadClass('Zend_Acl');	
Zend_Loader::loadClass('Zend_Acl_Role');
Zend_Loader::loadClass('Zend_Acl_Resource');
Zend_Loader::loadClass('Zend_Date');
Zend_Loader::loadClass('Zend_Mail');
Zend_Loader::loadClass('Zend_Mail_Transport_Smtp');
Zend_Loader::loadClass('Zend_File_Transfer'); 		/** Classe usada para fazer upload de arquivos */
Zend_Loader::loadClass('Zend_File_Transfer_Adapter_Http');

/*************************************************************************************
 * BANCO DE DADOS
 *************************************************************************************/

/** Configuracoes da base de dados.
 * Indica onde estao as configuracoes do projeto.
 * Estao no arquivo config.ini na secao database.
 */
$config = new Zend_Config_Ini('../application/config.ini', 'database');
$config_site = new Zend_Config_Ini('../application/config.ini', 'site');

/** Registra na memoria a variavel config */
Zend_Registry::set('config', $config);
Zend_Registry::set('site', $config_site->toArray());

/** Configura a conexao com a base de dados, pegando as variaveis do arquivo
 * de configuracao.
 */
$db = Zend_Db::factory($config->db->adapter, $config->db->config->toArray());
Zend_Db_Table_Abstract::setDefaultAdapter($db);

/** Registra a variavel db */
Zend_Registry::set('db', $db);

/*************************************************************************************
 * INCLUINDO CLASSES DE CONTROLE DE ACESSO
 *************************************************************************************/

// Dando load nas classes responsavel pelo login e controle de acesso
Zend_Loader::loadClass('MyPluginAuth');
Zend_Loader::loadClass('MyAcl');
Zend_Loader::loadClass('Zend_Auth'); 

/*************************************************************************************
 * CONTROLE DE VIEWS
 *************************************************************************************/

/** Classes substitutas do framework */
Zend_Loader::loadClass('LogicBSB_View_Smarty'); /** substituta da classe Zend_View */

/** O metodo set e responsavel por armazenar variaveis que podem ser usadas
 * pelos aplicativos. Aqui, registrando os arrays post e get com dados vindos do usuario.
 * o Zend_Filter limpa os dados.
 */
$options = array('escapeFilter' => 'StringTrim');
$post = new Zend_Filter_Input(NULL,NULL,$_POST,$options);
Zend_Registry::set('post', $post);
Zend_Registry::set('get', new Zend_Filter_Input(NULL,NULL,$_GET));

/** Parte das visoes */
$_site = Zend_Registry::get("site");
$data['documentRoot'] = $_site['documentRoot'];
$view = new LogicBSB_View_Smarty($data); /** Cria um novo objeto do tipo view */

/** Configura a codificacao das paginas */
$view->setEncoding('UTF-8');
$view->setEscape('htmlentities');
$view->setTemplateDir(SISNOME);
Zend_Registry::set('view', $view); 	/** Registra na memoria a variavel view que indica a visao */

/** Inicia a sessao global */
Zend_Session::start();

/** Cria o manipulador da sessao */
//Zend_Registry::set('session',new Zend_Session_Namespace());

/** Configura o controlador do projeto.
 * O Controlador, por acaso, eh o index.php
 */
$baseUrl = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index.php'));
//$baseUrl = "/";

/** Cria uma nova instancia da classe controladora */
$frontController = Zend_Controller_Front::getInstance();

/** Configura o endereco do controlador do projeto */
$frontController->setbaseUrl($baseUrl);

/** Indica o diretorio onde estao os outros controladores da aplicacao */
$frontController->setControllerDirectory('../application/controllers');

/** O controlador deve tratar as excecoes */
$frontController->throwExceptions(false);
$auth = Zend_Auth::getInstance();
$acl = new MyAcl($auth);
$plugin = new MyPluginAuth($auth, $acl);
$frontController->registerPlugin( $plugin );
$frontController->setParam('auth', $auth);

/** Executa o controlador do projeto.
 * Ele ira receber todas as requisicoes e invocar os arquivos correspondentes.
 */
$frontController->dispatch();
