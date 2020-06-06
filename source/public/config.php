<?php
/**
 * Identifica o sistema operacional do servidor, considerando que pode
 * ser Windows ou Linux.
 */
$operatingSystem =  stripos($_SERVER['SERVER_SOFTWARE'],'win32')!== FALSE ? 'WINDOWS' : 'LINUX';

// define separador de paths para include path 
$pathSeparator = $operatingSystem == 'WINDOWS' ? ';' : ':' ;
define("SISPATH", "/var/www/html/");
#define("SISPATH", "E:/@Diogo/Projetos/socialzend.com/public_html/novo/public_html/");
define("SISNOME", basename(getcwd()));
$applicationName = SISNOME;
$documentRoot = SISPATH;

// Definindo paths da aplicacao
$path 	= 	'.'.$pathSeparator.SISPATH.'library';
$path 	.= 	$pathSeparator.SISPATH.'library/LogicBSB';
$path 	.= 	$pathSeparator.SISPATH.'application/models';
$path	.=	$pathSeparator.SISPATH.'application/autenticacao';
$path	.=	$pathSeparator.SISPATH.'application/controllers';
$path	.=	$pathSeparator.SISPATH.'application/views/scripts';
set_include_path($path.$pathSeparator.get_include_path());

/** Configura o timezone e formato da moeda */
setlocale(LC_MONETARY,'ptb');
date_default_timezone_set("America/Sao_Paulo");
