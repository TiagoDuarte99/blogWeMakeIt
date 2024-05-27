<?php
session_start();

// Destruir a sessão
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Seus estilos CSS e outros elementos head -->
</head>
<body>
    <h1>Logout</h1>
    <p>Você saiu da sua conta com sucesso.</p>
    <a href="./list-articles/list-articles.php"><button>Voltar</button></a>

    <script>
        // Limpa o token do localStorage
        localStorage.removeItem('token');
    </script>
</body>
</html>