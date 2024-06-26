<?php
  /* error_log( print_r( $response, true ) );  */
$envFile = __DIR__ . '/../.env';
$envVariables = parse_ini_file($envFile);
$key_secret = $envVariables['key_secret'];
// GUARDA O TOKEN
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['method']) && $_POST['method'] == 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $message = $_POST['message'];
    $imageTeste = $_POST['imageTeste'];
    $category = $_POST['category'];
    $obs = $_POST['obs'];

    addPost($title, $subtitle, $message, $imageTeste, $category, $obs);
  }

  if (isset($_POST['method']) && $_POST['method'] == 'DELETE') {
    $id = $_POST['id'];

    deletePost($id);
  }

  if (isset($_POST['method']) && $_POST['method'] == 'PUT') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $message = $_POST['message'];
    $imageTeste = $_POST['imageTeste'];
    $category = $_POST['category'];
    $obs = $_POST['obs'];

    editPost($id, $title, $subtitle, $message, $imageTeste, $category, $obs);
  }

  if (isset($_POST['method']) && $_POST['method'] == 'GET') {
    $categoryId = isset($_POST['categoryId']) ? $_POST['categoryId'] : 0;
    $articlesData = getArticles($categoryId);

    $blogArticles = $articlesData['blogArticles'];
    $blogCategories = $articlesData['blogCategories'];
    $showButtons = $articlesData['showButtons'];

    include 'list-articles.php';
    exit;
  }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $categoryId = isset($_GET['categoryId']) ? (int) $_GET['categoryId'] : 0;
  $articlesData = getArticles($categoryId);

  $blogArticles = $articlesData['blogArticles'];
  $blogCategories = $articlesData['blogCategories'];
  $showButtons = $articlesData['showButtons'];
}

function getArticles($categoryId)
{
  global $envVariables, $key_secret;

  /*   error_log($key_secret); */ /* ASSIM PARA VER NO PHP_ERROR_LOG */

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
     /* error_log( print_r( $blogs_data, true ) ); */
    $blogArticles = $blogs_data['blogs'];
    $blogCategories = $blogs_data['blogTypes'];

    $showButtons = (isset($_SESSION['token'])) ? true : false;


    return array(
      'blogArticles' => $blogArticles,
      'blogCategories' => $blogCategories,
      'showButtons' => $showButtons
    );
  }

  curl_close($curl_blogs);
}

function addPost($title, $subtitle, $message, $imageTeste, $category, $obs)
{
  global $envVariables, $key_secret;

  $url_add_post = $envVariables['url_api'] . 'new/blog';

  // Dados para adicionar a categoria
  $data = array(
    "id" => 0,
    "title" => $title,
    "subtitle" => $subtitle,
    "description" => $message,
    "url" => $imageTeste,
    "category" => $category,
    "obs" => $obs
  );
     /*  error_log( print_r( $data, true ) ); */

  // Cabeçalhos adicionais
  $headers = array(
    "Secret: $key_secret",
    "Content-Type: application/json",
    /*       "Client: max", */
    "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_post);

  // Configura as opções da requisição cURL para adicionar a categoria
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  // Faz a requisição cURL para adicionar a categoria
  $response = curl_exec($curl);
  /* error_log( print_r( $response, true ) );  */

  if ($response === false) {
    echo "Erro ao fazer a solicitação para adicionar categoria: " . curl_error($curl);
  } else {
    header("Location: list-articles.php");
    exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}

function deletePost($id)
{
  global $envVariables, $key_secret;

  $url_add_post = $envVariables['url_api'] . 'blog/delete';

  // Dados para adicionar a categoria
  $data = array(
    "id" => $id
  );

  // Cabeçalhos adicionais
  $headers = array(
    "Secret: $key_secret",
    "Content-Type: application/json",
    /*       "Client: max", */
    "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_post);

  // Configura as opções da requisição cURL para adicionar a categoria
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  // Faz a requisição cURL para adicionar a categoria
  $response = curl_exec($curl);

  if ($response === false) {
    echo "Erro ao fazer a solicitação para adicionar categoria: " . curl_error($curl);
  } else {
    header("Location: list-articles.php");
    exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}

function editPost($id, $title, $subtitle, $message, $imageTeste, $category, $obs)
{
  global $envVariables, $key_secret;

  $url_add_post = $envVariables['url_api'] . 'new/blog';

  // Dados para adicionar a categoria
  $data = array(
    "id" => $id,
    "title" => $title,
    "subtitle" => $subtitle,
    "description" => $message,
    "url" => $imageTeste,
    "category" => $category,
    "obs" => $obs
  );
     /*  error_log( print_r( $data, true ) ); */

  // Cabeçalhos adicionais
  $headers = array(
    "Secret: $key_secret",
    "Content-Type: application/json",
    /*       "Client: max", */
    "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_post);

  // Configura as opções da requisição cURL para adicionar a categoria
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  // Faz a requisição cURL para adicionar a categoria
  $response = curl_exec($curl);
  /* error_log( print_r( $response, true ) );  */

  if ($response === false) {
    echo "Erro ao fazer a solicitação para adicionar categoria: " . curl_error($curl);
  } else {
    header("Location: list-articles.php");
    exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}
