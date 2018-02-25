<?php
header('Access-Control-Allow-Origin: *'); 
include "db.php";
include "web/SUAP.php";


$matricula = $_POST['matricula'];
$senha = $_POST['senha'];
$contatos = $_POST['contatos'];
$messeg = "";

if(empty($matricula) || empty($senha)) {
    $messeg = "vazio";
    echo "$messeg";
} else {
    $sql = "SELECT * FROM usuario WHERE matricula=? AND 
    senha=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($matricula,$senha));

    if($query->rowCount() >= 1) {

        $row = $query->fetch(PDO::FETCH_ASSOC);
        $messeg = array(
            'nome'=> $row['nome'],
            'foto'=>$row['foto'],
            'email'=>$row['email'],
            'curso'=>$row['curso']
        );
        
        
        echo json_encode($messeg);

    } else {        
        try {
            $client = new Suap();
            $token = $client->autenticar($matricula, $senha, true);         

            $dados = json_decode($client->getMeusDados(),true);




            //insere usuario
            $url = 'http://snapdark.com/servidorTCC/insert.php';
            $data = array('nome' => $dados['nome_usual'], 'matricula' => $dados['matricula'],'administrador' => 'false', 'senha' => $senha, 'email' => $dados['email'],'curso' => $dados['vinculo']['curso'],'foto'=> "https://suap.ifrn.edu.br".$dados['url_foto_75x100'] ,'contatos'=>$contatos, 'insert' => "");

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(   
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",             
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);            
            $messeg = array(
                'nome'=> $dados['nome_usual'],
                'foto'=> "https://suap.ifrn.edu.br".$dados['url_foto_75x100'],
                'email'=>$dados['email'],
                'curso'=>$dados['vinculo']['curso']);
        } catch (Exception $e) {            
            $messeg = "erro";
        }
        echo json_encode($messeg);
    }
}

?>