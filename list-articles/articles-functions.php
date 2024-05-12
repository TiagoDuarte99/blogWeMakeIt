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

  $blogArticles = $blogs_data['blogs'];
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

curl_close($curl_blogs);
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    isset($_POST['title'])
    && isset($_POST['subtitle'])
    && isset($_POST['message'])
    && isset($_POST['imageTeste'])
    && isset($_POST['category'])
  ) {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $message = $_POST['message'];
    $imageTeste = $_POST['imageTeste'];
    $category = $_POST['category'];

    addPost($title, $subtitle, $message, $imageTeste, $category);
  }

  if (isset($_POST['id'])) {
    $id = $_POST['id'];

    deletePost($id);
  }
}

function addPost($title, $subtitle, $message, $imageTeste, $category)
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
    "category" => $category
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
    // Log da resposta
    echo "<script>console.log('Resposta da API:', " . json_encode($response) . ");</script>";
    // Atualiza a lista de categorias após inserção bem-sucedida
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
    // Log da resposta
    echo "<script>console.log('Resposta da API:', " . json_encode($response) . ");</script>";
    // Atualiza a lista de categorias após inserção bem-sucedida
    header("Location: list-articles.php");
    exit;
  }

  // Fecha a sessão cURL
  curl_close($curl);
}
