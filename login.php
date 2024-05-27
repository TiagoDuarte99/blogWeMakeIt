<?php
$envFile = __DIR__ . '/.env';
$envVariables = parse_ini_file($envFile);

$url_login = $envVariables['url_api'] . 'authenticate';

$email = $envVariables['email'];
$password = $envVariables['password'];

// Dados de autenticação
$data_login = array(
    "email" => $email,
    "password" => $password,
    "device" => "3",
    "tokenFirebase" => "x"
);

// Inicializa uma nova sessão cURL para a solicitação de login
$curl_login = curl_init($url_login);

// Configura as opções da requisição cURL para a solicitação de login
curl_setopt($curl_login, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_login, CURLOPT_POST, true);
curl_setopt($curl_login, CURLOPT_POSTFIELDS, json_encode($data_login));
curl_setopt($curl_login, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

// Faz a requisição cURL para login
$response_login = curl_exec($curl_login);

// Verifica se houve algum erro na requisição de login
if ($response_login === false) {
    $error_message = "Erro ao fazer a solicitação de login: " . curl_error($curl_login);
} else {
    // Processa a resposta do login
    $login_button = '<a href="./list-articles/list-articles.php"><button>voltar</button></a>';
    if (!empty($response_login) && strpos($response_login, "token") !== false) {
        // Extrai o token da resposta
        $token = json_decode($response_login, true)['token'];

        // Gera o script JavaScript para armazenar o token em localStorage
        $script = "<script>";
        $script .= "var token = '" . $token . "';";
        $script .= "localStorage.setItem('token', token);";
        $script .= "console.log('Token armazenado no localStorage:', token);";
        $script .= "</script>";

        // Imprime o script na página
        $login_button .= $script;
    }

    if (!empty($response_login) && strpos($response_login, "token") !== false) {
        // Extrai o token da resposta
        $token = json_decode($response_login, true)['token'];

        // Armazena o token na sessão do servidor
        session_start(); // Inicia a sessão se ainda não estiver iniciada
        $_SESSION['token'] = $token;
        if(isset($_SESSION['token'])) {
          var_dump($_SESSION['token']);
      } else {
          echo "A variável 'token' na sessão está vazia ou não está definida.";
      }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Seus estilos CSS e outros elementos head -->
</head>
<body>
    <h1>Resposta do Login</h1>
    <?php if (isset($error_message)) : ?>
        <p><?php echo $error_message; ?></p>
    <?php else : ?>
        <p>Você fez login com sucesso!</p>
        <?php echo $login_button; ?>
    <?php endif; ?>
</body>
</html>