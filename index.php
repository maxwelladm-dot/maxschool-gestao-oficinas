<?php 
session_start();
// Proteção: Só acessa se estiver logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
include 'includes/db.php'; 
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST['nome'];
    $ano   = $_POST['ano'];
    $turma = $_POST['turma'];
    $turno = $_POST['turno'];

    $sql = $conn->prepare("INSERT INTO alunos (nome, ano, turma, turno) VALUES (?, ?, ?, ?)");
    $sql->bind_param("siss", $nome, $ano, $turma, $turno);
    
    if ($sql->execute()) {
        $mensagem = "<div class='alert alert-success shadow-sm'>✅ Aluno <strong>$nome</strong> cadastrado com sucesso!</div>";
    } else {
        $mensagem = "<div class='alert alert-danger shadow-sm'>❌ Erro ao cadastrar aluno.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Aluno - MaxSchool</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .card-cadastro { border-radius: 15px; border: none; }
        .header-azul { background: #0d6efd; color: white; border-radius: 15px 15px 0 0; padding: 20px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-cadastro shadow">
                <div class="header-azul text-center">
                    <h3 class="mb-0"><i class="bi bi-person-plus"></i> Cadastro de Aluno</h3>
                    <small>Escola Arnaldo Antônio - Dom Eliseu</small>
                </div>
                <div class="card-body p-4">
                    
                    <?php echo $mensagem; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nome Completo:</label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: Alex Willian" required autofocus>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ano/Série:</label>
                                <select name="ano" class="form-select" required>
                                    <option value="1">1º Ano</option>
                                    <option value="2">2º Ano</option>
                                    <option value="3">3º Ano</option>
                                    <option value="4">4º Ano</option>
                                    <option value="5">5º Ano</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Turma:</label>
                                <select name="turma" class="form-select" required>
                                    <option value="A">Turma A</option>
                                    <option value="B">Turma B</option>
                                    <option value="C">Turma C</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Turno:</label>
                            <select name="turno" class="form-select" required>
                                <option value="Matutino">Manhã (Matutino)</option>
                                <option value="Vespertino" selected>Tarde (Vespertino)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold p-2">
                                <i class="bi bi-check-circle"></i> CADASTRAR ALUNO
                            </button>
                            
                            <a href="admin.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Voltar ao Painel Central
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 text-muted small">MaxSchool v2.0 - 2026</p>
        </div>
    </div>
</div>

</body>
</html>