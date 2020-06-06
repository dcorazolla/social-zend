<?php
/**
* Controlador USUARIO
*  @filesource
 * @author			Diogo Corazolla
 * @copyright		Copyright 2011 LogicBSB
 * @package			socialzend
 * @subpackage		socialzend.application.controllers
 * @version			1.0
*/
class UsuarioController extends Zend_Controller_Action
{
	
	// 0 = nao sao amigos e não existe solicitação
	// 1 = sao amigos
	// 2 = mesmo usuario
	// 3 = nao sao amigos e exise solicitacao de amizade
	// 4 = nao sao amigos e a solicitacao foi recusada
	// 5 = sao amigos e o usuario esta bloqueado
	// 6 = nao sao amigos e o usuario esta bloqueado
	// 7 = amigo removido
	
	private $intTamPag;
	
	public function init()
	{
		Zend_Loader::loadClass('Usuario');
		Zend_Loader::loadClass('Perfil');
		Zend_Loader::loadClass('Acesso');
		Zend_Loader::loadClass('Cidade');
		Zend_Loader::loadClass('FotoPerfil');
		Zend_Loader::loadClass('Uf');
		Zend_Loader::loadClass('Amigo');
		Zend_Loader::loadClass('Noticia');
		
		// inicializando variaveis com valor padrao
		$this->intTamPag = 10;
	}
	
	public function trocaFundoAction()
	{
		$auth = Zend_Auth::getInstance();
		$usuario = $auth->getIdentity();
		
		$get = Zend_Registry::get('get');
		
		$tblUsuario = new Usuario();
		
		$usuarioFind = $tblUsuario->find($usuario["id"])->current();
		
		$fundo = $get->fundo;
		$fundo = substr($fundo, 1);
		
		if ($usuarioFind)
		{
			$usuarioFind->vhr_css = $fundo;
			$usuarioFind->save();
		}
		
		exit();
	}
	
