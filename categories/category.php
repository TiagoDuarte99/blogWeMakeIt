<?php

$envFile = __DIR__ . '/../.env';
$envVariables = parse_ini_file($envFile);

$url_blogs = $envVariables['url_api'] . 'verify/blogs';

// Acessar a variável de ambiente KEY_SECRET
$key_secret = $envVariables['key_secret'];

// Dados para verificar blogs
$data_blogs = array(
  "next" => 0,
  "category" => 0
);

// Cabeçalhos adicionais
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

if ($response_blogs === false) {
  echo "Erro ao fazer a solicitação para verificar blogs: " . curl_error($curl_blogs);
} else {
  $blogs_data = json_decode($response_blogs, true);

  $blogCategories = $blogs_data['blogTypes'];

  // GUARDA O TOKEN
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if (isset($_SESSION['token'])) {
    $showButtons = true;
  } else {
    $showButtons = false;
  }

}
// Fecha a sessão cURL
curl_close($curl_blogs);

?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['method']) && $_POST['method'] == 'POST') {
    $nome = $_POST['categoryName'];
    $obs = $_POST['categoryObs'];
    addCategory($nome, $obs);
  }

  if (isset($_POST['method']) && $_POST['method'] == 'DELETE') {
    $id = $_POST['id'];
    $delete = $_POST['delete'];
    deleteCategory($id, $delete);
  }

  if (isset($_POST['method']) && $_POST['method'] == 'PUT'){
    $id = $_POST['categoryIdEdit'];
    $name = $_POST['catagoryNameEdit'];
    $obs = $_POST['categoryObsEdit'];
    editCategory($id, $name, $obs);
  }
}

function addCategory($name, $obs) {
  global $envVariables, $key_secret;

  $url_add_category = $envVariables['url_api'] . 'verify/blog/add/type';

  // Dados para adicionar a categoria
  $data = array(
      "name" => $name,
      "obs" => $obs
  );

  // Cabeçalhos adicionais
  $headers = array(
      "Secret: $key_secret",
      "Content-Type: application/json",
      "Client: max",
      "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_category);

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
      // Log da resposta
      echo "<script>console.log('Resposta da API:', " . json_encode($response) . ");</script>";
      // Atualiza a lista de categorias após inserção bem-sucedida
      header("Location: navbar-categories.php");
      exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}


function deleteCategory($id, $delete) {
  global $envVariables, $key_secret;

  $url_add_category = $envVariables['url_api'] . 'verify/blog/add/type';

  // Dados para adicionar a categoria
  $data = array(
      "id" => $id,
      "delete" => $delete
  );

  // Cabeçalhos adicionais
  $headers = array(
      "Secret: $key_secret",
      "Content-Type: application/json",
      "Client: max",
      "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_category);

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
      // Log da resposta
      echo "<script>console.log('Resposta da API:', " . json_encode($response) . ");</script>";
      // Atualiza a lista de categorias após inserção bem-sucedida
      header("Location: navbar-categories.php");
      exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}


function editCategory($id, $name, $obs) {
  global $envVariables, $key_secret;

  $url_add_category = $envVariables['url_api'] . 'verify/blog/add/type';

  // Dados para adicionar a categoria
  $data = array(
      "id" => $id,
      "name" => $name,
      "obs" => $obs,
  );

  // Cabeçalhos adicionais
  $headers = array(
      "Secret: $key_secret",
      "Content-Type: application/json",
      "Client: max",
      "Token: " . $_SESSION['token']
  );

  // Inicializa uma nova sessão cURL
  $curl = curl_init($url_add_category);

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
      // Log da resposta
      echo "<script>console.log('Resposta da API:', " . json_encode($response) . ");</script>";
      // Atualiza a lista de categorias após inserção bem-sucedida
      header("Location: navbar-categories.php");
      exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}

?>


