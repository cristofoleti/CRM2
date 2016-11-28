<?php

$idioma = parse_ini_file('pt_br.idioma',true);
$cfg 	= parse_ini_file('configuracoes.cfg',true);

// CARREGO OS DADOS DO USUARIO
$db 				=&JFactory::getDBO();
// $id_pessoa_sessao 	= (count($FORTIUS_Cadastros)>0) ? $FORTIUS_Cadastros[0]->id : 688;
// $dadosPessoais 		= $usuario->GetDadosPessoais($id_pessoa_sessao, $db, $path, $dados);

// $id_pessoa			= $dadosPessoais[0]->idPessoas;
// $nome_usuario 		= $dadosPessoais[0]->NomePrimeiro;
// $nome_usuario_U		= $dadosPessoais[0]->NomeUltimo;
// $fotoperfil			= $dadosPessoais[0]->fotoPerfil;
// 
// $txtEmail 			= $dadosPessoais[0]->email;
// $txtCidade 			= $dadosPessoais[0]->Cidade; 
// $sltUF 				= $dadosPessoais[0]->UF; 
// 
// $nome_aluno = ($nome_usuario != "")? $nome_usuario." ".$nome_usuario_U :"Bill Smith";
// $foto_aluno = ($fotoperfil!="")? $fotoperfil: "guy-6.jpg";

// $vars_dados_pessoais = array('{NOME_ALUNO}' => $nome_aluno, '{FOTOPERFIL}'	=> $foto_aluno, '{FOTO_ALUNO}' => $foto_aluno);
?>