	public function exibeResumoHomeAction()
	{
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$mensagem = "";
		$scripts = "";
		$cidade = "";
		$fotoPerfil = "";
		$uf = "";

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
					case 4:
					case 5:
					case 6:
					case 7:
						$cidade = $usuario->findParentRow("Cidade");
						if ($cidade && $cidade->int_idacidade!=0) $uf = $cidade->findParentRow("Uf");
						$tblFotoPerfil = new FotoPerfil();
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1), array(), 1, 0)->current();

						$pagina = "usuario/resumo_home.tpl";
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
									"_cidade"=>$cidade,
									"_foto"=>$fotoPerfil,
									"descricao"=>$mensagem,
									"_saoAmigos"=>$saoAmigos,
									"_uf"=>$uf),
							false);
	}
	
	public function exibeLinksHomeAction()
	{
		
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$mensagem = "";
		$scripts = "";
		$cidade = "";
		$fotoPerfil = "";
		$uf = "";

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
					case 4:
					case 5:
					case 6:
					case 7:
						$pagina = "usuario/links_home.tpl";
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
									"descricao"=>$mensagem,
									"_saoAmigos"=>$saoAmigos),
							false);

	}
	
	public function exibeAmigosHomeAction()
	{
		
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		$tblNoticia = new Noticia();
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		$usuario = "";
		$totalAmigos = 0;
		$amigos = "";

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
					case 4:
					case 5:
					case 6:
					case 7:
						$totalAmigos = $tblAmigo->buscaTotalAmigos($usuario);
						$amigos = $tblAmigo->buscaAmigosHome($usuario);
						$retorno = array();
						
						foreach($amigos as $amigo)
						{
							$temp = array();
							if ($usuario->int_idausuario != $amigo["int_idfusuario1"])
							{
								$usuarioAmigo = $tblUsuario->busca(array("int_idausuario="=>$amigo["int_idfusuario1"]))->current();
							}
							else
							{
								$usuarioAmigo = $tblUsuario->busca(array("int_idausuario="=>$amigo["int_idfusuario2"]))->current();
							}
							
//							xd($ususarioAmigo);
							
							$temp["int_idausuario"] = $usuarioAmigo->int_idausuario;
							$temp["vhr_nome"] = $usuarioAmigo->vhr_nome;
							$temp["vhr_css"] = $usuarioAmigo->vhr_css;
							$temp["total_noticias"] = $tblNoticia->pegaTotal(array("int_idfusuario="=>$usuarioAmigo->int_idausuario,
																					"bln_ativo="=>"1"));
							$temp["sao_amigos"] = $tblAmigo->saoAmigos($identUsuario["id"], $usuarioAmigo->int_idausuario);
							$tblFotoPerfil = new FotoPerfil();
							$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuarioAmigo->int_idausuario,
												"bln_ativa="=>1), array(), 1, 0)->current();
							if ($fotoPerfil)
							{
								$temp["foto"] = $fotoPerfil->int_idafotoperfil;
							}
							else
							{
								$temp["foto"] = 0;
							}
							$totalAmigosUsuario = $tblAmigo->buscaTotalAmigos($usuarioAmigo);
							$temp["total_amigos"] = $totalAmigosUsuario;
							$retorno[] = $temp;
						}
						$amigos = $retorno;
						
						$pagina = "usuario/amigos_home.tpl";
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
									"totalAmigos"=>$totalAmigos,
									"amigos"=>$amigos,
									"descricao"=>$mensagem),
							false);
	}
	
	public function removerAmigoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$usuario = "";
		$totalAmigos = 0;
		$amigos = "";
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				switch ($saoAmigos)
				{
					case 1:
					case 5:
						$pagina = "usuario/form_conf_remover_amigo.tpl";
						break;
					case 2:
						$mensagem = "Não pode deixar de ser amigo de você mesmo.";
						$pagina = "index/resposta_erro.tpl";
						break;
					case 0:
					case 3:
					case 4:
					case 6:
					case 7:
						$mensagem = "Não são amigos";
						$pagina = "index/resposta_erro.tpl";
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
									"totalAmigos"=>$totalAmigos,
									"amigos"=>$amigos,
									"descricao"=>$mensagem),
							false);
	}
	
	public function confirmaRemoverAmigoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$usuario = "";
		$totalAmigos = 0;
		$amigos = "";
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
				switch ($saoAmigos)
				{
					case 1:
					case 5:
						$solAmizade = $tblAmigo->ultimaSolicitacao($identUsuario, $usuario->int_idausuario)->current();
						xd($solAmizade);
						$solAmizade->bln_aceito = 7;
						$solAmizade->save();
						
						$scripts = "setTimeout('$(\"#container-solicitacao-aceitar".$usuario->int_idausuario."\").hide(\"slow\")', 3000);
						jqAjaxLink('/usuario/exibe-amigos-home?cod=".$usuario->int_idausuario."','container-amigos-usuario-home',true);
						jqAjaxLink('/usuario/exibe-links-home?cod=".$usuario->int_idausuario."','container-links-usuario-home',true);
						jqAjaxLink('/usuario/destaque?cod=".$usuario->int_idausuario."','container-destaques-home',true);";
						
						$mensagem = "amigo removido com sucesso";
						$pagina = "index/resposta_sucesso.tpl";
						break;
					case 2:
						$mensagem = "Não pode deixar de ser amigo de você mesmo.";
						$pagina = "index/resposta_erro.tpl";
						break;
					case 0:
					case 3:
					case 4:
					case 6:
					case 7:
						$mensagem = "Não são amigos";
						$pagina = "index/resposta_erro.tpl";
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
									"totalAmigos"=>$totalAmigos,
									"amigos"=>$amigos,
									"descricao"=>$mensagem),
							false);
	}
	
	public function verAmigoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$tblNoticia = new Noticia();
		$usuario = "";
		$totalAmigos = 0;
		$amigos = "";
		$saoAmigos = "";
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
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
						$totalAmigos = $tblAmigo->buscaTotalAmigos($usuario);
						$amigos = $tblAmigo->buscaAmigos($usuario);
						$retorno = array();
						
						foreach($amigos as $amigo)
						{
							$temp = array();
							if ($usuario->int_idausuario != $amigo["int_idfusuario1"])
							{
								$usuarioAmigo = $tblUsuario->busca(array("int_idausuario="=>$amigo["int_idfusuario1"]))->current();
							}
							else
							{
								$usuarioAmigo = $tblUsuario->busca(array("int_idausuario="=>$amigo["int_idfusuario2"]))->current();
							}
							
//							xd($ususarioAmigo);
							
							$temp["int_idausuario"] = $usuarioAmigo->int_idausuario;
							$temp["vhr_nome"] = $usuarioAmigo->vhr_nome;
							$temp["vhr_css"] = $usuarioAmigo->vhr_css;
							$temp["total_noticias"] = $tblNoticia->pegaTotal(array("int_idfusuario="=>$usuarioAmigo->int_idausuario));
							$temp["sao_amigos"] = $tblAmigo->saoAmigos($identUsuario["id"], $usuarioAmigo->int_idausuario);
							$tblFotoPerfil = new FotoPerfil();
							$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuarioAmigo->int_idausuario,
												"bln_ativa="=>1), array(), 1, 0)->current();
							if ($fotoPerfil)
							{
								$temp["foto"] = $fotoPerfil->int_idafotoperfil;
							}
							else
							{
								$temp["foto"] = 0;
							}
							
							$totalAmigosUsuario = $tblAmigo->buscaTotalAmigos($usuarioAmigo);
							$temp["total_amigos"] = $totalAmigosUsuario;
							
							$retorno[] = $temp;
						}
						$amigos = $retorno;
						
						$pagina = "usuario/ver_amigos.tpl";
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
									"totalAmigos"=>$totalAmigos,
									"amigos"=>$amigos,
									"_saoAmigos"=>$saoAmigos,
									"descricao"=>$mensagem),
							false);
	}
	
	public function cadastroAction()
	{
		// exibe tela
		$this->montaTela("usuario/formulario_cadastro.tpl", 
							array(),
							false);
	}
	
	public function exibeSugestaoAmigosHomeAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$tblFoto = new FotoPerfil();
		
		$usuario = $tblUsuario->find($identUsuario["id"])->current();
		
		$sugestoes = $tblUsuario->buscaSugestaoAmigo($usuario);
		
		$retorno = 0;
		if (count($sugestoes)>0)
		{
			$retorno = array();
			foreach ($sugestoes as $sug)
			{
				$temp = $sug;
				$foto = $tblFoto->busca(array("int_idfusuario="=>$sug["int_idausuario"],
													"bln_ativa="=>1), array(), 1, 0)->current();
				if ($foto)
				{
					$temp["foto"] = $foto->int_idafotoperfil;
				}
				else
				{
					$temp["foto"] = 0;
				}
				
//				x($temp);

		if (strlen($temp["vhr_nome"]) > 17) $temp["vhr_nome"] = substr($temp["vhr_nome"], 0, 17)."...";
				$retorno[] = $temp;
			}
		}
		
		// exibe tela
		$this->montaTela("usuario/sugestao_amigos_home.tpl", 
							array("_usuario"=>$usuario,
									"_sugestoes"=>$retorno),
							false);
	}
	
	public function formLoginAction()
	{
		$mensagem = $this->_getParam('mensagem');
		
		$this->montaTela("usuario/pagina_login.tpl", 
								array("mensagem"=>$mensagem), 
								false);
	}
	
	private function tamanhoNome($nome, $tamanho)
	{
		
	}
	
	function realizaLoginAction()
	{
		$post = Zend_Registry::get('post');
		$login = $post->login;
		$senha = $post->senha;
		
		$nomeDiv = "aviso".geraSenha(4);
		
		Zend_Loader::loadClass('Zend_Auth');
		Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
		
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());

		//setando as colunas e as tabelas aonde vai conferir os dados
		$authAdapter->setTableName('tbl_usuario');
		$authAdapter->setIdentityColumn('vhr_login');
		$authAdapter->setCredentialColumn('vhr_senha');
		
		$mensagem = "";
		$scripts = "";
		$parametros = "";

		//setando os dados
		$authAdapter->setIdentity($login);
		$authAdapter->setCredential($senha);
			
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		
		$destino = "/usuario/form-login/";
                
		
		// Verifica se a senha confere
		if ($result->isValid()) {
			//Senha confere
			$data = $authAdapter->getResultRowObject(null, 'vhr_senha');
			
			$tblUsuario = new Usuario();
			$rowUsuario = $tblUsuario->busca(array("vhr_login="=>$data->vhr_login))->current();
			
			if ($rowUsuario->bln_ativo == 1)
			{
				
				// pegando dados do usuario e setando no objeto
				$usuario['id']   = $rowUsuario->int_idausuario;
				$usuario['vhr_login']   = $rowUsuario->vhr_login;
				$usuario['id_perfil'] = $rowUsuario->perfil_id;
				$usuario['perfil_nome'] = $rowUsuario->perfil_nome;
				$usuario['usuario_nome'] = $rowUsuario->vhr_nome;
				
				$tblAcesso = new Acesso();
				$data = array("int_idfusuario"=>$usuario['id'], "dte_data"=>date("Y-m-d H:i:s"), "vhr_ip"=>$_SERVER["REMOTE_ADDR"], "vhr_url"=>$_SERVER["REQUEST_URI"]);
				$tblAcesso->insert($data);
				Zend_Registry::set('usuario', $usuario);
				$auth->getStorage()->write($usuario);
				
				$destino = "/index/";
			} 
			else
			{
				Zend_Auth::getInstance()->clearIdentity();
				$destino = $destino."mensagem/Usuário cadastrado mas ainda não validado/";
				$mensagem = "<span id='".$nomeDiv."'>Usuário cadastrado mas ainda não validado</span>";
			}
		}
		else 
		{
			$destino = $destino."mensagem/Login ou Senha inv&aacute;lidos/";
			$mensagem = "<span id='".$nomeDiv."'>Login e/ou Senha inv&aacute;lidos</span>";
			
		}
		
		$this->_redirect($destino);
	}
	
	
	public function sairAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Registry::set('mensagem', null);
		
		$this->_forward("/index");
	}
	
	public function gravaCadastroInicialAction()
	{
		$post = Zend_Registry::get('post');
		
		$nomeCompleto = $post->nome;
		$email = $post->email;
		$email2 = $post->email2;
		$senha = $post->senha;
		$senha2 = $post->senha2;
//		$senha = geraSenha(6);
		$chave = geraSenha(10);
		$sexo = $post->genero;
		$mensagem = "";
		$pagina = "index/resposta_branco.tpl";
		$scripts = "";
		if ($email != $email2) 
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem="Email e confirmação não conferem";
		}
		else
		{
			if ($senha != $senha2) 
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem="Senha e confirmação não conferem";
			}
			else
			{
				$tblUsuario = new Usuario();
				$existe = $tblUsuario->busca(array("vhr_login="=>$email))->current();
				
				if ($existe)
				{	
					$pagina = "index/resposta_erro.tpl";
					
					if ($existe->bln_ativo==0)
					{
						$mensagem="Já existe um usuário com este email, mas ele ainda não foi ativado.<br>Clique <a href='/usuario/reenviar-chave?cod=".$existe->int_idausuario."' onclick='jqAjaxLink($(this).attr(\"href\"), \"container-resposta-cadastro\", true); return false;'><b>AQUI</b></a> para reenviar a chave de validação para o seu email, ou utilize outro email para realizar o cadastro.";
					}
					else
					{
						$mensagem="Já existe um usuário com este email.<br>Tente outro.";
					}
						
				}
				else
				{
					$data = array("int_idfperfil"=>1, 
									"vhr_nome"=>$nomeCompleto, 
									"vhr_login"=>$email, 
									"vhr_senha"=>$senha, 
									"vhr_email"=>$email, 
									"dte_cadastro"=>date("Y-m-d H:i:s"), 
									"bln_ativo"=>0, 
									"vhr_chavevalidacao"=>$chave,
									"vhr_sexo"=>$sexo,
									"int_idfcidade"=>1,
									"int_idfestadocivil"=>1,
									"bln_perfilpublico"=>1);
					$tblUsuario->insert($data);
					$this->enviaEmailCadastro($nomeCompleto, $email, $chave);
					
					$pagina = "index/resposta_sucesso.tpl";
					$mensagem = "Cadastro realizado com sucesso. <br>Foi enviado um email para o endereço informado com detalhes para validação de sua conta.<br>Não esqueça de verificar sua caixa de SPAM.";
					//$scripts = "jqAjaxLink('/usuario/validar-sem', 'container-form-cadastro', true);";
					$scripts = "$('#container-form-cadastro').hide('slow');";
				}
			}
			

		}
		
		$this->montaTela($pagina, 
								array("descricao"=>$mensagem,
										"scripts"=>$scripts), 
								false);
		
