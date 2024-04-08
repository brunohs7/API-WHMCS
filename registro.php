<?php

/*Conexão com o banco para descobrir o ID do domínio*/
 /* *** WHMCS XML API Sample Code *** */
 
 function whmcsapi_xml_parser($rawxml) {
	$xml_parser = xml_parser_create();
	xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
	xml_parser_free($xml_parser);
	$params = array();
	$level = array();
	$alreadyused = array();
	$x=0;
	foreach ($vals as $xml_elem) {
	  if ($xml_elem['type'] == 'open') {
		 if (in_array($xml_elem['tag'],$alreadyused)) {
			$x++;
			$xml_elem['tag'] = $xml_elem['tag'].$x;
		 }
		 $level[$xml_elem['level']] = $xml_elem['tag'];
		 $alreadyused[] = $xml_elem['tag'];
	  }
	  if ($xml_elem['type'] == 'complete') {
	   $start_level = 1;
	   $php_stmt = '$params';
	   while($start_level < $xml_elem['level']) {
		 $php_stmt .= '[$level['.$start_level.']]';
		 $start_level++;
	   }
	   $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
	   @eval($php_stmt);
	  }
	}
	return($params);
 }

// Configure com seu login/senha
$login = '*********';
$senha = '*********';
$str_conexao = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';

if (!extension_loaded('imap')) {
    die('Modulo PHP/IMAP nao foi carregado');
}

// Abrindo conexao
$mailbox = imap_open($str_conexao, $login, $senha);
if (!$mailbox) {
    die('Erro ao conectar: '.imap_last_error());
}

$check = imap_check($mailbox);


    // Numero de mensagens total
    echo "<b>Total de Mensagens na Caixa de Entrada:</b> ".$check->Nmsgs."<br><br><br>";
   //ultima mensagem recebida
   $msg = $check->Nmsgs;
   $i=0;

  
