<?php
	$session = JFactory::getSession();	
	$FORTIUS_Cadastros = $session->get('FORTIUS_Cadastros');

	
	// print "<pre>";
	// print_r($FORTIUS_Cadastros);
	// print "</pre>";
	// exit;
	
	// id_pessoa_sessao

	$existe = $session->get('FORTIUS_Existe');	
if(count($existe)==0){header('location: /encore/c/altius/acesso/login.php');exit;}

?>