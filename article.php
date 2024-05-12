<?php
// URL da API para obter um único artigo
$api_url = 'https://wemakeit.appsfarma.com/api/verify/single/blog/';

if (isset($_GET['id'])) {
  // Obtém o ID do artigo da URL
  $id = $_GET['id'];

// Chave secreta
$key_secret = 'P3YgJ4eecO78wEGvAMGa';

// Cliente
$cliente = 'type1';

// Cabeçalhos da requisição
$headers = array(
    "Secret: $key_secret",
    "Client: $cliente",
    "Content-Type: application/json"
);

// Inicializa uma nova sessão cURL
$curl = curl_init();

// Configura as opções da requisição cURL
curl_setopt($curl, CURLOPT_URL, $api_url . $id);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Faz a requisição cURL para obter o artigo
$response = curl_exec($curl);

// Verifica se houve algum erro na requisição
if ($response === false) {
    echo "Erro ao fazer a solicitação para obter o artigo: " . curl_error($curl);
} else {
    // Processa a resposta
    $article_data = json_decode($response, true);
    
    // Imprime os dados do artigo
    var_dump($article_data);
}


} else {
  // Se o parâmetro 'id' não foi passado na URL, exiba uma mensagem de erro ou redirecione o usuário para uma página de erro
  echo "Erro: ID do artigo não encontrado na URL.";
}
// Fecha a sessão cURL
curl_close($curl);
?>