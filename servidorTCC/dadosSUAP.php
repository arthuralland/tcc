<?php
namespace Ivmelo\SUAP;
use GuzzleHttp\Client;
/**
 * Acessa dados do SUAP (Sistema Unificado de Administração Pública).
 *
 * @author Ivanilson Melo <meloivanilson@gmail.com>
 */
class SUAP
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
     * Construtor. Pode ser vazio ou receber um token de acesso.
     *
     * @param string $token Token de acesso.
     */
    public function __construct($token = false)
    {
        if ($token) {
            $this->setToken($token);
        }
        // Create and use a guzzle client instance that will time out after 10 seconds
        $this->client = new Client([
            'timeout'         => 10,
            'connect_timeout' => 10,
        ]);
    }
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
        // Se estiver acessando com uma chave de acesso...
        if ($accessKey) {
            $url = $this->endpoint.'autenticacao/acesso_responsaveis/';
            $params = [
                'matricula' => $username,
                'chave'     => $password,
            ];
        } else {
            $url = $this->endpoint.'autenticacao/token/';
            $params = [
                'username' => $username,
                'password' => $password,
            ];
        }
        $response = $this->client->request('POST', $url, [
            'form_params' => $params,
        ]);
        $data = false;
        if ($response->getStatusCode() == 200) {
            // Decodifica a resposta JSON para um array.
            $data = json_decode($response->getBody(), true);
            // Seta o token se solicitado. Padrão é true.
            if ($setToken && isset($data['token'])) {
                $this->setToken($data['token']);
            }
        }
        return $data;
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
}