//		echo $mensagem;
//		xd($nomeCompleto);
	}
	
	public function reenviarChaveAction()
	{
		$get = Zend_Registry::get('get');
		
		$cod_usuario = $get->cod;
		$tblUsuario = new Usuario();
		
		if ($cod_usuario && $cod_usuario>0)
		{
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
			
			if ($usuario)
			{
				if ($usuario->bln_ativo == 0)
				{
					$chave = $usuario->vhr_chavevalidacao;
					$nome = $usuario->vhr_nome;
					$email = $usuario->vhr_login;
					$this->enviaEmailChave($nome, $email, $chave);
					
					$pagina = "index/resposta_sucesso.tpl";
					$mensagem="Foi enviado um email para a conta informada com a CHAVE de ativação e maiores detalhes.";
					$scripts = "jqAjaxLink('/usuario/validar-sem', 'container-form-cadastro', true);";
				}
				else
				{
					$pagina = "index/resposta_erro.tpl";
					$mensagem="Usuário já foi ativado";
				}
			}
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem="Usuario nao encontrado";
			}
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem="Usuario nao informado";
		}
		
		$this->montaTela($pagina, 
								array("descricao"=>$mensagem,
										"scripts"=>$scripts), 
								false);
		
//		echo $mensagem;
//		xd($nomeCompleto);
	}
	
	public function validarSemAction()
	{
		$email = "";
		$chave = "";
		
		$this->montaTela("usuario/formulario_validacao.tpl", 
								array("email"=>$email,
										"chave"=>$chave), 
								false);
	}
	
	public function validarAction()
	{
		
		$get = Zend_Registry::get('get');
		$email = "";
		$chave = "";
		
		if ($get->email && $get->email!="")
		{
			$email = $get->email;
			$chave = $get->chave;
		}
		
		$this->montaTela("usuario/pagina_validar.tpl", 
								array("arquivo"=>"usuario/formulario_validacao.tpl",
										"email"=>$email,
										"chave"=>$chave), 
								false);
	}
	
	public function verificaValidarAction()
	{
		$post = Zend_Registry::get('post');
		
		$chave = $post->chave;
		$email = $post->email;
//		$senha = geraSenha(6);
		$pagina = "index/resposta_branco.tpl";
		
		$tblUsuario = new Usuario();
		$usuarios = $tblUsuario->busca(array("vhr_login="=>$email));
		
		$mensagem = "";
		$scripts = "";
		
		if (count($usuarios)==0)
		{
			$mensagem = "Usuário não encontrado";
			$pagina = "index/resposta_erro.tpl";
		}
		else
		{
			foreach($usuarios as $usuario)
			{
				if ($usuario->bln_ativo == 1)
				{
					$mensagem = "Usuário já está ativado.";
					$pagina = "index/resposta_sucesso.tpl";
				}
				else
				{
					if (trim($usuario->vhr_chavevalidacao) != trim($chave))
					{
						$mensagem = "Chave inválida.";
						$pagina = "index/resposta_erro.tpl";
					}
					else
					{
						$pagina = "index/resposta_sucesso.tpl";
						$row = $tblUsuario->find($usuario->int_idausuario)->current();
						$row->bln_ativo = 1;
						$row->dte_ativacao = date("Y-m-d H:i:s");
						$senha = $row->vhr_senha;
						$row->save();
						$this->enviaEmailValidado($usuario->vhr_nome, $usuario->vhr_email, $senha);
						$mensagem = "Usuário validado com sucesso.<br>Informe seu email e a senha informada no cadastro inicial no formulário ao lado para acessar.";
						$scripts = "$('#container-form-validacao').html('');";
					}
				}
			}
		}
		
		$this->montaTela($pagina, 
								array("descricao"=>$mensagem,
										"scripts"=>$scripts), 
								false);
	}
	
	public function completeNomeAction()
	{
		$arrOpcoes = array();
		
		$get = Zend_Registry::get('get');
		
		$q = strtoupper($get->q);
		
		$ordens = array("int_idausuario", "vhr_nome", "vhr_login", "dte_cadastro", "dte_ativacao", "vhr_email");
		$ordens2 = array("asc", "desc");
	
		$ordem = $ordens[rand(0,count($ordens)-1)]." ".$ordens2[rand(0,count($ordens2)-1)];
		
		$tblUsuario = new Usuario();
		$rsUsuario = $tblUsuario->busca(array("UPPER(u.vhr_nome) like "=>"%".$q."%",
												"u.bln_ativo = "=>1), array($ordem));
		
		foreach ($rsUsuario as $usuario)
		{
			$tblFotoPerfil = new FotoPerfil();
			$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
												"bln_ativa="=>1), array(), 1, 0)->current();
			if ($fotoPerfil) $cod_foto = $fotoPerfil->int_idafotoperfil;
			else $cod_foto = 0;
			$arrOpcoes[] = array("id"=>$usuario->int_idausuario,
									"nome"=>$usuario->vhr_nome,
									"foto"=>$cod_foto,
									"css"=>$usuario->vhr_css);
		}
		
		$this->montaTela("index/options_complete.tpl", 
							array("dados_lista"=>$arrOpcoes), 
							false);
	}
	
	public function adicionarAmigoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$saoAmigos = null;
		$pagina = "";
		$mensagem = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$usuario = null;
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="" && is_numeric($cod_usuario) && $cod_usuario>0)
		{
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
			
			if ($usuario)
			{
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $cod_usuario);
				
				switch ($saoAmigos)
				{
					case 0:
					case 4:
					case 6:
					case 7:
						$pagina = "perfil/formulario_amigo.tpl";
						break;
					case 1:
					case 5:
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Vocês já são amigos";
						break;
					case 2:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não é possível adicionar você mesmo como amigo.";
						break;
					case 3:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Já foi feita a solicitação de amizade, mas o usuário ainda não aceitou.";
						break;
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
									"_saoAmigos"=>$saoAmigos),
							false);

	}
	
	
	public function adicionarAmigoGravarAction()
	{
		$get = Zend_Registry::get('get');
		$post = Zend_Registry::get('post');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		$msg = $post->mensagem;
		$nomeUsuario = $post->nomeUsuario;
		
		$pagina = "";
		$mensagem = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$usuario = null;
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			
			$solicitante = $tblUsuario->find($identUsuario["id"])->current();
			$solicitado = $tblUsuario->find($cod_usuario)->current();
			
			if ($solicitado)
			{
			
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $cod_usuario);
				
				switch ($saoAmigos)
				{
					case 0:
					case 4:
					case 6:
					case 7:
						$data = array("int_idfusuario1"=>$identUsuario["id"], 
								"int_idfusuario2"=>$cod_usuario, 
								"dte_criacao"=>date("Y-m-d H:i:s"), 
								"bln_aceito"=>3, 
								"txt_solicitacao"=>$msg);
						$tblAmigo->insert($data);
						
						$this->enviaEmailAmigo($identUsuario["usuario_nome"], $solicitado->vhr_nome, $solicitado->vhr_email, $msg);
						
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Solicitação de amizade enviada com sucesso. Aguarde a confirmação.";
						break;
					case 1:
					case 5:
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Vocês já são amigos";
						break;
					case 2:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não é possível adicionar você mesmo como amigo.";
						break;
					case 3:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Já foi feita a solicitação de amizade, mas o usuário ainda não aceitou.";
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
									"descricao"=>$mensagem),
							false);

	}
	
	public function destaqueAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$usuario = null;
		
		$links = array();
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($identUsuario["id"], $usuario->int_idausuario);
				
					// 0 = nao sao amigos e não existe solicitação
	// 1 = sao amigos
	// 2 = mesmo usuario
	// 3 = nao sao amigos e exise solicitacao de amizade
	// 4 = nao sao amigos e a solicitacao foi recusada
	// 5 = sao amigos e o usuario esta bloqueado
	// 6 = nao sao amigos e o usuario esta bloqueado
	// 7 = amigo removido
				
				switch ($saoAmigos)
				{
					case 2:
						$links[] = array("Postar Notícia", "/noticia/form-cadastro");
						$pagina = "usuario/destaque.tpl";
						$mensagem = "";
						$solicitacoesPendentes = $tblAmigo->solicitacoesPendentes($usuario);
						
						if (count($solicitacoesPendentes)>0)
						{
							$links[] = array("(".count($solicitacoesPendentes).") Solicitaç".(count($solicitacoesPendentes)==1?"ão":"ões"), "/usuario/exibe-solicitacoes?cod=".$usuario->int_idausuario);
						}

						break;
					case 0:
						$links[] = array("Adicionar Amigo", "/usuario/adicionar-amigo?cod=".$usuario->int_idausuario);
						break;
					case 4:
						$links[] = array("Adicionar Amigo", "/usuario/adicionar-amigo?cod=".$usuario->int_idausuario);
						break;
					case 1:
						$links[] = array("Enviar Mensagem", "/mensagem/form-cadastro?cod=".$usuario->int_idausuario);
						break;
					case 3:
//						$links[] = array("Reenviar solicitação", "/noticia/form-cadastro");
						break;
					case 5:
						$links[] = array("Desbloquear", "/noticia/form-cadastro");
						break;
					case 6:
						$links[] = array("Desbloquear", "/noticia/form-cadastro");
						$links[] = array("Adicionar Amigo", "/usuario/adicionar-amigo?cod=".$usuario->int_idausuario);
						break;
					case 7:
						$links[] = array("Adicionar Amigo", "/usuario/adicionar-amigo?cod=".$usuario->int_idausuario);
						break;
					
				}
				$pagina = "usuario/destaque.tpl";
				$mensagem = "";
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
		
