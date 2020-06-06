<?php
/**
* Controlador PERFIL
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
	

class PerfilController extends Zend_Controller_Action
{
	
	private $intTamPag;
	

	public function init()
	{
		Zend_Loader::loadClass('Usuario');
		Zend_Loader::loadClass('Cidade');
		Zend_Loader::loadClass('Uf');
		Zend_Loader::loadClass('EstadoCivil');
		Zend_Loader::loadClass('Perfil');
		Zend_Loader::loadClass('FotoPerfil');
		Zend_Loader::loadClass('Amigo');
		// inicializando variaveis com valor padrao
//		$this->intTamPag = 10;
	}


	public function indexAction()
	{
		$this->_redirect("/perfil/visualizar");
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
						if ($cidade) $uf = $cidade->findParentRow("Uf");
						
						$tblFotoPerfil = new FotoPerfil();
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1,
															"int_idfnoticia="=>0), array(), 1, 0)->current();
						
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
	
	public function visualizarFotoAction()
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
															"bln_ativa="=>1,
															"int_idfnoticia="=>0), array(), 1, 0)->current();
						
						if ($usuario->dte_nascimento!=null)
						{
							$date = new Zend_Date();
							$date->set($usuario->dte_nascimento, "Y-m-d");
							$usuario->dte_nascimento = $date->get("dd/mm/Y");
						}
						
						$pagina = "perfil/visualizar_foto.tpl";
						
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
						if ($cidade) $uf = $cidade->findParentRow("Uf");
						
						$tblFotoPerfil = new FotoPerfil();
						$fotoPerfil = $tblFotoPerfil->busca(array("int_idfusuario="=>$usuario->int_idausuario,
															"bln_ativa="=>1,
															"int_idfnoticia="=>0), array(), 1, 0)->current();
						
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
										"bln_ativo="=>1,
										"int_idfnoticia="=>0),
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
	
	public function fotoAction()
	{
		$identUsuario = Zend_Auth::getInstance()->getIdentity();
		
		$tblUsuario = new Usuario();
		$tblAmigo = new Amigo();
		
		$mensagem = "";
		$scripts = "";
		$fotos_perfil = "";

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
						$fotos_perfil = $this->pegaFotosPerfil($usuario->int_idausuario);
						$pagina = "perfil/detalhes_foto.tpl";
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
									"_fotos"=>$fotos_perfil,
									"saoAmigos"=>$saoAmigos,
									"descricao"=>$mensagem),
							false);

	}
	
	static function retornaExtensao($arquivo)
	{
		$extensao = explode(".", $arquivo);
		return strtolower($extensao[count($extensao)-1]);
	}
	
	public function verFotoAction()
	{
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$cod_usuario = $identUsuario["id"];
		
		$get = Zend_Registry::get('get');
		$cod_foto = $get->cod;
		$mini = $get->mini;
		$paramAltura = ($get->alt?$get->alt:0);
		$tblFoto = new FotoPerfil();
		$tblAmigo = new Amigo();
		$tblUsuario = new Usuario();
		$foto = $tblFoto->find($cod_foto)->current();
		$cod_noticia = $get->cod2;
		
		if ($foto)
		{
			
				// 0 = nao sao amigos e não existe solicitação
	// 1 = sao amigos
	// 2 = mesmo usuario
	// 3 = nao sao amigos e exise solicitacao de amizade
	// 4 = nao sao amigos e a solicitacao foi recusada
	// 5 = sao amigos e o usuario esta bloqueado
	// 6 = nao sao amigos e o usuario esta bloqueado
	// 7 = amigo removido
			
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$foto->int_idfusuario))->current();
			
			$saoAmigos = $tblAmigo->saoAmigos($foto->int_idfusuario, $identUsuario["id"]);
			$permitida = "n";
			
			switch ($saoAmigos)
			{
				case 1:
				case 2:
					$permitida = "s";
					break;
				case 0:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
					$permitida = "n";
					break;
			}
			
			if ($identUsuario["id_perfil"]==2) $permitida = "s";
			if ($cod_noticia && $cod_noticia!="" && $cod_noticia>0 && $cod_noticia==$foto->int_idfnoticia) $permitida = "s";
			
			if ($permitida == "n" && $foto->bln_ativa==0)
			{
				$im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . "/images/site/foto-naopermitida.jpg");
				header("Content-Type: image/jpg");
				imagejpeg($im);
				exit();
			}
			else
			{
				$extensao = strtolower(PerfilController::retornaExtensao($foto->vhr_nomearquivo));
				
				$pasta = $_SERVER['DOCUMENT_ROOT'] . '/../uploads/' . identificaPasta($cod_foto) . '/';
				
				if ($mini) {
					$arquivo = $pasta . $cod_foto . "-min." . $extensao;
				}
				else
				{
					$arquivo = $pasta . $cod_foto . "." . $extensao;
				}
				
				switch ($extensao)
				{
					case 'gif':
						$im = imagecreatefromgif($arquivo);
						break;
				
					case 'jpeg':
					case 'jpg':
						$im = imagecreatefromjpeg($arquivo);
						break;
				
					case 'png':
						$im = imagecreatefrompng($arquivo);
						break;
						
				}
				
				$x = $width = imagesx($im);
				$y = $height = imagesy($im);
				
				if ($mini)
				{
					if ($paramAltura > 0)
					{
						if ($height >= $paramAltura)
						{
							$height = $paramAltura;
							if ($extensao == "jpg" || $extensao == "jpeg")
							{
								$newim = imagecreatetruecolor($width, $height);
							}
							else
							{
								$newim = imagecreate($width, $height);
							}
							imagecopy($newim, $im, 0, 0, 0, 0, $width, $height);
							$im = $newim;
							$newim= "";
						}
					}
				}
				
				switch ($extensao)
				{
					case 'gif':
//						$im = imagecreatefromgif($arquivo);
						header("Content-Type: image/gif");
						imagegif($im);
						break;
				
					case 'jpeg':
					case 'jpg':
//						$im = imagecreatefromjpeg($arquivo);
						header("Content-Type: image/jpg");
						imagejpeg($im);
						break;
				
					case 'png':
//						$im = imagecreatefrompng($arquivo);
						header("Content-Type: image/png");
						imagepng($im);
						break;
						
				}
				exit();
			}
			
			
		}
		else
		{
			$im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . "/images/site/foto-naoencontrada.jpg");
			header("Content-Type: image/jpg");
			imagejpeg($im);
			exit();
		}
		
		
	}
	
	public function uploadFotoAction()
	{
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$cod_usuario = $identUsuario["id"];
		$mensagem = "";
		
		$scripts = "";
		
		if (!empty($_FILES)) 
		{
			if (count($_FILES["Filedata"]["name"]) > 1)
			{
				for ($i=0; $i<count($_FILES["Filedata"]["name"]); $i++)
				{
					$nome_arquivo = $_FILES['Filedata']['name'][$i];
					$tempFile = $_FILES['Filedata']['tmp_name'][$i];
					
					PerfilController::enviarFoto($nome_arquivo, $tempFile, $cod_usuario);
				}
			}
			else
			{
				$nome_arquivo = $_FILES['Filedata']['name'];
				$tempFile = $_FILES['Filedata']['tmp_name'];
				
				PerfilController::enviarFoto($nome_arquivo, $tempFile, $cod_usuario);
			}
			
			$pagina = "index/resposta_sucesso.tpl";
			$scripts = "jqAjaxLink('/perfil/foto?cod=".$cod_usuario."', 'container-fotos-perfil', true);";
			$mensagem = "Foto enviada com sucesso";
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Nenhum arquivo enviado";
		}
		
		// exibe tela
		$this->montaTela($pagina,
							array("scripts"=>$scripts,
									"descricao"=>$mensagem),
							false);
	}
	
	
	static function enviarFoto($nome_arquivo, $tempFile, $cod_usuario)
	{
		$extensoes_permitidas = array("gif", "jpg", "jpeg", "png");
		$extensao = strtolower(PerfilController::retornaExtensao($nome_arquivo));
		
		if (in_array($extensao, $extensoes_permitidas))
		{
			$tblFoto = new FotoPerfil();
					
			$data = array("int_idfusuario"=>$cod_usuario,
						"dte_upload"=>date("Y-m-d H:i:s"),
						"bln_ativa"=>0,
						"vhr_nomearquivo"=>$nome_arquivo,
						"bln_ativo"=>1,
						"int_idfnoticia"=>0);
			$tblFoto->insert($data);
			
			$maiorFoto = $tblFoto->busca(array(), array("int_idafotoperfil desc"), 1, 0)->current();
			$cod_foto = $maiorFoto->int_idafotoperfil;
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/../uploads/' . identificaPasta($cod_foto) . '/';
			
			if (!is_dir($targetPath))
			{
				mkdir( $targetPath, 0755);
			}
			
			$targetFile =  str_replace('//','/',$targetPath) . $cod_foto.".".$extensao;
			$targetTumbFile =  str_replace('//','/',$targetPath) . $cod_foto."-min.".$extensao;

			move_uploaded_file($tempFile, $targetFile);
			@unlink($tempFile);
			
			if ($extensao=="jpg" || $extensao=="jpge") $im = @imagecreatefromjpeg($targetFile);
			if ($extensao=="png") $im = @imagecreatefrompng($targetFile);
			if ($extensao=="gif") $im = @imagecreatefromgif($targetFile);

			if ($im)
			{
				$x = imagesx($im);
				$y = imagesy($im);
				$width = 200;
				$height = ceil($width*$y/$x);
				if ($extensao == "jpg" || $extensao == "jpeg")
				{
					$newim = imagecreatetruecolor($width, $height);
				}
				else
				{
					$newim = imagecreate($width, $height);
				}
				imagecopyresized($newim, $im, 0, 0, 0, 0, $width, $height, $x, $y);
					
				$im = $newim;
					
				switch ($extensao)
				{
					case 'jpeg':
					case 'jpg':
						imagejpeg($im, $targetTumbFile, 60);
						break;
					case 'png':
						imagepng($im, $targetTumbFile);
						break;
					case 'gif':
						imagegif($im, $targetTumbFile);
						break;
				}
					
				
			}
		}
	}
	
	
	public function colocarFotoPerfilAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$tblUsuario = new Usuario();
		$tblFotoPerfil = new FotoPerfil();
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$cod_usuario = $get->cod;
		$cod_foto = $get->codFoto;
		
		$usuario = $tblUsuario->busca(array("int_idausuario="=>$identUsuario["id"]))->current();
		
		if ($usuario)
		{
			$foto = $tblFotoPerfil->busca(array("int_idfusuario="=>$cod_usuario,
												"int_idafotoperfil="=>$cod_foto))->current();
			if ($foto)
			{
				$fotos = $tblFotoPerfil->busca(array("int_idfusuario="=>$cod_usuario, 
												"bln_ativa="=>1));
												
				foreach ($fotos as $ft)
				{
					$ft->bln_ativa = 0;
					$ft->save();
				}
				
				$foto->bln_ativa = 1;
				$foto->save();
			}
			$pagina = "index/resposta_branco.tpl";
			$mensagem = "Imagem apagada com sucesso";
//			jqAjaxLink("/perfil/foto?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-fotos-perfil", true);
			$scripts = "jqAjaxLink('/perfil/foto?cod=".$cod_usuario."', 'container-fotos-perfil', true);";
			$scripts .= "jqAjaxLink('/usuario/exibe-resumo-home?cod=".$cod_usuario."', 'container-resumo-usuario-home', true);";
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não encontrado";
		}

		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"scripts"=>$scripts),
							false);
	}
	
	public function apagarFotoAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$tblUsuario = new Usuario();
		$tblFotoPerfil = new FotoPerfil();
		$pagina = "";
		$mensagem = "";
		$scripts = "";
		
		$cod_usuario = $get->cod;
		$cod_foto = $get->codFoto;
		
		$usuario = $tblUsuario->busca(array("int_idausuario="=>$identUsuario["id"]))->current();
		
		if ($usuario)
		{
			$foto = $tblFotoPerfil->busca(array("int_idfusuario="=>$cod_usuario,
												"int_idafotoperfil="=>$cod_foto))->current();
			if ($foto)
			{
				$foto->bln_ativo = 0;
				$foto->save();
			}
			$pagina = "index/resposta_branco.tpl";
			$mensagem = "Imagem apagada com sucesso";
//			jqAjaxLink("/perfil/foto?cod={/literal}{$_usuario->int_idausuario}{literal}", "container-fotos-perfil", true);
			$scripts = "jqAjaxLink('/perfil/foto?cod=".$cod_usuario."', 'container-fotos-perfil', true);";
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não encontrado";
		}

		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"descricao"=>$mensagem,
									"scripts"=>$scripts),
							false);
	}
	
	public function editarAction()
	{
		$get = Zend_Registry::get('get');
		$auth = Zend_Auth::getInstance();
		$identUsuario = $auth->getIdentity();
		$tblUsuario = new Usuario();
		$pagina = "";
		$usuario = "";
		$cidade = "";
		$uf = "";
		$mensagem = "";
		$scripts = "";
		$estadoCivil = "";
		
		$cod_usuario = $get->cod;
		
		if ($cod_usuario && !empty($cod_usuario) && $cod_usuario!="")
		{
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$cod_usuario))->current();
		}
		else
		{
			$usuario = $tblUsuario->busca(array("int_idausuario="=>$identUsuario["id"]))->current();
		}
		
		if ($usuario)
		{
			$estadoCivil = $usuario->findParentRow("EstadoCivil");
			$cidade = $usuario->findParentRow("Cidade");
			$uf = $cidade->findParentRow("Uf");
			
//			xd($uf);
			
			if ($usuario->dte_nascimento!=null)
			{
				$date = new Zend_Date();
				$date->set($usuario->dte_nascimento, "Y-m-d");
				$usuario->dte_nascimento = $date->get("dd/mm/Y");
			}
			
			$pagina = "perfil/formulario_editar.tpl";
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuário não encontrado";
		}

		// exibe tela
		$this->montaTela($pagina, 
							array("_usuario"=>$usuario,
									"_estadoCivil"=>$estadoCivil,
									"_cidade"=>$cidade,
									"_uf"=>$uf,
									"descricao"=>$mensagem),
							false);
	}
	
	public function gravaEditarAction()
	{
		$get = Zend_Registry::get('get');
		$post = Zend_Registry::get('post');
		$cod_usuario = $get->cod;
		$scripts = "";
		
		$tblUsuario = new Usuario();
		$usuario = $tblUsuario->find($cod_usuario)->current();
		
		if ($usuario)
		{
			$usuario->vhr_nome = $post->nome;
			
			$date = new Zend_Date();
			$date->set($post->dataNascimento, "dd/mm/Y");
			$usuario->dte_nascimento = $date->get("Y-m-d");
			
			$usuario->vhr_sexo = $post->genero;
			$usuario->int_idfestadocivil = $post->estadoCivil;
			$usuario->int_idfcidade = $post->cidade;
			$usuario->vhr_profissao = $post->profissao;
			$usuario->txt_quemsoueu = $post->quemSouEu;
			
			$usuario->save();
			
			$pagina = "index/resposta_sucesso.tpl";
			$mensagem = "Dados alterados com sucesso";
			$scripts = 'jqAjaxLink("/usuario/exibe-resumo-home?cod='.$cod_usuario.'", "container-resumo-usuario-home", true);';
		}
		else
		{
			$pagina = "index/resposta_erro.tpl";
			$mensagem = "Usuario não encontrado";
		}
		
		
		
		$this->montaTela($pagina, 
					array("_usuario"=>$usuario,
							"mensagem"=>$mensagem,
							"descricao"=>$mensagem,
							"scripts"=>$scripts),
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