while ( $i <= $msg ) {
	
	$emailw = 0;
	$desprezado = 0;
	$idnaoencontrado = 0;
	$header = imap_header($mailbox, $i);
	
	if($header->Unseen == 'U') {
		
		$remetente = $header->fromaddress;
				
		if(strpos($remetente, "@registro.br") !== false){
		
			$assunto = $header->Subject;	
			
			if(strpos($assunto, "Extensao de prazo de pagamento") !== false || strpos($assunto, "Lembrete de renovacao") !== false || strpos($assunto, "Dominio congelado por falta de pagamento") !== false || strpos($assunto, "Periodo de renovacao selecionado") !== false || strpos($assunto, "Dominio removido") !== false || strpos($assunto, "Aviso de remocao do dominio") !== false || strpos($assunto, "Aviso de congelamento do dominio") !== false || strpos($assunto, "Aviso de renovacao") !== false || strpos($assunto, "Confirmacao de pagamento") !== false || strpos($assunto, "Alteracao no periodo de renovacao do dominio") !== false){
				$estrutura = imap_fetchstructure($mailbox, $i);
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$partes = explode(" - ", $assunto);
				$dominio = $partes[1];
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";
				
			}else if (strpos($assunto, "Registro.br - Solicitacao de extensao de pagamento") !== false){
				$estrutura = imap_fetchstructure($mailbox, $i);
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$partes = explode(" - ", $assunto);
				$dominio = $partes[2];
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";
				
			}else if (strpos($assunto, "Fatura de registro") !== false && strpos($assunto, "Aviso de Quitacao") == false){
				$estrutura = imap_fetchstructure($mailbox, $i);	
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$partes = explode(" - ", $assunto);
				$partes2 = explode(" - ", $partes);
				$dominio = $partes[1];				
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}		
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";
			
			}else if (strpos($assunto, "Instrucoes de pagamento") !== false) {
				$estrutura = imap_fetchstructure($mailbox, $i);	
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$partes = explode(" - ", $assunto);
				$dominio = $partes[0];				
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}		
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";	
			}else if (strpos($assunto, "Aviso de descongelamento") !== false) {
				$estrutura = imap_fetchstructure($mailbox, $i);	
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$partes = explode(" [", $assunto);
				$partes2 = explode("]", $partes[1]);
				$dominio = $partes2[0];	
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}		
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";
			}else if (strpos($assunto, "Fatura de registro - Aviso de Quitacao") !== false || strpos($assunto, "Registro de dominio") !== false) {
				$estrutura = imap_fetchstructure($mailbox, $i);	
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				$dominio = "Não se aplica";
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}		
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> ".$dominio."<br>";
				$desprezado = 1;
			}else{
				$estrutura = imap_fetchstructure($mailbox, $i);	
				$corpo = quoted_printable_decode((imap_fetchbody($mailbox, $i, 1.2)));
				if (empty($corpo)) {	
					$corpo = imap_fetchbody($mailbox, $i, 1);
					if ($estrutura->encoding == 1){		
						$corpo2 = utf8_encode($corpo);
						$corpo3 = nl2br($corpo2);
					}else{
						$corpo3 = nl2br($corpo);
					}
				}
				echo "<b>Assunto:</b> ".$assunto."<br>";
				echo "<b>Domínio:</b> Não se aplica <br>";
				$destino = "atendimento@teste.com.br";
				$dominio = "teste.com.br";
				$emailw = 1;
			}
			
			$url = "*********"; # URL to WHMCS API file goes here
			$username = "******"; # Admin username goes here
			$password = "******"; # Admin password goes here
			
			if ($desprezado == 0){
				$postfields = array();
				$postfields["username"] = $username;
				$postfields["password"] = md5($password);
				$postfields["action"] = "GetClientsProducts";
				$postfields["domain"] = $dominio;
				$postfields["responsetype"] = "xml";
				
				$query_string = "";
				 foreach ($postfields AS $k=>$v) $query_string .= "$k=".urlencode($v)."&";
				 
				 $ch = curl_init();
				 curl_setopt($ch, CURLOPT_URL, $url);
				 curl_setopt($ch, CURLOPT_POST, 1);
				 curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				 curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
				 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				 $xml = curl_exec($ch);
				 if (curl_error($ch) || !$xml) $xml = '<whmcsapi><result>error</result>'.
				 '<message>Connection Error</message><curlerror>'.
				 curl_errno($ch).' - '.curl_error($ch).'</curlerror></whmcsapi>';
				 curl_close($ch);
				 $arr = whmcsapi_xml_parser($xml); # Parse XML
				 
				 $idcliente = $arr['WHMCSAPI']['PRODUCTS']['PRODUCT']['ID'];
			}else{
				$idcliente == null;
			}
				
			if ($emailw == 0){
				if ($desprezado == 0){
					if ($idcliente == null){
						echo "<b>ID do assinante não encontrado</b><br>";
						$idnaoencontrado = 1;
						$idcliente = "1841";
					}else{
						echo "<b>ID do assinante: </b>".$idcliente."<br>";
					}
				}
			}
			
			/*Debug Output - Uncomment if needed to troubleshoot problems
			echo "<textarea rows=50 cols=100>Request: ".print_r($postfields,true);
			echo "\nResponse: ".htmlentities($xml)."\n\nArray: ".print_r($arr,true);
			echo "</textarea>";*/
				
				
				
			// Enviar o email de acordo com o ID do assinante
			if ($desprezado == 0){
				$postfields2 = array();
				$postfields2["username"] = $username;
				$postfields2["password"] = md5($password);
				$postfields2["action"] = "sendemail";
				$postfields2["customtype"] = "product";
				$postfields2["customsubject"] = $assunto;
				$postfields2["custommessage"] = "Encaminhamos o comunicado abaixo, que recebemos do órgão registrador oficial (Registro.br).<br><b>Importante ler com atenção, para evitar congelamento e/ou perda do domínio:</b><br><br>".$corpo3;
				$postfields2["id"] = $idcliente;
				$postfields2["responsetype"] = "xml";
				 
				 $query_string2 = "";
				 foreach ($postfields2 AS $k2=>$v2) $query_string2 .= "$k2=".urlencode($v2)."&";
				 
				 $ch2 = curl_init();
				 curl_setopt($ch2, CURLOPT_URL, $url);
				 curl_setopt($ch2, CURLOPT_POST, 1);
				 curl_setopt($ch2, CURLOPT_TIMEOUT, 30);
				 curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
				 curl_setopt($ch2, CURLOPT_POSTFIELDS, $query_string2);
				 curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, 0);
				 curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, 0);
				 $xml2 = curl_exec($ch2);
				 if ($emailw == 0){
					 if ($idnaoencontrado == 0){
						if (curl_error($ch2) || !$xml2){ 
							$status = 'Erro ao enviar E-mail';
						}else{
							$status = 'Encaminhado para assinante';
						}
					 }else{
						 if (curl_error($ch2) || !$xml2){ 
							$status = 'Erro ao enviar E-mail';
						}else{
							$status = 'Encaminhado para atendimento';
						}
					 }
				 }else{
					 if (curl_error($ch2) || !$xml2){ 
						$status = 'Erro ao enviar E-mail';
					}else{
						$status = 'Encaminhado para atendimento';
					}
				 }
			}else{
				$status = "Desprezado";
			}
			 
			 
			 //Debug Output - Uncomment if needed to troubleshoot problems
			 echo "<b>Resposta:</b> ".htmlentities($xml2)."<br>";
			 			
			echo "<b>Status: </b>".$status."<br>";
				
			echo "<br><hr>";
			 

		 }
	}
	$i++;
}

?>