//		x($links);
		
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"scripts"=>$scripts,
									"links"=>$links,
									"saoAmigos"=>$saoAmigos),
							false);

	}
	
	public function exibeSolicitacoesAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_usuario = $get->cod;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$tblFoto = new FotoPerfil();
		
		$usuario = null;
		
		$foto="";
		
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			
			$usuario = $tblUsuario->find($cod_usuario)->current();
			
			if ($usuario)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($usuario->int_idausuario, $identUsuario["id"]);
				
				switch ($saoAmigos)
				{
					case 2:
						$solicitacoesPendentes = $tblAmigo->solicitacoesPendentes($usuario);
						$pagina = "usuario/destaque_amizades.tpl";
						foreach ($solicitacoesPendentes as $solicitacao)
						{
							$scripts .= "
							jqAjaxLink('/usuario/exibe-solicitacao?cod1=".$usuario->int_idausuario."&cod2=".$solicitacao->int_idfusuario1."', 'container-destaques-amizades-interno', true, 'append');";
						}
						break;
					case 0:
					case 1:
					case 3:
					case 4:
					case 5:
					case 6:
					case 7:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não pode ver solicitações";
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
									"descricao"=>$mensagem,
									"scripts"=>$scripts,
									"foto"=>$foto),
							false);

	}
	
	public function exibeSolicitacaoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_solicitado = $get->cod1;
		$cod_solicitante = $get->cod2;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$tblFoto = new FotoPerfil();
		
		$solicitado = null;
		$solicitante = null;
		
		$foto="";
		
		
		if ($cod_solicitado && $cod_solicitante 
				&& !empty($cod_solicitado) && !empty($cod_solicitante) 
				&& $cod_solicitado!="" && $cod_solicitante!="")
		{
			
			$solicitante = $tblUsuario->find($cod_solicitante)->current();
			$solicitado = $tblUsuario->find($cod_solicitado)->current();
			
			if ($solicitante && $solicitado)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($solicitante->int_idausuario, $solicitado->int_idausuario);
				
//				x($saoAmigos);
				
				switch ($saoAmigos)
				{
					case 0:
					case 4:
					case 5:
					case 6:
					case 7:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não existe solicitação de amizade";
						break;
					case 1:
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Já são amigos";
						break;
					case 2:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Impossível solicitar amizade a você mesmo";
						break;
					case 3:
						$solAmizade = $tblAmigo->busca(array("int_idfusuario1="=>$solicitante->int_idausuario, "int_idfusuario2="=>$solicitado->int_idausuario))->current();
						if ($solAmizade)
						{
							$pagina = "usuario/form_conf_solicitacao.tpl";
							$mensagem = $solAmizade->txt_solicitacao;
							$foto = $tblFoto->busca(array("int_idfusuario="=>$solicitante->int_idausuario,
													"bln_ativa="=>1), array(), 1, 0)->current();
							
						}
						else
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Não pode aprovar uma solicitação feita por você mesmo";
						}
						break;
				}
				
			} 
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Um dos usuários não foi encontrado";
			}
			
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Um dos usuários não foi informado";
		}
		
		$this->montaTela($pagina, 
							array("_usuario"=>$solicitado,
									"_usuario2"=>$solicitante,
									"_saoAmigos"=>$saoAmigos,
									"descricao"=>$mensagem,
									"scripts"=>$scripts,
									"foto"=>$foto),
							false);

	}
	
	public function confirmaSolicitacaoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_solicitado = $get->cod1;
		$cod_solicitante = $get->cod2;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		
		$solicitado = null;
		$solicitante = null;

		if ($cod_solicitado && $cod_solicitante 
				&& !empty($cod_solicitado) && !empty($cod_solicitante) 
				&& $cod_solicitado!="" && $cod_solicitante!="")
		{
			
			$solicitante = $tblUsuario->find($cod_solicitante)->current();
			$solicitado = $tblUsuario->find($cod_solicitado)->current();
			
			if ($solicitante && $solicitado)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($solicitante->int_idausuario, $solicitado->int_idausuario);
				
				switch ($saoAmigos)
				{
					case 0:
					case 4:
					case 5:
					case 6:
					case 7:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não existe solicitação de amizade";
						break;
					case 1:
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Já são amigos";
						break;
					case 2:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Impossível aceitar amizade com você mesmo";
						break;
					case 3:
						$solAmizade = $tblAmigo->busca(array("int_idfusuario1="=>$solicitante->int_idausuario, "int_idfusuario2="=>$solicitado->int_idausuario), array("int_idaamigo desc"), 1, 0)->current();
					
						if ($solAmizade)
						{
							$solAmizade->bln_aceito = 1;
							$solAmizade->dte_aceito = date("Y-m-d H:i:s");
							$solAmizade->save();
							
							$scripts = "setTimeout('$(\"#container-solicitacao-aceitar".$solicitante->int_idausuario."\").hide(\"slow\")', 3000);
							jqAjaxLink('/usuario/exibe-amigos-home?cod=".$solicitado->int_idausuario."','container-amigos-usuario-home',true);";
							
							$this->enviaEmailAmigoAceito($solicitado->vhr_nome, $solicitante->vhr_nome, $solicitante->vhr_email);
							
							$pagina = "index/resposta_sucesso.tpl";
							$mensagem = "Solicitação aceita";
						}
						else
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Não pode aprovar uma solicitação feita por você mesmo";
						}
				}
				
			} 
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Um dos usuários não foi encontrado";
			}
			
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Um dos usuários não foi informado";
		}
		
		$this->montaTela($pagina, 
							array("_usuario"=>$solicitado,
									"_usuario2"=>$solicitante,
									"descricao"=>$mensagem,
									"scripts"=>$scripts),
							false);

	}
	
	public function recusaSolicitacaoAction()
	{
		$get = Zend_Registry::get('get');
		
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		
		$cod_solicitado = $get->cod1;
		$cod_solicitante = $get->cod2;
		
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		
		$solicitado = null;
		$solicitante = null;

		if ($cod_solicitado && $cod_solicitante 
				&& !empty($cod_solicitado) && !empty($cod_solicitante) 
				&& $cod_solicitado!="" && $cod_solicitante!="")
		{
			
			$solicitante = $tblUsuario->find($cod_solicitante)->current();
			
			$solicitado = $tblUsuario->find($cod_solicitado)->current();
			
			
			if ($solicitante && $solicitado)
			{
				
				$saoAmigos = $tblAmigo->saoAmigos($solicitante->int_idausuario, $solicitado->int_idausuario);
				
				switch ($saoAmigos)
				{
					case 0:
					case 4:
					case 5:
					case 6:
					case 7:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Não existe solicitação de amizade";
						break;
					case 1:
						$pagina = "index/resposta_sucesso.tpl";
						$mensagem = "Já são amigos";
						break;
					case 2:
						$pagina = "index/resposta_erro.tpl";
						$mensagem = "Impossível recusar amizade com você mesmo";
						break;
					case 3:
						$solAmizade = $tblAmigo->busca(array("int_idfusuario1="=>$solicitante->int_idausuario, "int_idfusuario2="=>$solicitado->int_idausuario))->current();
					
						if ($solAmizade)
						{
							$solAmizade->bln_aceito = 4;
							$solAmizade->dte_aceito = date("Y-m-d H:i:s");
							$solAmizade->save();

							$scripts = "setTimeout('$(\"#container-solicitacao-aceitar".$solicitante->int_idausuario."\").hide(\"slow\")', 3000);";
							
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Solicitação recusada";
							
						}
						else
						{
							$pagina = "index/resposta_erro.tpl";
							$mensagem = "Não pode recusar uma solicitação feita por você mesmo";
						}
				}
			} 
			else
			{
				$pagina = "index/resposta_erro.tpl";
				$mensagem = "Um dos usuários não foi encontrado";
			}
			
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Um dos usuários não foi informado";
		}
		
		$this->montaTela($pagina, 
							array("_usuario"=>$solicitado,
									"_usuario2"=>$solicitante,
									"descricao"=>$mensagem,
									"scripts"=>$scripts),
							false);

	}
	
	public function migrarAction()
	{
		
		$conPublicare = false;
		$tblUsuario = new Usuario();
		$tblFotoPerfil = new FotoPerfil();
		$tblNoticia = new Noticia();
		
		// classes
		$classes = array(
			"usuario"=>array(
						"cod"=>62,
						"props"=>array(
									"foto"=>172,
									"nascimento"=>173,
									"sexo"=>179,
									"civil"=>181,
									"uf"=>180,
									"cidade"=>176,
									"profissao"=>177,
									"descricao"=>178,
									"publico"=>182)),
			"noticia"=>array(
						"cod"=>10,
						"props"=>array(
									"foto"=>171,
									"texto"=>8,
									"fonte"=>11,
									"link"=>13))
		);
		
		$comple = array(
						"civil"=>array(
									"0"=>"1",
									"640"=>"2",
									"642"=>"9",
									"641"=>"10",
									"639"=>"5",
									"643"=>"6"
						),
						"uf"=>array(
									"0"=>"1",
									"611"=>"2",
									"612"=>"3",
									"613"=>"4",
									"614"=>"5",
									"615"=>"6",
									"616"=>"7",
									"617"=>"8",
									"618"=>"9",
									"619"=>"10",
									"620"=>"11",
									"621"=>"12",
									"622"=>"13",
									"623"=>"14",
									"624"=>"15",
									"625"=>"16",
									"626"=>"17",
									"627"=>"18",
									"628"=>"19",
									"629"=>"20",
									"630"=>"21",
									"631"=>"22",
									"632"=>"23",
									"633"=>"24",
									"634"=>"25",
									"635"=>"26",
									"636"=>"27",
									"637"=>"28"
						)
		);
		
		// propriedades
		$propFotoPerfil = 172;
		$propNascimento = 173;
		$propSexo = 179;
		$propCivil = 181;
		$propCidade = 176;
		
		
		
		if(!($conPublicare = mysql_connect("localhost","mirtesne","22Em9kg2Tm"))) {
		   echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
   			exit;
		} 
		
		if(!($con=mysql_select_db("mirtesne_publicare",$conPublicare))) {
		   echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
		   exit;
		} 
		
		// recuperando usuarios
		$sql = "select cod_usuario, nome, login from usuario
				where cod_usuario not in (1,130)
				and valido = 1
				order by cod_usuario";
		$res = mysql_query($sql,$conPublicare);
		
		$usuarios = array();
		
		while ($row = mysql_fetch_array($res)) 
		{
			$usuario = array();
			$usuario["cod"] = $row["cod_usuario"];
			$usuario["nome"] = $row["nome"];
			$usuario["login"] = $row["login"];
			$usuario["senha"] = geraSenha(8);
			
			// recuperando perfis
			$sql = "select * from objeto 
					where cod_usuario = ".$usuario["cod"]." 
					and cod_classe = ".$classes["usuario"]["cod"]." 
					and cod_status = 2
					and apagado = 0";
			$res2 = mysql_query($sql,$conPublicare);
			while ($row2 = mysql_fetch_array($res2)) 
			{
				$usuario["criacao"] = $row2["data_publicacao"];
				$usuario["perfil"]["cod"] = $row2["cod_objeto"];
				
				// foto do perfil
				$sql = "select * from tbl_blob 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["foto"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["foto"]["cod"] = 0;
				$usuario["perfil"]["foto"]["arquivo"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["foto"]["cod"] = $row3["cod_blob"];
					$usuario["perfil"]["foto"]["arquivo"] = $row3["arquivo"];
					
				}
				
				// nascimento
				$sql = "select * from tbl_date 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["nascimento"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["nascimento"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["nascimento"] = $row3["valor"];
					
				}
				
				// sexo
				$sql = "select * from tbl_boolean 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["sexo"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["sexo"] = null;
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["sexo"] = $row3["valor"];
					
				}
				
				// estado civil
				$sql = "select * from tbl_objref 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["civil"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["civil"]["cod"] = 0;
				$usuario["perfil"]["civil"]["nome"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["civil"]["cod"] = $row3["valor"];
					
					$sql = "select * from objeto 
						where cod_objeto = ".$row3["valor"];
					$res4 = mysql_query($sql,$conPublicare);
					while ($row4 = mysql_fetch_array($res4)) 
					{
						$usuario["perfil"]["civil"]["nome"] = $row4["titulo"];
					}
					
				}
				
				// uf
				$sql = "select * from tbl_objref 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["uf"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["uf"]["cod"] = 0;
				$usuario["perfil"]["uf"]["nome"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["uf"]["cod"] = $row3["valor"];
					
					$sql = "select * from objeto 
						where cod_objeto = ".$row3["valor"];
					$res4 = mysql_query($sql,$conPublicare);
					while ($row4 = mysql_fetch_array($res4)) 
					{
						$usuario["perfil"]["uf"]["nome"] = $row4["titulo"];
					}
					
				}
				
				// cidade
				$sql = "select * from tbl_string 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["cidade"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["cidade"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["cidade"] = $row3["valor"];
					
				}
				
				// profissao
				$sql = "select * from tbl_string 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["profissao"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["profissao"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["profissao"] = $row3["valor"];
					
				}
				
				// quem sou eu
				$sql = "select * from tbl_string 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["descricao"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["descricao"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["descricao"] = $row3["valor"];
					
				}
				
				// publico
				$sql = "select * from tbl_boolean 
						where cod_objeto = ".$usuario["perfil"]["cod"]." 
						and cod_propriedade = ".$classes["usuario"]["props"]["publico"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["perfil"]["publico"] = 1;
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$usuario["perfil"]["publico"] = $row3["valor"];
					
				}
				
			}
			
			
			
			// noticias
			$sql = "select * from objeto 
					where cod_usuario = ".$usuario["cod"]." 
					and cod_classe = ".$classes["noticia"]["cod"]." 
					and cod_status = 2
					and apagado = 0";
			$res2 = mysql_query($sql,$conPublicare);
			$usuario["noticias"]["total"] = 0;
			while ($row2 = mysql_fetch_array($res2))
			{
				$noticia["cod"] = $row2["cod_objeto"];
				$noticia["titulo"] = $row2["titulo"];
				$noticia["resumo"] = $row2["descricao"];
				$noticia["criacao"] = $row2["data_publicacao"];
				
				// foto
				$sql = "select * from tbl_blob 
						where cod_objeto = ".$noticia["cod"]." 
						and cod_propriedade = ".$classes["noticia"]["props"]["foto"];
				$res3 = mysql_query($sql,$conPublicare);
				$noticia["foto"]["cod"] = 0;
				$noticia["foto"]["arquivo"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$noticia["foto"]["cod"] = $row3["cod_blob"];
					$noticia["foto"]["arquivo"] = $row3["arquivo"];
					
				}
				
				// conteudo
				$sql = "select * from tbl_text 
						where cod_objeto = ".$noticia["cod"]." 
						and cod_propriedade = ".$classes["noticia"]["props"]["texto"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["conteudo"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$noticia["conteudo"] = $row3["valor"];
					
				}
				
				// fonte
				$sql = "select * from tbl_string 
						where cod_objeto = ".$noticia["cod"]." 
						and cod_propriedade = ".$classes["noticia"]["props"]["fonte"];
				$res3 = mysql_query($sql,$conPublicare);
				$noticia["fonte"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$noticia["fonte"] = $row3["valor"];
					
				}
				
				// link
				$sql = "select * from tbl_string 
						where cod_objeto = ".$noticia["cod"]." 
						and cod_propriedade = ".$classes["noticia"]["props"]["link"];
				$res3 = mysql_query($sql,$conPublicare);
				$usuario["link"] = "";
				while ($row3 = mysql_fetch_array($res3)) 
				{
					
					$noticia["link"] = $row3["valor"];
					
				}
				
				
				$usuario["noticias"]["total"]++;
				
				$usuario["noticias"][$usuario["noticias"]["total"]] = $noticia;
			}
			
			$usuarios[] = $usuario;
		}
		
		// adicionando dados no novo socialzend
		foreach ($usuarios as $usu)
		{
//			x($usu);
			
			$envEmail = array();
			$_site = Zend_Registry::get("site");
			
			// verifica se o email já existe
			$usuario = $tblUsuario->busca(array("vhr_login="=>$usu["login"]))->current();
			if ($usuario) {
				
				$envEmail[] = "existe";
				
				if ($usuario->bln_ativo == 0)
				{
					$usuario->bln_ativo = 1;
					$usuario->dte_ativacao = date("Y-m-d H:i:s");
//					$usuario->save();
					$envEmail[] = "ativado";
				}
				
				
				
//				$usuario->vhr_nome = $usu["nome"];
				
//				$dados = array("int_idausuario"=>$usuario->int_idausuario);
//				$dados = array("vhr_nome"=>$usu["nome"]); //echo "encontrado ".$usu["login"]."<br>";
				
//				x($usuario->toArray());
				
			}
			else
			{
				$envEmail[] = "novo";
				/*
				
				$dadosNew = array(
					"int_idfperfil"=>1,
					"int_idfestadocivil"=>$comple["civil"][$usu["civil"]["cod"]],
					"vhr_nome"=>$usu["nome"],
					"vhr_login"=>$usu["login"],
					"vhr_senha"=>$usu["senha"],
					"dte_cadastro"=>date("Y-m-d H:i:s"),
					"bln_ativo"=>1,
					"dte_ativacao"=>date("Y-m-d H:i:s"),
					"vhr_sexo"=>($usu["sexo"]=="0"?"M":"F"),
					"dte_nascimento"=>substr($usu["nascimento"],0,4)
										."-".substr($usu["nascimento"],4,2)
										."-".substr($usu["nascimento"],6,2),
					"vhr_profissao"=>$usu["profissao"],
					"txt_quemsoueu"=>$usu["descricao"],
					"bln_perfilpublico"=>$usu["publico"],
					"vhr_email"=>$usu["login"]
				);
				
				if ($tblUsuario->insert($dadosNew))
				{
					$usuario = $tblUsuario->busca(array(), 
															array("int_idausuario desc"), 1, 0)->current();
															
				}*/
			}
			
			
			// verificando se existem noticias e cadastrando as mesmas
			if ($usu["noticias"]["total"] > 0)
			{
				$envEmail[] = "noticia";
				
				for ($i=1; $i<$usu["noticias"]["total"]; $i++)
				{
					
					$not = $usu["noticias"][$i];
					
					$dados = array(
						"int_idfusuario"=>$usuario->int_idausuario,
						"vhr_titulo"=>utf8_encode($not["titulo"]),
						"txt_resumo"=>utf8_decode($not["resumo"]),
						"dte_criacao"=>substr($not["criacao"],0,4)
										."-".substr($not["criacao"],4,2)
										."-".substr($not["criacao"],6,2)
										." ".substr($not["criacao"],8,2)
										.":".substr($not["criacao"],10,2)
										.":".substr($not["criacao"],12,2),
						"int_cliques"=>0,
						"vhr_subtitulo"=>"",
						"vhr_fonte"=>utf8_encode($not["fonte"]),
						"vhr_link"=>$not["link"],
						"bln_admin"=>0,
						"bln_publica"=>1,
						"bln_ativo"=>1,
						"vhr_tags"=>"",
						"txt_conteudo"=>utf8_decode($not["conteudo"])
					);
					

//					if ($tblNoticia->insert($dados))
//					{
						$maiorNoticia = $tblNoticia->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"dte_criacao="=>$dados["dte_criacao"],
															"bln_ativo="=>1), 
														array("int_idanoticia desc"), 1, 0)->current();
														
						$cod_noticia = $maiorNoticia->int_idanoticia;
						
//						echo $cod_noticia."<br>";
						
						if ($not["foto"]["cod"]>0)
						{
//							echo "tem foto";
							$extensao = explode(".", $not["foto"]["arquivo"]);
							$extensao = strtolower($extensao[count($extensao)-1]);
							if ($extensao == "") $extensao = "jpg";
							$nome = $not["foto"]["cod"].".".$extensao;
							$arquivo = identificaPasta($not["foto"]["cod"])."/".$nome;
							$dados["foto"] = $arquivo;
							
							
							$dadosFoto = array("int_idfusuario"=>$usuario->int_idausuario,
											"dte_upload"=>date("Y-m_d H:i:s"),
											"bln_ativa"=>0,
											"vhr_nomearquivo"=>$not["foto"]["arquivo"],
											"bln_ativo"=>1,
											"int_idfnoticia"=>$cod_noticia);
											
//							if ($tblFotoPerfil->insert($dadosFoto))
//							{
							try 
							{
								$maiorFoto = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
																	"int_idfnoticia="=>$cod_noticia), 
															array("int_idafotoperfil desc"), 1, 0)->current();
															
								$cod_foto = $maiorFoto->int_idafotoperfil;
								
								$novo_arquivo = identificaPasta($cod_foto)."/".$cod_foto.".".$extensao;
								$novo_arquivo_min = identificaPasta($cod_foto)."/".$cod_foto."-min.".$extensao;
								
								copy("/home/mirtesne/public_html/classico/upd_blob/".$arquivo, "/home/mirtesne/public_html/novo/uploads/".$novo_arquivo);
								copy("/home/mirtesne/public_html/classico/upd_thumb/".$nome, "/home/mirtesne/public_html/novo/uploads/".$novo_arquivo_min);
							} catch (Exception $e) {}
