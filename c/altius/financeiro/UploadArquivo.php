<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');
set_time_limit(0);

include('../../exec_in_joomla.inc');
// include('../seguranca.php');
// include('../classes/usuario.class.php') ;
// $usuario = new usuario();

$path 	 = '../';
include('../configuracoes.php');
// include('../classes/apoio.class.php');

include('../classes/cef.class.php');

$time_start = microtime(true);

$cef = new cef();

$nomeProjeto = $cfg['nomeProjeto'];
$googleCode	 = $cfg['googleCode'];
$pathSky 	 = $cfg['pathSky'];
$pathSistema = $cfg['pathSistema'];
$pathFileUpload = $cfg['pathFileUpload'];
$pathAbsoluto = $cfg['pathAbsoluto'];
$pathArqRet = "../ARQUIVOS/RET_CEF/";

$dados = array('path'=>$path, 'pathSistema' => $pathSistema, 'pathFileUpload' => $pathFileUpload, 'pathAbsoluto' => $pathAbsoluto);

$vars = array('{PATHSKY}'=>$pathSky, '{PATHSISTEMA}' => $pathSistema);
$template = null;
$html_menu_esquerda = file_get_contents('../../../v/MENU.Esquerda.html');
$html_menu_esquerda = strtr($html_menu_esquerda, $vars);

if(isset($_REQUEST['btAtualizarPgtosCEF'])) {	
    if(array_key_exists('ufileCOCEF', $_FILES)) { 
	
        if(move_uploaded_file($_FILES['ufileCOCEF']['tmp_name'], $pathArqRet. $_FILES['ufileCOCEF']['name'])) {
                $success = true ;
                $path = $pathArqRet.$_FILES['ufileCOCEF']['name'];
				
				 //GET FILE NAME 
				 $theFileName = $_FILES['ufileCOCEF']['name']; 

				 //GET FILE SIZE 
				 $theFileSize = $_FILES['ufileCOCEF']['size']; 

				 if ($theFileSize>999999){ //IF GREATER THAN 999KB, DISPLAY AS MB 
					 $theDiv = $theFileSize / 1000000; 
					 $theFileSize = round($theDiv, 1)." MB"; //round($WhatToRound, $DecimalPlaces) 
				 } else { //OTHERWISE DISPLAY AS KB 
					 $theDiv = $theFileSize / 1000; 
					 $theFileSize = round($theDiv, 1)." KB"; //round($WhatToRound, $DecimalPlaces) 
				 }
            } else {
                $success = false ;
            }
    }
	
	//$arquivo_ret = "RETORNOCEF090316.ret";
	$arquivo_ret = $theFileName;
	
	$dados["arquivo"] = $arquivo_ret;

	$ret_cef = $cef->buscaArquivoRetorno($dados, $db);

	$arquivo_conteudo = $ret_cef['arquivo_conteudo'];
	$dados["arquivo_conteudo"] = $arquivo_conteudo;

	$titulos = array();
	for($i=0;$i<count($arquivo_conteudo);$i++){
		if(substr($arquivo_conteudo[$i],13,1)=="T"){
			if(trim(substr($arquivo_conteudo[$i],58,11))!="")
				{$titulos[] = ltrim(substr($arquivo_conteudo[$i],58,11), '0');}
		}
	}
	
	$urlPesquisaTituloOriginal = "http://core360.com.br/shop/skin/frontend/base/default/lib/core360_sdk/infoPgtoPedido.php?x1={NUMDOC}&x2=3CLX";
	$urlBaixaPgtoOriginal = "http://core360.com.br/shop/skin/frontend/base/default/lib/core360_sdk/PagarPedido.php?x1={ORDERID}&x2=3CLX&x4={RET}";
	
	$template = file_get_contents('../../../v/UploadArquivo_Obrigado.html');
	$tr_obrigado_tpl = file_get_contents('../../../v/UploadArquivo_Obrigado_TR.html');
	$tr_obrigado 	 = "";
	
	for($i=0;$i<count($titulos);$i++){
		$vars = array('{NUMDOC}' => $titulos[$i]);
		$urlPesquisaTitulo = strtr($urlPesquisaTituloOriginal,$vars);
		$resultado = file_get_contents($urlPesquisaTitulo);
		
		$resultado = json_decode($resultado);
		
		$vars = array('{ORDERID}' => $resultado[0]->order_id, '{RET}' => $arquivo_ret);
		$urlBaixaPgto = strtr($urlBaixaPgtoOriginal,$vars);
		$resultadoPgto = file_get_contents($urlBaixaPgto);
		
		
		$vars = array('{NUMDOC}' => $resultado[0]->order_id, '{VALOR}' => "@MOEDA_PAIS ".number_format($resultado[0]->base_grand_total,2) , '{NOSSONUM}' => $resultado[0]->nosso_numero);
		$tr_obrigado .= strtr($tr_obrigado_tpl,$vars);
		
		// print_r($urlPesquisaTitulo);
		// print "</br>";
		// print_r($urlBaixaPgto);	
		// print_r($resultado);	
		// print_r($resultadoPgto);	
		// print "</br>";
	}
	// print_r($titulos);
	$vars = array('{PATHSKY}'=>$pathSky, '{PATHSISTEMA}' => $pathSistema, '{LINHAS_RET}'=>$tr_obrigado, '{RET}' => $arquivo_ret, '{MENU_ESQUERDA}'=>$html_menu_esquerda);

	// $modalAguarde = file_get_contents('../../../v/moda_aguarde.html');
	// $modalAguarde = strtr($modalAguarde, $vars);
	// $modalAguarde = strtr($modalAguarde, $idioma);
	// $vars['{MODAL_AGUARDE}']= $modalAguarde;

	$template = strtr($template,$vars);
	// $template = strtr($template,$vars_dados_pessoais);
	$template = strtr($template,$idioma);
	// 
	print $template;
	exit;
}

// $cef->baixaDocumentos($dados, $db);

// $id_pessoa_sessao 	= $dadosPessoais[0]->idPessoas;
$template = file_get_contents('../../../v/UploadArquivo.html');
$vars = array('{PATHSKY}'=>$pathSky, '{PATHSISTEMA}' => $pathSistema, '{MENU_ESQUERDA}'=>$html_menu_esquerda);

// $modalAguarde = file_get_contents('../../../v/moda_aguarde.html');
// $modalAguarde = strtr($modalAguarde, $vars);
// $modalAguarde = strtr($modalAguarde, $idioma);
// $vars['{MODAL_AGUARDE}']= $modalAguarde;

$template = strtr($template,$vars);
// $template = strtr($template,$vars_dados_pessoais);
$template = strtr($template,$idioma);
// 
print $template;
?>