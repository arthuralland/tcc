<?php

/**
 * Acessa dados do SUAP (Sistema Unificado de Administração Pública).
 *
 * @author Ivanilson Melo <meloivanilson@gmail.com>
 */
class Suap
{
    /**
     * O token de acesso do usuário. Tokens tem 24 horas de validade.
     *
     * @var string Token de acesso.
     */
    private $token;
    /**
     * Endpoint do SUAP.
     *
     * @var string Endpoint de acesso ao suap.
     */
    private $endpoint = 'https://suap.ifrn.edu.br/api/v2/';
    /**
     * Um cliente GuzzleHttp para fazer os requests HTTP.
     *
     * @var GuzzleHttp\Client Cliente GuzzleHttp.
     */
    private $client;
    
    /**
     * Autentica o usuário e retorna um token de acesso.
     * Pode-se usar a senha ou chave de acesso do aluno.
     *
     * @param string $username  Matrícula do aluno.
     * @param string $password  Senha do aluno ou chave de acesso do responsável.
     * @param bool   $accessKey Define se o login é por chave de acesso.
     * @param bool   $setToken  Define se deve salvar o token para requests subsequentes.
     *
     * @return array $data Array contendo o token de acesso.
     */
    public function autenticar($username, $password, $accessKey = false, $setToken = true)
    {
        $url = 'https://suap.ifrn.edu.br/api/v2/autenticacao/token/';
        $data = array('username' => $username, 'password' => $password);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(   
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",             
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context), true);
                
        $this->setToken($result["token"]);            
        
        return $this->token;
    }
    /**
     * Seta o token para acesso a API.
     *
     * @param string $token Token de acesso.
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
    /**
     * Pega os dados pessoais do aluno autenticado.
     *
     * @return array $data Dados pessoais do aluno.
     */
    public function getMeusDados()
    {
        $url = $this->endpoint.'minhas-informacoes/meus-dados/';
        return $this->doGetRequest($url);
    }
 
    /**
     * Faz um request GET para um endpoint definido.
     *
     * @param string $url Url para fazer o request.
     *
     * @return array $data Dados retornados pela API.
     */
    private function doGetRequest($url)
    {        
        
        $options = array(
            'http' => array(   
                'header'  => "Authorization: JWT ".$this->token, 
                'method'  => 'GET'                
            )
        );

        $context  = stream_context_create($options);
        
        return file_get_contents($url, false, $context);
    }
}