//							}
							
						}
						
						
					//}

					
//						xd($dados);
					
				}
				
			}
			
		/*
			$assunto = "Novo socialzend - Migração da sua conta";
			$corpo = "Caro(a) ".$usuario->vhr_nome.",<br><br>
			O socialzend foi reformulado e já está disponível uma nova versão desta rede social no endereço http://www.socialzend.com. <br><br>
			Você está recebendo este email pois o email pois o login <b>".$usuario->vhr_login."</b> está cadastrado no socialzend antigo. <br><br>";
			foreach ($envEmail as $enviar)
			{
				if ($enviar=="existe") $corpo .= "- O mesmo login já existe no novo socialzend, portanto não foi recriado e a sua senha de acesso continua a mesma. <br>";
				if ($enviar=="novo") $corpo .= "- O login foi criado e ativado automaticamente para você. Confira seus dados de acesso:<br>
												Login: ".$usuario->vhr_login."<br>
												Senha: ".$usuario->vhr_senha."<br>";
				if ($enviar=="ativado") $corpo .= "- Seu login estava desativado, portanto ativamos ele para você. <br>";
				if ($enviar=="noticia") $corpo .= "- Suas notícias foram automaticamente migradas para o novo socialzend. <br>";
			}
			$corpo .= "<br>Acesse agora mesmo e confira as novidades que preparamos especialmente para você.<br><br>
			Caso deseje utilizar o socialzend antigo, ele poderá ser encontrado aqui: http://classico.socialzend.com";
			
			if (strpos($usuario->vhr_login,"@")===false)
			{
			}
			else
			{
				enviaEmail($assunto, $corpo, $usuario->vhr_nome, $usuario->vhr_login);
			}
			*/
