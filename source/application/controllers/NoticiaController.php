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
class NoticiaController extends Zend_Controller_Action
{
	
	/**
	 * Este m�todo sera executado sempre que a classe for instanciada,
	 * depois do construtor.
	 * Faz o carregamento das classes que ser�o usadas pelo controlador.
	 *
	 * @return void
	 */
	public function init()
	{
		Zend_Loader::loadClass('Noticia');
		Zend_Loader::loadClass('Usuario');
		Zend_Loader::loadClass('Amigo');
		Zend_Loader::loadClass('Comentario');
		Zend_Loader::loadClass('FotoPerfil');
		//xd(phpinfo());
	}

	/**
	 * Metodo que mostra a pagina inicial
	 *
	 * @return void
	 */
//	public function indexAction()
//	{
//		$this->_redirect("/index");
//	}
	
	
	/**
	*/
	public function exibeNoticiaAction()
	{
		$tblNoticia = new Noticia();
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblComentario = new Comentario();
		$tblFoto = new FotoPerfil();
		$acessos = array();
		$acesso = array();
		$noticia = array();
		$usuarioNoticia = array();
		
		$get = Zend_Registry::get('get');
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
//		x($identUsuario);

		$num = $get->num;
		
		$cod_usuario = $get->cod;
		
		$noticias = null;
		
		$mensagem = "";
		
		$where = array();
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
			
			if ($usuario)
			{
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($saoAmigos==2 && $identUsuario["id_perfil"]==2)
				{
					$noticias = $tblNoticia->busca(array("bln_ativo="=>"1"), 
													array("int_idanoticia desc"),
													1,
													$num)->current();
				}
				else
				{
					$where["bln_ativo="] = "1";
	
					$noticias = $tblNoticia->buscaRestricao($usuario->int_idausuario, 
										$saoAmigos,
										$where, 
										array("int_idanoticia desc"),
										1,
										$num)->current();
				}
			
			} else {
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Usuário não encontrado";
			}
		
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não informado";
		}
		
		$pagina = "noticia/resumonoticiahome.tpl";
		
		
		
		if ($noticias!=null) {
			$noticia = $noticias->toArray();
			$date = new Zend_Date();
			$date->set($noticia["dte_criacao"], "Y-m-d");
			$noticia["dte_criacao"] = $date->get("dd/mm/Y");
			if ($noticia["txt_resumo"]=="") $noticia["txt_resumo"] = cortaTexto($noticia["txt_conteudo"],300);
			$noticia["total_comentarios"] = $tblComentario->pegaTotal(array("bln_ativo="=>"1",
																			"bln_aprovado="=>"1",
																			"int_idfnoticia="=>$noticia["int_idanoticia"]));
					
			$usuarioNoticia = $tblUsuario->find($noticias->int_idfusuario)->current()->toArray();
			$tblFotoPerfil = new FotoPerfil();
			$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuarioNoticia["int_idausuario"],
															"bln_ativa="=>1,
															"int_idfnoticia="=>0), array(), 1, 0)->current();
			if ($fotoPerfil)
			{
				$usuarioNoticia["foto"] = $fotoPerfil->int_idafotoperfil;
			}
			else
			{
				$usuarioNoticia["foto"] = 0;
			}
			$fotoNoticia = $tblFoto->busca(array("int_idfusuario="=>$noticias->int_idfusuario,
													"int_idfnoticia="=>$noticias->int_idanoticia))->current();
//													
//			xd($fotoNoticia);
			if ($fotoNoticia) $noticia["foto"] = $fotoNoticia->int_idafotoperfil;
			else $noticia["foto"] = 0;
			
