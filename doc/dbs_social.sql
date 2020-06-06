SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `dbs_social` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dbs_social`;

CREATE TABLE `tba_noticia_tag` (
  `int_idfnoticia` int(11) NOT NULL,
  `int_idftag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_acesso` (
  `int_idaacesso` int(11) NOT NULL,
  `int_idfusuario` int(11) NOT NULL,
  `dte_data` datetime NOT NULL,
  `vhr_ip` varchar(15) NOT NULL,
  `vhr_url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_amigo` (
  `int_idfusuario1` int(11) NOT NULL,
  `int_idfusuario2` int(11) NOT NULL,
  `dte_criacao` datetime NOT NULL,
  `bln_aceito` tinyint(4) DEFAULT '0',
  `dte_aceito` datetime DEFAULT NULL,
  `txt_solicitacao` text,
  `int_idaamigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_anuncio` (
  `idtbl_anuncio` int(11) NOT NULL,
  `vhr_titulo` varchar(45) DEFAULT NULL,
  `vhr_link` varchar(45) DEFAULT NULL,
  `dte_cadastro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_comentario` (
  `int_idacomentario` int(11) NOT NULL,
  `int_idfusuario` int(11) NOT NULL,
  `int_idfnoticia` int(11) NOT NULL,
  `txt_conteudo` text NOT NULL,
  `bln_aprovado` tinyint(4) DEFAULT '0',
  `dte_criacao` datetime NOT NULL,
  `dte_aprovado` datetime DEFAULT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_fotoperfil` (
  `int_idafotoperfil` int(11) NOT NULL,
  `int_idfusuario` int(11) NOT NULL,
  `dte_upload` datetime NOT NULL,
  `bln_ativa` tinyint(4) NOT NULL DEFAULT '1',
  `vhr_nomearquivo` varchar(100) NOT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL,
  `int_idfnoticia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_noticia` (
  `int_idanoticia` int(11) NOT NULL,
  `vhr_titulo` varchar(255) NOT NULL,
  `txt_conteudo` text NOT NULL,
  `int_idfusuario` int(11) NOT NULL,
  `dte_criacao` datetime NOT NULL,
  `bln_ativo` tinyint(4) NOT NULL,
  `vhr_foto` varchar(255) DEFAULT NULL,
  `vhr_video` varchar(255) DEFAULT NULL,
  `txt_resumo` text,
  `vhr_subtitulo` varchar(255) DEFAULT NULL,
  `int_cliques` int(11) NOT NULL DEFAULT '0',
  `vhr_fonte` varchar(150) DEFAULT NULL,
  `vhr_link` varchar(150) DEFAULT NULL,
  `vhr_tags` varchar(200) DEFAULT NULL,
  `bln_admin` tinyint(4) DEFAULT NULL,
  `bln_publica` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_noticia` (`int_idanoticia`, `vhr_titulo`, `txt_conteudo`, `int_idfusuario`, `dte_criacao`, `bln_ativo`, `vhr_foto`, `vhr_video`, `txt_resumo`, `vhr_subtitulo`, `int_cliques`, `vhr_fonte`, `vhr_link`, `vhr_tags`, `bln_admin`, `bln_publica`) VALUES
(1, 'Noticia teste', 'bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla', 1, '0000-00-00 00:00:00', 1, NULL, NULL, 'resumo da noticia teste', 'subtitulo teste', 1, '', NULL, NULL, NULL, NULL);

CREATE TABLE `tbl_recado` (
  `int_idarecado` int(11) NOT NULL,
  `int_idfusuarioorigem` int(11) NOT NULL,
  `int_idfusuariodestino` int(11) NOT NULL,
  `txt_conteudo` text NOT NULL,
  `dte_criacao` datetime NOT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL,
  `vhr_titulo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_tag` (
  `int_idatags` int(11) NOT NULL,
  `vhr_tag` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tbl_usuario` (
  `int_idausuario` int(11) NOT NULL,
  `int_idfperfil` int(11) NOT NULL,
  `int_idfcidade` int(11) DEFAULT NULL,
  `int_idfestadocivil` int(11) DEFAULT NULL,
  `vhr_nome` varchar(100) NOT NULL,
  `vhr_login` varchar(45) NOT NULL,
  `vhr_senha` varchar(45) NOT NULL,
  `dte_cadastro` datetime NOT NULL,
  `bln_ativo` tinyint(4) NOT NULL DEFAULT '0',
  `dte_ativacao` datetime DEFAULT NULL,
  `dte_desativacao` datetime DEFAULT NULL,
  `vhr_chavevalidacao` varchar(20) DEFAULT NULL,
  `vhr_sexo` varchar(1) DEFAULT NULL,
  `dte_nascimento` date DEFAULT NULL,
  `vhr_profissao` varchar(100) DEFAULT NULL,
  `txt_quemsoueu` text,
  `bln_perfilpublico` tinyint(4) DEFAULT NULL,
  `vhr_motivodesativacao` varchar(250) DEFAULT NULL,
  `vhr_css` varchar(100) DEFAULT NULL,
  `vhr_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_usuario` (`int_idausuario`, `int_idfperfil`, `int_idfcidade`, `int_idfestadocivil`, `vhr_nome`, `vhr_login`, `vhr_senha`, `dte_cadastro`, `bln_ativo`, `dte_ativacao`, `dte_desativacao`, `vhr_chavevalidacao`, `vhr_sexo`, `dte_nascimento`, `vhr_profissao`, `txt_quemsoueu`, `bln_perfilpublico`, `vhr_motivodesativacao`, `vhr_css`, `vhr_email`) VALUES
(1, 2, 8, 2, 'LogicBSB', 'admin', 'admin', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', NULL, NULL, 'M', '1983-04-05', 'Desenvolvimento / Manutenção de websites e sistemas', '', NULL, NULL, 'public/css/5.css', NULL),
(2, 1, 1, 1, 'Usuario', 'usuario', 'usuario', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 2, 8, 2, 'Diogo Santana Corazolla', 'diogocorazolla@gmail.com', '123456', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', NULL, 'X9459CLG75', 'M', '1983-04-05', 'Programador', 'Alguém que gosta de poesias binárias.', 1, NULL, 'css/5.css', NULL);

CREATE TABLE `tbr_cidade` (
  `int_idacidade` int(11) NOT NULL,
  `int_idfuf` int(11) NOT NULL,
  `vhr_nome` varchar(100) NOT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbr_cidade` (`int_idacidade`, `int_idfuf`, `vhr_nome`, `bln_ativo`) VALUES
(1, 1, 'Não informado', 1),
(2, 2, 'Rio Branco', 1),
(3, 3, 'Maceió', 1),
(4, 4, 'Macapá', 1),
(5, 5, 'Manaus', 1),
(6, 6, 'Salvador', 1),
(7, 7, 'Fortaleza', 1),
(8, 8, 'Brasília', 1),
(9, 9, 'Vitória', 1),
(10, 10, 'Goiânia', 1),
(11, 11, 'São Luís', 1),
(12, 12, 'Cuiabá', 1),
(13, 13, 'Campo Grande', 1),
(14, 14, 'Belo Horizonte', 1),
(15, 15, 'Belém', 1),
(16, 16, 'João Pessoa', 1),
(17, 17, 'Curitiba', 1),
(18, 18, 'Recife', 1),
(19, 19, 'Teresina', 1),
(20, 20, 'Rio de Janeiro', 1),
(21, 21, 'Natal', 1),
(22, 22, 'Porto Alegre', 1),
(23, 23, 'Porto Velho', 1),
(24, 24, 'Boa Vista', 1),
(25, 25, 'Florianópolis', 1),
(26, 26, 'São Paulo', 1),
(27, 27, 'Aracaju', 1),
(28, 28, 'Palmas', 1);

CREATE TABLE `tbr_estadocivil` (
  `int_idaestadocivil` int(11) NOT NULL,
  `vhr_nome` varchar(45) DEFAULT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbr_estadocivil` (`int_idaestadocivil`, `vhr_nome`, `bln_ativo`) VALUES
(1, 'Não informado', 1),
(2, 'Casado', 1),
(3, 'Namorando', 1),
(4, 'Enrolado', 1),
(5, 'Solteiro', 1),
(6, 'Viúvo', 1),
(7, 'Disponível', 1),
(8, 'Não estou disponível', 1);

CREATE TABLE `tbr_perfil` (
  `int_idaperfil` int(11) NOT NULL,
  `vhr_nome` varchar(20) NOT NULL,
  `vhr_pai` varchar(20) NOT NULL,
  `bln_ativo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbr_perfil` (`int_idaperfil`, `vhr_nome`, `vhr_pai`, `bln_ativo`) VALUES
(1, 'usuario', 'guest', 1),
(2, 'admin', 'usuario', 1);

CREATE TABLE `tbr_uf` (
  `int_idauf` int(11) NOT NULL,
  `vhr_nome` varchar(50) NOT NULL,
  `vhr_sigla` varchar(2) NOT NULL,
  `bln_ativo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbr_uf` (`int_idauf`, `vhr_nome`, `vhr_sigla`, `bln_ativo`) VALUES
(1, 'Não informado', 'NN', 1),
(2, 'Acre', 'AC', 1),
(3, 'Alagoas', 'AL', 1),
(4, 'Amapá', 'AP', 1),
(5, 'Amazonas', 'AM', 1),
(6, 'Bahia', 'BA', 1),
(7, 'Ceará', 'CE', 1),
(8, 'Distrito Federal', 'DF', 1),
(9, 'Espírito Santo', 'ES', 1),
(10, 'Goiás', 'GO', 1),
(11, 'Maranhão', 'MA', 1),
(12, 'Mato Grosso', 'MT', 1),
(13, 'Mato Grosso do Sul', 'MS', 1),
(14, 'Minas Gerais', 'MG', 1),
(15, 'Pará', 'PA', 1),
(16, 'Paraíba', 'PB', 1),
(17, 'Paraná', 'PR', 1),
(18, 'Pernambuco', 'PE', 1),
(19, 'Piauí', 'PI', 1),
(20, 'Rio de Janeiro', 'RJ', 1),
(21, 'Rio Grande do Norte', 'RN', 1),
(22, 'Rio Grande do SuL', 'RS', 1),
(23, 'Rondônia', 'RO', 1),
(24, 'Roraima', 'RR', 1),
(25, 'Santa Catarina', 'SC', 1),
(26, 'São Paulo', 'SP', 1),
(27, 'Sergipe', 'SE', 1),
(28, 'Tocantins', 'TO', 1);


ALTER TABLE `tba_noticia_tag`
  ADD PRIMARY KEY (`int_idfnoticia`,`int_idftag`),
  ADD KEY `fk_tag_noticia` (`int_idftag`);

ALTER TABLE `tbl_acesso`
  ADD PRIMARY KEY (`int_idaacesso`),
  ADD KEY `fk_acesso_usuario` (`int_idfusuario`);

ALTER TABLE `tbl_amigo`
  ADD PRIMARY KEY (`int_idaamigo`),
  ADD KEY `fk_amigo_usuario2` (`int_idfusuario2`),
  ADD KEY `int_idfusuario1` (`int_idfusuario1`,`int_idfusuario2`) USING BTREE;

ALTER TABLE `tbl_anuncio`
  ADD PRIMARY KEY (`idtbl_anuncio`);

ALTER TABLE `tbl_comentario`
  ADD PRIMARY KEY (`int_idacomentario`),
  ADD KEY `fk_comentario_noticia` (`int_idfnoticia`),
  ADD KEY `fk_comentario_usuario` (`int_idfusuario`);

ALTER TABLE `tbl_fotoperfil`
  ADD PRIMARY KEY (`int_idafotoperfil`),
  ADD KEY `fk_fotoperfil_usuario` (`int_idfusuario`);

ALTER TABLE `tbl_noticia`
  ADD PRIMARY KEY (`int_idanoticia`),
  ADD KEY `fk_noticia_fusuario` (`int_idfusuario`);

ALTER TABLE `tbl_recado`
  ADD PRIMARY KEY (`int_idarecado`),
  ADD KEY `fk_recado_origem` (`int_idfusuarioorigem`),
  ADD KEY `fk_recado_destino` (`int_idfusuariodestino`);

ALTER TABLE `tbl_tag`
  ADD PRIMARY KEY (`int_idatags`);

ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`int_idausuario`),
  ADD KEY `fk_usuario_perfil` (`int_idfperfil`),
  ADD KEY `fk_usuario_cidade` (`int_idfcidade`),
  ADD KEY `fk_usuario_estadocivil` (`int_idfestadocivil`);

ALTER TABLE `tbr_cidade`
  ADD PRIMARY KEY (`int_idacidade`),
  ADD KEY `fk_cidade_uf` (`int_idfuf`);

ALTER TABLE `tbr_estadocivil`
  ADD PRIMARY KEY (`int_idaestadocivil`);

ALTER TABLE `tbr_perfil`
  ADD PRIMARY KEY (`int_idaperfil`);

ALTER TABLE `tbr_uf`
  ADD PRIMARY KEY (`int_idauf`);


ALTER TABLE `tbl_acesso`
  MODIFY `int_idaacesso` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_amigo`
  MODIFY `int_idaamigo` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_comentario`
  MODIFY `int_idacomentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tbl_fotoperfil`
  MODIFY `int_idafotoperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

ALTER TABLE `tbl_noticia`
  MODIFY `int_idanoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tbl_recado`
  MODIFY `int_idarecado` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_tag`
  MODIFY `int_idatags` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tbl_usuario`
  MODIFY `int_idausuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `tbr_cidade`
  MODIFY `int_idacidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

ALTER TABLE `tbr_estadocivil`
  MODIFY `int_idaestadocivil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `tbr_perfil`
  MODIFY `int_idaperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tbr_uf`
  MODIFY `int_idauf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;


ALTER TABLE `tba_noticia_tag`
  ADD CONSTRAINT `fk_noticia_tag` FOREIGN KEY (`int_idfnoticia`) REFERENCES `tbl_noticia` (`int_idanoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tag_noticia` FOREIGN KEY (`int_idftag`) REFERENCES `tbl_tag` (`int_idatags`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_acesso`
  ADD CONSTRAINT `fk_acesso_usuario` FOREIGN KEY (`int_idfusuario`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_amigo`
  ADD CONSTRAINT `fk_amigo_usuario1` FOREIGN KEY (`int_idfusuario1`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_amigo_usuario2` FOREIGN KEY (`int_idfusuario2`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_comentario`
  ADD CONSTRAINT `fk_comentario_noticia` FOREIGN KEY (`int_idfnoticia`) REFERENCES `tbl_noticia` (`int_idanoticia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`int_idfusuario`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_fotoperfil`
  ADD CONSTRAINT `fk_fotoperfil_usuario` FOREIGN KEY (`int_idfusuario`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_noticia`
  ADD CONSTRAINT `fk_noticia_fusuario` FOREIGN KEY (`int_idfusuario`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_recado`
  ADD CONSTRAINT `fk_recado_destino` FOREIGN KEY (`int_idfusuariodestino`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recado_origem` FOREIGN KEY (`int_idfusuarioorigem`) REFERENCES `tbl_usuario` (`int_idausuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbl_usuario`
  ADD CONSTRAINT `fk_usuario_cidade` FOREIGN KEY (`int_idfcidade`) REFERENCES `tbr_cidade` (`int_idacidade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_estadocivil` FOREIGN KEY (`int_idfestadocivil`) REFERENCES `tbr_estadocivil` (`int_idaestadocivil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`int_idfperfil`) REFERENCES `tbr_perfil` (`int_idaperfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `tbr_cidade`
  ADD CONSTRAINT `fk_cidade_uf` FOREIGN KEY (`int_idfuf`) REFERENCES `tbr_uf` (`int_idauf`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
