<?php
class cef{
	public function buscaArquivoRetorno($dados, $db){
		$retorno 	= array();
		$path 	 	= $dados['path'];
		$arquivo 	= $dados['arquivo'];
		
		$pathSistema 	= $dados['pathSistema'];
		$pathFileUpload	= $dados['pathFileUpload'];
		$pathAbsoluto	= $dados['pathAbsoluto'];

		$arquivo 	= $pathAbsoluto.$pathFileUpload.'RET_CEF/'.$arquivo;

		$arquivo = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		$retorno['arquivo_conteudo'] = $arquivo;

		return $retorno;
	}

	public function baixaDocumentos($dados, $db){
		$retorno 				= array();
		$arquivo 				= $dados['arquivo_conteudo'];

		$path 					= $dados['path'];
		$dados['pathAbsoluto'] 	= $dados['pathAbsoluto'];
		$dados['pathLogFile']	= $dados['pathLogFile'];

		$dateFile 				= date("Ymd");

		$errorLogFile 	= 'CEF_baixaDocumentos_'.$dateFile.'.log';

		$linha = array();
		for($i=0;$i<count($arquivo);$i++){
			if(substr($arquivo[$i],13,1)=="T"){
				$linha[] = $arquivo[$i];
			}
		}

		for($i=0;$i<count($linha);$i++){
			$num_doc = substr($linha[$i],62,11);
			$num_doc = trim($num_doc);

			$vars = array('{NUM_DOC}' => $num_doc);
			print $num_doc."</br>";

			$sql = file_get_contents($path.'model/BaixaTituloCEF.sql');
			$query 	= strtr($sql,$vars);

			// print "<pre>";
			// print_r($query);
			// print "</pre>";
			// exit;

			$db->setQuery($query);
			$db->Query();

			$retorno[] = array("num_doc" => $num_doc, "STATUS"=>"SUCESSO","MENSAGEM"=>null);

			if($db->getErrorNum()> 0) {
				$erro = $db->getErrorMsg();
				$mArr = $erro."\n\n\n";
				file_put_contents($dados['pathAbsoluto'].$dados['pathLogFile'].$errorLogFile,$mArr,FILE_APPEND);
				$retorno[] = array("num_doc" => $num_doc, "STATUS"=>"ERRO","MENSAGEM"=>$erro);
			}
		}
		
		return $retorno;
	}
	
	
}
?>