//			xd($noticia["foto"]);
			
		}
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_saoAmigos"=>$saoAmigos,
									"acesso"=>$acesso,
									"_noticia"=>$noticia,
									"_usuarioNoticia"=>$usuarioNoticia,
									"_num"=>($num+1)),
							"n");

	}
	
	public function detalheAction()
	{
		$tblNoticia = new Noticia();
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblFoto = new FotoPerfil();
		$acessos = array();
		$acesso = array();
		$noticia = array();
		$usuarioNoticia = array();
		
		$get = Zend_Registry::get('get');
		$identUsuario = Zend_Auth::getInstance()->getIdentity();

		$cod_usuario = $get->cod;
		$cod_noticia = $get->cod2;
		
		$noticias = null;
		
		$mensagem = "";
		
		$where = array();
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
			
			if ($usuario)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($cod_noticia && !empty($cod_noticia) && $cod_noticia!="" && is_numeric($cod_noticia) && $cod_noticia>0)
				{
					
					$noticia = $tblNoticia->busca(array("int_idanoticia="=>$cod_noticia, "bln_ativo="=>"1"))->current();
			
					if ($noticia)
					{
						
						
						if ($noticia["int_idfusuario"]!=$usuario->int_idausuario)
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Usuário informado não é o dono da notícia";
						}
						else
						{
						
							if (
									($noticia->bln_publica==0 && $noticia->bln_admin==0) 
									&& 
									($saoAmigos!=2 && $saoAmigos!=1)
									&&
									($identUsuario["id_perfil"]!=2)
								)
							{
								$pagina = "index/resposta_erro.tpl";
								$mensagem = "Visualização desta notícia não permitida para você";
							}
							else
							{
								$noticia->int_cliques = $noticia->int_cliques + 1;
								$noticia->save();
								
								$noticia = $noticia->toArray();
								
								$fotoNoticia = $tblFoto->busca(array("int_idfusuario="=>$noticia["int_idfusuario"],
													"int_idfnoticia="=>$noticia["int_idanoticia"]))->current();
													
					//			xd($fotoNoticia);
								if ($fotoNoticia) $noticia["foto"] = $fotoNoticia->int_idafotoperfil;
								else $noticia["foto"] = 0;
								
								$usuarioNoticia = $tblUsuario->find($noticia["int_idfusuario"])->current()->toArray();
								$pagina = "noticia/detalhes.tpl";
							}
							
						}
						
//						if ($noticia)
						
//						$noticias = $tblNoticia->busca();

						//$noticias = $tblNoticia->buscaRestricao($usuario->int_idausuario, 
						//			$saoAmigos,
						//			$where, 
						//			array("dte_criacao desc"),
						//			1,
						//			$num)->current();
					}
					else
					{
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Notícia não encontrada";
					}
					
				}
				else
				{
					$pagina = "index/resposta_erro.tpl";
					$mensagem = "Notícia não informada";
				}
				
			
			} else {
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Usuário não encontrado";
			}
		
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não informado";
		}
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_saoAmigos"=>$saoAmigos,
									"acesso"=>$acesso,
									"_noticia"=>$noticia,
									"_usuarioNoticia"=>$usuarioNoticia),
							"n");

	}
	
	public function formCadastroAction()
	{
		$tblNoticia = new Noticia();
		$tblUsuario = new Usuario();
		
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$usuario = $auth->getIdentity();
		$acessos = array();
		$acesso = array();
		$noticia = array();
		$usuarioNoticia = array();
		
		$num = $get->num;
//		echo ($num+1).".";
			
		$noticias = $tblNoticia->busca(array("bln_ativo="=>1), 
									array("dte_criacao desc"),
									1,
									$num)->current();
									
		
		
		if ($noticias!=null) {
			$noticia = $noticias->toArray();
		
			$usuarioNoticia = $tblUsuario->find($noticias->int_idfusuario)->current()->toArray();
		}
		
		// exibe tela
		$this->montaTela("noticia/form_cadastro.tpl", 
							array("_usuario"=>$usuario,
									"acesso"=>$acesso,
									"_noticia"=>$noticia,
									"_usuarioNoticia"=>$usuarioNoticia,
									"_num"=>($num+1)),
							"n");
	}
	
	public function gravarAction()
	{
		$tblNoticia = new Noticia();
		$tblUsuario = new Usuario();
		
		$post = Zend_Registry::get('post');
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$usuario = $tblUsuario->find($identUsuario['id'])->current();
		
		if ($usuario)
		{
		
			$dados["vhr_titulo"] = $post->titulo;
			$dados["txt_conteudo"] = $post->texto;
			$dados["int_idfusuario"] = $usuario->int_idausuario;
			$dados["dte_criacao"] = date("Y-m-d H:i:s");
			$dados["bln_ativo"] = 1;
			$dados["bln_publica"] = $post->publico;
			if ($post->subtitulo && $post->subtitulo!="") $dados["vhr_subtitulo"] = $post->subtitulo;
			if ($post->resumo && $post->resumo!="") $dados["txt_resumo"] = $post->resumo;
			if ($post->fonte && $post->fonte!="") $dados["vhr_fonte"] = $post->fonte;
			if ($post->link && $post->link!="") $dados["vhr_link"] = $post->link;
			if ($post->tags && $post->tags!="") $dados["vhr_tags"] = $post->tags;
			
			$tblNoticia->insert($dados);
			
			$mensagem = "Notícia enviada";
			$pagina = "index/resposta_sucesso.tpl";
			$scripts = "montaInterface('".$usuario->int_idausuario."', '".$usuario->vhr_css."');";
		}
		else
		{
			$mensagem = "Usuario não encontrado";
			$pagina = "index/resposta_erro.tpl";
		}
			
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"scripts"=>$scripts,
									"descricao"=>$mensagem),
							"n");
	}
	
	/**
	 * Monta a tela de retorno ao usuario
	 * @param string $corpo - arquivo tpl do corpo
	 * @param array $dados - array com os dados a serem inseridos na tela, no seguinte formato "nome"=>"valor"
	 * @param boolean $exibeHeader - true ou false para exibir header, menu e rodape 
	 * @return void
	 */
	private function montaTela($corpo, $dados=array(), $exibeHeader="s")
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
		if ($exibeHeader && $exibeHeader=="n") $tplLayout = $_site["layout_sem_header"];
		else $tplLayout = $_site["layout"];
		// retorna o tempalte master, com corpo e variaveis setadas
		$view->output($tplLayout);
	}
}