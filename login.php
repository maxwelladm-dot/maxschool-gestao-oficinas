<?php
session_start();

// Defina aqui o usuário e a senha padrão para os monitores
$usuario_correto = "admin";
$senha_correta = "max123"; 

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['usuario'] == $usuario_correto && $_POST['senha'] == $senha_correta) {
        $_SESSION['logado'] = true;
        header("Location: admin.php"); // Vai para o Painel Central
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #2c3e50; display: flex; align-items: center; height: 100vh; }
        .card-login { border-radius: 15px; width: 100%; max-width: 400px; margin: auto; }
    </style>
</head>
<body>
    <div class="card card-login shadow-lg p-4 bg-white">
        <h3 class="text-center fw-bold">Gestão MaxSchool</h3>
        <p class="text-center text-muted small">Área de Monitores e Professores</p>
        
        <?php if($erro): ?>
            <div class="alert alert-danger small text-center"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Usuário:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha:</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">ENTRAR</button>
        </form>
    </div>
</body>
</html>