//			xd("fim");
			
		}
		
		xd("fim");
	}
	
	public function lembreteAtivacaoAction()
	{
		$tblUsuario = new Usuario();
		$_site = Zend_Registry::get("site");
		
		$usuarios = $tblUsuario->busca(array("u.bln_ativo="=>0));
		
		if ($usuarios)
		{
			echo "total usuarios inativos: ".count($usuarios)."<br>";
			
			$assunto = "Ative a sua conta - socialzend";

			foreach($usuarios as $usu)
			{
				$nome = $usu->vhr_nome;
				$email = $usu->vhr_login;
				$chave = $usu->vhr_chavevalidacao;
				
				$corpo = "Cara(o) ".$nome.",<br><br>
				Você está recebendo esta mensagem por ter cadastrado seu email no socialzend. Sua conta ainda não foi ativada.<br><br>
				Para conhecer o socialzend e começar a fazer amigos é simples, basta clicar no link abaixo (ou copiar o endereço e colar no seu navegador) e sua conta será ativada.<br><br>
			 	<a href='".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."' target='_blank'>".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."</a><br><br>
				Venha, junte-se a nós.<br><br>
				socialzend
				";
				
				if (strpos($email,"@")===false)
				{
				}
				else
				{
					enviaEmail($assunto, $corpo, $nome, $email);
				}

				
				echo " - ".$usu->vhr_login."<br>";
			}
//			$nome = 
		}
		
		xd("fim");
	}
	
	private function enviaEmailValidado($nome, $email, $senha)
	{
		$_site = Zend_Registry::get("site");
		
		$assunto = "Cadastro Validado - socialzend";
		$corpo = "Caro(a) ".$nome.",<br><br>
		Seu cadastro foi validado. <br><br>
		Para acessar o socialzend utilize os dados abaixo.<br>
		LOGIN: ".$email."<br>
		SENHA: ".$senha;
		
		enviaEmail($assunto, $corpo, $nome, $email);
	}
	
	private function enviaEmailCadastro($nome, $email, $chave)
	{
		$_site = Zend_Registry::get("site");
		
		$assunto = "Novo Cadastro - socialzend";
		$corpo = "Caro(a) ".$nome.",<br><br>
		Recebemos um pedido de cadastro no site socialzend, seu email foi cadastrado mas ainda nao foi confirmado. <br><br>
		Para validar seu cadastro é simples, basta clicar no endereço abaixo (ou copiar e colar no seu navegador).<br><br>
		<a href='".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."'>".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."</a><br>
		<!--CHAVE: ".$chave."-->";
		
		enviaEmail($assunto, $corpo, $nome, $email);
	}
	
	private function enviaEmailChave($nome, $email, $chave)
	{
		$_site = Zend_Registry::get("site");
		
		$assunto = "Ativação da conta - socialzend";
		$corpo = "Caro(a) ".$nome.",<br><br>
		Você está cadastrado no socialzend mas sua conta ainda não foi ativada.<br><br>
		Para validar seu cadastro é simples, basta clicar no endereço abaixo (ou copiar e colar no seu navegador).<br><br>
		URL: <a href='".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."'>".$_site["url"]."usuario/validar?email=".$email."&chave=".$chave."</a><br>
		<!--CHAVE: ".$chave."-->";
		
		enviaEmail($assunto, $corpo, $nome, $email);
	}
	
	private function enviaEmailAmigo($nomeRemetente, $nomeDestino, $email, $msg)
	{
		$_site = Zend_Registry::get("site");
		
		$assunto = "Solicitacao de amizade - socialzend";
		$corpo = "Caro(a) ".$nomeDestino.",<br><br>
		O usuario <b>".$nomeRemetente."</b> fez uma solicitacao de amizade no socialzend. <br><br>
		***** MENSAGEM *****<br>
		".$msg."<br>
		********************<br><br>
		Acesse a sua conta para aprovar ou negar a solicitacao.<br>
		".$_site["url"];
		
		enviaEmail($assunto, $corpo, $nomeDestino, $email);
	}
	
	private function enviaEmailAmigoAceito($nomeRemetente, $nomeDestino, $email)
	{
		$_site = Zend_Registry::get("site");
		
		$assunto = "Solicitacao de amizade aceita - socialzend";
		$corpo = "Caro(a) ".$nomeDestino.",<br><br>
		O usuario <b>".$nomeRemetente."</b> aceitou a sua solicitacao de amizade no socialzend. <br><br>
		".$_site["url"];
		
		enviaEmail($assunto, $corpo, $nomeDestino, $email);
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