<?php
//require_once 'Zend/Acl.php';
//require_once 'Zend/Acl/Role.php';
//require_once 'Zend/Acl/Resource.php';

class MyAcl extends Zend_Acl
{
    public function __construct(Zend_Auth $auth)
    {

    	// Roles
        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('usuario'), 'guest');
        $this->addRole(new Zend_Acl_Role('admin'), 'usuario');
//		$this->addRole(new Zend_Acl_Role('u'), 'admin');
    	
		// Resources (CONTROLLERS)
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('usuario'));
		$this->add(new Zend_Acl_Resource('noticia'));
		$this->add(new Zend_Acl_Resource('anuncio'));
		$this->add(new Zend_Acl_Resource('erro'));
		$this->add(new Zend_Acl_Resource('perfil'));
		$this->add(new Zend_Acl_Resource('cidade'));
		$this->add(new Zend_Acl_Resource('uf'));
		$this->add(new Zend_Acl_Resource('estado-civil'));
		$this->add(new Zend_Acl_Resource('comentario'));
		$this->add(new Zend_Acl_Resource('mensagem'));
		
        //Recursos do Guest
		$this->allow('guest', 
						'usuario', 
						array('form-login',
								'realiza-login',
								'grava-cadastro-inicial',
								'validar',
								'validar-sem',
								'verifica-validar',
								'reenviar-chave'));
								
		$this->allow('guest', 
						'erro');
        
		$this->deny('guest', 
						'index');
		
        //Recursos do Usuario
		
		// index
		$this->allow('usuario', 
						'index', 
						array('index',
								'monta-interface'));
						

		// usuario
        $this->allow('usuario', 
						'usuario', 
						array('index',
								'sair', 
								'exibe-resumo-home',
								'exibe-links-home' ,
								'exibe-amigos-home', 
								'exibe-sugestao-amigos-home',
								'complete-nome',
								'adicionar-amigo',
								'adicionar-amigo-gravar',
								'troca-fundo',
								'destaque',
								'exibe-solicitacao',
								'confirma-solicitacao',
								'recusa-solicitacao',
								'remover-amigo',
								'ver-amigo',
								'confirma-remover-amigo',
								'exibe-solicitacoes'));

		// noticia						
		$this->allow('usuario', 
						'noticia', 
						array('exibe-noticia',
								'form-cadastro',
								'gravar',
								'detalhe'));
						
		// anuncio
		$this->allow('usuario', 
						'anuncio', 
						array('exibe-anuncios-home'));
						
		//perfil
		$this->allow('usuario', 
						'perfil', 
						array('visualizar',
								'visualizar-foto',
								'editar',
								'grava-editar',
								'foto',
								'upload-foto',
								'ver-foto',
								'apagar-foto',
								'colocar-foto-perfil',
								'detalhe'));
								
		// uf
		$this->allow('usuario', 
						'uf', 
						array('select'));
		
		// cidade
		$this->allow('usuario', 
						'cidade', 
						array('select'));
						
		// estado civil
		$this->allow('usuario', 
						'estado-civil', 
						array('select'));
						
		// estado civil
		$this->allow('usuario', 
						'comentario', 
						array('form-cadastro',
								'ver',
								'gravar',
								'lista'));
						
		// estado civil
		$this->allow('usuario', 
						'mensagem', 
						array('form-cadastro',
								'lista',
								'gravar'));
						
						
               
        //Recursos do admin
        $this->allow('admin');
        

    }
}
