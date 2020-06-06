<?php
/**
* Controlador COMENTARIO
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/

	
	// 0 = nao sao amigos e não existe solicitação
	// 1 = sao amigos
	// 2 = mesmo usuario
	// 3 = nao sao amigos e exise solicitacao de amizade
	// 4 = nao sao amigos e a solicitacao foi recusada
	// 5 = sao amigos e o usuario esta bloqueado
	// 6 = nao sao amigos e o usuario esta bloqueado
	// 7 = amigo removido
	

class ComentarioController extends Zend_Controller_Action
{

	public function init()
	{
		Zend_Loader::loadClass('Usuario');
		Zend_Loader::loadClass('Perfil');
		Zend_Loader::loadClass('FotoPerfil');
		Zend_Loader::loadClass('Amigo');
		Zend_Loader::loadClass('Comentario');
		Zend_Loader::loadClass('Noticia');
	}


	public function indexAction()
	{
		$this->_redirect("/index");
	}
	
	public function verAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblComentario = new Comentario();
		$tblFotoPerfil = new FotoPerfil();
		$tblNoticia = new Noticia();
		
		$usuario = "";
		$mensagem = "";
		$scripts = "";
		$saoAmigos = null;
		$fotoPerfil = false;
		$noticia = array();

		$cod_usuario = $get->cod;
		$cod_noticia = $get->cod2;
		
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($cod_noticia && !empty($cod_noticia) && $cod_noticia!="" && is_numeric($cod_noticia) && $cod_noticia>0)
				{
					
					$noticia = $tblNoticia->busca(array("int_idanoticia="=>$cod_noticia, "bln_ativo="=>"1"))->current();
			
					if ($noticia)
					{
						$noticia = $noticia->toArray();
						
						if ($noticia["int_idfusuario"]!=$usuario->int_idausuario)
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Usuário informado não é o dono da notícia";
						}
						else
						{
						
							if (
								($noticia["bln_publica"]==0 && $noticia["bln_admin"]==0) 
								&& 
								($saoAmigos!=2 && $saoAmigos!=1)
								&&
								($identUsuario["id_perfil"]!=2)
								)
							{
								$pagina = "index/resposta_erro.tpl";
								$mensagem = "Não pode ver os comentários desta notícia";
							}
							else
							{
								$pagina = "comentario/lista_comentarios.tpl";
							}
						}
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
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_noticia"=>$noticia,
									"_saoAmigos"=>$saoAmigos,
									"_foto"=>$fotoPerfil),
							false);
	}
	
	public function listaAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblComentario = new Comentario();
		$tblFotoPerfil = new FotoPerfil();
		$tblNoticia = new Noticia();
		
		$usuario = "";
		$mensagem = "";
		$scripts = "";
		$saoAmigos = null;
		$fotoPerfil = false;
		$noticia = array();
		$comentarios = array();

		$cod_usuario = $get->cod;
		$cod_noticia = $get->cod2;
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($cod_noticia && !empty($cod_noticia) && $cod_noticia!="" && is_numeric($cod_noticia) && $cod_noticia>0)
				{
					
					$noticia = $tblNoticia->busca(array("int_idanoticia="=>$cod_noticia, "bln_ativo="=>"1"))->current();
			
					if ($noticia)
					{
						$noticia = $noticia->toArray();
						
						if ($noticia["int_idfusuario"]!=$usuario->int_idausuario)
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Usuário informado não é o dono da notícia";
						}
						else
						{
						
							if (
								($noticia["bln_publica"]==0 && $noticia["bln_admin"]==0) 
								&& 
								($saoAmigos!=2 && $saoAmigos!=1)
								&&
								($identUsuario["id_perfil"]!=2)
								)
							{
								$pagina = "index/resposta_erro.tpl";
								$mensagem = "Não pode ver os comentários desta notícia";
							}
							else
							{
								$comentarios = $tblComentario->busca(array("bln_ativo="=>"1",
																			"bln_aprovado="=>"1",
																			"int_idfnoticia="=>$noticia["int_idanoticia"]),
																		array())->toArray();
																			
								$retorno = array();
								
								foreach ($comentarios as $comentario)
								{
									$temp = $comentario;
									
									$usuarioComentario = $tblUsuario->busca(array("int_idausuario="=>$temp["int_idfusuario"]))->current();
									$temp["usuario"] = $usuarioComentario->toArray();
									
									$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$comentario["int_idfusuario"],
													"bln_ativa="=>1), array(), 1, 0)->current();
									if ($fotoPerfil)
									{
										$temp["foto"] = $fotoPerfil->int_idafotoperfil;
									}
									else
									{
										$temp["foto"] = 0;
									}
									
									$retorno[] = $temp;
								}
								
								$comentarios = $retorno;
//																			xd($comentarios);
								
/*								$tblFotoPerfil = new FotoPerfil();
								
								*/
								
								$pagina = "comentario/comentarios_noticia.tpl";
							}
						}
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
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_noticia"=>$noticia,
									"_saoAmigos"=>$saoAmigos,
									"_foto"=>$fotoPerfil,
									"comentarios"=>$comentarios),
							false);
	}
	
	
	public function gravarAction()
	{
		$post = Zend_Registry::get('post');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblComentario = new Comentario();
		$tblFotoPerfil = new FotoPerfil();
		$tblNoticia = new Noticia();
		
		$usuario = "";
		$mensagem = "";
		$scripts = "";
		$saoAmigos = null;
		$fotoPerfil = false;
		$noticia = array();
		$comentario = array();

		$cod_usuario = $post->cod;
		$cod_noticia = $post->cod2;
		$cod_comentario = $post->cod3;
		
		$mensagem = $post->mensagem;
		$publico = $post->publico;
		
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($cod_noticia && !empty($cod_noticia) && $cod_noticia!="" && is_numeric($cod_noticia) && $cod_noticia>0)
				{
					
					$noticia = $tblNoticia->busca(array("int_idanoticia="=>$cod_noticia, "bln_ativo="=>"1"))->current();
			
					if ($noticia)
					{
						$noticia = $noticia->toArray();
						
						if ($noticia["int_idfusuario"]!=$usuario->int_idausuario)
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Usuário informado não é o dono da notícia";
						}
						else
						{
						
							if (
								($noticia["bln_publica"]==0 && $noticia["bln_admin"]==0) 
								&& 
								($saoAmigos!=2 && $saoAmigos!=1)
								&&
								($identUsuario["id_perfil"]!=2)
								)
							{
								
								$pagina = "index/resposta_erro.tpl";
								$mensagem = "Não pode gravar comentários nesta notícia";
							}
							else
							{
								$dados = array(
											"int_idfusuario"=>$identUsuario["id"],
											"int_idfnoticia"=>$noticia["int_idanoticia"],
											"txt_conteudo"=>$mensagem,
											"bln_aprovado"=>1,
											"dte_criacao"=>date("Y-m-d H:i:s"),
											"dte_aprovado"=>date("Y-m-d H:i:s"),
											"bln_ativo"=>1
								);
								
								$gravado = $tblComentario->insert($dados);
								
								$pagina = "index/resposta_sucesso.tpl";
								$mensagem = "Comentário gravado com sucesso";
								
								$scripts = "
								jqAjaxLink('/comentario/form-cadastro?cod=".$usuario->int_idausuario."&cod2=".$noticia["int_idanoticia"]."', 'container-lista-comentarios-form-".$noticia["int_idanoticia"]."', true);
								jqAjaxLink('/comentario/lista?cod=".$usuario->int_idausuario."&cod2=".$noticia["int_idanoticia"]."', 'container-lista-comentarios-".$noticia["int_idanoticia"]."', true);
								";
							}
						}
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
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_noticia"=>$noticia,
									"_saoAmigos"=>$saoAmigos,
									"_foto"=>$fotoPerfil,
									"scripts"=>$scripts),
							false);
	}
	
	public function formCadastroAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblComentario = new Comentario();
		$tblFotoPerfil = new FotoPerfil();
		$tblNoticia = new Noticia();
		
		$usuario = "";
		$mensagem = "";
		$scripts = "";
		$saoAmigos = null;
		$noticia = array();
		$comentario = array();

		$cod_usuario = $get->cod;
		$cod_noticia = $get->cod2;
		
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				if ($cod_noticia && !empty($cod_noticia) && $cod_noticia!="" && is_numeric($cod_noticia) && $cod_noticia>0)
				{
					
					$noticia = $tblNoticia->busca(array("int_idanoticia="=>$cod_noticia, "bln_ativo="=>"1"))->current();
			
					if ($noticia)
					{
						$noticia = $noticia->toArray();
						$pagina = "comentario/form_cadastro.tpl";
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
			
				/*
				switch ($saoAmigos)
				{
					case 1:
						
						break;
					case 0:
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
					
						$estadoCivil = $usuario->findParentRow("EstadoCivil");
						$cidade = $usuario->findParentRow("Cidade");
						$uf = $cidade->findParentRow("Uf");
						
						
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1), array(), 1, 0)->current();
						
						if ($usuario->dte_nascimento!=null)
						{
							$date = new Zend_Date();
							$date->set($usuario->dte_nascimento, "Y-m-d");
							$usuario->dte_nascimento = $date->get("dd/mm/Y");
						}
						
						$pagina = "perfil/detalhes_perfil.tpl";
						
						$editar = $identUsuario["id"]==$usuario->int_idausuario;
						break;
				}
				*/
				
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
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"_noticia"=>$noticia,
									"_saoAmigos"=>$saoAmigos,
									"_comentario"=>$comentario),
							false);
	}
	
	public function detalheAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$pagina = "";
		$usuario = "";
		$cidade = "";
		$uf = "";
		$mensagem = "";
		$scripts = "";
		$estadoCivil = "";
		$editar = false;
		$saoAmigos = null;
		$fotoPerfil = false;

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
					case 4:
					case 5:
					case 6:
					case 7:
						$estadoCivil = $usuario->findParentRow("EstadoCivil");
						$cidade = $usuario->findParentRow("Cidade");
						$uf = $cidade->findParentRow("Uf");
						
						$tblFotoPerfil = new FotoPerfil();
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1), array(), 1, 0)->current();
						
						if ($usuario->dte_nascimento!=null)
						{
							$date = new Zend_Date();
							$date->set($usuario->dte_nascimento, "Y-m-d");
							$usuario->dte_nascimento = $date->get("dd/mm/Y");
						}
						
						$pagina = "perfil/detalhes_perfil.tpl";
						
						$editar = $identUsuario["id"]==$usuario->int_idausuario;
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
		
		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"_estadoCivil"=>$estadoCivil,
									"_cidade"=>$cidade,
									"_uf"=>$uf,
									"descricao"=>$mensagem,
									"_editar"=>$editar,
									"_saoAmigos"=>$saoAmigos,
									"_foto"=>$fotoPerfil),
							false);
	}
	
	public function visualizarAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$pagina = "";
		$usuario = "";
		$cidade = "";
		$uf = "";
		$mensagem = "";
		$scripts = "";
		$estadoCivil = "";
		$editar = false;
		$saoAmigos = null;
		$fotoPerfil = "";

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
					case 4:
					case 5:
					case 6:
					case 7:
						$estadoCivil = $usuario->findParentRow("EstadoCivil");
						$cidade = $usuario->findParentRow("Cidade");
						$uf = $cidade->findParentRow("Uf");
						
						$tblFotoPerfil = new FotoPerfil();
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1), array(), 1, 0)->current();
						
						if ($usuario->dte_nascimento!=null)
						{
							$date = new Zend_Date();
							$date->set($usuario->dte_nascimento, "Y-m-d");
							$usuario->dte_nascimento = $date->get("dd/mm/Y");
						}
						
						$pagina = "perfil/visualizar_perfil.tpl";
						
						$editar = $identUsuario["id"]==$usuario->int_idausuario;
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

		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"_estadoCivil"=>$estadoCivil,
									"_cidade"=>$cidade,
									"_uf"=>$uf,
									"descricao"=>$mensagem,
									"_editar"=>$editar,
									"_saoAmigos"=>$saoAmigos,
									"_foto"=>$fotoPerfil),
							false);
	}
	
	
	private function pegaFotosPerfil($cod_usuario)
	{
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$tblUsuario = new Usuario();
		$tblFotos = new FotoPerfil();
		
		$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
		$fotos_perfil = $tblFotos->busca(
									array("int_idfusuario="=>$usuario->int_idausuario,
										"bln_ativo="=>1),
									array("int_idafotoperfil asc"));
		
		if (count($fotos_perfil)>0)
		{
			return $fotos_perfil->toArray();
		}
		else
		{
			return 0;
		}
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