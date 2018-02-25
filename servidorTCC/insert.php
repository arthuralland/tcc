<?php
header('Access-Control-Allow-Origin: *'); 
 include "db.php";
 if(isset($_POST['insert'])){
 	$nome=$_POST['nome'];
 	$matricula=$_POST['matricula'];
 	$administrador=$_POST['administrador'];
 	$curso=$_POST['curso'];
	$email=$_POST['email'];
 	$senha=$_POST['senha'];
 	$foto=$_POST['foto'];
 	 	
	$consulta = $pdo->query("SELECT matricula FROM usuario where matricula= '$matricula';");		 		
	if ($consulta->fetch()[0] == null) {
		$stmt = $pdo->prepare("INSERT INTO usuario(nome,matricula,administrador,curso,email,senha,foto)
		 		VALUES (:nome,:matricula,:administrador,:curso,:email,:senha,:foto)");
		$stmt->execute(array(		    				
	    	':nome' => $nome,
	   	 	':matricula' => $matricula,
	   	 	':administrador' => $administrador,
			':curso' => $curso,
			':email' => $email,
			':senha'=> $senha,
			':foto' =>$foto
		));	   



		$contatosTxt= $_POST['contatos'];
		if ($contatosTxt != null) {
			$contatosTxt = substr($contatosTxt,0,strlen($contatosTxt)-1);

			$contatos = explode(";",$contatosTxt);
			for ($i=0; $i < count($contatos); $i++) { 
				$partes = explode(",",$contatos[$i]);

				$nome_contato = $partes[0];			
				$numero_contato = $partes[1];
				
				$stmt = $pdo->prepare("INSERT INTO contatos_do_usuario(matricula,nome_contatos,numero_contatos)
			 		VALUES (:matricula,:nome_contatos,:numero_contatos)");

				$stmt->execute(array(		    				
			    	':matricula' => $matricula,
			   	 	':nome_contatos' => $nome_contato,
					':numero_contatos' => $numero_contato				
				));	   
			}
		}		
		
		echo "Cadastrado com sucesso!";
		//$ok = array('success' => true, 'matricula' => $pdo->lastInsertId());            	  		   
	}else{
		//$ok = array('success' => false, "error" => 0);		
		echo "Esse Email Já Existe";
	}				  			  			
}
?>