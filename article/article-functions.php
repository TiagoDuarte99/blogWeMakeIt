<?php
$envFile = __DIR__ . '/../.env';
$envVariables = parse_ini_file($envFile);
$key_secret = $envVariables['key_secret'];

$url_article = $envVariables['url_api'] . 'verify/single/blog/';

if (isset($_GET['id'])) {
  // Obtém o ID do artigo da URL
  $id = $_GET['id'];

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
curl_setopt($curl, CURLOPT_URL, $url_article . $id);
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
    $article = $article_data['blog'];

    $categories = getCategories();

    // Criar um array associativo para mapear os nomes das categorias aos seus IDs
    $categories_map = [];
    foreach ($categories as $category) {
        $categories_map[$category['id']] = $category['name'];
    }

    // Substituir o ID da categoria pelo nome da categoria no array $blog
    if (isset($categories_map[$article['category']])) {
      
      $article['category_name'] = $categories_map[$article['category']];
    } else {
        $article['category_name'] = 'Categoria desconhecida'; // Caso o ID não corresponda a nenhuma categoria
    }

    $blogs = getArticles(0);

/*      error_log( print_r( $blogs, true ) );
     error_log( print_r( $article, true ) ); */

    return array(
      'article' => $article,
      'blogs' => $blogs
    );
}


} else {

  echo "Erro: ID do artigo não encontrado na URL.";
}
// Fecha a sessão cURL
curl_close($curl);



function getCategories() {
  global $envVariables, $key_secret;
    // URL para obter as categorias
    $url_categories = $envVariables['url_api'] . 'verify/blog/add/type';

    $data = array(
      "list" => true
    );
  

    $headers = array(
      "Secret: $key_secret",
      "Content-Type: application/json"
  );

    // Inicializa o cURL
    $curl = curl_init($url_categories);


    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // Executa a requisição
    $response = curl_exec($curl);

    // Verifica se houve algum erro na requisição
    if ($response === false) {
        echo "Erro ao fazer a solicitação para obter as categorias: " . curl_error($curl);
        return [];
    } else {
        // Decodifica a resposta JSON
        $categories_data = json_decode($response, true);
    
       /*  error_log( print_r( $categories_data, true ) ); */
       return $categories_data['blogTypes'];
    }

    // Fecha a sessão cURL
    curl_close($curl);
}


function getArticles($categoryId)
{
  global $envVariables, $key_secret;

  $url_blogs = $envVariables['url_api'] . 'verify/blogs';
  $data_blogs = array(
    "next" => 0,
    "category" => $categoryId
  );

  $headers = array(
    "Secret: $key_secret",
    "Content-Type: application/json",
    "Client: max",
    "Token: "
  );


  // Inicializa uma nova sessão cURL
  $curl_blogs = curl_init($url_blogs);

  // Configura as opções da requisição cURL para a solicitação de verificação de blogs
  curl_setopt($curl_blogs, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl_blogs, CURLOPT_POST, true);
  curl_setopt($curl_blogs, CURLOPT_POSTFIELDS, json_encode($data_blogs));
  curl_setopt($curl_blogs, CURLOPT_HTTPHEADER, $headers);

  // Faz a requisição cURL para verificar blogs
  $response_blogs = curl_exec($curl_blogs);
  /* echo "resposta: $response_blogs"; */
  if ($response_blogs === false) {
    echo "Erro ao fazer a solicitação para verificar blogs: " . curl_error($curl_blogs);
  } else {
    $blogs_data = json_decode($response_blogs, true);
    
    $blogArticles = $blogs_data['blogs'];

    return  $blogArticles;
  }

  curl_close($curl_blogs);
}
?>