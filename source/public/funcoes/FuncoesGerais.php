<?php

	/*FUNÇÃO ÚTIL PARA DEBUG*/
	function xd($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				var_dump($obj);
			echo "</pre>";
		echo "</div>";
		die();
	}
	
	/*FUNÇÃO ÚTIL PARA DEBUG SEM  DIE*/
	function x($obj)
	{
		echo "<div style='background-color:#DFDFDF; border:1px #666666 solid'>";
			echo "<pre>";
				var_dump($obj);
			echo "</pre>";
		echo "</div>";
	}
	
	function identificaPasta($cod_blob){
		$ret = false;
		$tamanho = strlen($cod_blob);
		if ($cod_blob+0) {
			if ($tamanho<=3){
				$ret="0000";
			} else {
				$ret = (int)($cod_blob/1000);
			}
			for ($i=strlen($ret); $i<4; $i++) $ret="0".$ret;
		}
		return $ret;
	}
	
	function  geraSenha($tamanho=6) {
	    $length = $tamanho;
	    $characters = "0123456789ABCDEFGHJKLMNPQRSTUVXZ";
	    $string ="";    
	
	    for ($p = 0; $p < $length; $p++) {
	        $string .= $characters[mt_rand(0, strlen($characters)-1)];
	    }
	
	    return $string;
	}
	
	function cortaTexto($txt, $tam){
		$vtxt = explode(" ", $txt);
		$tam_temp = 0;
		$txt_temp = "";
		for ($cont=0; $cont<sizeof($vtxt); $cont++){
			$tam_temp += strlen($vtxt[$cont]);
			if ($tam_temp < $tam)
			{
				$txt_temp .= " ".$vtxt[$cont];
			}
			else
			{
				$txt_temp .= "...";
				break;
			}
		}
		return $txt_temp;
	}
	
	function enviaEmail($assunto, $corpo, $dstNome, $dstEmail)
	{
		$_site = Zend_Registry::get("site");
		
		$config = array('auth' => 'login',
                'username' => $_site["smtp_user"],
                'password' => $_site["smtp_pass"]);

		$tr = new Zend_Mail_Transport_Smtp($_site["smtp"], $config);
		Zend_Mail::setDefaultTransport($tr);
		
		$mail = new Zend_Mail();
		$mail->setBodyHtml(utf8_decode($corpo));
		$mail->setFrom($_site["smtp_remetente"], 'MirtesNET');
		$mail->addTo($dstEmail, $dstNome);
		$mail->addBcc("diogocorazolla@gmail.com");
		$mail->setSubject(utf8_decode($assunto));
		$mail->send();
	}
?>